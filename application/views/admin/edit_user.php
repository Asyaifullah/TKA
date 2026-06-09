<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Perusahaan — <?= htmlspecialchars($user->perusahaan) ?></title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/shared.css') ?>">

    <style>
        /* ============================================================
           EDIT PERUSAHAAN
           Desktop : grid 2 kolom (form kiri | aksi kanan)
           Mobile  : 1 kolom stack
        ============================================================ */

        /* ── Hamburger ────────────────────────────────────────── */
        .topnav-burger {
            display: none;
            width: 34px;
            height: 34px;
            border-radius: 9px;
            border: 1px solid var(--c-border);
            background: var(--c-surface-2);
            align-items: center;
            justify-content: center;
            color: var(--c-text-muted);
            font-size: 13px;
            cursor: pointer;
            flex-shrink: 0;
            transition: background 0.15s, color 0.15s;
        }

        .topnav-burger:hover {
            background: var(--c-primary-light);
            color: var(--c-primary);
        }

        @media (max-width: 768px) {
            .topnav-burger { display: flex; }
        }

        /* ── Company hero banner ──────────────────────────────── */
        .company-hero {
            background: linear-gradient(135deg, var(--c-primary) 0%, #2a9d7f 100%);
            border-radius: var(--r-lg);
            padding: 22px 24px;
            display: flex;
            align-items: center;
            gap: 18px;
            margin-bottom: 18px;
            position: relative;
            overflow: hidden;
        }

        /* Dekorasi lingkaran */
        .company-hero::before {
            content: '';
            position: absolute;
            top: -40px; right: -40px;
            width: 160px; height: 160px;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
        }

        .company-hero::after {
            content: '';
            position: absolute;
            bottom: -50px; right: 110px;
            width: 110px; height: 110px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
        }

        .company-avatar {
            width: 56px;
            height: 56px;
            border-radius: var(--r-md);
            background: rgba(255,255,255,0.2);
            border: 2px solid rgba(255,255,255,0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            font-weight: 800;
            color: #fff;
            flex-shrink: 0;
            z-index: 1;
        }

        .company-hero-info {
            flex: 1;
            min-width: 0;
            z-index: 1;
        }

        .ch-name {
            font-size: 1.05rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 3px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ch-sub {
            font-size: 0.76rem;
            color: rgba(255,255,255,0.75);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .ch-sub i { font-size: 9px; }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 11px;
            border-radius: 20px;
            font-size: 0.68rem;
            font-weight: 700;
            background: rgba(255,255,255,0.22);
            color: #fff;
            white-space: nowrap;
            z-index: 1;
            flex-shrink: 0;
        }

        /* ── Main layout grid ─────────────────────────────────── */
        .edit-grid {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 20px;
            align-items: start;
        }

        /* ── Form grid dalam surface (2 kolom desktop) ────────── */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        .form-row {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 20px;
            border-bottom: 1px solid var(--c-border);
        }

        /* Ganjil: border kanan (separator antar kolom) */
        .form-row:nth-child(odd) {
            border-right: 1px solid var(--c-border);
        }

        /* Baris terakhir tanpa border bawah */
        .form-row:last-child,
        .form-row:nth-last-child(2):nth-child(odd) {
            border-bottom: none;
        }

        /* Full-width row (textarea alamat) */
        .form-row.col-full {
            grid-column: 1 / -1;
            border-right: none;
        }

        .form-row.col-full:last-child { border-bottom: none; }

        .form-icon {
            width: 30px;
            height: 30px;
            border-radius: var(--r-sm);
            background: var(--c-primary-light);
            color: var(--c-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            flex-shrink: 0;
            margin-top: 5px;
        }

        .form-field { flex: 1; min-width: 0; }

        .f-label {
            display: block;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: var(--c-text-muted);
            margin-bottom: 5px;
        }

        /* ── Input / select / textarea ────────────────────────── */
        .f-input,
        .f-select,
        .f-textarea {
            width: 100%;
            font-family: var(--font-body);
            font-size: 0.84rem;
            font-weight: 500;
            color: var(--c-text);
            background: var(--c-surface);
            border: 1px solid var(--c-border);
            border-radius: var(--r-sm);
            padding: 8px 11px;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
            -webkit-appearance: none;
        }

        .f-input:focus,
        .f-select:focus,
        .f-textarea:focus {
            border-color: var(--c-primary);
            box-shadow: 0 0 0 3px var(--c-primary-glow);
        }

        .f-input.mono,
        .f-select.mono { font-family: 'Courier New', monospace; font-size: 0.8rem; color: var(--c-primary); }

        .f-textarea {
            resize: vertical;
            min-height: 80px;
            line-height: 1.6;
        }

        .f-select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            padding-right: 28px;
        }

        .field-error {
            font-size: 0.69rem;
            color: #f43f5e;
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* ── Action buttons ───────────────────────────────────── */
        .btn-save {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            background: var(--c-primary);
            border: none;
            border-radius: var(--r-md);
            padding: 0 18px;
            height: 40px;
            font-family: var(--font-body);
            font-weight: 700;
            font-size: 0.84rem;
            color: #fff;
            cursor: pointer;
            transition: opacity 0.15s, transform 0.1s;
            width: 100%;
        }

        .btn-save:hover  { opacity: 0.88; }
        .btn-save:active { transform: scale(0.98); }

        .btn-cancel {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            background: var(--c-surface-2);
            border: 1px solid var(--c-border);
            border-radius: var(--r-md);
            padding: 0 18px;
            height: 40px;
            font-family: var(--font-body);
            font-weight: 600;
            font-size: 0.84rem;
            color: var(--c-text-muted);
            cursor: pointer;
            text-decoration: none;
            transition: background 0.15s, color 0.15s;
            width: 100%;
        }

        .btn-cancel:hover { background: var(--c-border); color: var(--c-text); }

        /* Toggle status */
        .btn-toggle {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 100%;
            padding: 8px 12px;
            border-radius: 30px;
            font-size: 0.72rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: none;
            font-family: var(--font-body);
        }

        .btn-deactivate { background: #fee2e2; color: #b91c1c; }
        .btn-deactivate:hover { background: #fecaca; color: #b91c1c; }
        .btn-activate   { background: #e0f2fe; color: #0369a1; }
        .btn-activate:hover { background: #bae6fd; color: #0369a1; }

        /* Status divider dalam action card */
        .status-divider {
            margin-top: 6px;
            padding-top: 12px;
            border-top: 1px solid var(--c-border);
        }

        .status-label {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: var(--c-text-muted);
            margin-bottom: 8px;
        }

        /* Info row */
        .info-row {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 12px 18px;
            border-bottom: 1px solid var(--c-border);
        }

        .info-row:last-child { border-bottom: none; }

        .info-label {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: var(--c-text-muted);
            margin-bottom: 3px;
        }

        .info-value { font-size: 0.84rem; font-weight: 500; }

        /* Alert validasi */
        .alert-val {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-left: 3px solid #f43f5e;
            border-radius: var(--r-md);
            padding: 11px 14px;
            font-size: 0.82rem;
            color: #991b1b;
            margin-bottom: 16px;
        }

        /* ── RESPONSIVE ───────────────────────────────────────── */
        @media (max-width: 900px) {
            .edit-grid { grid-template-columns: 1fr; gap: 14px; }
        }

        @media (max-width: 640px) {
            .page-content { padding: 14px 12px 32px; }

            /* Form grid → 1 kolom */
            .form-grid { grid-template-columns: 1fr; }
            .form-row:nth-child(odd) { border-right: none; }
            .form-row { border-bottom: 1px solid var(--c-border); }
            .form-row:last-child { border-bottom: none; }

            /* Hero lebih compact */
            .company-avatar { width: 46px; height: 46px; font-size: 1.1rem; }
            .ch-name { font-size: 0.92rem; }
            .hero-badge { display: none; } /* tersembunyi di HP kecil */

            /* iOS zoom prevention */
            .f-input, .f-select, .f-textarea { font-size: 16px; }
        }

        @media (max-width: 400px) {
            .company-hero { padding: 16px 14px; gap: 12px; }
        }
    </style>
</head>
<body>

<?php $this->load->view('admin/sidebar'); ?>

<div class="page-wrapper">

    <!-- ── Topnav ───────────────────────────────────────────── -->
    <header class="topnav">
        <div class="topnav-breadcrumb">
            <!-- Hamburger — hanya muncul di mobile -->
            <button class="topnav-burger" id="sidebarBurger" aria-label="Buka Menu">
                <i class="fas fa-bars"></i>
            </button>

            <a href="<?= base_url('admin/dashboard') ?>" style="color:var(--c-text-muted);text-decoration:none;">
                <i class="fas fa-home"></i>
            </a>
            <i class="fas fa-chevron-right" style="font-size:8px;"></i>
            <a href="<?= base_url('admin/perusahaan') ?>" style="color:var(--c-text-muted);text-decoration:none;">Perusahaan</a>
            <i class="fas fa-chevron-right" style="font-size:8px;"></i>
            <a href="<?= site_url('admin/detail_user/'.$user->id) ?>" style="color:var(--c-text-muted);text-decoration:none;max-width:100px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                <?= htmlspecialchars($user->perusahaan) ?>
            </a>
            <i class="fas fa-chevron-right" style="font-size:8px;"></i>
            <strong>Edit</strong>
        </div>
        <div class="topnav-actions">
            <!--<a href="<?= site_url('admin/detail_perusahaan/'.$user->id) ?>"
               class="btn-secondary" style="height:34px;padding:0 12px;font-size:0.78rem;">
                <i class="fas fa-arrow-left"></i>
                <span class="desktop-label">Kembali</span>
            </a>-->
        </div>
    </header>

    <style>
        @media (max-width: 480px) { .desktop-label { display: none; } }
    </style>

    <main class="page-content">

        <?php $initials = strtoupper(substr($user->perusahaan, 0, 2)); ?>

        <!-- Company hero banner -->
        <div class="company-hero">
            <div class="company-avatar"><?= $initials ?></div>
            <div class="company-hero-info">
                <div class="ch-name"><?= htmlspecialchars($user->perusahaan) ?></div>
                <div class="ch-sub">
                    <i class="fas fa-pen"></i>
                    Sedang mengedit data perusahaan
                </div>
            </div>
            <span class="hero-badge">
                <i class="fas fa-pen-to-square"></i> Mode Edit
            </span>
        </div>

        <!-- Validasi errors -->
        <?php if(validation_errors()): ?>
        <div class="alert-val">
            <i class="fas fa-exclamation-circle" style="margin-right:6px;"></i>
            <?= validation_errors() ?>
        </div>
        <?php endif; ?>

        <?= form_open('admin/update_user/'.$user->id) ?>

        <div class="edit-grid">

            <!-- ════════════════════════════════════════
                 KOLOM KIRI: Form utama
            ════════════════════════════════════════ -->
            <div>

                <!-- Informasi Perusahaan -->
                <div class="surface" style="margin-bottom:16px;">
                    <div class="surface-header">
                        <div class="surface-title">
                            <i class="fas fa-building"></i> Informasi Perusahaan
                        </div>
                    </div>

                    <div class="form-grid">

                        <div class="form-row">
                            <div class="form-icon"><i class="fas fa-user-tie"></i></div>
                            <div class="form-field">
                                <label class="f-label" for="nama">Nama PIC</label>
                                <input type="text" id="nama" name="nama" class="f-input"
                                       value="<?= set_value('nama', $user->nama) ?>" required>
                                <?php if(form_error('nama')): ?>
                                    <div class="field-error"><i class="fas fa-exclamation-circle" style="font-size:9px;"></i><?= form_error('nama') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-icon"><i class="fas fa-building"></i></div>
                            <div class="form-field">
                                <label class="f-label" for="perusahaan">Nama Perusahaan</label>
                                <input type="text" id="perusahaan" name="perusahaan" class="f-input"
                                       value="<?= set_value('perusahaan', $user->perusahaan) ?>" required>
                                <?php if(form_error('perusahaan')): ?>
                                    <div class="field-error"><i class="fas fa-exclamation-circle" style="font-size:9px;"></i><?= form_error('perusahaan') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-icon"><i class="fas fa-envelope"></i></div>
                            <div class="form-field">
                                <label class="f-label" for="email">Email</label>
                                <input type="email" id="email" name="email" class="f-input mono"
                                       value="<?= set_value('email', $user->email) ?>" required>
                                <?php if(form_error('email')): ?>
                                    <div class="field-error"><i class="fas fa-exclamation-circle" style="font-size:9px;"></i><?= form_error('email') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-icon"><i class="fas fa-phone"></i></div>
                            <div class="form-field">
                                <label class="f-label" for="no_hp">Nomor HP</label>
                                <input type="tel" id="no_hp" name="no_hp" class="f-input mono"
                                       value="<?= set_value('no_hp', $user->no_hp) ?>" required>
                                <?php if(form_error('no_hp')): ?>
                                    <div class="field-error"><i class="fas fa-exclamation-circle" style="font-size:9px;"></i><?= form_error('no_hp') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-row col-full">
                            <div class="form-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <div class="form-field">
                                <label class="f-label" for="alamat">Alamat Perusahaan</label>
                                <textarea id="alamat" name="alamat" class="f-textarea" required><?= set_value('alamat', $user->alamat) ?></textarea>
                                <?php if(form_error('alamat')): ?>
                                    <div class="field-error"><i class="fas fa-exclamation-circle" style="font-size:9px;"></i><?= form_error('alamat') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Ubah Password (opsional) -->
                <div class="surface">
                    <div class="surface-header">
                        <div class="surface-title">
                            <i class="fas fa-lock" style="color:#f59e0b;"></i>
                            Ubah Password
                            <span style="background:#fef3c7;color:#92400e;padding:2px 8px;border-radius:20px;font-size:0.65rem;font-weight:600;margin-left:4px;">Opsional</span>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-row">
                            <div class="form-icon" style="background:#fef3c7;color:#d97706;">
                                <i class="fas fa-key"></i>
                            </div>
                            <div class="form-field">
                                <label class="f-label" for="password">Password Baru</label>
                                <input type="password" id="password" name="password" class="f-input"
                                       placeholder="Kosongkan jika tidak diubah"
                                       autocomplete="new-password">
                                <?php if(form_error('password')): ?>
                                    <div class="field-error"><i class="fas fa-exclamation-circle" style="font-size:9px;"></i><?= form_error('password') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-icon" style="background:#fef3c7;color:#d97706;">
                                <i class="fas fa-key"></i>
                            </div>
                            <div class="form-field">
                                <label class="f-label" for="password_confirm">Konfirmasi Password</label>
                                <input type="password" id="password_confirm" name="password_confirm"
                                       class="f-input" placeholder="Ulangi password baru"
                                       autocomplete="new-password">
                                <?php if(form_error('password_confirm')): ?>
                                    <div class="field-error"><i class="fas fa-exclamation-circle" style="font-size:9px;"></i><?= form_error('password_confirm') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- /kolom kiri -->

            <!-- ════════════════════════════════════════
                 KOLOM KANAN: Aksi + Info akun
            ════════════════════════════════════════ -->
            <div>

                <!-- Aksi -->
                <div class="surface" style="margin-bottom:14px;">
                    <div class="surface-header">
                        <div class="surface-title">
                            <i class="fas fa-bolt"></i> Aksi
                        </div>
                    </div>
                    <div style="padding:14px 16px; display:flex; flex-direction:column; gap:8px;">

                        <button type="submit" class="btn-save">
                            <i class="fas fa-floppy-disk"></i> Simpan Perubahan
                        </button>

                        <button type="button" class="btn-cancel"
                                onclick="window.location.href='<?= site_url('admin/manage_users') ?>'">
                            <i class="fas fa-xmark"></i> Batal
                        </button>

                        <div class="status-divider">
                            <div class="status-label">Status Akun</div>
                            <?php if($user->is_active == 1): ?>
                                <a href="<?= site_url('admin/toggle_user/'.$user->id) ?>"
                                   class="btn-toggle btn-deactivate"
                                   onclick="return confirm('Nonaktifkan akun perusahaan ini?')">
                                    <i class="fas fa-ban"></i> Nonaktifkan Akun
                                </a>
                            <?php else: ?>
                                <a href="<?= site_url('admin/toggle_user/'.$user->id) ?>"
                                   class="btn-toggle btn-activate"
                                   onclick="return confirm('Aktifkan kembali akun perusahaan ini?')">
                                    <i class="fas fa-check-circle"></i> Aktifkan Akun
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Info Akun -->
                <div class="surface">
                    <div class="surface-header">
                        <div class="surface-title">
                            <i class="fas fa-circle-info"></i> Info Akun
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="form-icon" style="background:#eff6ff;color:#3b82f6;margin-top:0;">
                            <i class="fas fa-id-badge"></i>
                        </div>
                        <div>
                            <div class="info-label">User ID</div>
                            <div class="info-value" style="color:var(--c-primary);">#<?= $user->id ?></div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="form-icon" style="background:#f5f3ff;color:#7c3aed;margin-top:0;">
                            <i class="fas fa-calendar-plus"></i>
                        </div>
                        <div>
                            <div class="info-label">Terdaftar Sejak</div>
                            <div class="info-value">
                                <?= isset($user->created_at) ? date('d M Y', strtotime($user->created_at)) : '-' ?>
                            </div>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="form-icon" style="background:<?= $user->is_active ? '#ecfdf5' : '#fef2f2' ?>;color:<?= $user->is_active ? '#16a34a' : '#dc2626' ?>;margin-top:0;">
                            <i class="fas fa-<?= $user->is_active ? 'check-circle' : 'ban' ?>"></i>
                        </div>
                        <div>
                            <div class="info-label">Status</div>
                            <div class="info-value" style="color:<?= $user->is_active ? '#16a34a' : '#dc2626' ?>;">
                                <?= $user->is_active ? 'Aktif' : 'Nonaktif' ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- /kolom kanan -->

        </div><!-- /edit-grid -->

        <?= form_close() ?>

    </main>

    <?php $this->load->view('footer'); ?>
</div>

<script>
(function () {

    /* ── Hamburger — buka sidebar di mobile ──────────────── */
    var burger = document.getElementById('sidebarBurger');
    if (burger) {
        burger.addEventListener('click', function (e) {
            e.stopPropagation();

            /* 1. Coba hook ke fungsi global dari shared sidebar */
            if (typeof window.openAdminSidebar === 'function') {
                window.openAdminSidebar();
                return;
            }

            /* 2. Fallback: toggle class mobile-open + buat overlay */
            var sidebar = document.getElementById('mainSidebar');
            if (!sidebar) return;

            var isOpen = sidebar.classList.contains('mobile-open');

            if (isOpen) {
                /* Tutup */
                sidebar.classList.remove('mobile-open');
                var ov = document.getElementById('sidebarOverlay');
                if (ov) ov.remove();
            } else {
                /* Buka */
                sidebar.classList.add('mobile-open');

                var overlay = document.createElement('div');
                overlay.id = 'sidebarOverlay';
                overlay.style.cssText = 'position:fixed;inset:0;background:rgba(0,0,0,0.45);z-index:998;';
                overlay.addEventListener('click', function () {
                    sidebar.classList.remove('mobile-open');
                    overlay.remove();
                });
                document.body.appendChild(overlay);
            }
        });
    }

    /* ── Sidebar toggle (desktop collapse) ──────────────── */
    var sidebarEl = document.getElementById('mainSidebar');
    var toggleBtn = document.getElementById('sidebarToggle');
    var chevron   = document.getElementById('toggleChevron');

    if (sidebarEl && toggleBtn) {
        if (localStorage.getItem('sidebarCollapsed') === '1') {
            sidebarEl.classList.add('collapsed');
            if (chevron) chevron.style.transform = 'rotate(180deg)';
        }

        toggleBtn.addEventListener('click', function () {
            sidebarEl.classList.toggle('collapsed');
            var c = sidebarEl.classList.contains('collapsed');
            localStorage.setItem('sidebarCollapsed', c ? '1' : '0');
            if (chevron) chevron.style.transform = c ? 'rotate(180deg)' : 'rotate(0deg)';
        });
    }

})();
</script>
</body>
</html>