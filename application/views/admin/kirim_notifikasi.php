<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kirim Notifikasi — SITLAKEB TKA Admin</title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/shared.css') ?>">
    <style>
        html, body { height: 100%; }
        .page-wrapper { min-height: 100vh; display: flex; flex-direction: column; }
        .page-content { flex: 1; }
        .site-footer  { flex-shrink: 0; }

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

        /* ── Page hero ── */
        .page-hero {
            background: linear-gradient(135deg, #1a6b52 0%, #22896a 100%);
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
        .page-hero-title { font-size: 1rem; font-weight: 800; color: white; margin-bottom: 2px; }
        .page-hero-sub   { font-size: 0.74rem; color: rgba(255,255,255,0.75); line-height: 1.5; }

        /* ── Two-column layout ── */
        .notif-grid {
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 20px;
            align-items: start;
        }

        /* ── Select styled ── */
        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 36px;
        }

        textarea.form-input { resize: vertical; min-height: 110px; line-height: 1.6; }

        /* ── Mode radio ── */
        .mode-radio-group { display: flex; gap: 16px; margin-bottom: 4px; flex-wrap: wrap; }
        .mode-radio-label {
            display: flex; align-items: center; gap: 8px;
            padding: 9px 16px;
            border: 1.5px solid var(--c-border);
            border-radius: 10px;
            cursor: pointer; font-size: 0.82rem; font-weight: 500;
            color: var(--c-text-muted);
            transition: border-color .15s, background .15s, color .15s;
            flex: 1; min-width: 140px;
        }
        .mode-radio-label input { display: none; }
        .mode-radio-label .mr-icon {
            width: 28px; height: 28px; border-radius: 7px;
            background: var(--c-surface-2);
            display: flex; align-items: center; justify-content: center;
            font-size: 11px; flex-shrink: 0;
            transition: background .15s, color .15s;
        }
        .mode-radio-label.selected {
            border-color: var(--c-primary);
            background: var(--c-primary-light);
            color: var(--c-primary);
        }
        .mode-radio-label.selected .mr-icon { background: var(--c-primary); color: white; }

        /* ── Live Preview ── */
        .preview-panel {
            background: var(--c-surface-2);
            border: 1.5px dashed var(--c-border-strong);
            border-radius: var(--r-lg);
            padding: 14px 16px;
            margin-top: 18px;
            transition: border-color 0.2s, background 0.2s;
        }
        .preview-panel.has-content {
            border-style: solid;
            border-color: var(--c-primary);
            background: var(--c-primary-light);
        }
        .preview-label {
            font-size: 0.62rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.1em;
            color: var(--c-text-muted);
            margin-bottom: 10px;
            display: flex; align-items: center; gap: 6px;
        }
        .preview-empty { font-size: 0.78rem; color: var(--c-text-muted); font-style: italic; text-align: center; padding: 8px 0; }
        .preview-notif-card { background: white; border: 1px solid var(--c-border); border-radius: var(--r-md); padding: 12px 14px; display: none; }
        .preview-notif-header { display: flex; align-items: center; gap: 8px; margin-bottom: 6px; }
        .preview-notif-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--c-primary); flex-shrink: 0; }
        .preview-notif-title { font-family: var(--font-head); font-size: 0.82rem; font-weight: 700; color: var(--c-text); }
        .preview-notif-msg  { font-size: 0.76rem; color: var(--c-text-mid); line-height: 1.55; padding-left: 16px; }
        .preview-notif-time { font-size: 0.66rem; color: var(--c-text-muted); padding-left: 16px; margin-top: 6px; }

        /* ── Template cards ── */
        .tpl-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
        .tpl-card {
            display: flex; align-items: flex-start; gap: 10px;
            padding: 11px 12px; border-radius: var(--r-md);
            border: 1.5px solid var(--c-border);
            background: var(--c-surface); cursor: pointer;
            text-align: left; width: 100%;
            transition: border-color .15s, background .15s, box-shadow .15s, transform .1s;
        }
        .tpl-card:hover { border-color: var(--c-primary); background: var(--c-primary-light); transform: translateY(-1px); box-shadow: var(--shadow-sm); }
        .tpl-card.active { border-color: var(--c-primary); background: var(--c-primary-light); box-shadow: 0 0 0 3px var(--c-primary-glow); }
        .tpl-icon { width: 32px; height: 32px; border-radius: var(--r-sm); display: flex; align-items: center; justify-content: center; font-size: 13px; flex-shrink: 0; }
        .ti-green  { background:#dcfce7; color:#15803d; }
        .ti-blue   { background:#dbeafe; color:#1d4ed8; }
        .ti-amber  { background:#fef3c7; color:#b45309; }
        .ti-slate  { background:#f1f5f9; color:#475569; }
        .tpl-body  { flex: 1; min-width: 0; }
        .tpl-title { font-size: 0.75rem; font-weight: 700; color: var(--c-text); margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-family: var(--font-head); }
        .tpl-desc  { font-size: 0.67rem; color: var(--c-text-muted); line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .tpl-radio { width: 15px; height: 15px; border-radius: 50%; border: 1.5px solid var(--c-border-strong); flex-shrink: 0; display: flex; align-items: center; justify-content: center; margin-top: 1px; transition: all .15s; }
        .tpl-card.active .tpl-radio { background: var(--c-primary); border-color: var(--c-primary); }
        .tpl-card.active .tpl-radio::after { content: ''; width: 5px; height: 5px; border-radius: 50%; background: white; }

        .tpl-selected-box { margin-top: 14px; background: var(--c-surface-2); border: 1px solid var(--c-border); border-radius: var(--r-md); padding: 12px 14px; display: none; }
        .tpl-selected-box.visible { display: block; }
        .tsl-mini-label { font-size: 0.6rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.09em; color: var(--c-text-muted); margin-bottom: 6px; }
        .tsl-title { font-size: 0.78rem; font-weight: 700; color: var(--c-text); margin-bottom: 3px; }
        .tsl-msg   { font-size: 0.72rem; color: var(--c-text-mid); line-height: 1.5; }
        .tsl-clear { font-size: 0.68rem; color: var(--c-text-muted); background: none; border: none; padding: 0; cursor: pointer; margin-top: 8px; display: flex; align-items: center; gap: 4px; transition: color .12s; }
        .tsl-clear:hover { color: #e53e3e; }

        /* ── Char counter ── */
        .char-counter { font-size: 0.68rem; color: var(--c-text-muted); text-align: right; margin-top: 3px; }
        .char-counter.warn { color: #f59e0b; }
        .char-counter.over { color: #ef4444; }

        /* ── Flash alert ── */
        .flash-alert { display: flex; align-items: flex-start; gap: 10px; padding: 12px 16px; border-radius: var(--r-md); margin-bottom: 20px; font-size: 0.8rem; }
        .flash-success { background:#ecfdf5; border:1px solid #a7f3d0; color:#065f46; }
        .flash-error   { background:#fff1f2; border:1px solid #fecdd3; color:#9f1239; }
        .flash-alert i { font-size: 12px; margin-top: 1px; flex-shrink: 0; }
        .flash-close { margin-left: auto; background: none; border: none; cursor: pointer; color: inherit; opacity: 0.6; font-size: 12px; padding: 0; flex-shrink: 0; }
        .flash-close:hover { opacity: 1; }

        /* ── Form actions ── */
        .form-actions { display: flex; align-items: center; gap: 10px; margin-top: 22px; padding-top: 18px; border-top: 1px solid var(--c-border); flex-wrap: wrap; }
        .btn-ghost { display: inline-flex; align-items: center; gap: 6px; background: transparent; color: var(--c-text-muted); border: 1px solid var(--c-border-strong); padding: 9px 16px; border-radius: var(--r-md); font-size: 0.8rem; font-weight: 500; font-family: var(--font-body); cursor: pointer; transition: background .12s, color .12s; }
        .btn-ghost:hover { background: var(--c-surface-2); color: var(--c-text); }

        /* ── Tips ── */
        .tips-box { background: var(--c-surface-2); border: 1px solid var(--c-border); border-radius: var(--r-lg); padding: 16px 18px; margin-top: 16px; }
        .tips-title { font-family: var(--font-head); font-size: 0.75rem; font-weight: 700; color: var(--c-text-muted); margin-bottom: 12px; display: flex; align-items: center; gap: 6px; text-transform: uppercase; letter-spacing: 0.07em; }
        .tip-item { display: flex; align-items: flex-start; gap: 8px; font-size: 0.72rem; color: var(--c-text-mid); line-height: 1.5; margin-bottom: 8px; }
        .tip-item:last-child { margin-bottom: 0; }
        .tip-bullet { width: 16px; height: 16px; border-radius: 50%; background: var(--c-primary-light); color: var(--c-primary); font-size: 8px; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 1px; }

        /* ─────────────────────────────────────────
           RESPONSIVE MOBILE (≤ 768px)
        ───────────────────────────────────────── */
        @media (max-width: 1024px) {
            .notif-grid { grid-template-columns: 1fr; }
            /* di mobile, kolom kanan (template+tips) naik ke atas */
            .notif-col-right { order: -1; }
        }

        @media (max-width: 768px) {
            /* topnav */
            .topnav { padding: 0 12px !important; }
            .topnav-burger { display: flex; }

            /* page content */
            .page-content { padding: 12px !important; }

            /* hero */
            .page-hero { padding: 16px; border-radius: 14px; margin-bottom: 14px; gap: 12px; }
            .page-hero-icon  { width: 42px; height: 42px; font-size: 1.1rem; border-radius: 12px; }
            .page-hero-title { font-size: 0.9rem; }
            .page-hero-sub   { font-size: 0.72rem; }

            /* flash */
            .flash-alert { font-size: 0.78rem; padding: 11px 14px; }

            /* surface */
            .surface { border-radius: 14px !important; }
            .surface-header { padding: 12px 16px !important; }
            .surface-body   { padding: 14px 16px !important; }

            /* mode radio */
            .mode-radio-group { gap: 10px; }
            .mode-radio-label { padding: 9px 12px; font-size: 0.79rem; min-width: 0; }

            /* form inputs: 16px cegah zoom iOS */
            .form-input { font-size: 16px !important; }
            textarea.form-input { min-height: 90px !important; }

            /* field label */
            .field-label { font-size: 0.72rem !important; }

            /* char counter */
            .char-counter { font-size: 0.65rem; }

            /* preview panel */
            .preview-panel { padding: 12px 14px; margin-top: 14px; }

            /* template grid: 2 kolom tetap tapi lebih compact */
            .tpl-grid { gap: 7px; }
            .tpl-card { padding: 10px 10px; gap: 8px; }
            .tpl-icon { width: 28px; height: 28px; font-size: 11px; }
            .tpl-title { font-size: 0.72rem; }
            .tpl-desc  { font-size: 0.63rem; }

            /* tips box */
            .tips-box { padding: 14px 16px; margin-top: 12px; }
            .tip-item { font-size: 0.7rem; }

            /* form actions: full width */
            .form-actions { flex-direction: column; gap: 8px; padding-top: 16px; margin-top: 18px; }
            .form-actions .btn-primary,
            .form-actions .btn-ghost {
                width: 100% !important;
                justify-content: center !important;
                height: 46px !important;
                font-size: 0.9rem !important;
                border-radius: 12px !important;
            }
        }

        @media (max-width: 480px) {
            .tpl-grid { grid-template-columns: 1fr !important; }
            .mode-radio-group { flex-direction: column; gap: 8px; }
            .mode-radio-label { flex: none; }
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
            <i class="fas fa-chevron-right" style="font-size:8px;"></i>
            <strong>Kirim Notifikasi</strong>
        </div>
        <div class="topnav-actions">
            <!--<a href="<?= base_url('dashboard') ?>" class="topnav-btn" title="Kembali">
                <i class="fas fa-arrow-left"></i>
            </a>-->
        </div>
    </header>

    <main class="page-content">

        <!-- Page hero -->
        <div class="page-hero">
            <div class="page-hero-icon"><i class="fas fa-paper-plane"></i></div>
            <div class="page-hero-info">
                <div class="page-hero-title">Kirim Notifikasi</div>
                <div class="page-hero-sub">Kirim notifikasi manual kepada satu atau semua perusahaan terdaftar.</div>
            </div>
        </div>

        <!-- Flash messages -->
        <?php if($this->session->flashdata('success')): ?>
            <div class="flash-alert flash-success" id="flashMsg">
                <i class="fas fa-check-circle"></i>
                <span><?= $this->session->flashdata('success') ?></span>
                <button class="flash-close" onclick="this.closest('.flash-alert').remove()"><i class="fas fa-xmark"></i></button>
            </div>
        <?php endif; ?>
        <?php if($this->session->flashdata('error')): ?>
            <div class="flash-alert flash-error" id="flashMsg">
                <i class="fas fa-exclamation-circle"></i>
                <span><?= $this->session->flashdata('error') ?></span>
                <button class="flash-close" onclick="this.closest('.flash-alert').remove()"><i class="fas fa-xmark"></i></button>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('admin/kirim_notifikasi_action') ?>" method="post" id="notifForm">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                   value="<?= $this->security->get_csrf_hash(); ?>">

            <div class="notif-grid">

                <!-- ── KIRI: Form Utama ── -->
                <div class="notif-col-left">
                    <div class="surface">
                        <div class="surface-header">
                            <div class="surface-title">
                                <i class="fas fa-paper-plane"></i>
                                Isi Notifikasi
                            </div>
                        </div>
                        <div class="surface-body">

                            <!-- Mode pengiriman -->
                            <div class="field-wrap">
                                <label class="field-label required">Tujuan Pengiriman</label>
                                <div class="mode-radio-group" id="modeRadioGroup">
                                    <label class="mode-radio-label selected" id="mrl-single">
                                        <input type="radio" name="send_mode" value="single" checked onchange="toggleUserSelect(); updateModeLabel();">
                                        <div class="mr-icon"><i class="fas fa-building"></i></div>
                                        <span>Perusahaan Tertentu</span>
                                    </label>
                                    <label class="mode-radio-label" id="mrl-all">
                                        <input type="radio" name="send_mode" value="all" onchange="toggleUserSelect(); updateModeLabel();">
                                        <div class="mr-icon"><i class="fas fa-globe"></i></div>
                                        <span>Semua Perusahaan</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Pilih Perusahaan -->
                            <div class="field-wrap" id="user-select-wrapper">
                                <label class="field-label required">Pilih Perusahaan</label>
                                <div style="position:relative;">
                                    <i class="fas fa-building" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--c-text-muted);font-size:11px;pointer-events:none;"></i>
                                    <select name="user_id" id="user_id" class="form-input form-select"
                                            style="padding-left:32px;" required>
                                        <option value="">— Pilih Perusahaan —</option>
                                        <?php
                                        $perusahaan_list = $this->db->where('role','user')->get('users')->result();
                                        foreach($perusahaan_list as $u): ?>
                                        <option value="<?= $u->id ?>">
                                            <?= htmlspecialchars($u->perusahaan) ?> (<?= $u->email ?>)
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Judul -->
                            <div class="field-wrap">
                                <label class="field-label required">Judul Notifikasi</label>
                                <div style="position:relative;">
                                    <i class="fas fa-heading" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--c-text-muted);font-size:11px;pointer-events:none;"></i>
                                    <input type="text" name="title" id="input-title" class="form-input"
                                           style="padding-left:32px;" required maxlength="80"
                                           placeholder="Contoh: Surat Keterangan TKA Telah Siap"
                                           oninput="updatePreview(); countChars('input-title','cnt-title',80)">
                                </div>
                                <div class="char-counter" id="cnt-title">0 / 80</div>
                            </div>

                            <!-- Pesan -->
                            <div class="field-wrap">
                                <label class="field-label required">Pesan Notifikasi</label>
                                <textarea name="message" id="input-message" class="form-input"
                                          rows="4" required maxlength="500"
                                          placeholder="Tulis pesan notifikasi di sini…"
                                          oninput="updatePreview(); countChars('input-message','cnt-msg',500)"></textarea>
                                <div class="char-counter" id="cnt-msg">0 / 500</div>
                            </div>

                            <!-- Link -->
                            <div class="field-wrap">
                                <label class="field-label">
                                    Link Tujuan
                                    <span style="font-weight:400;color:var(--c-text-muted);font-size:0.7rem;">(opsional)</span>
                                </label>
                                <div style="position:relative;">
                                    <i class="fas fa-link" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--c-text-muted);font-size:11px;pointer-events:none;"></i>
                                    <input type="text" name="link" id="input-link" class="form-input"
                                           style="padding-left:32px;"
                                           placeholder="https://… atau /user/data_tka">
                                </div>
                                <div class="field-hint">
                                    <i class="fas fa-circle-info"></i>
                                    Kosongkan jika tidak ada halaman tujuan spesifik.
                                </div>
                            </div>

                            <!-- Preview -->
                            <div class="preview-panel" id="previewPanel">
                                <div class="preview-label"><i class="fas fa-eye"></i> Preview Notifikasi</div>
                                <div class="preview-empty" id="preview-empty">Isi judul dan pesan untuk melihat preview.</div>
                                <div class="preview-notif-card" id="preview-content">
                                    <div class="preview-notif-header">
                                        <div class="preview-notif-dot"></div>
                                        <div class="preview-notif-title" id="preview-title"></div>
                                    </div>
                                    <div class="preview-notif-msg"  id="preview-msg"></div>
                                    <div class="preview-notif-time">Baru saja · SITLAKEB TKA</div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="form-actions">
                                <button type="submit" class="btn-primary">
                                    <i class="fas fa-paper-plane"></i> Kirim Notifikasi
                                </button>
                                <button type="button" class="btn-ghost" onclick="resetForm()">
                                    <i class="fas fa-rotate-left"></i> Reset
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- ── KANAN: Template & Tips ── -->
                <div class="notif-col-right">

                    <!-- Template cepat -->
                    <div class="surface">
                        <div class="surface-header">
                            <div class="surface-title">
                                <i class="fas fa-bolt" style="color:#f59e0b;"></i>
                                Template Cepat
                            </div>
                            <span style="font-size:0.68rem;color:var(--c-text-muted);">Klik untuk mengisi</span>
                        </div>
                        <div class="surface-body" style="padding:14px 16px;">

                            <div class="tpl-grid">
                                <button type="button" class="tpl-card" onclick="fillTemplate(1, this)">
                                    <div class="tpl-icon ti-green"><i class="fas fa-file-circle-check"></i></div>
                                    <div class="tpl-body">
                                        <div class="tpl-title">Surat Selesai</div>
                                        <div class="tpl-desc">Surat keterangan TKA siap diunduh.</div>
                                    </div>
                                    <div class="tpl-radio"></div>
                                </button>

                                <button type="button" class="tpl-card" onclick="fillTemplate(2, this)">
                                    <div class="tpl-icon ti-blue"><i class="fas fa-circle-check"></i></div>
                                    <div class="tpl-body">
                                        <div class="tpl-title">Verifikasi OK</div>
                                        <div class="tpl-desc">Pengajuan TKA disetujui.</div>
                                    </div>
                                    <div class="tpl-radio"></div>
                                </button>

                                <button type="button" class="tpl-card" onclick="fillTemplate(3, this)">
                                    <div class="tpl-icon ti-amber"><i class="fas fa-triangle-exclamation"></i></div>
                                    <div class="tpl-body">
                                        <div class="tpl-title">Data Kurang</div>
                                        <div class="tpl-desc">Data TKA belum lengkap.</div>
                                    </div>
                                    <div class="tpl-radio"></div>
                                </button>

                                <button type="button" class="tpl-card" onclick="fillTemplate(4, this, 'all')">
                                    <div class="tpl-icon ti-slate"><i class="fas fa-bullhorn"></i></div>
                                    <div class="tpl-body">
                                        <div class="tpl-title">Pengumuman</div>
                                        <div class="tpl-desc">Kirim ke semua perusahaan.</div>
                                    </div>
                                    <div class="tpl-radio"></div>
                                </button>
                            </div>

                            <!-- Selected template detail -->
                            <div class="tpl-selected-box" id="tplSelectedBox">
                                <div class="tsl-mini-label"><i class="fas fa-check" style="font-size:8px;margin-right:4px;"></i>Template Aktif</div>
                                <div class="tsl-title" id="tsl-title"></div>
                                <div class="tsl-msg"   id="tsl-msg"></div>
                                <button class="tsl-clear" onclick="clearTemplate()">
                                    <i class="fas fa-xmark"></i> Hapus pilihan template
                                </button>
                            </div>

                        </div>
                    </div>

                    <!-- Tips -->
                    <div class="tips-box">
                        <div class="tips-title"><i class="fas fa-lightbulb" style="color:#f59e0b;"></i> Tips Penulisan</div>
                        <div class="tip-item">
                            <div class="tip-bullet">1</div>
                            <span>Gunakan judul yang jelas dan ringkas, maksimal 80 karakter.</span>
                        </div>
                        <div class="tip-item">
                            <div class="tip-bullet">2</div>
                            <span>Sertakan nama TKA agar penerima tahu pengajuan yang dimaksud.</span>
                        </div>
                        <div class="tip-item">
                            <div class="tip-bullet">3</div>
                            <span>Tambahkan link tujuan agar penerima langsung diarahkan ke halaman relevan.</span>
                        </div>
                        <div class="tip-item">
                            <div class="tip-bullet">4</div>
                            <span>Untuk pengumuman massal, pilih mode <strong>Semua Perusahaan</strong>.</span>
                        </div>
                    </div>

                </div>

            </div><!-- /notif-grid -->
        </form>

    </main>

    <?php $this->load->view('footer'); ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
/* ── Burger ── */
(function(){
    var burger = document.getElementById('adminBurger');
    if (burger) {
        burger.addEventListener('click', function(e) {
            e.stopPropagation();
            if (typeof window.openAdminSidebar === 'function') window.openAdminSidebar();
        });
    }
})();

/* ── Template data ── */
var templates = {
    1: { title: 'Surat Keterangan TKA Siap',
         message: 'Surat keterangan untuk TKA atas nama [Nama TKA] telah selesai diproses. Silakan unduh dokumen melalui menu Data TKA.',
         link: '/user/data_tka' },
    2: { title: 'Verifikasi TKA Berhasil',
         message: 'Pengajuan TKA Anda telah diverifikasi dan disetujui oleh petugas. Status terkini dapat dilihat pada dashboard Anda.',
         link: '/user/dashboard' },
    3: { title: 'Data TKA Perlu Dilengkapi',
         message: 'Terdapat data detail TKA Anda yang belum lengkap. Harap segera lengkapi melalui menu Data TKA agar proses dapat dilanjutkan.',
         link: '/user/data_tka' },
    4: { title: 'Pengumuman Penting dari Disnaker',
         message: 'Terdapat pembaruan informasi dari Dinas Ketenagakerjaan Kota Bekasi. Mohon perhatikan informasi terbaru di website resmi kami.',
         link: '' }
};

/* ── Update label mode radio ── */
function updateModeLabel() {
    var mode = document.querySelector('input[name="send_mode"]:checked').value;
    document.getElementById('mrl-single').classList.toggle('selected', mode === 'single');
    document.getElementById('mrl-all').classList.toggle('selected', mode === 'all');
}

/* ── Toggle user select ── */
function toggleUserSelect() {
    var mode    = document.querySelector('input[name="send_mode"]:checked').value;
    var wrapper = document.getElementById('user-select-wrapper');
    var select  = document.getElementById('user_id');
    if (mode === 'all') {
        wrapper.style.display = 'none';
        select.removeAttribute('required');
        select.value = '';
    } else {
        wrapper.style.display = '';
        select.setAttribute('required','required');
    }
}

/* ── Fill template ── */
function fillTemplate(id, el, mode) {
    var tpl = templates[id]; if (!tpl) return;
    setVal('input-title',   tpl.title);
    setVal('input-message', tpl.message);
    setVal('input-link',    tpl.link);
    countChars('input-title',   'cnt-title', 80);
    countChars('input-message', 'cnt-msg',  500);
    document.querySelectorAll('.tpl-card').forEach(function(c){ c.classList.remove('active'); });
    el.classList.add('active');
    if (mode === 'all') {
        document.querySelector('input[name="send_mode"][value="all"]').checked = true;
    } else {
        document.querySelector('input[name="send_mode"][value="single"]').checked = true;
    }
    toggleUserSelect();
    updateModeLabel();
    document.getElementById('tsl-title').textContent = tpl.title;
    document.getElementById('tsl-msg').textContent   = tpl.message;
    document.getElementById('tplSelectedBox').classList.add('visible');
    updatePreview();
}

/* ── Clear template ── */
function clearTemplate() {
    document.querySelectorAll('.tpl-card').forEach(function(c){ c.classList.remove('active'); });
    document.getElementById('tplSelectedBox').classList.remove('visible');
}

/* ── Reset form ── */
function resetForm() {
    setVal('input-title',''); setVal('input-message',''); setVal('input-link','');
    countChars('input-title','cnt-title',80);
    countChars('input-message','cnt-msg',500);
    clearTemplate();
    document.querySelector('input[name="send_mode"][value="single"]').checked = true;
    toggleUserSelect();
    updateModeLabel();
    updatePreview();
}

/* ── Live preview ── */
function updatePreview() {
    var title = get('input-title').trim();
    var msg   = get('input-message').trim();
    var empty = document.getElementById('preview-empty');
    var card  = document.getElementById('preview-content');
    var panel = document.getElementById('previewPanel');
    if (title || msg) {
        empty.style.display = 'none';
        card.style.display  = 'block';
        document.getElementById('preview-title').textContent = title || '(Judul belum diisi)';
        document.getElementById('preview-msg').textContent   = msg   || '(Pesan belum diisi)';
        panel.classList.add('has-content');
    } else {
        empty.style.display = 'block';
        card.style.display  = 'none';
        panel.classList.remove('has-content');
    }
}

/* ── Char counter ── */
function countChars(inputId, counterId, max) {
    var len = get(inputId).length;
    var el  = document.getElementById(counterId);
    el.textContent = len + ' / ' + max;
    el.className   = 'char-counter' + (len > max * 0.9 ? (len >= max ? ' over' : ' warn') : '');
}

/* ── Utils ── */
function get(id)     { return document.getElementById(id).value; }
function setVal(id,v){ document.getElementById(id).value = v; }

/* ── Init ── */
countChars('input-title',  'cnt-title', 80);
countChars('input-message','cnt-msg',  500);
toggleUserSelect();
updateModeLabel();
</script>
</body>
</html>