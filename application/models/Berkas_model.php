<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berkas_model extends CI_Model {
    public function insert($data) {
        $this->db->insert('berkas', $data);
    }
    public function get_by_tka($tka_id) {
        return $this->db->get_where('berkas', ['tka_id' => $tka_id])->row();
    }

    public function get_field($tka_id, $field) {
    $row = $this->db->get_where('berkas', ['tka_id' => $tka_id])->row();
    return $row->$field ?? null;
    }

public function update_field($tka_id, $field, $value) {
    $this->db->where('tka_id', $tka_id);
    return $this->db->update('berkas', [$field => $value]);
    }
}