<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Petugas — SITLAKEB TKA Admin</title>

    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="stylesheet" href="<?= base_url('assets/css/shared.css') ?>">

    <style>

        html,
        body {
            height: 100%;
            overflow-x: hidden;
        }

        body {
            background: #f8fafc;
        }

        .page-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .page-content {
            flex: 1 0 auto;
            padding: 20px 28px 32px;
        }

        footer,
        .site-footer {
            flex-shrink: 0;
        }

        /* ─────────────────────────────
           BURGER
        ───────────────────────────── */
        .topnav-burger {
            display: none;
            width: 34px;
            height: 34px;
            border-radius: 9px;
            border: 1px solid var(--c-border);
            background: var(--c-surface-2, #f8fafc);
            align-items: center;
            justify-content: center;
            color: var(--c-text-muted);
            font-size: 13px;
            cursor: pointer;
            flex-shrink: 0;
            transition: background .15s, color .15s;
        }

        .topnav-burger:hover {
            background: var(--c-primary-light);
            color: var(--c-primary);
        }

        /* ─────────────────────────────
           HERO
        ───────────────────────────── */
        .officer-hero {
            background: linear-gradient(135deg, #1e40af 0%, #3b6dd4 100%);
            border-radius: 22px;
            padding: 24px 28px;
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
            position: relative;
            overflow: hidden;
        }

        .officer-hero::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 180px;
            height: 180px;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
        }

        .officer-hero::after {
            content: '';
            position: absolute;
            bottom: -50px;
            right: 120px;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
        }

        .officer-avatar {
            width: 64px;
            height: 64px;
            border-radius: 18px;
            background: rgba(255,255,255,0.2);
            border: 2px solid rgba(255,255,255,0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            font-weight: 800;
            color: white;
            flex-shrink: 0;
            z-index: 1;
        }

        .officer-hero-info {
            flex: 1;
            z-index: 1;
        }

        .oh-name {
            font-size: 1.1rem;
            font-weight: 800;
            color: white;
            margin-bottom: 4px;
        }

        .oh-sub {
            font-size: .78rem;
            color: rgba(255,255,255,.78);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .officer-hero-badges {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 8px;
            z-index: 1;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 999px;
            font-size: .7rem;
            font-weight: 700;
        }

        .hb-edit {
            background: rgba(255,255,255,.22);
            color: white;
        }

        .hb-role {
            background: rgba(255,255,255,.12);
            color: rgba(255,255,255,.88);
        }

        /* ─────────────────────────────
           SURFACE
        ───────────────────────────── */
        .surface {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            overflow: hidden;
            margin-bottom: 16px;
        }

        .surface-header {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 14px 20px;
            border-bottom: 1px solid #e2e8f0;
            background: #fff;
        }

        .surface-title {
            font-size: .88rem;
            font-weight: 700;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .surface-body {
            padding: 16px;
        }

        /* ─────────────────────────────
           GRID
        ───────────────────────────── */
        .content-grid {
            display: grid;
            grid-template-columns: minmax(0,1fr) 300px;
            gap: 20px;
            align-items: start;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2,1fr);
        }

        .form-row {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 16px 20px;
            border-bottom: 1px solid #e2e8f0;
        }

        .form-row:nth-child(odd) {
            border-right: 1px solid #e2e8f0;
        }

        .form-row.full-width {
            grid-column: 1 / -1;
            border-right: none;
        }

        .form-icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-top: 4px;
        }

        .form-field {
            flex: 1;
            min-width: 0;
        }

        .form-label-inline {
            display: block;
            font-size: .68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #64748b;
            margin-bottom: 6px;
        }

        .form-control-clean {
            width: 100%;
            border: 1px solid #dbe2ea;
            border-radius: 12px;
            padding: 10px 13px;
            font-size: .88rem;
            font-weight: 500;
            background: white;
            color: #0f172a;
            transition: .2s ease;
        }

        .form-control-clean:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 4px #dbeafe;
        }

        .form-control-clean.mono {
            font-family: monospace;
        }

        .field-hint {
            margin-top: 5px;
            font-size: .7rem;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        select.form-control-clean {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 40px;
        }

        /* ─────────────────────────────
           TOGGLE
        ───────────────────────────── */
        .toggle-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 18px 20px;
        }

        .toggle-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .toggle-icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: #f0fdf4;
            color: #16a34a;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .toggle-label {
            font-size: .86rem;
            font-weight: 700;
            color: #0f172a;
        }

        .toggle-desc {
            font-size: .74rem;
            color: #64748b;
            margin-top: 2px;
        }

        .switch {
            position: relative;
            width: 44px;
            height: 24px;
            flex-shrink: 0;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            inset: 0;
            background: #cbd5e1;
            border-radius: 999px;
            cursor: pointer;
            transition: .25s ease;
        }

        .slider:before {
            content: '';
            position: absolute;
            width: 18px;
            height: 18px;
            left: 3px;
            bottom: 3px;
            background: white;
            border-radius: 50%;
            transition: .25s ease;
            box-shadow: 0 1px 3px rgba(0,0,0,.2);
        }

        input:checked + .slider {
            background: #16a34a;
        }

        input:checked + .slider:before {
            transform: translateX(20px);
        }

        /* ─────────────────────────────
           BUTTON
        ───────────────────────────── */
        .btn-primary,
        .btn-secondary {
            width: 100%;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: .85rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
            transition: .2s ease;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background: #1d4ed8;
            color: white;
        }

        .btn-secondary {
            border: 1px solid #dbe2ea;
            background: white;
            color: #0f172a;
        }

        .btn-secondary:hover {
            background: #f8fafc;
            color: #0f172a;
        }

        /* ─────────────────────────────
           TOPNAV
        ───────────────────────────── */
        .topnav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 14px;
            padding: 0 28px;
        }

        .topnav-breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            font-size: .82rem;
            color: #64748b;
        }

        .topnav-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .topnav-btn {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            border: 1px solid #dbe2ea;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0f172a;
            text-decoration: none;
        }

        /* ─────────────────────────────
           RESPONSIVE
        ───────────────────────────── */
        @media (max-width:768px){

            .topnav {
                padding: 0 12px !important;
            }

            .topnav-burger {
                display: flex;
            }

            .topnav-breadcrumb .bc-hide {
                display: none;
            }

            .page-content {
                padding: 12px 12px 28px !important;
            }

            .content-grid {
                grid-template-columns: 1fr;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .form-row {
                border-right: none !important;
                padding: 15px 16px;
            }

            .surface {
                border-radius: 14px;
            }

            .surface-header {
                padding: 12px 16px;
            }

            .surface-body {
                padding: 14px;
            }

            .officer-hero {
                flex-direction: column;
                align-items: flex-start;
                padding: 18px;
                gap: 16px;
                border-radius: 18px;
            }

            .officer-hero-badges {
                width: 100%;
                flex-direction: row;
                align-items: flex-start;
                flex-wrap: wrap;
            }

            .toggle-row {
                flex-direction: column;
                align-items: flex-start;
            }

            .switch {
                align-self: flex-end;
            }

            .btn-primary,
            .btn-secondary {
                height: 46px;
                font-size: .9rem;
            }
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

            <a style="color:var(--c-text-muted);text-decoration:none;">
                <i class="fas fa-home"></i>
            </a>

            <i class="fas fa-chevron-right bc-hide" style="font-size:8px;"></i>

            <a href="<?= base_url('admin/manage_officers') ?>"
               class="bc-hide"
               style="color:var(--c-text-muted);text-decoration:none;">
                Petugas
            </a>

            <i class="fas fa-chevron-right" style="font-size:8px;"></i>

            <strong>Edit — <?= htmlspecialchars($user->nama) ?></strong>
        </div>

        <div class="topnav-actions">
            <!--<a href="<?= base_url('admin/manage_officers') ?>" class="topnav-btn">
                <i class="fas fa-arrow-left"></i>
            </a>-->
        </div>
    </header>

    <main class="page-content">

        <?php
            $roleLabels = [
                'kasi' => 'Kasi',
                'kabid' => 'Kabid',
                'sekdis' => 'Sekdis',
                'kadis' => 'Kadis',
                'admin' => 'Admin',
                'operator' => 'Operator',
            ];

            $currentRole = $roleLabels[$user->role] ?? strtoupper($user->role);
            $initials = strtoupper(substr($user->nama, 0, 2));
        ?>

        <!-- HERO -->
        <div class="officer-hero">

            <div class="officer-avatar">
                <?= $initials ?>
            </div>

            <div class="officer-hero-info">
                <div class="oh-name">
                    <?= htmlspecialchars($user->nama) ?>
                </div>

                <div class="oh-sub">
                    <i class="fas fa-pen"></i>
                    Sedang mengedit data petugas
                </div>
            </div>

            <div class="officer-hero-badges">

                <span class="hero-badge hb-edit">
                    <i class="fas fa-pen-to-square"></i>
                    Mode Edit
                </span>

                <span class="hero-badge hb-role">
                    <i class="fas fa-shield-halved"></i>
                    <?= $currentRole ?>
                </span>

            </div>
        </div>

        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger" style="border-radius:14px;margin-bottom:18px;">
                <i class="fas fa-circle-exclamation me-2"></i>
                <?= $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('admin/update_officer/'.$user->id) ?>" method="post">

            <input type="hidden"
                   name="<?= $this->security->get_csrf_token_name(); ?>"
                   value="<?= $this->security->get_csrf_hash(); ?>">

            <div class="content-grid">

                <!-- LEFT -->
                <div>

                    <div class="surface">

                        <div class="surface-header">
                            <div class="surface-title">
                                <i class="fas fa-id-card" style="color:#2563eb;"></i>
                                Data Petugas
                            </div>
                        </div>

                        <div class="form-grid">

                            <div class="form-row">
                                <div class="form-icon">
                                    <i class="fas fa-user"></i>
                                </div>

                                <div class="form-field">
                                    <label class="form-label-inline">Nama Lengkap</label>

                                    <input
                                        type="text"
                                        name="nama"
                                        class="form-control-clean"
                                        value="<?= htmlspecialchars($user->nama) ?>"
                                        placeholder="Nama lengkap petugas"
                                        required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-icon">
                                    <i class="fas fa-fingerprint"></i>
                                </div>

                                <div class="form-field">
                                    <label class="form-label-inline">NIP</label>

                                    <input
                                        type="text"
                                        name="nip"
                                        class="form-control-clean mono"
                                        value="<?= htmlspecialchars($user->nip) ?>"
                                        placeholder="Nomor Induk Pegawai"
                                        required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>

                                <div class="form-field">
                                    <label class="form-label-inline">Email</label>

                                    <input
                                        type="email"
                                        class="form-control-clean mono"
                                        value="<?= htmlspecialchars($user->email) ?>"
                                        disabled>

                                    <div class="field-hint">
                                        <i class="fas fa-lock"></i>
                                        Email tidak dapat diubah
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-icon">
                                    <i class="fas fa-phone"></i>
                                </div>

                                <div class="form-field">
                                    <label class="form-label-inline">No. Handphone</label>

                                    <input
                                        type="tel"
                                        name="no_hp"
                                        class="form-control-clean mono"
                                        value="<?= htmlspecialchars($user->no_hp) ?>"
                                        placeholder="08xxxxxxxxxx"
                                        maxlength="13"
                                        pattern="[0-9]+"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                        required>
                                </div>
                            </div>

                            <div class="form-row full-width">
                                <div class="form-icon" style="background:#f5f3ff;color:#7c3aed;">
                                    <i class="fas fa-shield-halved"></i>
                                </div>

                                <div class="form-field">
                                    <label class="form-label-inline">Role / Jabatan</label>

                                    <select name="role" class="form-control-clean" required>
                                        <option value="kasi" <?= $user->role == 'kasi' ? 'selected' : '' ?>>Kasi</option>
                                        <option value="kabid" <?= $user->role == 'kabid' ? 'selected' : '' ?>>Kabid</option>
                                        <option value="sekdis" <?= $user->role == 'sekdis' ? 'selected' : '' ?>>Sekdis</option>
                                        <option value="kadis" <?= $user->role == 'kadis' ? 'selected' : '' ?>>Kadis</option>
                                        <option value="admin" <?= $user->role == 'admin' ? 'selected' : '' ?>>Admin</option>
                                        <option value="operator" <?= $user->role == 'operator' ? 'selected' : '' ?>>Operator</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="toggle-row">

                            <div class="toggle-info">

                                <div class="toggle-icon">
                                    <i class="fas fa-circle-check"></i>
                                </div>

                                <div>
                                    <div class="toggle-label">Status Akun</div>
                                    <div class="toggle-desc">Akun aktif dapat login ke sistem</div>
                                </div>
                            </div>

                            <label class="switch">
                                <input
                                    type="checkbox"
                                    name="is_active"
                                    value="1"
                                    <?= $user->is_active == 1 ? 'checked' : '' ?>>

                                <span class="slider"></span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- RIGHT -->
                <div>

                    <div class="surface">

                        <div class="surface-header">
                            <div class="surface-title">
                                <i class="fas fa-bolt" style="color:#f59e0b;"></i>
                                Aksi
                            </div>
                        </div>

                        <div class="surface-body" style="display:flex;flex-direction:column;gap:10px;">

                            <button type="submit" class="btn-primary">
                                <i class="fas fa-floppy-disk"></i>
                                Simpan Perubahan
                            </button>

                            <a href="<?= base_url('admin/manage_officers') ?>" class="btn-secondary">
                                <i class="fas fa-xmark"></i>
                                Batal
                            </a>
                        </div>
                    </div>

                    <div class="surface">

                        <div class="surface-header">
                            <div class="surface-title">
                                <i class="fas fa-circle-info" style="color:#2563eb;"></i>
                                Info Akun
                            </div>
                        </div>

                        <div>

                            <div class="form-row" style="border-right:none;">

                                <div class="form-icon">
                                    <i class="fas fa-id-badge"></i>
                                </div>

                                <div>
                                    <div class="form-label-inline">User ID</div>

                                    <div style="font-size:.84rem;font-weight:700;color:#2563eb;font-family:monospace;">
                                        #<?= $user->id ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row" style="border-right:none;">

                                <div class="form-icon" style="background:#f5f3ff;color:#7c3aed;">
                                    <i class="fas fa-shield-halved"></i>
                                </div>

                                <div>
                                    <div class="form-label-inline">Role Saat Ini</div>

                                    <div style="font-size:.84rem;font-weight:700;color:#0f172a;">
                                        <?= $currentRole ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row" style="border-right:none;border-bottom:none;">

                                <div class="form-icon" style="background:#f5f3ff;color:#7c3aed;">
                                    <i class="fas fa-calendar-plus"></i>
                                </div>

                                <div>
                                    <div class="form-label-inline">Terdaftar Sejak</div>

                                    <div style="font-size:.84rem;font-weight:700;color:#0f172a;">
                                        <?= isset($user->created_at) ? date('d M Y', strtotime($user->created_at)) : '-' ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>

    <?php $this->load->view('footer'); ?>
</div>

<script>
(function(){

    /* ── Burger ── */
    var burger = document.getElementById('adminBurger');

    if (burger) {
        burger.addEventListener('click', function(e) {
            e.stopPropagation();

            if (typeof window.openAdminSidebar === 'function') {
                window.openAdminSidebar();
            }
        });
    }

    /* ── Sidebar collapse desktop ── */
    var sidebar = document.getElementById('adminSidebar');
    var toggle  = document.getElementById('adminSidebarToggle');

    if (sidebar && toggle) {

        toggle.addEventListener('click', function() {

            sidebar.classList.toggle('collapsed');

            localStorage.setItem(
                'adminSidebarCollapsed',
                sidebar.classList.contains('collapsed') ? '1' : '0'
            );
        });
    }

    if (sidebar && localStorage.getItem('adminSidebarCollapsed') === '1') {
        sidebar.classList.add('collapsed');
    }

})();
</script>

</body>
</html>

