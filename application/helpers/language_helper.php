<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Language Helper — SITLAKEB TKA
 * 
 * Fungsi shortcut untuk multi-language system.
 */

if (!function_exists('lang_line')) {
    /**
     * Ambil teks terjemahan berdasarkan key
     * 
     * @param string $key Language key
     * @param string $default Fallback jika key tidak ditemukan
     * @return string
     */
    function lang_line($key, $default = '') {
        $CI =& get_instance();
        $line = $CI->lang->line($key);
        
        if ($line === false || $line === '') {
            return !empty($default) ? $default : $key;
        }
        
        return $line;
    }
}

if (!function_exists('current_lang')) {
    /**
     * Ambil bahasa aktif saat ini
     * 
     * @return string 'indonesian' atau 'english'
     */
    function current_lang() {
        $CI =& get_instance();
        $lang = $CI->session->userdata('site_lang');
        return !empty($lang) ? $lang : 'indonesian';
    }
}

if (!function_exists('is_lang')) {
    /**
     * Cek apakah bahasa aktif adalah bahasa tertentu
     * 
     * @param string $lang 'indonesian' atau 'english'
     * @return bool
     */
    function is_lang($lang) {
        return current_lang() === $lang;
    }
}

if (!function_exists('lang_url')) {
    /**
     * Generate URL untuk switch bahasa
     * 
     * @param string $lang 'indonesian' atau 'english'
     * @return string Full URL
     */
    function lang_url($lang) {
        $CI =& get_instance();
        return base_url('lang/switch/' . $lang);
    }
}
