<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH . 'vendor/autoload.php';

use PhpOffice\PhpWord\IOFactory;
use Dompdf\Dompdf;
use Dompdf\Options;

class Word_to_pdf {

    private $CI;
    private $template_path;
    private $temp_path;

    public function __construct() {
        $this->CI =& get_instance();
        $this->temp_path = FCPATH . 'uploads/temp/';
        if (!is_dir($this->temp_path)) {
            mkdir($this->temp_path, 0777, true);
        }
    }

    public function set_template($path) {
        $this->template_path = $path;
        return $this;
    }

    public function generate_pdf($text_data, $image_data = [], $output_filename = 'surat.pdf') {
        if (!$this->template_path || !file_exists($this->template_path)) {
            throw new Exception("Template Word tidak ditemukan: " . $this->template_path);
        }

        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($this->template_path);

        foreach ($text_data as $key => $value) {
            $templateProcessor->setValue($key, $value);
        }

        foreach ($image_data as $placeholder => $image_path) {
            if (file_exists($image_path)) {
                $templateProcessor->setImageValue($placeholder, $image_path);
            }
        }

        $temp_docx = $this->temp_path . uniqid() . '.docx';
        $templateProcessor->saveAs($temp_docx);

        $phpWord = IOFactory::load($temp_docx);
        $htmlWriter = IOFactory::createWriter($phpWord, 'HTML');
        $temp_html = $this->temp_path . uniqid() . '.html';
        $htmlWriter->save($temp_html);

        $html_content = file_get_contents($temp_html);
        $html_content = mb_convert_encoding($html_content, 'HTML-ENTITIES', 'UTF-8');

        // Langsung generate PDF dengan Dompdf (tanpa Pdf_generator)
        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html_content);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream($output_filename, array("Attachment"=>1));

        unlink($temp_docx);
        unlink($temp_html);
    }
}
?>