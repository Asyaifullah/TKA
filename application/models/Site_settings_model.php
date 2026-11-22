<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Site_settings_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get() {
        return $this->db->where('id', 1)->get('site_settings')->row();
    }

    public function update_footer($footer_text) {
        $this->db->where('id', 1)->update('site_settings', ['footer_text' => $footer_text]);
    }
}
?>