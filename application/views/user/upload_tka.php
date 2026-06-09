<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload TKA — SITLAKEB TKA</title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/shared.css') ?>">
    <style>
        /* ================================================================
           FORM FIELD BASE
        ================================================================ */
        .form-label {
            display: block;
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--c-text-muted);
            text-transform: uppercase;
            letter-spacing: 0.055em;
            margin-bottom: 7px;
        }
        .form-label .opt {
            font-weight: 400;
            font-size: 0.68rem;
            text-transform: none;
            letter-spacing: 0;
            color: #b8c8d8;
        }
        .form-label.required::after {
            content: " *";
            color: #f43f5e;
        }

        .form-input {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid var(--c-border-strong);
            border-radius: var(--r-md);
            background: var(--c-surface);
            font-family: var(--font-body);
            font-size: 0.86rem;
            color: var(--c-text);
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .form-input:focus {
            border-color: var(--c-primary);
            box-shadow: 0 0 0 3px var(--c-primary-glow);
        }
        .form-input::placeholder { color: #c0ccd8; }

        .field-hint {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.7rem;
            color: var(--c-text-muted);
            margin-top: 5px;
        }

        /* ================================================================
           SECTION TITLE
        ================================================================ */
        .doc-section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: var(--font-head);
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--c-text);
            padding: 14px 0 12px;
            border-bottom: 2px solid var(--c-primary-light);
            margin-bottom: 16px;
        }
        .doc-section-title .sec-icon {
            width: 30px; height: 30px;
            border-radius: var(--r-sm);
            display: flex; align-items: center; justify-content: center;
            font-size: 12px;
            flex-shrink: 0;
        }
        .sec-icon-pdf   { background: #fff1f2; color: #dc2626; }
        .sec-icon-img   { background: #eff6ff; color: #2563eb; }
        .doc-section-title .sec-note {
            margin-left: auto;
            font-size: 0.68rem;
            font-weight: 500;
            color: var(--c-text-muted);
            background: var(--c-surface-2);
            border: 1px solid var(--c-border);
            padding: 2px 8px;
            border-radius: 20px;
        }

        /* ================================================================
           FILE DROP ZONE — redesigned
        ================================================================ */
        .file-zone {
            position: relative;
            border: 1.5px dashed var(--c-border-strong);
            border-radius: var(--r-md);
            background: var(--c-surface-2);
            cursor: pointer;
            transition: all 0.18s;
            overflow: hidden;
        }
        .file-zone:hover { border-color: var(--c-primary); background: #f0faf6; }
        .file-zone.has-file {
            border-style: solid;
            border-color: var(--c-primary);
            background: #f0faf6;
        }
        .file-zone.error-zone {
            border-color: #f43f5e !important;
            background: #fff5f5 !important;
        }
        .file-zone input[type="file"] {
            position: absolute; inset: 0;
            opacity: 0; cursor: pointer;
            width: 100%; height: 100%;
            z-index: 2;
        }
        .file-zone-inner {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 14px;
            pointer-events: none;
        }

        /* File type icon badge */
        .fz-badge {
            width: 40px; height: 40px;
            border-radius: var(--r-md);
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
            flex-shrink: 0;
            transition: all 0.18s;
        }
        .fz-badge-pdf  { background: #fff1f2; color: #dc2626; border: 1px solid #fecdd3; }
        .fz-badge-img  { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
        .file-zone.has-file .fz-badge-pdf,
        .file-zone.has-file .fz-badge-img {
            background: var(--c-primary);
            color: white;
            border-color: var(--c-primary);
        }
        .file-zone.error-zone .fz-badge-pdf,
        .file-zone.error-zone .fz-badge-img {
            background: #fee2e2;
            color: #dc2626;
            border-color: #fecaca;
        }

        .fz-body { flex: 1; min-width: 0; }
        .fz-name {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--c-text);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 2px;
        }
        .fz-sub {
            font-size: 0.67rem;
            color: var(--c-text-muted);
        }
        .file-zone.has-file .fz-name { color: var(--c-primary); }
        .file-zone.has-file .fz-sub  { color: var(--c-primary-mid, #1e7d60); }

        /* Check mark when file selected */
        .fz-check {
            width: 20px; height: 20px;
            border-radius: 50%;
            background: var(--c-primary);
            color: white;
            display: flex; align-items: center; justify-content: center;
            font-size: 9px;
            flex-shrink: 0;
            opacity: 0;
            transform: scale(0);
            transition: all 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .file-zone.has-file .fz-check {
            opacity: 1;
            transform: scale(1);
        }

        /* Error message style */
        .invalid-feedback-custom {
            font-size: 0.7rem;
            color: #f43f5e;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .invalid-feedback-custom i {
            font-size: 0.65rem;
        }

        /* ================================================================
           PDF DOCS GRID — 2 col with bigger zones
        ================================================================ */
        .docs-grid-pdf {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        /* ================================================================
           IMAGE DOCS — side by side with preview (UNIFORM 4:3 ASPECT RATIO)
        ================================================================ */
        .docs-grid-img {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }
        .img-upload-card {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .img-preview-wrap {
            position: relative;
            width: 100%;
            aspect-ratio: 4 / 3;
            background: var(--c-surface-2);
            border: 1.5px dashed var(--c-border-strong);
            border-radius: var(--r-md);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: border-color 0.15s;
        }
        .img-preview-wrap.has-img {
            border-style: solid;
            border-color: var(--c-primary);
        }
        .img-preview-wrap.error-border {
            border-color: #f43f5e !important;
            background: #fff5f5;
        }
        .img-preview-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            color: var(--c-text-muted);
            font-size: 0.72rem;
            pointer-events: none;
            z-index: 1;
        }
        .img-preview-placeholder i { font-size: 1.6rem; opacity: 0.3; }
        .img-preview-el {
            position: absolute; inset: 0;
            width: 100%; height: 100%;
            object-fit: cover;
            object-position: center;
            display: none;
        }

        /* Photo size guide */
        .photo-guide {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.68rem;
            color: var(--c-text-muted);
            background: var(--c-surface-2);
            border: 1px solid var(--c-border);
            border-radius: var(--r-sm);
            padding: 5px 9px;
        }
        .photo-guide i { font-size: 10px; color: var(--c-primary); }

        /* ================================================================
           NAME INPUT — large, prominent
        ================================================================ */
        .name-input-wrap {
            position: relative;
        }
        .name-input-wrap .name-icon {
            position: absolute;
            left: 13px; top: 50%;
            transform: translateY(-50%);
            font-size: 14px;
            color: var(--c-text-muted);
            pointer-events: none;
        }
        .name-input-wrap .form-input {
            padding-left: 40px;
            font-size: 0.95rem;
            font-weight: 600;
            font-family: var(--font-head);
            letter-spacing: 0.01em;
        }

        /* ================================================================
           PROGRESS HEADER
        ================================================================ */
        .upload-progress-strip {
            display: flex;
            align-items: center;
            gap: 0;
            padding: 18px 22px;
            background: var(--c-surface-2);
            border-bottom: 1px solid var(--c-border);
        }
        .ups-step {
            display: flex;
            align-items: center;
            gap: 9px;
            flex: 1;
        }
        .ups-dot {
            width: 32px; height: 32px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.72rem; font-weight: 800;
            font-family: var(--font-head);
            flex-shrink: 0;
            transition: all 0.2s;
        }
        .ups-dot.done   { background: var(--c-primary); color: white; }
        .ups-dot.active { background: var(--c-primary-light); color: var(--c-primary); border: 2px solid var(--c-primary); }
        .ups-dot.idle   { background: var(--c-border); color: var(--c-text-muted); }
        .ups-label {
            font-size: 0.73rem; font-weight: 600;
            line-height: 1.2;
        }
        .ups-label .ups-num  { color: var(--c-text-muted); font-size: 0.62rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.04em; }
        .ups-label .ups-text { color: var(--c-text); }
        .ups-line {
            flex: 1; height: 2px;
            background: var(--c-border);
            margin: 0 12px;
            border-radius: 2px;
            transition: background 0.3s;
        }
        .ups-line.done { background: var(--c-primary); }

        /* ================================================================
           ALERT
        ================================================================ */
        .alert-strip {
            display: flex;
            gap: 10px;
            align-items: flex-start;
            background: #fff1f2;
            border: 1px solid #fecdd3;
            border-left: 4px solid #f43f5e;
            border-radius: var(--r-md);
            padding: 12px 14px;
            font-size: 0.8rem;
            color: #9f1239;
            margin-bottom: 20px;
        }

        /* ================================================================
           ACTION BAR
        ================================================================ */
        .form-action-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            padding: 16px 22px;
            border-top: 1px solid var(--c-border);
            background: var(--c-surface-2);
        }

        .btn-submit {
            background: var(--c-primary);
            color: white;
            border: none;
            border-radius: 40px;
            padding: 0 28px;
            height: 44px;
            font-family: var(--font-body);
            font-size: 0.86rem;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background 0.15s, transform 0.1s, box-shadow 0.15s;
            box-shadow: 0 2px 12px rgba(26,107,82,0.28);
        }
        .btn-submit:hover { background: #145c44; transform: translateY(-1px); box-shadow: 0 5px 18px rgba(26,107,82,0.36); }
        .btn-submit:active { transform: translateY(0); }

        .btn-cancel {
            background: var(--c-surface);
            color: var(--c-text-muted);
            border: 1.5px solid var(--c-border-strong);
            border-radius: 40px;
            padding: 0 22px;
            height: 44px;
            font-family: var(--font-body);
            font-size: 0.86rem;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            text-decoration: none;
            transition: background 0.15s, color 0.15s;
        }
        .btn-cancel:hover { background: var(--c-surface-2); color: var(--c-text); text-decoration: none; }

        /* Upload count indicator */
        .upload-counter {
            font-size: 0.73rem;
            color: var(--c-text-muted);
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .upload-counter strong { color: var(--c-primary); font-family: var(--font-head); font-size: 0.85rem; }

        /* ================================================================
           RESPONSIVE
        ================================================================ */
        @media (max-width: 640px) {
            .docs-grid-pdf { grid-template-columns: 1fr; }
            .docs-grid-img { grid-template-columns: 1fr; }
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
            <strong>Upload TKA Baru</strong>
        </div>
        <div class="topnav-actions">
            <a href="<?= base_url('user/data_tka') ?>" class="topnav-btn" title="Data TKA">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
    </header>

    <main class="page-content">

        <div class="page-header" style="margin-bottom:20px;">
            <div class="page-title">Upload Data TKA</div>
            <div class="page-subtitle">Lengkapi nama TKA dan unggah seluruh dokumen yang diperlukan</div>
        </div>

        <div class="surface" style="max-width:900px;">

            <!-- Progress strip -->
            <div class="upload-progress-strip">
                <div class="ups-step">
                    <div class="ups-dot active">1</div>
                    <div class="ups-label">
                        <div class="ups-num">Langkah 1</div>
                        <div class="ups-text">Data & Dokumen</div>
                    </div>
                </div>
                <div class="ups-line"></div>
                <div class="ups-step">
                    <div class="ups-dot idle">2</div>
                    <div class="ups-label">
                        <div class="ups-num">Langkah 2</div>
                        <div class="ups-text">Detail TKA</div>
                    </div>
                </div>
                <div class="ups-line"></div>
                <div class="ups-step">
                    <div class="ups-dot idle">3</div>
                    <div class="ups-label">
                        <div class="ups-num">Langkah 3</div>
                        <div class="ups-text">Verifikasi</div>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <form action="<?= base_url('user/do_upload') ?>" method="post"
                  enctype="multipart/form-data" id="uploadForm">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                       value="<?= $this->security->get_csrf_hash(); ?>">

                <div style="padding:24px 24px 0;">

                    <!-- Error -->
                    <?php if($this->session->flashdata('error')): ?>
                    <div class="alert-strip">
                        <i class="fas fa-exclamation-circle" style="flex-shrink:0; margin-top:1px;"></i>
                        <?= $this->session->flashdata('error') ?>
                    </div>
                    <?php endif; ?>

                    <!-- Nama TKA -->
                    <div style="margin-bottom:24px;">
                        <label class="form-label required">Nama Tenaga Kerja Asing</label>
                        <div class="name-input-wrap">
                            <i class="fas fa-user-tie name-icon"></i>
                            <input type="text" name="nama_tka" class="form-input" required
                                   placeholder="Contoh: JOHN SMITH"
                                   style="text-transform:uppercase;"
                                   oninput="this.value=this.value.toUpperCase()"
                                   value="<?= set_value('nama_tka') ?>">
                        </div>
                        <div class="field-hint">
                            <i class="fas fa-circle-info"></i>
                            Nama lengkap sesuai paspor, otomatis huruf kapital.
                        </div>
                    </div>

                    <!-- ── Dokumen PDF ── -->
                    <div class="doc-section-title">
                        <div class="sec-icon sec-icon-pdf"><i class="fas fa-file-pdf"></i></div>
                        Dokumen PDF
                        <span class="sec-note">PDF · Maks. 2 MB per file</span>
                    </div>

                    <?php
                    $pdf_fields = [
                        'surat_permohonan'  => ['label' => 'Surat Permohonan',                              'icon' => 'fa-envelope-open-text','required' => true],
                        'passport'          => ['label' => 'Paspor (Halaman Identitas)',                    'icon' => 'fa-passport',          'required' => true],
                        'kitas'             => ['label' => 'Kartu Izin Tempat Tinggal (KITAS)',             'icon' => 'fa-id-card',           'required' => false],
                        'stm'               => ['label' => 'Surat Tanda Melapor (STM)',                     'icon' => 'fa-file-signature',    'required' => false],
                        'rptka'             => ['label' => 'Rencana Penggunaan Tenaga Kerja Asing (RPTKA)', 'icon' => 'fa-file-contract',     'required' => true],
                        'notifikasi'        => ['label' => 'Surat Notifikasi',                              'icon' => 'fa-bell',              'required' => true],
                        'bukti_bayar'       => ['label' => 'Bukti Bayar (PNBP)',                            'icon' => 'fa-receipt',           'required' => true],
                        'surat_kuasa'       => ['label' => 'Surat Kuasa',                                   'icon' => 'fa-file-contract',     'required' => true],
                        'surat_wajib_lapor' => ['label' => 'Surat Wajib Lapor Ketenagakerjaan',             'icon' => 'fa-file-alt',          'required' => true],
                    ];
                    ?>

                    <div class="docs-grid-pdf" style="margin-bottom:28px;">
                        <?php foreach($pdf_fields as $fname => $fdata): ?>
                        <div>
                            <label class="form-label <?= $fdata['required'] ? 'required' : '' ?>">
                                <?= $fdata['label'] ?>
                                <?php if( ! $fdata['required']): ?>
                                    <span class="opt">(Opsional)</span>
                                <?php endif; ?>
                            </label>
                            <div class="file-zone" id="zone_<?= $fname ?>">
                                <input type="file" name="<?= $fname ?>" accept=".pdf"
                                       <?= $fdata['required'] ? 'required' : '' ?>
                                       onchange="validateAndSetFile('<?= $fname ?>', this, 'pdf')">
                                <div class="file-zone-inner">
                                    <div class="fz-badge fz-badge-pdf">
                                        <i class="fas <?= $fdata['icon'] ?>"></i>
                                    </div>
                                    <div class="fz-body">
                                        <div class="fz-name" id="fzname_<?= $fname ?>">Pilih file PDF</div>
                                        <div class="fz-sub" id="fzsub_<?= $fname ?>">Klik atau seret ke sini</div>
                                    </div>
                                    <div class="fz-check" id="fzcheck_<?= $fname ?>">
                                        <i class="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="invalid-feedback-custom" id="error_<?= $fname ?>" style="display: none;">
                                <i class="fas fa-exclamation-circle"></i> <span></span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- ── Dokumen Gambar ── -->
                    <div class="doc-section-title">
                        <div class="sec-icon sec-icon-img"><i class="fas fa-image"></i></div>
                        Dokumen Gambar
                        <span class="sec-note">JPG/PNG · Maks. 2 MB per file</span>
                    </div>

                    <div class="docs-grid-img" style="margin-bottom:8px;">

                        <!-- KTP -->
                        <div class="img-upload-card">
                            <label class="form-label required">KTP Penanggung Jawab</label>
                            <div class="img-preview-wrap" id="wrap_ktp">
                                <div class="img-preview-placeholder" id="ph_ktp">
                                    <i class="fas fa-id-card"></i>
                                    <span>Pratinjau KTP</span>
                                </div>
                                <img class="img-preview-el" id="prev_ktp" alt="Preview KTP">
                            </div>
                            <div class="file-zone" id="zone_ktp" style="margin-top:0;">
                                <input type="file" name="ktp" accept="image/jpeg,image/jpg,image/png" required
                                       onchange="validateAndSetFile('ktp', this, 'image'); previewImg(this,'prev_ktp','wrap_ktp','ph_ktp')">
                                <div class="file-zone-inner">
                                    <div class="fz-badge fz-badge-img">
                                        <i class="fas fa-id-card"></i>
                                    </div>
                                    <div class="fz-body">
                                        <div class="fz-name" id="fzname_ktp">Pilih file gambar</div>
                                        <div class="fz-sub">Klik atau seret ke sini</div>
                                    </div>
                                    <div class="fz-check" id="fzcheck_ktp"><i class="fas fa-check"></i></div>
                                </div>
                            </div>
                            <div class="invalid-feedback-custom" id="error_ktp" style="display: none;">
                                <i class="fas fa-exclamation-circle"></i> <span></span>
                            </div>
                            <div class="photo-guide">
                                <i class="fas fa-info-circle"></i>
                                KTP harus terbaca jelas, scan/foto langsung (JPG/PNG)
                            </div>
                        </div>

                        <!-- Foto TKA -->
                        <div class="img-upload-card">
                            <label class="form-label required">Foto TKA</label>
                            <div class="img-preview-wrap" id="wrap_foto">
                                <div class="img-preview-placeholder" id="ph_foto">
                                    <i class="fas fa-user-circle"></i>
                                    <span>Pratinjau Foto</span>
                                </div>
                                <img class="img-preview-el" id="prev_foto" alt="Preview Foto TKA">
                            </div>
                            <div class="file-zone" id="zone_foto" style="margin-top:0;">
                                <input type="file" name="foto" accept="image/jpeg,image/jpg,image/png" required
                                       onchange="validateAndSetFile('foto', this, 'image'); previewImg(this,'prev_foto','wrap_foto','ph_foto')">
                                <div class="file-zone-inner">
                                    <div class="fz-badge fz-badge-img">
                                        <i class="fas fa-user-circle"></i>
                                    </div>
                                    <div class="fz-body">
                                        <div class="fz-name" id="fzname_foto">Pilih file gambar</div>
                                        <div class="fz-sub">Klik atau seret ke sini</div>
                                    </div>
                                    <div class="fz-check" id="fzcheck_foto"><i class="fas fa-check"></i></div>
                                </div>
                            </div>
                            <div class="invalid-feedback-custom" id="error_foto" style="display: none;">
                                <i class="fas fa-exclamation-circle"></i> <span></span>
                            </div>
                            <div class="photo-guide">
                                <i class="fas fa-info-circle"></i>
                                Foto TKA, JPG/PNG, akan ditampilkan dengan fokus tengah
                            </div>
                        </div>

                    </div>

                </div><!-- /padding wrap -->

                <!-- Action bar -->
                <div class="form-action-bar" style="margin-top:24px;">
                    <div class="upload-counter">
                        File terpilih: <strong id="fileCount">0</strong> / 11
                    </div>
                    <div style="display:flex; gap:10px; align-items:center;">
                        <a href="<?= base_url('user/data_tka') ?>" class="btn-cancel">
                            <i class="fas fa-times"></i> Batal
                        </a>
                        <button type="submit" class="btn-submit" id="submitBtn">
                            <i class="fas fa-cloud-upload-alt"></i> Simpan & Upload
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </main>
</div>

<?php $this->load->view('footer'); ?>

<script>
/* ── Sidebar toggle ── */
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

/* ── File validation and zone update (with type validation) ── */
function validateAndSetFile(fieldName, inputElement, typeCategory) {
    // Clear previous error
    clearFieldError(fieldName);
    
    var zone = document.getElementById('zone_' + fieldName);
    var labelSpan = document.getElementById('fzname_' + fieldName);
    var subSpan = document.getElementById('fzsub_' + fieldName);
    
    if (inputElement.files && inputElement.files[0]) {
        var file = inputElement.files[0];
        var isValid = true;
        var errorMsg = "";
        
        // Validate type based on category
        if (typeCategory === 'pdf') {
            if (file.type !== 'application/pdf' && !file.name.toLowerCase().endsWith('.pdf')) {
                isValid = false;
                errorMsg = "Tipe file tidak diizinkan. Harap unggah file PDF (.pdf)";
            }
        } 
        else if (typeCategory === 'image') {
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            const fileExt = file.name.split('.').pop().toLowerCase();
            const extAllowed = (fileExt === 'jpg' || fileExt === 'jpeg' || fileExt === 'png');
            if (!allowedTypes.includes(file.type) || !extAllowed) {
                isValid = false;
                errorMsg = "Tipe file tidak diizinkan. Harap unggah gambar JPG/JPEG/PNG";
            }
        }
        
        // Additional size validation (max 2MB)
        if (isValid && file.size > 2 * 1024 * 1024) {
            isValid = false;
            errorMsg = "Ukuran file melebihi batas maksimum 2 MB";
        }
        
        if (!isValid) {
            // Reset input value to clear invalid file
            inputElement.value = '';
            // Show error message
            showFieldError(fieldName, errorMsg);
            // Reset zone UI to empty state
            labelSpan.textContent = (typeCategory === 'pdf') ? 'Pilih file PDF' : 'Pilih file gambar';
            if (subSpan) subSpan.textContent = 'Klik atau seret ke sini';
            zone.classList.remove('has-file');
            zone.classList.add('error-zone');
            // For images, also reset preview
            if (typeCategory === 'image') {
                resetImagePreview(fieldName);
            }
            updateCounter();
            return;
        }
        
        // Valid file: update UI
        zone.classList.remove('error-zone');
        var fname = file.name.length > 26 ? file.name.substr(0, 24) + '…' : file.name;
        var fsize = (file.size / 1024).toFixed(0) + ' KB';
        labelSpan.textContent = fname;
        if (subSpan) subSpan.textContent = fsize;
        zone.classList.add('has-file');
    } else {
        // No file selected
        labelSpan.textContent = (typeCategory === 'pdf') ? 'Pilih file PDF' : 'Pilih file gambar';
        if (subSpan) subSpan.textContent = 'Klik atau seret ke sini';
        zone.classList.remove('has-file');
        zone.classList.remove('error-zone');
        if (typeCategory === 'image') {
            resetImagePreview(fieldName);
        }
    }
    updateCounter();
}

function showFieldError(fieldName, message) {
    var errorDiv = document.getElementById('error_' + fieldName);
    if (errorDiv) {
        errorDiv.style.display = 'flex';
        errorDiv.querySelector('span').textContent = message;
    }
}

function clearFieldError(fieldName) {
    var errorDiv = document.getElementById('error_' + fieldName);
    if (errorDiv) {
        errorDiv.style.display = 'none';
        errorDiv.querySelector('span').textContent = '';
    }
    // Also remove error styling from zone and preview wrap
    var zone = document.getElementById('zone_' + fieldName);
    if (zone) zone.classList.remove('error-zone');
    if (fieldName === 'ktp' || fieldName === 'foto') {
        var wrap = document.getElementById('wrap_' + fieldName);
        if (wrap) wrap.classList.remove('error-border');
    }
}

function resetImagePreview(fieldName) {
    var img = document.getElementById('prev_' + fieldName);
    var wrap = document.getElementById('wrap_' + fieldName);
    var ph = document.getElementById('ph_' + fieldName);
    if (img) {
        img.src = '';
        img.style.display = 'none';
    }
    if (wrap) wrap.classList.remove('has-img', 'error-border');
    if (ph) ph.style.display = 'flex';
}

/* ── Image preview with type safety (already handled in validateAndSetFile) ── */
function previewImg(input, previewId, wrapId, phId) {
    if (input.files && input.files[0]) {
        // check if file is valid image type again for preview
        var file = input.files[0];
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!allowedTypes.includes(file.type) && !file.name.match(/\.(jpg|jpeg|png)$/i)) {
            return; // preview not shown, error already handled in validateAndSetFile
        }
        var reader = new FileReader();
        reader.onload = function(e) {
            var img = document.getElementById(previewId);
            var wrap = document.getElementById(wrapId);
            var ph = document.getElementById(phId);
            img.src = e.target.result;
            img.style.display = 'block';
            wrap.classList.add('has-img');
            if(ph) ph.style.display = 'none';
        };
        reader.readAsDataURL(file);
    }
}

/* ── File counter ── */
function updateCounter() {
    var inputs = document.querySelectorAll('#uploadForm input[type="file"]');
    var count = 0;
    inputs.forEach(function(i){ if(i.files && i.files.length > 0) count++; });
    var counterSpan = document.getElementById('fileCount');
    if (counterSpan) counterSpan.textContent = count;
}

/* ── Drag & drop enhancement with validation ── */
document.querySelectorAll('.file-zone').forEach(function(zone){
    zone.addEventListener('dragover', function(e){
        e.preventDefault();
        this.style.borderColor = 'var(--c-primary)';
        this.style.background  = '#e6f5ef';
    });
    zone.addEventListener('dragleave', function(){
        if (!this.classList.contains('has-file') && !this.classList.contains('error-zone')) {
            this.style.borderColor = '';
            this.style.background  = '';
        }
    });
    zone.addEventListener('drop', function(e){
        e.preventDefault();
        var inp = this.querySelector('input[type="file"]');
        if (inp && e.dataTransfer.files.length) {
            inp.files = e.dataTransfer.files;
            // Determine category based on accept attribute
            var accept = inp.getAttribute('accept');
            var typeCat = (accept && accept.includes('pdf')) ? 'pdf' : 'image';
            var fieldName = inp.getAttribute('name');
            validateAndSetFile(fieldName, inp, typeCat);
            if (typeCat === 'image') {
                // Trigger preview
                var previewId = (fieldName === 'ktp') ? 'prev_ktp' : (fieldName === 'foto' ? 'prev_foto' : '');
                var wrapId = (fieldName === 'ktp') ? 'wrap_ktp' : (fieldName === 'foto' ? 'wrap_foto' : '');
                var phId = (fieldName === 'ktp') ? 'ph_ktp' : (fieldName === 'foto' ? 'ph_foto' : '');
                if (previewId) previewImg(inp, previewId, wrapId, phId);
            }
        }
    });
});

/* ── Final submit validation (additional safety) ── */
var REQUIRED_PDF = <?php echo json_encode(array_keys(array_filter($pdf_fields, function($f){ return $f['required']; }))); ?>;
var LABEL_PDF    = <?php
    $labels = [];
    foreach($pdf_fields as $k => $f) if($f['required']) $labels[] = $f['label'];
    echo json_encode($labels);
?>;

document.getElementById('uploadForm').addEventListener('submit', function(e){
    // Re-validate all required files and types before submit
    var hasError = false;
    
    // Validate required PDFs
    for (var i = 0; i < REQUIRED_PDF.length; i++) {
        var inp = document.querySelector('input[name="'+REQUIRED_PDF[i]+'"]');
        if (!inp || inp.files.length === 0) {
            showFieldError(REQUIRED_PDF[i], 'Dokumen wajib diupload');
            var zone = document.getElementById('zone_'+REQUIRED_PDF[i]);
            if(zone) zone.classList.add('error-zone');
            hasError = true;
        } else {
            var file = inp.files[0];
            if (file.type !== 'application/pdf' && !file.name.toLowerCase().endsWith('.pdf')) {
                showFieldError(REQUIRED_PDF[i], 'Tipe file tidak diizinkan. Harap unggah PDF');
                var zoneErr = document.getElementById('zone_'+REQUIRED_PDF[i]);
                if(zoneErr) zoneErr.classList.add('error-zone');
                hasError = true;
            } else if (file.size > 2 * 1024 * 1024) {
                showFieldError(REQUIRED_PDF[i], 'Ukuran file melebihi 2 MB');
                var zoneErr2 = document.getElementById('zone_'+REQUIRED_PDF[i]);
                if(zoneErr2) zoneErr2.classList.add('error-zone');
                hasError = true;
            } else {
                clearFieldError(REQUIRED_PDF[i]);
            }
        }
    }
    
    // Validate images (ktp & foto)
    var imgFields = [
        { name: 'ktp',  label: 'KTP Penanggung Jawab' },
        { name: 'foto', label: 'Foto TKA' }
    ];
    for (var j = 0; j < imgFields.length; j++) {
        var inpImg = document.querySelector('input[name="'+imgFields[j].name+'"]');
        if (!inpImg || inpImg.files.length === 0) {
            showFieldError(imgFields[j].name, 'Gambar wajib diupload');
            var zoneImg = document.getElementById('zone_'+imgFields[j].name);
            if(zoneImg) zoneImg.classList.add('error-zone');
            var wrapImg = document.getElementById('wrap_'+imgFields[j].name);
            if(wrapImg) wrapImg.classList.add('error-border');
            hasError = true;
        } else {
            var fileImg = inpImg.files[0];
            const allowed = ['image/jpeg', 'image/jpg', 'image/png'];
            const extOk = fileImg.name.match(/\.(jpg|jpeg|png)$/i);
            if (!allowed.includes(fileImg.type) || !extOk) {
                showFieldError(imgFields[j].name, 'Tipe file tidak diizinkan. Harap unggah JPG/JPEG/PNG');
                var zoneErrImg = document.getElementById('zone_'+imgFields[j].name);
                if(zoneErrImg) zoneErrImg.classList.add('error-zone');
                var wrapErr = document.getElementById('wrap_'+imgFields[j].name);
                if(wrapErr) wrapErr.classList.add('error-border');
                hasError = true;
            } else if (fileImg.size > 2 * 1024 * 1024) {
                showFieldError(imgFields[j].name, 'Ukuran file melebihi 2 MB');
                var zoneErrSize = document.getElementById('zone_'+imgFields[j].name);
                if(zoneErrSize) zoneErrSize.classList.add('error-zone');
                hasError = true;
            } else {
                clearFieldError(imgFields[j].name);
            }
        }
    }
    
    // Also check optional PDFs for type if they exist (tidak wajib tapi jika diupload harus valid)
    var allPdfFields = <?php echo json_encode(array_keys($pdf_fields)); ?>;
    for (var k = 0; k < allPdfFields.length; k++) {
        var optInp = document.querySelector('input[name="'+allPdfFields[k]+'"]');
        if (optInp && optInp.files.length > 0) {
            var optFile = optInp.files[0];
            if (optFile.type !== 'application/pdf' && !optFile.name.toLowerCase().endsWith('.pdf')) {
                showFieldError(allPdfFields[k], 'Tipe file tidak diizinkan. Harap unggah PDF');
                var zoneOpt = document.getElementById('zone_'+allPdfFields[k]);
                if(zoneOpt) zoneOpt.classList.add('error-zone');
                hasError = true;
            } else if (optFile.size > 2 * 1024 * 1024) {
                showFieldError(allPdfFields[k], 'Ukuran file melebihi 2 MB');
                var zoneOptSize = document.getElementById('zone_'+allPdfFields[k]);
                if(zoneOptSize) zoneOptSize.classList.add('error-zone');
                hasError = true;
            } else {
                clearFieldError(allPdfFields[k]);
            }
        }
    }
    
    if (hasError) {
        e.preventDefault();
        // Scroll to first error
        var firstError = document.querySelector('.invalid-feedback-custom[style*="display: flex"]');
        if (firstError) firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        alert('Mohon perbaiki error pada file yang ditandai. Hanya file yang bermasalah perlu diganti, data lain tetap tersimpan.');
        return false;
    }
    
    // Disable button to prevent double submit
    var btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengupload...';
});

// Initial counter update
window.addEventListener('DOMContentLoaded', function() {
    updateCounter();
});
</script>
</body>
</html>