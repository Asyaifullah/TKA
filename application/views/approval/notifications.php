<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi — <?= $role_display ?></title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/shared.css') ?>">

    <style>
        /* ── Filter chips ─────────────────────────────────────── */
        .filter-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
            padding: 12px 20px;
            border-bottom: 1px solid var(--c-border);
            background: var(--c-surface-2);
        }

        .filter-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .chip {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            border: 1px solid var(--c-border);
            background: var(--c-surface);
            color: var(--c-text-muted);
            cursor: pointer;
            transition: background 0.12s, color 0.12s, border-color 0.12s;
            white-space: nowrap;
        }

        .chip:hover  { border-color: var(--c-primary); color: var(--c-primary); }
        .chip.active { background: var(--c-primary); color: #fff; border-color: var(--c-primary); }

        /* ── Search ───────────────────────────────────────────── */
        .search-wrap {
            position: relative;
            flex-shrink: 0;
        }

        .search-icon {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--c-text-muted);
            font-size: 11px;
            pointer-events: none;
        }

        .search-input {
            padding: 7px 12px 7px 30px;
            border: 1px solid var(--c-border);
            border-radius: var(--r-md);
            background: var(--c-surface);
            font-family: var(--font-body);
            font-size: 0.78rem;
            color: var(--c-text);
            outline: none;
            width: 220px;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .search-input:focus {
            border-color: var(--c-primary);
            box-shadow: 0 0 0 3px var(--c-primary-glow);
        }

        .search-input::placeholder { color: var(--c-text-muted); }

        /* ── Badge status ─────────────────────────────────────── */
        .badge-unread {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #dcfce7;
            color: #15803d;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.68rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .badge-read {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: var(--c-surface-2);
            color: var(--c-text-muted);
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.68rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .notif-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            display: inline-block;
            background: #15803d;
        }

        /* ── Pagination ───────────────────────────────────────── */
        .paging-wrap {
            padding: 12px 20px;
            border-top: 1px solid var(--c-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            background: var(--c-surface-2);
        }

        .paging-info { font-size: 0.72rem; color: var(--c-text-muted); }

        .paging-controls {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .page-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 30px;
            height: 30px;
            padding: 0 8px;
            border: 1px solid var(--c-border);
            border-radius: var(--r-sm);
            background: var(--c-surface);
            font-family: var(--font-body);
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--c-text-muted);
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
            background: var(--c-primary);
            border-color: var(--c-primary);
            color: #fff;
            font-weight: 700;
        }

        .page-btn:disabled { opacity: 0.35; cursor: not-allowed; }

        .per-page-wrap {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.72rem;
            color: var(--c-text-muted);
        }

        .per-page-select {
            padding: 3px 22px 3px 8px;
            border: 1px solid var(--c-border);
            border-radius: var(--r-sm);
            background: var(--c-surface);
            font-size: 0.72rem;
            color: var(--c-text);
            outline: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 7px center;
            cursor: pointer;
        }

        /* ── No result ────────────────────────────────────────── */
        .no-result {
            display: none;
            padding: 40px 20px;
            text-align: center;
            color: var(--c-text-muted);
            font-size: 0.82rem;
        }

        .no-result i {
            font-size: 1.6rem;
            margin-bottom: 10px;
            display: block;
            opacity: 0.4;
        }

        /* ── Alert custom ─────────────────────────────────────── */
        .alert-custom {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 11px 14px;
            border-radius: var(--r-md);
            font-size: 0.84rem;
            margin-bottom: 16px;
            line-height: 1.5;
        }

        .alert-success-c {
            background: #f0fdf4;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }

        /* ══════════════════════════════════════════════════════
           TABEL vs CARD
        ══════════════════════════════════════════════════════ */
        .card-list { padding: 0; }

        @media (min-width: 769px) {
            .table-desktop { display: block; }
            .card-list     { display: none !important; }
        }

        @media (max-width: 768px) {
            .table-desktop { display: none !important; }
            .card-list     { display: block; }

            .filter-bar {
                flex-direction: column;
                align-items: stretch;
                gap: 8px;
                padding: 10px 14px;
            }

            .search-wrap  { width: 100%; }
            .search-input { width: 100%; }

            .paging-wrap {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
                padding: 12px 14px;
            }

            .topnav-actions .btn-primary {
                height: 32px;
                padding: 0 10px;
                font-size: 0.78rem;
            }
        }

        .notif-card {
            padding: 14px 16px;
            border-bottom: 1px solid var(--c-border);
            display: flex;
            flex-direction: column;
            gap: 6px;
            transition: background 0.12s;
        }

        .notif-card:last-child { border-bottom: none; }

        .notif-card.is-unread {
            background: #f8fff9;
            border-left: 3px solid #15803d;
            padding-left: 13px;
        }

        .notif-card-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 8px;
        }

        .notif-card-title {
            font-size: 0.86rem;
            font-weight: 700;
            color: var(--c-text);
            line-height: 1.4;
            flex: 1;
        }

        .notif-card-msg {
            font-size: 0.8rem;
            color: var(--c-text-muted);
            line-height: 1.6;
        }

        .notif-card-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 2px;
        }

        .notif-card-time {
            font-size: 0.72rem;
            color: var(--c-text-muted);
        }

        tr.row-hidden  { display: none !important; }
        .notif-card.card-hidden { display: none !important; }
    </style>
