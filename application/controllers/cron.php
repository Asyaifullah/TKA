<?php
// =============================================
// File: application/controllers/Cron.php
// Hanya bisa dijalankan via CLI
// =============================================
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Pastikan akses hanya melalui CLI
        if (!is_cli()) {
            show_404();
        }
        $this->load->model('approval_log_model');
        $this->load->model('tka_model');
        $this->load->helper('my_helper');
    }

    /**
     * Endpoint utama yang dipanggil oleh cron: php index.php cron run
     */
    public function run() {
        echo "[CRON] Mulai SLA checker " . date('Y-m-d H:i:s') . "\n";
        
        // 1. Kirim reminder
        $this->kirim_reminder();
        
        // 2. Tandai overdue
        $this->tandai_overdue();
        
        // 3. Eskalasi
        $this->eskalasi();
        
        echo "[CRON] Selesai.\n";
    }

    /**
     * Proses 1: Kirim notifikasi reminder ke approver yang mendekati deadline
     */
    private function kirim_reminder() {
        $logs = $this->approval_log_model->get_approaching_deadline();
        
        foreach ($logs as $log) {
            $sla = $this->approval_log_model->get_sla_by_level($log->level);
            if (!$sla || !$sla->reminder_jam) continue;
            
            // Hitung sisa jam
            $deadline = new DateTime($log->sla_deadline);
            $now = new DateTime();
            $diff_hours = ($deadline->getTimestamp() - $now->getTimestamp()) / 3600;
            
            // Kirim jika sisa waktu <= reminder_jam dan belum di-warned
            if ($diff_hours <= $sla->reminder_jam && empty($log->warned_at)) {
                // Ambil data user approver (dari approval log level, cari user dengan role terkait)
                $approver = $this->get_approver_by_level($log->tka_id, $log->level);
                if ($approver) {
                    $message = "Pengingat: Pengajuan TKA #{$log->tka_id} menunggu persetujuan Anda. "
                             . "Batas waktu: " . sisa_waktu_label($log->sla_deadline);
                    $this->send_notification($approver->id, $message, 'reminder');
                }
                
                // Tandai sudah di-warned
                $this->approval_log_model->set_warned($log->id);
                echo "[REMINDER] Level {$log->level} TKA#{$log->tka_id} - sisa " . round($diff_hours,1) . " jam\n";
            }
        }
    }

    /**
     * Proses 2: Tandai overdue dan notifikasi ke approver & user
     */
    private function tandai_overdue() {
        $logs = $this->approval_log_model->get_new_overdue();
        
        foreach ($logs as $log) {
            // Tandai overdue
            $this->approval_log_model->set_overdue($log->id);
            $this->tka_model->set_overdue_flag($log->tka_id, 1);
            
            // Notifikasi ke approver
            $approver = $this->get_approver_by_level($log->tka_id, $log->level);
            if ($approver) {
                $msg = "Peringatan: Pengajuan TKA #{$log->tka_id} telah melewati batas waktu persetujuan!";
                $this->send_notification($approver->id, $msg, 'overdue');
            }
            
            // Notifikasi ke user pemohon
            $tka = $this->tka_model->get_detail_tka($log->tka_id);
            if ($tka && $tka->user_id) {
                $nama_level = APPROVAL_LEVELS[$log->level] ?? '';
                $msg_user = "Pengajuan TKA Anda (#{$log->tka_id}) mengalami keterlambatan pada tahap "
                          . label_status_tka($nama_level) . ". Kami sedang menindaklanjuti.";
                $this->send_notification($tka->user_id, $msg_user, 'overdue');
            }
            
            echo "[OVERDUE] Level {$log->level} TKA#{$log->tka_id} - deadline " . $log->sla_deadline . "\n";
        }
    }

    /**
     * Proses 3: Eskalasi ke level di atasnya
     */
    private function eskalasi() {
        $logs = $this->approval_log_model->get_not_escalated_overdue();
        
        foreach ($logs as $log) {
            $level_asal = $log->level;
            $level_atas = $level_asal + 1;
            
            // Cari user role di atas
            $penerima = null;
            if ($level_atas <= 4) {
                $role_atas = ROLE_BY_LEVEL[$level_atas];
                $penerima = $this->db->where('role', $role_atas)->get('users')->row();
            } else {
                // Kadis overdue -> admin
                $penerima = $this->db->where('role', 'admin')->get('users')->row();
            }
            
            if ($penerima) {
                $tka = $this->tka_model->get_detail_tka($log->tka_id);
                $level_nama = isset(APPROVAL_LEVELS[$level_asal]) ? label_status_tka(APPROVAL_LEVELS[$level_asal]) : '';
                $msg = "Eskalasi: Pengajuan TKA #{$log->tka_id} pada tahap {$level_nama} telah melewati batas waktu. "
                     . "Mohon segera ditindaklanjuti.";
                $this->send_notification($penerima->id, $msg, 'eskalasi');
                
                // Catat eskalasi
                $this->db->insert('escalation_log', [
                    'tka_id' => $log->tka_id,
                    'dari_user_id' => null,
                    'ke_user_id' => $penerima->id,
                    'level_asal' => $level_asal,
                    'jenis' => 'eskalasi',
                    'catatan' => 'Sistem otomatis',
                    'created_at' => date('Y-m-d H:i:s')
                ]);
                
                echo "[ESKALASI] Level {$level_asal} TKA#{$log->tka_id} ke {$penerima->role}\n";
            }
            
            // Tandai sudah dieskalasi
            $this->approval_log_model->set_escalated($log->id);
        }
    }

    /**
     * Mendapatkan user approver yang sedang bertugas pada level tertentu untuk TKA tertentu
     * Placeholder: Anda harus menyesuaikan dengan logika assignment approval Anda
     */
    private function get_approver_by_level($tka_id, $level) {
        // Asumsi: user dengan role sesuai level (misal kasi, kabid)
        $role = ROLE_BY_LEVEL[$level] ?? null;
        if (!$role) return null;
        return $this->db->where('role', $role)->get('users')->row();
    }

    /**
     * Kirim notifikasi in-app (sesuaikan dengan sistem notifikasi Anda)
     */
    private function send_notification($user_id, $message, $type = 'info') {
        $this->db->insert('notifications', [
            'user_id' => $user_id,
            'message' => $message,
            'type'    => $type,
            'is_read' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}