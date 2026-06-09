<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH . 'vendor/autoload.php';
use PhpOffice\PhpWord\TemplateProcessor;

class Word_generator {
    public function generate($template_path, $data_text, $data_image = [], $output_filename = 'surat.docx') {
        if (!file_exists($template_path)) {
            throw new Exception("Template tidak ditemukan: " . $template_path);
        }
        
        $templateProcessor = new TemplateProcessor($template_path);
        
        // Ganti teks
        foreach ($data_text as $key => $value) {
            $templateProcessor->setValue($key, $value);
        }
        
        // Ganti gambar
    foreach ($data_image as $img) {
    if (!isset($img['placeholder']) || !isset($img['path'])) continue;
    if (file_exists($img['path'])) {
        $templateProcessor->setImageValue($img['placeholder'], [
            'path'   => $img['path'],
            'width'  => $img['width']  ?? 100,
            'height' => $img['height'] ?? 100,
            'ratio'  => $img['ratio']  ?? false,
        ]);
    } else {
        error_log("File gambar tidak ditemukan: " . $img['path']);
    }
}
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
        header('Content-Disposition: attachment; filename="' . $output_filename . '"');
        $templateProcessor->saveAs('php://output');
    }
}
?>