</head>
<body>

<?php $this->load->view('approval/sidebar'); ?>

<div class="page-wrapper">

    <header class="topnav">
        <div class="topnav-breadcrumb">
            <a href="<?= base_url('approval/index') ?>" style="color:var(--c-text-muted);text-decoration:none;">
                <i class="fas fa-home"></i>
            </a>
            <i class="fas fa-chevron-right" style="font-size:8px;"></i>
            <strong>Notifikasi</strong>
        </div>
        <div class="topnav-actions">
            <?php if($unread_count > 0): ?>
                <a href="<?= base_url('approval/mark_all_read') ?>"
                   class="btn-primary"
                   style="height:36px;padding:0 14px;"
                   onclick="return confirm('Tandai semua notifikasi sudah dibaca?')">
                    <i class="fas fa-check-double"></i>
                    <span class="btn-label">Tandai Semua Dibaca</span>
                </a>
            <?php endif; ?>
        </div>
    </header>

    <main class="page-content">

        <div class="page-header">
            <div class="page-title">Notifikasi Saya</div>
            <div class="page-subtitle">Riwayat seluruh notifikasi pada akun Anda (<?= htmlspecialchars($role_display) ?>)</div>
        </div>

        <?php if($this->session->flashdata('success')): ?>
        <div class="alert-custom alert-success-c">
            <i class="fas fa-circle-check" style="margin-top:1px;flex-shrink:0;"></i>
            <span><?= $this->session->flashdata('success') ?></span>
        </div>
        <?php endif; ?>

        <div class="surface" style="overflow:hidden;">

            <div class="surface-header">
                <div class="surface-title">
                    <i class="fas fa-bell"></i>
                    Riwayat Notifikasi
                    <?php if(!empty($notifications)): ?>
                        <span style="background:var(--c-primary-light);color:var(--c-primary);padding:2px 8px;border-radius:20px;font-size:0.68rem;">
                            <?= count($notifications) ?>
                        </span>
                    <?php endif; ?>
                    <?php if($unread_count > 0): ?>
                        <span style="background:#fef2f2;color:#dc2626;padding:2px 8px;border-radius:20px;font-size:0.68rem;">
                            <?= $unread_count ?> Belum Dibaca
                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <?php if(empty($notifications)): ?>
                <div class="empty-state">
                    <div class="empty-state-icon"><i class="fas fa-bell-slash"></i></div>
                    <h4>Belum Ada Notifikasi</h4>
                    <p>Anda belum memiliki notifikasi apapun.</p>
                </div>
            <?php else: ?>

                <div class="filter-bar">
                    <div class="filter-chips">
                        <div class="chip active" data-filter="all">Semua</div>
                        <div class="chip" data-filter="unread">Belum Dibaca</div>
                        <div class="chip" data-filter="read">Sudah Dibaca</div>
                    </div>
                    <div class="search-wrap">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" class="search-input" id="searchInput" placeholder="Cari notifikasi…">
                    </div>
                </div>

                <!-- DESKTOP TABLE -->
                <div class="table-desktop">
                    <div class="table-wrap">
                        <table class="data-table" id="notifTable">
                            <thead>
                                <tr>
                                    <th class="cell-no">#</th>
                                    <th style="width:120px;">Status</th>
                                    <th>Judul</th>
                                    <th>Pesan</th>
                                    <th style="width:130px;">Waktu</th>
                                    <th class="cell-action">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; foreach($notifications as $n): ?>
                                <tr data-status="<?= $n->is_read == 0 ? 'unread' : 'read' ?>"
                                    data-title="<?= strtolower(htmlspecialchars($n->title)) ?>"
                                    data-message="<?= strtolower(htmlspecialchars($n->message)) ?>">

                                    <td class="cell-no"><?= $no++ ?></td>

                                    <td>
                                        <?php if($n->is_read == 0): ?>
                                            <span class="badge-unread">
                                                <span class="notif-dot"></span> Belum Dibaca
                                            </span>
                                        <?php else: ?>
                                            <span class="badge-read">
                                                <i class="fas fa-check-circle" style="font-size:0.65rem;"></i> Sudah Dibaca
                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <strong style="font-size:0.83rem;">
                                            <?= htmlspecialchars($n->title) ?>
                                        </strong>
                                    </td>

                                    <td style="max-width:320px;font-size:0.82rem;color:var(--c-text-muted);">
                                        <?= htmlspecialchars($n->message) ?>
                                    </td>

                                    <td>
                                        <div class="cell-date-main"><?= date('d M Y', strtotime($n->created_at)) ?></div>
                                        <div class="cell-date-sub"><?= date('H:i', strtotime($n->created_at)) ?> WIB</div>
                                    </td>

                                    <td class="cell-action">
                                        <?php if($n->is_read == 0): ?>
                                            <a href="<?= base_url('approval/mark_notification_read/'.$n->id) ?>"
                                               class="btn-xs bx-lengkapi">
                                                <i class="fas fa-check"></i> Tandai Dibaca
                                            </a>
                                        <?php else: ?>
                                            <span style="color:var(--c-text-muted);font-size:0.8rem;">—</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- MOBILE CARD STACK -->
                <div class="card-list" id="cardList">
                    <?php foreach($notifications as $n): ?>
                    <div class="notif-card <?= $n->is_read == 0 ? 'is-unread' : '' ?>"
                         data-status="<?= $n->is_read == 0 ? 'unread' : 'read' ?>"
                         data-title="<?= strtolower(htmlspecialchars($n->title)) ?>"
                         data-message="<?= strtolower(htmlspecialchars($n->message)) ?>">

                        <div class="notif-card-top">
                            <div class="notif-card-title"><?= htmlspecialchars($n->title) ?></div>
                            <?php if($n->is_read == 0): ?>
                                <span class="badge-unread" style="flex-shrink:0;">
                                    <span class="notif-dot"></span> Baru
                                </span>
                            <?php else: ?>
                                <span class="badge-read" style="flex-shrink:0;">
                                    <i class="fas fa-check-circle" style="font-size:0.65rem;"></i> Dibaca
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="notif-card-msg"><?= htmlspecialchars($n->message) ?></div>

                        <div class="notif-card-meta">
                            <div class="notif-card-time">
                                <i class="fas fa-clock" style="font-size:0.65rem;margin-right:3px;"></i>
                                <?= date('d M Y, H:i', strtotime($n->created_at)) ?> WIB
                            </div>
                            <?php if($n->is_read == 0): ?>
                                <a href="<?= base_url('approval/mark_notification_read/'.$n->id) ?>"
                                   class="btn-xs bx-lengkapi">
                                    <i class="fas fa-check"></i> Tandai Dibaca
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

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

                <div class="no-result" id="noResult">
                    <i class="fas fa-search"></i>
                    Tidak ada notifikasi yang cocok dengan pencarian.
                </div>

            <?php endif; ?>

        </div>

    </main>
