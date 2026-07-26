<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin Controller
 *
 * Mengelola seluruh fungsi administrasi SITLAKEB TKA:
 * perusahaan, petugas, data TKA, surat, laporan, SLA, dan notifikasi.
 *
 * @package    SITLAKEB TKA
 * @author     ZAI
 */
class Admin extends CI_Controller
{
    // =========================================================================
    // KONSTANTA ROLE
    // =========================================================================

    /** Role yang diizinkan untuk petugas/admin. */
    private const OFFICER_ROLES = ['kasi', 'kabid', 'sekdis', 'kadis', 'admin', 'operator'];

    // =========================================================================
    // CONSTRUCTOR
    // =========================================================================

    public function __construct()
    {
        parent::__construct();

        // Guard: hanya admin yang boleh masuk
        if ( ! $this->session->userdata('logged_in') || $this->session->userdata('role') !== 'admin') {
            redirect('auth/login');
        }

        $this->load->model([
            'Tka_model',
            'User_model',
            'Berkas_model',
            'Approval_log_model',
            'Admin_log_model',
            'Notification_model',
            'Surat_template_model',
            'sla_model'
        ]);

        $this->load->library('form_validation');
    }

    // =========================================================================
    // HELPER — PRIVATE
    // =========================================================================

    private function _log(string $action, ?string $target_type, ?int $target_id, string $description): void
    {
        $this->Admin_log_model->add_log([
            'admin_id'    => $this->session->userdata('user_id'),
            'admin_name'  => $this->session->userdata('nama'),
            'action'      => $action,
            'target_type' => $target_type,
            'target_id'   => $target_id,
            'description' => $description,
            'ip_address'  => $this->input->ip_address(),
        ]);
    }

    private function _delete_directory(string $dir): void
    {
        if ( ! is_dir($dir)) return;
        foreach (array_diff(scandir($dir), ['.', '..']) as $file) {
            is_dir("$dir/$file") ? $this->_delete_directory("$dir/$file") : unlink("$dir/$file");
        }
        rmdir($dir);
    }

    private function _ensure_dir(string $path): void
    {
        if ( ! is_dir($path)) mkdir($path, 0777, true);
    }

    private function _json(array $data, int $status = 200): void
    {
        $this->output->set_status_header($status)->set_content_type('application/json')->set_output(json_encode($data));
    }

    private function _get_tka_or_404(int $id): object
    {
        $tka = $this->Tka_model->get_by_id($id);
        if ( ! $tka) show_404();
        return $tka;
    }

    private function _get_user_or_404(int $id, string $role): object
    {
        $user = $this->User_model->get_by_id($id);
        if ( ! $user || $user->role !== $role) show_404();
        return $user;
    }

    private function _get_officer_or_404(int $id): object
    {
        $user = $this->User_model->get_by_id($id);
        if ( ! $user || ! in_array($user->role, self::OFFICER_ROLES, true)) show_404();
        return $user;
    }

