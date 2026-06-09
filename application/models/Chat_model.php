<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chat_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Kirim pesan
    public function send_message($from, $to, $message) {
        $data = [
            'from_user_id' => $from,
            'to_user_id'   => $to,
            'message'      => $message,
            'created_at'   => date('Y-m-d H:i:s')
        ];
        $this->db->insert('chat_messages', $data);
        return $this->db->insert_id();
    }

    // Ambil percakapan antara dua user
    public function get_conversation($user1, $user2, $limit = 100) {
        $this->db->where("(from_user_id = $user1 AND to_user_id = $user2) OR (from_user_id = $user2 AND to_user_id = $user1)");
        $this->db->order_by('created_at', 'ASC');
        $this->db->limit($limit);
        return $this->db->get('chat_messages')->result();
    }

    // Tandai pesan dari user ke admin sudah dibaca oleh admin
    public function mark_as_read_admin($from_user_id, $to_admin_id) {
        $this->db->where('from_user_id', $from_user_id);
        $this->db->where('to_user_id', $to_admin_id);
        $this->db->update('chat_messages', ['is_read_admin' => 1]);
    }

    // Tandai pesan dari admin ke user sudah dibaca oleh user
    public function mark_as_read_user($from_admin_id, $to_user_id) {
        $this->db->where('from_user_id', $from_admin_id);
        $this->db->where('to_user_id', $to_user_id);
        $this->db->update('chat_messages', ['is_read_user' => 1]);
    }

    // Jumlah pesan belum dibaca oleh admin
    public function count_unread_admin($admin_id) {
        return $this->db->where('to_user_id', $admin_id)
                        ->where('is_read_admin', 0)
                        ->count_all_results('chat_messages');
    }

    // Jumlah pesan belum dibaca oleh user
    public function count_unread_user($user_id) {
        return $this->db->where('to_user_id', $user_id)
                        ->where('is_read_user', 0)
                        ->count_all_results('chat_messages');
    }

    // Ambil daftar perusahaan (user) yang pernah chat dengan admin, lengkap dengan pesan terakhir, waktu, dan unread count
    public function get_users_with_last_message($admin_id) {
        // Ambil semua user dengan role 'user'
        $users = $this->db->select('id, nama, perusahaan')
                          ->where('role', 'user')
                          ->get('users')->result();

        foreach ($users as $user) {
            // Pesan terakhir antara admin dan user ini
            $sql = "SELECT message, created_at, from_user_id FROM chat_messages 
                    WHERE (from_user_id = ? AND to_user_id = ?) OR (from_user_id = ? AND to_user_id = ?)
                    ORDER BY created_at DESC LIMIT 1";
            $last = $this->db->query($sql, [$admin_id, $user->id, $user->id, $admin_id])->row();

            $user->last_message = $last ? $last->message : '';
            $user->last_message_time = $last ? $last->created_at : '0000-00-00 00:00:00';
            $user->last_message_from_me = ($last && $last->from_user_id == $admin_id);

            // Hitung pesan belum dibaca oleh admin (dari user ke admin, is_read_admin = 0)
            $unread = $this->db->select('COUNT(*) as unread')
                               ->from('chat_messages')
                               ->where('to_user_id', $admin_id)
                               ->where('from_user_id', $user->id)
                               ->where('is_read_admin', 0)
                               ->get()->row();
            $user->unread_count = $unread ? (int)$unread->unread : 0;
        }
        return $users;
    }
}
?>