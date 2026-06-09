<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\{Fill, Border, Alignment, Font};
use PhpOffice\PhpSpreadsheet\Style\Border as B;

class Excel_generator {

    // Warna tema (hijau kebiruan sesuai UI kamu)
    const COLOR_HEADER_BG  = 'FF1e6f5c'; // hijau tua
    const COLOR_HEADER_FG  = 'FFFFFFFF'; // putih
    const COLOR_SUBHEAD_BG = 'FFe8f5f1'; // hijau muda
    const COLOR_SUBHEAD_FG = 'FF1e6f5c';
    const COLOR_ROW_ALT    = 'FFf8fffe'; // baris selang-seling
    const COLOR_BORDER     = 'FFd1e7e0';

    // Badge warna per status
    const STATUS_COLORS = [
        'SELESAI'          => ['bg' => 'FFdcfce7', 'fg' => 'FF15803d'],
        'DITOLAK'          => ['bg' => 'FFfee2e2', 'fg' => 'FFb91c1c'],
        'DRAFT'            => ['bg' => 'FFf1f5f9', 'fg' => 'FF475569'],
        'MENUNGGU_KASI'    => ['bg' => 'FFe0f2fe', 'fg' => 'FF0369a1'],
        'MENUNGGU_KABID'   => ['bg' => 'FFe0f2fe', 'fg' => 'FF0369a1'],
        'MENUNGGU_SEKDIS'  => ['bg' => 'FFe0f2fe', 'fg' => 'FF0369a1'],
        'MENUNGGU_KADIS'   => ['bg' => 'FFe0f2fe', 'fg' => 'FF0369a1'],
    ];

    public function generate_perusahaan(array $data, string $filename = 'Data_Perusahaan'): void
{
    $spread = new Spreadsheet();
    $sheet  = $spread->getActiveSheet();
    $sheet->setTitle('Data Perusahaan');

    $totalRows = count($data);
    $now       = date('d F Y, H:i') . ' WIB';

    /* ── Baris 1: Judul ── */
    $sheet->mergeCells('A1:G1');
    $sheet->setCellValue('A1', 'LAPORAN DATA PERUSAHAAN PENGGUNA TKA');
    $sheet->getStyle('A1')->applyFromArray([
        'font'      => ['bold' => true, 'size' => 14, 'color' => ['argb' => self::COLOR_HEADER_FG], 'name' => 'Arial'],
        'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => self::COLOR_HEADER_BG]],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
    ]);
    $sheet->getRowDimension(1)->setRowHeight(36);

    /* ── Baris 2: Sub info ── */
    $sheet->mergeCells('A2:G2');
    $sheet->setCellValue('A2', 'Dinas Ketenagakerjaan  |  Diekspor: ' . $now . '  |  Total: ' . $totalRows . ' perusahaan');
    $sheet->getStyle('A2')->applyFromArray([
        'font'      => ['italic' => true, 'size' => 9, 'color' => ['argb' => self::COLOR_SUBHEAD_FG], 'name' => 'Arial'],
        'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => self::COLOR_SUBHEAD_BG]],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
    ]);
    $sheet->getRowDimension(2)->setRowHeight(20);

    /* ── Baris 3: Spacer ── */
    $sheet->getRowDimension(3)->setRowHeight(8);

    /* ── Baris 4: Header kolom ── */
    $headers = ['No', 'Nama Perusahaan', 'PIC / Nama', 'Email', 'No. HP', 'Alamat', 'Status'];
    $cols    = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];

