<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail TKA — SITLAKEB TKA Operator</title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/shared.css') ?>">
    <style>
        html, body { height: 100%; }
        .page-wrapper { min-height: 100vh; display: flex; flex-direction: column; }
        .page-content { flex: 1 0 auto; }
        footer, .site-footer { flex-shrink: 0; }

        /* ── TKA Hero ── */
        .tka-hero {
            border-radius: var(--r-xl);
            padding: 24px 28px;
            display: flex; align-items: center; gap: 20px;
            margin-bottom: 20px;
            position: relative; overflow: hidden;
        }
        .tka-hero.hero-proses  { background: linear-gradient(135deg, #1e40af 0%, #3b6dd4 100%); }
        .tka-hero.hero-selesai { background: linear-gradient(135deg, var(--c-primary) 0%, #2a9d7f 100%); }
        .tka-hero.hero-ditolak { background: linear-gradient(135deg, #9f1239 0%, #e11d48 100%); }
        .tka-hero.hero-draft   { background: linear-gradient(135deg, #475569 0%, #64748b 100%); }
        .tka-hero::before {
            content: ''; position: absolute; top: -40px; right: -40px;
            width: 180px; height: 180px; border-radius: 50%;
            background: rgba(255,255,255,0.06);
        }
        .tka-hero::after {
            content: ''; position: absolute; bottom: -50px; right: 120px;
            width: 120px; height: 120px; border-radius: 50%;
            background: rgba(255,255,255,0.04);
        }
        .tka-avatar {
            width: 64px; height: 64px; border-radius: var(--r-lg);
            background: rgba(255,255,255,0.2);
            border: 2px solid rgba(255,255,255,0.25);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.6rem; color: white; flex-shrink: 0; z-index: 1;
        }
        .tka-hero-info { flex: 1; z-index: 1; }
        .tka-hero-info .th-name {
            font-family: var(--font-head); font-size: 1.15rem; font-weight: 800;
            color: white; margin-bottom: 3px; letter-spacing: -0.01em;
        }
        .tka-hero-info .th-sub {
            font-size: 0.78rem; color: rgba(255,255,255,0.75);
            display: flex; align-items: center; gap: 6px; flex-wrap: wrap;
        }
        .tka-hero-info .th-sub i { font-size: 10px; }
        .tka-hero-badges { display: flex; flex-direction: column; align-items: flex-end; gap: 6px; z-index: 1; }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 4px 12px; border-radius: 20px;
            font-size: 0.7rem; font-weight: 700; font-family: var(--font-head);
        }
        .hb-proses  { background: #bfdbfe; color: #1e3a8a; }
        .hb-selesai { background: #4ade80; color: #064e3b; }
        .hb-ditolak { background: #fca5a5; color: #7f1d1d; }
        .hb-draft   { background: rgba(255,255,255,0.18); color: rgba(255,255,255,0.9); }
        .hb-date    { background: rgba(255,255,255,0.14); color: rgba(255,255,255,0.8); font-size: 0.68rem; }

        /* ── Progress / Timeline ── */
        .approval-track {
            display: flex; align-items: flex-start;
            padding: 20px 22px; gap: 0;
        }
        .track-step {
            flex: 1; display: flex; flex-direction: column; align-items: center;
            position: relative;
        }
        .track-step:not(:last-child)::after {
            content: '';
            position: absolute; top: 14px; left: 50%; width: 100%; height: 2px;
            background: var(--c-border); z-index: 0;
        }
        .track-step.ts-done:not(:last-child)::after  { background: var(--c-primary); }
        .track-step.ts-active:not(:last-child)::after { background: linear-gradient(to right, #3b82f6, var(--c-border)); }

        .ts-dot {
            width: 28px; height: 28px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 11px; font-weight: 700; z-index: 1;
            border: 2px solid transparent;
        }
        .ts-dot.td-done   { background: var(--c-primary); color: white; border-color: var(--c-primary); }
        .ts-dot.td-active { background: #3b82f6; color: white; border-color: #3b82f6; }
        .ts-dot.td-wait   { background: white; color: var(--c-text-muted); border-color: var(--c-border); }
        .ts-dot.td-reject { background: #f43f5e; color: white; border-color: #f43f5e; }

        .ts-label {
            margin-top: 8px; font-size: 0.68rem; font-weight: 700;
            font-family: var(--font-head); text-align: center; line-height: 1.3;
        }
        .ts-label.tl-done   { color: var(--c-primary); }
        .ts-label.tl-active { color: #3b82f6; }
        .ts-label.tl-wait   { color: var(--c-text-muted); }
        .ts-label.tl-reject { color: #f43f5e; }
        .ts-sublabel { font-size: 0.63rem; color: var(--c-text-muted); margin-top: 2px; text-align: center; }

        /* ── Info grid ── */
        .info-grid {
            display: grid; grid-template-columns: repeat(2, 1fr); gap: 0;
        }
        @media (max-width: 640px) { .info-grid { grid-template-columns: 1fr; } }

        .info-row {
            display: flex; align-items: flex-start; gap: 12px;
            padding: 13px 22px; border-bottom: 1px solid var(--c-border);
        }
        .info-row:nth-child(odd)  { border-right: 1px solid var(--c-border); }
        .info-row:last-child,
        .info-row:nth-last-child(2):nth-child(odd) { border-bottom: none; }
        .info-row.full { grid-column: 1 / -1; border-right: none; }
        @media (max-width: 640px) {
            .info-row { border-right: none !important; }
            .info-row:last-child { border-bottom: none; }
        }

        .info-icon {
            width: 30px; height: 30px; border-radius: var(--r-sm);
            background: var(--c-primary-light); color: var(--c-primary);
            display: flex; align-items: center; justify-content: center;
            font-size: 11px; flex-shrink: 0; margin-top: 1px;
        }
        .info-label { font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em; color: var(--c-text-muted); margin-bottom: 2px; }
        .info-value { font-size: 0.82rem; font-weight: 500; color: var(--c-text); line-height: 1.5; }
        .info-value.mono { font-family: 'Courier New', monospace; font-size: 0.78rem; color: var(--c-primary); }
        .info-value.empty { color: var(--c-text-muted); font-style: italic; font-size: 0.78rem; }

        /* ── Dokumen grid ── */
        .doc-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 12px;
            padding: 18px 22px;
        }
        .doc-item {
            border: 1px solid var(--c-border);
            border-radius: var(--r-md);
            overflow: hidden;
            transition: box-shadow 0.15s, border-color 0.15s;
        }
        .doc-item:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.08); border-color: var(--c-primary); }
        .doc-preview {
            height: 90px; background: #f8fafc;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem; color: #cbd5e1; overflow: hidden;
        }
        .doc-preview img { width: 100%; height: 100%; object-fit: cover; }
        .doc-preview.dp-pdf  { color: #ef4444; }
        .doc-preview.dp-img  { padding: 0; }
        .doc-preview.dp-none { color: #e2e8f0; }
        .doc-footer {
            padding: 8px 10px; border-top: 1px solid var(--c-border);
            background: white;
        }
        .doc-name { font-size: 0.68rem; font-weight: 700; color: var(--c-text); margin-bottom: 4px; font-family: var(--font-head); }
        .doc-link {
            display: inline-flex; align-items: center; gap: 4px;
            font-size: 0.65rem; font-weight: 600; font-family: var(--font-head);
            color: var(--c-primary); text-decoration: none;
        }
        .doc-link:hover { text-decoration: underline; }
        .doc-none { font-size: 0.65rem; color: var(--c-text-muted); font-style: italic; }

        /* ── Log timeline (dengan tiga tipe: sistem, approve, reject) ── */
        .log-list { padding: 0 22px 18px; }
        .log-item {
            display: flex; gap: 14px;
            padding: 12px 0;
            border-bottom: 1px solid var(--c-border);
        }
        .log-item:last-child { border-bottom: none; }
        .log-dot-wrap { display: flex; flex-direction: column; align-items: center; gap: 0; }
        .log-dot {
            width: 28px; height: 28px; border-radius: 50%; flex-shrink: 0;
            display: flex; align-items: center; justify-content: center;
            font-size: 11px;
        }
        .ld-approve { background: #dcfce7; color: #15803d; }
        .ld-reject  { background: #fee2e2; color: #b91c1c; }
        .ld-system  { background: #e2e8f0; color: #475569; }
        .log-line   { flex: 1; width: 2px; background: var(--c-border); margin-top: 4px; }
        .log-item:last-child .log-line { display: none; }
        .log-body { flex: 1; padding-top: 3px; }
        .log-role {
            font-family: var(--font-head); font-size: 0.8rem; font-weight: 700;
            color: var(--c-text); margin-bottom: 3px;
            display: flex; align-items: center; gap: 8px;
        }
        .log-badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 2px 8px; border-radius: 20px;
            font-size: 0.65rem; font-weight: 700;
        }
        .lb-approve { background: #dcfce7; color: #15803d; }
        .lb-reject  { background: #fee2e2; color: #b91c1c; }
        .lb-system  { background: #e2e8f0; color: #334155; }
        .log-time { font-size: 0.7rem; color: var(--c-text-muted); margin-bottom: 4px; }
        .log-note { font-size: 0.78rem; color: var(--c-text); background: var(--c-bg); border-radius: var(--r-sm); padding: 6px 10px; border-left: 2px solid var(--c-border); margin-top: 4px; }
    </style>
</head>
<body>

<?php $this->load->view('operator/sidebar'); ?>

<div class="page-wrapper">

    <header class="topnav">
        <div class="topnav-breadcrumb">
            <a href="<?= base_url('operator/dashboard') ?>" style="color:var(--c-text-muted);text-decoration:none;"><i class="fas fa-home"></i></a>
            <i class="fas fa-chevron-right" style="font-size:8px;"></i>
            <a href="<?= base_url('operator/semua_tka') ?>" style="color:var(--c-text-muted);text-decoration:none;">Seluruh TKA</a>
            <i class="fas fa-chevron-right" style="font-size:8px;"></i>
            <strong><?= htmlspecialchars($tka->nama_tka) ?></strong>
        </div>
        <div class="topnav-actions">
            <a href="<?= base_url('operator/semua_tka') ?>" class="topnav-btn" title="Kembali">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
    </header>

    <main class="page-content">

        <?php
        $prosesStatuses = ['MENUNGGU_KASI','MENUNGGU_KABID','MENUNGGU_SEKDIS','MENUNGGU_KADIS'];
        $isProses  = in_array($tka->status, $prosesStatuses);
        $isSelesai = ($tka->status === 'SELESAI');
        $isDitolak = ($tka->status === 'DITOLAK');

        if($isSelesai)      { $heroClass = 'hero-selesai'; $badgeClass = 'hb-selesai'; $badgeIcon = 'fa-check-circle'; $badgeLabel = 'Selesai'; }
        elseif($isDitolak)  { $heroClass = 'hero-ditolak'; $badgeClass = 'hb-ditolak'; $badgeIcon = 'fa-times-circle'; $badgeLabel = 'Ditolak'; }
        elseif($isProses)   { $heroClass = 'hero-proses';  $badgeClass = 'hb-proses';  $badgeIcon = 'fa-spinner';      $badgeLabel = 'Proses'; }
        else                { $heroClass = 'hero-draft';   $badgeClass = 'hb-draft';   $badgeIcon = 'fa-pen-fancy';    $badgeLabel = 'Draft'; }

        $stages      = ['MENUNGGU_KASI','MENUNGGU_KABID','MENUNGGU_SEKDIS','MENUNGGU_KADIS'];
        $stageLabels = ['Kasi','Kabid','Sekdis','Kadis'];
        $curIdx      = array_search($tka->status, $stages);

        $fileFields = [
            'surat_permohonan' => ['label'=>'Surat Permohonan','icon'=>'fa-file-lines'],
            'passport'         => ['label'=>'Passport',        'icon'=>'fa-passport'],
            'kitas'            => ['label'=>'KITAS',           'icon'=>'fa-id-card'],
            'stm'              => ['label'=>'STM',             'icon'=>'fa-file-contract'],
            'rptka'            => ['label'=>'RPTKA',           'icon'=>'fa-file-signature'],
            'notifikasi'       => ['label'=>'Notifikasi',      'icon'=>'fa-bell'],
            'bukti_bayar'      => ['label'=>'Bukti Bayar',     'icon'=>'fa-receipt'],
            'surat_kuasa'      => ['label'=>'Surat Kuasa',     'icon'=>'fa-stamp'],
            'surat_wajib_lapor' => ['label'=>'Surat Wajib Lapor','icon'=>'fa-file-alt'],
            'ktp'              => ['label'=>'KTP',             'icon'=>'fa-id-badge'],
            'foto'             => ['label'=>'Foto',            'icon'=>'fa-image'],
        ];
        ?>

        <!-- Hero -->
        <div class="tka-hero <?= $heroClass ?>">
            <div class="tka-avatar"><i class="fas fa-user-tie"></i></div>
            <div class="tka-hero-info">
                <div class="th-name"><?= htmlspecialchars($tka->nama_tka) ?></div>
                <div class="th-sub">
                    <i class="fas fa-building"></i> <?= htmlspecialchars($perusahaan_nama) ?>
                    &nbsp;·&nbsp;
                    <i class="fas fa-calendar-alt"></i> <?= date('d M Y', strtotime($tka->created_at)) ?>
                </div>
            </div>
            <div class="tka-hero-badges">
                <span class="hero-badge <?= $badgeClass ?>">
                    <i class="fas <?= $badgeIcon ?>"></i> <?= $badgeLabel ?>
                </span>
                <span class="hero-badge hb-date">
                    <i class="fas fa-clock"></i> <?= date('H:i', strtotime($tka->created_at)) ?> WIB
                </span>
            </div>
        </div>

        <div style="display:grid; grid-template-columns:1fr 300px; gap:20px; align-items:start;">

        <!-- LEFT -->
        <div>

            <!-- ── Tahapan Approval ── -->
            <div class="surface" style="margin-bottom:20px;">
                <div class="surface-header">
                    <div class="surface-title">
                        <i class="fas fa-route" style="color:#3b82f6;"></i>
                        Tahapan Approval
                    </div>
                </div>
                <div class="approval-track">
                    <?php foreach($stageLabels as $i => $label):
                        if($isSelesai) {
                            $dotClass = 'td-done'; $lblClass = 'tl-done'; $dotIcon = 'fa-check'; $sub = 'Selesai';
                        } elseif($isDitolak && $curIdx == $i) {
                            $dotClass = 'td-reject'; $lblClass = 'tl-reject'; $dotIcon = 'fa-times'; $sub = 'Ditolak';
                        } elseif($curIdx !== false && $i < $curIdx) {
                            $dotClass = 'td-done'; $lblClass = 'tl-done'; $dotIcon = 'fa-check'; $sub = 'Disetujui';
                        } elseif($curIdx !== false && $i == $curIdx) {
                            $dotClass = 'td-active'; $lblClass = 'tl-active'; $dotIcon = 'fa-ellipsis'; $sub = 'Menunggu';
                        } else {
                            $dotClass = 'td-wait'; $lblClass = 'tl-wait'; $dotIcon = 'fa-minus'; $sub = 'Belum';
                        }
                        $stepClass = ($dotClass == 'td-done') ? 'ts-done' : (($dotClass == 'td-active') ? 'ts-active' : 'ts-wait');
                    ?>
                    <div class="track-step <?= $stepClass ?>">
                        <div class="ts-dot <?= $dotClass ?>"><i class="fas <?= $dotIcon ?>"></i></div>
                        <div class="ts-label <?= $lblClass ?>"><?= $label ?></div>
                        <div class="ts-sublabel"><?= $sub ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- ── Data Detail Perusahaan ── -->
            <div class="surface" style="margin-bottom:20px;">
                <div class="surface-header">
                    <div class="surface-title">
                        <i class="fas fa-clipboard-list"></i>
                        Data Detail Pengajuan
                    </div>
                </div>
                <div class="info-grid">
                    <?php
                    $v = function($val, $mono=false) {
                        if($val === null || $val === '') return '<span class="info-value empty">Belum diisi</span>';
                        return '<span class="info-value'.($mono?' mono':'').'">'.htmlspecialchars($val).'</span>';
                    };
                    $vDate = function($val) {
                        if(!$val) return '<span class="info-value empty">-</span>';
                        return '<span class="info-value">'.date('d M Y', strtotime($val)).'</span>';
                    };
                    $rows = [
                        ['fa-passport',          'Nomor Passport',            $v($tka->passport_no, true)],
                        ['fa-calendar-xmark',    'Masa Berlaku Passport',     $vDate($tka->passport_expiry)],
                        ['fa-id-card',           'Nomor KITAS',               $v($tka->kitas_no, true)],
                        ['fa-file-contract',     'Nomor STM',                 $v($tka->stm_no, true)],
                        ['fa-file-signature',    'Nomor RPTKA',               $v($tka->rptka_no, true)],
                        ['fa-calendar-check',    'Tanggal RPTKA',             $vDate($tka->rptka_date)],
                        ['fa-bell',              'Nomor Notifikasi',          $v($tka->notifikasi_no, true)],
                        ['fa-calendar-day',      'Tanggal Notifikasi',        $vDate($tka->notifikasi_date)],
                        ['fa-briefcase',         'Jabatan',                   $v($tka->jabatan)],
                        ['fa-earth-asia',        'Kebangsaan',                $v($tka->negara_asal)],
                        ['fa-map-pin',           'Tempat Lahir',              $v($tka->tempat_lahir)],
                        ['fa-cake-candles',      'Tanggal Lahir',             $vDate($tka->tanggal_lahir)],
                        ['fa-venus-mars',        'Jenis Kelamin',             $v($tka->jenis_kelamin)],
                        ['fa-building-flag',     'Lokasi Kerja',              $v($tka->lokasi_kerja)],
                        ['fa-tag',               'Jenis Notifikasi',          $v($tka->jenis_notifikasi)],
                        ['fa-hourglass-half',    'Masa Berlaku Notifikasi',   $v($tka->masa_berlaku_notifikasi)],
                        ['fa-circle-check',      'Lunas DKP-TKA',             $v($tka->lunas_dkp)],
                        ['fa-industry',          'Bidang Usaha',              $v($tka->bidang_usaha)],
                    ];
                    foreach($rows as $r): ?>
                    <div class="info-row">
                        <div class="info-icon"><i class="fas <?= $r[0] ?>"></i></div>
                        <div>
                            <div class="info-label"><?= $r[1] ?></div>
                            <?= $r[2] ?>
                        </div>
                    </div>
                    <?php endforeach; ?>

                    <!-- Alamat — full width -->
                    <div class="info-row full">
                        <div class="info-icon"><i class="fas fa-house"></i></div>
                        <div>
                            <div class="info-label">Alamat Tinggal</div>
                            <div class="info-value"><?= nl2br(htmlspecialchars($tka->alamat_tinggal ?? '-')) ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ── Dokumen Upload ── -->
            <div class="surface" style="margin-bottom:20px;">
                <div class="surface-header">
                    <div class="surface-title">
                        <i class="fas fa-folder-open" style="color:#f59e0b;"></i>
                        Dokumen yang Diupload
                        <span style="background:var(--c-primary-light);color:var(--c-primary);padding:2px 8px;border-radius:20px;font-size:0.67rem;">
                            <?= count(array_filter(array_map(function($f) use($berkas){ return isset($berkas->$f) && $berkas->$f; }, array_keys($fileFields)))) ?> / <?= count($fileFields) ?> file
                        </span>
                    </div>
                </div>
                <div class="doc-grid">
                    <?php foreach($fileFields as $field => $meta):
                        $file   = isset($berkas->$field) ? $berkas->$field : '';
                        $ext    = $file ? strtolower(pathinfo($file, PATHINFO_EXTENSION)) : '';
                        $isImg  = in_array($ext, ['jpg','jpeg','png']);
                        $url    = $file ? base_url('uploads/'.$tka->id.'/'.$file) : '';
                    ?>
                    <div class="doc-item">
                        <div class="doc-preview <?= $file ? ($isImg ? 'dp-img' : 'dp-pdf') : 'dp-none' ?>">
                            <?php if($file && $isImg): ?>
                                <img src="<?= $url ?>" alt="<?= $meta['label'] ?>">
                            <?php elseif($file): ?>
                                <i class="fas fa-file-pdf"></i>
                            <?php else: ?>
                                <i class="fas fa-file-circle-xmark"></i>
                            <?php endif; ?>
                        </div>
                        <div class="doc-footer">
                            <div class="doc-name"><?= $meta['label'] ?></div>
                            <?php if($file): ?>
                                <a href="<?= $url ?>" target="_blank" class="doc-link">
                                    <i class="fas fa-arrow-up-right-from-square" style="font-size:9px;"></i>
                                    <?= $isImg ? 'Lihat Gambar' : 'Lihat PDF' ?>
                                </a>
                            <?php else: ?>
                                <span class="doc-none">Tidak ada</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- ── Riwayat Approval (Sistem, Approve, Tolak) ── -->
            <div class="surface">
                <div class="surface-header">
                    <div class="surface-title">
                        <i class="fas fa-clock-rotate-left" style="color:#7c3aed;"></i>
                        Riwayat Approval
                        <?php if(!empty($logs)): ?>
                            <span style="background:#f5f3ff;color:#7c3aed;padding:2px 8px;border-radius:20px;font-size:0.67rem;"><?= count($logs) ?> entri</span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if(!empty($logs)): ?>
                <div class="log-list">
                    <?php foreach($logs as $log):
                        // Klasifikasi tipe log: sistem, approve, reject
                        if ($log->status === 'approve') {
                            $logType = 'approve';
                            $icon = 'fa-check';
                            $bgClass = 'ld-approve';
                            $badgeClass = 'lb-approve';
                            $badgeIcon = 'fa-check-circle';
                            $badgeText = 'Disetujui';
                        } elseif ($log->status === 'reject' || $log->status === 'DITOLAK') {
                            $logType = 'reject';
                            $icon = 'fa-times';
                            $bgClass = 'ld-reject';
                            $badgeClass = 'lb-reject';
                            $badgeIcon = 'fa-times-circle';
                            $badgeText = 'Ditolak';
                        } else {
                            // Sistem (MENUNGGU_KASI, MENUNGGU_KABID, dll)
                            $logType = 'system';
                            $icon = 'fa-clock';
                            $bgClass = 'ld-system';
                            $badgeClass = 'lb-system';
                            $badgeIcon = 'fa-robot';
                            $badgeText = 'Sistem';
                        }
                    ?>
                    <div class="log-item">
                        <div class="log-dot-wrap">
                            <div class="log-dot <?= $bgClass ?>">
                                <i class="fas <?= $icon ?>"></i>
                            </div>
                            <div class="log-line"></div>
                        </div>
                        <div class="log-body">
                            <div class="log-role">
                                <?= ucfirst($log->role ?? 'Sistem') ?>
                                <span class="log-badge <?= $badgeClass ?>">
                                    <i class="fas <?= $badgeIcon ?>" style="font-size:9px;"></i>
                                    <?= $badgeText ?>
                                </span>
                            </div>
                            <div class="log-time">
                                <i class="fas fa-clock" style="font-size:9px;margin-right:3px;"></i>
                                <?= date('d M Y, H:i', strtotime($log->created_at)) ?> WIB
                            </div>
                            <?php if($log->catatan): ?>
                                <div class="log-note">
                                    <i class="fas fa-quote-left" style="font-size:9px;color:var(--c-text-muted);margin-right:4px;"></i>
                                    <?= htmlspecialchars($log->catatan) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <div class="empty-state">
                    <div class="empty-state-icon"><i class="fas fa-clock-rotate-left"></i></div>
                    <h4>Belum Ada Riwayat</h4>
                    <p>Proses approval belum dimulai.</p>
                </div>
                <?php endif; ?>
            </div>

        </div><!-- /LEFT -->

        <!-- RIGHT -->
        <div>

            <!-- Aksi Cepat -->
            <div class="surface" style="margin-bottom:16px;">
                <div class="surface-header">
                    <div class="surface-title">
                        <i class="fas fa-bolt" style="color:#f59e0b;"></i>
                        Aksi Cepat
                    </div>
                </div>
                <div class="surface-body" style="padding:16px;display:flex;flex-direction:column;gap:8px;">

                    <?php if($isSelesai && isset($tka->surat_teks_approved) && $tka->surat_teks_approved == 1): ?>
                        <a href="<?= base_url('operator/download_surat_word/'.$tka->id) ?>" class="btn-primary" style="justify-content:center;">
                            <i class="fas fa-download"></i> Download Surat
                        </a>
                    <?php endif; ?>

                    <a href="<?= base_url('operator/edit_nomor_surat/'.$tka->id) ?>" class="btn-secondary" style="justify-content:center;">
                        <i class="fas fa-hashtag"></i> Edit Nomor Surat
                    </a>

                    <!-- Tombol Edit Data TKA -->
                    <!--<a href="<?= base_url('operator/edit_tka/'.$tka->id) ?>" class="btn-secondary" style="justify-content:center;">
                        <i class="fas fa-pen"></i> Edit Data TKA
                    </a>-->

                    <!-- Tombol Hapus Pengajuan -->
                    <!--<div style="margin-top:4px;padding-top:12px;border-top:1px solid var(--c-border);">
                        <a href="<?= base_url('operator/delete_tka/'.$tka->id) ?>"
                           class="btn-xs bx-delete" style="width:100%;justify-content:center;padding:7px 0;"
                           onclick="return confirm('Yakin hapus data TKA ini? Semua file akan dihapus.')">
                            <i class="fas fa-trash"></i> Hapus Pengajuan
                        </a>
                    </div>-->

                </div>
            </div>

            <!-- Info Singkat -->
            <div class="surface">
                <div class="surface-header">
                    <div class="surface-title">
                        <i class="fas fa-circle-info" style="color:#3b82f6;"></i>
                        Info Singkat
                    </div>
                </div>
                <div style="padding:0;">
                    <div class="info-row" style="border-right:none;">
                        <div class="info-icon" style="background:#eff6ff;color:#3b82f6;"><i class="fas fa-id-badge"></i></div>
                        <div>
                            <div class="info-label">ID Pengajuan</div>
                            <div class="info-value mono">#<?= $tka->id ?></div>
                        </div>
                    </div>
                    <div class="info-row" style="border-right:none;">
                        <div class="info-icon" style="background:#f5f3ff;color:#7c3aed;"><i class="fas fa-building"></i></div>
                        <div>
                            <div class="info-label">Perusahaan</div>
                            <div class="info-value"><?= htmlspecialchars($perusahaan_nama) ?></div>
                        </div>
                    </div>
                    <div class="info-row" style="border-right:none;">
                        <div class="info-icon" style="background:#fef3c7;color:#d97706;"><i class="fas fa-calendar-plus"></i></div>
                        <div>
                            <div class="info-label">Tanggal Pengajuan</div>
                            <div class="info-value"><?= date('d M Y', strtotime($tka->created_at)) ?></div>
                        </div>
                    </div>
                    <?php if($tka->nomor_surat_keluar): ?>
                    <div class="info-row" style="border-right:none;">
                        <div class="info-icon"><i class="fas fa-paper-plane"></i></div>
                        <div>
                            <div class="info-label">No. Surat Keluar</div>
                            <div class="info-value mono"><?= htmlspecialchars($tka->nomor_surat_keluar) ?></div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if($tka->nomor_surat_permohonan): ?>
                    <div class="info-row" style="border-right:none;border-bottom:none;">
                        <div class="info-icon"><i class="fas fa-inbox"></i></div>
                        <div>
                            <div class="info-label">No. Surat Permohonan</div>
                            <div class="info-value mono"><?= htmlspecialchars($tka->nomor_surat_permohonan) ?></div>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="info-row" style="border-right:none;border-bottom:none;">
                        <div class="info-icon" style="background:#fef3c7;color:#d97706;"><i class="fas fa-hashtag"></i></div>
                        <div>
                            <div class="info-label">Nomor Surat</div>
                            <div class="info-value empty">Belum diisi</div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

        </div><!-- /RIGHT -->
        </div><!-- /grid -->

    </main>

    <?php $this->load->view('footer'); ?>
</div>

<script>
(function(){
    var sidebar = document.getElementById('mainSidebar');
    var btn     = document.getElementById('sidebarToggle');
    var chevron = document.getElementById('toggleChevron');
    if (!sidebar || !btn) return;
    if (localStorage.getItem('sidebarCollapsed') === '1') {
        sidebar.classList.add('collapsed');
        if (chevron) chevron.style.transform = 'rotate(180deg)';
    }
    btn.addEventListener('click', function(){
        sidebar.classList.toggle('collapsed');
        var c = sidebar.classList.contains('collapsed');
        localStorage.setItem('sidebarCollapsed', c ? '1' : '0');
        if (chevron) chevron.style.transform = c ? 'rotate(180deg)' : 'rotate(0deg)';
    });
})();
</script>
</body>
</html>