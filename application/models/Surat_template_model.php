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

    public function update_template($data)
    {
        // Cek apakah sudah ada baris data di tabel surat_template
        $cek_data = $this->db->get('surat_template')->num_rows();

        if ($cek_data > 0) {
            // Jika sudah ada isinya, lakukan UPDATE
            return $this->db->update('surat_template', $data);
        } else {
            // Jika tabel masih benar-benar kosong, lakukan INSERT
            return $this->db->insert('surat_template', $data);
        }
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