<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Bulanan — SITLAKEB TKA Admin</title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/shared.css') ?>">

    <style>
        /* ============================================================
           LAPORAN BULANAN
        ============================================================ */

        /* ── Tombol hamburger (mobile only) ───────────────────── */
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

        /* Tampilkan hamburger di mobile */
        @media (max-width: 768px) {
            .topnav-burger { display: flex; }
        }

        /* ── Layout utama (desktop: 2 kolom, mobile: 1 kolom) ─── */
        .laporan-grid {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 20px;
            align-items: start;
        }

        /* ── Period preview badge ─────────────────────────────── */
        .period-preview {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--c-primary-light);
            color: var(--c-primary);
            border-radius: 20px;
            padding: 4px 12px;
            font-size: 0.73rem;
            font-weight: 700;
            transition: all 0.2s;
            white-space: nowrap;
        }

        /* ── Quick pick buttons ───────────────────────────────── */
        .quick-picks-label {
            padding: 10px 20px 0;
            font-size: 0.63rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: var(--c-text-muted);
        }

        .quick-picks {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
            padding: 8px 20px 14px;
            border-bottom: 1px solid var(--c-border);
        }

        .qpick {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.69rem;
            font-weight: 700;
            background: var(--c-surface-2);
            color: var(--c-text-muted);
            border: 1px solid var(--c-border);
            cursor: pointer;
            transition: all 0.15s;
            user-select: none;
            font-family: var(--font-body);
        }

        .qpick:hover,
        .qpick.active {
            background: var(--c-primary-light);
            color: var(--c-primary);
            border-color: #a7d9cf;
        }

        /* ── Form row: 2 kolom ────────────────────────────────── */
        .form-row-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            border-bottom: 1px solid var(--c-border);
        }

        .fr-cell {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 16px 20px;
        }

        .fr-cell:first-child {
            border-right: 1px solid var(--c-border);
        }

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

        .form-field { flex: 1; }

        .f-label-sm {
            display: block;
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            color: var(--c-text-muted);
            margin-bottom: 5px;
        }

        /* Select field */
        .select-clean {
            width: 100%;
            font-family: var(--font-body);
            font-size: 0.84rem;
            font-weight: 500;
            color: var(--c-text);
            background: var(--c-surface);
            border: 1px solid var(--c-border);
            border-radius: var(--r-sm);
            padding: 7px 30px 7px 11px;
            outline: none;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center;
            transition: border-color 0.15s, box-shadow 0.15s;
            -webkit-appearance: none;
        }

        .select-clean:focus {
            border-color: var(--c-primary);
            box-shadow: 0 0 0 3px var(--c-primary-glow);
        }

        /* ── Form actions ─────────────────────────────────────── */
        .form-actions {
            padding: 14px 20px;
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
        }

        /* ── Info card items ──────────────────────────────────── */
        .info-item {
            display: flex;
            gap: 8px;
            margin-bottom: 8px;
            font-size: 0.78rem;
            color: var(--c-text-muted);
            line-height: 1.6;
        }

        .info-item:last-child { margin-bottom: 0; }

        .info-item i {
            color: #10b981;
            margin-top: 3px;
            font-size: 10px;
            flex-shrink: 0;
        }

        /* ── Periode aktif card ───────────────────────────────── */
        .period-card-body {
            padding: 20px;
            text-align: center;
        }

        .period-month {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--c-text);
            line-height: 1.2;
        }

        .period-year {
            font-size: 1rem;
            font-weight: 600;
            color: var(--c-primary);
            margin-top: 2px;
        }

        .period-ready {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: var(--c-primary-light);
            color: var(--c-primary);
            border-radius: 20px;
            padding: 4px 14px;
            font-size: 0.7rem;
            font-weight: 700;
            margin-top: 12px;
        }

        /* ── RESPONSIVE ───────────────────────────────────────── */
        @media (max-width: 900px) {
            .laporan-grid {
                grid-template-columns: 1fr;
                gap: 14px;
            }

            /* Kolom kanan (info + periode aktif) naik ke bawah form */
        }

        @media (max-width: 580px) {
            .page-content { padding: 14px 12px 32px; }

            .form-row-2 {
                grid-template-columns: 1fr;
            }

            .fr-cell:first-child {
                border-right: none;
                border-bottom: 1px solid var(--c-border);
            }

            /* Select cegah iOS zoom */
            .select-clean { font-size: 16px; }

            .quick-picks { padding: 8px 14px 12px; }
            .quick-picks-label { padding: 10px 14px 0; }

            .fr-cell { padding: 14px; }
            .form-actions { padding: 12px 14px; }
            .form-actions .btn-primary,
            .form-actions .btn-secondary { flex: 1; justify-content: center; }

            .surface-header { padding: 11px 14px; }
        }
    </style>
