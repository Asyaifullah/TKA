<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Surat & TTD — SITLAKEB TKA Admin</title>
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

        /* ── Burger button (mobile only, di dalam topnav) ── */
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
        .topnav-burger:hover {
            background: var(--c-primary-light);
            color: var(--c-primary);
        }

        /* ── Form rows ── */
        .form-row {
            display: flex; align-items: flex-start; gap: 12px;
            padding: 16px 22px;
            border-bottom: 1px solid var(--c-border);
        }
        .form-row:last-child { border-bottom: none; }
        .form-row.fr-2col {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0; padding: 0;
        }

        .fr-cell {
            display: flex; align-items: flex-start; gap: 12px;
            padding: 16px 22px;
            border-bottom: 1px solid var(--c-border);
        }
        .fr-cell:first-child { border-right: 1px solid var(--c-border); }

        .form-icon {
            width: 32px; height: 32px; border-radius: var(--r-sm);
            background: var(--c-primary-light); color: var(--c-primary);
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; flex-shrink: 0; margin-top: 6px;
        }
        .form-field { flex: 1; }
        .form-label-inline {
            font-size: 0.67rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.07em;
            color: var(--c-text-muted); margin-bottom: 5px; display: block;
        }

        .form-control-clean {
            width: 100%;
            font-family: var(--font-body, 'DM Sans', sans-serif);
            font-size: 0.84rem; font-weight: 500;
            color: var(--c-text);
            background: var(--c-surface, #fff);
            border: 1px solid var(--c-border);
            border-radius: var(--r-sm);
            padding: 7px 11px; outline: none;
            transition: border-color 0.18s, box-shadow 0.18s;
        }
        .form-control-clean:focus {
            border-color: var(--c-primary);
            box-shadow: 0 0 0 3px var(--c-primary-light);
        }
        .form-control-clean.mono {
            font-family: 'Courier New', monospace;
            font-size: 0.8rem; color: var(--c-primary);
        }
        input[type="file"].form-control-clean { padding: 6px 11px; cursor: pointer; }
        input[type="file"].form-control-clean::-webkit-file-upload-button {
            background: var(--c-primary-light); color: var(--c-primary);
            border: none; border-radius: 4px;
            padding: 3px 10px; font-size: 0.75rem; font-weight: 700;
            font-family: var(--font-head); cursor: pointer; margin-right: 10px;
        }

        .field-hint {
            font-size: 0.69rem; color: var(--c-text-muted);
            margin-top: 4px; display: flex; align-items: flex-start; gap: 4px;
            line-height: 1.5;
        }

        /* ── Flash alert ── */
        .flash-alert {
            display: flex; align-items: flex-start; gap: 12px;
            border-radius: var(--r-lg); padding: 14px 18px;
            margin-bottom: 20px; font-size: 0.82rem;
        }
        .flash-success { background: #f0fdf4; border: 1px solid #a7f3d0; color: #065f46; }
        .flash-error   { background: #fff1f2; border: 1px solid #fecdd3; color: #9f1239; }
        .flash-alert .fa-icon { margin-top: 1px; font-size: 14px; flex-shrink: 0; }

        /* ── TTD preview ── */
        .ttd-preview-wrap {
            display: flex; align-items: center; gap: 20px;
            padding: 18px 22px; flex-wrap: wrap;
        }
        .ttd-img-box {
            background-image:
                linear-gradient(45deg, #f1f5f9 25%, transparent 25%),
                linear-gradient(-45deg, #f1f5f9 25%, transparent 25%),
                linear-gradient(45deg, transparent 75%, #f1f5f9 75%),
                linear-gradient(-45deg, transparent 75%, #f1f5f9 75%);
            background-size: 12px 12px;
            background-position: 0 0, 0 6px, 6px -6px, -6px 0px;
            border: 1px solid var(--c-border);
            border-radius: var(--r-md);
            padding: 12px 18px;
            display: flex; align-items: center; justify-content: center;
            min-width: 160px; min-height: 80px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }
        .ttd-img-box img { max-width: 160px; max-height: 80px; object-fit: contain; }
        .ttd-info { flex: 1; min-width: 0; }
        .ttd-info-title { font-family: var(--font-head); font-size: 0.84rem; font-weight: 700; color: var(--c-text); margin-bottom: 4px; }
        .ttd-info-desc  { font-size: 0.76rem; color: var(--c-text-muted); margin-bottom: 12px; line-height: 1.6; }
        .ttd-badge {
            display: inline-flex; align-items: center; gap: 5px;
            background: #dcfce7; color: #15803d;
            border-radius: 20px; padding: 3px 10px;
            font-size: 0.68rem; font-weight: 700;
            margin-bottom: 10px;
        }
        .ttd-badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: #10b981; }

        .ttd-empty {
            display: flex; align-items: center; gap: 14px;
            background: var(--c-bg, #f8fafc);
            border: 1.5px dashed var(--c-border);
            border-radius: var(--r-md);
            margin: 14px 22px;
            padding: 16px 18px;
        }
        .ttd-empty-icon {
            width: 40px; height: 40px; border-radius: var(--r-sm);
            background: var(--c-border); color: var(--c-text-muted);
            display: flex; align-items: center; justify-content: center;
            font-size: 16px; flex-shrink: 0;
        }
        .ttd-empty-text { font-size: 0.79rem; color: var(--c-text-muted); line-height: 1.5; }

        .section-divider { border: none; border-top: 1px solid var(--c-border); margin: 0; }
        .section-sublabel {
            padding: 12px 22px 4px;
            font-size: 0.65rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.08em;
            color: var(--c-text-muted);
        }

        .btn-hapus {
            display: inline-flex; align-items: center; gap: 5px;
            background: #fff1f2; color: #9f1239;
            border: 1px solid #fecdd3; border-radius: var(--r-sm);
            padding: 5px 12px; font-size: 0.72rem; font-weight: 700;
            cursor: pointer; text-decoration: none;
            transition: background 0.15s, border-color 0.15s;
        }
        .btn-hapus:hover { background: #ffe4e6; border-color: #fda4af; color: #be123c; }
        .btn-hapus i { font-size: 10px; }

        .btn-upload {
            display: inline-flex; align-items: center; gap: 6px;
            background: #eff6ff; color: #1e40af;
            border: 1px solid #bfdbfe; border-radius: var(--r-sm);
            padding: 7px 16px; font-size: 0.75rem; font-weight: 700;
            cursor: pointer; transition: background 0.15s, border-color 0.15s;
        }
        .btn-upload:hover { background: #dbeafe; border-color: #93c5fd; }

        /* ── Page hero banner ── */
        .page-hero {
            background: linear-gradient(135deg, #1e40af 0%, #3b6dd4 100%);
            border-radius: 16px;
            padding: 20px 24px;
            margin-bottom: 20px;
            display: flex; align-items: center; gap: 16px;
            position: relative; overflow: hidden;
        }
        .page-hero::before {
            content: ''; position: absolute;
            top: -30px; right: -30px;
            width: 140px; height: 140px; border-radius: 50%;
            background: rgba(255,255,255,0.06);
        }
        .page-hero-icon {
            width: 48px; height: 48px; border-radius: 14px;
            background: rgba(255,255,255,0.18);
            border: 1px solid rgba(255,255,255,0.25);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; color: white; flex-shrink: 0; z-index: 1;
        }
        .page-hero-info { z-index: 1; }
        .page-hero-title { font-size: 1rem; font-weight: 800; color: white; margin-bottom: 2px; font-family: var(--font-head); }
        .page-hero-sub   { font-size: 0.75rem; color: rgba(255,255,255,0.75); line-height: 1.5; }

        /* ── Layout grid ── */
        .two-col-layout {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 20px;
            align-items: start;
        }

        /* ────────────────────────────────────
           RESPONSIVE MOBILE (≤ 768px)
        ──────────────────────────────────── */
        @media (max-width: 768px) {

            /* topnav */
            .topnav { padding: 0 12px !important; }
            .topnav-burger { display: flex; }

            /* page content */
            .page-content { padding: 12px !important; }

            /* hero */
            .page-hero { padding: 16px; border-radius: 14px; margin-bottom: 14px; gap: 12px; }
            .page-hero-icon { width: 42px; height: 42px; font-size: 1.1rem; border-radius: 12px; }
            .page-hero-title { font-size: 0.9rem; }
            .page-hero-sub   { font-size: 0.72rem; }

            /* flash */
            .flash-alert { padding: 12px 14px; font-size: 0.79rem; border-radius: 12px; margin-bottom: 14px; }

            /* layout: 1 kolom, card kanan naik ke atas di mobile */
            .two-col-layout {
                grid-template-columns: 1fr !important;
                gap: 14px !important;
            }
            .col-right { order: -1; } /* Panduan & Status naik ke atas */

            /* surface */
            .surface { border-radius: 14px !important; margin-bottom: 0 !important; }
            .surface-header { padding: 12px 16px !important; }

            /* fr-2col: 1 kolom di mobile */
            .form-row.fr-2col { grid-template-columns: 1fr !important; }
            .fr-cell { padding: 13px 16px !important; }
            .fr-cell:first-child { border-right: none !important; }

            /* form row biasa */
            .form-row { padding: 13px 16px !important; }

            /* input: 16px cegah zoom iOS */
            .form-control-clean { font-size: 16px !important; padding: 9px 12px !important; }
            .form-control-clean.mono { font-size: 14px !important; }

            /* labels */
            .form-label-inline { font-size: 0.64rem !important; }
            .field-hint { font-size: 0.66rem !important; }

            /* form icon lebih kecil */
            .form-icon { width: 28px !important; height: 28px !important; font-size: 11px !important; margin-top: 14px !important; }

            /* ttd preview: stack vertikal */
            .ttd-preview-wrap {
                flex-direction: column !important;
                align-items: flex-start !important;
                padding: 14px 16px !important;
                gap: 14px !important;
            }
            .ttd-img-box { min-width: 100% !important; min-height: 80px !important; }
            .ttd-img-box img { max-width: 100% !important; }
            .ttd-info-desc { font-size: 0.73rem !important; margin-bottom: 10px !important; }

            /* ttd empty */
            .ttd-empty { margin: 12px 16px !important; padding: 14px 16px !important; }
            .ttd-empty-text { font-size: 0.76rem !important; }

            /* section sublabel */
            .section-sublabel { padding: 10px 16px 4px !important; }

            /* tombol aksi */
            .btn-primary {
                width: 100% !important;
                justify-content: center !important;
                padding: 12px 16px !important;
                font-size: 0.86rem !important;
                border-radius: 12px !important;
            }
            .btn-upload {
                width: 100% !important;
                justify-content: center !important;
                padding: 12px 16px !important;
                font-size: 0.82rem !important;
                border-radius: 12px !important;
            }
            div[style*="padding:14px 22px"] {
                padding: 12px 16px !important;
            }

            /* panduan card */
            .guide-body { padding: 12px 14px !important; }
        }

        @media (max-width: 400px) {
            .page-content { padding: 10px !important; }
            .page-hero { padding: 14px 12px; }
        }
    </style>
</head>
<body>

<?php $this->load->view('admin/sidebar'); ?>

<div class="page-wrapper">

    <!-- Burger terintegrasi di topnav, mobile only -->
    <header class="topnav">
        <div class="topnav-breadcrumb">
            <!-- Burger terintegrasi di topnav, mobile only -->
            <button class="topnav-burger" id="adminBurger" aria-label="Buka Menu">
                <i class="fas fa-bars"></i>
            </button>
            <i class="fas fa-chevron-right" style="font-size:8px;"></i>
            <strong>Pengaturan Surat &amp; TTD</strong>
        </div>
    </header>


    <main class="page-content">

        <!-- Page Hero -->
        <div class="page-hero">
            <div class="page-hero-icon">
                <i class="fas fa-stamp"></i>
            </div>
            <div class="page-hero-info">
                <div class="page-hero-title">Pengaturan Surat &amp; TTD</div>
                <div class="page-hero-sub">Kelola data kepala dinas dan tanda tangan pada surat keterangan TKA.</div>
            </div>
        </div>

        <!-- Flash messages -->
        <?php if($this->session->flashdata('success')): ?>
        <div class="flash-alert flash-success">
            <i class="fas fa-circle-check fa-icon"></i>
            <span><?= $this->session->flashdata('success') ?></span>
        </div>
        <?php endif; ?>
        <?php if($this->session->flashdata('error')): ?>
        <div class="flash-alert flash-error">
            <i class="fas fa-circle-exclamation fa-icon"></i>
            <span><?= $this->session->flashdata('error') ?></span>
        </div>
        <?php endif; ?>

        <!-- Grid layout -->
        <div class="two-col-layout">

            <!-- LEFT: Form -->
            <div class="col-left">

                <!-- Kepala Dinas -->
                <div class="surface" style="margin-bottom:20px;">
                    <div class="surface-header">
                        <div class="surface-title">
                            <i class="fas fa-user-tie"></i>
                            Data Kepala Dinas
                        </div>
                    </div>

                    <div style="padding:12px 22px 0; font-size:0.77rem; color:var(--c-text-muted); line-height:1.6;">
                        Nama dan NIP ini akan tercetak otomatis pada bagian tanda tangan di setiap surat keterangan TKA.
                    </div>

                    <form action="<?= base_url('admin/update_kepala_dinas') ?>" method="post">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

                        <div class="form-row fr-2col">
                            <div class="fr-cell">
                                <div class="form-icon"><i class="fas fa-user-tie"></i></div>
                                <div class="form-field">
                                    <label class="form-label-inline" for="kepala_dinas">Nama Kepala Dinas</label>
                                    <input type="text" id="kepala_dinas" name="kepala_dinas"
                                           class="form-control-clean"
                                           value="<?= htmlspecialchars($template->kepala_dinas ?? '') ?>"
                                           placeholder="Drs. H. Ahmad Fauzi, M.Si." required>
                                </div>
                            </div>
                            <div class="fr-cell" style="border-bottom:1px solid var(--c-border);">
                                <div class="form-icon" style="background:#f5f3ff;color:#7c3aed;"><i class="fas fa-fingerprint"></i></div>
                                <div class="form-field">
                                    <label class="form-label-inline" for="nip_kepala">NIP Kepala Dinas</label>
                                    <input type="text" id="nip_kepala" name="nip_kepala_dinas"
                                           class="form-control-clean mono"
                                           value="<?= htmlspecialchars($template->nip_kepala_dinas ?? '') ?>"
                                           placeholder="19670512 199403 1 005" required>
                                </div>
                            </div>
                        </div>

                        <div style="padding:14px 22px;">
                            <button type="submit" class="btn-primary" style="border:none;cursor:pointer;justify-content:center;">
                                <i class="fas fa-floppy-disk"></i> Simpan Data Kepala Dinas
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Tanda Tangan -->
                <div class="surface">
                    <div class="surface-header">
                        <div class="surface-title">
                            <i class="fas fa-signature" style="color:#7c3aed;"></i>
                            Tanda Tangan (TTD)
                        </div>
                    </div>

                    <div class="section-sublabel">TTD Saat Ini</div>

                    <?php if(!empty($ttd_path) && file_exists(FCPATH . $ttd_path)): ?>
                    <div class="ttd-preview-wrap">
                        <div class="ttd-img-box">
                            <img src="<?= base_url($ttd_path) ?>" alt="TTD Kepala Dinas">
                        </div>
                        <div class="ttd-info">
                            <div class="ttd-badge"><i class="fas fa-check-circle" style="font-size:9px;"></i> TTD Aktif</div>
                            <div class="ttd-info-title">Tanda tangan terpasang</div>
                            <div class="ttd-info-desc">
                                Tanda tangan ini akan dicetak otomatis pada setiap surat keterangan TKA.
                                Upload ulang untuk mengganti, atau hapus jika tidak lagi diperlukan.
                            </div>
                            <a href="<?= base_url('admin/delete_ttd') ?>" class="btn-hapus"
                               onclick="return confirm('Hapus TTD saat ini?')">
                                <i class="fas fa-trash-alt"></i> Hapus TTD
                            </a>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="ttd-empty">
                        <div class="ttd-empty-icon"><i class="fas fa-image-slash"></i></div>
                        <div class="ttd-empty-text">Belum ada TTD yang diunggah. Upload file di bawah untuk memasang tanda tangan pada surat.</div>
                    </div>
                    <?php endif; ?>

                    <hr class="section-divider" style="margin-top:12px;">
                    <div class="section-sublabel">Upload TTD Baru</div>

                    <form action="<?= base_url('admin/do_upload_ttd') ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

                        <div class="form-row">
                            <div class="form-icon" style="background:#f5f3ff;color:#7c3aed;">
                                <i class="fas fa-upload"></i>
                            </div>
                            <div class="form-field">
                                <label class="form-label-inline" for="ttd_file">Pilih File TTD</label>
                                <input type="file" id="ttd_file" name="ttd_file"
                                       class="form-control-clean"
                                       accept="image/png,image/jpeg,image/jpg">
                                <div class="field-hint">
                                    <i class="fas fa-circle-info" style="font-size:9px;"></i>
                                    Format PNG / JPG · Maks. 1 MB · Background transparan (PNG) sangat disarankan
                                </div>
                            </div>
                        </div>

                        <div style="padding:14px 22px;">
                            <button type="submit" class="btn-upload">
                                <i class="fas fa-cloud-arrow-up"></i> Upload TTD
                            </button>
                        </div>
                    </form>
                </div>

            </div><!-- /col-left -->

            <!-- RIGHT: Panduan + Status -->
            <div class="col-right">

                <!-- Panduan -->
                <div class="surface">
                    <div class="surface-header">
                        <div class="surface-title">
                            <i class="fas fa-lightbulb" style="color:#f59e0b;"></i>
                            Panduan
                        </div>
                    </div>
                    <div class="guide-body" style="padding:14px 18px;">
                        <div style="font-size:0.78rem;color:var(--c-text-muted);line-height:1.8;">

                            <div style="font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:var(--c-text);margin-bottom:8px;">
                                Data Kepala Dinas
                            </div>
                            <div style="display:flex;gap:8px;margin-bottom:7px;">
                                <i class="fas fa-circle-check" style="color:#10b981;margin-top:3px;font-size:10px;flex-shrink:0;"></i>
                                <span>Nama dan NIP akan tercetak otomatis pada bagian bawah surat.</span>
                            </div>
                            <div style="display:flex;gap:8px;margin-bottom:16px;">
                                <i class="fas fa-circle-check" style="color:#10b981;margin-top:3px;font-size:10px;flex-shrink:0;"></i>
                                <span>Perubahan langsung berlaku pada surat yang baru di-generate.</span>
                            </div>

                            <div style="font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:var(--c-text);margin-bottom:8px;">
                                Tanda Tangan (TTD)
                            </div>
                            <div style="display:flex;gap:8px;margin-bottom:7px;">
                                <i class="fas fa-circle-check" style="color:#10b981;margin-top:3px;font-size:10px;flex-shrink:0;"></i>
                                <span>Gunakan <strong>PNG background transparan</strong> untuk hasil terbaik.</span>
                            </div>
                            <div style="display:flex;gap:8px;margin-bottom:7px;">
                                <i class="fas fa-circle-check" style="color:#10b981;margin-top:3px;font-size:10px;flex-shrink:0;"></i>
                                <span>Ukuran file maksimal <strong>1 MB</strong>.</span>
                            </div>
                            <div style="display:flex;gap:8px;">
                                <i class="fas fa-circle-check" style="color:#10b981;margin-top:3px;font-size:10px;flex-shrink:0;"></i>
                                <span>Upload baru akan <strong>mengganti</strong> TTD yang lama secara otomatis.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status TTD -->
                <div class="surface" style="margin-top:16px;">
                    <div class="surface-header">
                        <div class="surface-title">
                            <i class="fas fa-circle-info" style="color:#3b82f6;"></i>
                            Status TTD
                        </div>
                    </div>
                    <div style="padding:0;">
                        <div style="display:flex;align-items:flex-start;gap:12px;padding:14px 18px;border-bottom:1px solid var(--c-border);">
                            <div style="width:30px;height:30px;border-radius:var(--r-sm);background:var(--c-primary-light);color:var(--c-primary);display:flex;align-items:center;justify-content:center;font-size:11px;flex-shrink:0;">
                                <i class="fas fa-signature"></i>
                            </div>
                            <div>
                                <div style="font-size:0.65rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:var(--c-text-muted);margin-bottom:4px;">Status</div>
                                <?php if(!empty($ttd_path) && file_exists(FCPATH . $ttd_path)): ?>
                                    <span style="display:inline-flex;align-items:center;gap:5px;background:#dcfce7;color:#15803d;border-radius:20px;padding:3px 10px;font-size:0.68rem;font-weight:700;">
                                        <span style="width:6px;height:6px;border-radius:50%;background:#10b981;"></span> TTD Aktif
                                    </span>
                                <?php else: ?>
                                    <span style="display:inline-flex;align-items:center;gap:5px;background:#f1f5f9;color:#475569;border-radius:20px;padding:3px 10px;font-size:0.68rem;font-weight:700;">
                                        <span style="width:6px;height:6px;border-radius:50%;background:#94a3b8;"></span> Belum Ada TTD
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div style="display:flex;align-items:flex-start;gap:12px;padding:14px 18px;">
                            <div style="width:30px;height:30px;border-radius:var(--r-sm);background:#f5f3ff;color:#7c3aed;display:flex;align-items:center;justify-content:center;font-size:11px;flex-shrink:0;">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div style="min-width:0;">
                                <div style="font-size:0.65rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:var(--c-text-muted);margin-bottom:4px;">Kepala Dinas</div>
                                <div style="font-size:0.82rem;font-weight:500;color:var(--c-text);word-break:break-word;">
                                    <?= !empty($template->kepala_dinas)
                                        ? htmlspecialchars($template->kepala_dinas)
                                        : '<span style="color:var(--c-text-muted);font-style:italic;">Belum diisi</span>' ?>
                                </div>
                                <?php if(!empty($template->nip_kepala_dinas)): ?>
                                <div style="font-size:0.72rem;font-family:'Courier New',monospace;color:var(--c-primary);margin-top:2px;">
                                    <?= htmlspecialchars($template->nip_kepala_dinas) ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- /col-right -->

        </div><!-- /two-col-layout -->

    </main>

    <?php $this->load->view('footer'); ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
(function(){
    /* ── Burger: panggil fungsi dari sidebar ── */
    var burger = document.getElementById('adminBurger');
    if (burger) {
        burger.addEventListener('click', function(e) {
            e.stopPropagation();
            if (typeof window.openAdminSidebar === 'function') {
                window.openAdminSidebar();
            }
        });
    }
})();
</script>
</body>
</html>