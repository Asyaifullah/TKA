<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Pengajuan TKA — Operator SITLAKEB</title>
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

        .tbl-toolbar {
            padding: 14px 20px; border-bottom: 1px solid var(--c-border);
            display: flex; align-items: center;
            justify-content: space-between; gap: 12px; flex-wrap: wrap;
        }
        .toolbar-left  { display: flex; align-items: center; gap: 10px; flex: 1; flex-wrap: wrap; }
        .toolbar-right { display: flex; align-items: center; gap: 8px; flex-shrink: 0; }

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
            color: var(--c-text);
            background: var(--c-bg, #f8fafc);
            border: 1px solid var(--c-border);
            border-radius: var(--r-sm);
            padding: 7px 32px 7px 32px;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
        }
        .search-input:focus {
            background: #fff;
            border-color: var(--c-primary);
            box-shadow: 0 0 0 3px var(--c-primary-light);
        }
        .search-input::placeholder { color: #cbd5e1; }

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

        .tbl-counter { font-size: 0.75rem; color: var(--c-text-muted); white-space: nowrap; }
        .tbl-counter strong { color: var(--c-text); }

        .data-table { width: 100%; border-collapse: collapse; }
        .data-table thead th {
            background: #fafcff;
            color: var(--c-text-muted);
            font-size: 0.68rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.07em;
            padding: 11px 16px;
            border-bottom: 1px solid var(--c-border);
            white-space: nowrap;
        }
        .data-table tbody td {
            padding: 12px 16px; vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.83rem; color: var(--c-text);
        }
        .data-table tbody tr:last-child td { border-bottom: none; }
        .data-table tbody tr:hover td { background: #f8fffe; }

        .co-cell { display: flex; align-items: center; gap: 9px; }
        .co-avatar {
            width: 30px; height: 30px; border-radius: var(--r-sm);
            background: var(--c-primary-light); color: var(--c-primary);
            font-family: var(--font-head); font-size: 0.68rem; font-weight: 800;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; text-transform: uppercase;
        }
        .co-name { font-weight: 600; font-size: 0.83rem; color: var(--c-text); }

        .badge { display: inline-flex; align-items: center; gap: 5px; padding: 3px 10px; border-radius: 20px; font-size: 0.68rem; font-weight: 700; font-family: var(--font-head); }
        .badge-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
        .badge-draft   { background: #f1f5f9; color: #475569; }
        .badge-proses  { background: #e0f2fe; color: #0369a1; }
        .badge-selesai { background: #dcfce7; color: #15803d; }
        .badge-ditolak { background: #fee2e2; color: #b91c1c; }

        .act-btn {
            display: inline-flex; align-items: center; justify-content: center;
            width: 28px; height: 28px;
            border-radius: 6px; border: 1px solid;
            font-size: 11px; text-decoration: none;
            transition: background 0.15s, border-color 0.15s, transform 0.1s;
            flex-shrink: 0;
        }
        .act-btn-text {
            display: inline-flex; align-items: center; gap: 4px;
            height: 28px; padding: 0 10px;
            border-radius: 6px; border: 1px solid;
            font-family: var(--font-head); font-size: 0.7rem; font-weight: 700;
            text-decoration: none; white-space: nowrap;
            transition: background 0.15s, border-color 0.15s, transform 0.1s;
        }
        .act-btn:hover, .act-btn-text:hover { transform: translateY(-1px); }
        .ab-detail   { background: #f1f5f9; color: #334155; border-color: #e2e8f0; }
        .ab-detail:hover   { background: var(--c-primary-light); border-color: #a7d9cf; color: var(--c-primary); }
        .ab-nomor    { background: #eff6ff; color: #1e40af; border-color: #bfdbfe; }
        .ab-nomor:hover    { background: #dbeafe; border-color: #93c5fd; }
        .ab-download { background: #ecfdf5; color: #065f46; border-color: #a7f3d0; }
        .ab-download:hover { background: #d1fae5; border-color: #6ee7b7; }

        .cell-date-main { font-size: 0.81rem; color: var(--c-text); }
        .cell-date-sub  { font-size: 0.7rem; color: var(--c-text-muted); margin-top: 1px; }

        .tbl-footer {
            padding: 11px 20px;
            border-top: 1px solid var(--c-border);
            font-size: 0.75rem; color: var(--c-text-muted);
            display: flex; align-items: center; justify-content: space-between;
        }

        .no-result-cell { padding: 48px 20px !important; text-align: center; }
        .no-result-cell .nri { font-size: 2rem; color: #cbd5e1; margin-bottom: 10px; }
        .no-result-cell p { font-size: 0.84rem; color: var(--c-text-muted); margin: 0; }

        mark.hl { background: #fef9c3; color: #92400e; border-radius: 2px; padding: 0 1px; }

        .flash-alert {
            display: flex; align-items: flex-start; gap: 12px;
            border-radius: var(--r-lg); padding: 13px 16px;
            margin-bottom: 16px; font-size: 0.82rem;
        }
        .flash-success { background: #f0fdf4; border: 1px solid #a7f3d0; color: #065f46; }
        .flash-error   { background: #fff1f2; border: 1px solid #fecdd3; color: #9f1239; }

        /* ── Pagination dashboard style ── */
        .paging-wrap {
            padding: 14px 20px;
            border-top: 1px solid var(--c-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            background: var(--c-surface-2);
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

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .tbl-toolbar { flex-direction: column; align-items: flex-start; }
            .toolbar-left { width: 100%; }
            .search-wrap { max-width: 100%; width: 100%; }
            .filter-pills { margin-top: 8px; }
            .paging-wrap { flex-direction: column; align-items: flex-start; }
            .page-btn { min-width: 28px; height: 28px; font-size: 0.7rem; }
            .act-btn-text { padding: 0 8px; font-size: 0.65rem; }
        }
        @media (max-width: 576px) {
            .page-content { padding: 16px 12px; }
            .tbl-toolbar, .filter-pills { padding-left: 12px; padding-right: 12px; }
        }
    </style>
</head>
<body>

<?php $this->load->view('operator/sidebar'); ?>

<div class="page-wrapper">
    <header class="topnav">
        <div class="topnav-breadcrumb">
            <a href="<?= base_url('operator/dashboard') ?>" style="color:var(--c-text-muted);text-decoration:none;"><i class="fas fa-home"></i></a>
            <i class="fas fa-chevron-right" style="font-size:8px;"></i>
            <strong>Seluruh Pengajuan TKA</strong>
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

        <?php if($this->session->flashdata('error')): ?>
        <div class="flash-alert flash-error">
            <i class="fas fa-circle-exclamation" style="margin-top:1px;flex-shrink:0;"></i>
            <span><?= $this->session->flashdata('error') ?></span>
        </div>
        <?php endif; ?>
        <?php if($this->session->flashdata('success')): ?>
        <div class="flash-alert flash-success">
            <i class="fas fa-circle-check" style="margin-top:1px;flex-shrink:0;"></i>
            <span><?= $this->session->flashdata('success') ?></span>
        </div>
        <?php endif; ?>

        <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
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
            <div class="tbl-toolbar">
                <div class="toolbar-left">
                    <div class="search-wrap" id="searchWrap">
                        <i class="fas fa-search s-icon"></i>
                        <input type="text" class="search-input" id="searchInput" placeholder="Cari perusahaan atau nama TKA..." autocomplete="off">
                        <button class="s-clear" id="searchClear" title="Hapus"><i class="fas fa-xmark"></i></button>
                    </div>
                    <div class="tbl-counter">
                        <strong id="visibleCount"><?= $total ?></strong> dari <?= $total ?> ditampilkan
                    </div>
                </div>
            </div>

            <div style="padding:10px 20px; border-bottom:1px solid var(--c-border); display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                <span style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:var(--c-text-muted);margin-right:2px;">Filter:</span>
                <div class="filter-pills">
                    <span class="fpill fpill-all active"   data-filter="all"><i class="fas fa-layer-group" style="font-size:9px;"></i> Semua (<?= $total ?>)</span>
                    <span class="fpill fpill-proses"  data-filter="proses"><i class="fas fa-spinner" style="font-size:9px;"></i> Proses (<?= $cProses ?>)</span>
                    <span class="fpill fpill-selesai" data-filter="selesai"><i class="fas fa-check-circle" style="font-size:9px;"></i> Selesai (<?= $cSelesai ?>)</span>
                    <span class="fpill fpill-ditolak" data-filter="ditolak"><i class="fas fa-times-circle" style="font-size:9px;"></i> Ditolak (<?= $cDitolak ?>)</span>
                    <span class="fpill fpill-draft"   data-filter="draft"><i class="fas fa-pen-fancy" style="font-size:9px;"></i> Draft (<?= $cDraft ?>)</span>
                </div>
            </div>

            <!-- ═══════════ RESPONSIVE TABLE WRAPPER ═══════════ -->
            <div class="table-wrap table-responsive-card">
                <table class="data-table" id="mainTable">
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
                                $bClass = 'badge-proses'; $bLabel = 'Proses'; $bDot = '#3b82f6'; $fKey = 'proses';
                            } elseif($t->status == 'SELESAI') {
                                $bClass = 'badge-selesai'; $bLabel = 'Selesai'; $bDot = '#10b981'; $fKey = 'selesai';
                            } elseif($t->status == 'DITOLAK') {
                                $bClass = 'badge-ditolak'; $bLabel = 'Ditolak'; $bDot = '#f43f5e'; $fKey = 'ditolak';
                            } else {
                                $bClass = 'badge-draft'; $bLabel = 'Draft'; $bDot = '#94a3b8'; $fKey = 'draft';
                            }
                        ?>
                        <tr data-search="<?= strtolower(htmlspecialchars($t->perusahaan . ' ' . $t->nama_tka)) ?>" data-status="<?= $fKey ?>">
                            <td style="text-align:center;font-size:0.75rem;color:var(--c-text-muted);"><?= $no++ ?></td>
                            <td data-label="Perusahaan">
                                <div class="co-cell">
                                    <div class="co-avatar"><?= $coInit ?></div>
                                    <span class="co-name" data-field="perusahaan"><?= htmlspecialchars($t->perusahaan) ?></span>
                                </div>
                            </td>
                            <td data-label="Nama TKA"><span data-field="nama_tka" style="font-weight:500;"><?= htmlspecialchars($t->nama_tka) ?></span></td>
                            <td data-label="Status">
                                <span class="badge <?= $bClass ?>">
                                    <span class="badge-dot" style="background:<?= $bDot ?>;"></span> <?= $bLabel ?>
                                </span>
                            </td>
                            <td data-label="Tanggal">
                                <div class="cell-date-main"><?= date('d M Y', strtotime($t->created_at)) ?></div>
                                <div class="cell-date-sub"><?= date('H:i', strtotime($t->created_at)) ?> WIB</div>
                            </td>
                            <td class="cell-action" data-label="Aksi">
                                <div style="display:flex;gap:4px;align-items:center;flex-wrap:nowrap;">
                                    <?php if($t->status == 'SELESAI' && $t->surat_teks_approved == 1): ?>
                                        <a href="<?= base_url('operator/download_surat_word/'.$t->id) ?>" class="act-btn-text ab-download" title="Download Surat"><i class="fas fa-download" style="font-size:10px;"></i> Surat</a>
                                    <?php endif; ?>
                                    <a href="<?= base_url('operator/edit_nomor_surat/'.$t->id) ?>" class="act-btn-text ab-nomor" title="Edit Nomor Surat"><i class="fas fa-pen-alt" style="font-size:10px;"></i> Nomor</a>
                                    <a href="<?= base_url('operator/detail_tka/'.$t->id) ?>" class="act-btn ab-detail" title="Detail"><i class="fas fa-eye"></i></a>
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

            <!-- Pagination (model dashboard) -->
            <div class="paging-wrap" id="mainPagingWrap">
                <div class="paging-info" id="mainPagingInfo">—</div>
                <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
                    <div class="per-page-wrap">
                        <span>Tampilkan</span>
                        <select class="per-page-select" id="mainPerPage">
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <span>per halaman</span>
                    </div>
                    <div class="paging-controls" id="mainPagingControls"></div>
                </div>
            </div>

            <!-- No result message (bukan baris dalam tabel) -->
            <div id="jsNoResult" style="display:none; padding:48px 20px; text-align:center; color:var(--c-text-muted);">
                <div class="nri"><i class="fas fa-magnifying-glass"></i></div>
                <p id="jsNoResultMsg" style="font-size:0.84rem;"></p>
            </div>

            <div class="tbl-footer">
                <span>Menampilkan <strong id="footerCount"><?= $total ?></strong> dari <?= $total ?> pengajuan</span>
                <span id="searchStatus" style="display:none;color:var(--c-primary);font-weight:600;font-size:0.72rem;">
                    <i class="fas fa-filter" style="margin-right:4px;"></i> Filter aktif
                </span>
            </div>
        </div>
    </main>

    <?php $this->load->view('footer'); ?>
</div>

<script>
(function () {
    // Elemen UI
    var input = document.getElementById('searchInput');
    var clearBtn = document.getElementById('searchClear');
    var searchWrap = document.getElementById('searchWrap');
    var tbody = document.getElementById('tableBody');
    var visCount = document.getElementById('visibleCount');
    var footCount = document.getElementById('footerCount');
    var searchStat = document.getElementById('searchStatus');
    var jsNoResult = document.getElementById('jsNoResult');
    var jsNoMsg = document.getElementById('jsNoResultMsg');
    var activeFilter = 'all';

    // Pagination elements
    var infoEl = document.getElementById('mainPagingInfo');
    var controlsEl = document.getElementById('mainPagingControls');
    var perPageSelect = document.getElementById('mainPerPage');
    var perPage = 10;
    var currentPage = 1;

    // Data
    var allRows = Array.from(tbody.querySelectorAll('tr[data-search]'));
    var filteredRows = [];

    // Simpan original text untuk highlight
    allRows.forEach(function (row) {
        row.querySelectorAll('[data-field]').forEach(function (el) {
            el.setAttribute('data-orig', el.textContent.trim());
        });
    });

    // Highlight helpers
    function escapeRegex(s) { return s.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'); }
    function highlight(text, q) {
        if (!q) return text;
        return text.replace(new RegExp('(' + escapeRegex(q) + ')', 'gi'), '<mark class="hl">$1</mark>');
    }

    // Tentukan filteredRows berdasarkan filter dan search
    function filterRows() {
        var q = input.value.trim().toLowerCase();
        filteredRows = allRows.filter(function (row) {
            var matchSearch = !q || row.getAttribute('data-search').indexOf(q) !== -1;
            var matchFilter = activeFilter === 'all' || row.getAttribute('data-status') === activeFilter;
            return matchSearch && matchFilter;
        });

        // Update counters (total filtered, bukan per halaman)
        visCount.textContent = filteredRows.length;
        footCount.textContent = filteredRows.length;

        // Tampilkan/sembunyikan pesan tidak ada hasil
        if (filteredRows.length === 0 && allRows.length > 0) {
            jsNoResult.style.display = 'block';
            jsNoMsg.innerHTML = q ? 'Tidak ada hasil untuk &ldquo;<strong>' + q + '</strong>&rdquo;' : 'Tidak ada hasil pada filter ini.';
        } else {
            jsNoResult.style.display = 'none';
        }

        // Status filter
        searchWrap.classList.toggle('has-value', q.length > 0);
        searchStat.style.display = (q || activeFilter !== 'all') ? '' : 'none';

        // Reset ke halaman 1
        showPage(1);
    }

    // Tampilkan halaman tertentu dari filteredRows
    function showPage(page) {
        var total = filteredRows.length;
        var totalPages = Math.ceil(total / perPage) || 1;
        if (page < 1) page = 1;
        if (page > totalPages) page = totalPages;
        currentPage = page;

        var start = (currentPage - 1) * perPage;
        var end = Math.min(currentPage * perPage, total);

        // Sembunyikan semua baris
        allRows.forEach(function (row) { row.style.display = 'none'; });

        // Tampilkan slice dan terapkan highlight jika ada keyword
        var q = input.value.trim().toLowerCase();
        filteredRows.forEach(function (row, i) {
            if (i >= start && i < end) {
                row.style.display = '';
                row.querySelectorAll('[data-field]').forEach(function (el) {
                    var orig = el.getAttribute('data-orig') || '';
                    el.innerHTML = q ? highlight(orig, q) : orig;
                });
            } else {
                // Reset ke original (tanpa highlight) untuk baris yang tidak ditampilkan
                row.querySelectorAll('[data-field]').forEach(function (el) {
                    var orig = el.getAttribute('data-orig') || '';
                    if (el.innerHTML !== orig) el.innerHTML = orig;
                });
            }
        });

        // Update info pagination
        infoEl.innerHTML = total > 0
            ? 'Menampilkan <strong>' + (start+1) + '–' + end + '</strong> dari <strong>' + total + '</strong> pengajuan'
            : '0 pengajuan';

        renderControls(totalPages);
    }

    // Bangun tombol navigasi pagination
    function renderControls(totalPages) {
        controlsEl.innerHTML = '';
        if (totalPages <= 1) return;

        var prevBtn = document.createElement('button');
        prevBtn.className = 'page-btn';
        prevBtn.innerHTML = '<i class="fas fa-chevron-left" style="font-size:10px;"></i>';
        prevBtn.disabled = currentPage === 1;
        prevBtn.addEventListener('click', function () { showPage(currentPage - 1); });
        controlsEl.appendChild(prevBtn);

        var startP = Math.max(1, currentPage - 2);
        var endP = Math.min(totalPages, startP + 4);
        startP = Math.max(1, endP - 4);

        if (startP > 1) {
            controlsEl.appendChild(makePageBtn(1));
            if (startP > 2) controlsEl.appendChild(makeDots());
        }
        for (var i = startP; i <= endP; i++) {
            controlsEl.appendChild(makePageBtn(i));
        }
        if (endP < totalPages) {
            if (endP < totalPages - 1) controlsEl.appendChild(makeDots());
            controlsEl.appendChild(makePageBtn(totalPages));
        }

        var nextBtn = document.createElement('button');
        nextBtn.className = 'page-btn';
        nextBtn.innerHTML = '<i class="fas fa-chevron-right" style="font-size:10px;"></i>';
        nextBtn.disabled = currentPage === totalPages;
        nextBtn.addEventListener('click', function () { showPage(currentPage + 1); });
        controlsEl.appendChild(nextBtn);
    }

    function makePageBtn(num) {
        var btn = document.createElement('button');
        btn.className = 'page-btn' + (num === currentPage ? ' active' : '');
        btn.textContent = num;
        btn.addEventListener('click', function () { showPage(num); });
        return btn;
    }
    function makeDots() {
        var span = document.createElement('span');
        span.className = 'page-btn';
        span.style.cursor = 'default';
        span.textContent = '…';
        return span;
    }

    // Event listeners
    input.addEventListener('input', filterRows);
    clearBtn.addEventListener('click', function () { input.value = ''; filterRows(); input.focus(); });

    document.querySelectorAll('.fpill').forEach(function (pill) {
        pill.addEventListener('click', function () {
            document.querySelectorAll('.fpill').forEach(function (p) { p.classList.remove('active'); });
            pill.classList.add('active');
            activeFilter = pill.getAttribute('data-filter');
            filterRows();
        });
    });

    perPageSelect.addEventListener('change', function () {
        perPage = parseInt(this.value);
        // Reset ke halaman 1 saat ganti per page
        // (filterRows akan memanggil showPage(1) secara otomatis)
        filterRows();
    });

    document.addEventListener('keydown', function (e) {
        if ((e.key === '/' && document.activeElement !== input) || (e.ctrlKey && e.key === 'k')) {
            e.preventDefault(); input.focus(); input.select();
        }
        if (e.key === 'Escape' && document.activeElement === input) {
            input.value = ''; filterRows(); input.blur();
        }
    });

    // Inisialisasi
    if (allRows.length > 0) {
        filterRows();
    }
})();
</script>
</body>
</html>