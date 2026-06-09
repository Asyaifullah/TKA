<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Approval extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if(!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        $this->load->model([
            'Tka_model',
            'Berkas_model',
            'Approval_log_model',
            'User_model',
            'Admin_log_model',
            'Notification_model'
        ]);
        $this->role = $this->session->userdata('role');
        $allowed = ['kasi', 'kabid', 'sekdis', 'kadis'];
        if(!in_array($this->role, $allowed)) {
            show_error('Akses ditolak. Anda tidak memiliki hak untuk halaman ini.');
        }
    }

    private function get_role_display() {
        $role_names = [
            'kasi'   => 'Kepala Seksi',
            'kabid'  => 'Kepala Bidang',
            'sekdis' => 'Sekretaris Dinas',
            'kadis'  => 'Kepala Dinas'
        ];
        return $role_names[$this->role] ?? ucfirst($this->role);
    }

    private function kirim_notifikasi($user_id, $pesan, $tipe = 'info') {
        $data = [
            'user_id'    => $user_id,
            'message'    => $pesan,
            'type'       => $tipe,
            'is_read'    => 0,
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('notifications', $data);
    }

    /* ==================== HALAMAN UTAMA ==================== */

    public function index() {
        $status = '';
        $level  = 0;
        switch($this->role) {
            case 'kasi':   $status = 'MENUNGGU_KASI';   $level = 1; break;
            case 'kabid':  $status = 'MENUNGGU_KABID';  $level = 2; break;
            case 'sekdis': $status = 'MENUNGGU_SEKDIS'; $level = 3; break;
            case 'kadis':  $status = 'MENUNGGU_KADIS';  $level = 4; break;
        }

        // Ambil TKA + perusahaan
        $this->db->select('tka.*, users.perusahaan');
        $this->db->from('tka');
        $this->db->join('users', 'users.id = tka.user_id');
        $this->db->where('tka.status', $status);
        $this->db->order_by('tka.created_at', 'DESC');
        $list = $this->db->get()->result();

        // Ambil SLA untuk setiap TKA
        foreach ($list as $t) {
            // Cari log approval yang sesuai level dan statusnya
            $log = $this->db->where('tka_id', $t->id)
                            ->where('level', $level)
                            ->where('status', $status)
                            ->order_by('created_at', 'DESC')
                            ->get('approval_log')
                            ->row();

            if (!$log) {
                // FALLBACK: buat log otomatis jika belum ada
                $sla = $this->Approval_log_model->get_sla_by_level($level);
                $deadline = null;
                if ($sla && $sla->sla_jam > 0) {
                    $deadline = date('Y-m-d H:i:s', strtotime($t->created_at . " + {$sla->sla_jam} hours"));
                }
                $this->db->insert('approval_log', [
                    'tka_id'       => $t->id,
                    'level'        => $level,
                    'status'       => $status,
                    'sla_deadline' => $deadline,
                    'catatan'      => 'Auto-created by fallback',
                    'created_at'   => $t->created_at
                ]);
                $t->sla_deadline = $deadline;
                $t->warned_at    = null;
            } else {
                $t->sla_deadline = $log->sla_deadline ?? null;
                $t->warned_at    = $log->warned_at ?? null;
            }
        }

        $data['list'] = $list;
        $data['role'] = $this->role;
        $data['role_display'] = $this->get_role_display();
        $this->load->view('approval/list', $data);
    }
    
    public function detail($id) {
        $tka = $this->Tka_model->get_by_id($id);
        if(!$tka) show_404();
        $allowed_status = [
            'kasi'   => 'MENUNGGU_KASI',
            'kabid'  => 'MENUNGGU_KABID',
            'sekdis' => 'MENUNGGU_SEKDIS',
            'kadis'  => 'MENUNGGU_KADIS'
        ];
        if($tka->status != $allowed_status[$this->role]) {
            show_error('Status tidak sesuai untuk role ini.');
        }
        $data['tka'] = $tka;
        $data['berkas'] = $this->Berkas_model->get_by_tka($id);
        $data['logs'] = $this->Approval_log_model->get_by_tka($id);
        $data['role'] = $this->role;
        $data['role_display'] = $this->get_role_display();
        $this->load->view('approval/detail', $data);
    }

    /* ==================== PROSES APPROVAL / REJECT ==================== */

    public function process($id) {
        $action  = $this->input->post('action');
        $catatan = $this->input->post('catatan');

        if(!in_array($action, ['approve', 'reject'])) {
            show_error('Aksi tidak valid.');
        }

        $tka = $this->Tka_model->get_by_id($id);
        if(!$tka) show_404();

        $status_map = [
            'kasi'   => 'MENUNGGU_KASI',
            'kabid'  => 'MENUNGGU_KABID',
            'sekdis' => 'MENUNGGU_SEKDIS',
            'kadis'  => 'MENUNGGU_KADIS'
        ];

        if($tka->status != $status_map[$this->role]) {
            $this->session->set_flashdata('error', 'Status TKA sudah berubah, tidak dapat diproses.');
            redirect('approval/index');
        }

        if($action == 'approve') {
            $role_to_level = ['kasi' => 1, 'kabid' => 2, 'sekdis' => 3, 'kadis' => 4];
            $current_level = $role_to_level[$this->role] ?? 1;

            switch($this->role) {
                case 'kasi':   $next_status = 'MENUNGGU_KABID'; break;
                case 'kabid':  $next_status = 'MENUNGGU_SEKDIS'; break;
                case 'sekdis': $next_status = 'MENUNGGU_KADIS'; break;
                case 'kadis':  $next_status = 'SELESAI'; break;
                default:       $next_status = 'MENUNGGU_KASI'; break;
            }

            $update = $this->Tka_model->update_status($id, $next_status);
            if(!$update) {
                $this->session->set_flashdata('error', 'Gagal mengupdate status TKA (approve). Silakan coba lagi.');
                redirect('approval/detail/'.$id);
            }

            if($next_status == 'SELESAI') {
                $this->Tka_model->reset_estimasi($id);
            }

            // Catat log approval untuk level saat ini (approve)
            $log_data = [
                'tka_id'  => $id,
                'role'    => $this->role,
                'status'  => 'approve',
                'catatan' => $catatan ?: null
            ];
            $insert_log = $this->Approval_log_model->insert($log_data);
            if(!$insert_log) {
                log_message('error', 'Gagal insert approval_log untuk TKA ID: '.$id);
                $this->session->set_flashdata('warning', 'Status berhasil diubah, tetapi gagal mencatat log approval.');
            }

            // Buat log untuk level selanjutnya (jika belum selesai)
            if($next_status != 'SELESAI') {
                $next_level = $current_level + 1;
                $this->Approval_log_model->insert_with_sla(
                    $id,
                    $next_level,
                    $next_status,
                    null,
                    "Diteruskan dari " . $this->get_role_display()
                );
            }

            $pesan_user = "Pengajuan TKA Anda (ID: {$id}) telah disetujui oleh {$this->get_role_display()} dan "
                        . ($next_status == 'SELESAI' ? "telah selesai. Surat izin dapat diunduh setelah Nomor Surat Telah Ditentukan" : "diteruskan ke tahap berikutnya.");
            $this->kirim_notifikasi($tka->user_id, $pesan_user, 'approval');

            if($next_status != 'SELESAI') {
                $next_role = array_search($next_status, $status_map);
                $users_next = $this->db->where('role', $next_role)->get('users')->result();
                foreach($users_next as $u) {
                    $this->kirim_notifikasi($u->id, "Pengajuan TKA baru (ID: {$id}) menunggu persetujuan Anda.", 'info');
                }
            }

            $msg = 'Berhasil approve pengajuan TKA.';

        } else { // REJECT
            if(trim($catatan) == '') {
                $this->session->set_flashdata('error', 'Catatan penolakan wajib diisi.');
                redirect('approval/detail/'.$id);
            }

            $update = $this->Tka_model->update_status($id, 'DITOLAK');
            if(!$update) {
                $this->session->set_flashdata('error', 'Gagal mengupdate status TKA (reject). Silakan coba lagi.');
                redirect('approval/detail/'.$id);
            }

            $this->Tka_model->reset_estimasi($id);

            $log_data = [
                'tka_id'  => $id,
                'role'    => $this->role,
                'status'  => 'reject',
                'catatan' => $catatan
            ];
            $insert_log = $this->Approval_log_model->insert($log_data);
            if(!$insert_log) {
                log_message('error', 'Gagal insert approval_log untuk TKA ID: '.$id);
                $this->session->set_flashdata('warning', 'Pemberkasan ditolak, tetapi gagal mencatat log approval.');
            }

            $pesan_user = "Pengajuan TKA Anda (ID: {$id}) telah ditolak oleh {$this->get_role_display()}.\n"
                        . "Alasan: " . $catatan . "\n"
                        . "Silakan perbaiki dan kirim ulang pengajuan revisi.";
            $this->kirim_notifikasi($tka->user_id, $pesan_user, 'reject');

            $msg = 'Pengajuan TKA ditolak.';
        }

        // Catat ke admin_log
        $admin_log = [
            'admin_id'    => $this->session->userdata('user_id'),
            'admin_name'  => $this->session->userdata('nama'),
            'action'      => strtoupper($action),
            'target_type' => 'tka',
            'target_id'   => $id,
            'description' => ucfirst($action) . ' pengajuan TKA ' . $tka->nama_tka . ' oleh ' . $this->role,
            'ip_address'  => $this->input->ip_address()
        ];
        $this->Admin_log_model->add_log($admin_log);

        $this->session->set_flashdata('success', $msg);
        redirect('approval/index');
    }

    /* ==================== LOG & DASHBOARD ==================== */

    public function logs() {
        $data['logs'] = $this->Admin_log_model->get_all_logs();
        $data['role'] = $this->role;
        $data['role_display'] = $this->get_role_display();
        $this->load->view('approval/logs', $data);
    }

    public function dashboard() {
        $status_map = [
            'kasi'   => 'MENUNGGU_KASI',
            'kabid'  => 'MENUNGGU_KABID',
            'sekdis' => 'MENUNGGU_SEKDIS',
            'kadis'  => 'MENUNGGU_KADIS'
        ];
        $my_status = $status_map[$this->role];

        $total_pending  = $this->db->where('status', $my_status)->count_all_results('tka');
        $total_approved = $this->db->where('role', $this->role)->where('status', 'approve')->count_all_results('approval_log');
        $total_rejected = $this->db->where('role', $this->role)->where('status', 'reject')->count_all_results('approval_log');

        $monthly_all = array_fill(1, 12, 0);
        $all_tka = $this->db->select('created_at')->get('tka')->result();
        foreach ($all_tka as $t) {
            $bulan = date('n', strtotime($t->created_at));
            $monthly_all[$bulan]++;
        }
        $chart_labels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $chart_data = array_values($monthly_all);

        $pie_data = [$total_approved, $total_rejected];

        $this->db->select('tka.*, users.perusahaan');
        $this->db->from('tka');
        $this->db->join('users', 'users.id = tka.user_id');
        $this->db->where('tka.status', $my_status);
        $this->db->order_by('tka.created_at', 'DESC');
        $this->db->limit(5);
        $recent_pending = $this->db->get()->result();

        $data = [
            'total_pending'   => $total_pending,
            'total_approved'  => $total_approved,
            'total_rejected'  => $total_rejected,
            'chart_labels'    => json_encode($chart_labels),
            'chart_data'      => json_encode($chart_data),
            'pie_data'        => json_encode($pie_data),
            'recent_pending'  => $recent_pending,
            'role'            => $this->role,
            'role_display'    => $this->get_role_display()
        ];
        $this->load->view('approval/dashboard', $data);
    }

    public function dashboard_data() {
        $status_map = [
            'kasi'   => 'MENUNGGU_KASI',
            'kabid'  => 'MENUNGGU_KABID',
            'sekdis' => 'MENUNGGU_SEKDIS',
            'kadis'  => 'MENUNGGU_KADIS'
        ];
        $my_status = $status_map[$this->role];

        $total_pending  = $this->db->where('status', $my_status)->count_all_results('tka');
        $total_approved = $this->db->where('role', $this->role)->where('status', 'approve')->count_all_results('approval_log');
        $total_rejected = $this->db->where('role', $this->role)->where('status', 'reject')->count_all_results('approval_log');

        $monthly_all = array_fill(1, 12, 0);
        $all_tka = $this->db->select('created_at')->get('tka')->result();
        foreach ($all_tka as $t) {
            $bulan = date('n', strtotime($t->created_at));
            $monthly_all[$bulan]++;
        }
        $chart_data = array_values($monthly_all);

        echo json_encode([
            'total_pending'  => $total_pending,
            'total_approved' => $total_approved,
            'total_rejected' => $total_rejected,
            'chart_data'     => $chart_data
        ]);
    }



public function get_notifications() {
    $user_id = $this->session->userdata('user_id');
    $unread_count = $this->Notification_model->get_unread_count($user_id);
    $notifications = $this->Notification_model->get_recent($user_id, 10);
    echo json_encode(['unread_count' => $unread_count, 'notifications' => $notifications]);
}

public function mark_notification_read($id) {
    $user_id = $this->session->userdata('user_id');
    $notif = $this->db->where('id', $id)->where('user_id', $user_id)->get('notifications')->row();
    $this->Notification_model->mark_as_read($id, $user_id);
    $referer = $this->input->server('HTTP_REFERER');
    if ($referer && strpos($referer, 'approval/notifications') !== false) {
        redirect('approval/notifications');
    } elseif ($notif && $notif->link) {
        redirect($notif->link);
    } else {
        redirect('approval/index');
    }
}

public function notifications() {
    $user_id = $this->session->userdata('user_id');
    $data['notifications'] = $this->Notification_model->get_recent($user_id, 100);
    $data['unread_count'] = $this->Notification_model->get_unread_count($user_id);
    $data['role'] = $this->role;
    $data['role_display'] = $this->get_role_display();
    $this->load->view('approval/notifications', $data);
}

public function mark_all_read() {
    $user_id = $this->session->userdata('user_id');
    $this->Notification_model->mark_all_read($user_id);
    $this->session->set_flashdata('success', 'Semua notifikasi telah ditandai sudah dibaca.');
    redirect('approval/notifications');
}
}