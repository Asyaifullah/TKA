<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Penyimpanan berkas di Supabase Storage (bucket privat).
 * Aktif hanya jika environment variable SUPABASE_URL dan SUPABASE_KEY terisi
 * (di Vercel). Di lokal, enabled() bernilai FALSE dan folder uploads/ dipakai.
 */
class Supabase_storage {

    private $url;
    private $key;
    private $bucket;

    public function __construct() {
        $this->url    = rtrim((string) getenv('SUPABASE_URL'), '/');
        $this->key    = (string) getenv('SUPABASE_KEY');
        $this->bucket = getenv('SUPABASE_BUCKET') ?: 'berkas';
    }

    public function enabled() {
        return $this->url !== '' && $this->key !== '';
    }

    private function headers($extra = array()) {
        $h = array('apikey: ' . $this->key);
        // Key format baru (sb_secret_...) bukan JWT, jadi hanya dikirim lewat apikey.
        if (strpos($this->key, 'sb_') !== 0) {
            $h[] = 'Authorization: Bearer ' . $this->key;
        }
        return array_merge($h, $extra);
    }

    private function encode_path($path) {
        return implode('/', array_map('rawurlencode', explode('/', trim($path, '/'))));
    }

    /**
     * Unggah file lokal ke bucket. $remote_path contoh: uploads/12/12_foto_123.jpg
     */
    public function upload($local_file, $remote_path, $mime = 'application/octet-stream') {
        if (!$this->enabled() || !is_file($local_file)) return FALSE;

        $endpoint = $this->url . '/storage/v1/object/' . $this->bucket . '/' . $this->encode_path($remote_path);
        $ch = curl_init($endpoint);
        curl_setopt_array($ch, array(
            CURLOPT_POST           => TRUE,
            CURLOPT_POSTFIELDS     => file_get_contents($local_file),
            CURLOPT_HTTPHEADER     => $this->headers(array('Content-Type: ' . $mime, 'x-upsert: true')),
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT        => 30,
        ));
        curl_exec($ch);
        $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($code < 200 || $code >= 300) {
            log_message('error', 'Supabase upload gagal (' . $code . '): ' . $remote_path);
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Ambil isi file dari bucket. Mengembalikan array(body, mime) atau FALSE.
     */
    public function get($remote_path) {
        if (!$this->enabled()) return FALSE;

        $endpoint = $this->url . '/storage/v1/object/authenticated/' . $this->bucket . '/' . $this->encode_path($remote_path);
        $ch = curl_init($endpoint);
        curl_setopt_array($ch, array(
            CURLOPT_HTTPHEADER     => $this->headers(),
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT        => 30,
        ));
        $body = curl_exec($ch);
        $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $mime = (string) curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        curl_close($ch);

        if ($code !== 200 || $body === FALSE) return FALSE;
        return array('body' => $body, 'mime' => $mime ?: 'application/octet-stream');
    }

    /**
     * Unduh file dari bucket ke path lokal (misalnya /tmp). Mengembalikan TRUE/FALSE.
     */
    public function download($remote_path, $local_file) {
        $file = $this->get($remote_path);
        if ($file === FALSE) return FALSE;
        $dir = dirname($local_file);
        if (!is_dir($dir)) mkdir($dir, 0777, TRUE);
        return file_put_contents($local_file, $file['body']) !== FALSE;
    }

    /**
     * Hapus satu file dari bucket.
     */
    public function delete($remote_path) {
        if (!$this->enabled()) return FALSE;

        $endpoint = $this->url . '/storage/v1/object/' . $this->bucket;
        $ch = curl_init($endpoint);
        curl_setopt_array($ch, array(
            CURLOPT_CUSTOMREQUEST  => 'DELETE',
            CURLOPT_POSTFIELDS     => json_encode(array('prefixes' => array(ltrim($remote_path, '/')))),
            CURLOPT_HTTPHEADER     => $this->headers(array('Content-Type: application/json')),
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_TIMEOUT        => 30,
        ));
        curl_exec($ch);
        $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $code >= 200 && $code < 300;
    }
}