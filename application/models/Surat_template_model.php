<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat_template_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get() {
        return $this->db->where('id', 1)->get('surat_template')->row();
    }

    public function update_template($data) {
        $this->db->where('id', 1)->update('surat_template', $data);
    }

    // ========== TAMBAHKAN DUA METHOD INI DI SINI ==========
    public function update_ttd($ttd_path) {
        $this->db->where('id', 1)->update('surat_template', ['ttd_path' => $ttd_path]);
    }

    public function get_ttd_path() {
        $row = $this->db->where('id', 1)->get('surat_template')->row();
        return $row ? $row->ttd_path : null;
    }
}
?>