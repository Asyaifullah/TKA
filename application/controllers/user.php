<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if(!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'user') {
            redirect('auth/login');
        }
        $this->load->model(['Tka_model', 'Berkas_model', 'Approval_log_model', 'User_model']);
        $this->load->library('form_validation');
    }

    // ========== UPLOAD AWAL ==========
    public function upload() {
        $this->load->view('user/upload_tka');
    }

    public function do_upload() {
        $this->form_validation->set_rules('nama_tka', 'Nama TKA', 'required');
        if($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('user/upload');
        }

        $tka_data = [
            'user_id' => $this->session->userdata('user_id'),
            'nama_tka' => $this->input->post('nama_tka'),
            'status' => 'DRAFT'
        ];
        $tka_id = $this->Tka_model->insert($tka_data);
        if(!$tka_id) {
            $this->session->set_flashdata('error', 'Gagal menyimpan data TKA.');
            redirect('user/upload');
        }

        $upload_path = './uploads/'.$tka_id.'/';
        if(!is_dir($upload_path)) mkdir($upload_path, 0777, true);

        $config['upload_path'] = $upload_path;
        $config['max_size'] = 2048;
        $config['file_ext_tolower'] = TRUE;
        $this->load->library('upload');

        $wajib_pdf_fields = ['surat_permohonan', 'passport', 'rptka', 'notifikasi', 'bukti_bayar', 'surat_kuasa', 'surat_wajib_lapor'];
        $opsional_pdf_fields = ['kitas'];
        $image_fields = ['ktp', 'foto'];
        $upload_data = ['tka_id' => $tka_id];

        // Upload PDF wajib
        foreach($wajib_pdf_fields as $field) {
            if(!isset($_FILES[$field]) || $_FILES[$field]['error'] != 0) {
                $this->Tka_model->delete($tka_id);
                $this->session->set_flashdata('error', "File $field wajib diupload.");
                redirect('user/upload');
            }
            $config['allowed_types'] = 'pdf';
            $config['file_name'] = $tka_id.'_'.$field.'_'.time();
            $this->upload->initialize($config);
            if($this->upload->do_upload($field)) {
                $upload_data[$field] = $this->upload->data('file_name');
            } else {
                $this->Tka_model->delete($tka_id);
                $this->session->set_flashdata('error', "Gagal upload $field: " . $this->upload->display_errors('', ''));
                redirect('user/upload');
            }
        }

        // Upload PDF opsional (KITAS)
        foreach($opsional_pdf_fields as $field) {
            if(isset($_FILES[$field]) && $_FILES[$field]['error'] == 0) {
                $config['allowed_types'] = 'pdf';
                $config['file_name'] = $tka_id.'_'.$field.'_'.time();
                $this->upload->initialize($config);
                if($this->upload->do_upload($field)) {
                    $upload_data[$field] = $this->upload->data('file_name');
                } else {
                    $this->session->set_flashdata('warning', "Gagal upload $field (opsional): " . $this->upload->display_errors('', ''));
                }
            }
        }

        // Upload gambar wajib
        foreach($image_fields as $field) {
            if(!isset($_FILES[$field]) || $_FILES[$field]['error'] != 0) {
                $this->Tka_model->delete($tka_id);
                $this->session->set_flashdata('error', "File $field wajib diupload.");
                redirect('user/upload');
            }
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['file_name'] = $tka_id.'_'.$field.'_'.time();
            $this->upload->initialize($config);
            if($this->upload->do_upload($field)) {
                $upload_data[$field] = $this->upload->data('file_name');
            } else {
                $this->Tka_model->delete($tka_id);
                $this->session->set_flashdata('error', "Gagal upload $field: " . $this->upload->display_errors('', ''));
                redirect('user/upload');
            }
        }

        $this->Berkas_model->insert($upload_data);
        $this->session->set_flashdata('success', 'Data TKA berhasil diupload. Silakan lengkapi data detail TKA.');
        redirect('user/detail_form/'.$tka_id);
    }

    // ========== DATA TKA (LIST) ==========
    public function data_tka() {
        $user_id = $this->session->userdata('user_id');
        $list = $this->Tka_model->get_by_user($user_id);
        foreach($list as $t) {
            if ($t->status == 'DRAFT') {
                $t->stage_label = 'Data Belum Lengkap';
                $t->stage_color = 'secondary';
            } else {
                $stage = $this->Tka_model->get_approval_stage($t->status);
                $t->stage_label = $stage['label'];
                $t->stage_color = $stage['color'];
            }
        }
        $data['tka'] = $list;
        $this->load->view('user/data_tka', $data);
    }

    // ========== DETAIL TKA (USER) ==========
    public function detail($id) {
        $tka = $this->Tka_model->get_by_id($id);
        if(!$tka || $tka->user_id != $this->session->userdata('user_id')) show_404();
        $stage = $this->Tka_model->get_approval_stage($tka->status);
        $tka->stage_label = $stage['label'];
        $tka->stage_color = $stage['color'];
        $data['tka'] = $tka;
        $data['berkas'] = $this->Berkas_model->get_by_tka($id);
        $data['logs'] = $this->Approval_log_model->get_by_tka($id);
        $this->load->view('user/detail_tka', $data);
    }

    // ========== FORM LENGKAPI DATA DETAIL (hanya DRAFT) ==========
    public function detail_form($id) {
        $tka = $this->Tka_model->get_by_id($id);
        if(!$tka || $tka->user_id != $this->session->userdata('user_id')) show_404();
        if($tka->status != 'DRAFT') {
            $this->session->set_flashdata('error', 'Data detail sudah diisi atau pengajuan sudah diproses.');
            redirect('user/data_tka');
        }
        $data['tka'] = $tka;
        $this->load->view('user/detail_form', $data);
    }

    // ========== SIMPAN DATA DETAIL (DRAFT → MENUNGGU_KASI) ==========
    public function save_detail($id) {
        $tka = $this->Tka_model->get_by_id($id);
        if(!$tka || $tka->user_id != $this->session->userdata('user_id')) show_404();
        if($tka->status != 'DRAFT') {
            $this->session->set_flashdata('error', 'Data detail sudah diisi.');
            redirect('user/data_tka');
        }

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

        if($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('user/detail_form/'.$id);
        }

        $data = [
            'passport_no' => $this->input->post('passport_no'),
            'passport_expiry' => $this->input->post('passport_expiry'),
            'kitas_no' => $this->input->post('kitas_no'),
            'stm_no' => $this->input->post('stm_no'),
            'rptka_no' => $this->input->post('rptka_no'),
            'rptka_date' => $this->input->post('rptka_date'),
            'notifikasi_no' => $this->input->post('notifikasi_no'),
            'notifikasi_date' => $this->input->post('notifikasi_date'),
            'jabatan' => $this->input->post('jabatan'),
            'tempat_lahir' => $this->input->post('tempat_lahir'),
            'tanggal_lahir' => $this->input->post('tanggal_lahir'),
            'negara_asal' => $this->input->post('negara_asal'),
            'jenis_kelamin' => $this->input->post('jenis_kelamin'),
            'alamat_tinggal' => $this->input->post('alamat_tinggal'),
            'lokasi_kerja' => $this->input->post('lokasi_kerja'),
            'jenis_notifikasi' => $this->input->post('jenis_notifikasi'),
            'masa_berlaku_notifikasi' => $this->input->post('masa_berlaku_notifikasi'),
            'lunas_dkp' => $this->input->post('lunas_dkp'),
            'bidang_usaha' => $this->input->post('bidang_usaha')
        ];

        if($this->Tka_model->update_detail($id, $data)) {
            $this->Tka_model->update_status($id, 'MENUNGGU_KASI');
            $this->Approval_log_model->insert_with_sla(
                $id, 1, 'MENUNGGU_KASI', null, 'Pengajuan baru oleh perusahaan'
            );
            $this->session->set_flashdata('success', 'Data detail berhasil disimpan. Pengajuan masuk ke antrian verifikasi.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan data detail.');
        }
        redirect('user/data_tka');
    }

    // ========== PERBAIKI TKA YANG DITOLAK ==========
    public function perbaiki_tka($id) {
        $tka = $this->Tka_model->get_by_id($id);
        if(!$tka || $tka->user_id != $this->session->userdata('user_id')) show_404();
        if($tka->status != 'DITOLAK') {
            $this->session->set_flashdata('error', 'Pengajuan tidak dalam status ditolak.');
            redirect('user/data_tka');
        }
        $this->Tka_model->update_status($id, 'DRAFT');
        $this->session->set_flashdata('info', 'Silakan perbaiki data sesuai catatan penolakan, lalu simpan kembali.');
        redirect('user/edit_tka/'.$id);
    }

    // ========== EDIT TKA (MENAMPILKAN FORM) ==========
    public function edit_tka($id) {
        $tka = $this->Tka_model->get_by_id($id);
        if(!$tka || $tka->user_id != $this->session->userdata('user_id')) show_404();
        $data['tka'] = $tka;
        $data['berkas'] = $this->Berkas_model->get_by_tka($id);
        $this->load->view('user/edit_tka', $data);
    }

    // ========== UPDATE TKA (DATA DIRI) ==========
    public function update_tka($id) {
        $tka = $this->Tka_model->get_by_id($id);
        if(!$tka || $tka->user_id != $this->session->userdata('user_id')) show_404();
        if(!in_array($tka->status, ['DRAFT', 'MENUNGGU_KASI'])) {
            $this->session->set_flashdata('error', 'Data tidak dapat diubah karena pengajuan sudah diproses lebih lanjut.');
            redirect('user/data_tka');
        }

        $this->form_validation->set_rules('nama_tka', 'Nama TKA', 'required');
        if($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('user/edit_tka/'.$id);
        }

        $data = [
            'nama_tka' => $this->input->post('nama_tka'),
            'passport_no' => $this->input->post('passport_no'),
            'passport_expiry' => $this->input->post('passport_expiry'),
            'kitas_no' => $this->input->post('kitas_no'),
            'stm_no' => $this->input->post('stm_no'),
            'rptka_no' => $this->input->post('rptka_no'),
            'rptka_date' => $this->input->post('rptka_date'),
            'notifikasi_no' => $this->input->post('notifikasi_no'),
            'notifikasi_date' => $this->input->post('notifikasi_date'),
            'jabatan' => $this->input->post('jabatan'),
            'tempat_lahir' => $this->input->post('tempat_lahir'),
            'tanggal_lahir' => $this->input->post('tanggal_lahir'),
            'negara_asal' => $this->input->post('negara_asal'),
            'jenis_kelamin' => $this->input->post('jenis_kelamin'),
            'alamat_tinggal' => $this->input->post('alamat_tinggal'),
            'lokasi_kerja' => $this->input->post('lokasi_kerja'),
            'jenis_notifikasi' => $this->input->post('jenis_notifikasi'),
            'masa_berlaku_notifikasi' => $this->input->post('masa_berlaku_notifikasi'),
            'lunas_dkp' => $this->input->post('lunas_dkp'),
            'bidang_usaha' => $this->input->post('bidang_usaha')
        ];

        $this->Tka_model->update_detail($id, $data);
        
        $last_reject = $this->Approval_log_model->get_last_reject($id);
        if($last_reject && $tka->status == 'DRAFT') {
            $this->Tka_model->update_status($id, 'MENUNGGU_KASI');
            $this->Approval_log_model->insert_with_sla(
                $id, 1, 'MENUNGGU_KASI', null, 'Perbaikan setelah penolakan oleh ' . $last_reject->role
            );
            $this->session->set_flashdata('success', 'Data berhasil diperbaiki dan dikirim ulang ke antrian verifikasi.');
        } else {
            $this->session->set_flashdata('success', 'Data TKA berhasil diupdate.');
        }
        redirect('user/data_tka');
    }

    // ========== HAPUS TKA ==========
    public function delete_tka($id) {
        $tka = $this->Tka_model->get_by_id($id);
        if (!$tka) show_error('Data TKA tidak ditemukan.');
        if ($tka->status != 'DRAFT') show_error('Data tidak dapat dihapus karena sudah diverifikasi atau dalam proses.');
        $folder = FCPATH . 'uploads/' . $id;
        if (is_dir($folder)) $this->delete_directory($folder);
        $this->Tka_model->delete($id);
        $this->session->set_flashdata('success', 'Data TKA berhasil dihapus.');
        redirect('user/data_tka');
    }

    private function delete_directory($dir) {
        if (!is_dir($dir)) return;
        $items = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );
        foreach ($items as $item) {
            if ($item->isDir()) rmdir($item->getRealPath());
            else unlink($item->getRealPath());
        }
        rmdir($dir);
    }

    // ========== GANTI BERKAS (UPLOAD ULANG) ==========
    public function update_berkas($id) {
        $tka = $this->Tka_model->get_by_id($id);
        if(!$tka || $tka->user_id != $this->session->userdata('user_id')) show_404();
        if(!in_array($tka->status, ['DRAFT','MENUNGGU_KASI'])) {
            $this->session->set_flashdata('error', 'Tidak dapat mengganti berkas karena pengajuan sudah diproses lebih lanjut.');
            redirect('user/edit_tka/'.$id);
        }

        $upload_path = './uploads/'.$id.'/';
        if(!is_dir($upload_path)) mkdir($upload_path, 0777, true);

        $config['upload_path'] = $upload_path;
        $config['max_size'] = 2048;
        $config['file_ext_tolower'] = TRUE;
        $this->load->library('upload');

        $fields = ['surat_permohonan','passport','kitas','stm','rptka','notifikasi','bukti_bayar','surat_kuasa','ktp','foto'];
        $updated = false;

        foreach($fields as $field) {
            if(isset($_FILES[$field]) && $_FILES[$field]['error'] == 0) {
                if(in_array($field, ['ktp','foto'])) {
                    $config['allowed_types'] = 'jpg|jpeg|png';
                } else {
                    $config['allowed_types'] = 'pdf';
                }
                $config['file_name'] = $id.'_'.$field.'_'.time();
                $this->upload->initialize($config);
                if($this->upload->do_upload($field)) {
                    $file_name = $this->upload->data('file_name');
                    $old_file = $this->Berkas_model->get_field($id, $field);
                    if($old_file && file_exists($upload_path.$old_file)) {
                        unlink($upload_path.$old_file);
                    }
                    $this->Berkas_model->update_field($id, $field, $file_name);
                    $updated = true;
                } else {
                    $this->session->set_flashdata('error', "Gagal upload $field: " . $this->upload->display_errors('', ''));
                    redirect('user/edit_tka/'.$id);
                }
            }
        }

        if($updated) {
            $this->session->set_flashdata('success', 'Berkas berhasil diganti.');
        } else {
            $this->session->set_flashdata('info', 'Tidak ada file yang dipilih untuk diganti.');
        }
        redirect('user/edit_tka/'.$id);
    }

    // ========== NOTIFIKASI ==========
    public function get_notifications() {
        $this->load->model('Notification_model');
        $user_id = $this->session->userdata('user_id');
        $unread_count = $this->Notification_model->get_unread_count($user_id);
        $notifications = $this->Notification_model->get_recent($user_id, 10);
        echo json_encode(['unread_count' => $unread_count, 'notifications' => $notifications]);
    }

    public function mark_notification_read($id) {
        $this->load->model('Notification_model');
        $user_id = $this->session->userdata('user_id');
        $notif = $this->db->where('id', $id)->where('user_id', $user_id)->get('notifications')->row();
        $this->Notification_model->mark_as_read($id, $user_id);
        $referer = $this->input->server('HTTP_REFERER');
        if ($referer && strpos($referer, 'user/notifications') !== false) {
            redirect('user/notifications');
        } elseif ($notif && $notif->link) {
            redirect($notif->link);
        } else {
            redirect('dashboard');
        }
    }

    public function notifications() {
        $this->load->model('Notification_model');
        $user_id = $this->session->userdata('user_id');
        $data['notifications'] = $this->Notification_model->get_recent($user_id, 100);
        $data['unread_count'] = $this->Notification_model->get_unread_count($user_id);
        $this->load->view('user/notifications', $data);
    }

    public function mark_all_read() {
        $this->load->model('Notification_model');
        $user_id = $this->session->userdata('user_id');
        $this->Notification_model->mark_all_read($user_id);
        $this->session->set_flashdata('success', 'Semua notifikasi telah ditandai sudah dibaca.');
        redirect('user/notifications');
    }

    // ========== DOWNLOAD SURAT WORD ==========
    public function download_surat_word($id) {
        $tka = $this->Tka_model->get_by_id($id);
        if (!$tka) show_404();
        if ($tka->status != 'SELESAI') {
            $this->session->set_flashdata('error', 'Surat hanya dapat diunduh jika status sudah SELESAI.');
            redirect('user/data_tka');
        }
        if ($tka->surat_teks_approved != 1) {
            $this->session->set_flashdata('error', 'Surat belum disetujui oleh admin.');
            redirect('user/data_tka');
        }

        $user = $this->User_model->get_by_id($tka->user_id);
        $berkas = $this->Berkas_model->get_by_tka($id);
        $this->load->model('Surat_template_model');
        $tmpl = $this->Surat_template_model->get();

        $nomor_surat = !empty($tka->nomor_surat_manual)
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
            'alamat_perusahaan'        => $user->alamat,
            'tanggal_surat'            => $tanggal_surat,
            'kepala_dinas'             => $tmpl->kepala_dinas ?? 'Kepala Dinas',
            'nip_kepala_dinas'         => $tmpl->nip_kepala_dinas ?? '-',
            'nomor_surat_keluar'       => $tka->nomor_surat_keluar ?? '',
            'nomor_surat_permohonan'   => $tka->nomor_surat_permohonan ?? '',
        ];

        $image_data = [];
        $ttd_path = $this->Surat_template_model->get_ttd_path();
        if (!empty($ttd_path) && file_exists(FCPATH . $ttd_path)) {
            $image_data[] = [
                'placeholder' => 'ttd_kepala_dinas',
                'path'        => FCPATH . $ttd_path,
                'width'       => 150,
                'height'      => 75,
                'ratio'       => true,
            ];
        }

        $foto_path = FCPATH . 'uploads/' . $id . '/' . ($berkas->foto ?? '');
        if (file_exists($foto_path)) {
            $image_data[] = [
                'placeholder' => 'foto_path',
                'path'        => $foto_path,
                'width'       => 151,
                'height'      => 227,
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

    // ========== PROFILE & CHANGE PASSWORD ==========
    public function profile() {
        $data['user'] = $this->User_model->get_by_id($this->session->userdata('user_id'));
        $this->load->view('user/profile', $data);
    }

    public function change_password() {
        $this->form_validation->set_rules('current_password', 'Password Saat Ini', 'required');
        $this->form_validation->set_rules('new_password', 'Password Baru', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[new_password]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('user/profile');
        }

        $user_id = $this->session->userdata('user_id');
        $user = $this->User_model->get_by_id($user_id);
        if (!password_verify($this->input->post('current_password'), $user->password)) {
            $this->session->set_flashdata('error', 'Password saat ini salah.');
            redirect('user/profile');
        }

        $new_password = password_hash($this->input->post('new_password'), PASSWORD_DEFAULT);
        $this->User_model->update_password($user_id, $new_password);
        $this->session->set_flashdata('success', 'Password berhasil diubah.');
        redirect('user/profile');
    }

    public function update_profile() {
    $this->load->model('User_model');
    $data = [
        'nama'        => $this->input->post('nama'),
        'perusahaan'  => $this->input->post('perusahaan'),
        'no_hp'       => $this->input->post('no_hp'),
        'alamat'      => $this->input->post('alamat'),
    ];
    $this->User_model->update($this->session->userdata('user_id'), $data);
    $this->session->set_flashdata('success', 'Profil berhasil diperbarui.');
    redirect('user/profile');
    }
}
?>