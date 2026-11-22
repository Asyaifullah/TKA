<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_log_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function add_log($data) {
        // Kolom target_type & target_id NOT NULL di DB — beri default kalau kosong
        $data['target_type'] = $data['target_type'] ?? 'system';
        $data['target_id']   = $data['target_id'] ?? 0;

        $this->db->insert('admin_logs', $data);
        return $this->db->insert_id();
    }

    public function get_all_logs($limit = 200, $offset = 0) {
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get('admin_logs')->result();
    }

    public function count_logs() {
        return $this->db->count_all('admin_logs');
    }
}