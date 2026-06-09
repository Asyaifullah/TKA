<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Perusahaan — SITLAKEB TKA Admin</title>
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

        /* ── Toolbar ── */
        .tbl-toolbar {
            padding: 14px 20px;
            border-bottom: 1px solid var(--c-border);
            display: flex; align-items: center;
            justify-content: space-between;
            gap: 12px; flex-wrap: wrap;
        }

        /* ── Search ── */
        .search-wrap { position: relative; flex: 1; max-width: 320px; }
        .search-wrap .s-icon {
            position: absolute; left: 11px; top: 50%;
            transform: translateY(-50%);
            color: var(--c-text-muted); font-size: 12px;
            pointer-events: none; transition: color 0.15s;
        }
        .search-wrap .s-clear {
            position: absolute; right: 9px; top: 50%;
            transform: translateY(-50%);
            color: var(--c-text-muted); font-size: 11px;
            cursor: pointer; display: none;
            background: var(--c-border); border: none; border-radius: 50%;
            width: 18px; height: 18px;
            align-items: center; justify-content: center;
            transition: background 0.15s;
        }
        .search-wrap .s-clear:hover { background: #cbd5e1; }
        .search-wrap.has-value .s-clear { display: flex; }
        .search-wrap.has-value .s-icon  { color: var(--c-primary); }
        .search-input {
            width: 100%;
            font-family: var(--font-body, 'DM Sans', sans-serif);
            font-size: 0.82rem; font-weight: 500;
            color: var(--c-text); background: var(--c-bg, #f8fafc);
            border: 1px solid var(--c-border); border-radius: var(--r-sm);
            padding: 7px 32px; outline: none;
            transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
        }
        .search-input:focus { background: #fff; border-color: var(--c-primary); box-shadow: 0 0 0 3px var(--c-primary-light); }
        .search-input::placeholder { color: #cbd5e1; }

        /* ── Counter pill ── */
        .tbl-counter { font-size: 0.75rem; color: var(--c-text-muted); white-space: nowrap; }
        .tbl-counter strong { color: var(--c-text); }

        /* ── Table ── */
        .data-table thead th {
            background: #fafcff; color: var(--c-text-muted);
            font-size: 0.68rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.07em;
            padding: 11px 16px; border-bottom: 1px solid var(--c-border);
            white-space: nowrap; text-align: left;
        }
        .data-table tbody td {
            padding: 12px 16px; vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.83rem; color: var(--c-text);
        }
        .data-table tbody tr:last-child td { border-bottom: none; }
        .data-table tbody tr:hover td { background: #f8fffe; }

        /* ── Company cell ── */
        .company-cell { display: flex; align-items: center; gap: 10px; }
        .co-avatar {
            width: 32px; height: 32px; border-radius: var(--r-sm);
            background: var(--c-primary-light); color: var(--c-primary);
            font-family: var(--font-head); font-size: 0.72rem; font-weight: 800;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; text-transform: uppercase;
        }
        .co-name { font-weight: 600; color: var(--c-text); font-size: 0.84rem; line-height: 1.3; }
        .co-id   { font-size: 0.68rem; color: var(--c-text-muted); font-family: 'Courier New', monospace; }

        /* ── PIC cell ── */
        .pic-wrap { display: flex; align-items: center; gap: 8px; }
        .pic-avatar {
            width: 26px; height: 26px; border-radius: 50%;
            background: #eff6ff; color: #3b82f6;
            font-size: 9px; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; text-transform: uppercase;
        }
        .pic-name { font-size: 0.82rem; color: var(--c-text); font-weight: 500; }

        /* ── Contact cell ── */
        .contact-email { font-size: 0.79rem; color: var(--c-text); }
        .contact-phone { font-size: 0.73rem; color: var(--c-text-muted); margin-top: 2px; }

        /* ── Status badge ── */
        .sts-badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 3px 10px; border-radius: 6px;
            font-size: 0.68rem; font-weight: 700;
            font-family: var(--font-head); white-space: nowrap;
        }
        .sts-badge::before { content: ''; width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
        .sts-aktif           { background: #ecfdf5; color: #065f46; }
        .sts-aktif::before   { background: #10b981; }
        .sts-nonaktif        { background: #fff1f2; color: #9f1239; }
        .sts-nonaktif::before{ background: #f43f5e; }

        /* ── Action buttons ── */
        .act-btn {
            display: inline-flex; align-items: center; justify-content: center;
            width: 28px; height: 28px; border-radius: 6px; border: 1px solid;
            font-size: 11px; text-decoration: none;
            transition: background 0.15s, border-color 0.15s, transform 0.1s;
            flex-shrink: 0; cursor: pointer;
        }
        .act-btn:hover { transform: translateY(-1px); text-decoration: none; }
        .ab-detail { background: #f1f5f9; color: #334155; border-color: #e2e8f0; }
        .ab-detail:hover { background: var(--c-primary-light); border-color: #a7d9cf; color: var(--c-primary); }
        .ab-edit   { background: #fffbeb; color: #92400e; border-color: #fde68a; }
        .ab-edit:hover   { background: #fef3c7; border-color: #fcd34d; color: #92400e; }
        .ab-reset  { background: #eff6ff; color: #1e40af; border-color: #bfdbfe; }
        .ab-reset:hover  { background: #dbeafe; border-color: #93c5fd; color: #1e40af; }
        .ab-off    { background: #f1f5f9; color: #475569; border-color: #e2e8f0; }
        .ab-off:hover    { background: #fee2e2; color: #991b1b; border-color: #fca5a5; }
        .ab-on     { background: #ecfdf5; color: #065f46; border-color: #a7f3d0; }
        .ab-on:hover     { background: #d1fae5; border-color: #6ee7b7; color: #065f46; }
        .ab-delete { background: #fff1f2; color: #9f1239; border-color: #fecdd3; }
        .ab-delete:hover { background: #ffe4e6; border-color: #fda4af; color: #9f1239; }

        /* ── Pagination ── */
        .paging-wrap {
            padding: 14px 20px; border-top: 1px solid var(--c-border);
            display: flex; justify-content: space-between; align-items: center;
            flex-wrap: wrap; gap: 10px; background: var(--c-surface-2);
        }
        .paging-info { font-size: 0.72rem; color: var(--c-text-muted); }
        .paging-controls { display: flex; align-items: center; gap: 4px; }
        .page-btn {
            display: inline-flex; align-items: center; justify-content: center;
            min-width: 30px; height: 30px; padding: 0 8px;
            border: 1px solid var(--c-border-strong); border-radius: var(--r-sm);
            background: var(--c-surface); font-family: var(--font-body);
            font-size: 0.75rem; font-weight: 500; color: var(--c-text-mid);
            cursor: pointer; transition: all 0.12s; user-select: none;
        }
        .page-btn:hover:not(:disabled):not(.active) { background: var(--c-primary-light); border-color: var(--c-primary); color: var(--c-primary); }
        .page-btn.active { background: var(--c-primary); border-color: var(--c-primary); color: white; font-weight: 700; }
        .page-btn:disabled { opacity: 0.35; cursor: not-allowed; }
        .per-page-wrap { display: flex; align-items: center; gap: 6px; font-size: 0.72rem; color: var(--c-text-muted); }
        .per-page-select {
            padding: 3px 22px 3px 8px; border: 1px solid var(--c-border-strong);
            border-radius: var(--r-sm); background: var(--c-surface);
            font-size: 0.72rem; color: var(--c-text); outline: none; appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 7px center; cursor: pointer;
        }

        .no-result-cell { padding: 48px 20px !important; text-align: center; }
        .no-result-cell .nri { font-size: 2rem; color: #cbd5e1; margin-bottom: 10px; }
        .no-result-cell p { font-size: 0.84rem; color: var(--c-text-muted); margin: 0; }
        mark.hl { background: #fef9c3; color: #92400e; border-radius: 2px; padding: 0 1px; }

        /* ── Hamburger button (mobile) ── */
        .btn-hamburger {
            display: none;
            width: 36px; height: 36px; border-radius: 9px;
            border: 1px solid var(--c-border); background: var(--c-surface);
            align-items: center; justify-content: center;
            color: #64748b; font-size: 15px; cursor: pointer; flex-shrink: 0;
            transition: background .15s, color .15s;
        }
        .btn-hamburger:hover { background: var(--c-primary-light); color: var(--c-primary); }

        /* helper: mobile-only meta */
        .mobile-meta { display: none; }
        /* helper: desktop-only col */
        .desktop-only { }

        /* ══════════════════════════════════════════
           MOBILE  ≤ 768px — semua perubahan di sini
        ══════════════════════════════════════════ */
        @media (max-width: 768px) {

            /* Hamburger tampil */
            .btn-hamburger { display: flex; }

            /* Topnav */
            .topnav { padding: 0 14px; gap: 10px; }
            /* Sembunyikan breadcrumb kecuali judul halaman */
            .topnav-breadcrumb a,
            .topnav-breadcrumb span,
            .topnav-breadcrumb .fa-chevron-right { display: none; }

            /* Page */
            .page-content { padding: 14px; }

            /* Page heading */
            .page-heading-wrap {
                flex-direction: column; gap: 6px;
                margin-bottom: 14px !important;
            }
            .page-heading-wrap h1 { font-size: 1rem; }
            .page-heading-wrap p  { font-size: 0.73rem; }

            /* Toolbar */
            .tbl-toolbar { flex-direction: column; align-items: stretch; padding: 12px 14px; gap: 8px; }
            .search-wrap { max-width: 100%; }
            .search-input { font-size: 0.84rem; padding: 9px 32px; }
            .tbl-counter  { font-size: 0.72rem; text-align: right; }

            /* ── Table → Card list ── */
            .data-table thead { display: none; }
            .data-table tbody { display: flex; flex-direction: column; }

            .data-table tbody tr {
                display: block;
                padding: 14px;
                border-bottom: 1px solid #f0f3f6;
                background: var(--c-surface);
                transition: background .12s;
            }
            .data-table tbody tr:last-child { border-bottom: none; }
            .data-table tbody tr:hover      { background: #fafcfc; }

            .data-table tbody td { display: block; padding: 0; border: none; }

            /* Nomor urut — sembunyikan */
            .data-table tbody td.col-no { display: none; }

            /* ── Zona 1: Nama perusahaan + ID ── */
            .data-table tbody td[data-label="Perusahaan"] { margin-bottom: 8px; }

            /* ── Zona 2: PIC + status (mobile-meta) ── */
            .mobile-meta {
                display: flex; align-items: center; flex-wrap: wrap;
                gap: 6px; margin-bottom: 10px;
            }
            .mobile-meta .pic-wrap { flex: 1; min-width: 0; }
            .mobile-meta .pic-name { font-size: 0.78rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

            /* Sembunyikan kolom PIC & Status (ditampilkan di mobile-meta) */
            .data-table tbody td[data-label="PIC"],
            .data-table tbody td[data-label="Status"] { display: none; }

            /* ── Zona 3: Kontak ── */
            .data-table tbody td[data-label="Kontak"] {
                background: var(--c-surface-2);
                border: 1px solid var(--c-border);
                border-radius: 8px;
                padding: 9px 12px;
                margin-bottom: 10px;
            }
            .contact-email { font-size: 0.79rem; }
            .contact-phone { font-size: 0.73rem; margin-top: 4px; }

            /* ── Zona 4: Aksi — full-width strip ── */
            .data-table tbody td[data-label="Aksi"] { padding: 0; }

            .act-strip-mobile {
                display: flex; gap: 7px;
                padding-top: 10px;
                border-top: 1px dashed #edf0f4;
            }
            /* Setiap tombol melebar merata */
            .act-strip-mobile .act-btn {
                flex: 1; width: auto; height: 34px;
                border-radius: 7px; font-size: 12px;
                gap: 5px;
            }
            .act-strip-mobile .act-btn .abl {
                font-size: 0.67rem; font-weight: 700;
                font-family: var(--font-head); white-space: nowrap;
            }
            /* Desktop strip tetap sembunyikan di mobile */
            .act-strip-desktop { display: none; }

            /* ── Pagination ── */
            .paging-wrap {
                padding: 12px 14px;
                flex-direction: column; align-items: stretch; gap: 10px;
            }
            .paging-info { text-align: center; }
            .per-page-wrap { justify-content: center; }
            .paging-controls { justify-content: center; flex-wrap: wrap; }
            .page-btn { min-width: 32px; height: 32px; }
        }

        /* ≤ 420px: sembunyikan label teks tombol, cukup ikon */
        @media (max-width: 420px) {
            .act-strip-mobile .act-btn .abl { display: none; }
            .act-strip-mobile .act-btn { font-size: 14px; }
        }
    </style>
</head>
<body>

<?php $this->load->view('admin/sidebar'); ?>

<div class="page-wrapper">

    <header class="topnav">
        <div style="display:flex; align-items:center; gap:10px;">
            <!-- Hamburger: memanggil window.openAdminSidebar() dari sidebar.php -->
            <button class="btn-hamburger" id="btnHamburger" aria-label="Buka Menu">
                <i class="fas fa-bars"></i>
            </button>
            <div class="topnav-breadcrumb">
                <a href="<?= base_url('dashboard') ?>" style="color:var(--c-text-muted);text-decoration:none;"><i class="fas fa-home"></i></a>
                <i class="fas fa-chevron-right" style="font-size:8px;"></i>
                <strong>Perusahaan</strong>
            </div>
        </div>
    </header>

    <main class="page-content">

        <!-- Flash messages -->
        <?php if($this->session->flashdata('success')): ?>
        <div style="background:#ecfdf5;border:1px solid #a7f3d0;border-left:4px solid #10b981;border-radius:var(--r-md);padding:11px 16px;font-size:0.82rem;color:#065f46;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
            <i class="fas fa-check-circle"></i> <?= $this->session->flashdata('success') ?>
        </div>
        <?php endif; ?>
        <?php if($this->session->flashdata('error')): ?>
        <div style="background:#fff1f2;border:1px solid #fecdd3;border-left:4px solid #f43f5e;border-radius:var(--r-md);padding:11px 16px;font-size:0.82rem;color:#9f1239;margin-bottom:16px;display:flex;align-items:center;gap:8px;">
            <i class="fas fa-exclamation-circle"></i> <?= $this->session->flashdata('error') ?>
        </div>
        <?php endif; ?>

        <!-- Page heading -->
        <div class="page-heading-wrap" style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
            <div>
                <div style="font-family:var(--font-head);font-size:1.1rem;font-weight:800;color:var(--c-text);margin-bottom:3px;">
                    <i class="fas fa-building" style="color:var(--c-primary);margin-right:8px;"></i>
                    Manajemen Perusahaan
                </div>
                <div style="font-size:0.78rem;color:var(--c-text-muted);">
                    Total <strong><?= count($users) ?></strong> perusahaan terdaftar
                </div>
            </div>
        </div>

        <div class="surface">

            <!-- Toolbar -->
            <div class="tbl-toolbar">
                <div class="search-wrap" id="searchWrap">
                    <i class="fas fa-search s-icon"></i>
                    <input type="text" class="search-input" id="searchInput"
                           placeholder="Cari perusahaan, PIC, email..." autocomplete="off">
                    <button class="s-clear" id="searchClear" title="Hapus pencarian">
                        <i class="fas fa-xmark" style="font-size:9px;"></i>
                    </button>
                </div>
                <div class="tbl-counter">
                    <strong id="visibleCount"><?= count($users) ?></strong> dari <?= count($users) ?> ditampilkan
                </div>
            </div>

            <!-- Table -->
            <div style="overflow-x:auto;">
                <table class="data-table" style="width:100%;border-collapse:collapse;">
                    <thead>
                        <tr>
                            <th style="width:44px;text-align:center;">#</th>
                            <th>Perusahaan</th>
                            <th>PIC</th>
                            <th>Kontak</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <?php $no = 1; foreach($users as $u):
                            $words   = explode(' ', trim($u->nama));
                            $picInit = strtoupper(substr($words[0], 0, 1));
                            if(isset($words[1])) $picInit .= strtoupper(substr($words[1], 0, 1));
                            $coInit  = strtoupper(substr($u->perusahaan, 0, 2));
                            $isActive = ($u->is_active == 1);
                        ?>
                        <tr data-search="<?= strtolower(htmlspecialchars($u->perusahaan . ' ' . $u->nama . ' ' . $u->email . ' ' . $u->no_hp)) ?>">

                            <!-- # -->
                            <td class="col-no" style="text-align:center;font-size:0.75rem;color:var(--c-text-muted);"><?= $no++ ?></td>

                            <!-- Perusahaan -->
                            <td data-label="Perusahaan">
                                <div class="company-cell">
                                    <div class="co-avatar"><?= $coInit ?></div>
                                    <div>
                                        <div class="co-name" data-field="perusahaan"><?= htmlspecialchars($u->perusahaan) ?></div>
                                        <div class="co-id">#<?= $u->id ?></div>
                                    </div>
                                </div>
                                <!-- Mobile-only: PIC + status di bawah nama perusahaan -->
                                <div class="mobile-meta">
                                    <div class="pic-wrap">
                                        <div class="pic-avatar"><?= $picInit ?></div>
                                        <span class="pic-name" data-field="nama_mobile"><?= htmlspecialchars($u->nama) ?></span>
                                    </div>
                                    <?php if($isActive): ?>
                                        <span class="sts-badge sts-aktif">Aktif</span>
                                    <?php else: ?>
                                        <span class="sts-badge sts-nonaktif">Nonaktif</span>
                                    <?php endif; ?>
                                </div>
                            </td>

                            <!-- PIC (desktop only) -->
                            <td data-label="PIC">
                                <div class="pic-wrap">
                                    <div class="pic-avatar"><?= $picInit ?></div>
                                    <span class="pic-name" data-field="nama"><?= htmlspecialchars($u->nama) ?></span>
                                </div>
                            </td>

                            <!-- Kontak -->
                            <td data-label="Kontak">
                                <div class="contact-email" data-field="email">
                                    <i class="fas fa-envelope" style="font-size:9px;color:var(--c-text-muted);margin-right:4px;"></i>
                                    <?= htmlspecialchars($u->email) ?>
                                </div>
                                <div class="contact-phone" data-field="no_hp">
                                    <i class="fas fa-phone" style="font-size:9px;color:var(--c-text-muted);margin-right:4px;"></i>
                                    <?= htmlspecialchars($u->no_hp) ?>
                                </div>
                            </td>

                            <!-- Status (desktop only) -->
                            <td data-label="Status">
                                <?php if($isActive): ?>
                                    <span class="sts-badge sts-aktif">Aktif</span>
                                <?php else: ?>
                                    <span class="sts-badge sts-nonaktif">Nonaktif</span>
                                <?php endif; ?>
                            </td>

                            <!-- Aksi -->
                            <td data-label="Aksi">

                                <!-- Desktop: ikon kecil -->
                                <div class="act-strip-desktop" style="display:flex;gap:4px;align-items:center;flex-wrap:nowrap;">
                                    <a href="<?= base_url('admin/detail_user/'.$u->id) ?>" class="act-btn ab-detail" title="Detail"><i class="fas fa-eye"></i></a>
                                    <a href="<?= base_url('admin/edit_user/'.$u->id) ?>" class="act-btn ab-edit" title="Edit"><i class="fas fa-pen"></i></a>
                                    <a href="<?= base_url('admin/reset_password/'.$u->id) ?>" class="act-btn ab-reset" title="Reset Password" onclick="return confirm('Reset password perusahaan ini menjadi default?')"><i class="fas fa-key"></i></a>
                                    <?php if($isActive): ?>
                                        <a href="<?= base_url('admin/toggle_status/'.$u->id) ?>" class="act-btn ab-off" title="Nonaktifkan" onclick="return confirm('Nonaktifkan akun perusahaan ini?')"><i class="fas fa-ban"></i></a>
                                    <?php else: ?>
                                        <a href="<?= base_url('admin/toggle_status/'.$u->id) ?>" class="act-btn ab-on" title="Aktifkan" onclick="return confirm('Aktifkan akun perusahaan ini?')"><i class="fas fa-check"></i></a>
                                    <?php endif; ?>
                                    <a href="<?= base_url('admin/delete_user/'.$u->id) ?>" class="act-btn ab-delete" title="Hapus" onclick="return confirm('Hapus perusahaan dan semua data TKA-nya?')"><i class="fas fa-trash"></i></a>
                                </div>

                                <!-- Mobile: tombol lebar dengan label -->
                                <div class="act-strip-mobile">
                                    <a href="<?= base_url('admin/detail_user/'.$u->id) ?>" class="act-btn ab-detail" title="Detail">
                                        <i class="fas fa-eye"></i><span class="abl"> Detail</span>
                                    </a>
                                    <a href="<?= base_url('admin/edit_user/'.$u->id) ?>" class="act-btn ab-edit" title="Edit">
                                        <i class="fas fa-pen"></i><span class="abl"> Edit</span>
                                    </a>
                                    <a href="<?= base_url('admin/reset_password/'.$u->id) ?>" class="act-btn ab-reset" title="Reset PW" onclick="return confirm('Reset password perusahaan ini menjadi default?')">
                                        <i class="fas fa-key"></i><span class="abl"> Reset</span>
                                    </a>
                                    <?php if($isActive): ?>
                                        <a href="<?= base_url('admin/toggle_status/'.$u->id) ?>" class="act-btn ab-off" title="Nonaktifkan" onclick="return confirm('Nonaktifkan akun perusahaan ini?')">
                                            <i class="fas fa-ban"></i><span class="abl"> Nonaktif</span>
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= base_url('admin/toggle_status/'.$u->id) ?>" class="act-btn ab-on" title="Aktifkan" onclick="return confirm('Aktifkan akun perusahaan ini?')">
                                            <i class="fas fa-check"></i><span class="abl"> Aktifkan</span>
                                        </a>
                                    <?php endif; ?>
                                    <a href="<?= base_url('admin/delete_user/'.$u->id) ?>" class="act-btn ab-delete" title="Hapus" onclick="return confirm('Hapus perusahaan dan semua data TKA-nya?')">
                                        <i class="fas fa-trash"></i><span class="abl"> Hapus</span>
                                    </a>
                                </div>

                            </td>
                        </tr>
                        <?php endforeach; ?>

                        <?php if(empty($users)): ?>
                        <tr>
                            <td colspan="6" class="no-result-cell">
                                <div class="nri"><i class="fas fa-building-circle-xmark"></i></div>
                                <p>Belum ada perusahaan terdaftar.</p>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- No result (JS) -->
            <div id="jsNoResult" style="display:none;padding:48px 20px;text-align:center;">
                <div style="font-size:2rem;color:#cbd5e1;margin-bottom:10px;"><i class="fas fa-magnifying-glass"></i></div>
                <p id="jsNoResultMsg" style="font-size:0.84rem;color:var(--c-text-muted);margin:0;"></p>
            </div>

            <!-- Pagination -->
            <div class="paging-wrap" id="pagingWrap">
                <div class="paging-info" id="pagingInfo">—</div>
                <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
                    <div class="per-page-wrap">
                        <span>Tampilkan</span>
                        <select class="per-page-select" id="perPageSelect">
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <span>per halaman</span>
                    </div>
                    <div class="paging-controls" id="pagingControls"></div>
                </div>
            </div>

        </div><!-- /surface -->
    </main>

    <?php $this->load->view('footer'); ?>
</div>

<script>
(function () {

    /* ── Hamburger: panggil fungsi dari sidebar.php ── */
    document.getElementById('btnHamburger')?.addEventListener('click', function () {
        if (typeof window.openAdminSidebar === 'function') {
            window.openAdminSidebar();
        }
    });

    /* ── Sinkronisasi desktop vs mobile untuk elemen duplikat ── */
    function syncView() {
        var isMobile = window.innerWidth <= 768;
        /* act-strip */
        document.querySelectorAll('.act-strip-desktop').forEach(function (el) {
            el.style.display = isMobile ? 'none' : 'flex';
        });
        document.querySelectorAll('.act-strip-mobile').forEach(function (el) {
            el.style.display = isMobile ? 'flex' : 'none';
        });
        /* mobile-meta (PIC + status di bawah nama perusahaan) */
        document.querySelectorAll('.mobile-meta').forEach(function (el) {
            el.style.display = isMobile ? 'flex' : 'none';
        });
    }
    syncView();
    window.addEventListener('resize', syncView);

    /* ── Search & Pagination ── */
    var input          = document.getElementById('searchInput');
    var clearBtn       = document.getElementById('searchClear');
    var searchWrap     = document.getElementById('searchWrap');
    var tbody          = document.getElementById('tableBody');
    var visCount       = document.getElementById('visibleCount');
    var jsNoResult     = document.getElementById('jsNoResult');
    var jsNoMsg        = document.getElementById('jsNoResultMsg');
    var pagingInfo     = document.getElementById('pagingInfo');
    var pagingControls = document.getElementById('pagingControls');
    var perPageSelect  = document.getElementById('perPageSelect');

    var allRows      = Array.from(tbody.querySelectorAll('tr[data-search]'));
    var filteredRows = [];
    var currentPage  = 1;
    var perPage      = 10;

    allRows.forEach(function (row) {
        row.querySelectorAll('[data-field]').forEach(function (el) {
            el.setAttribute('data-orig', el.textContent.trim());
        });
    });

    function escR(s) { return s.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'); }
    function hl(text, q) {
        if (!q) return text;
        return text.replace(new RegExp('(' + escR(q) + ')', 'gi'), '<mark class="hl">$1</mark>');
    }
    function getFiltered(q) {
        return allRows.filter(function (row) {
            return !q || row.getAttribute('data-search').indexOf(q) !== -1;
        });
    }

    function renderPaging(total, page, ppg) {
        var tp = Math.ceil(total / ppg) || 1;
        var s  = (page - 1) * ppg + 1, e = Math.min(page * ppg, total);
        pagingInfo.innerHTML = total > 0
            ? 'Menampilkan <strong>' + s + '–' + e + '</strong> dari <strong>' + total + '</strong> perusahaan'
            : '0 perusahaan ditemukan';
        pagingControls.innerHTML = '';
        pagingControls.appendChild(mkBtn('<i class="fas fa-chevron-left" style="font-size:10px;"></i>', page <= 1, function () { goToPage(page - 1); }));
        var sp = Math.max(1, page - 2), ep = Math.min(tp, sp + 4); sp = Math.max(1, ep - 4);
        if (sp > 1) { pagingControls.appendChild(mkPage(1, page)); if (sp > 2) pagingControls.appendChild(mkDots()); }
        for (var i = sp; i <= ep; i++) pagingControls.appendChild(mkPage(i, page));
        if (ep < tp) { if (ep < tp - 1) pagingControls.appendChild(mkDots()); pagingControls.appendChild(mkPage(tp, page)); }
        pagingControls.appendChild(mkBtn('<i class="fas fa-chevron-right" style="font-size:10px;"></i>', page >= tp, function () { goToPage(page + 1); }));
    }
    function mkBtn(html, disabled, cb) { var b = document.createElement('button'); b.className = 'page-btn'; b.innerHTML = html; b.disabled = disabled; b.addEventListener('click', cb); return b; }
    function mkPage(num, active) { var b = document.createElement('button'); b.className = 'page-btn' + (num === active ? ' active' : ''); b.textContent = num; b.addEventListener('click', function () { goToPage(num); }); return b; }
    function mkDots() { var s = document.createElement('span'); s.className = 'page-btn'; s.style.cursor = 'default'; s.textContent = '…'; return s; }
    function goToPage(page) { var tp = Math.ceil(filteredRows.length / perPage) || 1; currentPage = Math.max(1, Math.min(page, tp)); applyPaging(); }

    function doSearch(q) {
        q = q.trim().toLowerCase();
        filteredRows = getFiltered(q);
        currentPage  = 1;
        applyPaging(q);
        searchWrap.classList.toggle('has-value', q.length > 0);
    }

    function applyPaging(q) {
        if (q === undefined) q = input.value.trim().toLowerCase();
        var total = filteredRows.length;
        var start = (currentPage - 1) * perPage, end = start + perPage;
        allRows.forEach(function (row) { row.style.display = 'none'; });
        filteredRows.forEach(function (row, i) {
            var show = (i >= start && i < end);
            row.style.display = show ? '' : 'none';
            row.querySelectorAll('[data-field]').forEach(function (el) {
                var orig = el.getAttribute('data-orig') || '';
                el.innerHTML = (show && q) ? hl(orig, q) : orig;
            });
        });
        visCount.textContent = total;
        jsNoResult.style.display = (total === 0 && allRows.length > 0) ? 'block' : 'none';
        if (total === 0 && q) jsNoMsg.innerHTML = 'Tidak ada hasil untuk &ldquo;<strong>' + q + '</strong>&rdquo;';
        else if (total === 0) jsNoMsg.textContent = 'Tidak ada data.';
        renderPaging(total, currentPage, perPage);
        syncView(); /* pastikan strip benar setelah re-render */
    }

    input.addEventListener('input', function () { doSearch(this.value); });
    clearBtn.addEventListener('click', function () { input.value = ''; doSearch(''); input.focus(); });
    perPageSelect.addEventListener('change', function () { perPage = parseInt(this.value); currentPage = 1; applyPaging(); });
    document.addEventListener('keydown', function (e) {
        if ((e.key === '/' && document.activeElement !== input) || (e.ctrlKey && e.key === 'k')) { e.preventDefault(); input.focus(); input.select(); }
        if (e.key === 'Escape' && document.activeElement === input) { input.value = ''; doSearch(''); input.blur(); }
    });

    doSearch('');
})();
</script>
</body>
</html>