</head>
<body>

<?php $this->load->view('admin/sidebar'); ?>

<div class="page-wrapper">

    <!-- ── Topnav ───────────────────────────────────────────── -->
    <header class="topnav">
        <div class="topnav-breadcrumb">
            <!-- Hamburger — tampil di mobile, tersembunyi di desktop -->
            <button class="topnav-burger" id="sidebarBurger" aria-label="Buka Menu">
                <i class="fas fa-bars"></i>
            </button>

            <a href="<?= base_url('admin/dashboard') ?>"
               style="color:var(--c-text-muted);text-decoration:none;">
                <i class="fas fa-home"></i>
            </a>
            <i class="fas fa-chevron-right" style="font-size:8px;"></i>
            <strong>Laporan Bulanan</strong>
        </div>
        <div class="topnav-actions">
            <a href="<?= base_url('admin/dashboard') ?>" class="btn-secondary"
               style="height:34px;padding:0 12px;font-size:0.78rem;">
                <i class="fas fa-arrow-left"></i>
                <span class="btn-label-desktop">Kembali</span>
            </a>
        </div>
    </header>

    <main class="page-content">

        <!-- Page heading -->
        <div class="page-header">
            <div class="page-title">
                <i class="fas fa-chart-line" style="color:var(--c-primary);margin-right:8px;"></i>
                Cetak Laporan Bulanan
            </div>
            <div class="page-subtitle">
                Pilih periode dan cetak laporan pengajuan TKA dalam format PDF.
            </div>
        </div>

        <div class="laporan-grid">

            <!-- ════════════════════════════════════════
                 KOLOM KIRI: Form pilih periode
            ════════════════════════════════════════ -->
            <div>
                <div class="surface">
                    <div class="surface-header">
                        <div class="surface-title">
                            <i class="fas fa-calendar-days" style="color:#3b82f6;"></i>
                            Pilih Periode Laporan
                        </div>
                        <span class="period-preview" id="periodPreview">
                            <i class="fas fa-calendar-check" style="font-size:9px;"></i>
                            <span id="previewText"><?= date('F Y') ?></span>
                        </span>
                    </div>

                    <!-- Quick picks -->
                    <div class="quick-picks-label">Pilih Cepat</div>
                    <div class="quick-picks" id="quickPicks">
                        <?php
                        $bulanIndo = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                        for($i = 0; $i < 4; $i++):
                            $ts    = mktime(0, 0, 0, date('m') - $i, 1, date('Y'));
                            $bNum  = date('n', $ts);
                            $tNum  = date('Y', $ts);
                            $label = $bulanIndo[$bNum] . ' ' . $tNum;
                        ?>
                        <button type="button" class="qpick <?= $i === 0 ? 'active' : '' ?>"
                                data-bulan="<?= $bNum ?>" data-tahun="<?= $tNum ?>">
                            <?= $label ?>
                        </button>
                        <?php endfor; ?>
                    </div>

                    <form action="<?= base_url('admin/laporan_bulanan') ?>"
                          method="get" target="_blank" id="formLaporan">

                        <!-- Bulan + Tahun (2 kolom desktop, 1 kolom mobile) -->
                        <div class="form-row-2">
                            <div class="fr-cell">
                                <div class="form-icon"><i class="fas fa-calendar-alt"></i></div>
                                <div class="form-field">
                                    <label class="f-label-sm" for="bulan">Bulan</label>
                                    <select id="bulan" name="bulan" class="select-clean">
                                        <?php for($i = 1; $i <= 12; $i++): ?>
                                        <option value="<?= $i ?>" <?= ($i == date('n')) ? 'selected' : '' ?>>
                                            <?= $bulanIndo[$i] ?>
                                        </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="fr-cell">
                                <div class="form-icon" style="background:#eff6ff;color:#3b82f6;">
                                    <i class="fas fa-calendar"></i>
                                </div>
                                <div class="form-field">
                                    <label class="f-label-sm" for="tahun">Tahun</label>
                                    <select id="tahun" name="tahun" class="select-clean">
                                        <?php for($i = date('Y'); $i >= 2020; $i--): ?>
                                        <option value="<?= $i ?>" <?= ($i == date('Y')) ? 'selected' : '' ?>>
                                            <?= $i ?>
                                        </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol aksi -->
                        <div class="form-actions">
                            <button type="submit" class="btn-primary"
                                    style="border:none;cursor:pointer;justify-content:center;">
                                <i class="fas fa-print"></i> Cetak PDF
                            </button>
                            <a href="<?= base_url('admin/laporan') ?>"
                               class="btn-secondary" style="justify-content:center;">
                                <i class="fas fa-rotate-left"></i> Reset
                            </a>
                        </div>

                    </form>
                </div>
            </div><!-- /kolom kiri -->

            <!-- ════════════════════════════════════════
                 KOLOM KANAN: Info + Periode aktif
            ════════════════════════════════════════ -->
            <div>

                <!-- Info -->
                <div class="surface" style="margin-bottom:14px;">
                    <div class="surface-header">
                        <div class="surface-title">
                            <i class="fas fa-lightbulb" style="color:#f59e0b;"></i>
                            Panduan
                        </div>
                    </div>
                    <div style="padding:14px 18px;">
                        <div class="info-item">
                            <i class="fas fa-circle-check"></i>
                            <span>Laporan berisi seluruh pengajuan TKA pada bulan yang dipilih.</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-circle-check"></i>
                            <span>PDF akan terbuka di tab baru dan siap untuk dicetak.</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-circle-check"></i>
                            <span>Gunakan <strong>Pilih Cepat</strong> untuk memilih bulan-bulan terakhir.</span>
                        </div>
                    </div>
                </div>

                <!-- Periode aktif -->
                <div class="surface">
                    <div class="surface-header">
                        <div class="surface-title">
                            <i class="fas fa-calendar-check" style="color:var(--c-primary);"></i>
                            Periode Dipilih
                        </div>
                    </div>
                    <div class="period-card-body">
                        <div class="period-month" id="bigPreview"><?= date('F') ?></div>
                        <div class="period-year"  id="bigYear"><?= date('Y') ?></div>
                        <div class="period-ready">
                            <i class="fas fa-file-pdf" style="font-size:10px;"></i>
                            Siap Cetak
                        </div>
                    </div>
                </div>

            </div><!-- /kolom kanan -->

        </div><!-- /laporan-grid -->

    </main>

    <?php $this->load->view('footer'); ?>