    private function _validate(array $rules, string $redirect_to): bool
    {
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($redirect_to);
            return false;
        }
        return true;
    }

    private function _get_export_tka_data(): array
    {
        return $this->Tka_model->get_all_with_company();
    }

    // =========================================================================
    // DASHBOARD ADMIN (fix 404)
    // =========================================================================

    public function dashboard()
{
    // Data statistik dasar
    $data['total_tka_all'] = $this->Tka_model->count_all();

    // Hitung jumlah per status (gunakan GROUP BY)
    $statuses = ['MENUNGGU_KASI','MENUNGGU_KABID','MENUNGGU_SEKDIS','MENUNGGU_KADIS','SELESAI','DITOLAK'];
    $data['stage_counts'] = [];
    $status_query = $this->db->select('status, COUNT(*) as total')->group_by('status')->get('tka')->result();
    foreach ($status_query as $row) {
        $data['stage_counts'][$row->status] = $row->total;
    }
    foreach ($statuses as $st) {
        if (!isset($data['stage_counts'][$st])) $data['stage_counts'][$st] = 0;
    }

    // Rata-rata waktu per tahap (gunakan 0 jika error)
    $data['avg_time_stage'] = [];
    foreach ($statuses as $st) {
        $data['avg_time_stage'][$st] = 0;
    }

    $data['avg_convert_days'] = 0;
    $data['inactive_leads'] = $data['stage_counts']['DITOLAK'] ?? 0;

    // Chart data
    $chart = $this->Tka_model->get_chart_data_6months();
    $data['months']       = $chart['months'];
    $data['closed_won']   = $chart['closed_won'];
    $data['closed_lost']  = $chart['closed_lost'];
    $data['in_progress']  = $chart['in_progress'];

    // Alasan penolakan
    $data['recent_rejects'] = $this->Tka_model->get_recent_reject_reasons(5);

    // Semua TKA untuk tabel terbaru
    $data['all_tka'] = $this->Tka_model->get_all_with_company();

    $this->load->view('admin/dashboard', $data);
    }

    // =========================================================================
    // PERUSAHAAN
    // =========================================================================

    public function perusahaan(): void
    {
        $data['perusahaan'] = $this->User_model->get_all_companies();
        $this->load->view('admin/perusahaan', $data);
    }

    public function detail_user(int $id): void
    {
        $user = $this->_get_user_or_404($id, 'user');
        $data['user']     = $user;
        $data['tka_list'] = $this->Tka_model->get_by_user($id);
        $this->load->view('admin/detail_user', $data);
    }

    // =========================================================================
    // MANAJEMEN PERUSAHAAN (CRUD)
    // =========================================================================

    public function manage_users(): void
    {
        $data['users'] = $this->User_model->get_all_users_by_role('user');
        $this->load->view('admin/manage_users', $data);
    }

    public function edit_user(int $id): void
    {
        $data['user'] = $this->_get_user_or_404($id, 'user');
        $this->load->view('admin/edit_user', $data);
    }

    public function update_user(int $id): void
    {
        $this->_get_user_or_404($id, 'user');
        $rules = [
            ['field' => 'nama',       'label' => 'Nama PIC',   'rules' => 'required'],
            ['field' => 'perusahaan', 'label' => 'Perusahaan', 'rules' => 'required'],
            ['field' => 'no_hp',      'label' => 'No HP',      'rules' => 'required'],
            ['field' => 'alamat',     'label' => 'Alamat',     'rules' => 'required'],
        ];
        if ( ! $this->_validate($rules, "admin/edit_user/$id")) return;

        $this->User_model->update_user($id, [
            'nama'       => $this->input->post('nama'),
            'perusahaan' => $this->input->post('perusahaan'),
            'no_hp'      => $this->input->post('no_hp'),
            'alamat'     => $this->input->post('alamat'),
        ]);
        $this->_log('EDIT_USER', 'user', $id, "Mengedit data perusahaan ID $id");
        $this->session->set_flashdata('success', 'Data perusahaan berhasil diupdate.');
        redirect('admin/manage_users');
    }

    public function reset_password(int $id): void
    {
        $user = $this->_get_user_or_404($id, 'user');
        $this->User_model->update_user($id, ['password' => password_hash('password123', PASSWORD_DEFAULT)]);
        $this->_log('RESET_PASSWORD', 'user', $id, "Reset password perusahaan {$user->perusahaan}");
        $this->session->set_flashdata('success', 'Password berhasil direset menjadi <strong>password123</strong>.');
        redirect('admin/manage_users');
    }

    public function toggle_status(int $id = 0): void
    {
        if ( ! $id) show_404();
        $user = $this->_get_user_or_404($id, 'user');
        $new_status = ($user->is_active == 1) ? 0 : 1;
        $label = $new_status ? 'diaktifkan' : 'dinonaktifkan';
        $this->User_model->update_user($id, ['is_active' => $new_status]);
        $this->_log('TOGGLE_USER_STATUS', 'user', $id, "Perusahaan {$user->perusahaan} (ID {$id}) {$label}");
        $this->session->set_flashdata('success', "Akun perusahaan <strong>{$user->perusahaan}</strong> berhasil {$label}.");
        redirect('admin/manage_users');
    }

    public function delete_user(int $id): void
    {
        $user = $this->_get_user_or_404($id, 'user');
        $this->User_model->delete_user($id);
        $this->_log('DELETE_USER', 'user', $id, "Menghapus perusahaan {$user->perusahaan}");
        $this->session->set_flashdata('success', 'Perusahaan dan semua data terkait berhasil dihapus.');
        redirect('admin/manage_users');
    }

    // =========================================================================
    // MANAJEMEN PETUGAS & ADMIN (CRUD)
    // =========================================================================

    public function manage_officers(): void
    {
        $data['users'] = $this->User_model->get_all_officers_and_admins();
        $this->load->view('admin/manage_officers', $data);
    }

    public function add_officer(): void
    {
        $rules = [
            ['field' => 'nama',     'label' => 'Nama',     'rules' => 'required|trim'],
            ['field' => 'email',    'label' => 'Email',    'rules' => 'required|valid_email|is_unique[users.email]'],
            ['field' => 'password', 'label' => 'Password', 'rules' => 'required|min_length[6]'],
            ['field' => 'role',     'label' => 'Role',     'rules' => 'required|in_list[' . implode(',', self::OFFICER_ROLES) . ']'],
            ['field' => 'nip',      'label' => 'NIP',      'rules' => 'required|trim'],
            ['field' => 'no_hp',    'label' => 'No HP',    'rules' => 'required|trim'],
        ];
        if ( ! $this->_validate($rules, 'admin/manage_officers')) return;

        $insert_data = [
            'nama'       => $this->input->post('nama'),
            'email'      => $this->input->post('email'),
            'password'   => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'role'       => $this->input->post('role'),
            'nip'        => $this->input->post('nip'),
            'no_hp'      => $this->input->post('no_hp'),
            'perusahaan' => '-',
            'alamat'     => '-',
            'is_active'  => 1,
        ];
        $new_id = $this->User_model->insert($insert_data);
        $this->_log('ADD_OFFICER', 'user', $new_id, "Menambahkan petugas baru: {$insert_data['nama']} (role {$insert_data['role']})");
        $this->session->set_flashdata('success', "Petugas <strong>{$insert_data['nama']}</strong> berhasil ditambahkan.");
        redirect('admin/manage_officers');
    }

    public function edit_officer(int $id): void
    {
        $data['user'] = $this->_get_officer_or_404($id);
        $this->load->view('admin/edit_officer', $data);
    }

    public function update_officer(int $id): void
    {
        $this->_get_officer_or_404($id);
        $rules = [
            ['field' => 'nama',  'label' => 'Nama',  'rules' => 'required|trim'],
            ['field' => 'nip',   'label' => 'NIP',   'rules' => 'required|trim'],
            ['field' => 'no_hp', 'label' => 'No HP', 'rules' => 'required|trim'],
            ['field' => 'role',  'label' => 'Role',  'rules' => 'required|in_list[' . implode(',', self::OFFICER_ROLES) . ']'],
        ];
        if ( ! $this->_validate($rules, "admin/edit_officer/$id")) return;

        $this->User_model->update_user($id, [
            'nama'      => $this->input->post('nama'),
            'nip'       => $this->input->post('nip'),
            'no_hp'     => $this->input->post('no_hp'),
            'role'      => $this->input->post('role'),
            'is_active' => $this->input->post('is_active') ? 1 : 0,
        ]);
        $this->_log('EDIT_OFFICER', 'user', $id, "Mengedit data petugas ID $id");
        $this->session->set_flashdata('success', 'Data petugas berhasil diupdate.');
        redirect('admin/manage_officers');
    }

    public function reset_officer_password(int $id): void
    {
        $logged_in = (int) $this->session->userdata('user_id');
        if ($id === $logged_in) {
            $this->session->set_flashdata('error', 'Gunakan halaman profil untuk mengganti password Anda sendiri.');
            redirect('admin/manage_officers');
            return;
        }
        $user = $this->_get_officer_or_404($id);
        $this->User_model->update_user($id, ['password' => password_hash('Admin@1234', PASSWORD_DEFAULT)]);
        $this->_log('RESET_OFFICER_PASSWORD', 'user', $id, "Reset password petugas {$user->nama}");
        $this->session->set_flashdata('success', "Password <strong>{$user->nama}</strong> berhasil direset menjadi <strong>Admin@1234</strong>.");
        redirect('admin/manage_officers');
    }

    public function toggle_officer_status($id = 0): void
    {
        if (empty($id)) $id = (int) $this->uri->segment(3);
        if (empty($id)) show_404();

        $logged_in = (int) $this->session->userdata('user_id');
        if ($id === $logged_in) {
            $this->session->set_flashdata('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri.');
            redirect('admin/manage_officers');
            return;
        }
        $user = $this->_get_officer_or_404($id);
        $new_status = ($user->is_active == 1) ? 0 : 1;
        $label = $new_status ? 'diaktifkan' : 'dinonaktifkan';
        $this->User_model->update_user($id, ['is_active' => $new_status]);
        $this->_log('TOGGLE_OFFICER_STATUS', 'user', $id, "Petugas {$user->nama} (ID {$id}) {$label}");
        $this->session->set_flashdata('success', "Akun petugas <strong>{$user->nama}</strong> berhasil {$label}.");
        redirect('admin/manage_officers');
    }

    public function delete_officer(int $id = 0): void
    {
        if ( ! $id) show_404();
        $logged_in = (int) $this->session->userdata('user_id');
        if ($id === $logged_in) {
            $this->session->set_flashdata('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
            redirect('admin/manage_officers');
            return;
        }
        if ($id === 1) {
            $this->session->set_flashdata('error', 'Admin utama (ID 1) tidak dapat dihapus.');
            redirect('admin/manage_officers');
            return;
        }
        $user = $this->_get_officer_or_404($id);
        $this->User_model->delete_user($id);
        $this->_log('DELETE_OFFICER', 'user', $id, "Menghapus petugas {$user->nama}");
        $this->session->set_flashdata('success', "Akun petugas <strong>{$user->nama}</strong> berhasil dihapus.");
        redirect('admin/manage_officers');
    }

    // =========================================================================
    // DATA TKA
    // =========================================================================

    public function semua_tka(): void
    {
        $data['all_tka'] = $this->Tka_model->get_all_with_company();
        $this->load->view('admin/semua_tka', $data);
    }

    public function detail_tka(int $id): void
    {
        $tka  = $this->_get_tka_or_404($id);
        $user = $this->User_model->get_by_id($tka->user_id);
        $data = [
            'tka'             => $tka,
            'perusahaan_nama' => $user ? $user->perusahaan : '-',
            'berkas'          => $this->Berkas_model->get_by_tka($id),
            'logs'            => $this->Approval_log_model->get_by_tka($id),
        ];
        $this->load->view('admin/detail_tka', $data);
    }

    public function edit_tka(int $id): void
    {
        $data['tka']    = $this->_get_tka_or_404($id);
        $data['berkas'] = $this->Berkas_model->get_by_tka($id);
        $this->load->view('admin/edit_tka', $data);
    }

    public function update_tka(int $id): void
    {
        $this->_get_tka_or_404($id);
        $rules = [
            ['field' => 'nama_tka', 'label' => 'Nama TKA', 'rules' => 'required'],
            ['field' => 'status',   'label' => 'Status',   'rules' => 'required'],
        ];
        if ( ! $this->_validate($rules, "admin/edit_tka/$id")) return;

        $fields = ['nama_tka', 'status', 'passport_no', 'passport_expiry', 'kitas_no', 'stm_no', 'rptka_no', 'rptka_date',
                   'notifikasi_no', 'notifikasi_date', 'jabatan', 'tempat_lahir', 'tanggal_lahir', 'negara_asal',
                   'jenis_kelamin', 'alamat_tinggal', 'lokasi_kerja'];
        $this->Tka_model->update_detail($id, $this->input->post($fields));
        $this->_log('EDIT_TKA', 'tka', $id, "Mengedit data TKA ID $id");
        $this->session->set_flashdata('success', 'Data TKA berhasil diupdate.');
        redirect('admin/semua_tka');
    }

    public function delete_tka(int $id): void
    {
        $tka = $this->_get_tka_or_404($id);
        $this->_delete_directory('./uploads/' . $id);
        $this->Tka_model->delete($id);
        $this->_log('DELETE_TKA', 'tka', $id, "Menghapus TKA {$tka->nama_tka}");
        $this->session->set_flashdata('success', 'Data TKA berhasil dihapus.');
        redirect('admin/semua_tka');
    }

    // =========================================================================
    // NOMOR SURAT
    // =========================================================================

    public function edit_nomor_surat(int $tka_id): void
    {
        $data['tka'] = $this->_get_tka_or_404($tka_id);
        $this->load->view('admin/edit_nomor_surat', $data);
    }

    public function update_nomor_surat(int $tka_id): void
    {
        $tka = $this->_get_tka_or_404($tka_id);
        $this->Tka_model->update($tka_id, [
            'nomor_surat_keluar'     => $this->input->post('nomor_surat_keluar'),
            'nomor_surat_permohonan' => $this->input->post('nomor_surat_permohonan'),
            'surat_teks_approved'    => 1,
        ]);
        $this->Notification_model->add($tka->user_id, 'Nomor Surat Telah Ditentukan',
            "Nomor surat untuk TKA {$tka->nama_tka} telah siap. Silakan download surat.",
            base_url("user/detail/$tka_id"));
        $this->session->set_flashdata('success', 'Nomor surat berhasil diupdate. User sekarang bisa download.');
        redirect('admin/semua_tka');
    }

    // =========================================================================
    // SURAT & EMAIL
    // =========================================================================

     public function kirim_notifikasi() {
        $data['perusahaan'] = $this->db->where('role', 'user')->get('users')->result();
        $this->load->view('admin/kirim_notifikasi', $data);
    }

    public function kirim_notifikasi_action() {
    $this->form_validation->set_rules('send_mode', 'Mode', 'required');
    $this->form_validation->set_rules('title', 'Judul', 'required');
    $this->form_validation->set_rules('message', 'Pesan', 'required');

    if ($this->form_validation->run() == FALSE) {
        $this->session->set_flashdata('error', validation_errors());
        redirect('admin/kirim_notifikasi');
        return;
    }

    $title   = $this->input->post('title', TRUE);
    $message = $this->input->post('message', TRUE);
    $link    = $this->input->post('link', TRUE);
    $mode    = $this->input->post('send_mode');

    if ($mode === 'all') {
        // Ambil semua user role 'user'
        $users = $this->db->where('role', 'user')->get('users')->result();
        if (empty($users)) {
            $this->session->set_flashdata('error', 'Tidak ada perusahaan terdaftar.');
            redirect('admin/kirim_notifikasi');
            return;
        }

        $count = 0;
        foreach ($users as $u) {
            $this->send_notification($u->id, $title, $message, $link);
            $count++;
        }
        $this->session->set_flashdata('success', "Notifikasi berhasil dikirim ke $count perusahaan.");
    } else {
        // Single user
        $user_id = $this->input->post('user_id', TRUE);
        if (empty($user_id)) {
            $this->session->set_flashdata('error', 'Pilih perusahaan terlebih dahulu.');
            redirect('admin/kirim_notifikasi');
            return;
        }
        $this->send_notification($user_id, $title, $message, $link);
        $this->session->set_flashdata('success', 'Notifikasi berhasil dikirim ke perusahaan yang dipilih.');
    }

    redirect('admin/kirim_notifikasi');
    }

    // Helper method (sesuaikan dengan mekanisme notifikasi yang sudah ada)
    private function send_notification($user_id, $title, $message, $link) {
        $data = [
            'user_id'    => $user_id,
            'title'      => $title,
            'message'    => $message,
            'link'       => $link,
            'created_at' => date('Y-m-d H:i:s'),
            'is_read'    => 0
        ];
        $this->db->insert('notifications', $data);
    }

    // =========================================================================
    // PENGATURAN SURAT & TANDA TANGAN
    // =========================================================================

    public function upload_ttd(): void
    {
        $data['template'] = $this->Surat_template_model->get();
        $data['ttd_path'] = $this->Surat_template_model->get_ttd_path();
        $this->load->view('admin/upload_ttd', $data);
    }

    public function update_kepala_dinas(): void
    {
        $this->Surat_template_model->update_template([
            'kepala_dinas'     => $this->input->post('kepala_dinas'),
            'nip_kepala_dinas' => $this->input->post('nip_kepala_dinas'),
        ]);
        $this->session->set_flashdata('success', 'Data Kepala Dinas berhasil diupdate.');
        redirect('admin/upload_ttd');
    }

    public function do_upload_ttd(): void
    {
        $upload_path = './uploads/ttd/';
        $this->_ensure_dir($upload_path);
        $this->load->library('upload', [
            'upload_path'   => $upload_path,
            'allowed_types' => 'png|jpg|jpeg',
            'max_size'      => 1024,
            'file_name'     => 'ttd_kepala_dinas_' . time(),
        ]);
        if ($this->upload->do_upload('ttd_file')) {
            $file_path = 'uploads/ttd/' . $this->upload->data('file_name');
            $old_ttd = $this->Surat_template_model->get_ttd_path();
            if ($old_ttd && file_exists($old_ttd)) unlink($old_ttd);
            $this->Surat_template_model->update_ttd($file_path);
            $this->session->set_flashdata('success', 'TTD berhasil diupload.');
        } else {
            $this->session->set_flashdata('error', $this->upload->display_errors());
        }
        redirect('admin/upload_ttd');
    }

    public function delete_ttd(): void
    {
        $old_ttd = $this->Surat_template_model->get_ttd_path();
        if ($old_ttd && file_exists($old_ttd)) unlink($old_ttd);
        $this->Surat_template_model->update_ttd(null);
        $this->session->set_flashdata('success', 'TTD berhasil dihapus.');
        redirect('admin/upload_ttd');
    }

    public function edit_surat_settings(): void
    {
        $data['template'] = $this->Surat_template_model->get();
        $this->load->view('admin/edit_surat_settings', $data);
    }

    public function update_surat_settings(): void
    {
        $this->Surat_template_model->update_template([
            'kepala_dinas'     => $this->input->post('kepala_dinas'),
            'nip_kepala_dinas' => $this->input->post('nip_kepala_dinas'),
        ]);
        $this->session->set_flashdata('success', 'Data kepala dinas berhasil diupdate.');
        redirect('admin/edit_surat_settings');
    }

    // =========================================================================
    // DOWNLOAD SURAT (WORD)
    // =========================================================================

    public function download_surat_word(int $id): void
    {
        $tka = $this->_get_tka_or_404($id);
        if ($tka->status !== 'SELESAI' || $tka->surat_teks_approved != 1) {
            $this->session->set_flashdata('error', 'Surat tidak dapat diunduh. Status belum SELESAI atau teks belum disetujui.');
            redirect('admin/semua_tka');
            return;
        }

        $user   = $this->User_model->get_by_id($tka->user_id);
        $berkas = $this->Berkas_model->get_by_tka($id);
        $tmpl   = $this->Surat_template_model->get();

        $nomor_surat = ! empty($tka->nomor_surat_manual) ? $tka->nomor_surat_manual :
            str_replace(['{id}', '{tahun}'], [$id, date('Y')], $tmpl->nomor_surat_format ?? '503/{id}/DISNAKER/{tahun}');
        $tanggal_surat = ! empty($tka->tanggal_surat_manual) ? date('d-m-Y', strtotime($tka->tanggal_surat_manual)) : date('d-m-Y');

        $text_data = [
            'perusahaan'               => $user ? $user->perusahaan : '-',
            'nomor_surat'              => $nomor_surat,
            'nama_pic'                 => $user ? $user->nama : '-',
            'tanggal_surat_permohonan' => date('d-m-Y', strtotime($tka->created_at)),
            'nama_tka'                 => $tka->nama_tka,
            'jenis_kelamin'            => $tka->jenis_kelamin ?? '-',
            'tempat_lahir'             => $tka->tempat_lahir ?? '-',
            'tanggal_lahir'            => $tka->tanggal_lahir ? date('d-m-Y', strtotime($tka->tanggal_lahir)) : '-',
            'kebangsaan'               => $tka->negara_asal ?? '-',
            'jabatan'                  => $tka->jabatan ?? '-',
            'passport_no'              => $tka->passport_no ?? '-',
            'passport_expiry'          => $tka->passport_expiry ? date('d-m-Y', strtotime($tka->passport_expiry)) : '-',
            'kitas_no'                 => $tka->kitas_no ?? '-',
            'rptka_no'                 => $tka->rptka_no ?? '-',
            'rptka_date'               => $tka->rptka_date ? date('d-m-Y', strtotime($tka->rptka_date)) : '-',
            'notifikasi_no'            => $tka->notifikasi_no ?? '-',
            'notifikasi_date'          => $tka->notifikasi_date ? date('d-m-Y', strtotime($tka->notifikasi_date)) : '-',
            'jenis_notifikasi'         => $tka->jenis_notifikasi ?? '-',
            'masa_berlaku_notifikasi'  => $tka->masa_berlaku_notifikasi ?? '-',
            'lunas_dkp'                => $tka->lunas_dkp ?? '-',
            'lokasi_kerja'             => $tka->lokasi_kerja ?? '-',
            'alamat_tinggal'           => $tka->alamat_tinggal ?? '-',
            'bidang_usaha'             => $tka->bidang_usaha ?? '-',
            'alamat_perusahaan'        => $user ? $user->alamat : '-',
            'tanggal_surat'            => $tanggal_surat,
            'kepala_dinas'             => $tmpl->kepala_dinas ?? 'Kepala Dinas',
            'nip_kepala_dinas'         => $tmpl->nip_kepala_dinas ?? '-',
            'nomor_surat_keluar'       => $tka->nomor_surat_keluar ?? '',
            'nomor_surat_permohonan'   => $tka->nomor_surat_permohonan ?? '',
        ];

        $image_data = [];
        $ttd_path = $this->Surat_template_model->get_ttd_path();
        if (!empty($ttd_path) && file_exists(FCPATH . $ttd_path)) {
            $image_data[] = ['placeholder' => 'ttd_kepala_dinas', 'path' => FCPATH . $ttd_path, 'width' => 160, 'height' => 110, 'ratio' => true];
        }
        if ($berkas && !empty($berkas->foto)) {
            $foto_path = FCPATH . 'uploads/' . $id . '/' . $berkas->foto;
            if (file_exists($foto_path)) {
                $image_data[] = ['placeholder' => 'foto_path', 'path' => $foto_path, 'width' => 170, 'height' => 200, 'ratio' => false];
            }
        }

        $this->load->library('Word_generator');
        $this->word_generator->generate(FCPATH . 'application/template/template_surat.docx', $text_data, $image_data, "Surat_TKA_{$tka->nama_tka}.docx");
    }

    // =========================================================================
    // EKSPOR DATA
    // =========================================================================

    public function export_tka_csv(): void
    {
        $this->_log('EXPORT_TKA_CSV', null, null, 'Mengekspor data TKA ke CSV');
        $rows = $this->_get_export_tka_data();
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="data_tka_' . date('Y-m-d') . '.csv"');
        $out = fopen('php://output', 'w');
        fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));
        fputcsv($out, ['No', 'Perusahaan', 'Nama TKA', 'Status', 'Tanggal Pengajuan', 'Passport No', 'KITAS No', 'STM No', 'RPTKA No', 'Jabatan', 'Tempat Lahir', 'Tanggal Lahir', 'Negara Asal', 'Lokasi Kerja']);
        $no = 1;
        foreach ($rows as $t) {
            fputcsv($out, [
                $no++, $t->perusahaan, $t->nama_tka, $t->status, date('d-m-Y H:i', strtotime($t->created_at)),
                $t->passport_no ?? '', $t->kitas_no ?? '', $t->stm_no ?? '', $t->rptka_no ?? '', $t->jabatan ?? '',
                $t->tempat_lahir ?? '', $t->tanggal_lahir ? date('d-m-Y', strtotime($t->tanggal_lahir)) : '', $t->negara_asal ?? '', $t->lokasi_kerja ?? ''
            ]);
        }
        fclose($out);
        exit;
    }

    public function export_tka_xlsx(): void
    {
        $this->_log('EXPORT_TKA_XLSX', null, null, 'Mengekspor data TKA ke Excel dengan template');

        // Ambil data dari database
        $rows = $this->_get_export_tka_data();

        // Path file template (pastikan path benar)
        $templatePath = FCPATH . 'application/template/template_tka.xlsx';
        if (!file_exists($templatePath)) {
            show_error('Template tidak ditemukan: ' . $templatePath);
        }

        // Load template dengan namespace lengkap
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();

        // Hapus semua baris data contoh (mulai baris 6 ke bawah)
        $highestRow = $sheet->getHighestRow();
        $startDataRow = 6;
        if ($highestRow >= $startDataRow) {
            $sheet->removeRow($startDataRow, $highestRow - $startDataRow + 1);
        }

        // Variabel untuk grouping perusahaan
        $currentRow = $startDataRow;
        $globalNo = 1;
        $prevPerusahaan = null;
        $noPerusahaan = 0;
        $noTkaInPerusahaan = 1;

        foreach ($rows as $t) {
            if ($prevPerusahaan !== $t->perusahaan) {
                $noPerusahaan++;
                $noTkaInPerusahaan = 1;
                $prevPerusahaan = $t->perusahaan;
            } else {
                $noTkaInPerusahaan++;
            }

            $sheet->setCellValue('A' . $currentRow, $globalNo++);
            $sheet->setCellValue('B' . $currentRow, $noPerusahaan);
            $sheet->setCellValue('C' . $currentRow, $t->perusahaan);
            $sheet->setCellValue('D' . $currentRow, $noTkaInPerusahaan);
            $sheet->setCellValue('E' . $currentRow, $t->nama_tka);
            $sheet->setCellValue('F' . $currentRow, $t->negara_asal ?? '');
            $sheet->setCellValue('G' . $currentRow, $t->jabatan ?? '');
            $sheet->setCellValue('H' . $currentRow, $t->jenis_usaha ?? '');
            $sheet->setCellValue('I' . $currentRow, date('d-m-Y', strtotime($t->created_at)));
            $sheet->setCellValue('J' . $currentRow, $this->_getLokasiKerja($t->lokasi_kerja ?? ''));
            $sheet->setCellValue('K' . $currentRow, '');
            $sheet->setCellValue('L' . $currentRow, '');
            $sheet->setCellValue('M' . $currentRow, '');
            $sheet->setCellValue('N' . $currentRow, '');
            $sheet->setCellValue('O' . $currentRow, '');
            $sheet->setCellValue('P' . $currentRow, $this->_getKeteranganTKA($t->status));
            $sheet->setCellValue('Q' . $currentRow, '');

            $currentRow++;
        }

        // Download file
        $fileName = 'Data_TKA_' . date('Ymd_His') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    // Helper functions (pastikan ada di dalam class Admin)
    private function _getLokasiKerja($lokasi)
    {
        $map = [
            'Bekasi' => 1,
            'Pusat'  => 2,
            'Prov'   => 3,
        ];
        return $map[$lokasi] ?? $lokasi;
    }

    private function _getKeteranganTKA($status)
    {
        $map = [
            'DRAFT' => 'Draft',
            'MENUNGGU_KASI' => 'Menunggu Kasi',
            'MENUNGGU_KABID' => 'Menunggu Kabid',
            'MENUNGGU_SEKDIS' => 'Menunggu Sekdis',
            'MENUNGGU_KADIS' => 'Menunggu Kadis',
            'SELESAI' => 'Selesai',
            'DITOLAK' => 'Ditolak',
        ];
        return $map[$status] ?? 'Proses';
    }

    public function export_perusahaan_xlsx(): void
    {
        $this->_log('EXPORT_PERUSAHAAN_XLSX', null, null, 'Mengekspor data perusahaan ke Excel');
        $data = $this->User_model->get_all_companies();
        $this->load->library('excel_generator');
        $this->excel_generator->generate_perusahaan($data, 'Data_Perusahaan');
    }

    // =========================================================================
    // LAPORAN BULANAN
    // =========================================================================

    public function laporan(): void
    {
        $data['bulan'] = date('m');
        $data['tahun'] = date('Y');
        $this->load->view('admin/laporan_form', $data);
    }

    public function laporan_bulanan(): void
    {
        $bulan = $this->input->get('bulan') ?: date('m');
        $tahun = $this->input->get('tahun') ?: date('Y');
        $start_date = "$tahun-$bulan-01";
        $end_date = date('Y-m-t', strtotime($start_date));
        $rows = $this->Tka_model->get_by_date_range($start_date, $end_date);
        $data = [
            'tka' => $rows,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'bulan_nama' => date('F', mktime(0, 0, 0, (int) $bulan, 1)),
        ];
        $this->_log('CETAK_LAPORAN', null, null, "Cetak laporan bulanan $bulan-$tahun");
        $this->load->library('Pdf_generator');
        $html = $this->load->view('admin/laporan_bulanan_pdf', $data, true);
        $this->pdf_generator->generate_from_html($html, "Laporan_Bulanan_{$tahun}-{$bulan}.pdf");
    }

    // =========================================================================
    // LOG AKTIVITAS
    // =========================================================================

    public function logs(): void
    {
        $data['logs'] = $this->Admin_log_model->get_all_logs(200);
        $this->load->view('admin/logs', $data);
    }

    // =========================================================================
    // PENGATURAN SLA
    // =========================================================================

    public function sla(): void
    {
        $data['sla_list'] = $this->sla_model->get_all();
        $this->load->view('admin/sla', $data);
    }

    public function update_sla(): void
    {
        $updates = [];
        foreach ([1, 2, 3, 4] as $level) {
            $sla_jam = (int) $this->input->post("sla_jam_{$level}");
            $reminder_jam = $this->input->post("reminder_jam_{$level}");

            if ($sla_jam <= 0) {
                $this->session->set_flashdata('error', "Jam SLA untuk level {$level} tidak valid.");
                redirect('admin/sla');
                return;
            }

            if ($reminder_jam !== '' && $reminder_jam !== null) {
                $reminder_jam = (int) $reminder_jam;
                if ($reminder_jam < 0 || $reminder_jam > $sla_jam) {
                    $this->session->set_flashdata('error', "Reminder level {$level} tidak valid (harus antara 0 dan SLA).");
                    redirect('admin/sla');
                    return;
                }
            } else {
                $reminder_jam = null;
            }

            // Simpan langsung per level — bukan batch
            $this->sla_model->update($level, [
                'sla_jam'      => $sla_jam,
                'reminder_jam' => $reminder_jam
            ]);
        }

        $this->_log('UPDATE_SLA', null, null, 'Memperbarui pengaturan SLA approval');
        $this->session->set_flashdata('success', 'Pengaturan SLA berhasil disimpan.');
        redirect('admin/sla');
    }

    // =========================================================================
    // NOTIFIKASI — API ENDPOINT
    // =========================================================================

    public function get_notifications(): void
    {
        $admin_id = (int) $this->session->userdata('user_id');
        $system_notifs = $this->db->select('id, title, message, is_read, created_at, "system" AS type')
            ->where('user_id', $admin_id)->order_by('created_at', 'DESC')->limit(30)->get('notifications')->result();
        $unread_chats = $this->db->select('m.id, CONCAT("Pesan dari ", u.perusahaan) AS title, m.message, m.is_read_admin AS is_read, m.created_at, "chat" AS type')
            ->from('messages m')->join('users u', 'u.id = m.from_user_id')
            ->where('m.to_user_id', $admin_id)->where('m.is_read_admin', 0)->where('u.role', 'user')
            ->order_by('m.created_at', 'DESC')->limit(20)->get()->result();
        $all = array_merge($system_notifs, $unread_chats);
        usort($all, fn($a, $b) => strtotime($b->created_at) - strtotime($a->created_at));
        $all = array_slice($all, 0, 40);
        $unread_count = count(array_filter($all, fn($n) => (int) $n->is_read === 0));
        $this->_json(['unread_count' => $unread_count, 'notifications' => $all]);
    }

    public function mark_notif_read(int $id): void
    {
        $this->db->where('id', $id)->update('notifications', ['is_read' => 1]);
        $this->_json(['status' => 'ok']);
    }

    public function mark_all_notif_read(): void
    {
        $admin_id = (int) $this->session->userdata('user_id');
        $this->db->where('user_id', $admin_id)->update('notifications', ['is_read' => 1]);
        $this->_json(['status' => 'ok']);
    }

    // =========================================================================
    // POLLING — Pengajuan Baru
    // =========================================================================

    public function check_new_submissions(): void
    {
        $last_id = $this->session->userdata('last_tka_id');
        if ( ! $last_id) {
            $max_id = $this->Tka_model->get_max_id();
            $this->session->set_userdata('last_tka_id', $max_id);
            $this->_json(['status' => 'init']);
            return;
        }
        $new_tka = $this->Tka_model->get_new_submissions($last_id);
        if (empty($new_tka)) {
            $this->_json(['status' => 'no_new']);
            return;
        }
        $this->session->set_userdata('last_tka_id', max(array_column($new_tka, 'id')));
        $count = count($new_tka);
        $first = $new_tka[0];
        $msg = ($count === 1) ? "Pengajuan baru dari {$first->perusahaan}: {$first->nama_tka}" : "Ada {$count} pengajuan TKA baru";
        $this->_json(['status' => 'new', 'message' => $msg, 'count' => $count]);
    }

    public function save_detail($id)
{
    // Cek apakah TKA ada
    $tka = $this->Tka_model->get_by_id($id);
    if (!$tka) show_404();

    // Validasi input
    $this->form_validation->set_rules('passport_no', 'Nomor Passport', 'required');
    $this->form_validation->set_rules('kitas_no', 'Nomor KITAS', 'required');
    $this->form_validation->set_rules('negara_asal', 'Kebangsaan', 'required');
    $this->form_validation->set_rules('jabatan', 'Jabatan', 'required');
    $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required');
    $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required');
    $this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required');
    $this->form_validation->set_rules('jenis_notifikasi', 'Jenis Notifikasi', 'required');
    $this->form_validation->set_rules('lunas_dkp', 'Lunas DKP', 'required');
    $this->form_validation->set_rules('bidang_usaha', 'Bidang Usaha', 'required');

    if ($this->form_validation->run() == FALSE) {
        $this->session->set_flashdata('error', validation_errors());
        redirect('admin/edit_tka/'.$id); // atau ke halaman sebelumnya
        return;
    }

    // Data yang akan diupdate
    $data = [
        'passport_no'            => $this->input->post('passport_no'),
        'passport_expiry'        => $this->input->post('passport_expiry'),
        'kitas_no'               => $this->input->post('kitas_no'),
        'stm_no'                 => $this->input->post('stm_no'),
        'rptka_no'               => $this->input->post('rptka_no'),
        'rptka_date'             => $this->input->post('rptka_date'),
        'notifikasi_no'          => $this->input->post('notifikasi_no'),
        'notifikasi_date'        => $this->input->post('notifikasi_date'),
        'jabatan'                => $this->input->post('jabatan'),
        'tempat_lahir'           => $this->input->post('tempat_lahir'),
        'tanggal_lahir'          => $this->input->post('tanggal_lahir'),
        'negara_asal'            => $this->input->post('negara_asal'),
        'jenis_kelamin'          => $this->input->post('jenis_kelamin'),
        'alamat_tinggal'         => $this->input->post('alamat_tinggal'),
        'lokasi_kerja'           => $this->input->post('lokasi_kerja'),
        'jenis_notifikasi'       => $this->input->post('jenis_notifikasi'),
        'masa_berlaku_notifikasi'=> $this->input->post('masa_berlaku_notifikasi'),
        'lunas_dkp'              => $this->input->post('lunas_dkp'),
        'bidang_usaha'           => $this->input->post('bidang_usaha')
    ];

    // Update ke database
    $update = $this->Tka_model->update_detail($id, $data);

    if ($update) {
        $this->session->set_flashdata('success', 'Data TKA berhasil diperbarui.');
    } else {
        $this->session->set_flashdata('error', 'Gagal memperbarui data TKA.');
    }

    redirect('admin/semua_tka'); // sesuaikan dengan halaman daftar TKA admin
    }
}