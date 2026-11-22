<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * MY_Controller — Base controller untuk SITLAKEB TKA
 * 
 * Menangani:
 * 1. Auto-load bahasa dari session
 * 2. Set CI config language secara dinamis
 * 3. Load semua language files
 * 4. Pass current_lang ke semua views
 */
class MY_Controller extends CI_Controller {

    protected $current_lang;
    protected $available_languages = ['indonesian', 'english'];

    public function __construct() {
        parent::__construct();
        $this->db->query("SET time_zone = '+07:00'");

        // Ambil bahasa dari session, default: indonesian
        $this->current_lang = $this->session->userdata('site_lang');

        if (empty($this->current_lang) || !in_array($this->current_lang, $this->available_languages)) {
            $this->current_lang = 'indonesian';
            $this->session->set_userdata('site_lang', 'indonesian');
        }

        // Set CI config language
        $this->config->set_item('language', $this->current_lang);

        // Load semua language files
        $lang_files = [
            'common',
            'auth',
            'dashboard',
            'sidebar',
            'tka',
            'admin',
            'approval',
            'notification',
            'chat',
            'user',
            'validation',
            'layout'
        ];

        foreach ($lang_files as $file) {
            $this->lang->load($file, $this->current_lang);
        }
    }
}
