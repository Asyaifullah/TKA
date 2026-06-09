<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail & Edit TKA — <?= htmlspecialchars($tka->nama_tka ?? 'Error') ?></title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/shared.css') ?>">
    <style>

        /* ── Burger (mobile only) ── */
        .topnav-burger {
            display: none;
            width: 34px; height: 34px;
            border-radius: 9px;
            border: 1px solid var(--c-border);
            background: var(--c-surface-2, #f8fafc);
            align-items: center; justify-content: center;
            color: var(--c-text-muted); font-size: 13px;
            cursor: pointer; flex-shrink: 0;
            transition: background .15s, color .15s;
        }
        .topnav-burger:hover { background: var(--c-primary-light); color: var(--c-primary); }

        .page-content { padding: 20px 28px 32px; }

        /* ── Page header ── */
        .page-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 20px; flex-wrap: wrap; gap: 12px;
        }
        .page-header-left { display: flex; align-items: center; gap: 14px; }
        .tka-avatar {
            width: 52px; height: 52px; border-radius: 14px;
            background: var(--c-primary); color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; font-weight: 800; flex-shrink: 0;
        }
        .tka-name { font-size: 1rem; font-weight: 700; color: var(--c-text); margin-bottom: 4px; line-height: 1.3; }
        .tka-meta { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
        .badge-status {
            display: inline-flex; align-items: center; gap: 4px;
            font-size: 0.66rem; font-weight: 700; padding: 2px 9px;
            border-radius: 20px; background: var(--c-primary-light);
            color: var(--c-primary); text-transform: uppercase; letter-spacing: 0.4px;
        }
        .meta-date { font-size: 0.76rem; color: var(--c-text-muted); }

        /* ── Info banner ── */
        .info-banner {
            display: flex; align-items: flex-start; gap: 10px;
            background: #eff8ff; border: 1px solid #bee3f8;
            border-radius: var(--r-md); padding: 11px 15px;
            font-size: 0.8rem; color: #1a5276;
            margin-bottom: 18px; line-height: 1.5;
        }
        .info-banner i { color: #2980b9; margin-top: 1px; flex-shrink: 0; }

        /* ── Alert ── */
        .alert-custom {
            display: flex; align-items: flex-start; gap: 9px;
            border-radius: var(--r-md); font-size: 0.82rem;
            padding: 11px 14px; margin-bottom: 12px; line-height: 1.5;
        }
        .alert-custom i { margin-top: 1px; flex-shrink: 0; }
        .alert-err { background: #fff5f5; border: 1px solid #feb2b2; color: #822727; }
        .alert-ok  { background: #f0fff4; border: 1px solid #9ae6b4; color: #1a5c35; }

        /* ── Surface ── */
        .surface {
            background: var(--c-surface);
            border: 1px solid var(--c-border);
            border-radius: var(--r-md);
            overflow: hidden; margin-bottom: 16px;
        }
        .surface-header {
            display: flex; align-items: center; gap: 10px;
            padding: 12px 20px; border-bottom: 1px solid var(--c-border);
            background: var(--c-surface-2);
        }
        .surface-icon {
            width: 30px; height: 30px; border-radius: 8px;
            background: var(--c-primary-light); color: var(--c-primary);
            display: flex; align-items: center; justify-content: center;
            font-size: 0.78rem; flex-shrink: 0;
        }
        .surface-title { font-size: 0.87rem; font-weight: 700; color: var(--c-text); margin: 0; }
        .surface-body  { padding: 20px 22px; }

        /* ── Form divider ── */
        .form-divider {
            display: flex; align-items: center; gap: 10px;
            margin: 18px 0 14px;
        }
        .form-divider span {
            font-size: 0.66rem; font-weight: 700; color: var(--c-text-muted);
            white-space: nowrap; text-transform: uppercase; letter-spacing: 0.5px;
        }
        .form-divider::before, .form-divider::after { content: ''; flex: 1; height: 1px; background: var(--c-border); }
        .form-divider:first-child { margin-top: 0; }

        /* ── Field group ── */
        .fgroup { margin-bottom: 14px; }
        .fgroup:last-child { margin-bottom: 0; }
        .fl {
            display: block; font-size: 0.71rem; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.5px;
            color: var(--c-text-muted); margin-bottom: 5px;
        }
        .fl .req { color: #e53e3e; margin-left: 1px; }

        /* ── Inputs ── */
        .f-input, .f-select, .f-textarea {
            width: 100%;
            border: 1px solid var(--c-border); border-radius: var(--r-md);
            padding: 9px 12px;
            font-family: var(--font-body); font-size: 0.875rem;
            color: var(--c-text); background: var(--c-surface); outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
            -webkit-appearance: none;
        }
        .f-input:focus, .f-select:focus, .f-textarea:focus {
            border-color: var(--c-primary);
            box-shadow: 0 0 0 3px var(--c-primary-glow);
        }
        .f-input::placeholder, .f-textarea::placeholder { color: var(--c-border); }
        .f-textarea { resize: vertical; min-height: 72px; line-height: 1.6; }
        .f-select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 12px center;
            padding-right: 30px; cursor: pointer;
        }

        /* ── Field grid ── */
        .field-grid         { display: grid; grid-template-columns: repeat(2, 1fr); gap: 14px; }
        .field-grid.cols-3  { grid-template-columns: repeat(3, 1fr); }
        .field-grid.cols-12 { grid-template-columns: 1fr 1fr; }
        .col-full           { grid-column: 1 / -1; }

        /* ── Two-col layout per section ── */
        .two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }

        /* ── File grid ── */
        .file-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 10px;
        }
        .file-item {
            background: var(--c-surface-2); border: 1px solid var(--c-border);
            border-radius: var(--r-md); padding: 10px 12px;
            display: flex; align-items: center; gap: 10px;
            font-size: 0.78rem; transition: border-color .15s, background .15s;
        }
        .file-item:hover { border-color: var(--c-primary); background: var(--c-primary-light); }
        .file-item-icon {
            width: 30px; height: 30px; border-radius: 7px;
            background: var(--c-surface); border: 1px solid var(--c-border);
            display: flex; align-items: center; justify-content: center;
            color: #e53e3e; font-size: 0.82rem; flex-shrink: 0;
        }
        .file-item-icon.is-img { color: #3b82f6; }
        .file-item-info        { overflow: hidden; min-width: 0; }
        .file-item-label       { font-weight: 600; color: var(--c-text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-size: 0.76rem; }
        .file-item-link        { color: var(--c-primary); text-decoration: none; font-size: 0.7rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block; }
        .file-item-link:hover  { text-decoration: underline; }
        .no-file               { font-size: 0.8rem; color: var(--c-text-muted); padding: 12px 0; display: flex; align-items: center; gap: 7px; }

        /* ── Form actions ── */
        .form-actions {
            background: var(--c-surface); border: 1px solid var(--c-border);
            border-radius: var(--r-md); padding: 16px 20px;
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 12px; margin-bottom: 8px;
        }
        .form-actions-hint { font-size: 0.76rem; color: var(--c-text-muted); display: flex; align-items: center; gap: 6px; }
        .form-actions-hint i { color: #d97706; }
        .btn-group-right { display: flex; align-items: center; gap: 8px; }

        .btn-save {
            display: inline-flex; align-items: center; gap: 7px;
            background: var(--c-primary); color: #fff; border: none;
            border-radius: var(--r-md); padding: 0 20px; height: 40px;
            font-family: var(--font-body); font-size: 0.85rem; font-weight: 600;
            cursor: pointer; transition: opacity .15s, transform .1s;
        }
        .btn-save:hover:not(:disabled)  { opacity: 0.88; }
        .btn-save:active:not(:disabled) { transform: scale(0.98); }

        .btn-back {
            display: inline-flex; align-items: center; gap: 7px;
            color: var(--c-text-muted); background: transparent;
            border: 1px solid var(--c-border); border-radius: var(--r-md);
            padding: 0 18px; height: 40px;
            font-family: var(--font-body); font-size: 0.84rem; font-weight: 500;
            cursor: pointer; text-decoration: none;
            transition: border-color .15s, color .15s;
        }
        .btn-back:hover { border-color: var(--c-primary); color: var(--c-primary); }

        /* ──────────────────────────────────────
           RESPONSIVE
        ────────────────────────────────────── */
        @media (max-width: 900px) {
            .field-grid.cols-3 { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 768px) {

            /* topnav */
            .topnav { padding: 0 12px !important; }
            .topnav-burger { display: flex; }
            .topnav-breadcrumb .bc-hide { display: none; }

            /* page content */
            .page-content { padding: 12px 12px 28px !important; }

            /* page header */
            .page-header      { margin-bottom: 14px; gap: 10px; }
            .tka-avatar       { width: 44px; height: 44px; font-size: 1.1rem; border-radius: 12px; }
            .tka-name         { font-size: 0.9rem; }
            .meta-date        { font-size: 0.7rem; }

            /* info banner */
            .info-banner      { font-size: 0.76rem; padding: 10px 13px; margin-bottom: 14px; }

            /* surface */
            .surface          { border-radius: 14px !important; margin-bottom: 12px; }
            .surface-header   { padding: 11px 16px !important; }
            .surface-title    { font-size: 0.84rem !important; }
            .surface-body     { padding: 14px 16px !important; }

            /* form divider */
            .form-divider     { margin: 14px 0 12px; }
            .form-divider:first-child { margin-top: 0; }

            /* field group */
            .fgroup           { margin-bottom: 12px; }
            .fl               { font-size: 0.67rem !important; margin-bottom: 4px; }

            /* Semua grid → 1 kolom */
            .two-col,
            .field-grid,
            .field-grid.cols-3,
            .field-grid.cols-12 { grid-template-columns: 1fr !important; gap: 12px !important; }
            .col-full           { grid-column: 1 !important; }

            /* iOS zoom prevention */
            .f-input, .f-select, .f-textarea { font-size: 16px !important; padding: 10px 12px !important; }

            /* File grid: 2 kolom di mobile */
            .file-grid { grid-template-columns: 1fr 1fr !important; gap: 8px; }
            .file-item { padding: 9px 10px; gap: 8px; }
            .file-item-label { font-size: 0.72rem; }
            .file-item-link  { font-size: 0.66rem; }

            /* Form actions */
            .form-actions {
                flex-direction: column; align-items: stretch;
                padding: 14px 16px; gap: 10px;
            }
            .btn-group-right  { flex-direction: column-reverse; gap: 8px; }
            .btn-save, .btn-back {
                width: 100% !important; justify-content: center;
                height: 46px !important; font-size: 0.9rem !important;
                border-radius: 12px !important;
            }
        }

        @media (max-width: 480px) {
            /* File grid: 1 kolom di layar sangat kecil */
            .file-grid { grid-template-columns: 1fr !important; }
        }
    </style>
</head>
<body>

<?php $this->load->view('admin/sidebar'); ?>

<div class="page-wrapper">

    <header class="topnav">
        <div class="topnav-breadcrumb">
            <!-- Burger mobile -->
            <button class="topnav-burger" id="adminBurger" aria-label="Buka Menu">
                <i class="fas fa-bars"></i>
            </button>
            <a href="<?= base_url('dashboard') ?>" style="color:var(--c-text-muted);text-decoration:none;">
                <i class="fas fa-home"></i>
            </a>
            <i class="fas fa-chevron-right bc-hide" style="font-size:8px;"></i>
            <a href="<?= base_url('admin/semua_tka') ?>" class="bc-hide" style="color:var(--c-text-muted);text-decoration:none;">Data TKA</a>
            <i class="fas fa-chevron-right" style="font-size:8px;"></i>
            <strong>Detail / Edit TKA</strong>
        </div>
    </header>

    <main class="page-content">

        <?php if(!isset($tka) || !$tka): ?>
        <div class="alert-custom alert-err">
            <i class="fas fa-exclamation-circle"></i>
            Data TKA tidak ditemukan.
            <a href="<?= base_url('admin/semua_tka') ?>" style="color:var(--c-primary);margin-left:4px;">Kembali ke daftar</a>
        </div>
        <?php else: ?>

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-header-left">
                <div class="tka-avatar"><?= strtoupper(substr($tka->nama_tka, 0, 1)) ?></div>
                <div>
                    <div class="tka-name"><?= htmlspecialchars($tka->nama_tka) ?></div>
                    <div class="tka-meta">
                        <span class="badge-status"><?= htmlspecialchars($tka->status) ?></span>
                        <span class="meta-date">
                            <i class="fas fa-calendar-alt" style="margin-right:3px;"></i>
                            Diajukan <?= date('d M Y', strtotime($tka->created_at)) ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Flash -->
        <?php if($this->session->flashdata('error')): ?>
        <div class="alert-custom alert-err">
            <i class="fas fa-exclamation-circle"></i>
            <?= $this->session->flashdata('error') ?>
        </div>
        <?php endif; ?>
        <?php if($this->session->flashdata('success')): ?>
        <div class="alert-custom alert-ok">
            <i class="fas fa-check-circle"></i>
            <?= $this->session->flashdata('success') ?>
        </div>
        <?php endif; ?>

        <!-- Info banner -->
        <div class="info-banner">
            <i class="fas fa-info-circle"></i>
            Form ini sudah terisi dari data perusahaan. Ubah jika diperlukan, lalu simpan.
        </div>

        <form action="<?= base_url('admin/save_detail/'.$tka->id) ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                   value="<?= $this->security->get_csrf_hash(); ?>">

            <!-- SECTION 1: Identitas & Dokumen -->
            <div class="surface">
                <div class="surface-header">
                    <div class="surface-icon"><i class="fas fa-id-card"></i></div>
                    <div class="surface-title">Identitas &amp; Dokumen TKA</div>
                </div>
                <div class="surface-body">
                    <div class="two-col">

                        <!-- Kolom kiri: Identitas -->
                        <div>
                            <div class="form-divider"><span>Identitas</span></div>
                            <div class="fgroup">
                                <label class="fl">Jabatan <span class="req">*</span></label>
                                <input type="text" name="jabatan" class="f-input" required
                                       value="<?= htmlspecialchars($tka->jabatan ?? '') ?>"
                                       placeholder="Contoh: Director">
                            </div>
                            <div class="fgroup">
                                <label class="fl">Kebangsaan <span class="req">*</span></label>
                                <input type="text" name="negara_asal" class="f-input" required
                                       value="<?= htmlspecialchars($tka->negara_asal ?? '') ?>"
                                       placeholder="Contoh: Japan">
                            </div>
                            <div class="fgroup">
                                <label class="fl">Tempat Lahir <span class="req">*</span></label>
                                <input type="text" name="tempat_lahir" class="f-input" required
                                       value="<?= htmlspecialchars($tka->tempat_lahir ?? '') ?>">
                            </div>
                            <div class="field-grid cols-12">
                                <div class="fgroup">
                                    <label class="fl">Tanggal Lahir <span class="req">*</span></label>
                                    <input type="date" name="tanggal_lahir" class="f-input" required
                                           value="<?= $tka->tanggal_lahir ?? '' ?>">
                                </div>
                                <div class="fgroup">
                                    <label class="fl">Jenis Kelamin <span class="req">*</span></label>
                                    <select name="jenis_kelamin" class="f-select" required>
                                        <option value="">— Pilih —</option>
                                        <option value="Laki-laki"  <?= ($tka->jenis_kelamin ?? '') == 'Laki-laki'  ? 'selected' : '' ?>>Laki-laki</option>
                                        <option value="Perempuan"  <?= ($tka->jenis_kelamin ?? '') == 'Perempuan'  ? 'selected' : '' ?>>Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="fgroup">
                                <label class="fl">Alamat Tinggal</label>
                                <textarea name="alamat_tinggal" class="f-textarea" rows="2"
                                          placeholder="Opsional"><?= htmlspecialchars($tka->alamat_tinggal ?? '') ?></textarea>
                            </div>
                        </div>

                        <!-- Kolom kanan: Dokumen -->
                        <div>
                            <div class="form-divider"><span>Dokumen Perjalanan</span></div>
                            <div class="fgroup">
                                <label class="fl">Nomor Passport <span class="req">*</span></label>
                                <input type="text" name="passport_no" class="f-input" required
                                       value="<?= htmlspecialchars($tka->passport_no ?? '') ?>"
                                       inputmode="numeric"
                                       oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                                       placeholder="Hanya angka">
                            </div>
                            <div class="fgroup">
                                <label class="fl">Masa Berlaku Passport</label>
                                <input type="date" name="passport_expiry" class="f-input"
                                       value="<?= $tka->passport_expiry ?? '' ?>">
                            </div>
                            <div class="fgroup">
                                <label class="fl">Nomor KITAS <span class="req">*</span></label>
                                <input type="text" name="kitas_no" class="f-input" required
                                       value="<?= htmlspecialchars($tka->kitas_no ?? '') ?>"
                                       inputmode="numeric"
                                       oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                                       placeholder="Hanya angka">
                            </div>
                            <div class="fgroup">
                                <label class="fl">Nomor STM</label>
                                <input type="text" name="stm_no" class="f-input"
                                       value="<?= htmlspecialchars($tka->stm_no ?? '') ?>"
                                       inputmode="numeric"
                                       oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                                       placeholder="Opsional">
                            </div>
                            <div class="field-grid cols-12">
                                <div class="fgroup">
                                    <label class="fl">Nomor RPTKA</label>
                                    <input type="text" name="rptka_no" class="f-input"
                                           value="<?= htmlspecialchars($tka->rptka_no ?? '') ?>">
                                </div>
                                <div class="fgroup">
                                    <label class="fl">Tanggal RPTKA</label>
                                    <input type="date" name="rptka_date" class="f-input"
                                           value="<?= $tka->rptka_date ?? '' ?>">
                                </div>
                            </div>
                        </div>

                    </div><!-- /two-col -->
                </div>
            </div>

            <!-- SECTION 2: Notifikasi & Pekerjaan -->
            <div class="surface">
                <div class="surface-header">
                    <div class="surface-icon"><i class="fas fa-bell"></i></div>
                    <div class="surface-title">Notifikasi &amp; Pekerjaan</div>
                </div>
                <div class="surface-body">
                    <div class="field-grid cols-3">

                        <!-- Notifikasi -->
                        <div>
                            <div class="fgroup">
                                <label class="fl">Nomor Notifikasi</label>
                                <input type="text" name="notifikasi_no" class="f-input"
                                       value="<?= htmlspecialchars($tka->notifikasi_no ?? '') ?>">
                            </div>
                            <div class="fgroup">
                                <label class="fl">Tanggal Notifikasi</label>
                                <input type="date" name="notifikasi_date" class="f-input"
                                       value="<?= $tka->notifikasi_date ?? '' ?>">
                            </div>
                        </div>

                        <!-- Jenis & masa berlaku -->
                        <div>
                            <div class="fgroup">
                                <label class="fl">Jenis Notifikasi <span class="req">*</span></label>
                                <select name="jenis_notifikasi" class="f-select" required>
                                    <option value="">— Pilih —</option>
                                    <option value="Baru"          <?= ($tka->jenis_notifikasi ?? '') == 'Baru'          ? 'selected' : '' ?>>Baru</option>
                                    <option value="jangka pendek" <?= ($tka->jenis_notifikasi ?? '') == 'jangka pendek' ? 'selected' : '' ?>>Jangka Pendek</option>
                                    <option value="Perpanjangan"  <?= ($tka->jenis_notifikasi ?? '') == 'Perpanjangan'  ? 'selected' : '' ?>>Perpanjangan</option>
                                </select>
                            </div>
                            <div class="fgroup">
                                <label class="fl">Masa Berlaku Notifikasi</label>
                                <input type="text" name="masa_berlaku_notifikasi" class="f-input"
                                       value="<?= htmlspecialchars($tka->masa_berlaku_notifikasi ?? '') ?>"
                                       placeholder="Contoh: 1 Tahun">
                            </div>
                        </div>

                        <!-- Pekerjaan & DKP -->
                        <div>
                            <div class="fgroup">
                                <label class="fl">Lokasi Kerja</label>
                                <input type="text" name="lokasi_kerja" class="f-input"
                                       value="<?= htmlspecialchars($tka->lokasi_kerja ?? '') ?>">
                            </div>
                            <div class="fgroup">
                                <label class="fl">Bidang Usaha <span class="req">*</span></label>
                                <input type="text" name="bidang_usaha" class="f-input" required
                                       value="<?= htmlspecialchars($tka->bidang_usaha ?? '') ?>">
                            </div>
                            <div class="fgroup">
                                <label class="fl">Status DKP <span class="req">*</span></label>
                                <select name="lunas_dkp" class="f-select" required>
                                    <option value="">— Pilih —</option>
                                    <option value="Lunas"       <?= ($tka->lunas_dkp ?? '') == 'Lunas'       ? 'selected' : '' ?>>Lunas</option>
                                    <option value="Belum Lunas" <?= ($tka->lunas_dkp ?? '') == 'Belum Lunas' ? 'selected' : '' ?>>Belum Lunas</option>
                                </select>
                            </div>
                        </div>

                    </div><!-- /field-grid cols-3 -->
                </div>
            </div>

            <!-- SECTION 3: Berkas -->
            <div class="surface">
                <div class="surface-header">
                    <div class="surface-icon"><i class="fas fa-folder-open"></i></div>
                    <div class="surface-title">Berkas Terupload</div>
                </div>
                <div class="surface-body">
                    <?php
                    $fields = [
                        'surat_permohonan' => ['Surat Permohonan', 'pdf'],
                        'passport'         => ['Passport',         'pdf'],
                        'kitas'            => ['KITAS',            'pdf'],
                        'stm'              => ['STM',              'pdf'],
                        'rptka'            => ['RPTKA',            'pdf'],
                        'notifikasi'       => ['Notifikasi',       'pdf'],
                        'bukti_bayar'      => ['Bukti Bayar',      'pdf'],
                        'surat_kuasa'      => ['Surat Kuasa',      'pdf'],
                        'ktp'              => ['KTP',              'img'],
                        'foto'             => ['Foto TKA',         'img'],
                    ];
                    $has_files = false;
                    if(isset($berkas) && $berkas) {
                        foreach($fields as $key => $info) {
                            if(!empty($berkas->$key)) { $has_files = true; break; }
                        }
                    }
                    ?>
                    <?php if($has_files): ?>
                    <div class="file-grid">
                        <?php foreach($fields as $key => [$label, $type]): ?>
                            <?php if(!empty($berkas->$key)): ?>
                            <div class="file-item">
                                <div class="file-item-icon <?= $type === 'img' ? 'is-img' : '' ?>">
                                    <i class="fas <?= $type === 'img' ? 'fa-image' : 'fa-file-pdf' ?>"></i>
                                </div>
                                <div class="file-item-info">
                                    <div class="file-item-label"><?= $label ?></div>
                                    <a href="<?= base_url('uploads/'.$tka->id.'/'.$berkas->$key) ?>"
                                       target="_blank" class="file-item-link">
                                        <?= htmlspecialchars($berkas->$key) ?>
                                    </a>
                                </div>
                            </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                    <p class="no-file">
                        <i class="fas fa-inbox" style="opacity:0.4;"></i>
                        Belum ada berkas yang diupload.
                    </p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <div class="form-actions-hint">
                    <i class="fas fa-exclamation-triangle"></i>
                    Field bertanda <strong style="color:#e53e3e;margin:0 2px;">*</strong> wajib diisi
                </div>
                <div class="btn-group-right">
                    <a href="<?= base_url('admin/semua_tka') ?>" class="btn-back">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn-save">
                        <i class="fas fa-floppy-disk"></i> Simpan Perubahan
                    </button>
                </div>
            </div>

        </form>

        <?php endif; ?>
    </main>
</div>

<?php $this->load->view('footer'); ?>

<script>
(function(){
    /* ── Burger ── */
    var burger = document.getElementById('adminBurger');
    if (burger) {
        burger.addEventListener('click', function(e) {
            e.stopPropagation();
            if (typeof window.openAdminSidebar === 'function') window.openAdminSidebar();
        });
    }

    /* ── Sidebar collapse (desktop) ── */
    var sidebar = document.getElementById('adminSidebar');
    var toggle  = document.getElementById('adminSidebarToggle');
    if (sidebar && toggle) {
        toggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            localStorage.setItem('adminSidebarCollapsed', sidebar.classList.contains('collapsed') ? '1' : '0');
        });
    }
    if (sidebar && localStorage.getItem('adminSidebarCollapsed') === '1') {
        sidebar.classList.add('collapsed');
    }
})();
</script>
</body>
</html>