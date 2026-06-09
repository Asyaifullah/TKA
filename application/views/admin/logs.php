<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Aktivitas — SITLAKEB TKA Admin</title>
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

        /* ── Filter bar ── */
        .filter-bar {
            display: flex; flex-wrap: wrap; gap: 8px; align-items: center;
            padding: 14px 20px;
            background: var(--c-surface-2);
            border-bottom: 1px solid var(--c-border);
        }
        .filter-input-wrap { position: relative; flex: 1; min-width: 180px; }
        .filter-icon {
            position: absolute; left: 11px; top: 50%; transform: translateY(-50%);
            color: var(--c-text-muted); font-size: 11px; pointer-events: none;
        }
        .filter-input {
            width: 100%; padding: 7px 12px 7px 30px;
            border: 1px solid var(--c-border-strong); border-radius: var(--r-md);
            background: var(--c-surface); font-family: var(--font-body);
            font-size: 0.78rem; color: var(--c-text); outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .filter-input:focus { border-color: var(--c-primary); box-shadow: 0 0 0 3px var(--c-primary-glow); }
        .filter-input::placeholder { color: var(--c-text-muted); }
        .filter-select {
            padding: 7px 28px 7px 10px; border: 1px solid var(--c-border-strong);
            border-radius: var(--r-md); background: var(--c-surface);
            font-family: var(--font-body); font-size: 0.78rem; color: var(--c-text);
            outline: none; appearance: none; cursor: pointer;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 9px center;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .filter-select:focus { border-color: var(--c-primary); box-shadow: 0 0 0 3px var(--c-primary-glow); }
        .filter-date {
            padding: 7px 10px; border: 1px solid var(--c-border-strong);
            border-radius: var(--r-md); background: var(--c-surface);
            font-family: var(--font-body); font-size: 0.78rem; color: var(--c-text);
            outline: none; transition: border-color 0.15s;
        }
        .filter-date:focus { border-color: var(--c-primary); box-shadow: 0 0 0 3px var(--c-primary-glow); }
        .btn-reset-filter {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 7px 14px; border: 1px solid var(--c-border-strong);
            border-radius: var(--r-md); background: var(--c-surface);
            font-family: var(--font-body); font-size: 0.75rem; font-weight: 500;
            color: var(--c-text-mid); cursor: pointer; white-space: nowrap;
            transition: background 0.12s, color 0.12s;
        }
        .btn-reset-filter:hover { background: var(--c-surface-2); color: var(--c-text); }

        /* ── Active filter tags ── */
        .filter-active-bar {
            display: none; flex-wrap: wrap; gap: 6px; align-items: center;
            padding: 8px 20px; border-bottom: 1px solid var(--c-border);
            background: var(--c-primary-light); font-size: 0.72rem; color: var(--c-primary);
        }
        .filter-active-bar.visible { display: flex; }
        .filter-tag {
            display: inline-flex; align-items: center; gap: 5px;
            background: white; border: 1px solid #b2d9ce;
            padding: 2px 8px; border-radius: 20px;
            font-size: 0.68rem; font-weight: 600; color: var(--c-primary);
        }
        .filter-tag-remove {
            background: none; border: none; padding: 0;
            cursor: pointer; color: var(--c-primary); font-size: 9px; line-height: 1;
        }

        /* ── Stats row ── */
        .log-stats {
            display: flex; flex-wrap: wrap; gap: 0;
            border-bottom: 1px solid var(--c-border);
        }
        .log-stat-item {
            flex: 1; min-width: 100px; padding: 12px 16px;
            text-align: center; border-right: 1px solid var(--c-border);
        }
        .log-stat-item:last-child { border-right: none; }
        .lsi-val { font-family: var(--font-head); font-size: 1.3rem; font-weight: 800; color: var(--c-text); line-height: 1; margin-bottom: 3px; }
        .lsi-lbl { font-size: 0.65rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; color: var(--c-text-muted); }

        /* ── Action badges ── */
        .action-badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 3px 9px; border-radius: var(--r-sm);
            font-size: 0.67rem; font-weight: 700;
            font-family: var(--font-head); letter-spacing: 0.02em; white-space: nowrap;
        }
        .action-badge::before { content: ''; width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }
        .ab-approve { background: #ecfdf5; color: #065f46; }
        .ab-approve::before { background: #10b981; }
        .ab-reject  { background: #fff1f2; color: #9f1239; }
        .ab-reject::before  { background: #f43f5e; }
        .ab-edit    { background: #eff6ff; color: #1e40af; }
        .ab-edit::before    { background: #3b82f6; }
        .ab-export  { background: #f5f3ff; color: #5b21b6; }
        .ab-export::before  { background: #8b5cf6; }
        .ab-default { background: #f1f5f9; color: #475569; }
        .ab-default::before { background: #94a3b8; }

        /* ── Target pill ── */
        .target-pill {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 0.72rem; color: var(--c-text-mid);
            background: var(--c-surface-2); border: 1px solid var(--c-border);
            padding: 2px 8px; border-radius: var(--r-sm);
        }
        .target-pill i { font-size: 9px; color: var(--c-text-muted); }

        /* ── IP code ── */
        .ip-code {
            font-family: 'Courier New', monospace; font-size: 0.72rem;
            color: var(--c-text-muted); background: var(--c-surface-2);
            border: 1px solid var(--c-border); padding: 2px 7px; border-radius: var(--r-sm);
        }

        /* ── Admin cell ── */
        .admin-wrap { display: flex; align-items: center; gap: 8px; }
        .admin-avatar {
            width: 26px; height: 26px; border-radius: 50%;
            background: var(--c-primary-light); color: var(--c-primary);
            font-size: 0.6rem; font-weight: 800;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; font-family: var(--font-head);
        }
        .admin-name { font-size: 0.8rem; font-weight: 600; color: var(--c-text); }
        .admin-id   { font-size: 0.67rem; color: var(--c-text-muted); }

        /* ── No result ── */
        .no-result-row td { text-align: center; padding: 48px 20px !important; color: var(--c-text-muted); }
        .no-result-icon { width: 48px; height: 48px; border-radius: var(--r-xl); background: var(--c-primary-light); color: var(--c-primary); display: flex; align-items: center; justify-content: center; font-size: 18px; margin: 0 auto 12px; }

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

        /* ── Refresh btn ── */
        .btn-refresh {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 7px 14px; border: 1px solid var(--c-border-strong);
            border-radius: var(--r-md); background: var(--c-surface);
            font-family: var(--font-body); font-size: 0.78rem; font-weight: 500;
            color: var(--c-text-mid); cursor: pointer; text-decoration: none;
            transition: background 0.12s;
        }
        .btn-refresh:hover { background: var(--c-surface-2); color: var(--c-text); }

        /* ── Hamburger ── */
        .btn-hamburger {
            display: none;
            width: 36px; height: 36px; border-radius: 9px;
            border: 1px solid var(--c-border); background: var(--c-surface);
            align-items: center; justify-content: center;
            color: #64748b; font-size: 15px; cursor: pointer; flex-shrink: 0;
            transition: background .15s, color .15s;
        }
        .btn-hamburger:hover { background: var(--c-primary-light); color: var(--c-primary); }

        /* ══════════════════════════════════════════
           MOBILE  ≤ 768px
        ══════════════════════════════════════════ */
        @media (max-width: 768px) {

            .btn-hamburger { display: flex; }

            /* Topnav */
            .topnav { padding: 0 14px; gap: 10px; }
            .topnav-breadcrumb a,
            .topnav-breadcrumb span,
            .topnav-breadcrumb .fa-chevron-right { display: none; }
            /* Refresh button di topnav — compact */
            .btn-refresh span { display: none; }
            .btn-refresh { padding: 7px 10px; }

            /* Page */
            .page-content { padding: 14px; }
            .page-header   { margin-bottom: 14px !important; }

            /* Surface header */
            .surface-header { padding: 12px 14px; flex-wrap: wrap; gap: 8px; }

            /* Stats: scroll horizontal, tetap tampil (tidak disembunyikan) */
            .log-stats {
                display: flex; flex-direction: row; flex-wrap: nowrap;
                overflow-x: auto; -webkit-overflow-scrolling: touch;
                scrollbar-width: none; padding: 0;
            }
            .log-stats::-webkit-scrollbar { display: none; }
            .log-stat-item { flex: 0 0 auto; min-width: 80px; padding: 10px 12px; }
            .lsi-val { font-size: 1.1rem; }
            .lsi-lbl { font-size: 0.58rem; }

            /* Filter bar — vertikal */
            .filter-bar {
                flex-direction: column; align-items: stretch;
                padding: 12px 14px; gap: 8px;
            }
            .filter-input-wrap { min-width: 100%; }
            .filter-input   { font-size: 0.84rem; padding: 9px 12px 9px 30px; }
            .filter-select  { width: 100%; font-size: 0.82rem; padding: 9px 28px 9px 10px; }
            .filter-date    { width: 100%; font-size: 0.82rem; padding: 9px 10px; }
            .btn-reset-filter { width: 100%; justify-content: center; padding: 9px 14px; font-size: 0.8rem; }

            /* Filter active bar */
            .filter-active-bar { padding: 8px 14px; }

            /* ── Table → Card list ── */
            .data-table thead { display: none; }
            .data-table tbody { display: flex; flex-direction: column; }

            .data-table tbody tr {
                display: grid;
                /* Grid 2-kolom:
                   col1: admin + badge aksi
                   col2: badge aksi (kanan)
                   row2: deskripsi full-width
                   row3: footer (target + IP + waktu) */
                grid-template-columns: 1fr auto;
                row-gap: 0;
                column-gap: 10px;
                padding: 14px;
                border-bottom: 1px solid #f0f3f6;
                transition: background .12s;
            }
            .data-table tbody tr:last-child { border-bottom: none; }
            .data-table tbody tr:hover { background: #fafcfc; }

            .data-table tbody td { display: block; padding: 0; border: none; }

            /* Kolom Waktu — disembunyikan, info waktu muncul di footer zone via admin-time */
            .data-table tbody td:nth-child(1) { display: none; }

            /* Kolom Admin — grid row 1 col 1 */
            .data-table tbody td:nth-child(2) {
                grid-column: 1; grid-row: 1;
                align-self: center; margin-bottom: 6px;
            }
            /* Tambahkan waktu di bawah admin-id */
            .admin-time {
                font-size: 0.65rem; color: var(--c-text-muted);
                display: block; margin-top: 1px;
            }

            /* Kolom Aksi (badge) — grid row 1 col 2 */
            .data-table tbody td:nth-child(3) {
                grid-column: 2; grid-row: 1;
                align-self: center; justify-self: end;
            }
            .action-badge { font-size: 0.66rem; padding: 4px 9px; }

            /* Kolom Deskripsi — row 2 full width */
            .data-table tbody td:nth-child(5) {
                grid-column: 1 / -1; grid-row: 2;
                font-size: 0.78rem; color: var(--c-text-mid); line-height: 1.55;
                padding: 7px 0 8px;
                border-bottom: 1px dashed #edf0f4;
                margin-bottom: 8px;
            }

            /* Kolom Target — row 3 col 1 */
            .data-table tbody td:nth-child(4) {
                grid-column: 1; grid-row: 3;
                align-self: center;
            }

            /* Kolom IP — row 3 col 2 */
            .data-table tbody td:nth-child(6) {
                grid-column: 2; grid-row: 3;
                justify-self: end; align-self: center;
            }

            .target-pill { font-size: 0.68rem; padding: 3px 8px; }
            .ip-code     { font-size: 0.65rem; padding: 2px 6px; }

            /* Pagination */
            .paging-wrap {
                padding: 12px 14px; flex-direction: column;
                align-items: stretch; gap: 10px;
            }
            .paging-info    { text-align: center; }
            .per-page-wrap  { justify-content: center; }
            .paging-controls{ justify-content: center; flex-wrap: wrap; }
            .page-btn { min-width: 32px; height: 32px; }
        }

        /* ≤ 420px: IP tersembunyi supaya tidak terlalu sempit */
        @media (max-width: 420px) {
            .data-table tbody td:nth-child(6) { display: none; }
            .data-table tbody td:nth-child(4) { grid-column: 1 / -1; }
        }
    </style>
</head>
<body>

<?php $this->load->view('admin/sidebar'); ?>

<div class="page-wrapper">

    <header class="topnav">
        <div style="display:flex; align-items:center; gap:10px;">
            <button class="btn-hamburger" id="btnHamburger" type="button" aria-label="Buka Menu">
                <i class="fas fa-bars"></i>
            </button>
            <div class="topnav-breadcrumb">
                <a href="<?= base_url('dashboard') ?>" style="color:var(--c-text-muted);text-decoration:none;"><i class="fas fa-home"></i></a>
                <i class="fas fa-chevron-right" style="font-size:8px;"></i>
                <strong>Log Aktivitas</strong>
            </div>
        </div>
        <div class="topnav-actions">
            <button class="btn-refresh" onclick="window.location.reload()">
                <i class="fas fa-rotate-right"></i>
                <span> Refresh</span>
            </button>
        </div>
    </header>

    <main class="page-content">

        <div class="page-header" style="display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:20px;">
            <div>
                <div class="page-title">Log Aktivitas Admin</div>
                <div class="page-subtitle">Rekam jejak seluruh tindakan yang dilakukan oleh admin</div>
            </div>
        </div>

        <div class="surface">

            <!-- Surface header -->
            <div class="surface-header">
                <div class="surface-title">
                    <i class="fas fa-clock-rotate-left"></i>
                    Riwayat Aktivitas
                    <?php if(!empty($logs)): ?>
                        <span style="background:var(--c-primary-light); color:var(--c-primary); padding:2px 8px; border-radius:20px; font-size:0.67rem;">
                            <?= count($logs) ?> entri
                        </span>
                    <?php endif; ?>
                </div>
                <div style="font-size:0.72rem; color:var(--c-text-muted);" id="resultCount"></div>
            </div>

            <!-- Stats row -->
            <?php if(!empty($logs)):
                $cnt_approve = $cnt_reject = $cnt_edit = $cnt_export = $cnt_other = 0;
                $approve_acts = ['APPROVE','SEND_EMAIL','EDIT_TKA'];
                $reject_acts  = ['REJECT','DELETE_USER','DELETE_TKA'];
                $edit_acts    = ['EDIT_USER','EDIT_TEMPLATE','EDIT_FOOTER','RESET_PASSWORD','TOGGLE_STATUS'];
                $export_acts  = ['EXPORT_TKA_CSV','EXPORT_PERUSAHAAN_CSV','CETAK_LAPORAN'];
                foreach($logs as $l) {
                    if(in_array($l->action, $approve_acts))      $cnt_approve++;
                    elseif(in_array($l->action, $reject_acts))   $cnt_reject++;
                    elseif(in_array($l->action, $edit_acts))     $cnt_edit++;
                    elseif(in_array($l->action, $export_acts))   $cnt_export++;
                    else                                          $cnt_other++;
                }
            ?>
            <div class="log-stats">
                <div class="log-stat-item">
                    <div class="lsi-val"><?= count($logs) ?></div>
                    <div class="lsi-lbl">Total</div>
                </div>
                <div class="log-stat-item">
                    <div class="lsi-val" style="color:#065f46;"><?= $cnt_approve ?></div>
                    <div class="lsi-lbl" style="color:#10b981;">Approve</div>
                </div>
                <div class="log-stat-item">
                    <div class="lsi-val" style="color:#9f1239;"><?= $cnt_reject ?></div>
                    <div class="lsi-lbl" style="color:#f43f5e;">Reject</div>
                </div>
                <div class="log-stat-item">
                    <div class="lsi-val" style="color:#1e40af;"><?= $cnt_edit ?></div>
                    <div class="lsi-lbl" style="color:#3b82f6;">Edit</div>
                </div>
                <div class="log-stat-item">
                    <div class="lsi-val" style="color:#5b21b6;"><?= $cnt_export ?></div>
                    <div class="lsi-lbl" style="color:#8b5cf6;">Export</div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Filter bar -->
            <div class="filter-bar">
                <div class="filter-input-wrap">
                    <i class="fas fa-search filter-icon"></i>
                    <input type="text" id="searchInput" class="filter-input"
                           placeholder="Cari admin, aksi, deskripsi…">
                </div>
                <select id="actionFilter" class="filter-select">
                    <option value="">Semua Aksi</option>
                    <option value="USER_REGISTER">USER_REGISTER</option>
                    <option value="EDIT_USER">EDIT_USER</option>
                    <option value="RESET_PASSWORD">RESET_PASSWORD</option>
                    <option value="TOGGLE_STATUS">TOGGLE_STATUS</option>
                    <option value="DELETE_USER">DELETE_USER</option>
                    <option value="SEND_EMAIL">SEND_EMAIL</option>
                    <option value="EXPORT_TKA_CSV">EXPORT_TKA_CSV</option>
                    <option value="EXPORT_PERUSAHAAN_CSV">EXPORT_PERUSAHAAN_CSV</option>
                    <option value="EDIT_TKA">EDIT_TKA</option>
                    <option value="DELETE_TKA">DELETE_TKA</option>
                    <option value="EDIT_TEMPLATE">EDIT_TEMPLATE</option>
                    <option value="EDIT_FOOTER">EDIT_FOOTER</option>
                    <option value="CETAK_LAPORAN">CETAK_LAPORAN</option>
                    <option value="APPROVE">APPROVE</option>
                    <option value="REJECT">REJECT</option>
                </select>
                <input type="date" id="dateFilter" class="filter-date" title="Filter tanggal">
                <button id="resetFilterBtn" class="btn-reset-filter">
                    <i class="fas fa-xmark"></i> Reset Filter
                </button>
            </div>

            <!-- Active filter tags -->
            <div class="filter-active-bar" id="filterActiveBar">
                <span style="font-size:0.68rem; font-weight:600; color:var(--c-primary);">
                    <i class="fas fa-filter" style="font-size:9px;"></i> Filter aktif:
                </span>
                <span id="filterTagSearch" class="filter-tag" style="display:none;">
                    <i class="fas fa-search" style="font-size:8px;"></i>
                    <span id="ftSearchLabel"></span>
                    <button class="filter-tag-remove" onclick="clearFilter('search')"><i class="fas fa-xmark"></i></button>
                </span>
                <span id="filterTagAction" class="filter-tag" style="display:none;">
                    <i class="fas fa-bolt" style="font-size:8px;"></i>
                    <span id="ftActionLabel"></span>
                    <button class="filter-tag-remove" onclick="clearFilter('action')"><i class="fas fa-xmark"></i></button>
                </span>
                <span id="filterTagDate" class="filter-tag" style="display:none;">
                    <i class="fas fa-calendar" style="font-size:8px;"></i>
                    <span id="ftDateLabel"></span>
                    <button class="filter-tag-remove" onclick="clearFilter('date')"><i class="fas fa-xmark"></i></button>
                </span>
            </div>

            <!-- Table -->
            <div style="overflow-x:auto;">
                <table class="data-table" id="logsTable">
                    <thead>
                        <tr>
                            <th style="width:140px;">Waktu</th>
                            <th>Admin</th>
                            <th>Aksi</th>
                            <th>Target</th>
                            <th>Deskripsi</th>
                            <th>IP Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($logs)): ?>
                            <tr class="no-result-row">
                                <td colspan="6">
                                    <div class="no-result-icon"><i class="fas fa-clock-rotate-left"></i></div>
                                    <div style="font-size:0.88rem; font-weight:600; color:var(--c-text); margin-bottom:4px;">Belum ada aktivitas</div>
                                    <div style="font-size:0.78rem;">Log aktivitas admin akan muncul di sini.</div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php
                            $approve_acts = ['APPROVE','SEND_EMAIL','EDIT_TKA'];
                            $reject_acts  = ['REJECT','DELETE_USER','DELETE_TKA'];
                            $edit_acts    = ['EDIT_USER','EDIT_TEMPLATE','EDIT_FOOTER','RESET_PASSWORD','TOGGLE_STATUS'];
                            $export_acts  = ['EXPORT_TKA_CSV','EXPORT_PERUSAHAAN_CSV','CETAK_LAPORAN'];
                            foreach($logs as $log):
                                if(in_array($log->action, $approve_acts))      $abClass = 'ab-approve';
                                elseif(in_array($log->action, $reject_acts))   $abClass = 'ab-reject';
                                elseif(in_array($log->action, $edit_acts))     $abClass = 'ab-edit';
                                elseif(in_array($log->action, $export_acts))   $abClass = 'ab-export';
                                else                                            $abClass = 'ab-default';
                                $initials = strtoupper(substr($log->admin_name, 0, 1));
                                $tgl      = date('d M Y', strtotime($log->created_at));
                                $jam      = date('H:i:s', strtotime($log->created_at));
                            ?>
                            <tr>
                                <!-- Kolom 1: Waktu (disembunyikan di mobile, info waktu masuk ke admin-time) -->
                                <td>
                                    <div class="cell-date-main"><?= $tgl ?></div>
                                    <div class="cell-date-sub"><?= $jam ?></div>
                                </td>
                                <!-- Kolom 2: Admin -->
                                <td>
                                    <div class="admin-wrap">
                                        <div class="admin-avatar"><?= $initials ?></div>
                                        <div>
                                            <div class="admin-name"><?= htmlspecialchars($log->admin_name) ?></div>
                                            <div class="admin-id">ID #<?= $log->admin_id ?></div>
                                            <!-- Waktu tampil di mobile sebagai sub-teks -->
                                            <span class="admin-time"><?= $tgl ?> · <?= date('H:i', strtotime($log->created_at)) ?></span>
                                        </div>
                                    </div>
                                </td>
                                <!-- Kolom 3: Aksi -->
                                <td>
                                    <span class="action-badge <?= $abClass ?>"><?= htmlspecialchars($log->action) ?></span>
                                </td>
                                <!-- Kolom 4: Target -->
                                <td>
                                    <span class="target-pill">
                                        <i class="fas fa-hashtag"></i>
                                        <?= htmlspecialchars($log->target_type) ?> <?= htmlspecialchars($log->target_id) ?>
                                    </span>
                                </td>
                                <!-- Kolom 5: Deskripsi -->
                                <td style="max-width:280px;">
                                    <div style="font-size:0.79rem; color:var(--c-text-mid); line-height:1.5;">
                                        <?= htmlspecialchars($log->description) ?>
                                    </div>
                                </td>
                                <!-- Kolom 6: IP -->
                                <td>
                                    <span class="ip-code"><?= htmlspecialchars($log->ip_address) ?></span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- No result (JS) -->
            <div id="jsNoResult" style="display:none; padding:48px 20px; text-align:center; color:var(--c-text-muted);">
                <div class="no-result-icon" style="margin:0 auto 12px;"><i class="fas fa-magnifying-glass"></i></div>
                <div style="font-size:0.88rem; font-weight:600; color:var(--c-text); margin-bottom:4px;">Tidak ada hasil</div>
                <div style="font-size:0.78rem;">Coba ubah kata kunci atau filter yang digunakan.</div>
            </div>

            <!-- Pagination -->
            <div class="paging-wrap" id="pagingWrap">
                <div class="paging-info" id="pagingInfo">—</div>
                <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
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

        </div>
    </main>

    <?php $this->load->view('footer'); ?>
</div>

<script>
/* ── Hamburger ── */
(function () {
    function initHamburger() {
        var btn = document.getElementById('btnHamburger');
        if (!btn) return;
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            if (typeof window.openAdminSidebar === 'function') {
                window.openAdminSidebar();
            } else {
                /* Fallback langsung */
                var sb = document.getElementById('adminSidebar');
                var ov = document.getElementById('adminOverlay');
                if (sb) sb.classList.add('mobile-open');
                if (ov) ov.classList.add('show');
                document.body.classList.add('body-no-scroll');
            }
        });
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initHamburger);
    } else {
        initHamburger();
    }
})();

/* ── admin-time: tampil hanya di mobile ── */
(function () {
    function syncAdminTime() {
        var isMobile = window.innerWidth <= 768;
        document.querySelectorAll('.admin-time').forEach(function (el) {
            el.style.display = isMobile ? 'block' : 'none';
        });
    }
    syncAdminTime();
    window.addEventListener('resize', syncAdminTime);
})();

/* ── Filter + Pagination ── */
(function () {
    var searchInput    = document.getElementById('searchInput');
    var actionFilter   = document.getElementById('actionFilter');
    var dateFilter     = document.getElementById('dateFilter');
    var resetBtn       = document.getElementById('resetFilterBtn');
    var allRows        = Array.from(document.querySelectorAll('#logsTable tbody tr:not(.no-result-row)'));
    var noResult       = document.getElementById('jsNoResult');
    var resultCount    = document.getElementById('resultCount');
    var filterBar      = document.getElementById('filterActiveBar');
    var pagingInfo     = document.getElementById('pagingInfo');
    var pagingControls = document.getElementById('pagingControls');
    var perPageSelect  = document.getElementById('perPageSelect');

    var currentPage  = 1;
    var perPage      = 10;
    var filteredRows = [];

    function getFilteredRows() {
        var search = searchInput.value.toLowerCase().trim();
        var action = actionFilter.value;
        var date   = dateFilter.value;
        return allRows.filter(function (row) {
            var cells = row.cells;
            if (!cells || cells.length < 6) return false;
            var rawDate = cells[0].innerText.trim();
            var admin   = cells[1].innerText.toLowerCase();
            var aksi    = cells[2].innerText.trim();
            var desc    = cells[4].innerText.toLowerCase();
            var ok = true;
            if (search) ok = ok && (admin.includes(search) || aksi.toLowerCase().includes(search) || desc.includes(search));
            if (action) ok = ok && (aksi === action);
            if (date) {
                var parts  = rawDate.split('\n')[0].split(' ');
                var months = {Jan:'01',Feb:'02',Mar:'03',Apr:'04',Mei:'05',Jun:'06',Jul:'07',Agu:'08',Sep:'09',Okt:'10',Nov:'11',Des:'12'};
                var mm     = months[parts[1]] || '00';
                var dd     = parts[0].padStart(2, '0');
                var logDate = parts[2] + '-' + mm + '-' + dd;
                ok = ok && (logDate === date);
            }
            return ok;
        });
    }

    function renderPaging(total, page, ppg) {
        var tp = Math.ceil(total / ppg) || 1;
        var s  = (page - 1) * ppg + 1, e = Math.min(page * ppg, total);
        pagingInfo.innerHTML = total > 0
            ? 'Menampilkan <strong>' + s + '–' + e + '</strong> dari <strong>' + total + '</strong> entri'
            : '0 entri ditemukan';
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
    function goToPage(p) { var tp = Math.ceil(filteredRows.length / perPage) || 1; currentPage = Math.max(1, Math.min(p, tp)); applyPaging(); }

    function applyAll() {
        filteredRows = getFilteredRows(); currentPage = 1; applyPaging(); updateFilterTags();
    }
    function applyPaging() {
        var total = filteredRows.length, start = (currentPage - 1) * perPage, end = start + perPage;
        allRows.forEach(function (r) { r.style.display = 'none'; });
        filteredRows.forEach(function (r, i) { r.style.display = (i >= start && i < end) ? '' : 'none'; });
        noResult.style.display = (total === 0 && allRows.length > 0) ? 'block' : 'none';
        resultCount.textContent = total + ' dari ' + allRows.length + ' entri';
        renderPaging(total, currentPage, perPage);
    }

    function updateFilterTags() {
        var search = searchInput.value.toLowerCase().trim();
        var action = actionFilter.value;
        var date   = dateFilter.value;
        var hs = search !== '', ha = action !== '', hd = date !== '';
        document.getElementById('filterTagSearch').style.display = hs ? '' : 'none';
        document.getElementById('filterTagAction').style.display = ha ? '' : 'none';
        document.getElementById('filterTagDate').style.display   = hd ? '' : 'none';
        if (hs) document.getElementById('ftSearchLabel').textContent = '"' + search + '"';
        if (ha) document.getElementById('ftActionLabel').textContent = action;
        if (hd) document.getElementById('ftDateLabel').textContent   = date;
        filterBar.classList.toggle('visible', hs || ha || hd);
    }

    window.clearFilter = function (type) {
        if (type === 'search') searchInput.value  = '';
        if (type === 'action') actionFilter.value = '';
        if (type === 'date')   dateFilter.value   = '';
        applyAll();
    };

    searchInput.addEventListener('input',   applyAll);
    actionFilter.addEventListener('change', applyAll);
    dateFilter.addEventListener('change',   applyAll);
    resetBtn.addEventListener('click', function () {
        searchInput.value = ''; actionFilter.value = ''; dateFilter.value = ''; applyAll();
    });
    perPageSelect.addEventListener('change', function () { perPage = parseInt(this.value); currentPage = 1; applyPaging(); });

    applyAll();
})();
</script>
</body>
</html>