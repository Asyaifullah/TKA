<!DOCTYPE html>
<html lang="<?= current_lang() == 'indonesian' ? 'id' : 'en' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->lang->line('tka_detail_title') ?? 'Detail TKA' ?> — <?= htmlspecialchars($tka->nama_tka) ?></title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/shared.css') ?>">
    <style>

        /* ── Info rows (label + value) ── */
        .info-row {
            display: flex;
            align-items: flex-start;
            gap: 0;
            padding: 10px 0;
            border-bottom: 1px solid var(--c-border);
            font-size: 0.83rem;
        }
        .info-row:last-child { border-bottom: none; }
        .info-key {
            flex: 0 0 200px;
            font-size: 0.73rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: var(--c-text-muted);
            padding-top: 1px;
        }
        .info-val {
            flex: 1;
            color: var(--c-text);
            font-weight: 500;
            line-height: 1.5;
        }
        .info-val.empty { color: var(--c-text-muted); font-weight: 400; font-style: italic; }

        /* ── Progress stepper ── */
        .stepper {
            display: flex;
            align-items: flex-start;
            gap: 0;
            margin: 20px 0 4px;
        }
        .step {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            text-align: center;
        }
        .step:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 15px;
            left: 50%;
            width: 100%;
            height: 2px;
            background: var(--c-border);
            z-index: 0;
        }
        .step.done:not(:last-child)::after { background: var(--c-primary); }
        .step-dot {
            width: 30px; height: 30px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 11px;
            font-weight: 700;
            border: 2px solid var(--c-border);
            background: var(--c-surface);
            color: var(--c-text-muted);
            position: relative;
            z-index: 1;
            transition: all 0.2s;
        }
        .step.done .step-dot {
            background: var(--c-primary);
            border-color: var(--c-primary);
            color: white;
        }
        .step.active .step-dot {
            background: var(--c-surface);
            border-color: var(--c-primary);
            color: var(--c-primary);
            box-shadow: 0 0 0 4px var(--c-primary-glow);
        }
        .step.rejected .step-dot {
            background: #fff1f2;
            border-color: #f43f5e;
            color: #f43f5e;
        }
        .step-label {
            font-size: 0.65rem;
            font-weight: 600;
            color: var(--c-text-muted);
            margin-top: 6px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }
        .step.done .step-label  { color: var(--c-primary); }
        .step.active .step-label { color: var(--c-primary); }
        .step.rejected .step-label { color: #f43f5e; }

        /* ── Rejection box ── */
        .reject-box {
            background: #fff1f2;
            border: 1px solid #fecdd3;
            border-left: 4px solid #f43f5e;
            border-radius: var(--r-md);
            padding: 14px 16px;
            font-size: 0.82rem;
            color: #9f1239;
        }
        .reject-box strong { display: block; margin-bottom: 5px; }

        /* ── Document grid ── */
        .doc-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 12px;
            padding: 18px 22px;
        }
        .doc-item {
            background: var(--c-surface-2);
            border: 1px solid var(--c-border);
            border-radius: var(--r-lg);
            padding: 14px 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            text-align: center;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .doc-item:hover { border-color: var(--c-primary); box-shadow: 0 2px 10px var(--c-primary-glow); }
        .doc-icon {
            width: 44px; height: 44px;
            border-radius: var(--r-md);
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
        }
        .doc-icon.pdf   { background: #fff1f2; color: #dc2626; }
        .doc-icon.image { background: var(--c-primary-light); color: var(--c-primary); }
        .doc-label {
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--c-text);
        }
        .doc-link {
            font-size: 0.68rem;
            color: var(--c-primary);
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 20px;
            background: var(--c-primary-light);
            transition: background 0.15s;
        }
        .doc-link:hover { background: #c5e8e1; color: var(--c-primary); text-decoration: none; }
        .doc-preview {
            width: 100%;
            max-height: 80px;
            object-fit: cover;
            border-radius: var(--r-sm);
            border: 1px solid var(--c-border);
        }

        /* ── Timeline log ── */
        .timeline { display: flex; flex-direction: column; gap: 0; }
        .tl-item {
            display: flex;
            gap: 14px;
            padding-bottom: 20px;
            position: relative;
        }
        .tl-item:not(:last-child)::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 32px;
            bottom: 0;
            width: 2px;
            background: var(--c-border);
        }
        .tl-dot {
            width: 32px; height: 32px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 11px;
            flex-shrink: 0;
            position: relative;
            z-index: 1;
        }
        .tl-dot.approve { background: #ecfdf5; color: #059669; border: 2px solid #a7f3d0; }
        .tl-dot.reject  { background: #fff1f2; color: #f43f5e; border: 2px solid #fecdd3; }
        /* dot untuk catatan sistem — netral abu-abu */
        .tl-dot.system  { background: var(--c-surface-2); color: var(--c-text-muted); border: 2px solid var(--c-border); }

        .tl-body { flex: 1; padding-top: 4px; }
        .tl-header {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 3px;
        }
        .tl-role {
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--c-text);
            text-transform: capitalize;
        }
        .tl-badge {
            font-size: 0.65rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 20px;
            text-transform: uppercase;
        }
        .tl-badge.approve { background: #ecfdf5; color: #065f46; }
        .tl-badge.reject  { background: #fff1f2; color: #9f1239; }
        /* badge sistem — abu-abu netral */
        .tl-badge.system  { background: var(--c-surface-2); color: var(--c-text-muted); border: 1px solid var(--c-border); }

        .tl-time { font-size: 0.68rem; color: var(--c-text-muted); }
        .tl-note {
            font-size: 0.78rem;
            background: var(--c-surface-2);
            border: 1px solid var(--c-border);
            border-radius: var(--r-sm);
            padding: 8px 12px;
            margin-top: 6px;
            color: var(--c-text-mid);
            line-height: 1.5;
        }
        /* catatan sistem — italic lebih redup */
        .tl-note.system-note {
            color: var(--c-text-muted);
            font-style: italic;
            font-size: 0.73rem;
            background: transparent;
            border-style: dashed;
        }

        /* ── Section spacing ── */
        .detail-section { margin-bottom: 14px; }
        .surf-body-pad  { padding: 4px 22px 16px; }

        /* ── Action buttons ── */
        .btn-dl {
            background: var(--c-primary);
            color: white;
            border: none;
            border-radius: 40px;
            padding: 0 22px;
            height: 40px;
            font-family: var(--font-body);
            font-size: 0.83rem;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            text-decoration: none;
            transition: background 0.15s, transform 0.1s;
            box-shadow: 0 2px 8px rgba(26,107,82,0.25);
        }
        .btn-dl:hover { background: #145c44; transform: translateY(-1px); color: white; text-decoration: none; }

        .btn-back {
            background: var(--c-surface);
            color: var(--c-text-muted);
            border: 1px solid var(--c-border-strong);
            border-radius: 40px;
            padding: 0 20px;
            height: 40px;
            font-family: var(--font-body);
            font-size: 0.83rem;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            text-decoration: none;
            transition: background 0.15s;
        }
        .btn-back:hover { background: var(--c-surface-2); color: var(--c-text); text-decoration: none; }

        .btn-disabled {
            background: var(--c-surface-2);
            color: var(--c-text-muted);
            border: 1px solid var(--c-border);
            border-radius: 40px;
            padding: 0 20px;
            height: 40px;
            font-family: var(--font-body);
            font-size: 0.83rem;
            cursor: not-allowed;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            opacity: 0.7;
        }

        @media (max-width: 600px) {
            .info-key { flex: 0 0 130px; }
            .doc-grid { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
</head>
<body>

<?php $this->load->view('user/sidebar'); ?>

<div class="page-wrapper">

    <header class="topnav">
        <div class="topnav-breadcrumb">
            <a href="<?= base_url('dashboard') ?>" style="color:var(--c-text-muted); text-decoration:none;"><i class="fas fa-home"></i></a>
            <i class="fas fa-chevron-right" style="font-size:8px;"></i>
            <a href="<?= base_url('user/data_tka') ?>" style="color:var(--c-text-muted); text-decoration:none;"><?= $this->lang->line('tka_breadcrumb') ?? 'Data TKA' ?></a>
            <i class="fas fa-chevron-right" style="font-size:8px;"></i>
            <strong><?= htmlspecialchars($tka->nama_tka) ?></strong>
        </div>
        <div class="topnav-actions">
            <?php if($tka->status == 'SELESAI' && $tka->surat_teks_approved == 1): ?>
                <a href="<?= base_url('user/download_surat_word/'.$tka->id) ?>" class="btn-dl">
                    <i class="fas fa-download"></i> <?= $this->lang->line('tka_download_letter') ?? 'Download Surat (Word)' ?>
                </a>
            <?php endif; ?>
        </div>
    </header>

    <main class="page-content">

        <?php
        $stages  = ['MENUNGGU_KASI'=>1,'MENUNGGU_KABID'=>2,'MENUNGGU_SEKDIS'=>3,'MENUNGGU_KADIS'=>4,'SELESAI'=>5];
        $current = isset($stages[$tka->status]) ? $stages[$tka->status] : 0;
        $is_done = ($tka->status === 'SELESAI');
        $is_rejected = ($tka->status === 'DITOLAK');

        /*
         * Daftar pola catatan sistem otomatis.
         * Log yang catatannya cocok dengan salah satu pola ini
         * akan ditampilkan sebagai "info sistem", bukan sebagai penolakan.
         */
        $system_note_patterns = [
            'Auto-created by fallback',
            'Pengajuan baru oleh perusahaan',
            'Diteruskan dari Kepala Seksi',
            'Diteruskan dari',   // tangkap semua varian "Diteruskan dari ..."
            'Auto-created',      // tangkap semua varian auto-created
        ];

        /**
         * Cek apakah sebuah log adalah catatan sistem otomatis.
         * Return true jika catatan mengandung salah satu pola di atas.
         */
        function is_system_log($catatan, $patterns) {
            if (empty($catatan)) return false;
            foreach ($patterns as $p) {
                if (stripos($catatan, $p) !== false) return true;
            }
            return false;
        }
        ?>

        <!-- ── Page header ── -->
        <div class="page-header" style="margin-bottom:20px;">
            <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
                <div>
                    <div class="page-title"><?= htmlspecialchars($tka->nama_tka) ?></div>
                    <div style="display:flex; align-items:center; gap:8px; margin-top:5px; flex-wrap:wrap;">
                        <?php if($is_rejected): ?>
                            <span class="badge badge-ditolak"><span class="badge-dot" style="background:#f43f5e;"></span> <?= $this->lang->line('tka_status_rejected') ?? 'Ditolak' ?></span>
                        <?php elseif($is_done): ?>
                            <span class="badge badge-selesai"><span class="badge-dot" style="background:#10b981;"></span> <?= $this->lang->line('tka_status_done') ?? 'Selesai' ?></span>
                        <?php else: ?>
                            <span class="badge badge-proses"><span class="badge-dot" style="background:#3b82f6;"></span> <?= $this->lang->line('tka_status_process') ?? 'Dalam Proses' ?></span>
                        <?php endif; ?>
                        <span style="font-size:0.72rem; color:var(--c-text-muted);">
                            <i class="fas fa-clock" style="font-size:9px;"></i>
                            Diajukan <?= date('d M Y, H:i', strtotime($tka->created_at)) ?> <?= $this->lang->line('auth_wib') ?? 'WIB' ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ── 1. Progress Stepper ── -->
        <div class="surface detail-section">
            <div class="surface-header">
                <div class="surface-title">
                    <i class="fas fa-tasks"></i> <?= $this->lang->line('tka_approval_progress') ?? 'Progress Approval' ?>
                </div>
                <?php if(!$is_rejected): ?>
                <span style="font-size:0.72rem; color:var(--c-text-muted);">
                    <?= sprintf($this->lang->line('tka_stage_of') ?? 'Tahap %s dari 5', $current) ?>
                </span>
                <?php endif; ?>
            </div>
            <div style="padding:20px 24px 24px;">

                <?php if($is_rejected): ?>
                    <!-- Rejection notice -->
                    <?php if(!empty($logs)):
                        $reject_log = null;
                        foreach($logs as $log) {
                            if($log->status == 'reject' && !is_system_log($log->catatan, $system_note_patterns)) {
                                $reject_log = $log;
                            }
                        }
                        if($reject_log): ?>
                    <div class="reject-box">
                        <strong><i class="fas fa-times-circle me-1"></i> <?= $this->lang->line('tka_rejection_title') ?? 'Pengajuan Ditolak' ?></strong>
                        <?= nl2br(htmlspecialchars($reject_log->catatan)) ?>
                        <div style="margin-top:7px; font-size:0.72rem; color:#b91c1c; opacity:0.8;">
                            <?= $this->lang->line('tka_rejected_by') ?? 'Oleh:' ?> <?= ucfirst($reject_log->role) ?> &nbsp;·&nbsp; <?= date('d M Y, H:i', strtotime($reject_log->created_at)) ?>
                        </div>
                    </div>
                    <?php endif; endif; ?>
                <?php else: ?>
                    <!-- Stepper -->
                    <?php
                    $step_defs = [
                        1 => ['label' => $this->lang->line('tka_step_kasi') ?? 'Kasi',   'icon' => 'fa-user-check'],
                        2 => ['label' => $this->lang->line('tka_step_kabid') ?? 'Kabid',  'icon' => 'fa-user-tie'],
                        3 => ['label' => $this->lang->line('tka_step_sekdis') ?? 'Sekdis', 'icon' => 'fa-user-shield'],
                        4 => ['label' => $this->lang->line('tka_step_kadis') ?? 'Kadis',  'icon' => 'fa-user-crown'],
                        5 => ['label' => $this->lang->line('tka_step_done') ?? 'Selesai','icon' => 'fa-check-double'],
                    ];
                    ?>
                    <div class="stepper">
                        <?php foreach($step_defs as $n => $s):
                            $cls = '';
                            if($current >= $n) $cls = 'done';
                            if($current === $n - 1 && !$is_done) $cls = 'active';
                            if($n === $current && !$is_done) $cls = 'active';
                        ?>
                        <div class="step <?= $cls ?>">
                            <div class="step-dot">
                                <?php if($current >= $n): ?>
                                    <i class="fas fa-check" style="font-size:10px;"></i>
                                <?php else: ?>
                                    <?= $n ?>
                                <?php endif; ?>
                            </div>
                            <div class="step-label"><?= $s['label'] ?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Current stage pill -->
                    <?php
                    $stage_label = [
                        'MENUNGGU_KASI'   => $this->lang->line('tka_waiting_kasi') ?? 'Menunggu verifikasi Kasi',
                        'MENUNGGU_KABID'  => $this->lang->line('tka_waiting_kabid') ?? 'Menunggu verifikasi Kabid',
                        'MENUNGGU_SEKDIS' => $this->lang->line('tka_waiting_sekdis') ?? 'Menunggu verifikasi Sekdis',
                        'MENUNGGU_KADIS'  => $this->lang->line('tka_waiting_kadis') ?? 'Menunggu verifikasi Kadis',
                        'SELESAI'         => $this->lang->line('tka_letter_issued') ?? 'Surat telah terbit',
                    ];
                    ?>
                    <div style="margin-top:14px; text-align:center;">
                        <span class="progress-pill <?= $is_done ? 'pp-selesai' : 'pp-kasi' ?>" style="font-size:0.75rem; padding:5px 14px;">
                            <i class="fas <?= $is_done ? 'fa-check-double' : 'fa-hourglass-half' ?>" style="font-size:9px;"></i>
                            <?= $stage_label[$tka->status] ?? $tka->status ?>
                        </span>
                    </div>
                <?php endif; ?>

            </div>
        </div>

        <!-- ── 2. Dokumen ── -->
        <div class="surface detail-section">
            <div class="surface-header">
                <div class="surface-title">
                    <i class="fas fa-folder-open"></i> <?= $this->lang->line('tka_uploaded_docs') ?? 'Dokumen yang Diupload' ?>
                </div>
            </div>
            <?php
            $file_fields = [
                'surat_permohonan' => $this->lang->line('tka_doc_surat_permohonan') ?? 'Surat Permohonan',
                'passport'         => $this->lang->line('tka_doc_passport') ?? 'Passport',
                'kitas'            => $this->lang->line('tka_doc_kitas') ?? 'KITAS',
                'stm'              => $this->lang->line('tka_doc_stm') ?? 'STM',
                'rptka'            => $this->lang->line('tka_doc_rptka') ?? 'RPTKA',
                'notifikasi'       => $this->lang->line('tka_doc_notifikasi') ?? 'Notifikasi',
                'bukti_bayar'      => $this->lang->line('tka_doc_bukti_bayar') ?? 'Bukti Bayar',
                'surat_kuasa'      => $this->lang->line('tka_doc_surat_kuasa') ?? 'Surat Kuasa',
                'surat_wajib_lapor' => $this->lang->line('tka_doc_surat_wajib_lapor') ?? 'Surat Wajib Lapor',
                'ktp'              => $this->lang->line('tka_ktp_label') ?? 'KTP',
                'foto'             => $this->lang->line('tka_photo_label') ?? 'Foto TKA',
            ];
            $has_file = false;
            foreach($file_fields as $field => $label) {
                if(!empty($berkas->$field)) { $has_file = true; break; }
            }
            ?>
            <?php if(!$has_file): ?>
                <div class="empty-state" style="padding:32px 24px;">
                    <div class="empty-state-icon"><i class="fas fa-folder"></i></div>
                    <p style="margin:0; font-size:0.82rem;"><?= $this->lang->line('tka_no_docs') ?? 'Belum ada dokumen yang diupload.' ?></p>
                </div>
            <?php else: ?>
            <div class="doc-grid">
                <?php foreach($file_fields as $field => $label):
                    $file = $berkas->$field ?? '';
                    if(!$file) continue;
                    $ext      = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                    $is_image = in_array($ext, ['jpg','jpeg','png']);
                    $file_url = base_url('uploads/'.$tka->id.'/'.$file);
                ?>
                <div class="doc-item">
                    <?php if($is_image): ?>
                        <a href="<?= $file_url ?>" target="_blank" style="width:100%;">
                            <img src="<?= $file_url ?>" class="doc-preview" alt="<?= $label ?>">
                        </a>
                    <?php else: ?>
                        <div class="doc-icon pdf"><i class="fas fa-file-pdf"></i></div>
                    <?php endif; ?>
                    <div class="doc-label"><?= $label ?></div>
                    <a href="<?= $file_url ?>" target="_blank" class="doc-link">
                        <i class="fas fa-eye" style="font-size:9px;"></i>
                        <?= $is_image ? ($this->lang->line('tka_view_doc') ?? 'Lihat') : ($this->lang->line('tka_open_pdf') ?? 'Buka PDF') ?>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- ── 3. Data Detail TKA ── -->
        <div class="surface detail-section">
            <div class="surface-header">
                <div class="surface-title">
                    <i class="fas fa-id-card"></i> <?= $this->lang->line('tka_detail_data') ?? 'Data Detail TKA' ?>
                </div>
            </div>
            <div style="padding:4px 22px 16px;">

                <!-- Identitas Dokumen -->
                <div style="padding-top:14px; padding-bottom:4px; font-size:0.68rem; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:var(--c-primary);">
                    <?= $this->lang->line('tka_identity_docs') ?? 'Dokumen Identitas' ?>
                </div>
                <div class="info-row">
                    <div class="info-key"><?= $this->lang->line('tka_passport_no') ?? 'Nomor Passport' ?></div>
                    <div class="info-val <?= empty($tka->passport_no) ? 'empty' : '' ?>"><?= $tka->passport_no ?? '—' ?></div>
                </div>
                <div class="info-row">
                    <div class="info-key"><?= $this->lang->line('tka_passport_expiry') ?? 'Masa Berlaku Passport' ?></div>
                    <div class="info-val <?= empty($tka->passport_expiry) ? 'empty' : '' ?>">
                        <?= $tka->passport_expiry ? date('d M Y', strtotime($tka->passport_expiry)) : '—' ?>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-key"><?= $this->lang->line('tka_kitas_no') ?? 'Nomor KITAS' ?></div>
                    <div class="info-val <?= empty($tka->kitas_no) ? 'empty' : '' ?>"><?= $tka->kitas_no ?? '—' ?></div>
                </div>
                <div class="info-row">
                    <div class="info-key"><?= $this->lang->line('tka_stm_no') ?? 'Nomor STM' ?></div>
                    <div class="info-val <?= empty($tka->stm_no) ? 'empty' : '' ?>"><?= $tka->stm_no ?? '—' ?></div>
                </div>

                <!-- RPTKA -->
                <div style="padding-top:18px; padding-bottom:4px; font-size:0.68rem; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:var(--c-primary);">
                    <?= $this->lang->line('tka_rptka_data') ?? 'Data RPTKA' ?>
                </div>
                <div class="info-row">
                    <div class="info-key"><?= $this->lang->line('tka_rptka_no') ?? 'Nomor RPTKA' ?></div>
                    <div class="info-val <?= empty($tka->rptka_no) ? 'empty' : '' ?>"><?= $tka->rptka_no ?? '—' ?></div>
                </div>
                <div class="info-row">
                    <div class="info-key"><?= $this->lang->line('tka_rptka_date') ?? 'Tanggal RPTKA' ?></div>
                    <div class="info-val <?= empty($tka->rptka_date) ? 'empty' : '' ?>">
                        <?= $tka->rptka_date ? date('d M Y', strtotime($tka->rptka_date)) : '—' ?>
                    </div>
                </div>

                <!-- Data Pribadi -->
                <div style="padding-top:18px; padding-bottom:4px; font-size:0.68rem; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:var(--c-primary);">
                    <?= $this->lang->line('tka_personal_data') ?? 'Data Pribadi TKA' ?>
                </div>
                <div class="info-row">
                    <div class="info-key"><?= $this->lang->line('tka_position') ?? 'Jabatan' ?></div>
                    <div class="info-val <?= empty($tka->jabatan) ? 'empty' : '' ?>"><?= $tka->jabatan ?? '—' ?></div>
                </div>
                <div class="info-row">
                    <div class="info-key"><?= $this->lang->line('tka_birthplace') ?? 'Tempat Lahir' ?></div>
                    <div class="info-val <?= empty($tka->tempat_lahir) ? 'empty' : '' ?>"><?= $tka->tempat_lahir ?? '—' ?></div>
                </div>
                <div class="info-row">
                    <div class="info-key"><?= $this->lang->line('tka_birthdate') ?? 'Tanggal Lahir' ?></div>
                    <div class="info-val <?= empty($tka->tanggal_lahir) ? 'empty' : '' ?>">
                        <?= $tka->tanggal_lahir ? date('d M Y', strtotime($tka->tanggal_lahir)) : '—' ?>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-key"><?= $this->lang->line('tka_nationality') ?? 'Kebangsaan' ?></div>
                    <div class="info-val <?= empty($tka->negara_asal) ? 'empty' : '' ?>"><?= $tka->negara_asal ?? '—' ?></div>
                </div>
                <div class="info-row">
                    <div class="info-key"><?= $this->lang->line('tka_gender') ?? 'Jenis Kelamin' ?></div>
                    <div class="info-val <?= empty($tka->jenis_kelamin) ? 'empty' : '' ?>"><?= $tka->jenis_kelamin ?? '—' ?></div>
                </div>
                <div class="info-row">
                    <div class="info-key"><?= $this->lang->line('tka_address') ?? 'Alamat Tinggal' ?></div>
                    <div class="info-val <?= empty($tka->alamat_tinggal) ? 'empty' : '' ?>">
                        <?= !empty($tka->alamat_tinggal) ? nl2br(htmlspecialchars($tka->alamat_tinggal)) : '—' ?>
                    </div>
                </div>

                <!-- Notifikasi & Pekerjaan -->
                <div style="padding-top:18px; padding-bottom:4px; font-size:0.68rem; font-weight:700; text-transform:uppercase; letter-spacing:0.06em; color:var(--c-primary);">
                    <?= $this->lang->line('tka_notif_work') ?? 'Notifikasi & Pekerjaan' ?>
                </div>
                <div class="info-row">
                    <div class="info-key"><?= $this->lang->line('tka_notif_no') ?? 'Nomor Notifikasi' ?></div>
                    <div class="info-val <?= empty($tka->notifikasi_no) ? 'empty' : '' ?>"><?= $tka->notifikasi_no ?? '—' ?></div>
                </div>
                <div class="info-row">
                    <div class="info-key"><?= $this->lang->line('tka_notif_date') ?? 'Tanggal Notifikasi' ?></div>
                    <div class="info-val <?= empty($tka->notifikasi_date) ? 'empty' : '' ?>">
                        <?= $tka->notifikasi_date ? date('d M Y', strtotime($tka->notifikasi_date)) : '—' ?>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-key"><?= $this->lang->line('tka_notif_type') ?? 'Jenis Notifikasi' ?></div>
                    <div class="info-val <?= empty($tka->jenis_notifikasi) ? 'empty' : '' ?>"><?= $tka->jenis_notifikasi ?? '—' ?></div>
                </div>
                <div class="info-row">
                    <div class="info-key"><?= $this->lang->line('tka_notif_expiry') ?? 'Masa Berlaku Notifikasi' ?></div>
                    <div class="info-val <?= empty($tka->masa_berlaku_notifikasi) ? 'empty' : '' ?>"><?= $tka->masa_berlaku_notifikasi ?? '—' ?></div>
                </div>
                <div class="info-row">
                    <div class="info-key"><?= $this->lang->line('tka_work_location') ?? 'Lokasi Kerja' ?></div>
                    <div class="info-val <?= empty($tka->lokasi_kerja) ? 'empty' : '' ?>"><?= $tka->lokasi_kerja ?? '—' ?></div>
                </div>
                <div class="info-row">
                    <div class="info-key"><?= $this->lang->line('tka_dkp_paid') ?? 'Lunas DKP-TKA' ?></div>
                    <div class="info-val">
                        <?php if(!empty($tka->lunas_dkp)): ?>
                            <?php if($tka->lunas_dkp == 'Lunas'): ?>
                                <span style="background:#ecfdf5; color:#065f46; padding:2px 10px; border-radius:20px; font-size:0.7rem; font-weight:700;">
                                    <i class="fas fa-check" style="font-size:9px;"></i> <?= $this->lang->line('tka_paid') ?? 'Lunas' ?>
                                </span>
                            <?php else: ?>
                                <span style="background:#fff1f2; color:#9f1239; padding:2px 10px; border-radius:20px; font-size:0.7rem; font-weight:700;">
                                    <i class="fas fa-times" style="font-size:9px;"></i> <?= $this->lang->line('tka_not_paid') ?? 'Belum Lunas' ?>
                                </span>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="empty">—</span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-key"><?= $this->lang->line('tka_business_field') ?? 'Bidang Usaha' ?></div>
                    <div class="info-val <?= empty($tka->bidang_usaha) ? 'empty' : '' ?>"><?= $tka->bidang_usaha ?? '—' ?></div>
                </div>

            </div>
        </div>

        <!-- ── 4. Riwayat Approval ── -->
        <div class="surface detail-section">
            <div class="surface-header">
                <div class="surface-title">
                    <i class="fas fa-history"></i> <?= $this->lang->line('tka_approval_history') ?? 'Riwayat Approval' ?>
                </div>
            </div>
            <div style="padding:20px 22px;">
                <?php if(empty($logs)): ?>
                    <p style="font-size:0.82rem; color:var(--c-text-muted); margin:0;"><?= $this->lang->line('tka_no_approval') ?? 'Belum ada proses approval.' ?></p>
                <?php else: ?>
                <div class="timeline">
                    <?php foreach(array_reverse($logs) as $log):
                        /*
                         * Tentukan apakah log ini adalah catatan sistem otomatis.
                         * Jika ya → tampilkan dengan style abu-abu netral (system),
                         * bukan merah reject, agar tidak membingungkan user.
                         */
                        $is_sys = is_system_log($log->catatan, $system_note_patterns);

                        if ($is_sys):
                            // ── Log sistem: dot + badge abu-abu, label "Info Sistem" ──
                    ?>
                    <div class="tl-item">
                        <div class="tl-dot system">
                            <i class="fas fa-info" style="font-size:10px;"></i>
                        </div>
                        <div class="tl-body">
                            <div class="tl-header">
                                <span class="tl-role" style="color:var(--c-text-muted); font-weight:600;"><?= $this->lang->line('tka_system') ?? 'Sistem' ?></span>
                                <span class="tl-badge system"><?= $this->lang->line('tka_info') ?? 'Info' ?></span>
                            </div>
                            <div class="tl-time">
                                <i class="fas fa-clock" style="font-size:9px;"></i>
                                <?= date('d M Y, H:i', strtotime($log->created_at)) ?> <?= $this->lang->line('auth_wib') ?? 'WIB' ?>
                            </div>
                            <?php if(!empty($log->catatan)): ?>
                                <div class="tl-note system-note">
                                    <i class="fas fa-info-circle" style="font-size:9px; margin-right:4px;"></i>
                                    <?= nl2br(htmlspecialchars($log->catatan)) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                        <?php else:
                            // ── Log manual (approve / reject nyata dari staff) ──
                        ?>
                    <div class="tl-item">
                        <div class="tl-dot <?= $log->status == 'approve' ? 'approve' : 'reject' ?>">
                            <i class="fas <?= $log->status == 'approve' ? 'fa-check' : 'fa-times' ?>" style="font-size:10px;"></i>
                        </div>
                        <div class="tl-body">
                            <div class="tl-header">
                                <span class="tl-role"><?= ucfirst($log->role) ?></span>
                                <span class="tl-badge <?= $log->status == 'approve' ? 'approve' : 'reject' ?>">
                                    <?= $log->status == 'approve' ? ($this->lang->line('tka_approved') ?? 'Disetujui') : ($this->lang->line('tka_status_rejected') ?? 'Ditolak') ?>
                                </span>
                            </div>
                            <div class="tl-time">
                                <i class="fas fa-clock" style="font-size:9px;"></i>
                                <?= date('d M Y, H:i', strtotime($log->created_at)) ?> <?= $this->lang->line('auth_wib') ?? 'WIB' ?>
                            </div>
                            <?php if(!empty($log->catatan)): ?>
                                <div class="tl-note">
                                    <i class="fas fa-comment-alt" style="font-size:9px; margin-right:4px;"></i>
                                    <?= nl2br(htmlspecialchars($log->catatan)) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- ── Bottom actions ── -->
        <div style="display:flex; gap:10px; flex-wrap:wrap; padding-bottom:8px;">
            <?php if($tka->status == 'SELESAI' && $tka->surat_teks_approved == 1): ?>
                <a href="<?= base_url('user/download_surat_word/'.$tka->id) ?>" class="btn-dl">
                    <i class="fas fa-download"></i> <?= $this->lang->line('tka_download_letter') ?? 'Download Surat (Word)' ?>
                </a>
            <?php else: ?>
                <span class="btn-disabled">
                    <i class="fas fa-hourglass-half"></i> <?= $this->lang->line('tka_letter_processing') ?? 'Surat sedang diproses' ?>
                </span>
            <?php endif; ?>
            <a href="<?= base_url('user/data_tka') ?>" class="btn-back">
                <i class="fas fa-arrow-left"></i> <?= $this->lang->line('tka_back_data') ?? 'Kembali ke Data TKA' ?>
            </a>
        </div>

    </main>
</div>

<?php $this->load->view('footer'); ?>

<script>
(function(){
    var sidebar = document.getElementById('mainSidebar');
    var btn     = document.getElementById('sidebarToggle');
    var chevron = document.getElementById('toggleChevron');
    if (!sidebar || !btn) return;
    if (localStorage.getItem('sidebarCollapsed') === '1') {
        sidebar.classList.add('collapsed');
        if(chevron) chevron.style.transform = 'rotate(180deg)';
    }
    btn.addEventListener('click', function(){
        sidebar.classList.toggle('collapsed');
        var c = sidebar.classList.contains('collapsed');
        localStorage.setItem('sidebarCollapsed', c ? '1' : '0');
        if(chevron) chevron.style.transform = c ? 'rotate(180deg)' : 'rotate(0deg)';
    });
})();
</script>
</body>
</html>