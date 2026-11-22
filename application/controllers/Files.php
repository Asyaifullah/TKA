<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Menyajikan berkas unggahan (/uploads/...) setelah memeriksa login.
 * Sumber utama: Supabase Storage. Cadangan: folder uploads/ di server (berkas lama).
 */
class Files extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            show_404();
        }
    }

    public function serve() {
        $segments = $this->uri->segment_array(); // contoh: [uploads, 49, 49_foto_123.jpg]
        $segments = array_map('rawurldecode', $segments);
        $path = implode('/', $segments);

        if (count($segments) < 3 || strpos($path, '..') !== FALSE || strpos($path, "\0") !== FALSE) {
            show_404();
        }

        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        if (!in_array($ext, array('pdf', 'jpg', 'jpeg', 'png'))) {
            show_404();
        }

        // Perusahaan hanya boleh membuka berkas pengajuannya sendiri
        $folder = $segments[1];
        if ($this->session->userdata('role') == 'user' && ctype_digit($folder)) {
            $this->load->model('Tka_model');
            $tka = $this->Tka_model->get_by_id($folder);
            if (!$tka || $tka->user_id != $this->session->userdata('user_id')) {
                show_404();
            }
        }

        $body = NULL;
        $this->load->library('supabase_storage');
        $file = $this->supabase_storage->get($path);
        if ($file !== FALSE) {
            $body = $file['body'];
        } elseif (is_file(FCPATH . $path)) {
            $body = file_get_contents(FCPATH . $path);
        }

        if ($body === NULL) {
            show_404();
        }

        $this->load->helper('file');
        $mime = get_mime_by_extension($path) ?: 'application/octet-stream';

        $this->output
            ->set_content_type($mime)
            ->set_header('Content-Disposition: inline; filename="' . basename($path) . '"')
            ->set_header('X-Content-Type-Options: nosniff')
            ->set_output($body);
    }
}