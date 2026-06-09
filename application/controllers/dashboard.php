<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        $this->load->model('Tka_model');
        $this->load->model('User_model');
        $this->load->model('Approval_log_model');
    }

    public function index() {
        $role = $this->session->userdata('role');

        if ($role == 'user') {
            $data['tka'] = $this->Tka_model->get_by_user($this->session->userdata('user_id'));
            $this->load->view('user/dashboard', $data);
        }
        elseif ($role == 'admin') {
            // ========== DATA ADMIN (tetap sama seperti sebelumnya) ==========
            $this->db->select('tka.*, users.perusahaan');
            $this->db->from('tka');
            $this->db->join('users', 'users.id = tka.user_id');
            $this->db->order_by('tka.created_at', 'DESC');
            $all_tka = $this->db->get()->result();

            $total_perusahaan = $this->db->where('role', 'user')->count_all_results('users');
            $total_tka = count($all_tka);
            $proses = 0;
            $selesai = 0;
            $ditolak = 0;
            foreach ($all_tka as $t) {
                if (in_array($t->status, ['MENUNGGU_KASI','MENUNGGU_KABID','MENUNGGU_SEKDIS','MENUNGGU_KADIS'])) $proses++;
                elseif ($t->status == 'SELESAI') $selesai++;
                elseif ($t->status == 'DITOLAK') $ditolak++;
            }

            $monthly = array_fill(1, 12, 0);
            foreach ($all_tka as $t) {
                $bulan = date('n', strtotime($t->created_at));
                $monthly[$bulan]++;
            }
            $chart_labels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
            $chart_data = array_values($monthly);
            $status_data = [$proses, $selesai, $ditolak];

            $statuses = ['MENUNGGU_KASI', 'MENUNGGU_KABID', 'MENUNGGU_SEKDIS', 'MENUNGGU_KADIS', 'SELESAI', 'DITOLAK'];
            $stage_counts = [];
            foreach ($statuses as $st) {
                $stage_counts[$st] = $this->db->where('status', $st)->count_all_results('tka');
            }

            $avg_time_stage = [];
            foreach ($statuses as $st) {
                $role_map = '';
                switch ($st) {
                    case 'MENUNGGU_KASI':  $role_map = 'kasi'; break;
                    case 'MENUNGGU_KABID': $role_map = 'kabid'; break;
                    case 'MENUNGGU_SEKDIS': $role_map = 'sekdis'; break;
                    case 'MENUNGGU_KADIS': $role_map = 'kadis'; break;
                    default: $role_map = '';
                }
                if ($role_map) {
                    $this->db->select('tka.created_at as tka_created, approval_log.created_at as log_created');
                    $this->db->from('approval_log');
                    $this->db->join('tka', 'tka.id = approval_log.tka_id');
                    $this->db->where('approval_log.status', 'approve');
                    $this->db->where('approval_log.role', $role_map);
                    $logs = $this->db->get()->result();
                    $total_days = 0;
                    $count = 0;
                    foreach ($logs as $log) {
                        $diff = (strtotime($log->log_created) - strtotime($log->tka_created)) / (60 * 60 * 24);
                        if ($diff > 0) {
                            $total_days += $diff;
                            $count++;
                        }
                    }
                    $avg_time_stage[$st] = ($count > 0) ? round($total_days / $count, 1) : 0;
                } else {
                    $avg_time_stage[$st] = 0;
                }
            }

            $recent_rejects = $this->db->select('role, catatan, created_at')
                                      ->from('approval_log')
                                      ->where('status', 'reject')
                                      ->order_by('created_at', 'DESC')
                                      ->limit(10)
                                      ->get()
                                      ->result();

            $reasons_lost = $this->db->select('catatan, COUNT(*) as total')
                                      ->from('approval_log')
                                      ->where('status', 'reject')
                                      ->group_by('catatan')
                                      ->order_by('total', 'DESC')
                                      ->limit(5)
                                      ->get()
                                      ->result();

            $months = [];
            $closed_won = [];
            $closed_lost = [];
            $in_progress = [];
            for ($i = 5; $i >= 0; $i--) {
                $bulan = date('Y-m', strtotime("-$i months"));
                $bulan_nama = date('M', strtotime("-$i months"));
                $months[] = $bulan_nama;
                $start = $bulan . '-01';
                $end = date('Y-m-t', strtotime($start));
                $won = $this->db->where('status', 'SELESAI')->where('created_at >=', $start)->where('created_at <=', $end)->count_all_results('tka');
                $lost = $this->db->where('status', 'DITOLAK')->where('created_at >=', $start)->where('created_at <=', $end)->count_all_results('tka');
                $progress = $this->db->group_start()
                                ->where('status', 'MENUNGGU_KASI')
                                ->or_where('status', 'MENUNGGU_KABID')
                                ->or_where('status', 'MENUNGGU_SEKDIS')
                                ->or_where('status', 'MENUNGGU_KADIS')
                                ->group_end()
                                ->where('created_at >=', $start)
                                ->where('created_at <=', $end)
                                ->count_all_results('tka');
                $closed_won[] = $won;
                $closed_lost[] = $lost;
                $in_progress[] = $progress;
            }

            $total_tka_all = $this->db->count_all('tka');
            $avg_convert_days = 0;
            $finished = $this->db->select('id, created_at')->where('status', 'SELESAI')->order_by('id', 'DESC')->limit(100)->get('tka')->result();
            $total_diff = 0;
            $count_finished = count($finished);
            if ($count_finished > 0) {
                foreach ($finished as $f) {
                    $approve_log = $this->db->select('created_at')->where('tka_id', $f->id)->where('status', 'approve')->order_by('id', 'DESC')->limit(1)->get('approval_log')->row();
                    if ($approve_log) {
                        $diff = (strtotime($approve_log->created_at) - strtotime($f->created_at)) / (60 * 60 * 24);
                        if ($diff > 0) $total_diff += $diff;
                    }
                }
                $avg_convert_days = round($total_diff / $count_finished, 1);
            }
            $inactive_leads = $ditolak;

            $data = [
                'all_tka'           => $all_tka,
                'total_tka'         => $total_tka,
                'total_perusahaan'  => $total_perusahaan,
                'proses'            => $proses,
                'selesai'           => $selesai,
                'ditolak'           => $ditolak,
                'chart_labels'      => json_encode($chart_labels),
                'chart_data'        => json_encode($chart_data),
                'status_data'       => json_encode($status_data),
                'stage_counts'      => $stage_counts,
                'avg_time_stage'    => $avg_time_stage,
                'recent_rejects'    => $recent_rejects,
                'reasons_lost'      => $reasons_lost,
                'months'            => json_encode($months),
                'closed_won'        => json_encode($closed_won),
                'closed_lost'       => json_encode($closed_lost),
                'in_progress'       => json_encode($in_progress),
                'total_tka_all'     => $total_tka_all,
                'avg_convert_days'  => $avg_convert_days,
                'inactive_leads'    => $inactive_leads
            ];
            $this->load->view('admin/dashboard', $data);
        }
        elseif ($role == 'operator') {
            redirect('operator/dashboard');
        }
        else {
            redirect('approval/index');
        }
    }
}