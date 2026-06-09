<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seluruh Pengajuan TKA — SITLAKEB TKA Admin</title>
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
        .toolbar-left  { display: flex; align-items: center; gap: 10px; flex: 1; flex-wrap: wrap; }
        .toolbar-right { display: flex; align-items: center; gap: 8px; flex-shrink: 0; }

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
            color: var(--c-text-muted); font-size: 9px;
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

        /* ── Filter pills ── */
        .filter-pills { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }
        .fpill {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 4px 10px; border-radius: 20px;
            font-family: var(--font-head); font-size: 0.68rem; font-weight: 700;
            border: 1px solid transparent; cursor: pointer;
            transition: all 0.15s; user-select: none;
        }
        .fpill-all     { background: var(--c-primary-light); color: var(--c-primary); border-color: #a7d9cf; }
        .fpill-proses  { background: #e0f2fe; color: #0369a1; border-color: #bae6fd; }
        .fpill-selesai { background: #dcfce7; color: #15803d; border-color: #a7f3d0; }
        .fpill-ditolak { background: #fee2e2; color: #b91c1c; border-color: #fca5a5; }
        .fpill-draft   { background: #f1f5f9; color: #475569; border-color: #cbd5e1; }
        .fpill.active  { box-shadow: 0 0 0 2px currentColor; }
        .fpill:not(.active) { opacity: 0.55; }
        .fpill:hover   { opacity: 1; }

        /* ── Export button ── */
        .btn-export {
            display: inline-flex; align-items: center; gap: 6px;
            background: #ecfdf5; color: #065f46;
            border: 1px solid #a7f3d0; border-radius: var(--r-sm);
            padding: 7px 14px; font-family: var(--font-head);
            font-size: 0.75rem; font-weight: 700;
            text-decoration: none; white-space: nowrap;
            transition: background 0.15s, border-color 0.15s;
        }
        .btn-export:hover { background: #d1fae5; border-color: #6ee7b7; color: #064e3b; }
        .btn-export i { font-size: 11px; }

        /* ── Counter ── */
        .tbl-counter { font-size: 0.75rem; color: var(--c-text-muted); white-space: nowrap; }
        .tbl-counter strong { color: var(--c-text); }

        /* ── Table ── */
        .data-table { width: 100%; border-collapse: collapse; }
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
        .co-cell { display: flex; align-items: center; gap: 9px; }
        .co-avatar {
            width: 30px; height: 30px; border-radius: var(--r-sm);
            background: var(--c-primary-light); color: var(--c-primary);
            font-family: var(--font-head); font-size: 0.68rem; font-weight: 800;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; text-transform: uppercase;
        }
        .co-name { font-weight: 600; font-size: 0.83rem; color: var(--c-text); }
        .tka-name { font-size: 0.83rem; color: var(--c-text); font-weight: 500; }

        /* ── Badge status ── */
        .badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 3px 10px; border-radius: 20px;
            font-size: 0.68rem; font-weight: 700; font-family: var(--font-head);
        }
        .badge-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
        .badge-draft   { background: #f1f5f9; color: #475569; }
        .badge-proses  { background: #e0f2fe; color: #0369a1; }
        .badge-selesai { background: #dcfce7; color: #15803d; }
        .badge-ditolak { background: #fee2e2; color: #b91c1c; }

        /* ── Action buttons ── */
        .act-btn {
            display: inline-flex; align-items: center; justify-content: center;
            width: 28px; height: 28px; border-radius: 6px; border: 1px solid;
            font-size: 11px; text-decoration: none;
            transition: background 0.15s, border-color 0.15s, transform 0.1s;
            flex-shrink: 0; cursor: pointer;
        }
        .act-btn-text {
            display: inline-flex; align-items: center; gap: 4px;
            height: 28px; padding: 0 10px; border-radius: 6px; border: 1px solid;
            font-family: var(--font-head); font-size: 0.7rem; font-weight: 700;
            text-decoration: none; white-space: nowrap;
            transition: background 0.15s, border-color 0.15s, transform 0.1s;
        }
        .act-btn:hover, .act-btn-text:hover { transform: translateY(-1px); text-decoration: none; }
        .ab-detail   { background: #f1f5f9; color: #334155; border-color: #e2e8f0; }
        .ab-detail:hover   { background: var(--c-primary-light); border-color: #a7d9cf; color: var(--c-primary); }
        .ab-edit     { background: #fffbeb; color: #92400e; border-color: #fde68a; }
        .ab-edit:hover     { background: #fef3c7; border-color: #fcd34d; color: #92400e; }
        .ab-delete   { background: #fff1f2; color: #9f1239; border-color: #fecdd3; }
        .ab-delete:hover   { background: #ffe4e6; border-color: #fda4af; color: #9f1239; }
        .ab-download { background: #ecfdf5; color: #065f46; border-color: #a7f3d0; }
        .ab-download:hover { background: #d1fae5; border-color: #6ee7b7; color: #065f46; }
        .ab-nomor    { background: #eff6ff; color: #1e40af; border-color: #bfdbfe; }
        .ab-nomor:hover    { background: #dbeafe; border-color: #93c5fd; color: #1e40af; }

        /* ── Date cell ── */
        .cell-date-main { font-size: 0.81rem; color: var(--c-text); }
        .cell-date-sub  { font-size: 0.7rem; color: var(--c-text-muted); margin-top: 1px; }

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

        /* mobile-meta — default sembunyi */
        .mobile-meta { display: none; }

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

            /* Page */
            .page-content { padding: 14px; }
            .page-heading-wrap { margin-bottom: 14px !important; gap: 8px !important; }

            /* ── Toolbar baris 1: search + counter + export ── */
            .tbl-toolbar {
                flex-direction: column; align-items: stretch;
                padding: 12px 14px; gap: 8px;
            }
            .toolbar-left  { flex-direction: column; align-items: stretch; gap: 8px; }
            .toolbar-right { width: 100%; }
            .search-wrap   { max-width: 100%; }
            .search-input  { font-size: 0.84rem; padding: 9px 32px; }
            .tbl-counter   { font-size: 0.72rem; text-align: right; }
            .btn-export    { width: 100%; justify-content: center; padding: 9px 14px; font-size: 0.8rem; }

            /* ── Toolbar baris 2: filter pills — scroll horizontal ── */
            .filter-bar-wrap {
                padding: 10px 14px;
                border-bottom: 1px solid var(--c-border);
                overflow-x: auto; -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
            }
            .filter-bar-wrap::-webkit-scrollbar { display: none; }
            .filter-pills { flex-wrap: nowrap; gap: 7px; }
            .fpill { white-space: nowrap; font-size: 0.7rem; padding: 5px 11px; }

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
            .data-table tbody tr:hover { background: #fafcfc; }

            .data-table tbody td { display: block; padding: 0; border: none; }

            /* Nomor — sembunyikan */
            .data-table tbody td.col-no { display: none; }

            /* ── Zona 1: Perusahaan + TKA + status (header card) ── */
            .data-table tbody td[data-label="Perusahaan"] { margin-bottom: 8px; }

            /* mobile-meta: nama TKA + badge status langsung di bawah perusahaan */
            .mobile-meta {
                display: flex; align-items: center; flex-wrap: wrap;
                gap: 7px; margin-bottom: 8px;
            }
            .mobile-meta .tka-name { font-size: 0.8rem; flex: 1; min-width: 0; }

            /* Sembunyikan kolom TKA & Status (sudah di mobile-meta) */
            .data-table tbody td[data-label="TKA"],
            .data-table tbody td[data-label="Status"] { display: none; }

            /* ── Zona 2: Tanggal — inline tipis ── */
            .data-table tbody td[data-label="Tanggal"] {
                display: flex; align-items: center; gap: 7px;
                font-size: 0.75rem; color: var(--c-text-muted);
                margin-bottom: 10px; padding: 0;
            }
            .data-table tbody td[data-label="Tanggal"]::before {
                content: '\f017'; /* fa-clock */
                font-family: 'Font Awesome 6 Free'; font-weight: 400;
                font-size: 10px; color: var(--c-text-muted); flex-shrink: 0;
            }
            .cell-date-main { font-size: 0.75rem; display: inline; }
            .cell-date-sub  { font-size: 0.72rem; display: inline; margin-top: 0; margin-left: 3px; }

            /* ── Zona 3: Aksi — full-width strip ── */
            .data-table tbody td[data-label="Aksi"] { padding: 0; }
            .act-strip-mobile {
                display: flex; gap: 7px;
                padding-top: 10px;
                border-top: 1px dashed #edf0f4;
            }
            .act-strip-mobile .act-btn,
            .act-strip-mobile .act-btn-text {
                flex: 1; width: auto; height: 34px;
                border-radius: 7px; font-size: 11px;
                justify-content: center; gap: 5px;
                padding: 0 8px;
            }
            .act-strip-mobile .abl {
                font-size: 0.67rem; font-weight: 700;
                font-family: var(--font-head); white-space: nowrap;
            }
            /* Desktop strip — sembunyikan di mobile */
            .act-strip-desktop { display: none; }

            /* ── Pagination ── */
            .paging-wrap {
                padding: 12px 14px;
                flex-direction: column; align-items: stretch; gap: 10px;
            }
            .paging-info    { text-align: center; }
            .per-page-wrap  { justify-content: center; }
            .paging-controls{ justify-content: center; flex-wrap: wrap; }
            .page-btn { min-width: 32px; height: 32px; }
        }

        /* ≤ 420px: label teks tombol sembunyi, cukup ikon */
        @media (max-width: 420px) {
            .act-strip-mobile .abl { display: none; }
            .act-strip-mobile .act-btn,
            .act-strip-mobile .act-btn-text { font-size: 13px; padding: 0; }
        }
    </style>
</head>
<body>

<?php $this->load->view('admin/sidebar'); ?>

<div class="page-wrapper">

    <header class="topnav">
        <div style="display:flex; align-items:center; gap:10px;">
            <button class="btn-hamburger" id="btnHamburger" aria-label="Buka Menu">
                <i class="fas fa-bars"></i>
            </button>
            <div class="topnav-breadcrumb">
                <a href="<?= base_url('dashboard') ?>" style="color:var(--c-text-muted);text-decoration:none;"><i class="fas fa-home"></i></a>
                <i class="fas fa-chevron-right" style="font-size:8px;"></i>
                <strong>Seluruh Pengajuan TKA</strong>
            </div>
        </div>
    </header>

    <main class="page-content">

        <?php
        $total   = count($all_tka);
        $cProses = $cSelesai = $cDitolak = $cDraft = 0;
        $prosesStatuses = ['MENUNGGU_KASI','MENUNGGU_KABID','MENUNGGU_SEKDIS','MENUNGGU_KADIS'];
        foreach($all_tka as $t) {
            if(in_array($t->status, $prosesStatuses))  $cProses++;
            elseif($t->status == 'SELESAI')             $cSelesai++;
            elseif($t->status == 'DITOLAK')             $cDitolak++;
            elseif($t->status == 'DRAFT')               $cDraft++;
        }
        ?>

        <!-- Page heading -->
        <div class="page-heading-wrap" style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
            <div>
                <div style="font-family:var(--font-head);font-size:1.1rem;font-weight:800;color:var(--c-text);margin-bottom:3px;">
                    <i class="fas fa-file-alt" style="color:var(--c-primary);margin-right:8px;"></i>
                    Seluruh Pengajuan TKA
                </div>
                <div style="font-size:0.78rem;color:var(--c-text-muted);">
                    Total <strong><?= $total ?></strong> pengajuan terdaftar
                </div>
            </div>
        </div>

        <div class="surface">

            <!-- Toolbar: search + counter + export -->
            <div class="tbl-toolbar">
                <div class="toolbar-left">
                    <div class="search-wrap" id="searchWrap">
                        <i class="fas fa-search s-icon"></i>
                        <input type="text" class="search-input" id="searchInput"
                               placeholder="Cari perusahaan atau nama TKA..." autocomplete="off">
                        <button class="s-clear" id="searchClear" title="Hapus pencarian">
                            <i class="fas fa-xmark"></i>
                        </button>
                    </div>
                    <div class="tbl-counter">
                        <strong id="visibleCount"><?= $total ?></strong> dari <?= $total ?> ditampilkan
                    </div>
                </div>
                <div class="toolbar-right">
                    <a href="<?= base_url('admin/export_tka_xlsx') ?>" class="btn-export">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </a>
                </div>
            </div>

            <!-- Filter pills baris -->
            <div class="filter-bar-wrap" style="padding:10px 20px; border-bottom:1px solid var(--c-border); display:flex; align-items:center; gap:8px;">
                <span style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:var(--c-text-muted);flex-shrink:0;">Filter:</span>
                <div class="filter-pills">
                    <span class="fpill fpill-all active" data-filter="all">
                        <i class="fas fa-layer-group" style="font-size:9px;"></i> Semua (<?= $total ?>)
                    </span>
                    <span class="fpill fpill-proses" data-filter="proses">
                        <i class="fas fa-spinner" style="font-size:9px;"></i> Proses (<?= $cProses ?>)
                    </span>
                    <span class="fpill fpill-selesai" data-filter="selesai">
                        <i class="fas fa-check-circle" style="font-size:9px;"></i> Selesai (<?= $cSelesai ?>)
                    </span>
                    <span class="fpill fpill-ditolak" data-filter="ditolak">
                        <i class="fas fa-times-circle" style="font-size:9px;"></i> Ditolak (<?= $cDitolak ?>)
                    </span>
                    <span class="fpill fpill-draft" data-filter="draft">
                        <i class="fas fa-pen-fancy" style="font-size:9px;"></i> Draft (<?= $cDraft ?>)
                    </span>
                </div>
            </div>

            <!-- Table -->
            <div style="overflow-x:auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width:44px;text-align:center;">#</th>
                            <th>Perusahaan</th>
                            <th>Nama TKA</th>
                            <th>Status</th>
                            <th>Tgl Pengajuan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <?php $no = 1; foreach($all_tka as $t):
                            $coInit = strtoupper(substr($t->perusahaan, 0, 2));
                            if(in_array($t->status, $prosesStatuses)) {
                                $bClass = 'badge-proses'; $bLabel = 'Proses'; $bDot = '#3b82f6'; $filterKey = 'proses';
                            } elseif($t->status == 'SELESAI') {
                                $bClass = 'badge-selesai'; $bLabel = 'Selesai'; $bDot = '#10b981'; $filterKey = 'selesai';
                            } elseif($t->status == 'DITOLAK') {
                                $bClass = 'badge-ditolak'; $bLabel = 'Ditolak'; $bDot = '#f43f5e'; $filterKey = 'ditolak';
                            } else {
                                $bClass = 'badge-draft'; $bLabel = 'Draft'; $bDot = '#94a3b8'; $filterKey = 'draft';
                            }
                            $tanggal = date('d M Y', strtotime($t->created_at));
                            $jam     = date('H:i', strtotime($t->created_at));
                        ?>
                        <tr data-search="<?= strtolower(htmlspecialchars($t->perusahaan . ' ' . $t->nama_tka)) ?>"
                            data-status="<?= $filterKey ?>">

                            <!-- # -->
                            <td class="col-no" style="text-align:center;font-size:0.75rem;color:var(--c-text-muted);"><?= $no++ ?></td>

                            <!-- Perusahaan -->
                            <td data-label="Perusahaan">
                                <div class="co-cell">
                                    <div class="co-avatar"><?= $coInit ?></div>
                                    <span class="co-name" data-field="perusahaan"><?= htmlspecialchars($t->perusahaan) ?></span>
                                </div>
                                <!-- Mobile-only: nama TKA + badge status -->
                                <div class="mobile-meta">
                                    <span class="tka-name" data-field="nama_tka_mobile"><?= htmlspecialchars($t->nama_tka) ?></span>
                                    <span class="badge <?= $bClass ?>">
                                        <span class="badge-dot" style="background:<?= $bDot ?>;"></span>
                                        <?= $bLabel ?>
                                    </span>
                                </div>
                            </td>

                            <!-- Nama TKA (desktop only) -->
                            <td data-label="TKA">
                                <span class="tka-name" data-field="nama_tka"><?= htmlspecialchars($t->nama_tka) ?></span>
                            </td>

                            <!-- Status (desktop only) -->
                            <td data-label="Status">
                                <span class="badge <?= $bClass ?>">
                                    <span class="badge-dot" style="background:<?= $bDot ?>;"></span>
                                    <?= $bLabel ?>
                                </span>
                            </td>

                            <!-- Tanggal -->
                            <td data-label="Tanggal">
                                <div class="cell-date-main"><?= $tanggal ?></div>
                                <div class="cell-date-sub"><?= $jam ?> WIB</div>
                            </td>

                            <!-- Aksi -->
                            <td data-label="Aksi">

                                <!-- Desktop: ikon + teks kecil -->
                                <div class="act-strip-desktop" style="display:flex;gap:4px;align-items:center;flex-wrap:nowrap;">
                                    <?php if($t->status == 'SELESAI' && $t->surat_teks_approved == 1): ?>
                                        <a href="<?= base_url('admin/download_surat_word/'.$t->id) ?>" class="act-btn-text ab-download">
                                            <i class="fas fa-download" style="font-size:10px;"></i> Surat
                                        </a>
                                    <?php endif; ?>
                                    <a href="<?= base_url('admin/edit_nomor_surat/'.$t->id) ?>" class="act-btn-text ab-nomor">
                                        <i class="fas fa-pen-alt" style="font-size:10px;"></i> Nomor
                                    </a>
                                    <a href="<?= base_url('admin/detail_tka/'.$t->id) ?>" class="act-btn ab-detail" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?= base_url('admin/edit_tka/'.$t->id) ?>" class="act-btn ab-edit" title="Edit">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    <a href="<?= base_url('admin/delete_tka/'.$t->id) ?>" class="act-btn ab-delete" title="Hapus"
                                       onclick="return confirm('Yakin hapus data TKA ini?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>

                                <!-- Mobile: tombol lebar dengan label -->
                                <div class="act-strip-mobile">
                                    <?php if($t->status == 'SELESAI' && $t->surat_teks_approved == 1): ?>
                                        <a href="<?= base_url('admin/download_surat_word/'.$t->id) ?>" class="act-btn-text ab-download">
                                            <i class="fas fa-download"></i><span class="abl"> Surat</span>
                                        </a>
                                    <?php endif; ?>
                                    <a href="<?= base_url('admin/edit_nomor_surat/'.$t->id) ?>" class="act-btn-text ab-nomor">
                                        <i class="fas fa-pen-alt"></i><span class="abl"> Nomor</span>
                                    </a>
                                    <a href="<?= base_url('admin/detail_tka/'.$t->id) ?>" class="act-btn ab-detail">
                                        <i class="fas fa-eye"></i><span class="abl"> Detail</span>
                                    </a>
                                    <a href="<?= base_url('admin/edit_tka/'.$t->id) ?>" class="act-btn ab-edit">
                                        <i class="fas fa-pen"></i><span class="abl"> Edit</span>
                                    </a>
                                    <a href="<?= base_url('admin/delete_tka/'.$t->id) ?>" class="act-btn ab-delete"
                                       onclick="return confirm('Yakin hapus data TKA ini?')">
                                        <i class="fas fa-trash"></i><span class="abl"> Hapus</span>
                                    </a>
                                </div>

                            </td>
                        </tr>
                        <?php endforeach; ?>

                        <?php if(empty($all_tka)): ?>
                        <tr>
                            <td colspan="6" class="no-result-cell">
                                <div class="nri"><i class="fas fa-file-circle-xmark"></i></div>
                                <p>Belum ada pengajuan TKA.</p>
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

    /* ── Hamburger ── */
    document.getElementById('btnHamburger')?.addEventListener('click', function () {
        if (typeof window.openAdminSidebar === 'function') window.openAdminSidebar();
    });

    /* ── Sinkronisasi desktop vs mobile ── */
    function syncView() {
        var isMobile = window.innerWidth <= 768;
        document.querySelectorAll('.act-strip-desktop').forEach(function (el) { el.style.display = isMobile ? 'none' : 'flex'; });
        document.querySelectorAll('.act-strip-mobile').forEach(function (el)  { el.style.display = isMobile ? 'flex' : 'none'; });
        document.querySelectorAll('.mobile-meta').forEach(function (el)        { el.style.display = isMobile ? 'flex' : 'none'; });
    }
    syncView();
    window.addEventListener('resize', syncView);

    /* ── Search & Filter & Pagination ── */
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
    var activeFilter = 'all';

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
            var ms = !q || row.getAttribute('data-search').indexOf(q) !== -1;
            var mf = activeFilter === 'all' || row.getAttribute('data-status') === activeFilter;
            return ms && mf;
        });
    }

    function renderPaging(total, page, ppg) {
        var tp = Math.ceil(total / ppg) || 1;
        var s  = (page - 1) * ppg + 1, e = Math.min(page * ppg, total);
        pagingInfo.innerHTML = total > 0
            ? 'Menampilkan <strong>' + s + '–' + e + '</strong> dari <strong>' + total + '</strong> pengajuan'
            : '0 pengajuan ditemukan';
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
        var q = input.value.trim().toLowerCase();
        filteredRows = getFiltered(q);
        currentPage  = 1;
        applyPaging();
        searchWrap.classList.toggle('has-value', q.length > 0);
    }

    function applyPaging() {
        var q = input.value.trim().toLowerCase();
        var total = filteredRows.length, start = (currentPage - 1) * perPage, end = start + perPage;
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
        if (total === 0) jsNoMsg.innerHTML = q
            ? 'Tidak ada hasil untuk &ldquo;<strong>' + q + '</strong>&rdquo;'
            : 'Tidak ada data pada filter ini.';
        renderPaging(total, currentPage, perPage);
        syncView();
    }

    /* ── Filter pills ── */
    document.querySelectorAll('.fpill').forEach(function (pill) {
        pill.addEventListener('click', function () {
            document.querySelectorAll('.fpill').forEach(function (p) { p.classList.remove('active'); });
            pill.classList.add('active');
            activeFilter = pill.getAttribute('data-filter');
            applyAll();
        });
    });

    input.addEventListener('input', applyAll);
    clearBtn.addEventListener('click', function () { input.value = ''; applyAll(); input.focus(); });
    perPageSelect.addEventListener('change', function () { perPage = parseInt(this.value); currentPage = 1; applyPaging(); });
    document.addEventListener('keydown', function (e) {
        if ((e.key === '/' && document.activeElement !== input) || (e.ctrlKey && e.key === 'k')) { e.preventDefault(); input.focus(); input.select(); }
        if (e.key === 'Escape' && document.activeElement === input) { input.value = ''; applyAll(); input.blur(); }
    });

    applyAll();
})();
</script>
</body>
</html>