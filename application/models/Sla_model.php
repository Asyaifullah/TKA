<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sla_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        // Pastikan database sudah diload (jika tidak autoload)
        if (!isset($this->db)) {
            $this->load->database();
        }
    }

    public function get_all() {
        $query = $this->db->order_by('level', 'ASC')->get('approval_sla');
        return $query->result();
    }

    public function get_by_level($level) {
        return $this->db->where('level', $level)->get('approval_sla')->row();
    }

    public function update($level, $data) {
        $this->db->where('level', $level);
        return $this->db->update('approval_sla', $data);
    }

    // ========== METHOD BARU ==========
    public function update_batch($data) {
        return $this->db->update_batch('approval_sla', $data, 'id');
    }
}