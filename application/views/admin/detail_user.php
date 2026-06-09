<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Perusahaan — SITLAKEB TKA Admin</title>
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

        /* ── Burger (mobile only) ── */
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

        /* ── Company hero ── */
        .company-hero {
            background: linear-gradient(135deg, var(--c-primary) 0%, #2a9d7f 100%);
            border-radius: var(--r-xl);
            padding: 24px 28px;
            display: flex; align-items: center; gap: 20px;
            margin-bottom: 20px;
            position: relative; overflow: hidden;
        }
        .company-hero::before {
            content: ''; position: absolute; top: -40px; right: -40px;
            width: 180px; height: 180px; border-radius: 50%;
            background: rgba(255,255,255,0.06);
        }
        .company-hero::after {
            content: ''; position: absolute; bottom: -50px; right: 120px;
            width: 120px; height: 120px; border-radius: 50%;
            background: rgba(255,255,255,0.04);
        }
        .company-avatar {
            width: 64px; height: 64px;
            border-radius: var(--r-lg);
            background: rgba(255,255,255,0.2);
            border: 2px solid rgba(255,255,255,0.25);
            display: flex; align-items: center; justify-content: center;
            font-family: var(--font-head);
            font-size: 1.5rem; font-weight: 800;
            color: white; flex-shrink: 0; z-index: 1;
        }
        .company-hero-info { flex: 1; z-index: 1; min-width: 0; }
        .company-hero-info .ch-name {
            font-family: var(--font-head);
            font-size: 1.15rem; font-weight: 800;
            color: white; margin-bottom: 3px; letter-spacing: -0.01em;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .company-hero-info .ch-pic {
            font-size: 0.78rem; color: rgba(255,255,255,0.75);
            display: flex; align-items: center; gap: 6px;
        }
        .company-hero-info .ch-pic i { font-size: 10px; }
        .company-hero-badges {
            display: flex; flex-direction: column;
            align-items: flex-end; gap: 6px; z-index: 1;
        }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 4px 12px; border-radius: 20px;
            font-size: 0.7rem; font-weight: 700;
            font-family: var(--font-head); white-space: nowrap;
        }
        .hb-aktif    { background: #4ade80; color: #064e3b; }
        .hb-nonaktif { background: #f87171; color: #7f1d1d; }
        .hb-stat     { background: rgba(255,255,255,0.18); color: rgba(255,255,255,0.9); font-size: 0.68rem; }

        /* ── Info grid ── */
        .info-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 0; }
        .info-row {
            display: flex; align-items: flex-start; gap: 12px;
            padding: 14px 22px; border-bottom: 1px solid var(--c-border);
        }
        .info-row:nth-child(odd)  { border-right: 1px solid var(--c-border); }
        .info-row:last-child,
        .info-row:nth-last-child(2):nth-child(odd) { border-bottom: none; }
        .info-icon {
            width: 32px; height: 32px; border-radius: var(--r-sm);
            background: var(--c-primary-light); color: var(--c-primary);
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; flex-shrink: 0; margin-top: 1px;
        }
        .info-label {
            font-size: 0.67rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.07em;
            color: var(--c-text-muted); margin-bottom: 3px;
        }
        .info-value { font-size: 0.84rem; font-weight: 500; color: var(--c-text); line-height: 1.5; }
        .info-value.mono { font-family: 'Courier New', monospace; font-size: 0.8rem; color: var(--c-primary); }

        /* ── Stats mini ── */
        .stats-mini { display: flex; border-top: 1px solid var(--c-border); border-bottom: 1px solid var(--c-border); }
        .sm-item { flex: 1; padding: 14px 16px; text-align: center; border-right: 1px solid var(--c-border); }
        .sm-item:last-child { border-right: none; }
        .sm-val { font-family: var(--font-head); font-size: 1.4rem; font-weight: 800; color: var(--c-text); line-height: 1; margin-bottom: 3px; }
        .sm-lbl { font-size: 0.65rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.06em; color: var(--c-text-muted); }
        .sm-item.sc-proses  .sm-val { color: #1e40af; }
        .sm-item.sc-selesai .sm-val { color: #065f46; }
        .sm-item.sc-ditolak .sm-val { color: #9f1239; }

        /* ── Layout grid ── */
        .two-col-layout {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 20px;
            align-items: start;
        }

        /* ── Mobile card: tabel TKA ── */
        .tka-card-list { display: none; }
        .tka-card-item {
            padding: 13px 16px;
            border-bottom: 1px solid var(--c-border);
        }
        .tka-card-item:last-child { border-bottom: none; }
        .tka-card-top {
            display: flex; justify-content: space-between;
            align-items: flex-start; gap: 10px; margin-bottom: 6px;
        }
        .tka-card-name { font-size: 0.86rem; font-weight: 600; color: var(--c-text); }
        .tka-card-meta {
            display: flex; align-items: center;
            justify-content: space-between; gap: 8px;
        }
        .tka-card-date { font-size: 0.71rem; color: var(--c-text-muted); display: flex; align-items: center; gap: 4px; }

        /* ─────────────────────────────────────
           RESPONSIVE MOBILE (≤ 768px)
        ───────────────────────────────────── */
        @media (max-width: 768px) {

    .topnav { padding: 0 12px !important; }
    .topnav-burger { display: flex; }
    .topnav-breadcrumb .bc-hide { display: none; }

    .page-content { padding: 12px !important; }

    /* ── Hero ── */
    .company-hero {
        flex-wrap: wrap; gap: 10px;
        padding: 16px; border-radius: 16px; margin-bottom: 14px;
    }
    .company-avatar { width: 46px; height: 46px; font-size: 1.1rem; border-radius: 12px; }
    .company-hero-info { flex: 1; min-width: 0; }
    .company-hero-info .ch-name { font-size: 0.92rem; }
    .company-hero-info .ch-pic  { font-size: 0.71rem; }
    .company-hero-badges {
        flex: 0 0 100%;
        flex-direction: row; flex-wrap: wrap;
        align-items: center; gap: 6px;
    }
    .hero-badge { font-size: 0.64rem; padding: 3px 10px; }

    /* ── Surface ── */
    .surface        { border-radius: 14px !important; }
    .surface-header { padding: 12px 16px !important; }
    .surface-title  { font-size: 0.84rem !important; }

    /* ── Layout: 1 kolom ── */
    .two-col-layout {
        grid-template-columns: 1fr !important;
        gap: 12px !important;
    }
    /* kolom kanan (Aksi + Info Akun) naik ke atas */
    .col-right { order: -1; }

    /* kolom kiri jangan ada margin bawah ekstra */
    .col-left .surface:first-child { margin-bottom: 12px !important; }

    /* ── Quick actions: tombol full width ── */
    .surface-body .btn-primary,
    .surface-body .btn-secondary {
        width: 100% !important;
        justify-content: center !important;
        padding: 12px 14px !important;
        font-size: 0.85rem !important;
        border-radius: 12px !important;
    }
    .surface-body .btn-xs {
        width: 100% !important;
        justify-content: center !important;
        padding: 11px 14px !important;
        font-size: 0.82rem !important;
        border-radius: 10px !important;
        display: flex !important;
    }

    /* ── Info grid: 1 kolom ── */
    .info-grid { grid-template-columns: 1fr !important; }
    .info-row {
        border-right: none !important;
        padding: 11px 16px !important;
        gap: 10px !important;
    }
    .info-row:last-child    { border-bottom: none !important; }
    .info-row[style*="grid-column"] { grid-column: 1 !important; }
    .info-icon  { width: 28px !important; height: 28px !important; font-size: 11px !important; }
    .info-label { font-size: 0.62rem !important; }
    .info-value { font-size: 0.81rem !important; }
    .info-value.mono { font-size: 0.78rem !important; }

    /* ── Stats mini ── */
    .stats-mini { }
    .sm-item    { padding: 10px 6px; }
    .sm-val     { font-size: 1.15rem; }
    .sm-lbl     { font-size: 0.58rem; letter-spacing: 0.04em; }

    /* ── Tabel → card list ── */
    .tbl-desktop    { display: none !important; }
    .tka-card-list  { display: block; }

    /* card item lebih bersih */
    .tka-card-item  { padding: 12px 16px; }
    .tka-card-name  { font-size: 0.84rem; }
    .tka-card-date  { font-size: 0.69rem; }

    /* Info akun di dalam .col-right */
    .col-right .surface + .surface { margin-top: 12px !important; }
    }

    @media (max-width: 400px) {
        .page-content   { padding: 10px !important; }
        .company-hero   { padding: 13px 12px; }
        .sm-val         { font-size: 1rem; }
        .sm-lbl         { font-size: 0.55rem; }
    }
    </style>
</head>
<body>

<?php $this->load->view('admin/sidebar'); ?>

<div class="page-wrapper">

    <header class="topnav">
        <div class="topnav-breadcrumb">
            <!-- Burger mobile -->
            <button class="topnav-burger" id="adminBurger" aria-label="Buka Menu">
                <i class="fas fa-bars"></i>
            </button>
            <a href="<?= base_url('dashboard') ?>" style="color:var(--c-text-muted);text-decoration:none;">
                <i class="fas fa-home"></i>
            </a>
            <i class="fas fa-chevron-right bc-hide" style="font-size:8px;"></i>
            <a href="<?= base_url('admin/perusahaan') ?>" class="bc-hide" style="color:var(--c-text-muted);text-decoration:none;">Perusahaan</a>
            <i class="fas fa-chevron-right" style="font-size:8px;"></i>
            <strong><?= htmlspecialchars($user->perusahaan) ?></strong>
        </div>
        <div class="topnav-actions">
            <!--<a href="<?= base_url('admin/manage_users') ?>" class="topnav-btn" title="Kembali">
                <i class="fas fa-arrow-left"></i>
            </a>-->
        </div>
    </header>

    <main class="page-content">

        <?php
        $total   = count($tka_list);
        $proses  = 0; $selesai = 0; $ditolak = 0;
        $proses_statuses = ['MENUNGGU_KASI','MENUNGGU_KABID','MENUNGGU_SEKDIS','MENUNGGU_KADIS'];
        foreach($tka_list as $t) {
            if(in_array($t->status, $proses_statuses)) $proses++;
            elseif($t->status == 'SELESAI') $selesai++;
            elseif($t->status == 'DITOLAK') $ditolak++;
        }
        $initials = strtoupper(substr($user->perusahaan, 0, 2));
        ?>

        <!-- Company Hero -->
        <div class="company-hero">
            <div class="company-avatar"><?= $initials ?></div>
            <div class="company-hero-info">
                <div class="ch-name"><?= htmlspecialchars($user->perusahaan) ?></div>
                <div class="ch-pic">
                    <i class="fas fa-user-tie"></i>
                    PIC: <?= htmlspecialchars($user->nama) ?>
                </div>
            </div>
            <div class="company-hero-badges">
                <span class="hero-badge <?= ($user->is_active == 1) ? 'hb-aktif' : 'hb-nonaktif' ?>">
                    <i class="fas <?= ($user->is_active == 1) ? 'fa-check-circle' : 'fa-ban' ?>"></i>
                    <?= ($user->is_active == 1) ? 'Aktif' : 'Nonaktif' ?>
                </span>
                <span class="hero-badge hb-stat">
                    <i class="fas fa-file-alt"></i>
                    <?= $total ?> Pengajuan
                </span>
            </div>
        </div>

        <!-- Grid layout -->
        <div class="two-col-layout">

            <!-- LEFT -->
            <div class="col-left">

                <!-- Info Perusahaan -->
                <div class="surface" style="margin-bottom:20px;">
                    <div class="surface-header">
                        <div class="surface-title">
                            <i class="fas fa-building"></i>
                            Informasi Perusahaan
                        </div>
                    </div>
                    <div class="info-grid">
                        <div class="info-row">
                            <div class="info-icon"><i class="fas fa-user-tie"></i></div>
                            <div>
                                <div class="info-label">Nama PIC</div>
                                <div class="info-value"><?= htmlspecialchars($user->nama) ?></div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-icon"><i class="fas fa-building"></i></div>
                            <div>
                                <div class="info-label">Nama Perusahaan</div>
                                <div class="info-value"><?= htmlspecialchars($user->perusahaan) ?></div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-icon"><i class="fas fa-envelope"></i></div>
                            <div>
                                <div class="info-label">Email</div>
                                <div class="info-value mono"><?= htmlspecialchars($user->email) ?></div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-icon"><i class="fas fa-phone"></i></div>
                            <div>
                                <div class="info-label">No. HP</div>
                                <div class="info-value mono"><?= htmlspecialchars($user->no_hp) ?></div>
                            </div>
                        </div>
                        <div class="info-row" style="grid-column:1/-1;border-right:none;">
                            <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <div>
                                <div class="info-label">Alamat</div>
                                <div class="info-value"><?= nl2br(htmlspecialchars($user->alamat)) ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Daftar TKA -->
                <div class="surface">
                    <div class="surface-header">
                        <div class="surface-title">
                            <i class="fas fa-layer-group"></i>
                            Daftar Pengajuan TKA
                            <?php if($total > 0): ?>
                            <span style="background:var(--c-primary-light);color:var(--c-primary);padding:2px 8px;border-radius:20px;font-size:0.67rem;"><?= $total ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if($total > 0): ?>
                    <div class="stats-mini">
                        <div class="sm-item sc-total"><div class="sm-val"><?= $total ?></div><div class="sm-lbl">Total</div></div>
                        <div class="sm-item sc-proses"><div class="sm-val"><?= $proses ?></div><div class="sm-lbl">Proses</div></div>
                        <div class="sm-item sc-selesai"><div class="sm-val"><?= $selesai ?></div><div class="sm-lbl">Selesai</div></div>
                        <div class="sm-item sc-ditolak"><div class="sm-val"><?= $ditolak ?></div><div class="sm-lbl">Ditolak</div></div>
                    </div>
                    <?php endif; ?>

                    <?php if(empty($tka_list)): ?>
                        <div class="empty-state">
                            <div class="empty-state-icon"><i class="fas fa-file-circle-xmark"></i></div>
                            <h4>Belum Ada Pengajuan</h4>
                            <p>Perusahaan ini belum memiliki pengajuan TKA.</p>
                        </div>
                    <?php else: ?>

                        <!-- DESKTOP: tabel -->
                        <div class="tbl-desktop" style="overflow-x:auto;">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th class="cell-no">#</th>
                                        <th>Nama TKA</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; foreach($tka_list as $t):
                                        if(in_array($t->status, $proses_statuses)) { $bClass='badge-proses'; $bLabel='Proses'; $bDot='#3b82f6'; }
                                        elseif($t->status=='SELESAI') { $bClass='badge-selesai'; $bLabel='Selesai'; $bDot='#10b981'; }
                                        elseif($t->status=='DITOLAK') { $bClass='badge-ditolak'; $bLabel='Ditolak'; $bDot='#f43f5e'; }
                                        else { $bClass='badge-draft'; $bLabel='Draft'; $bDot='#94a3b8'; }
                                    ?>
                                    <tr>
                                        <td class="cell-no"><?= $no++ ?></td>
                                        <td class="cell-name"><?= htmlspecialchars($t->nama_tka) ?></td>
                                        <td>
                                            <span class="badge <?= $bClass ?>">
                                                <span class="badge-dot" style="background:<?= $bDot ?>;"></span>
                                                <?= $bLabel ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="cell-date-main"><?= date('d M Y', strtotime($t->created_at)) ?></div>
                                            <div class="cell-date-sub"><?= date('H:i', strtotime($t->created_at)) ?> WIB</div>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('admin/detail_tka/'.$t->id) ?>" class="btn-xs bx-detail">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- MOBILE: card list -->
                        <div class="tka-card-list">
                            <?php $no2 = 1; foreach($tka_list as $t):
                                if(in_array($t->status, $proses_statuses)) { $bClass='badge-proses'; $bLabel='Proses'; $bDot='#3b82f6'; }
                                elseif($t->status=='SELESAI') { $bClass='badge-selesai'; $bLabel='Selesai'; $bDot='#10b981'; }
                                elseif($t->status=='DITOLAK') { $bClass='badge-ditolak'; $bLabel='Ditolak'; $bDot='#f43f5e'; }
                                else { $bClass='badge-draft'; $bLabel='Draft'; $bDot='#94a3b8'; }
                            ?>
                            <div class="tka-card-item">
                                <div class="tka-card-top">
                                    <div class="tka-card-name"><?= htmlspecialchars($t->nama_tka) ?></div>
                                    <span class="badge <?= $bClass ?>">
                                        <span class="badge-dot" style="background:<?= $bDot ?>;"></span>
                                        <?= $bLabel ?>
                                    </span>
                                </div>
                                <div class="tka-card-meta">
                                    <div class="tka-card-date">
                                        <i class="fas fa-calendar-alt" style="font-size:10px;"></i>
                                        <?= date('d M Y', strtotime($t->created_at)) ?>
                                        <span style="opacity:.4;">·</span>
                                        <?= date('H:i', strtotime($t->created_at)) ?> WIB
                                    </div>
                                    <a href="<?= base_url('admin/detail_tka/'.$t->id) ?>" class="btn-xs bx-detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>

                    <?php endif; ?>
                </div>

            </div><!-- /col-left -->

            <!-- RIGHT -->
            <div class="col-right">

                <!-- Quick Actions -->
                <div class="surface">
                    <div class="surface-header">
                        <div class="surface-title">
                            <i class="fas fa-bolt" style="color:#f59e0b;"></i>
                            Aksi Cepat
                        </div>
                    </div>
                    <div class="surface-body" style="padding:16px;display:flex;flex-direction:column;gap:8px;">

                        <a href="<?= base_url('admin/edit_user/'.$user->id) ?>" class="btn-primary" style="justify-content:center;">
                            <i class="fas fa-pen"></i> Edit Perusahaan
                        </a>
                        <a href="<?= base_url('admin/perusahaan') ?>" class="btn-secondary" style="justify-content:center;">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                        </a>

                        <div style="margin-top:4px;padding-top:12px;border-top:1px solid var(--c-border);">
                            <div style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.07em;color:var(--c-text-muted);margin-bottom:8px;">Status Akun</div>
                            <?php if($user->is_active == 1): ?>
                                <a href="<?= base_url('admin/toggle_user/'.$user->id) ?>"
                                   class="btn-xs bx-delete"
                                   style="width:100%;justify-content:center;padding:9px 0;"
                                   onclick="return confirm('Nonaktifkan akun perusahaan ini?')">
                                    <i class="fas fa-ban"></i> Nonaktifkan Akun
                                </a>
                            <?php else: ?>
                                <a href="<?= base_url('admin/toggle_user/'.$user->id) ?>"
                                   class="btn-xs bx-surat"
                                   style="width:100%;justify-content:center;padding:9px 0;"
                                   onclick="return confirm('Aktifkan kembali akun perusahaan ini?')">
                                    <i class="fas fa-check-circle"></i> Aktifkan Akun
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Info Akun -->
                <div class="surface" style="margin-top:16px;">
                    <div class="surface-header">
                        <div class="surface-title">
                            <i class="fas fa-circle-info" style="color:#3b82f6;"></i>
                            Info Akun
                        </div>
                    </div>
                    <div style="padding:0;">
                        <div class="info-row" style="border-right:none;">
                            <div class="info-icon" style="background:#eff6ff;color:#3b82f6;"><i class="fas fa-id-badge"></i></div>
                            <div>
                                <div class="info-label">User ID</div>
                                <div class="info-value mono">#<?= $user->id ?></div>
                            </div>
                        </div>
                        <div class="info-row" style="border-right:none;border-bottom:none;">
                            <div class="info-icon" style="background:#f5f3ff;color:#7c3aed;"><i class="fas fa-calendar-plus"></i></div>
                            <div>
                                <div class="info-label">Terdaftar Sejak</div>
                                <div class="info-value"><?= isset($user->created_at) ? date('d M Y', strtotime($user->created_at)) : '-' ?></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- /col-right -->

        </div><!-- /two-col-layout -->

    </main>

    <?php $this->load->view('footer'); ?>
</div>

<script>
(function(){
    /* ── Burger ── */
    var burger = document.getElementById('adminBurger');
    if (burger) {
        burger.addEventListener('click', function(e) {
            e.stopPropagation();
            if (typeof window.openAdminSidebar === 'function') window.openAdminSidebar();
        });
    }
})();
</script>
</body>
</html>