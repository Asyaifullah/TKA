<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notification_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function add($user_id, $title, $message, $link = null) {
        $data = [
            'user_id' => $user_id,
            'title' => $title,
            'message' => $message,
            'link' => $link,
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('notifications', $data);
        return $this->db->insert_id();
    }

    public function get_unread_count($user_id) {
        return $this->db->where('user_id', $user_id)->where('is_read', 0)->count_all_results('notifications');
    }

    public function get_recent($user_id, $limit = 10) {
        $this->db->where('user_id', $user_id);
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get('notifications')->result();
    }

    public function mark_as_read($id, $user_id) {
        $this->db->where('id', $id)->where('user_id', $user_id)->update('notifications', ['is_read' => 1]);
    }

    public function mark_all_read($user_id) {
        $this->db->where('user_id', $user_id)->update('notifications', ['is_read' => 1]);
    }

    
}
?>