<?php
// File: application/helpers/my_helper.php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Mendapatkan label status TKA yang mudah dipahami
 * @param string $status
 * @return string
 */
function label_status_tka($status) {
    $labels = STATUS_LABEL;
    return isset($labels[$status]) ? $labels[$status] : $status;
}

/**
 * Menghitung progress approval dalam persen (0-100)
 * @param object|array $tka_row
 * @return int
 */
function progress_persen($tka_row) {
    $status = is_object($tka_row) ? $tka_row->status : $tka_row['status'];
    if ($status == 'SELESAI') return 100;
    if ($status == 'DITOLAK') return 0;
    if ($status == 'DRAFT' || $status == 'REVISI') return 0;
    
    $map = [
        'MENUNGGU_KASI' => 0,
        'MENUNGGU_KABID' => 25,
        'MENUNGGU_SEKDIS' => 50,
        'MENUNGGU_KADIS' => 75,
    ];
    
    return isset($map[$status]) ? $map[$status] : 0;
}

/**
 * Menghasilkan string sisa waktu yang mudah dibaca
 * @param string $deadline DateTime string
 * @return string
 */
function sisa_waktu_label($deadline) {
    if (empty($deadline)) return '';
    
    $now = new DateTime();
    $dead = new DateTime($deadline);
    
    if ($now > $dead) {
        return 'Melewati batas waktu';
    }
    
    $diff = $now->diff($dead);
    if ($diff->days > 0) {
        return $diff->days . ' hari ' . $diff->h . ' jam lagi';
    } elseif ($diff->h > 0) {
        return $diff->h . ' jam ' . $diff->i . ' menit lagi';
    } else {
        return $diff->i . ' menit lagi';
    }
}