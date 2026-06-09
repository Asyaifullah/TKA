<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan SLA — Admin TKA</title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/shared.css') ?>">
    <style>

        /* ── Burger (mobile only, di dalam topnav) ── */
        .topnav-burger {
            display: none;
            width: 34px; height: 34px;
            border-radius: 9px;
            border: 1px solid var(--c-border);
            background: var(--c-surface-2, #f8fafc);
            align-items: center; justify-content: center;
            color: var(--c-text-muted); font-size: 13px;
            cursor: pointer; flex-shrink: 0;
            transition: background .15s, color .15s;
        }
        .topnav-burger:hover { background: var(--c-primary-light); color: var(--c-primary); }

        /* ── Input ── */
        .form-control {
            border: 1px solid var(--c-border-strong) !important;
            border-radius: var(--r-md) !important;
            background: var(--c-surface) !important;
            font-family: var(--font-body) !important;
            font-size: 0.83rem !important;
            color: var(--c-text) !important;
            box-shadow: none !important;
            transition: border-color 0.15s, box-shadow 0.15s;
            padding: 8px 12px;
        }
        .form-control:focus {
            border-color: var(--c-primary) !important;
            box-shadow: 0 0 0 3px var(--c-primary-glow) !important;
            background: #fff !important;
        }
        .form-control::placeholder { color: #c0ccd8; }

        /* ── Page hero ── */
        .page-hero {
            background: linear-gradient(135deg, #1a6b52 0%, #22896a 100%);
            border-radius: 16px;
            padding: 20px 24px;
            margin-bottom: 20px;
            display: flex; align-items: center; gap: 16px;
            position: relative; overflow: hidden;
        }
        .page-hero::before {
            content: ''; position: absolute;
            top: -30px; right: -30px;
            width: 140px; height: 140px; border-radius: 50%;
            background: rgba(255,255,255,0.06);
        }
        .page-hero-icon {
            width: 48px; height: 48px; border-radius: 14px;
            background: rgba(255,255,255,0.18);
            border: 1px solid rgba(255,255,255,0.25);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; color: white; flex-shrink: 0; z-index: 1;
        }
        .page-hero-info { z-index: 1; }
        .page-hero-title { font-size: 1rem; font-weight: 800; color: white; margin-bottom: 2px; }
        .page-hero-sub   { font-size: 0.74rem; color: rgba(255,255,255,0.75); line-height: 1.5; }

        /* ── Summary cards ── */
        .sla-summary {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 16px;
        }
        .summary-card {
            background: var(--c-surface);
            border: 1px solid var(--c-border);
            border-radius: var(--r-lg);
            padding: 14px 16px;
            display: flex; align-items: center; gap: 12px;
        }
        .summary-icon {
            width: 38px; height: 38px;
            border-radius: var(--r-md);
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; flex-shrink: 0;
        }
        .summary-label { font-size: 0.68rem; color: var(--c-text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em; }
        .summary-value { font-family: var(--font-head); font-size: 1rem; font-weight: 800; color: var(--c-text); }

        /* ── Info strip ── */
        .info-strip {
            display: flex; gap: 10px; align-items: flex-start;
            border-radius: var(--r-md); padding: 12px 16px;
            font-size: 0.79rem; margin-bottom: 16px;
        }
        .info-strip.success { background: #ecfdf5; border: 1px solid #a7f3d0; border-left: 4px solid #10b981; color: #065f46; }
        .info-strip.danger  { background: #fff1f2; border: 1px solid #fecdd3; border-left: 4px solid #f43f5e; color: #9f1239; }
        .info-strip.info    { background: #eff6ff; border: 1px solid #bfdbfe; border-left: 4px solid #3b82f6; color: #1e40af; }

        /* ── SLA cards ── */
        .sla-cards { display: flex; flex-direction: column; gap: 12px; padding: 20px 22px; }

        .sla-card {
            display: grid;
            grid-template-columns: 44px 1fr 1fr 1fr;
            align-items: center;
            gap: 16px;
            background: var(--c-surface-2);
            border: 1px solid var(--c-border);
            border-radius: var(--r-lg);
            padding: 16px 18px;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .sla-card:hover { border-color: var(--c-border-strong); box-shadow: var(--shadow-sm); }

        /* Level badge */
        .level-badge {
            width: 44px; height: 44px;
            border-radius: var(--r-md);
            display: flex; align-items: center; justify-content: center;
            flex-direction: column;
            font-family: var(--font-head); flex-shrink: 0;
        }
        .level-badge .lv-num  { font-size: 1.1rem; font-weight: 800; line-height: 1; }
        .level-badge .lv-text { font-size: 0.52rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; opacity: 0.75; }
        .lv-1 { background: #fff7ed; color: #c2410c; }
        .lv-2 { background: #eff6ff; color: #1e40af; }
        .lv-3 { background: #f5f3ff; color: #5b21b6; }
        .lv-4 { background: #ecfdf5; color: #065f46; }

        /* Role info */
        .role-info .role-name { font-family: var(--font-head); font-size: 0.88rem; font-weight: 700; color: var(--c-text); margin-bottom: 2px; }
        .role-info .role-desc { font-size: 0.68rem; color: var(--c-text-muted); }

        /* Input group */
        .sla-field-wrap { display: flex; flex-direction: column; gap: 4px; }
        .sla-field-label { font-size: 0.68rem; font-weight: 700; color: var(--c-text-muted); text-transform: uppercase; letter-spacing: 0.05em; }
        .sla-input-row { display: flex; align-items: center; gap: 8px; }
        .sla-input-row .form-control { width: 100px; text-align: center; font-weight: 600; }
        .sla-unit { font-size: 0.72rem; color: var(--c-text-muted); white-space: nowrap; }
        .sla-hint { font-size: 0.67rem; color: var(--c-text-muted); margin-top: 3px; }

        /* Form footer */
        .form-footer {
            display: flex; align-items: center; justify-content: space-between;
            flex-wrap: wrap; gap: 12px;
            padding: 16px 22px;
            border-top: 1px solid var(--c-border);
            background: var(--c-surface-2);
        }
        .form-footer-note { font-size: 0.72rem; color: var(--c-text-muted); display: flex; align-items: center; gap: 6px; }

        /* Legend */
        .legend-row {
            display: flex; gap: 20px; flex-wrap: wrap;
            padding: 14px 22px;
            border-top: 1px solid var(--c-border);
            background: var(--c-surface-2);
        }
        .legend-item { display: flex; align-items: center; gap: 7px; font-size: 0.73rem; color: var(--c-text-muted); }
        .legend-dot  { width: 8px; height: 8px; border-radius: 50%; }

        /* ──────────────────────────────────────
           RESPONSIVE MOBILE (≤ 768px)
        ────────────────────────────────────── */
        @media (max-width: 768px) {

            /* topnav */
            .topnav { padding: 0 12px !important; }
            .topnav-burger { display: flex; }
            /* sembunyikan breadcrumb tengah agar tidak overflow */
            .topnav-breadcrumb .bc-mid { display: none; }

            /* page content */
            .page-content { padding: 12px !important; }

            /* hero */
            .page-hero { padding: 16px; border-radius: 14px; margin-bottom: 14px; gap: 12px; }
            .page-hero-icon  { width: 42px; height: 42px; font-size: 1.1rem; border-radius: 12px; }
            .page-hero-title { font-size: 0.9rem; }
            .page-hero-sub   { font-size: 0.72rem; }

            /* info strip */
            .info-strip { font-size: 0.76rem; padding: 11px 14px; border-radius: 12px; margin-bottom: 14px; }

            /* summary: 2x2 */
            .sla-summary { grid-template-columns: repeat(2, 1fr); gap: 10px; margin-bottom: 14px; }
            .summary-card { padding: 12px 14px; border-radius: 14px; gap: 10px; }
            .summary-icon { width: 34px; height: 34px; font-size: 13px; }
            .summary-label { font-size: 0.64rem; }
            .summary-value { font-size: 0.92rem; }

            /* surface */
            .surface { border-radius: 14px !important; }
            .surface-header { padding: 12px 16px !important; }
            .surface-title  { font-size: 0.82rem !important; }

            /* sla cards: 2 kolom (badge + info) di atas, input di bawah */
            .sla-cards { padding: 14px 14px; gap: 10px; }
            .sla-card {
                grid-template-columns: 40px 1fr !important;
                grid-template-rows: auto auto !important;
                gap: 10px 12px !important;
                padding: 14px 14px !important;
                border-radius: 14px !important;
            }

            /* badge: baris 1 kol 1 */
            .level-badge { width: 40px !important; height: 40px !important; grid-column: 1; grid-row: 1; }
            .level-badge .lv-num { font-size: 1rem !important; }

            /* role-info: baris 1 kol 2 */
            .role-info { grid-column: 2; grid-row: 1; }
            .role-info .role-name { font-size: 0.83rem !important; }
            .role-info .role-desc { font-size: 0.65rem !important; }

            /* inputs: baris 2, full width, flex row */
            .sla-inputs-row {
                grid-column: 1 / -1 !important;
                grid-row: 2 !important;
                display: flex !important;
                gap: 12px !important;
                flex-wrap: wrap !important;
            }
            .sla-field-wrap { flex: 1; min-width: 120px; }
            .sla-field-label { font-size: 0.65rem !important; }
            .sla-input-row .form-control { width: 80px !important; font-size: 16px !important; }
            .sla-hint { font-size: 0.63rem !important; }

            /* form footer: stack vertikal */
            .form-footer { flex-direction: column; align-items: stretch; padding: 14px 16px; gap: 10px; }
            .form-footer-note { font-size: 0.7rem; }
            .form-footer .btn-group { display: flex; gap: 8px; }
            .btn-primary, .btn-secondary {
                flex: 1 !important;
                justify-content: center !important;
                height: 44px !important;
                font-size: 0.86rem !important;
                border-radius: 12px !important;
            }

            /* legend */
            .legend-row { padding: 12px 16px; gap: 12px; }
            .legend-item { font-size: 0.7rem; }
            .legend-item:last-child { margin-left: 0 !important; }
        }

        @media (max-width: 400px) {
            .page-content { padding: 10px !important; }
            .sla-summary { gap: 8px; }
            .sla-field-wrap { min-width: 100px; }
        }
    </style>
</head>
<body>

<?php $this->load->view('admin/sidebar'); ?>

<div class="page-wrapper">

    <header class="topnav">
        <div class="topnav-breadcrumb">
            <!-- Burger terintegrasi di topnav, mobile only -->
            <button class="topnav-burger" id="adminBurger" aria-label="Buka Menu">
                <i class="fas fa-bars"></i>
            </button>
            <a href="<?= base_url('dashboard') ?>" style="color:var(--c-text-muted);text-decoration:none;">
                <i class="fas fa-home"></i>
            </a>
            <i class="fas fa-chevron-right bc-mid" style="font-size:8px;"></i>
            <span class="bc-mid" style="color:var(--c-text-muted);">Pengaturan</span>
            <i class="fas fa-chevron-right" style="font-size:8px;"></i>
            <strong>SLA Approval</strong>
        </div>
        <div class="topnav-actions"></div>
    </header>

    <main class="page-content">

        <!-- Page hero -->
        <div class="page-hero">
            <div class="page-hero-icon"><i class="fas fa-clock"></i></div>
            <div class="page-hero-info">
                <div class="page-hero-title">Service Level Agreement (SLA)</div>
                <div class="page-hero-sub">Tentukan batas waktu dan pengingat untuk setiap level persetujuan TKA.</div>
            </div>
        </div>

        <!-- Flash messages -->
        <?php if($this->session->flashdata('success')): ?>
        <div class="info-strip success">
            <i class="fas fa-check-circle" style="flex-shrink:0;margin-top:1px;"></i>
            <span><?= $this->session->flashdata('success') ?></span>
        </div>
        <?php endif; ?>
        <?php if($this->session->flashdata('error')): ?>
        <div class="info-strip danger">
            <i class="fas fa-exclamation-circle" style="flex-shrink:0;margin-top:1px;"></i>
            <span><?= $this->session->flashdata('error') ?></span>
        </div>
        <?php endif; ?>

        <!-- Info strip -->
        <div class="info-strip info">
            <i class="fas fa-info-circle" style="flex-shrink:0;margin-top:1px;"></i>
            <span>
                <strong>Cara kerja SLA:</strong> Sistem menghitung mundur dari saat pengajuan masuk ke setiap level.
                Jika melewati <em>deadline</em>, admin mendapat peringatan. Reminder dikirim sebelum deadline tercapai.
            </span>
        </div>

        <?php
        $level_config = [
            1 => ['name'=>'Kepala Seksi',    'short'=>'Kasi',   'icon'=>'fa-user-check',  'cls'=>'lv-1', 'bg'=>'#fff7ed', 'color'=>'#c2410c'],
            2 => ['name'=>'Kepala Bidang',   'short'=>'Kabid',  'icon'=>'fa-user-tie',    'cls'=>'lv-2', 'bg'=>'#eff6ff', 'color'=>'#1e40af'],
            3 => ['name'=>'Sekretaris Dinas','short'=>'Sekdis', 'icon'=>'fa-user-shield', 'cls'=>'lv-3', 'bg'=>'#f5f3ff', 'color'=>'#5b21b6'],
            4 => ['name'=>'Kepala Dinas',    'short'=>'Kadis',  'icon'=>'fa-user-crown',  'cls'=>'lv-4', 'bg'=>'#ecfdf5', 'color'=>'#065f46'],
        ];
        $sla_map = [];
        foreach($sla_list as $s) $sla_map[$s->level] = $s;
        ?>

        <!-- Summary cards -->
        <div class="sla-summary">
            <?php foreach($level_config as $lv => $cfg): ?>
            <?php $s = $sla_map[$lv] ?? null; ?>
            <div class="summary-card">
                <div class="summary-icon" style="background:<?= $cfg['bg'] ?>;color:<?= $cfg['color'] ?>;">
                    <i class="fas <?= $cfg['icon'] ?>"></i>
                </div>
                <div>
                    <div class="summary-label"><?= $cfg['short'] ?></div>
                    <div class="summary-value" id="summary-val-<?= $lv ?>"><?= $s ? $s->sla_jam.'j' : '—' ?></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Main form -->
        <div class="surface">
            <div class="surface-header">
                <div class="surface-title">
                    <i class="fas fa-sliders-h"></i>
                    Konfigurasi per Level
                </div>
                <span style="font-size:0.72rem;color:var(--c-text-muted);">
                    <i class="fas fa-circle" style="font-size:7px;color:#10b981;"></i>
                    Berlaku untuk pengajuan berikutnya
                </span>
            </div>

            <form action="<?= base_url('admin/update_sla') ?>" method="post" id="slaForm">
                <?= form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>

                <div class="sla-cards">
                    <?php foreach($level_config as $lv => $cfg): ?>
                    <?php $s = $sla_map[$lv] ?? null; ?>

                    <div class="sla-card" id="sla-card-<?= $lv ?>">

                        <!-- Level badge -->
                        <div class="level-badge <?= $cfg['cls'] ?>">
                            <span class="lv-num"><?= $lv ?></span>
                            <span class="lv-text">LVL</span>
                        </div>

                        <!-- Role info -->
                        <div class="role-info">
                            <div class="role-name">
                                <i class="fas <?= $cfg['icon'] ?>" style="font-size:11px;margin-right:5px;opacity:0.6;"></i>
                                <?= $cfg['name'] ?>
                            </div>
                            <div class="role-desc">Level <?= $lv ?> dari 4 tahap persetujuan</div>
                        </div>

                        <!-- Inputs: dibungkus div khusus untuk mobile layout -->
                        <div class="sla-inputs-row">

                            <!-- Deadline -->
                            <div class="sla-field-wrap">
                                <div class="sla-field-label">
                                    <i class="fas fa-stopwatch" style="font-size:9px;"></i> Deadline
                                </div>
                                <div class="sla-input-row">
                                    <input type="number"
                                           name="sla_jam_<?= $lv ?>"
                                           value="<?= $s ? $s->sla_jam : '' ?>"
                                           class="form-control"
                                           min="1" required
                                           placeholder="24"
                                           oninput="updateSummary(<?= $lv ?>, this.value)">
                                    <span class="sla-unit">jam</span>
                                </div>
                                <div class="sla-hint" id="hint-<?= $lv ?>">
                                    <?php if($s && $s->sla_jam): ?>
                                    ≈ <?= round($s->sla_jam / 24, 1) ?> hari kerja
                                    <?php else: ?>
                                    &nbsp;
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Reminder -->
                            <div class="sla-field-wrap">
                                <div class="sla-field-label">
                                    <i class="fas fa-bell" style="font-size:9px;"></i> Reminder
                                </div>
                                <div class="sla-input-row">
                                    <input type="number"
                                           name="reminder_jam_<?= $lv ?>"
                                           value="<?= $s ? $s->reminder_jam : '' ?>"
                                           class="form-control"
                                           min="0"
                                           placeholder="—">
                                    <span class="sla-unit">jam</span>
                                </div>
                                <div class="sla-hint">Kosongkan = tanpa pengingat</div>
                            </div>

                        </div><!-- /sla-inputs-row -->

                    </div><!-- /sla-card -->
                    <?php endforeach; ?>
                </div>

                <!-- Form footer -->
                <div class="form-footer">
                    <div class="form-footer-note">
                        <i class="fas fa-shield-alt" style="color:var(--c-primary);"></i>
                        Perubahan dicatat dalam log sistem
                    </div>
                    <div class="btn-group" style="display:flex;gap:10px;align-items:center;">
                        <a href="<?= base_url('dashboard') ?>" class="btn-secondary" style="height:40px;padding:0 18px;">
                            <i class="fas fa-arrow-left"></i> Batal
                        </a>
                        <button type="submit" class="btn-primary" style="height:40px;padding:0 22px;border:none;cursor:pointer;">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>

            </form>

            <!-- Legend -->
            <div class="legend-row">
                <div class="legend-item"><div class="legend-dot" style="background:#c2410c;"></div> Kasi</div>
                <div class="legend-item"><div class="legend-dot" style="background:#1e40af;"></div> Kabid</div>
                <div class="legend-item"><div class="legend-dot" style="background:#5b21b6;"></div> Sekdis</div>
                <div class="legend-item"><div class="legend-dot" style="background:#065f46;"></div> Kadis</div>
                <div class="legend-item" style="margin-left:auto;">
                    <i class="fas fa-info-circle" style="font-size:10px;color:var(--c-text-muted);"></i>
                    1 hari kerja = 8 jam
                </div>
            </div>

        </div><!-- /surface -->

    </main>
</div>

<?php $this->load->view('footer'); ?>

<script>
/* ── Burger: panggil fungsi dari sidebar ── */
(function(){
    var burger = document.getElementById('adminBurger');
    if (burger) {
        burger.addEventListener('click', function(e) {
            e.stopPropagation();
            if (typeof window.openAdminSidebar === 'function') {
                window.openAdminSidebar();
            }
        });
    }
})();

/* ── Live update summary ── */
function updateSummary(level, val) {
    var valEl = document.getElementById('summary-val-' + level);
    if (valEl) valEl.textContent = val ? val + 'j' : '—';
    var hint = document.getElementById('hint-' + level);
    if (hint) hint.textContent = val ? '≈ ' + (Math.round(val / 24 * 10) / 10) + ' hari kerja' : '';
}

/* ── Confirm sebelum submit ── */
document.getElementById('slaForm').addEventListener('submit', function(e) {
    if (!confirm('Simpan perubahan SLA? Pengaturan baru akan berlaku untuk pengajuan berikutnya.')) {
        e.preventDefault();
    }
});
</script>
</body>
</html>