</div>

<?php $this->load->view('footer'); ?>

<script>
(function () {
    var perPage      = 10;
    var activeFilter = 'all';
    var searchVal    = '';
    var currentPage  = 1;

    var tableBody = document.querySelector('#notifTable tbody');
    var allRows   = tableBody ? Array.from(tableBody.querySelectorAll('tr')) : [];

    var cardList  = document.getElementById('cardList');
    var allCards  = cardList ? Array.from(cardList.querySelectorAll('.notif-card')) : [];

    var total_items = Math.max(allRows.length, allCards.length);
    if (total_items === 0) return;

    var pagingInfo     = document.getElementById('pagingInfo');
    var pagingControls = document.getElementById('pagingControls');
    var perPageSelect  = document.getElementById('perPageSelect');
    var noResultEl     = document.getElementById('noResult');

    function getPassingIndices() {
        var passing = [];
        var ref = allRows.length > 0 ? allRows : allCards;
        ref.forEach(function(item, idx) {
            var status  = item.dataset.status  || '';
            var title   = item.dataset.title   || '';
            var message = item.dataset.message || '';

            var passFilter = (activeFilter === 'all') || (status === activeFilter);
            var passSearch = (searchVal === '') ||
                             (title.indexOf(searchVal) !== -1) ||
                             (message.indexOf(searchVal) !== -1);

            if (passFilter && passSearch) passing.push(idx);
        });
        return passing;
    }

    function setVisible(idx, show) {
        if (allRows[idx]) {
            allRows[idx].style.display = show ? '' : 'none';
        }
        if (allCards[idx]) {
            if (show) {
                allCards[idx].classList.remove('card-hidden');
            } else {
                allCards[idx].classList.add('card-hidden');
            }
        }
    }

    function showPage(page) {
        var passing    = getPassingIndices();
        var total      = passing.length;
        var totalPages = Math.max(1, Math.ceil(total / perPage));

        if (page < 1)          page = 1;
        if (page > totalPages) page = totalPages;
        currentPage = page;

        var start = (currentPage - 1) * perPage;
        var end   = Math.min(currentPage * perPage, total);

        for (var i = 0; i < total_items; i++) {
            setVisible(i, false);
        }

        passing.forEach(function(idx, pos) {
            if (pos >= start && pos < end) {
                setVisible(idx, true);
            }
        });

        if (pagingInfo) {
            pagingInfo.innerHTML = total > 0
                ? 'Menampilkan <strong>' + (start + 1) + '–' + end + '</strong> dari <strong>' + total + '</strong> notifikasi'
                : '0 notifikasi';
        }

        if (noResultEl) {
            noResultEl.style.display = (total === 0) ? 'block' : 'none';
        }

        renderPaging(totalPages);
    }

    function renderPaging(totalPages) {
        if (!pagingControls) return;
        pagingControls.innerHTML = '';
        if (totalPages <= 1) return;

        pagingControls.appendChild(makeNav('<i class="fas fa-chevron-left" style="font-size:9px;"></i>', currentPage - 1, currentPage === 1));

        var startP = Math.max(1, currentPage - 2);
        var endP   = Math.min(totalPages, startP + 4);
        startP     = Math.max(1, endP - 4);

        if (startP > 1) {
            pagingControls.appendChild(makeNumBtn(1));
            if (startP > 2) pagingControls.appendChild(makeDots());
        }
        for (var i = startP; i <= endP; i++) {
            pagingControls.appendChild(makeNumBtn(i));
        }
        if (endP < totalPages) {
            if (endP < totalPages - 1) pagingControls.appendChild(makeDots());
            pagingControls.appendChild(makeNumBtn(totalPages));
        }

        pagingControls.appendChild(makeNav('<i class="fas fa-chevron-right" style="font-size:9px;"></i>', currentPage + 1, currentPage === totalPages));
    }

    function makeNav(html, targetPage, disabled) {
        var btn = document.createElement('button');
        btn.className = 'page-btn';
        btn.innerHTML = html;
        btn.disabled  = disabled;
        btn.addEventListener('click', function() { showPage(targetPage); });
        return btn;
    }

    function makeNumBtn(num) {
        var btn = document.createElement('button');
        btn.className = 'page-btn' + (num === currentPage ? ' active' : '');
        btn.textContent = num;
        btn.addEventListener('click', function() { showPage(num); });
        return btn;
    }

    function makeDots() {
        var span = document.createElement('span');
        span.className    = 'page-btn';
        span.style.cursor = 'default';
        span.textContent  = '…';
        return span;
    }

    document.querySelectorAll('.chip').forEach(function(chip) {
        chip.addEventListener('click', function() {
            document.querySelectorAll('.chip').forEach(function(c) { c.classList.remove('active'); });
            this.classList.add('active');
            activeFilter = this.dataset.filter;
            showPage(1);
        });
    });

    var searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            searchVal = this.value.toLowerCase().trim();
            showPage(1);
        });
    }

    if (perPageSelect) {
        perPageSelect.addEventListener('change', function() {
            perPage = parseInt(this.value, 10);
            showPage(1);
        });
    }

    showPage(1);
})();
</script>
</body>
</html>