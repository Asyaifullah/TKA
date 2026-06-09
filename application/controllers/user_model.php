<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    public function get_by_email($email) {
        return $this->db->get_where('users', ['email' => $email])->row();
    }
    public function insert($data) {
        $this->db->insert('users', $data);
    }
    // Halaman profil user
    public function profile() {
    $user_id = $this->session->userdata('user_id');
    $data['user'] = $this->User_model->get_by_id($user_id);
    $this->load->view('user/profile', $data);
    }

// Proses ganti password
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
    $current_password = $this->input->post('current_password');

    if (!password_verify($current_password, $user->password)) {
        $this->session->set_flashdata('error', 'Password saat ini salah.');
        redirect('user/profile');
    }

    $new_password = password_hash($this->input->post('new_password'), PASSWORD_DEFAULT);
    $this->User_model->update_password($user_id, $new_password);

    // Update session password jika perlu (opsional)
    $this->session->set_flashdata('success', 'Password berhasil diubah.');
    redirect('user/profile');
    }
    public function update_password_by_email($email, $new_hash) {
    $this->db->where('email', $email);
    return $this->db->update('users', ['password' => $new_hash]);
    }
}