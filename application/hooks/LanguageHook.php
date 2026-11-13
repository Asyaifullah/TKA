<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * LanguageHook — Pre-Controller Hook
 * 
 * Set CI language config dari session sebelum controller di-load.
 * Ini memastikan bahasa sudah diset sebelum MY_Controller construct dipanggil.
 */
function set_language() {
    $CI =& get_instance();
    
    // Cek apakah session sudah ready
    if (isset($CI->session)) {
        $site_lang = $CI->session->userdata('site_lang');
        
        if (!empty($site_lang) && in_array($site_lang, ['indonesian', 'english'])) {
            $CI->config->set_item('language', $site_lang);
        } else {
            $CI->config->set_item('language', 'indonesian');
        }
    }
}
