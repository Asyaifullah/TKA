<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operator extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'operator') {
            redirect('auth/login');
        }
        $this->load->model([
            'Tka_model',
            'Berkas_model',
            'User_model',
            'Surat_template_model',
            'Notification_model',
            'Approval_log_model',
            'Chat_model',
        ]);
        $this->load->library('form_validation');
    }

    public function dashboard() {
        $data['total_tka']     = $this->db->count_all('tka');
        $data['total_selesai'] = $this->db->where('status', 'SELESAI')->count_all_results('tka');
        $data['total_proses']  = $this->db
            ->where_in('status', ['MENUNGGU_KASI','MENUNGGU_KABID','MENUNGGU_SEKDIS','MENUNGGU_KADIS'])
            ->count_all_results('tka');
        $data['total_ditolak'] = $this->db->where('status', 'DITOLAK')->count_all_results('tka');

        $sql = "
            SELECT
                t.*,
                u.perusahaan,
                u.nama AS nama_pic
            FROM tka t
            LEFT JOIN users u ON u.id = t.user_id
            ORDER BY
                CASE
                    WHEN t.status = 'SELESAI'
                     AND (t.nomor_surat_keluar IS NULL OR t.nomor_surat_keluar = '')
                    THEN 0
                    WHEN t.status IN (
                        'MENUNGGU_KASI','MENUNGGU_KABID',
                        'MENUNGGU_SEKDIS','MENUNGGU_KADIS'
                    ) THEN 1
                    WHEN t.status = 'SELESAI' THEN 2
                    ELSE 3
                END ASC,
                t.created_at DESC
            LIMIT 10
        ";
        $data['recent_tka'] = $this->db->query($sql)->result();

        $this->load->view('operator/dashboard', $data);
    }

    public function semua_tka() {
        $this->db->select('tka.*, users.perusahaan, users.nama AS nama_pic');
        $this->db->from('tka');
        $this->db->join('users', 'users.id = tka.user_id');
        $this->db->order_by('tka.created_at', 'DESC');
        $data['all_tka'] = $this->db->get()->result();
        $this->load->view('operator/semua_tka', $data);
    }

    public function detail_tka($id) {
        $tka = $this->Tka_model->get_by_id($id);
        if (!$tka) show_404();
        $user = $this->User_model->get_by_id($tka->user_id);
        $data['tka']            = $tka;
        $data['perusahaan_nama']= $user->perusahaan;
        $data['berkas']         = $this->Berkas_model->get_by_tka($id);
        $data['logs']           = $this->Approval_log_model->get_by_tka($id);
        $this->load->view('operator/detail_tka', $data);
    }

    public function edit_nomor_surat($tka_id) {
        $tka = $this->Tka_model->get_by_id($tka_id);
        if (!$tka) show_404();
        if ($tka->status != 'SELESAI') {
            $this->session->set_flashdata('error', 'Nomor surat hanya dapat diedit jika status SELESAI.');
            redirect('operator/semua_tka');
        }
        $data['tka'] = $tka;
        $this->load->view('operator/edit_nomor_surat', $data);
    }

    public function update_nomor_surat($tka_id) {
        $tka = $this->Tka_model->get_by_id($tka_id);
        if (!$tka) {
            $this->session->set_flashdata('error', 'Data TKA tidak ditemukan.');
            redirect('operator/semua_tka');
        }
        if ($tka->status != 'SELESAI') {
            $this->session->set_flashdata('error',
                'Nomor surat hanya dapat diedit jika status SELESAI (status saat ini: ' . $tka->status . ').'
            );
            redirect('operator/edit_nomor_surat/' . $tka_id);
        }
        $update = $this->db->where('id', $tka_id)->update('tka', [
            'nomor_surat_keluar'     => $this->input->post('nomor_surat_keluar'),
            'nomor_surat_permohonan' => $this->input->post('nomor_surat_permohonan'),
            'surat_teks_approved'    => 1,
        ]);
        if ($update) {
            $this->session->set_flashdata('success', 'Nomor surat berhasil diupdate.');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengupdate nomor surat. Silakan coba lagi.');
        }
        redirect('operator/semua_tka');
    }

    public function download_surat_word($id) {
        $tka = $this->Tka_model->get_by_id($id);
        if (!$tka) show_404();

        if ($tka->status != 'SELESAI') {
            $this->session->set_flashdata('error', 'Surat hanya dapat diunduh jika status sudah SELESAI.');
            redirect('admin/semua_tka');
        }
        if ($tka->surat_teks_approved != 1) {
            $this->session->set_flashdata('error', 'Surat belum disetujui oleh admin (teks belum diisi).');
            redirect('admin/semua_tka');
        }

        $user   = $this->User_model->get_by_id($tka->user_id);
        $berkas = $this->Berkas_model->get_by_tka($id);
        $this->load->model('Surat_template_model');
        $tmpl = $this->Surat_template_model->get();

        $nomor_surat   = !empty($tka->nomor_surat_manual)
            ? $tka->nomor_surat_manual
            : str_replace(['{id}', '{tahun}'], [$id, date('Y')],
                $tmpl->nomor_surat_format ?? '503/{id}/DISNAKER/{tahun}');
        $tanggal_surat = !empty($tka->tanggal_surat_manual)
            ? date('d-m-Y', strtotime($tka->tanggal_surat_manual))
            : date('d-m-Y');

        $text_data = [
            'perusahaan'               => $user->perusahaan,
            'nomor_surat'              => $nomor_surat,
            'nama_pic'                 => $user->nama,
            'tanggal_surat_permohonan' => date('d-m-Y', strtotime($tka->created_at)),
            'nama_tka'                 => $tka->nama_tka,
            'jenis_kelamin'            => $tka->jenis_kelamin        ?? '-',
            'tempat_lahir'             => $tka->tempat_lahir         ?? '-',
            'tanggal_lahir'            => $tka->tanggal_lahir ? date('d-m-Y', strtotime($tka->tanggal_lahir)) : '-',
            'kebangsaan'               => $tka->negara_asal          ?? '-',
            'jabatan'                  => $tka->jabatan              ?? '-',
            'passport_no'              => $tka->passport_no          ?? '-',
            'passport_expiry'          => $tka->passport_expiry ? date('d-m-Y', strtotime($tka->passport_expiry)) : '-',
            'kitas_no'                 => $tka->kitas_no             ?? '-',
            'rptka_no'                 => $tka->rptka_no             ?? '-',
            'rptka_date'               => $tka->rptka_date ? date('d-m-Y', strtotime($tka->rptka_date)) : '-',
            'notifikasi_no'            => $tka->notifikasi_no        ?? '-',
            'notifikasi_date'          => $tka->notifikasi_date ? date('d-m-Y', strtotime($tka->notifikasi_date)) : '-',
            'jenis_notifikasi'         => $tka->jenis_notifikasi     ?? '-',
            'masa_berlaku_notifikasi'  => $tka->masa_berlaku_notifikasi ?? '-',
            'lunas_dkp'                => $tka->lunas_dkp            ?? '-',
            'lokasi_kerja'             => $tka->lokasi_kerja         ?? '-',
            'alamat_tinggal'           => $tka->alamat_tinggal       ?? '-',
            'bidang_usaha'             => $tka->bidang_usaha         ?? '-',
            'alamat_perusahaan'        => $user->alamat,
            'tanggal_surat'            => $tanggal_surat,
            'kepala_dinas'             => $tmpl->kepala_dinas        ?? 'Kepala Dinas',
            'nip_kepala_dinas'         => $tmpl->nip_kepala_dinas    ?? '-',
            'nomor_surat_keluar'       => $tka->nomor_surat_keluar   ?? '',
            'nomor_surat_permohonan'   => $tka->nomor_surat_permohonan ?? '',
        ];

        $image_data = [];
        $ttd_path = $this->Surat_template_model->get_ttd_path();
        if (!empty($ttd_path) && file_exists(FCPATH . $ttd_path)) {
            $image_data[] = [
                'placeholder' => 'ttd_kepala_dinas',
                'path'        => FCPATH . $ttd_path,
                'width'       => 160,
                'height'      => 110,
                'ratio'       => true,
            ];
        }

        $foto_path = FCPATH . 'uploads/' . $id . '/' . $berkas->foto;
        if (file_exists($foto_path)) {
            $image_data[] = [
                'placeholder' => 'foto_path',
                'path'        => $foto_path,
                'width'       => 170,
                'height'      => 200,
                'ratio'       => false,
            ];
        }

        $this->load->library('Word_generator');
        $this->word_generator->generate(
            FCPATH . 'application/template/template_surat.docx',
            $text_data,
            $image_data,
            'Surat_TKA_' . $tka->nama_tka . '.docx'
        );
    }

    public function kirim_notifikasi() {
        $data['perusahaan'] = $this->db->where('role', 'user')->get('users')->result();
        $this->load->view('operator/kirim_notifikasi', $data);
    }

    public function kirim_notifikasi_action() {
    $this->form_validation->set_rules('send_mode', 'Mode', 'required');
    $this->form_validation->set_rules('title', 'Judul', 'required');
    $this->form_validation->set_rules('message', 'Pesan', 'required');

    if ($this->form_validation->run() == FALSE) {
        $this->session->set_flashdata('error', validation_errors());
        redirect('operator/kirim_notifikasi');
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
            redirect('operator/kirim_notifikasi');
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
            redirect('operator/kirim_notifikasi');
            return;
        }
        $this->send_notification($user_id, $title, $message, $link);
        $this->session->set_flashdata('success', 'Notifikasi berhasil dikirim ke perusahaan yang dipilih.');
    }

    redirect('operator/kirim_notifikasi');
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

    public function chat() {
        $data['users'] = $this->Chat_model->get_users_with_last_message(
            $this->session->userdata('user_id')
        );

        $partner_id = $this->input->get('user_id');
        if ($partner_id) {
            $data['selected_user'] = $this->User_model->get_by_id($partner_id);
            $data['messages']      = $this->Chat_model->get_conversation(
                $this->session->userdata('user_id'),
                $partner_id,
                100
            );
        }

        $this->load->view('operator/chat', $data);
    }

    public function chat_get_new() {
        $last_id    = $this->input->post('last_id');
        $partner_id = $this->input->post('partner_id');
        $user_id    = $this->session->userdata('user_id');

        $all = $this->Chat_model->get_conversation($user_id, $partner_id, 200);
        $new = [];
        foreach ($all as $msg) {
            if ($msg->id > $last_id) $new[] = $msg;
        }
        echo json_encode($new);
    }

    public function chat_send() {
        $to      = $this->input->post('to');
        $message = trim($this->input->post('message'));

        if (empty($message)) {
            echo json_encode(['status' => 'error', 'message' => 'Pesan tidak boleh kosong.']);
            return;
        }

        $insert = $this->Chat_model->send_message(
            $this->session->userdata('user_id'),
            $to,
            $message
        );

        echo json_encode($insert
            ? ['status' => 'success']
            : ['status' => 'error', 'message' => 'Gagal mengirim pesan.']
        );
    }

    public function chat_mark_read() {
        $partner_id = $this->input->post('partner_id');
        $admin_id   = $this->session->userdata('user_id');
        $this->Chat_model->mark_as_read_admin($partner_id, $admin_id);
        echo json_encode(['status' => 'ok']);
    }

    public function chat_get_user_list() {
        $users  = $this->Chat_model->get_users_with_last_message(
            $this->session->userdata('user_id')
        );
        $result = [];
        foreach ($users as $u) {
            $lastMsg  = $u->last_message ?? '';
            $result[] = [
                'id'                   => $u->id,
                'perusahaan'           => $u->perusahaan,
                'initials'             => strtoupper(substr($u->perusahaan, 0, 1)),
                'last_message'         => strlen($lastMsg) > 50 ? substr($lastMsg, 0, 50).'...' : $lastMsg,
                'last_message_from_me' => $u->last_message_from_me ?? false,
                'last_message_time'    => $u->last_message_time    ?? null,
                'unread_count'         => $u->unread_count         ?? 0,
            ];
        }
        echo json_encode($result);
    }
}