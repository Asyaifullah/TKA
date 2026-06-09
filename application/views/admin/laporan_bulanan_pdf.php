<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Bulanan TKA — <?= $bulan_nama ?> <?= $tahun ?></title>
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 10pt;
            color: #1a1a2e;
            background: #fff;
            line-height: 1.4;
        }

        /* ══════════════════════════════════════
           HALAMAN F4 Landscape 330 × 210 mm
           ══════════════════════════════════════ */
        .page {
            width: 330mm;
            min-height: 210mm;
            margin: 0 auto;
            padding: 9mm 15mm 9mm 15mm;
            background: #fff;
        }

        /* ══════════════════════════════════════
           KOP SURAT
           ══════════════════════════════════════ */
        .kop-wrap { width:100%; border-collapse:collapse; }
        .kop-wrap td { padding:0; vertical-align:middle; }

        .kop-td-logo   { width:80px; text-align:center; }
        .kop-td-logo img { width:115px; height:auto; display:block; margin:0 auto; }
        .kop-td-text   { text-align:center; padding:0 6px; }
        .kop-td-filler { width:80px; }

        .k-prov     { font-size:8pt; letter-spacing:.05em; text-transform:uppercase; color:#555; margin-bottom:1px; }
        .k-instansi { font-size:17pt; font-weight:bold; letter-spacing:.02em; text-transform:uppercase; color:#1B3A6B; line-height:1.05; margin-bottom:1px; }
        .k-kota     { font-size:9pt; font-weight:bold; letter-spacing:.16em; text-transform:uppercase; color:#333; margin-bottom:3px; }
        .k-alamat   { font-size:7.5pt; color:#555; line-height:1.5; }

        .kop-line-navy { border:none; border-top:3px solid #1B3A6B; margin:7px 0 2px; }
        .kop-line-gold { border:none; border-top:1px solid #C9A84C; margin:0 0 8px; }

        /* ══════════════════════════════════════
           JUDUL
           ══════════════════════════════════════ */
        .judul-wrap  { text-align:center; margin-bottom:7px; }
        .judul-utama { font-size:11.5pt; font-weight:bold; text-transform:uppercase;
                       letter-spacing:.05em; color:#1B3A6B; text-decoration:underline; margin-bottom:1px; }
        .judul-sub   { font-size:8.5pt; color:#555; margin-bottom:1px; }
        .judul-period{ font-size:9.5pt; font-weight:bold; color:#1a1a2e; }

        /* ══════════════════════════════════════
           META STRIP
           ══════════════════════════════════════ */
        .meta-table {
            width:100%; border-collapse:collapse;
            border:1px solid #C9A84C; margin-bottom:7px;
        }
        .meta-head-row td {
            background:#1B3A6B; color:#fff;
            font-size:7pt; font-weight:bold;
            letter-spacing:.07em; text-transform:uppercase;
            padding:3px 8px; border-right:1px solid #2d4f8a;
        }
        .meta-head-row td:last-child { border-right:none; }
        .meta-data-row td {
            padding:4px 8px; border-right:1px solid #e8e8e8;
            font-size:8.5pt; font-weight:bold; color:#1a1a2e; width:25%;
        }
        .meta-data-row td:last-child { border-right:none; }

        /* ══════════════════════════════════════
           TABEL DATA
           ══════════════════════════════════════ */
        .data-table {
            width:100%; border-collapse:collapse;
            font-size:7.6pt; table-layout:fixed;
        }
        .data-table thead tr { background:#1B3A6B; }
        .data-table thead th {
            color:#fff; font-size:7.4pt; font-weight:bold;
            letter-spacing:.02em; padding:5px 4px;
            border:1px solid #2d4f8a; text-align:center;
        }
        .data-table thead th.th-left { text-align:left; padding-left:6px; }

        .data-table tbody td {
            border:1px solid #ddd; padding:2.8px 4px;
            vertical-align:middle; line-height:1.25;
            color:#1a1a2e; overflow:hidden;
        }
        .data-table tbody tr.row-even td { background:#F0F4FA; }
        .data-table tbody tr.row-odd  td { background:#fff; }
        .data-table tbody tr:last-child td { border-bottom:2px solid #1B3A6B; }

        .col-no   { text-align:center; color:#888; font-size:7pt; padding:2.8px 2px !important; white-space:nowrap; }
        .col-mono { text-align:center; font-family:'Courier New',monospace; font-size:7pt; }
        .col-ctr  { text-align:center; }

        /* Pills */
        .pill {
            display:inline-block; padding:1.5px 6px;
            border-radius:20px; font-size:6.5pt;
            font-weight:bold; white-space:nowrap;
            border:1px solid transparent;
        }
        .pill-selesai { background:#ECFDF5; color:#065F46; border-color:#6EE7B7; }
        .pill-proses  { background:#EFF6FF; color:#1E40AF; border-color:#93C5FD; }
        .pill-draft   { background:#F3F4F6; color:#374151; border-color:#9CA3AF; }
        .pill-ditolak { background:#FEF2F2; color:#991B1B; border-color:#FCA5A5; }

        /* ══════════════════════════════════════
           BAGIAN BAWAH: RINGKASAN + TTD
           ══════════════════════════════════════ */
        .bottom-table {
            width:100%; border-collapse:collapse; margin-top:9px;
        }
        .bottom-table > tbody > tr > td {
            vertical-align:bottom; border:none; padding:0;
        }
        .bottom-td-summary { width:220px; }
        .bottom-td-sig     { width:325px; text-align:center; }

        /* Ringkasan */
        .summary-outer { border:1px solid #ddd; }
        .summary-head  {
            background:#1B3A6B; color:#fff;
            font-weight:bold; font-size:7.5pt;
            letter-spacing:.07em; text-transform:uppercase;
            text-align:center; padding:4px 8px;
        }
        .summary-inner { width:100%; border-collapse:collapse; font-size:7.8pt; }
        .summary-inner td { padding:3px 8px; border-bottom:1px solid #eee; color:#333; }
        .summary-inner tr:last-child td { border-bottom:none; }
        .summary-inner td.s-num {
            text-align:right; font-weight:bold; color:#1B3A6B; width:28px;
        }
        .summary-inner tr.s-total td { background:#1B3A6B; color:#fff; font-weight:bold; }
        .summary-inner tr.s-total td.s-num { color:#C9A84C; }

        /* TTD */
        .sig-wrap   { display:inline-block; width:180px; }
        .sig-date   { font-size:8.8pt; color:#444; margin-bottom:2px; }
        .sig-role   { font-size:8.8pt; font-weight:bold; text-transform:uppercase;
                      letter-spacing:.02em; line-height:1.45; color:#1a1a2e; margin-bottom:2px; }
        .sig-gap    { height:46px; }
        .sig-line   { border-top:1.5px solid #1a1a2e; padding-top:3px; margin-top:0; }
        .sig-name   { font-size:9.5pt; font-weight:bold; color:#1B3A6B; }
        .sig-nip    { font-size:7.8pt; color:#666; margin-top:2px; }

        /* Kosong */
        .empty-notice {
            text-align:center; padding:24px 20px;
            border:1.5px dashed #aaa; color:#777;
            font-style:italic; font-size:9pt;
        }

        /* ══════════════════════════════════════
           FOOTER
           ══════════════════════════════════════ */
        .footer-wrap { margin-top:8px; }
        .footer-inner {
            width:100%; border-collapse:collapse;
            border-top:1px solid #bbb;
        }
        .footer-inner td {
            padding-top:1px; font-size:6.8pt;
            color:#888; border:none;
        }
        .footer-inner td.f-left  { text-align:left; font-weight:bold; color:#555; }
        .footer-inner td.f-mid   { text-align:center; }
        .footer-inner td.f-right { text-align:right; }

        /* ══════════════════════════════════════
           PRINT / SCREEN
           ══════════════════════════════════════ */
        @media print {
            @page { size:330mm 210mm landscape; margin:0; }
            body  { background:#fff; margin:0; }
            .page { padding:8mm 14mm 8mm 14mm; box-shadow:none; margin:0; }
        }
        @media screen {
            body { background:#B0B7C3; padding:24px 0 48px; }
            .page {
                margin:24px auto;
                box-shadow:0 2px 6px rgba(0,0,0,.1), 0 14px 44px rgba(0,0,0,.2);
            }
        }
    </style>
</head>
<body>
<div class="page">

    <!-- ══ KOP SURAT ══ -->
    <table class="kop-wrap">
        <tr>
            <td class="kop-td-logo">
                <img src="<?= base_url('assets/images/logo_kota_bekasi.png') ?>" alt="Logo">
            </td>
            <td class="kop-td-text">
                <div class="k-prov">Pemerintah Kota Bekasi</div>
                <div class="k-instansi">Dinas Tenaga Kerja</div>
                <div class="k-kota">Kota Bekasi</div>
                <div class="k-alamat">
                    Jl. Jend. Ahmad Yani No.1, Bekasi Selatan, Kota Bekasi, Jawa Barat 17141<br>
                    Telp. (021) 8841023 &nbsp;&bull;&nbsp; disnaker@bekasikota.go.id &nbsp;&bull;&nbsp; www.bekasikota.go.id
                </div>
            </td>
            <td class="kop-td-filler"></td>
        </tr>
    </table>
    <hr class="kop-line-navy">
    <hr class="kop-line-gold">

    <!-- ══ JUDUL ══ -->
    <div class="judul-wrap">
        <div class="judul-utama">Laporan Bulanan Tenaga Kerja Asing (TKA)</div>
        <div class="judul-sub">Dinas Tenaga Kerja Kota Bekasi</div>
        <div class="judul-period">Periode: <?= $bulan_nama ?> <?= $tahun ?></div>
    </div>

    <!-- ══ META STRIP ══ -->
    <table class="meta-table">
        <tr class="meta-head-row">
            <td>Periode Laporan</td>
            <td>Total Pengajuan</td>
            <td>Tanggal Cetak</td>
            <td>Dicetak Oleh</td>
        </tr>
        <tr class="meta-data-row">
            <td><?= $bulan_nama ?> <?= $tahun ?></td>
            <td><?= count($tka) ?> Data TKA</td>
            <td><?= date('d F Y') ?></td>
            <td><?= htmlspecialchars($this->session->userdata('nama') ?: 'Sistem') ?></td>
        </tr>
    </table>

    <!-- ══ TABEL DATA ══ -->
    <?php if (empty($tka)): ?>
        <div class="empty-notice">
            Tidak ada data TKA pada periode <strong><?= $bulan_nama ?> <?= $tahun ?></strong>.
        </div>
    <?php else: ?>

    <?php
        $cnt_selesai = $cnt_proses = $cnt_draft = $cnt_ditolak = 0;
        $proses_statuses = ['MENUNGGU_KASI','MENUNGGU_KABID','MENUNGGU_SEKDIS','MENUNGGU_KADIS'];
        foreach ($tka as $t) {
            if ($t->status === 'SELESAI')                    $cnt_selesai++;
            elseif (in_array($t->status, $proses_statuses)) $cnt_proses++;
            elseif ($t->status === 'DITOLAK')               $cnt_ditolak++;
            else                                             $cnt_draft++;
        }
    ?>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width:3%; white-space:nowrap; padding:5px 5px;">No</th>
                <th class="th-left" style="width:135px;">Nama Perusahaan</th>
                <th class="th-left" style="width:110px;">Nama TKA</th>
                <th style="width:45px;">Tanggal Pengajuan</th>
                <th style="width:100px;">No. Paspor</th>
                <th style="width:108px;">No. KITAS</th>
                <th style="width:68px;">Status</th>
            </tr>
        </thead>
        <tbody>
        <?php $no = 1; foreach ($tka as $t):
            $row_class = ($no % 2 === 0) ? 'row-even' : 'row-odd';
            if ($t->status === 'SELESAI') {
                $pc = 'pill-selesai'; $pl = '&#10003; Selesai';
            } elseif (in_array($t->status, $proses_statuses)) {
                $pc = 'pill-proses';  $pl = '&#8635; Proses';
            } elseif ($t->status === 'DITOLAK') {
                $pc = 'pill-ditolak'; $pl = '&#10005; Ditolak';
            } else {
                $pc = 'pill-draft';   $pl = '&bull; Draft';
            }
        ?>
            <tr class="<?= $row_class ?>">
                <td class="col-no"><?= $no++ ?></td>
                <td style="padding-left:6px;"><?= htmlspecialchars($t->perusahaan) ?></td>
                <td style="padding-left:6px;"><?= htmlspecialchars($t->nama_tka) ?></td>
                <td class="col-ctr" style="white-space:nowrap;"><?= date('d/m/Y', strtotime($t->created_at)) ?></td>
                <td class="col-mono"><?= htmlspecialchars($t->passport_no ?? '') ?: '&mdash;' ?></td>
                <td class="col-mono"><?= htmlspecialchars($t->kitas_no ?? '') ?: '&mdash;' ?></td>
                <td class="col-ctr"><span class="pill <?= $pc ?>"><?= $pl ?></span></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- ══ RINGKASAN + TTD (sejajar, tidak pernah terpotong) ══ -->
    <table class="bottom-table">
        <tr>
            <!-- Ringkasan -->
            <td class="bottom-td-summary">
                <div class="summary-outer">
                    <div class="summary-head">Ringkasan Status Pengajuan</div>
                    <table class="summary-inner">
                        <tr class="s-total">
                            <td>Total Pengajuan</td>
                            <td class="s-num"><?= count($tka) ?></td>
                        </tr>
                        <tr>
                            <td>&#10003;&nbsp; Selesai / Surat Terbit</td>
                            <td class="s-num"><?= $cnt_selesai ?></td>
                        </tr>
                        <tr>
                            <td>&#8635;&nbsp; Dalam Proses</td>
                            <td class="s-num"><?= $cnt_proses ?></td>
                        </tr>
                        <tr>
                            <td>&bull;&nbsp; Draft / Belum Lengkap</td>
                            <td class="s-num"><?= $cnt_draft ?></td>
                        </tr>
                        <tr>
                            <td>&#10005;&nbsp; Ditolak</td>
                            <td class="s-num"><?= $cnt_ditolak ?></td>
                        </tr>
                    </table>
                </div>
            </td>

            <!-- Spacer -->
            <td>&nbsp;</td>

            <!-- TTD — selalu utuh -->
            <td class="bottom-td-sig">
                <div class="sig-date">Bekasi, <?= date('d F Y') ?></div>
                <div class="sig-role">Kepala Dinas Tenaga Kerja<br>Kota Bekasi</div>
                <div class="sig-gap"></div>
                <div class="sig-line">
                    <div class="sig-name"><?= htmlspecialchars($this->session->userdata('nama') ?: '_____________________') ?></div>
                    <?php if ($nip = $this->session->userdata('nip')): ?>
                    <div class="sig-nip">NIP. <?= htmlspecialchars($nip) ?></div>
                    <?php endif; ?>
                </div>
            </td>
        </tr>
    </table>

    <?php endif; ?>

    <!-- ══ FOOTER ══ -->
    <div class="footer-wrap">
        <table class="footer-inner">
            <tr>
                <td class="f-left">Dinas Tenaga Kerja &mdash; Kota Bekasi</td>
                <td class="f-mid">Dokumen resmi &bull; Dicetak <?= date('d/m/Y H:i') ?></td>
                <td class="f-right">Laporan Bulanan TKA &bull; <?= $bulan_nama ?> <?= $tahun ?></td>
            </tr>
        </table>
    </div>

</div><!-- /page -->
</body>
</html>