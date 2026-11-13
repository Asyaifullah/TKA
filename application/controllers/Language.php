<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Language Controller
 * 
 * Menangani perpindahan bahasa.
 * URL: lang/switch/indonesian atau lang/switch/english
 */
class Language extends CI_Controller {

    private $available_languages = ['indonesian', 'english'];

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
    }

    /**
     * Switch language
     * 
     * @param string $lang 'indonesian' atau 'english'
     */
    public function switch_lang($lang = 'indonesian') {
        // Validasi bahasa
        if (!in_array($lang, $this->available_languages)) {
            $lang = 'indonesian';
        }

        // Simpan ke session
        $this->session->set_userdata('site_lang', $lang);

        // Redirect kembali ke halaman sebelumnya
        $referrer = $this->input->server('HTTP_REFERER');

        if (!empty($referrer) && strpos($referrer, base_url()) !== false) {
            redirect($referrer);
        } else {
            redirect(base_url());
        }
    }
}
