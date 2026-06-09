<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Aktivitas — SITLAKEB TKA Approval</title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/shared.css') ?>">
    <style>
        html, body { height: 100%; }
        .page-wrapper { min-height: 100vh; display: flex; flex-direction: column; }
        .page-content { flex: 1 0 auto; }
        footer, .site-footer { flex-shrink: 0; }

        .filter-bar {
            display: flex; flex-wrap: wrap; gap: 8px; align-items: center;
            padding: 14px 20px; background: var(--c-surface-2);
            border-bottom: 1px solid var(--c-border);
        }
        .filter-input-wrap { position: relative; flex: 1; min-width: 180px; }
        .filter-icon { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); color: var(--c-text-muted); font-size: 11px; pointer-events: none; }
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
            outline: none; appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 9px center;
            transition: border-color 0.15s, box-shadow 0.15s; cursor: pointer;
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
            color: var(--c-text-mid); cursor: pointer;
            transition: background 0.12s, color 0.12s; white-space: nowrap;
        }
        .btn-reset-filter:hover { background: var(--c-surface-2); color: var(--c-text); }
        .filter-active-bar {
            display: none; flex-wrap: wrap; gap: 6px; align-items: center;
            padding: 8px 20px; border-bottom: 1px solid var(--c-border);
            background: var(--c-primary-light); font-size: 0.72rem; color: var(--c-primary);
        }
        .filter-active-bar.visible { display: flex; }
        .filter-tag {
            display: inline-flex; align-items: center; gap: 5px;
            background: white; border: 1px solid #b2d9ce; padding: 2px 8px;
            border-radius: 20px; font-size: 0.68rem; font-weight: 600; color: var(--c-primary);
        }
        .filter-tag-remove { background: none; border: none; padding: 0; cursor: pointer; color: var(--c-primary); font-size: 9px; }
        .log-stats {
            display: flex; flex-wrap: wrap; gap: 0;
            border-bottom: 1px solid var(--c-border);
        }
        .log-stat-item {
            flex: 1; min-width: 100px; padding: 12px 16px; text-align: center;
            border-right: 1px solid var(--c-border);
        }
        .log-stat-item:last-child { border-right: none; }
        .lsi-val { font-family: var(--font-head); font-size: 1.3rem; font-weight: 800; color: var(--c-text); line-height: 1; margin-bottom: 3px; }
        .lsi-lbl { font-size: 0.65rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; color: var(--c-text-muted); }
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
        .ab-default { background: #f1f5f9; color: #475569; }
        .ab-default::before { background: #94a3b8; }
        .target-pill {
            display: inline-flex; align-items: center; gap: 5px;
            font-size: 0.72rem; color: var(--c-text-mid);
            background: var(--c-surface-2); border: 1px solid var(--c-border);
            padding: 2px 8px; border-radius: var(--r-sm);
        }
        .target-pill i { font-size: 9px; color: var(--c-text-muted); }
        .ip-code {
            font-family: 'Courier New', monospace; font-size: 0.72rem;
            color: var(--c-text-muted); background: var(--c-surface-2);
            border: 1px solid var(--c-border); padding: 2px 7px; border-radius: var(--r-sm);
        }
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
        .admin-time {
            display: none; /* hanya muncul di mobile */
            font-size: 0.65rem; color: var(--c-text-muted); margin-top: 1px;
        }
        .no-result-row td { text-align: center; padding: 48px 20px !important; color: var(--c-text-muted); }
        .no-result-icon {
            width: 48px; height: 48px; border-radius: var(--r-xl);
            background: var(--c-primary-light); color: var(--c-primary);
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; margin: 0 auto 12px;
        }

        /* ── Pagination dashboard style ── */
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
            border: 1px solid var(--c-border-strong);
            border-radius: var(--r-sm);
            background: var(--c-surface);
            font-family: var(--font-body);
            font-size: 0.75rem; font-weight: 500;
            color: var(--c-text-mid);
            cursor: pointer;
            transition: background 0.12s, border-color 0.12s, color 0.12s;
            user-select: none;
        }
        .page-btn:hover:not(:disabled):not(.active) {
            background: var(--c-primary-light);
            border-color: var(--c-primary);
            color: var(--c-primary);
        }
        .page-btn.active {
            background: var(--c-primary); border-color: var(--c-primary);
            color: white; font-weight: 700;
        }
        .page-btn:disabled { opacity: 0.35; cursor: not-allowed; }
        .per-page-wrap { display: flex; align-items: center; gap: 6px; font-size: 0.72rem; color: var(--c-text-muted); }
        .per-page-select {
            padding: 3px 22px 3px 8px;
            border: 1px solid var(--c-border-strong);
            border-radius: var(--r-sm);
            background: var(--c-surface);
            font-size: 0.72rem; color: var(--c-text);
            outline: none; appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 7px center; cursor: pointer;
        }
        .btn-refresh {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 7px 14px; border: 1px solid var(--c-border-strong);
            border-radius: var(--r-md); background: var(--c-surface);
            font-family: var(--font-body); font-size: 0.78rem; font-weight: 500;
            color: var(--c-text-mid); cursor: pointer; transition: background 0.12s; text-decoration: none;
        }
        .btn-refresh i { font-size: 11px; }
        .btn-refresh:hover { background: var(--c-surface-2); color: var(--c-text); }

        /* ── Mobile menu & overlay ── */
        .mobile-menu-toggle {
            display: none;
            width: 36px; height: 36px;
            border-radius: 9px;
            border: 1px solid #e9ecef;
            background: #fff;
            align-items: center; justify-content: center;
            color: #64748b; font-size: 15px;
            cursor: pointer; flex-shrink: 0;
            transition: background .15s, color .15s;
        }
        .mobile-menu-toggle:hover { background: rgba(30,111,92,0.08); color: #1e6f5c; }
        .sidebar-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
            backdrop-filter: blur(2px);
            -webkit-backdrop-filter: blur(2px);
        }
        .sidebar-overlay.show { display: block; }
        .body-no-scroll { overflow: hidden !important; }

        /* ══════════════════════════════════════════
           MOBILE  ≤ 768px
        ══════════════════════════════════════════ */
        @media (max-width: 768px) {
            .mobile-menu-toggle { display: flex; }

            /* Filter stack */
            .filter-bar { flex-direction: column; align-items: stretch; padding: 12px 14px; gap: 8px; }
            .filter-input-wrap { min-width: 100%; }
            .filter-input, .filter-select, .filter-date { font-size: 0.82rem; padding: 9px 12px 9px 32px; }
            .filter-select, .filter-date { width: 100%; }
            .btn-reset-filter { width: 100%; justify-content: center; }

            /* Log stats hidden */
            .log-stats { display: none; }

            /* Page */
            .page-content { padding: 14px; }
            .page-title { font-size: 1.05rem; }
            .page-subtitle { font-size: 0.76rem; }
            .surface-header { padding: 12px 14px; flex-wrap: wrap; gap: 8px; }
            .surface-title { font-size: 0.8rem; }

            /* ── Table → Card Grid ── */
            .table-wrap { overflow-x: visible !important; }
            .data-table thead { display: none; }
            .data-table tbody { display: flex; flex-direction: column; }

            .data-table tr {
                display: grid;
                grid-template-columns: 1fr auto;
                grid-template-rows: auto auto auto;
                column-gap: 10px;
                row-gap: 0;
                padding: 14px;
                border-bottom: 1px solid #f0f3f6;
                transition: background .12s;
            }
            .data-table tr:last-child { border-bottom: none; }
            .data-table tr:hover { background: #fafcfc; }
            .data-table td { display: block; padding: 0; border: none; }

            /* Row 1 Col 1: Petugas + Waktu di bawah */
            .data-table td[data-label="Petugas"] {
                grid-column: 1; grid-row: 1;
                align-self: center;
            }
            /* Tampilkan waktu di bawah admin-id */
            .admin-time { display: block; }

            /* Row 1 Col 2: Badge Aksi */
            .data-table td[data-label="Aksi"] {
                grid-column: 2; grid-row: 1;
                align-self: center; justify-self: end;
            }

            /* Row 2: Deskripsi full width */
            .data-table td[data-label="Deskripsi"] {
                grid-column: 1 / -1; grid-row: 2;
                font-size: 0.78rem; color: var(--c-text-mid); line-height: 1.55;
                padding: 7px 0 8px;
                border-bottom: 1px dashed #edf0f4;
                margin-bottom: 8px;
            }

            /* Row 3 Col 1: Target */
            .data-table td[data-label="Target"] {
                grid-column: 1; grid-row: 3;
                align-self: center;
            }

            /* Row 3 Col 2: IP Address */
            .data-table td[data-label="IP Address"] {
                grid-column: 2; grid-row: 3;
                justify-self: end; align-self: center;
            }

            /* Sembunyikan kolom Waktu asli (sudah dimasukkan ke .admin-time) */
            .data-table td[data-label="Waktu"] { display: none; }

            /* Ukuran mobile untuk pills & badge */
            .target-pill { font-size: 0.68rem; padding: 3px 8px; }
            .ip-code { font-size: 0.65rem; padding: 2px 6px; }
            .action-badge { font-size: 0.68rem; padding: 4px 10px; }
            .admin-name { font-size: 0.83rem; }
            .admin-id   { font-size: 0.65rem; }

            /* Pagination mobile */
            .paging-wrap { padding: 12px 14px; flex-direction: column; align-items: flex-start; }
            .page-btn { min-width: 28px; height: 28px; font-size: 0.7rem; }
        }

        @media (max-width: 420px) {
            .data-table tr { padding: 12px; }
            /* IP sembunyi di layar sempit */
            .data-table td[data-label="IP Address"] { display: none; }
            .data-table td[data-label="Target"] { grid-column: 1 / -1; }
        }
    </style>
</head>
<body>

<?php $this->load->view('approval/sidebar'); ?>

<div class="page-wrapper">
    <header class="topnav">
        <div class="topnav-breadcrumb">
            <a href="<?= base_url('approval/dashboard') ?>" style="color:var(--c-text-muted); text-decoration:none;"><i class="fas fa-home"></i></a>
            <i class="fas fa-chevron-right" style="font-size:8px;"></i>
            <strong>Log Aktivitas</strong>
        </div>
        <div class="topnav-actions">
            <button class="btn-refresh" onclick="window.location.reload()">
                <i class="fas fa-rotate-right"></i> Refresh
            </button>
        </div>
    </header>

    <main class="page-content">
        <div class="page-header" style="display:flex; align-items:flex-start; justify-content:space-between; flex-wrap:wrap; gap:12px;">
            <div>
                <div class="page-title">Log Aktivitas Approval</div>
                <div class="page-subtitle">Rekam jejak persetujuan & penolakan pengajuan TKA</div>
            </div>
        </div>

        <div class="surface">
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

            <?php if(!empty($logs)):
                $total_approve = 0;
                $total_reject  = 0;
                foreach($logs as $l) {
                    if($l->action === 'APPROVE') $total_approve++;
                    elseif($l->action === 'REJECT') $total_reject++;
                }
            ?>
            <div class="log-stats">
                <div class="log-stat-item">
                    <div class="lsi-val"><?= count($logs) ?></div>
                    <div class="lsi-lbl">Total</div>
                </div>
                <div class="log-stat-item">
                    <div class="lsi-val" style="color:#065f46;"><?= $total_approve ?></div>
                    <div class="lsi-lbl" style="color:#10b981;">Disetujui</div>
                </div>
                <div class="log-stat-item">
                    <div class="lsi-val" style="color:#9f1239;"><?= $total_reject ?></div>
                    <div class="lsi-lbl" style="color:#f43f5e;">Ditolak</div>
                </div>
            </div>
            <?php endif; ?>

            <div class="filter-bar">
                <div class="filter-input-wrap">
                    <i class="fas fa-search filter-icon"></i>
                    <input type="text" id="searchInput" class="filter-input" placeholder="Cari petugas, aksi, deskripsi…">
                </div>
                <select id="actionFilter" class="filter-select">
                    <option value="">Semua Aksi</option>
                    <option value="APPROVE">APPROVE</option>
                    <option value="REJECT">REJECT</option>
                </select>
                <input type="date" id="dateFilter" class="filter-date" title="Filter tanggal">
                <button id="resetFilterBtn" class="btn-reset-filter">
                    <i class="fas fa-xmark"></i> Reset
                </button>
            </div>

            <div class="filter-active-bar" id="filterActiveBar">
                <span style="font-size:0.68rem; font-weight:600; color:var(--c-primary); margin-right:2px;">
                    <i class="fas fa-filter" style="font-size:9px;"></i> Filter aktif:
                </span>
                <span id="filterTagSearch"  class="filter-tag" style="display:none;">
                    <i class="fas fa-search" style="font-size:8px;"></i>
                    <span id="ftSearchLabel"></span>
                    <button class="filter-tag-remove" onclick="clearFilter('search')"><i class="fas fa-xmark"></i></button>
                </span>
                <span id="filterTagAction"  class="filter-tag" style="display:none;">
                    <i class="fas fa-bolt" style="font-size:8px;"></i>
                    <span id="ftActionLabel"></span>
                    <button class="filter-tag-remove" onclick="clearFilter('action')"><i class="fas fa-xmark"></i></button>
                </span>
                <span id="filterTagDate"    class="filter-tag" style="display:none;">
                    <i class="fas fa-calendar" style="font-size:8px;"></i>
                    <span id="ftDateLabel"></span>
                    <button class="filter-tag-remove" onclick="clearFilter('date')"><i class="fas fa-xmark"></i></button>
                </span>
            </div>

            <!-- ═══════════ RESPONSIVE TABLE ═══════════ -->
            <div class="table-wrap">
                <table class="data-table" id="logsTable">
                    <thead>
                        <tr>
                            <th style="width:140px;">Waktu</th>
                            <th>Petugas</th>
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
                                    <div style="font-size:0.78rem;">Log aktivitas approval akan muncul di sini.</div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($logs as $log):
                                $is_approve = ($log->action === 'APPROVE');
                                $abClass = $is_approve ? 'ab-approve' : 'ab-reject';
                                $initials = strtoupper(substr($log->admin_name, 0, 1));
                            ?>
                            <tr>
                                <td data-label="Waktu">
                                    <div class="cell-date-main"><?= date('d M Y', strtotime($log->created_at)) ?></div>
                                    <div class="cell-date-sub"><?= date('H:i:s', strtotime($log->created_at)) ?></div>
                                </td>
                                <td data-label="Petugas">
                                    <div class="admin-wrap">
                                        <div class="admin-avatar"><?= $initials ?></div>
                                        <div>
                                            <div class="admin-name"><?= htmlspecialchars($log->admin_name) ?></div>
                                            <div class="admin-id">ID #<?= $log->admin_id ?></div>
                                            <div class="admin-time"><?= date('d M Y · H:i', strtotime($log->created_at)) ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="Aksi">
                                    <span class="action-badge <?= $abClass ?>"><?= htmlspecialchars($log->action) ?></span>
                                </td>
                                <td data-label="Target">
                                    <span class="target-pill">
                                        <i class="fas fa-hashtag"></i>
                                        <?= htmlspecialchars($log->target_type) ?> <?= htmlspecialchars($log->target_id) ?>
                                    </span>
                                </td>
                                <td data-label="Deskripsi" style="max-width:280px;">
                                    <div style="font-size:0.79rem; color:var(--c-text-mid); line-height:1.5;">
                                        <?= htmlspecialchars($log->description) ?>
                                    </div>
                                </td>
                                <td data-label="IP Address">
                                    <span class="ip-code"><?= htmlspecialchars($log->ip_address) ?></span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div id="jsNoResult" style="display:none; padding:48px 20px; text-align:center; color:var(--c-text-muted);">
                <div class="no-result-icon" style="margin:0 auto 12px;"><i class="fas fa-magnifying-glass"></i></div>
                <div style="font-size:0.88rem; font-weight:600; color:var(--c-text); margin-bottom:4px;">Tidak ada hasil</div>
                <div style="font-size:0.78rem;">Coba ubah kata kunci atau filter yang digunakan.</div>
            </div>

            <!-- Pagination -->
            <div class="paging-wrap" id="logsPagingWrap">
                <div class="paging-info" id="logsPagingInfo">—</div>
                <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
                    <div class="per-page-wrap">
                        <span>Tampilkan</span>
                        <select class="per-page-select" id="logsPerPage">
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <span>per halaman</span>
                    </div>
                    <div class="paging-controls" id="logsPagingControls"></div>
                </div>
            </div>
        </div>
    </main>

    <?php $this->load->view('footer'); ?>
</div>

<!-- jQuery + Sidebar Mobile + Filter/Pagination -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {

    // ── 1. SIDEBAR COLLAPSE (DESKTOP) + MOBILE TOGGLE ──
    var $sidebar = $('#approvalSidebar');
    var $toggleBtn = $('#approvalSidebarToggle');
    var $toggleLabel = $toggleBtn.find('.sb-toggle-label');

    function applyCollapse(isCollapsed) {
        $sidebar.toggleClass('collapsed', isCollapsed);
        $toggleLabel.text(isCollapsed ? 'Buka Sidebar' : 'Tutup Sidebar');
        localStorage.setItem('approvalSidebarCollapsed', isCollapsed ? '1' : '0');
    }

    var savedState = localStorage.getItem('approvalSidebarCollapsed');
    if (savedState === '1' && $(window).width() > 768) {
        applyCollapse(true);
    }

    $toggleBtn.on('click', function(e) {
        e.preventDefault();
        applyCollapse(!$sidebar.hasClass('collapsed'));
    });

    function ensureMobileElements() {
        if ($(window).width() <= 768) {
            if ($('.mobile-menu-toggle').length === 0) {
                $('.topnav').prepend(
                    '<button class="mobile-menu-toggle" aria-label="Buka Menu">' +
                    '<i class="fas fa-bars"></i></button>'
                );
            }
            if ($('.sidebar-overlay').length === 0) {
                $('body').append('<div class="sidebar-overlay"></div>');
            }
        }
    }

    function openSidebar() {
        $sidebar.addClass('mobile-open');
        $('.sidebar-overlay').addClass('show');
        $('body').addClass('body-no-scroll');
    }

    function closeSidebar() {
        $sidebar.removeClass('mobile-open');
        $('.sidebar-overlay').removeClass('show');
        $('body').removeClass('body-no-scroll');
    }

    ensureMobileElements();

    $(document).on('click', '.mobile-menu-toggle', function(e) {
        e.preventDefault();
        openSidebar();
    });

    $(document).on('click', '.sidebar-overlay', function() {
        closeSidebar();
    });

    $(document).on('click', '.sidebar .sb-link', function() {
        if ($(window).width() <= 768) {
            setTimeout(closeSidebar, 150);
        }
    });

    var resizeDebounce;
    $(window).on('resize', function() {
        clearTimeout(resizeDebounce);
        resizeDebounce = setTimeout(function() {
            if ($(window).width() > 768) {
                closeSidebar();
                var saved = localStorage.getItem('approvalSidebarCollapsed');
                if (saved === '1') {
                    $sidebar.addClass('collapsed');
                    $toggleLabel.text('Buka Sidebar');
                } else {
                    $sidebar.removeClass('collapsed');
                    $toggleLabel.text('Tutup Sidebar');
                }
            } else {
                ensureMobileElements();
            }
        }, 200);
    });

    // ── 2. FILTER & PAGINATION ──
    const searchInput  = document.getElementById('searchInput');
    const actionFilter = document.getElementById('actionFilter');
    const dateFilter   = document.getElementById('dateFilter');
    const resetBtn     = document.getElementById('resetFilterBtn');
    const tableBody    = document.querySelector('#logsTable tbody');
    const allRows      = tableBody ? Array.from(tableBody.querySelectorAll('tr:not(.no-result-row)')) : [];
    const noResult     = document.getElementById('jsNoResult');
    const resultCount  = document.getElementById('resultCount');
    const filterBar    = document.getElementById('filterActiveBar');

    const infoEl       = document.getElementById('logsPagingInfo');
    const controlsEl   = document.getElementById('logsPagingControls');
    const perPageSelect = document.getElementById('logsPerPage');

    let perPage = 10;
    let currentPage = 1;
    let filteredRows = [];

    function filterRows() {
        const search = searchInput.value.toLowerCase().trim();
        const action = actionFilter.value;
        const date   = dateFilter.value;

        filteredRows = allRows.filter(row => {
            // Gunakan data-label untuk mencari cell
            const petugasCell = row.querySelector('td[data-label="Petugas"]');
            const aksiCell    = row.querySelector('td[data-label="Aksi"]');
            const descCell    = row.querySelector('td[data-label="Deskripsi"]');
            const waktuCell   = row.querySelector('td[data-label="Waktu"]');
            if (!aksiCell) return false;

            const petugas = petugasCell?.innerText.toLowerCase() || '';
            const aksi    = aksiCell?.innerText.trim() || '';
            const desc    = descCell?.innerText.toLowerCase() || '';

            if (search && !(petugas.includes(search) || aksi.toLowerCase().includes(search) || desc.includes(search))) return false;
            if (action && aksi !== action) return false;
            if (date && waktuCell) {
                const raw = waktuCell.querySelector('.cell-date-main')?.innerText.trim() || '';
                const parts = raw.split(' ');
                const months = {Jan:'01',Feb:'02',Mar:'03',Apr:'04',Mei:'05',Jun:'06',Jul:'07',Agu:'08',Sep:'09',Okt:'10',Nov:'11',Des:'12'};
                const mm = months[parts[1]] || '00';
                const dd = parts[0].padStart(2,'0');
                const logDate = parts[2] + '-' + mm + '-' + dd;
                if (logDate !== date) return false;
            }
            return true;
        });

        document.getElementById('filterTagSearch').style.display = search ? '' : 'none';
        document.getElementById('filterTagAction').style.display = action ? '' : 'none';
        document.getElementById('filterTagDate').style.display   = date   ? '' : 'none';
        if (search) document.getElementById('ftSearchLabel').textContent = '"' + search + '"';
        if (action) document.getElementById('ftActionLabel').textContent = action;
        if (date)   document.getElementById('ftDateLabel').textContent   = date;
        filterBar.classList.toggle('visible', search || action || date);

        resultCount.textContent = filteredRows.length + ' dari ' + allRows.length + ' entri';
        noResult.style.display = (filteredRows.length === 0 && allRows.length > 0) ? 'block' : 'none';

        showPage(1);
    }

    function showPage(page) {
        const total = filteredRows.length;
        const totalPages = Math.ceil(total / perPage) || 1;
        if (page < 1) page = 1;
        if (page > totalPages) page = totalPages;
        currentPage = page;

        allRows.forEach(row => row.style.display = 'none');
        const start = (currentPage - 1) * perPage;
        const end = Math.min(currentPage * perPage, total);
        for (let i = start; i < end; i++) {
            filteredRows[i].style.display = '';
        }

        infoEl.innerHTML = total > 0
            ? 'Menampilkan <strong>' + (start+1) + '–' + end + '</strong> dari <strong>' + total + '</strong> entri'
            : '0 entri';

        renderControls(totalPages);
    }

    function renderControls(totalPages) {
        controlsEl.innerHTML = '';
        if (totalPages <= 1) return;

        const prevBtn = document.createElement('button');
        prevBtn.className = 'page-btn';
        prevBtn.innerHTML = '<i class="fas fa-chevron-left" style="font-size:10px;"></i>';
        prevBtn.disabled = currentPage === 1;
        prevBtn.addEventListener('click', () => showPage(currentPage - 1));
        controlsEl.appendChild(prevBtn);

        let startP = Math.max(1, currentPage - 2);
        let endP = Math.min(totalPages, startP + 4);
        startP = Math.max(1, endP - 4);

        if (startP > 1) {
            controlsEl.appendChild(makePageBtn(1));
            if (startP > 2) controlsEl.appendChild(makeDots());
        }
        for (let i = startP; i <= endP; i++) controlsEl.appendChild(makePageBtn(i));
        if (endP < totalPages) {
            if (endP < totalPages - 1) controlsEl.appendChild(makeDots());
            controlsEl.appendChild(makePageBtn(totalPages));
        }

        const nextBtn = document.createElement('button');
        nextBtn.className = 'page-btn';
        nextBtn.innerHTML = '<i class="fas fa-chevron-right" style="font-size:10px;"></i>';
        nextBtn.disabled = currentPage === totalPages;
        nextBtn.addEventListener('click', () => showPage(currentPage + 1));
        controlsEl.appendChild(nextBtn);
    }

    function makePageBtn(num) {
        const btn = document.createElement('button');
        btn.className = 'page-btn' + (num === currentPage ? ' active' : '');
        btn.textContent = num;
        btn.addEventListener('click', () => showPage(num));
        return btn;
    }

    function makeDots() {
        const span = document.createElement('span');
        span.className = 'page-btn';
        span.style.cursor = 'default';
        span.textContent = '…';
        return span;
    }

    window.clearFilter = function(type) {
        if (type === 'search') searchInput.value = '';
        if (type === 'action') actionFilter.value = '';
        if (type === 'date')   dateFilter.value = '';
        filterRows();
    };

    searchInput.addEventListener('input', filterRows);
    actionFilter.addEventListener('change', filterRows);
    dateFilter.addEventListener('change', filterRows);
    resetBtn.addEventListener('click', () => {
        searchInput.value = '';
        actionFilter.value = '';
        dateFilter.value = '';
        filterRows();
    });
    perPageSelect.addEventListener('change', function() {
        perPage = parseInt(this.value);
        filterRows();
    });

    if (allRows.length > 0) {
        filterRows();
    }

});
</script>
</body>
</html>