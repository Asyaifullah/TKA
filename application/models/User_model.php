<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_by_email($email) {
        return $this->db->get_where('users', ['email' => $email])->row();
    }

    public function insert($data) {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    public function get_by_id($id) {
        return $this->db->get_where('users', ['id' => (int)$id])->row();
    }

    public function update_password($id, $new_password) {
        $this->db->where('id', $id);
        return $this->db->update('users', ['password' => $new_password]);
    }

    public function count_users_by_role($role) {
        return $this->db->where('role', $role)->count_all_results('users');
    }

    public function get_all_users_by_role($role) {
        return $this->db->where('role', $role)->order_by('id', 'DESC')->get('users')->result();
    }

    public function update_user($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    public function delete_user($id) {
        // Hapus semua TKA dan berkas terkait
        $tka_list = $this->db->where('user_id', $id)->get('tka')->result();
        foreach($tka_list as $tka) {
            $folder = './uploads/'.$tka->id;
            if(is_dir($folder)) {
                $this->delete_directory($folder);
            }
            $this->db->where('id', $tka->id)->delete('tka');
        }
        $this->db->where('id', $id)->delete('users');
        return true;
    }

    private function delete_directory($dir) {
        if(!is_dir($dir)) return;
        $files = array_diff(scandir($dir), ['.','..']);
        foreach($files as $file) {
            (is_dir("$dir/$file")) ? $this->delete_directory("$dir/$file") : unlink("$dir/$file");
        }
        rmdir($dir);
    }

    public function get_all_officers_and_admins() {
        $this->db->where_in('role', ['kasi', 'kabid', 'sekdis', 'kadis', 'admin', 'operator']);
        $this->db->order_by('role', 'ASC');
        return $this->db->get('users')->result();
    }

    public function get_security_question($email) {
        $this->db->select('id, security_question, security_answer');
        $this->db->where('email', $email);
        return $this->db->get('users')->row();
    }

    public function update_password_by_email($email, $new_password) {
        $this->db->where('email', $email);
        return $this->db->update('users', ['password' => $new_password]);
    }

    // =========================================================================
    // METHOD TAMBAHAN UNTUK ADMIN CONTROLLER
    // =========================================================================

    /**
     * Alias dari count_users_by_role untuk konsistensi
     */
    public function count_by_role(string $role): int {
        return $this->count_users_by_role($role);
    }

    /**
     * Menghitung jumlah petugas berdasarkan beberapa role
     */
    public function count_officers(array $roles): int {
        return $this->db->where_in('role', $roles)->count_all_results('users');
    }

    /**
     * Mengambil semua perusahaan (role user)
     */
    public function get_all_companies(): array {
        return $this->get_all_users_by_role('user');
    }

    public function update($user_id, $data){
    if (empty($user_id) || empty($data)) {
        return false;
    }

    // Pastikan hanya field yang diizinkan yang bisa diupdate
    $allowed = ['nama', 'perusahaan', 'no_hp', 'alamat', 'password'];
    $filtered = [];
    foreach ($data as $key => $value) {
        if (in_array($key, $allowed)) {
            $filtered[$key] = $value;
        }
    }

    if (empty($filtered)) {
        return false;
    }

    // Tambahkan timestamp update
    $filtered['updated_at'] = date('Y-m-d H:i:s');

    $this->db->where('id', $user_id);
    return $this->db->update('users', $filtered);
    }
}