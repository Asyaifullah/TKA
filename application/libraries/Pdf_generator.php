<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH . 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

class Pdf_generator {
    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->model(['Tka_model', 'Berkas_model', 'User_model', 'Surat_template_model']);
    }

    public function generate($tka_id) {
        $this->CI->load->library('Word_to_pdf');

        $tka = $this->CI->Tka_model->get_by_id($tka_id);
        if (!$tka) show_error('Data TKA tidak ditemukan');

        $user            = $this->CI->User_model->get_by_id($tka->user_id);
        $berkas          = $this->CI->Berkas_model->get_by_tka($tka_id);
        $template_surat  = $this->CI->Surat_template_model->get();

        // Nomor surat
        if (!empty($tka->nomor_surat_manual)) {
            $nomor_surat = $tka->nomor_surat_manual;
        } else {
            $nomor_surat = str_replace(
                ['{id}', '{tahun}'],
                [$tka_id, date('Y')],
                $template_surat->nomor_surat_format ?? '503/{id}/DISNAKER/{tahun}'
            );
        }

        // Tanggal surat
        if (!empty($tka->tanggal_surat_manual)) {
            $tanggal_surat = date('d-m-Y', strtotime($tka->tanggal_surat_manual));
        } else {
            $tanggal_surat = date('d-m-Y');
        }

        $text_data = [
            'perusahaan'               => $user->perusahaan,
            'nomor_surat'              => $nomor_surat,
            'nama_pic'                 => $user->nama,
            'tanggal_surat_permohonan' => date('d-m-Y', strtotime($tka->created_at)),
            'nama_tka'                 => $tka->nama_tka,
            'jenis_kelamin'            => $tka->jenis_kelamin ?? '-',
            'tempat_lahir'             => $tka->tempat_lahir ?? '-',
            'tanggal_lahir'            => $tka->tanggal_lahir ? date('d-m-Y', strtotime($tka->tanggal_lahir)) : '-',
            'kebangsaan'               => $tka->negara_asal ?? '-',
            'jabatan'                  => $tka->jabatan ?? '-',
            'passport_no'              => $tka->passport_no ?? '-',
            'passport_expiry'          => $tka->passport_expiry ? date('d-m-Y', strtotime($tka->passport_expiry)) : '-',
            'kitas_no'                 => $tka->kitas_no ?? '-',
            'rptka_no'                 => $tka->rptka_no ?? '-',
            'rptka_date'               => $tka->rptka_date ? date('d-m-Y', strtotime($tka->rptka_date)) : '-',
            'notifikasi_no'            => $tka->notifikasi_no ?? '-',
            'notifikasi_date'          => $tka->notifikasi_date ? date('d-m-Y', strtotime($tka->notifikasi_date)) : '-',
            'jenis_notifikasi'         => $tka->jenis_notifikasi ?? '-',
            'masa_berlaku_notifikasi'  => $tka->masa_berlaku_notifikasi ?? '-',
            'lunas_dkp'                => $tka->lunas_dkp ?? '-',
            'lokasi_kerja'             => $tka->lokasi_kerja ?? '-',
            'alamat_tinggal'           => $tka->alamat_tinggal ?? '-',
            'bidang_usaha'             => $tka->bidang_usaha ?? '-',
            'alamat_perusahaan'        => $user->alamat,
            'tanggal_surat'            => $tanggal_surat,
            'kepala_dinas'             => $template_surat->kepala_dinas ?? 'Kepala Dinas',
            'nip_kepala_dinas'         => $template_surat->nip_kepala_dinas ?? '-',
        ];

        $image_data = [];
        $foto_path  = FCPATH . 'uploads/' . $tka_id . '/' . $berkas->foto;
        if (file_exists($foto_path)) {
            $image_data['foto_path'] = $foto_path;
        }

        $this->CI->word_to_pdf
            ->set_template(FCPATH . 'application/templates/template_surat.docx')
            ->generate_pdf($text_data, $image_data, 'Surat_TKA_' . $tka->nama_tka . '.pdf');
    }

    /**
     * Generate PDF dari HTML string.
     *
     * Perbaikan utama vs versi lama:
     *
     * 1. isRemoteEnabled = FALSE — logo di-embed sebagai base64 di dalam HTML
     *    (lihat helper _embed_local_images di bawah), bukan di-fetch via URL.
     *    Fetching base_url() dari dalam server sendiri sering gagal karena
     *    localhost tidak bisa resolve dirinya → logo hilang → kop berantakan.
     *
     * 2. isHtml5ParserEnabled = TRUE — parser HTML5 Dompdf lebih toleran
     *    terhadap CSS modern (display:table, border-collapse, padding pada <hr>).
     *    Parser lama (default) sering salah render tabel dan hr.
     *
     * 3. defaultFont = 'DejaVu Sans' — font ini SELALU tersedia di dompdf
     *    (sudah include di package). 'Arial' TIDAK tersedia kecuali kamu
     *    install sendiri, sehingga dompdf fallback ke Courier yang merusak
     *    spacing dan lebar kolom tabel.
     *
     * 4. chroot = FCPATH — membatasi akses file dompdf hanya ke dalam project,
     *    sekaligus memungkinkan load file lokal (gambar, font) dengan benar.
     *
     * 5. Orientation bisa diatur dari parameter (portrait/landscape).
     *
     * @param  string $html         HTML string yang sudah di-render
     * @param  string $filename     Nama file output, contoh: 'Laporan_April_2026.pdf'
     * @param  string $orientation  'portrait' atau 'landscape'
     */
    public function generate_from_html($html, $filename, $orientation = 'portrait') {

        // ── 1. Embed semua gambar lokal sebagai base64 ──────────────────────
        //    Ganti src="http://..." atau src="/path/..." dengan data URI
        //    supaya dompdf tidak perlu fetch via HTTP sama sekali.
        $html = $this->_embed_local_images($html);

        // ── 2. Konfigurasi Dompdf ──────────────────────────────────────────
        $options = new Options();

        // Font default yang SELALU ada di dompdf — jangan pakai 'Arial'
        $options->set('defaultFont', 'DejaVu Sans');

        // Parser HTML5 = lebih akurat untuk CSS tabel dan layout modern
        $options->set('isHtml5ParserEnabled', true);

        // MATIKAN remote — kita sudah embed gambar sebagai base64 di atas
        $options->set('isRemoteEnabled', false);

        // Batasi akses file ke dalam folder project saja
        $options->set('chroot', FCPATH);

        // ── 3. Render ──────────────────────────────────────────────────────
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A4', $orientation);
        $dompdf->render();

        // ── 4. Stream ke browser sebagai download ─────────────────────────
        $dompdf->stream($filename, ['Attachment' => 1]);
        exit;
    }

    /**
     * Ubah semua tag <img src="..."> yang menunjuk ke file lokal
     * menjadi data URI (base64) supaya dompdf tidak perlu koneksi HTTP.
     *
     * Menangani 3 format src:
     *   a) http://localhost/myapp/assets/images/logo.png  (base_url)
     *   b) /myapp/assets/images/logo.png                  (root-relative)
     *   c) /absolute/path/on/disk/logo.png                (path absolut, jarang)
     */
    private function _embed_local_images($html) {
        return preg_replace_callback(
            '/<img([^>]*?)src=["\']([^"\']+)["\']([^>]*?)>/i',
            function ($matches) {
                $before = $matches[1];
                $src    = $matches[2];
                $after  = $matches[3];

                $file_path = $this->_resolve_path($src);

                if ($file_path && file_exists($file_path) && is_file($file_path)) {
                    $mime = $this->_mime_type($file_path);
                    $b64  = base64_encode(file_get_contents($file_path));
                    $data_uri = 'data:' . $mime . ';base64,' . $b64;
                    return '<img' . $before . 'src="' . $data_uri . '"' . $after . '>';
                }

                // Tidak bisa resolve → biarkan apa adanya (dompdf akan skip)
                return $matches[0];
            },
            $html
        );
    }

    /**
     * Resolve src URL/path ke path absolut di filesystem.
     */
    private function _resolve_path($src) {
        // Sudah data URI → skip
        if (strpos($src, 'data:') === 0) {
            return null;
        }

        // URL penuh (http / https) → coba petakan ke FCPATH
        if (preg_match('#^https?://#i', $src)) {
            $base = base_url();
            if (strpos($src, $base) === 0) {
                // http://localhost/myapp/assets/... → assets/...
                $relative = substr($src, strlen($base));
                return rtrim(FCPATH, '/') . '/' . ltrim($relative, '/');
            }
            return null; // domain lain → skip
        }

        // Root-relative path (diawali /)
        if ($src[0] === '/') {
            return rtrim(FCPATH, '/') . $src;
        }

        // Path relatif biasa
        return rtrim(FCPATH, '/') . '/' . ltrim($src, '/');
    }

    /**
     * Deteksi MIME type gambar berdasarkan ekstensi.
     */
    private function _mime_type($path) {
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $map = [
            'png'  => 'image/png',
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif'  => 'image/gif',
            'svg'  => 'image/svg+xml',
            'webp' => 'image/webp',
        ];
        return $map[$ext] ?? 'image/png';
    }
}