</div>

<style>
/* Sembunyikan label "Kembali" di mobile agar tombol tidak terlalu lebar */
@media (max-width: 480px) {
    .btn-label-desktop { display: none; }
}
</style>

<script>
(function(){
    var bulanSel   = document.getElementById('bulan');
    var tahunSel   = document.getElementById('tahun');
    var previewTxt = document.getElementById('previewText');
    var bigPreview = document.getElementById('bigPreview');
    var bigYear    = document.getElementById('bigYear');
    var qpicks     = document.querySelectorAll('.qpick');

    var bulanIndo = ['','Januari','Februari','Maret','April','Mei','Juni',
                     'Juli','Agustus','September','Oktober','November','Desember'];

    function updatePreview() {
        var b     = parseInt(bulanSel.value);
        var t     = tahunSel.value;
        var label = bulanIndo[b] + ' ' + t;

        previewTxt.textContent = label;
        bigPreview.textContent = bulanIndo[b];
        bigYear.textContent    = t;

        /* Sync highlight quick pick */
        qpicks.forEach(function(q) {
            var qb = parseInt(q.getAttribute('data-bulan'));
            var qt = q.getAttribute('data-tahun');
            q.classList.toggle('active', qb === b && qt === t);
        });
    }

    bulanSel.addEventListener('change', updatePreview);
    tahunSel.addEventListener('change', updatePreview);

    /* Klik quick pick */
    qpicks.forEach(function(q) {
        q.addEventListener('click', function() {
            bulanSel.value = q.getAttribute('data-bulan');
            tahunSel.value = q.getAttribute('data-tahun');
            updatePreview();
        });
    });

    /* ── Hamburger — buka sidebar di mobile ──────────────── */
    var burger = document.getElementById('sidebarBurger');
    if (burger) {
        burger.addEventListener('click', function(e) {
            e.stopPropagation();
            /* Coba hook ke fungsi sidebar yang sudah ada di shared */
            if (typeof window.openAdminSidebar === 'function') {
                window.openAdminSidebar();
                return;
            }
            /* Fallback: toggle class mobile-open pada sidebar */
            var sidebar = document.getElementById('mainSidebar');
            if (sidebar) {
                sidebar.classList.toggle('mobile-open');
                /* Buat overlay jika belum ada */
                var overlay = document.getElementById('sidebarOverlay');
                if (!overlay) {
                    overlay = document.createElement('div');
                    overlay.id = 'sidebarOverlay';
                    overlay.style.cssText = 'position:fixed;inset:0;background:rgba(0,0,0,0.45);z-index:998;';
                    overlay.addEventListener('click', function() {
                        sidebar.classList.remove('mobile-open');
                        overlay.remove();
                    });
                    document.body.appendChild(overlay);
                } else {
                    overlay.remove();
                }
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
        toggleBtn.addEventListener('click', function() {
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