    foreach ($headers as $i => $h) {
        $cell = $cols[$i] . '4';
        $sheet->setCellValue($cell, $h);
        $sheet->getStyle($cell)->applyFromArray([
            'font'      => ['bold' => true, 'size' => 10, 'color' => ['argb' => self::COLOR_HEADER_FG], 'name' => 'Arial'],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => self::COLOR_HEADER_BG]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => B::BORDER_THIN, 'color' => ['argb' => 'FF1e6f5c']]],
        ]);
    }
    $sheet->getRowDimension(4)->setRowHeight(22);

    /* ── Baris data ── */
    foreach ($data as $no => $p) {
        $row   = $no + 5;
        $isAlt = ($no % 2 === 1);
        $rowBg = $isAlt ? self::COLOR_ROW_ALT : 'FFFFFFFF';

        $isAktif     = isset($p->is_active) && $p->is_active == 1;
        $statusLabel = $isAktif ? 'Aktif' : 'Nonaktif';
        $statusBg    = $isAktif ? 'FFdcfce7' : 'FFfee2e2';
        $statusFg    = $isAktif ? 'FF15803d' : 'FFb91c1c';

        $rowData = [
            'A' => $no + 1,
            'B' => $p->perusahaan,
            'C' => $p->nama,
            'D' => $p->email,
            'E' => $p->no_hp,
            'F' => $p->alamat,
            'G' => $statusLabel,
        ];

        foreach ($rowData as $col => $val) {
            $cell = $col . $row;
            $sheet->setCellValue($cell, $val);

            $styleArr = [
                'font'      => ['size' => 9, 'name' => 'Arial'],
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $rowBg]],
                'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                'borders'   => ['allBorders' => ['borderStyle' => B::BORDER_THIN, 'color' => ['argb' => self::COLOR_BORDER]]],
            ];

            if ($col === 'A') {
                $styleArr['alignment']['horizontal'] = Alignment::HORIZONTAL_CENTER;
            }

            // Kolom Alamat: wrap text
            if ($col === 'F') {
                $styleArr['alignment']['wrapText'] = true;
            }

            // Kolom Status: badge warna
            if ($col === 'G') {
                $styleArr['font']['bold']               = true;
                $styleArr['font']['color']              = ['argb' => $statusFg];
                $styleArr['fill']['startColor']['argb'] = $statusBg;
                $styleArr['alignment']['horizontal']    = Alignment::HORIZONTAL_CENTER;
            }

            $sheet->getStyle($cell)->applyFromArray($styleArr);
        }

        $sheet->getRowDimension($row)->setRowHeight(20);
    }

    /* ── Footer total ── */
    $footerRow = $totalRows + 5;
    $sheet->mergeCells('A' . $footerRow . ':F' . $footerRow);
    $sheet->setCellValue('A' . $footerRow, 'TOTAL PERUSAHAAN');
    $sheet->setCellValue('G' . $footerRow, $totalRows . ' perusahaan');
    $sheet->getStyle('A' . $footerRow . ':G' . $footerRow)->applyFromArray([
        'font'      => ['bold' => true, 'size' => 9, 'color' => ['argb' => self::COLOR_SUBHEAD_FG], 'name' => 'Arial'],
        'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => self::COLOR_SUBHEAD_BG]],
        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        'borders'   => ['allBorders' => ['borderStyle' => B::BORDER_MEDIUM, 'color' => ['argb' => self::COLOR_HEADER_BG]]],
    ]);
    $sheet->getRowDimension($footerRow)->setRowHeight(20);

    /* ── Lebar kolom ── */
    $widths = ['A' => 6, 'B' => 30, 'C' => 22, 'D' => 28, 'E' => 16, 'F' => 35, 'G' => 12];
    foreach ($widths as $col => $w) {
        $sheet->getColumnDimension($col)->setWidth($w);
    }

    /* ── Freeze & autofilter ── */
    $sheet->freezePane('A5');
    $sheet->setAutoFilter('A4:G4');

    /* ── Page setup ── */
    $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
    $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
    $sheet->getPageSetup()->setFitToWidth(1);
    $sheet->getPageMargins()->setTop(0.5)->setBottom(0.5)->setLeft(0.5)->setRight(0.5);
    $sheet->getHeaderFooter()->setOddHeader('&C&B Laporan Data Perusahaan');
    $sheet->getHeaderFooter()->setOddFooter('&L' . $now . '&R Halaman &P dari &N');

    /* ── Output ── */
    $safeFilename = preg_replace('/[^A-Za-z0-9_\-]/', '_', $filename);
    $safeFilename .= '_' . date('Ymd_His') . '.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $safeFilename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spread);
    $writer->save('php://output');
    exit;
}

    public function generate_tka(array $data, string $filename = 'Data_TKA'): void
    {
        $spread = new Spreadsheet();
        $sheet  = $spread->getActiveSheet();
        $sheet->setTitle('Data TKA');

        $totalRows = count($data);
        $now       = date('d F Y, H:i') . ' WIB';

        /* ══════════════════════════════════════════
         *  BARIS 1 — Judul utama
         * ══════════════════════════════════════════ */
        $sheet->mergeCells('A1:G1');
        $sheet->setCellValue('A1', 'LAPORAN DATA PENGAJUAN TENAGA KERJA ASING (TKA)');
        $sheet->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 14, 'color' => ['argb' => self::COLOR_HEADER_FG], 'name' => 'Arial'],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => self::COLOR_HEADER_BG]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(36);

        /* ══════════════════════════════════════════
         *  BARIS 2 — Sub info
         * ══════════════════════════════════════════ */
        $sheet->mergeCells('A2:G2');
        $sheet->setCellValue('A2', 'Dinas Ketenagakerjaan  |  Diekspor: ' . $now . '  |  Total: ' . $totalRows . ' data');
        $sheet->getStyle('A2')->applyFromArray([
            'font'      => ['italic' => true, 'size' => 9, 'color' => ['argb' => self::COLOR_SUBHEAD_FG], 'name' => 'Arial'],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => self::COLOR_SUBHEAD_BG]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension(2)->setRowHeight(20);

        /* ══════════════════════════════════════════
         *  BARIS 3 — Kosong (spacer)
         * ══════════════════════════════════════════ */
        $sheet->getRowDimension(3)->setRowHeight(8);

        /* ══════════════════════════════════════════
         *  BARIS 4 — Header kolom
         * ══════════════════════════════════════════ */
        $headers = ['No', 'Nama TKA', 'Perusahaan', 'Jabatan', 'Negara Asal', 'Status', 'Tgl Pengajuan'];
        $cols    = ['A','B','C','D','E','F','G'];

        foreach ($headers as $i => $h) {
            $cell = $cols[$i] . '4';
            $sheet->setCellValue($cell, $h);
            $sheet->getStyle($cell)->applyFromArray([
                'font'      => ['bold' => true, 'size' => 10, 'color' => ['argb' => self::COLOR_HEADER_FG], 'name' => 'Arial'],
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => self::COLOR_HEADER_BG]],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                'borders'   => ['allBorders' => ['borderStyle' => B::BORDER_THIN, 'color' => ['argb' => 'FF1e6f5c']]],
            ]);
        }
        $sheet->getRowDimension(4)->setRowHeight(22);

        /* ══════════════════════════════════════════
         *  BARIS DATA (mulai baris 5)
         * ══════════════════════════════════════════ */
        $prosesStatuses = ['MENUNGGU_KASI','MENUNGGU_KABID','MENUNGGU_SEKDIS','MENUNGGU_KADIS'];

        foreach ($data as $no => $t) {
            $row    = $no + 5;
            $isAlt  = ($no % 2 === 1);
            $rowBg  = $isAlt ? self::COLOR_ROW_ALT : 'FFFFFFFF';

            // Label status
            if (in_array($t->status, $prosesStatuses)) {
                $statusLabel = 'Proses';
                $statusKey   = 'MENUNGGU_KASI';
            } else {
                $statusLabel = ucfirst(strtolower($t->status));
                $statusKey   = $t->status;
            }

            $rowData = [
                'A' => $no + 1,
                'B' => $t->nama_tka,
                'C' => $t->perusahaan,
                'D' => isset($t->jabatan)    ? $t->jabatan    : '-',
                'E' => isset($t->negara_asal) ? $t->negara_asal : '-',
                'F' => $statusLabel,
                'G' => date('d/m/Y H:i', strtotime($t->created_at)),
            ];

            foreach ($rowData as $col => $val) {
                $cell = $col . $row;
                $sheet->setCellValue($cell, $val);

                $styleArr = [
                    'font'      => ['size' => 9, 'name' => 'Arial'],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => $rowBg]],
                    'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                    'borders'   => ['allBorders' => ['borderStyle' => B::BORDER_THIN, 'color' => ['argb' => self::COLOR_BORDER]]],
                ];

                // Kolom No → center
                if ($col === 'A') {
                    $styleArr['alignment']['horizontal'] = Alignment::HORIZONTAL_CENTER;
                }

                // Kolom Status → badge warna
                if ($col === 'F') {
                    $colors = self::STATUS_COLORS[$statusKey] ?? ['bg' => 'FFf1f5f9', 'fg' => 'FF475569'];
                    $styleArr['font']['color']              = ['argb' => $colors['fg']];
                    $styleArr['font']['bold']               = true;
                    $styleArr['fill']['startColor']['argb'] = $colors['bg'];
                    $styleArr['alignment']['horizontal']    = Alignment::HORIZONTAL_CENTER;
                }

                $sheet->getStyle($cell)->applyFromArray($styleArr);
            }

            $sheet->getRowDimension($row)->setRowHeight(18);
        }

        /* ══════════════════════════════════════════
         *  BARIS FOOTER — Total
         * ══════════════════════════════════════════ */
        $footerRow = $totalRows + 5;
        $sheet->mergeCells('A' . $footerRow . ':E' . $footerRow);
        $sheet->setCellValue('A' . $footerRow, 'TOTAL DATA');
        $sheet->setCellValue('F' . $footerRow, $totalRows . ' pengajuan');
        $sheet->getStyle('A' . $footerRow . ':G' . $footerRow)->applyFromArray([
            'font'      => ['bold' => true, 'size' => 9, 'color' => ['argb' => self::COLOR_SUBHEAD_FG], 'name' => 'Arial'],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => self::COLOR_SUBHEAD_BG]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => B::BORDER_MEDIUM, 'color' => ['argb' => self::COLOR_HEADER_BG]]],
        ]);
        $sheet->getRowDimension($footerRow)->setRowHeight(20);

        /* ══════════════════════════════════════════
         *  LEBAR KOLOM
         * ══════════════════════════════════════════ */
        $widths = ['A' => 6, 'B' => 28, 'C' => 32, 'D' => 22, 'E' => 18, 'F' => 14, 'G' => 18];
        foreach ($widths as $col => $w) {
            $sheet->getColumnDimension($col)->setWidth($w);
        }

        /* ══════════════════════════════════════════
         *  FREEZE PANE & AUTO FILTER
         * ══════════════════════════════════════════ */
        $sheet->freezePane('A5');
        $sheet->setAutoFilter('A4:G4');

        /* ══════════════════════════════════════════
         *  PAGE SETUP (print)
         * ══════════════════════════════════════════ */
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
        $sheet->getPageSetup()->setFitToWidth(1);
        $sheet->getPageMargins()->setTop(0.5)->setBottom(0.5)->setLeft(0.5)->setRight(0.5);
        $sheet->getHeaderFooter()->setOddHeader('&C&B Laporan Data TKA');
        $sheet->getHeaderFooter()->setOddFooter('&L' . $now . '&R Halaman &P dari &N');

        /* ══════════════════════════════════════════
         *  OUTPUT
         * ══════════════════════════════════════════ */
        $safeFilename = preg_replace('/[^A-Za-z0-9_\-]/', '_', $filename);
        $safeFilename .= '_' . date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $safeFilename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spread);
        $writer->save('php://output');
        exit;
    }
}