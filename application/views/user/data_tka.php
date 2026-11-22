<?php
// ============================================================
// views/user/data_tka.php — Responsive (Desktop Tetap Aman)
// ============================================================
?>
<!DOCTYPE html>
<html lang="<?= current_lang() == 'indonesian' ? 'id' : 'en' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->lang->line('tka_page_title') ?></title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/shared.css') ?>">

    <style>
        /* ══════════════════════════════════════════
           SEARCH BAR & FILTER CHIPS (DESKTOP + MOBILE)
        ══════════════════════════════════════════ */
        .search-wrap {
            position: relative;
        }
        .search-icon {
            position: absolute; left: 10px; top: 50%;
            transform: translateY(-50%);
            color: var(--c-text-muted); font-size: 11px;
            pointer-events: none;
        }
        .search-input {
            padding: 7px 12px 7px 30px;
            border: 1px solid var(--c-border-strong);
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

        /* Filter chips */
        .filter-chips {
            display: flex; flex-wrap: wrap; gap: 6px;
            padding: 12px 22px;
            border-bottom: 1px solid var(--c-border);
            background: var(--c-surface-2);
        }
        .chip {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.7rem; font-weight: 600;
            border: 1px solid var(--c-border-strong);
            background: var(--c-surface);
            color: var(--c-text-muted);
            cursor: pointer;
            transition: background 0.12s, color 0.12s, border-color 0.12s;
        }
        .chip:hover  { border-color: var(--c-primary); color: var(--c-primary); }
        .chip.active { background: var(--c-primary); color: white; border-color: var(--c-primary); }

        /* Row hidden by filter */
        tr.row-hidden { display: none; }

        /* ── Pagination (model dashboard) ── */
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

        /* ── RESPONSIVE TAMBAHAN ── */
        @media (max-width: 575.98px) {
            .search-input {
                width: 100%;
            }
            .search-wrap {
                width: 100%;
            }
            .filter-chips {
                padding: 10px 14px;
                gap: 4px;
            }
            .chip {
                font-size: 0.65rem;
                padding: 3px 10px;
            }
            .paging-wrap {
                flex-direction: column;
                align-items: flex-start;
            }
            .page-btn {
                min-width: 28px;
                height: 28px;
                font-size: 0.7rem;
            }
            .surface-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>

<?php $this->load->view('user/sidebar'); ?>

<div class="page-wrapper">

    <header class="topnav">
        <div class="topnav-breadcrumb">
            <a href="<?= base_url('dashboard') ?>" style="color:var(--c-text-muted); text-decoration:none;"><i class="fas fa-home"></i></a>
            <i class="fas fa-chevron-right" style="font-size:8px;"></i>
            <strong><?= $this->lang->line('tka_breadcrumb') ?></strong>
        </div>
        <div class="topnav-actions">
            <a href="<?= base_url('user/upload') ?>" class="btn-primary" style="height:36px; padding:0 14px;">
                <i class="fas fa-plus"></i> <?= $this->lang->line('tka_upload_new') ?>
            </a>
        </div>
    </header>

    <main class="page-content">

        <div class="page-header" style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
            <div>
                <div class="page-title"><?= $this->lang->line('tka_page_heading') ?></div>
                <div class="page-subtitle"><?= $this->lang->line('tka_page_subtitle') ?></div>
            </div>
        </div>

        <div class="surface">
            <div class="surface-header">
                <div class="surface-title">
                    <i class="fas fa-layer-group"></i>
                    <?= $this->lang->line('tka_list_title') ?>
                    <?php if(!empty($tka)): ?>
                        <span style="background:var(--c-primary-light); color:var(--c-primary); padding:2px 8px; border-radius:20px; font-size:0.68rem;">
                            <?= count($tka) ?>
                        </span>
                    <?php endif; ?>
                </div>
                <div class="search-wrap">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" id="searchInput" placeholder="<?= $this->lang->line('tka_search_placeholder') ?>">
                </div>
            </div>

            <!-- Filter chips -->
            <?php if(!empty($tka)): ?>
            <div class="filter-chips">
                <div class="chip active" data-filter="all"><?= $this->lang->line('tka_filter_all') ?></div>
                <div class="chip" data-filter="DRAFT"><?= $this->lang->line('tka_filter_draft') ?></div>
                <div class="chip" data-filter="proses"><?= $this->lang->line('tka_filter_process') ?></div>
                <div class="chip" data-filter="SELESAI"><?= $this->lang->line('tka_filter_done') ?></div>
                <div class="chip" data-filter="DITOLAK"><?= $this->lang->line('tka_filter_rejected') ?></div>
            </div>
            <?php endif; ?>

            <?php if(empty($tka)): ?>
                <div class="empty-state">
                    <div class="empty-state-icon"><i class="fas fa-folder-open"></i></div>
                    <h4><?= $this->lang->line('tka_empty_title') ?></h4>
                    <p><?= $this->lang->line('tka_empty_message') ?></p>
                    <a href="<?= base_url('user/upload') ?>" class="btn-primary">
                        <i class="fas fa-plus"></i> <?= $this->lang->line('tka_empty_action') ?>
                    </a>
                </div>
            <?php else: ?>

            <?php
            $pp_map = [
                'DRAFT'           => 'pp-draft',
                'MENUNGGU_KASI'   => 'pp-kasi',
                'MENUNGGU_KABID'  => 'pp-kabid',
                'MENUNGGU_SEKDIS' => 'pp-sekdis',
                'MENUNGGU_KADIS'  => 'pp-kadis',
                'SELESAI'         => 'pp-selesai',
                'DITOLAK'         => 'pp-ditolak',
            ];
            $pp_label = [
                'DRAFT'           => $this->lang->line('tka_progress_draft'),
                'MENUNGGU_KASI'   => $this->lang->line('tka_progress_kasi'),
                'MENUNGGU_KABID'  => $this->lang->line('tka_progress_kabid'),
                'MENUNGGU_SEKDIS' => $this->lang->line('tka_progress_sekdis'),
                'MENUNGGU_KADIS'  => $this->lang->line('tka_progress_kadis'),
                'SELESAI'         => $this->lang->line('tka_progress_done'),
                'DITOLAK'         => $this->lang->line('tka_progress_rejected'),
            ];
            $proses_statuses = ['MENUNGGU_KASI','MENUNGGU_KABID','MENUNGGU_SEKDIS','MENUNGGU_KADIS'];
            ?>

                <!-- ═══════════ WRAPPER RESPONSIVE TABLE ═══════════ -->
                <div class="table-wrap table-responsive-card">
                    <table class="data-table" id="dataTkaTable">
                        <thead>
                            <tr>
                                <th class="cell-no"><?= $this->lang->line('tka_col_number') ?></th>
                                <th><?= $this->lang->line('tka_col_name') ?></th>
                                <th><?= $this->lang->line('tka_col_status') ?></th>
                                <th><?= $this->lang->line('tka_col_progress') ?></th>
                                <th><?= $this->lang->line('tka_col_date') ?></th>
                                <th><?= $this->lang->line('tka_col_action') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach($tka as $t):
                                $filterGroup = $t->status;
                                if(in_array($t->status, $proses_statuses)) $filterGroup = 'proses';
                            ?>
                            <tr data-status="<?= $filterGroup ?>" data-name="<?= strtolower(htmlspecialchars($t->nama_tka)) ?>">
                                <td class="cell-no"><?= $no++ ?></td>
                                <td class="cell-name" data-label="<?= $this->lang->line('tka_col_name') ?>"><?= htmlspecialchars($t->nama_tka) ?></td>
                                <td data-label="<?= $this->lang->line('tka_col_status') ?>">
                                    <?php if($t->status == 'DRAFT'): ?>
                                        <span class="badge badge-draft"><span class="badge-dot" style="background:#94a3b8;"></span><?= $this->lang->line('tka_status_draft') ?></span>
                                    <?php elseif(in_array($t->status, $proses_statuses)): ?>
                                        <span class="badge badge-proses"><span class="badge-dot" style="background:#3b82f6;"></span><?= $this->lang->line('tka_status_process') ?></span>
                                    <?php elseif($t->status == 'SELESAI'): ?>
                                        <span class="badge badge-selesai"><span class="badge-dot" style="background:#10b981;"></span><?= $this->lang->line('tka_status_done') ?></span>
                                    <?php elseif($t->status == 'DITOLAK'): ?>
                                        <span class="badge badge-ditolak"><span class="badge-dot" style="background:#f43f5e;"></span><?= $this->lang->line('tka_status_rejected') ?></span>
                                    <?php else: ?>
                                        <span class="badge badge-draft"><?= htmlspecialchars($t->status) ?></span>
                                    <?php endif; ?>
                                </td>
                                <td data-label="<?= $this->lang->line('tka_col_progress') ?>">
                                    <span class="progress-pill <?= $pp_map[$t->status] ?? 'pp-draft' ?>">
                                        <?= $pp_label[$t->status] ?? $t->status ?>
                                    </span>
                                </td>
                                <td data-label="<?= $this->lang->line('tka_col_date') ?>">
                                    <div class="cell-date-main"><?= date('d M Y', strtotime($t->created_at)) ?></div>
                                    <div class="cell-date-sub"><?= date('H:i', strtotime($t->created_at)) ?> <?= $this->lang->line('auth_wib') ?: 'WIB' ?></div>
                                </td>
                                <td class="cell-action" data-label="<?= $this->lang->line('tka_col_action') ?>">
                                    <div class="btn-row">
                                        <?php if($t->status == 'DRAFT'): ?>
                                            <a href="<?= base_url('user/detail/'.$t->id) ?>" class="btn-xs bx-detail"><i class="fas fa-eye"></i> <?= $this->lang->line('tka_btn_detail') ?></a>
                                            <a href="<?= base_url('user/detail_form/'.$t->id) ?>" class="btn-xs bx-lengkapi"><i class="fas fa-pen-fancy"></i> <?= $this->lang->line('tka_btn_complete') ?></a>
                                            <a href="<?= base_url('user/edit_tka/'.$t->id) ?>" class="btn-xs bx-ganti"><i class="fas fa-file-upload"></i> <?= $this->lang->line('tka_btn_replace') ?></a>
                                            <a href="<?= base_url('user/delete_tka/'.$t->id) ?>" class="btn-xs bx-delete" onclick="return confirm('<?= $this->lang->line('tka_confirm_delete') ?>')"><i class="fas fa-trash-alt"></i></a>
                                        <?php else: ?>
                                            <a href="<?= base_url('user/detail/'.$t->id) ?>" class="btn-xs bx-detail"><i class="fas fa-eye"></i> <?= $this->lang->line('tka_btn_detail') ?></a>
                                            <?php if($t->status == 'MENUNGGU_KASI'): ?>
                                                <a href="<?= base_url('user/edit_tka/'.$t->id) ?>" class="btn-xs bx-edit"><i class="fas fa-edit"></i> <?= $this->lang->line('tka_btn_edit') ?></a>
                                            <?php endif; ?>
                                            <?php if($t->status == 'DITOLAK'): ?>
                                                <a href="<?= base_url('user/perbaiki_tka/'.$t->id) ?>" class="btn-xs bx-edit"><i class="fas fa-wrench"></i> <?= $this->lang->line('tka_btn_fix') ?></a>
                                            <?php endif; ?>
                                            <?php if($t->status == 'SELESAI'): ?>
                                                <a href="<?= base_url('user/download_surat_word/'.$t->id) ?>" class="btn-xs bx-surat" target="_blank"><i class="fas fa-download"></i> <?= $this->lang->line('tka_btn_letter') ?></a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="paging-wrap" id="pagingWrap">
                    <div class="paging-info" id="pagingInfo">—</div>
                    <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
                        <div class="per-page-wrap">
                            <span><?= $this->lang->line('tka_show') ?></span>
                            <select class="per-page-select" id="perPageSelect">
                                <option value="10" selected>10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                            <span><?= $this->lang->line('tka_per_page') ?></span>
                        </div>
                        <div class="paging-controls" id="pagingControls"></div>
                    </div>
                </div>

                <!-- no-result -->
                <div id="noResult" style="display:none; padding:40px; text-align:center; color:var(--c-text-muted); font-size:0.82rem;">
                    <i class="fas fa-search" style="font-size:1.5rem; margin-bottom:10px; display:block;"></i>
                    <?= $this->lang->line('tka_no_match') ?>
                </div>

            <?php endif; ?>
        </div>

    </main>
</div>

<?php $this->load->view('footer'); ?>

<script>
    var lang_tka_showing = "<?= $this->lang->line('tka_showing') ?>";
    var lang_tka_of_submissions = "<?= $this->lang->line('tka_of_submissions') ?>";
    var lang_tka_zero = "<?= $this->lang->line('tka_zero') ?>";

// ─── Filter, Search, dan Pagination ─────────────────
(function(){
    let perPage = 10;
    let activeFilter = 'all';
    let searchVal    = '';
    let currentPage  = 1;

    const tableBody     = document.querySelector('#dataTkaTable tbody');
    if (!tableBody) return;
    const allRows       = Array.from(tableBody.querySelectorAll('tr'));
    const pagingInfo    = document.getElementById('pagingInfo');
    const pagingControls = document.getElementById('pagingControls');
    const perPageSelect  = document.getElementById('perPageSelect');
    const noResultEl     = document.getElementById('noResult');

    function getFilteredRows() {
        return allRows.filter(row => !row.classList.contains('row-hidden'));
    }

    function showPage(page) {
        const rows = getFilteredRows();
        const total = rows.length;
        const totalPages = Math.ceil(total / perPage) || 1;

        if (page < 1) page = 1;
        if (page > totalPages) page = totalPages;
        currentPage = page;

        const start = (currentPage - 1) * perPage;
        const end   = Math.min(currentPage * perPage, total);

        // Sembunyikan semua dulu, lalu tampilkan hanya yang di halaman ini
        allRows.forEach(r => r.style.display = 'none');
        rows.forEach((row, idx) => {
            if (idx >= start && idx < end) {
                row.style.display = '';
            }
        });

        pagingInfo.innerHTML = total > 0
            ? lang_tka_showing + ' <strong>' + (start+1) + '–' + end + '</strong> dari <strong>' + total + '</strong> ' + lang_tka_of_submissions
            : lang_tka_zero;

        renderPagingControls(totalPages);
    }

    function renderPagingControls(totalPages) {
        pagingControls.innerHTML = '';

        if (totalPages <= 1) return;

        const prevBtn = document.createElement('button');
        prevBtn.className = 'page-btn';
        prevBtn.innerHTML = '<i class="fas fa-chevron-left" style="font-size:10px;"></i>';
        prevBtn.disabled = (currentPage === 1);
        prevBtn.addEventListener('click', () => showPage(currentPage - 1));
        pagingControls.appendChild(prevBtn);

        let startP = Math.max(1, currentPage - 2);
        let endP = Math.min(totalPages, startP + 4);
        startP = Math.max(1, endP - 4);

        if (startP > 1) {
            pagingControls.appendChild(makePageBtn(1));
            if (startP > 2) pagingControls.appendChild(makeDots());
        }
        for (let i = startP; i <= endP; i++) {
            pagingControls.appendChild(makePageBtn(i));
        }
        if (endP < totalPages) {
            if (endP < totalPages - 1) pagingControls.appendChild(makeDots());
            pagingControls.appendChild(makePageBtn(totalPages));
        }

        const nextBtn = document.createElement('button');
        nextBtn.className = 'page-btn';
        nextBtn.innerHTML = '<i class="fas fa-chevron-right" style="font-size:10px;"></i>';
        nextBtn.disabled = (currentPage === totalPages);
        nextBtn.addEventListener('click', () => showPage(currentPage + 1));
        pagingControls.appendChild(nextBtn);
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

    function applyFiltersAndSearch() {
        allRows.forEach(row => {
            const status = row.dataset.status || '';
            const name   = row.dataset.name || '';

            const passFilter = (activeFilter === 'all') || (status === activeFilter);
            const passSearch = (searchVal === '') || (name.indexOf(searchVal) !== -1);

            row.classList.toggle('row-hidden', !(passFilter && passSearch));
        });

        const visibleRows = getFilteredRows();
        if (noResultEl) {
            noResultEl.style.display = (visibleRows.length === 0) ? 'block' : 'none';
        }

        showPage(1);
    }

    // Filter chips
    document.querySelectorAll('.chip').forEach(chip => {
        chip.addEventListener('click', function() {
            document.querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            activeFilter = this.dataset.filter;
            applyFiltersAndSearch();
        });
    });

    // Search input
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            searchVal = this.value.toLowerCase().trim();
            applyFiltersAndSearch();
        });
    }

    // Per-page select
    perPageSelect.addEventListener('change', function() {
        perPage = parseInt(this.value);
        applyFiltersAndSearch();
    });

    // Init
    if (allRows.length > 0) {
        applyFiltersAndSearch();
    }
})();
</script>
</body>
</html>