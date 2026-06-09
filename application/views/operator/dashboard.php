<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Operator — TKA App</title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/shared.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>

        /* ── Pagination ── */
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

        /* ── Mobile card list (menggantikan tabel di mobile) ── */
        .tka-card-list { display: none; }
        .tka-card-item {
            padding: 14px 16px;
            border-bottom: 1px solid var(--c-border);
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .tka-card-item:last-child { border-bottom: none; }
        .tka-card-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
        }
        .tka-card-name {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--c-text);
            line-height: 1.3;
        }
        .tka-card-company {
            font-size: 0.75rem;
            color: var(--c-text-muted);
            margin-top: 2px;
        }
        .tka-card-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }
        .tka-card-date {
            font-size: 0.72rem;
            color: var(--c-text-muted);
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .tka-card-actions {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {

            .page-content { padding: 12px !important; }

            /* stat grid: 2x2 */
            .stats-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 10px !important;
            }
            .stat-card {
                padding: 14px 14px !important;
                border-radius: 16px !important;
            }
            .stat-label { font-size: 0.72rem !important; }
            .stat-value { font-size: 1.5rem !important; }
            .stat-icon { width: 32px !important; height: 32px !important; font-size: 0.85rem !important; }

            /* surface border-radius */
            .surface { border-radius: 16px !important; }

            /* sembunyikan tabel, tampilkan card list */
            .table-wrap { display: none !important; }
            .tka-card-list { display: block !important; }

            /* pagination lebih compact */
            .paging-wrap {
                padding: 12px 14px;
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
                border-radius: 0 0 16px 16px;
            }
            .paging-controls { flex-wrap: wrap; }
            .page-btn { min-width: 32px; height: 32px; font-size: 0.72rem; }

            /* info banner */
            .info-banner {
                border-radius: 16px !important;
                padding: 14px 16px !important;
                gap: 12px !important;
            }
            .info-banner ul { padding-left: 14px; margin-bottom: 0; }
            .info-banner ul li { font-size: 0.78rem; margin-bottom: 3px; }

            /* surface header: tata letak bersih di mobile */
            .surface-header {
                padding: 14px 16px !important;
                flex-wrap: wrap !important;
                gap: 8px !important;
            }
            .surface-title { font-size: 0.88rem !important; }

            /* btn-secondary di header full width di mobile */
            .surface-header .btn-secondary {
                width: 100% !important;
                justify-content: center !important;
                padding: 10px 14px !important;
                font-size: 0.8rem !important;
                border-radius: 10px !important;
            }

            /* page header */
            .page-header { margin-bottom: 14px !important; }
            .page-title { font-size: 1.2rem !important; }
            .page-subtitle { font-size: 0.8rem !important; }
        }

        @media (max-width: 400px) {
            .page-content { padding: 10px !important; }
            .stats-grid { gap: 8px !important; }
            .stat-card { padding: 12px !important; }
        }
    </style>
</head>
<body>

<?php $this->load->view('operator/sidebar'); ?>

<div class="page-wrapper">
    <div class="topnav">
        <div class="topnav-breadcrumb">
            <span>Home</span>
            <i class="fas fa-chevron-right"></i>
            <strong>Dashboard Operator</strong>
        </div>
        <div class="topnav-actions">
            <span class="badge" style="background:var(--c-primary-light);color:var(--c-primary);font-weight:600;padding:5px 12px;">
                <i class="fas fa-user-cog" style="margin-right:5px;"></i> Operator
            </span>
        </div>
    </div>

    <div class="page-content">
        <div class="page-header">
            <h1 class="page-title">Dashboard Operator</h1>
            <p class="page-subtitle">
                Selamat datang, <strong><?= htmlspecialchars($this->session->userdata('nama')) ?></strong>.
                Pantau dan kelola pengajuan TKA dari satu tempat.
            </p>
        </div>

        <!-- Stat cards: 2x2 grid di mobile, 4 kolom di desktop -->
        <div class="stats-grid">
            <div class="stat-card sc-total">
                <div class="stat-top"><div class="stat-icon"><i class="fas fa-file-alt"></i></div></div>
                <div><div class="stat-label">Total Pengajuan</div><div class="stat-value"><?= $total_tka ?? 0 ?></div></div>
            </div>
            <div class="stat-card sc-selesai">
                <div class="stat-top"><div class="stat-icon"><i class="fas fa-check-circle"></i></div></div>
                <div><div class="stat-label">Selesai</div><div class="stat-value"><?= $total_selesai ?? 0 ?></div></div>
            </div>
            <div class="stat-card sc-proses">
                <div class="stat-top"><div class="stat-icon"><i class="fas fa-spinner"></i></div></div>
                <div><div class="stat-label">Dalam Proses</div><div class="stat-value"><?= $total_proses ?? 0 ?></div></div>
            </div>
            <div class="stat-card sc-ditolak">
                <div class="stat-top"><div class="stat-icon"><i class="fas fa-times-circle"></i></div></div>
                <div><div class="stat-label">Ditolak</div><div class="stat-value"><?= $total_ditolak ?? 0 ?></div></div>
            </div>
        </div>

        <!-- Info banner -->
        <div class="info-banner">
            <div class="info-banner-icon"><i class="fas fa-bullhorn"></i></div>
            <div class="info-banner-body">
                <h6>Hal yang perlu diperhatikan</h6>
                <ul>
                    <li>Pastikan nomor surat sudah diisi sebelum mengunduh dokumen.</li>
                    <li>Pengajuan <strong>DRAFT</strong> belum masuk antrean persetujuan — segera lengkapi.</li>
                    <li>Gunakan tombol <em>Edit Nomor</em> untuk menyesuaikan penomoran surat.</li>
                </ul>
            </div>
        </div>

        <!-- Tabel pengajuan terbaru -->
        <div class="surface">
            <div class="surface-header">
                <div class="surface-title">
                    <i class="fas fa-clock"></i> Pengajuan Terbaru
                </div>
                <a href="<?= base_url('operator/semua_tka') ?>" class="btn-secondary" style="padding:6px 14px;font-size:0.75rem;">
                    Lihat Semua <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="surface-body" style="padding:0;">

                <?php
                if (!isset($recent_tka) && isset($all_tka)) {
                    $recent_tka = array_slice($all_tka, 0, 5);
                }
                ?>

                <?php if (!empty($recent_tka)): ?>

                    <!-- ── DESKTOP: tabel biasa ── -->
                    <div class="table-wrap table-responsive-card">
                        <table class="data-table" id="recentTable">
                            <thead>
                                <tr>
                                    <th style="width:40px;text-align:center;">#</th>
                                    <th>Perusahaan</th>
                                    <th>Nama TKA</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach ($recent_tka as $t): ?>
                                <tr>
                                    <td class="cell-no"><?= $no++ ?></td>
                                    <td class="cell-name" data-label="Perusahaan"><?= htmlspecialchars($t->perusahaan ?? '-') ?></td>
                                    <td class="cell-name" data-label="Nama TKA" style="font-weight:500;"><?= htmlspecialchars($t->nama_tka) ?></td>
                                    <td data-label="Status">
                                        <?php if ($t->status == 'DRAFT'): ?>
                                            <span class="badge badge-draft"><span class="badge-dot"></span> DRAFT</span>
                                        <?php elseif (in_array($t->status, ['MENUNGGU_KASI','MENUNGGU_KABID','MENUNGGU_SEKDIS','MENUNGGU_KADIS'])): ?>
                                            <span class="badge badge-proses"><span class="badge-dot"></span> Proses</span>
                                        <?php elseif ($t->status == 'SELESAI'): ?>
                                            <span class="badge badge-selesai"><span class="badge-dot"></span> Selesai</span>
                                        <?php elseif ($t->status == 'DITOLAK'): ?>
                                            <span class="badge badge-ditolak"><span class="badge-dot"></span> Ditolak</span>
                                        <?php else: ?>
                                            <span class="badge badge-draft"><span class="badge-dot"></span> <?= htmlspecialchars($t->status) ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td data-label="Tanggal">
                                        <span class="cell-date-main"><?= date('d-m-Y', strtotime($t->created_at)) ?></span>
                                        <span class="cell-date-sub"><?= date('H:i', strtotime($t->created_at)) ?></span>
                                    </td>
                                    <td class="cell-action" data-label="Aksi">
                                        <div class="btn-row">
                                            <?php if ($t->status == 'SELESAI' && !empty($t->surat_teks_approved) && $t->surat_teks_approved == 1): ?>
                                                <a href="<?= base_url('operator/download_surat_word/'.$t->id) ?>" class="btn-xs bx-surat" title="Download Surat">
                                                    <i class="fas fa-download"></i> Surat
                                                </a>
                                            <?php endif; ?>
                                            <a href="<?= base_url('operator/edit_nomor_surat/'.$t->id) ?>" class="btn-xs bx-edit" title="Edit Nomor Surat">
                                                <i class="fas fa-pen-alt"></i> Edit Nomor
                                            </a>
                                            <a href="<?= base_url('operator/detail_tka/'.$t->id) ?>" class="btn-xs bx-detail" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- ── MOBILE: card list ── -->
                    <div class="tka-card-list" id="mobileCardList">
                        <?php $no2 = 1; foreach ($recent_tka as $t): ?>
                        <div class="tka-card-item">
                            <div class="tka-card-top">
                                <div>
                                    <div class="tka-card-name"><?= htmlspecialchars($t->nama_tka) ?></div>
                                    <div class="tka-card-company">
                                        <i class="fas fa-building" style="font-size:10px;margin-right:3px;"></i>
                                        <?= htmlspecialchars($t->perusahaan ?? '-') ?>
                                    </div>
                                </div>
                                <?php if ($t->status == 'DRAFT'): ?>
                                    <span class="badge badge-draft"><span class="badge-dot"></span> DRAFT</span>
                                <?php elseif (in_array($t->status, ['MENUNGGU_KASI','MENUNGGU_KABID','MENUNGGU_SEKDIS','MENUNGGU_KADIS'])): ?>
                                    <span class="badge badge-proses"><span class="badge-dot"></span> Proses</span>
                                <?php elseif ($t->status == 'SELESAI'): ?>
                                    <span class="badge badge-selesai"><span class="badge-dot"></span> Selesai</span>
                                <?php elseif ($t->status == 'DITOLAK'): ?>
                                    <span class="badge badge-ditolak"><span class="badge-dot"></span> Ditolak</span>
                                <?php else: ?>
                                    <span class="badge badge-draft"><span class="badge-dot"></span> <?= htmlspecialchars($t->status) ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="tka-card-meta">
                                <div class="tka-card-date">
                                    <i class="fas fa-calendar-alt" style="font-size:10px;"></i>
                                    <?= date('d M Y', strtotime($t->created_at)) ?>
                                    <span style="color:var(--c-border-strong);">·</span>
                                    <?= date('H:i', strtotime($t->created_at)) ?>
                                </div>
                                <div class="tka-card-actions">
                                    <?php if ($t->status == 'SELESAI' && !empty($t->surat_teks_approved) && $t->surat_teks_approved == 1): ?>
                                        <a href="<?= base_url('operator/download_surat_word/'.$t->id) ?>" class="btn-xs bx-surat" title="Download Surat">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    <?php endif; ?>
                                    <a href="<?= base_url('operator/edit_nomor_surat/'.$t->id) ?>" class="btn-xs bx-edit" title="Edit Nomor">
                                        <i class="fas fa-pen-alt"></i>
                                    </a>
                                    <a href="<?= base_url('operator/detail_tka/'.$t->id) ?>" class="btn-xs bx-detail" title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Pagination (shared, ditampilkan di bawah keduanya) -->
                    <div class="paging-wrap" id="recentPagingWrap">
                        <div class="paging-info" id="recentPagingInfo">—</div>
                        <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
                            <div class="per-page-wrap">
                                <span>Tampilkan</span>
                                <select class="per-page-select" id="recentPerPage">
                                    <option value="10" selected>10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                                <span>per halaman</span>
                            </div>
                            <div class="paging-controls" id="recentPagingControls"></div>
                        </div>
                    </div>

                <?php else: ?>
                    <div class="empty-state">
                        <div class="empty-state-icon"><i class="fas fa-inbox"></i></div>
                        <h4>Belum ada pengajuan</h4>
                        <p>Semua pengajuan TKA yang masuk akan muncul di sini.<br>Silakan mulai dengan membuat pengajuan baru.</p>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div><!-- /page-content -->
</div><!-- /page-wrapper -->

<?php $this->load->view('footer'); ?>

<script>
(function() {
    var isMobile = window.innerWidth <= 768;

    /* ── Ambil semua item (dari tabel desktop atau card mobile) ── */
    var tableBody   = document.querySelector('#recentTable tbody');
    var cardList    = document.getElementById('mobileCardList');
    var tableRows   = tableBody   ? Array.from(tableBody.querySelectorAll('tr'))              : [];
    var mobileCards = cardList    ? Array.from(cardList.querySelectorAll('.tka-card-item'))   : [];

    if (tableRows.length === 0 && mobileCards.length === 0) return;

    var perPage     = 10;
    var currentPage = 1;
    var total       = tableRows.length || mobileCards.length;

    var infoEl      = document.getElementById('recentPagingInfo');
    var controlsEl  = document.getElementById('recentPagingControls');
    var perPageSel  = document.getElementById('recentPerPage');

    function showPage(page) {
        var totalPages = Math.ceil(total / perPage) || 1;
        if (page < 1) page = 1;
        if (page > totalPages) page = totalPages;
        currentPage = page;

        var start = (currentPage - 1) * perPage;
        var end   = Math.min(currentPage * perPage, total);

        /* tabel */
        tableRows.forEach(function(row, idx) {
            row.style.display = (idx >= start && idx < end) ? '' : 'none';
        });
        /* card mobile */
        mobileCards.forEach(function(card, idx) {
            card.style.display = (idx >= start && idx < end) ? '' : 'none';
        });

        infoEl.innerHTML = total > 0
            ? 'Menampilkan <strong>' + (start + 1) + '–' + end + '</strong> dari <strong>' + total + '</strong> pengajuan'
            : '0 pengajuan';

        renderControls(totalPages);
    }

    function renderControls(totalPages) {
        controlsEl.innerHTML = '';
        if (totalPages <= 1) return;

        var prevBtn = makeBtn('<i class="fas fa-chevron-left" style="font-size:10px;"></i>', function() { showPage(currentPage - 1); });
        prevBtn.disabled = currentPage === 1;
        controlsEl.appendChild(prevBtn);

        var startP = Math.max(1, currentPage - 2);
        var endP   = Math.min(totalPages, startP + 4);
        startP     = Math.max(1, endP - 4);

        if (startP > 1) { controlsEl.appendChild(makePageBtn(1)); if (startP > 2) controlsEl.appendChild(makeDots()); }
        for (var i = startP; i <= endP; i++) controlsEl.appendChild(makePageBtn(i));
        if (endP < totalPages) { if (endP < totalPages - 1) controlsEl.appendChild(makeDots()); controlsEl.appendChild(makePageBtn(totalPages)); }

        var nextBtn = makeBtn('<i class="fas fa-chevron-right" style="font-size:10px;"></i>', function() { showPage(currentPage + 1); });
        nextBtn.disabled = currentPage === totalPages;
        controlsEl.appendChild(nextBtn);
    }

    function makeBtn(html, fn) {
        var b = document.createElement('button');
        b.className = 'page-btn';
        b.innerHTML = html;
        b.addEventListener('click', fn);
        return b;
    }
    function makePageBtn(num) {
        var b = makeBtn(num, function() { showPage(num); });
        if (num === currentPage) b.classList.add('active');
        return b;
    }
    function makeDots() {
        var s = document.createElement('span');
        s.className = 'page-btn';
        s.style.cursor = 'default';
        s.textContent = '…';
        return s;
    }

    perPageSel.addEventListener('change', function() {
        perPage = parseInt(this.value);
        showPage(1);
    });

    showPage(1);
})();
</script>
</body>
</html>