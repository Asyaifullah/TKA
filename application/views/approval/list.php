<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengajuan — <?= $role_display ?></title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Shared design system -->
    <link rel="stylesheet" href="<?= base_url('assets/css/shared.css') ?>">

    <style>
        /* ── Role badge ──────────────────────── */
        .role-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: var(--c-primary-light);
            color: var(--c-primary);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.4px;
        }

        /* ── Stat cards ──────────────────────── */
        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 18px;
        }

        .s-card {
            background: var(--c-surface);
            border: 1px solid var(--c-border);
            border-radius: var(--r-md);
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .s-ico {
            width: 36px;
            height: 36px;
            border-radius: var(--r-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .ico-p { background: var(--c-primary-light); color: var(--c-primary); }
        .ico-r { background: #fef2f2; color: #dc2626; }
        .ico-a { background: #fffbeb; color: #d97706; }
        .ico-g { background: #f0fdf4; color: #16a34a; }

        .s-val { font-size: 1.3rem; font-weight: 700; line-height: 1; color: var(--c-text); }
        .s-lbl { font-size: 0.65rem; color: var(--c-text-muted); margin-top: 3px; text-transform: uppercase; letter-spacing: 0.4px; }

        /* ── Main card ───────────────────────── */
        .main-card {
            background: var(--c-surface);
            border: 1px solid var(--c-border);
            border-radius: var(--r-md);
            overflow: hidden;
        }

        .card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 13px 18px;
            border-bottom: 1px solid var(--c-border);
            background: var(--c-surface-2);
            flex-wrap: wrap;
            gap: 8px;
        }

        .card-top-left {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-top-icon {
            width: 28px;
            height: 28px;
            border-radius: 7px;
            background: var(--c-primary-light);
            color: var(--c-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
        }

        .card-top h6 {
            font-size: 0.88rem;
            font-weight: 700;
            margin: 0;
            color: var(--c-text);
        }

        .count-pill {
            background: var(--c-primary-light);
            color: var(--c-primary);
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 700;
        }

        /* ── Filter chips ────────────────────── */
        .chips-bar {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 9px 18px;
            border-bottom: 1px solid var(--c-border);
            background: var(--c-surface-2);
            flex-wrap: wrap;
        }

        .chips-bar .lbl {
            font-size: 0.65rem;
            color: var(--c-text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-right: 2px;
            white-space: nowrap;
        }

        .chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 11px;
            border-radius: 20px;
            border: 1px solid var(--c-border);
            background: var(--c-surface);
            font-size: 0.7rem;
            font-weight: 600;
            color: var(--c-text-muted);
            cursor: pointer;
            transition: all 0.15s;
        }

        .chip:hover { border-color: var(--c-primary); color: var(--c-primary); }

        .chip.on {
            background: var(--c-primary-light);
            border-color: var(--c-primary);
            color: var(--c-primary);
        }

        .chip .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        /* ── Tabel desktop ───────────────────── */
        .tbl-wrap { overflow-x: auto; }

        table { width: 100%; border-collapse: collapse; }

        thead th {
            padding: 9px 16px;
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--c-text-muted);
            border-bottom: 1px solid var(--c-border);
            background: var(--c-surface-2);
            white-space: nowrap;
        }

        tbody tr { transition: background 0.1s; }
        tbody tr:hover td { background: var(--c-primary-light); }

        tbody td {
            padding: 11px 16px;
            border-bottom: 1px solid var(--c-border);
            vertical-align: middle;
        }

        tbody tr:last-child td { border-bottom: none; }

        .t-name { font-weight: 600; font-size: 0.82rem; color: var(--c-text); }
        .t-sub  { font-size: 0.7rem; color: var(--c-text-muted); margin-top: 2px; display: flex; align-items: center; gap: 4px; }
        .t-date { font-size: 0.8rem; color: var(--c-text); }
        .t-time { font-size: 0.68rem; color: var(--c-text-muted); margin-top: 2px; }

        /* ── SLA badge ───────────────────────── */
        .sla {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .sla .dot { width: 6px; height: 6px; border-radius: 50%; }

        .sla-ok   { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
        .sla-ok   .dot { background: #16a34a; }
        .sla-warn { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
        .sla-warn .dot { background: #d97706; }
        .sla-over { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
        .sla-over .dot { background: #dc2626; }
        .sla-na   { background: var(--c-surface-2); color: var(--c-text-muted); border: 1px solid var(--c-border); }
        .sla-na   .dot { background: var(--c-text-muted); }

        /* ── Tombol aksi ─────────────────────── */
        .btn-act {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--c-primary);
            color: #fff;
            border: none;
            border-radius: var(--r-sm);
            padding: 6px 13px;
            font-size: 0.75rem;
            font-weight: 600;
            font-family: var(--font-body);
            text-decoration: none;
            cursor: pointer;
            transition: opacity 0.15s, transform 0.1s;
        }

        .btn-act:hover  { opacity: 0.88; color: #fff; }
        .btn-act:active { transform: scale(0.97); }

        /* ── Empty state ─────────────────────── */
        .empty {
            padding: 48px 24px;
            text-align: center;
        }

        .empty-ico {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            background: #f0fdf4;
            color: #16a34a;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            margin: 0 auto 14px;
        }

        .empty h4 { font-size: 0.95rem; font-weight: 700; margin-bottom: 5px; color: var(--c-text); }
        .empty p  { font-size: 0.8rem; color: var(--c-text-muted); }

        /* ── Pagination ──────────────────────── */
        .paging {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 18px;
            border-top: 1px solid var(--c-border);
            background: var(--c-surface-2);
            flex-wrap: wrap;
            gap: 8px;
        }

        .pg-info { font-size: 0.7rem; color: var(--c-text-muted); }

        .pg-right {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .pg-size-wrap {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.7rem;
            color: var(--c-text-muted);
        }

        .pg-select {
            padding: 3px 24px 3px 8px;
            border: 1px solid var(--c-border);
            border-radius: var(--r-sm);
            font-size: 0.7rem;
            color: var(--c-text);
            background: var(--c-surface) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='9' height='9' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") no-repeat right 7px center;
            appearance: none;
            outline: none;
            cursor: pointer;
        }

        .pg-btns { display: flex; align-items: center; gap: 3px; }

        .pg-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 28px;
            height: 28px;
            padding: 0 6px;
            border: 1px solid var(--c-border);
            border-radius: var(--r-sm);
            background: var(--c-surface);
            font-size: 0.72rem;
            font-weight: 500;
            color: var(--c-text-muted);
            cursor: pointer;
            font-family: var(--font-body);
            transition: all 0.12s;
        }

        .pg-btn:hover:not(:disabled):not(.on) {
            border-color: var(--c-primary);
            color: var(--c-primary);
            background: var(--c-primary-light);
        }

        .pg-btn.on {
            background: var(--c-primary);
            border-color: var(--c-primary);
            color: #fff;
            font-weight: 700;
        }

        .pg-btn:disabled { opacity: 0.35; cursor: not-allowed; }

        /* ── Mobile: card stack ──────────────── */
        .card-list { padding: 0; }

        .pengajuan-card {
            padding: 14px 16px;
            border-bottom: 1px solid var(--c-border);
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .pengajuan-card:last-child { border-bottom: none; }

        .pengajuan-card.sla-over-card { border-left: 3px solid #dc2626; padding-left: 13px; background: #fff8f8; }
        .pengajuan-card.sla-warn-card { border-left: 3px solid #d97706; padding-left: 13px; background: #fffdf5; }

        .pc-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 8px;
        }

        .pc-name {
            font-size: 0.86rem;
            font-weight: 700;
            color: var(--c-text);
            line-height: 1.4;
        }

        .pc-company {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 0.75rem;
            color: var(--c-text-muted);
            margin-top: 3px;
        }

        .pc-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            flex-wrap: wrap;
        }

        .pc-date {
            font-size: 0.72rem;
            color: var(--c-text-muted);
        }

        .pengajuan-card.card-hidden { display: none !important; }

        /* ── Desktop vs Mobile ───────────────── */
        @media (min-width: 769px) {
            .tbl-desktop { display: block; }
            .card-list   { display: none !important; }
        }

        @media (max-width: 768px) {
            .tbl-desktop { display: none !important; }
            .card-list   { display: block; }
            .stats { grid-template-columns: repeat(2, 1fr); gap: 8px; }
            .s-card { padding: 10px 12px; gap: 10px; }
            .s-val  { font-size: 1.1rem; }
            .chips-bar { padding: 8px 14px; gap: 5px; }
            .chip { font-size: 0.65rem; padding: 3px 9px; }
            .page-content { padding: 14px 12px; }
            .card-top { padding: 10px 14px; }
            .paging {
                flex-direction: column;
                align-items: flex-start;
                padding: 10px 14px;
                gap: 10px;
            }
            .pg-right { width: 100%; justify-content: space-between; }
        }

        @media (max-width: 400px) {
            .stats { grid-template-columns: 1fr 1fr; }
        }

        /* ── NOTIFIKASI LONCENG ─────────────── */
        .notification-bell-wrapper {
            position: relative;
            margin-right: 4px;
        }

        .bell-btn {
            background: none;
            border: none;
            padding: 6px 10px;
            cursor: pointer;
            position: relative;
            color: var(--c-text-muted);
            font-size: 1.1rem;
        }

        #notifBadge {
            position: absolute;
            top: -2px;
            right: -2px;
            font-size: 0.6rem;
            display: none;
        }

        .notif-dropdown {
            display: none;
            position: absolute;
            right: 0;
            top: 38px;
            width: 360px;
            max-height: 400px;
            overflow-y: auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
            z-index: 1050;
            padding: 12px 0;
        }

        .notif-item {
            padding: 10px 16px;
            border-bottom: 1px solid #f1f5f9;
            cursor: pointer;
            font-size: 0.78rem;
            transition: background 0.1s;
        }

        .notif-item:hover { background: #f8fafc; }
        .notif-item.unread { background: #eff6ff; }
        .notif-item .time { font-size: 0.68rem; color: var(--c-text-muted); }
    </style>
</head>
<body>

<?php $this->load->view('approval/sidebar'); ?>

<?php
/* ── Hitung statistik SLA ──────────────────────── */
$total    = count($list);
$cnt_over = $cnt_warn = 0;

foreach ($list as $t) {
    if (empty($t->sla_deadline)) continue;
    $s = strtotime($t->sla_deadline) - time();
    if ($s < 0)    $cnt_over++;
    elseif ($s < 7200) $cnt_warn++;
}
$cnt_ok = $total - $cnt_over - $cnt_warn;

/* ── Helper: class & label SLA ──────────────────── */
function sla_info($dl) {
    if (empty($dl)) return ['sla-na', 'Belum tersedia'];
    $s = strtotime($dl) - time();
    if ($s < 0)    return ['sla-over', 'Terlambat ' . ceil(abs($s) / 86400) . ' hari'];
    if ($s < 7200) return ['sla-warn',  round($s / 3600, 1) . ' jam lagi'];
    return              ['sla-ok',   round($s / 86400, 1) . ' hari lagi'];
}
?>

<div class="page-wrapper">

    <!-- Top Nav -->
    <div class="topnav">
        <div class="topnav-breadcrumb">
            <span style="color:var(--c-text-muted);">Approval</span>
            <i class="fas fa-chevron-right" style="font-size:8px;color:var(--c-text-muted);"></i>
            <strong>Daftar Pengajuan</strong>
        </div>
        <div class="topnav-actions" style="display:flex; align-items:center; gap:8px;">
            <!-- ════════ NOTIFIKASI LONCENG ════════ -->
            <div class="notification-bell-wrapper">
                <button id="notificationBell" class="bell-btn" title="Notifikasi">
                    <i class="fas fa-bell"></i>
                    <span id="notifBadge" class="badge badge-danger" style="display:none;">0</span>
                </button>
                <div id="notifDropdown" class="notif-dropdown">
                    <div style="padding:8px 16px; font-weight:700; font-size:0.8rem; border-bottom:1px solid var(--c-border);">
                        Notifikasi
                    </div>
                    <div id="notifList" style="max-height:300px; overflow-y:auto;"></div>
                    <div style="padding:8px 16px; border-top:1px solid var(--c-border); text-align:center;">
                        <a href="<?= base_url('approval/notifications') ?>" style="font-size:0.75rem;">
                            Lihat Semua
                        </a>
                        <span style="margin:0 5px;">|</span>
                        <a href="<?= base_url('approval/mark_all_read') ?>" style="font-size:0.75rem;">
                            Tandai Semua Dibaca
                        </a>
                    </div>
                </div>
            </div>
            <!-- ════════════════════════════════════ -->
            <span class="role-badge">
                <i class="fas fa-user-check"></i>
                <?= strtoupper($role) ?>
            </span>
        </div>
    </div>

    <div class="page-content">

        <!-- Page header -->
        <div class="page-header">
            <div class="page-title">
                <i class="fas fa-tasks" style="color:var(--c-primary);margin-right:6px;"></i>
                Daftar Pengajuan TKA
            </div>
            <div class="page-subtitle">
                Pengajuan yang memerlukan tindakan Anda ·
                <strong><?= htmlspecialchars($role_display) ?></strong>
            </div>
        </div>

        <!-- Stat cards -->
        <?php if ($total > 0): ?>
        <div class="stats">
            <div class="s-card">
                <div class="s-ico ico-p"><i class="fas fa-inbox"></i></div>
                <div>
                    <div class="s-val"><?= $total ?></div>
                    <div class="s-lbl">Total</div>
                </div>
            </div>
            <div class="s-card">
                <div class="s-ico ico-r"><i class="fas fa-exclamation-circle"></i></div>
                <div>
                    <div class="s-val"><?= $cnt_over ?></div>
                    <div class="s-lbl">Terlambat</div>
                </div>
            </div>
            <div class="s-card">
                <div class="s-ico ico-a"><i class="fas fa-clock"></i></div>
                <div>
                    <div class="s-val"><?= $cnt_warn ?></div>
                    <div class="s-lbl">Hampir Tenggat</div>
                </div>
            </div>
            <div class="s-card">
                <div class="s-ico ico-g"><i class="fas fa-check-circle"></i></div>
                <div>
                    <div class="s-val"><?= $cnt_ok ?></div>
                    <div class="s-lbl">Tepat Waktu</div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Main card -->
        <div class="main-card">

            <!-- Card header -->
            <div class="card-top">
                <div class="card-top-left">
                    <div class="card-top-icon"><i class="fas fa-list-check"></i></div>
                    <h6>Pengajuan Perlu Diproses</h6>
                </div>
                <span class="count-pill"><?= $total ?> pengajuan</span>
            </div>

            <?php if (empty($list)): ?>

            <!-- Empty state -->
            <div class="empty">
                <div class="empty-ico"><i class="fas fa-check-circle"></i></div>
                <h4>Semua Beres!</h4>
                <p>Tidak ada pengajuan yang perlu diproses saat ini.</p>
            </div>

            <?php else: ?>

            <!-- Filter chips -->
            <div class="chips-bar">
                <span class="lbl">Filter:</span>
                <button class="chip on" data-f="all">
                    <span class="dot" style="background:var(--c-primary);"></span> Semua
                </button>
                <button class="chip" data-f="sla-over">
                    <span class="dot" style="background:#dc2626;"></span> Terlambat
                </button>
                <button class="chip" data-f="sla-warn">
                    <span class="dot" style="background:#d97706;"></span> Hampir Tenggat
                </button>
                <button class="chip" data-f="sla-ok">
                    <span class="dot" style="background:#16a34a;"></span> Tepat Waktu
                </button>
            </div>

            <!-- DESKTOP: Tabel -->
            <div class="tbl-desktop">
                <div class="tbl-wrap">
                    <table id="tbl">
                        <thead>
                            <tr>
                                <th>TKA / Perusahaan</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Status SLA</th>
                                <th style="width:90px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($list as $t):
                                [$sc, $st] = sla_info($t->sla_deadline ?? null);
                            ?>
                            <tr data-sla="<?= $sc ?>">
                                <td>
                                    <div class="t-name"><?= htmlspecialchars($t->nama_tka) ?></div>
                                    <div class="t-sub">
                                        <i class="fas fa-building" style="font-size:9px;"></i>
                                        <?= htmlspecialchars($t->perusahaan) ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="t-date"><?= date('d M Y', strtotime($t->created_at)) ?></div>
                                    <div class="t-time"><?= date('H:i', strtotime($t->created_at)) ?> WIB</div>
                                </td>
                                <td>
                                    <span class="sla <?= $sc ?>">
                                        <span class="dot"></span><?= $st ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?= base_url('approval/detail/' . $t->id) ?>" class="btn-act">
                                        <i class="fas fa-arrow-right"></i> Proses
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- MOBILE: Card stack -->
            <div class="card-list" id="cardList">
                <?php foreach ($list as $t):
                    [$sc, $st] = sla_info($t->sla_deadline ?? null);
                    $card_cls  = ($sc === 'sla-over') ? 'sla-over-card' : (($sc === 'sla-warn') ? 'sla-warn-card' : '');
                ?>
                <div class="pengajuan-card <?= $card_cls ?>"
                     data-sla="<?= $sc ?>">

                    <div class="pc-top">
                        <div>
                            <div class="pc-name"><?= htmlspecialchars($t->nama_tka) ?></div>
                            <div class="pc-company">
                                <i class="fas fa-building" style="font-size:9px;"></i>
                                <?= htmlspecialchars($t->perusahaan) ?>
                            </div>
                        </div>
                        <span class="sla <?= $sc ?>" style="flex-shrink:0;">
                            <span class="dot"></span><?= $st ?>
                        </span>
                    </div>

                    <div class="pc-meta">
                        <div class="pc-date">
                            <i class="fas fa-calendar-alt" style="font-size:9px;margin-right:3px;"></i>
                            <?= date('d M Y, H:i', strtotime($t->created_at)) ?> WIB
                        </div>
                        <a href="<?= base_url('approval/detail/' . $t->id) ?>" class="btn-act">
                            <i class="fas fa-arrow-right"></i> Proses
                        </a>
                    </div>

                </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <div class="paging">
                <div class="pg-info" id="pgInfo">—</div>
                <div class="pg-right">
                    <div class="pg-size-wrap">
                        Tampilkan
                        <select class="pg-select" id="pgSize">
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                        per halaman
                    </div>
                    <div class="pg-btns" id="pgCtrl"></div>
                </div>
            </div>

            <?php endif; ?>
        </div><!-- /main-card -->

    </div><!-- /page-content -->
</div><!-- /page-wrapper -->

<?php $this->load->view('footer'); ?>

<script>
/* ============================================================
   Filter + Pagination (logic sama seperti sebelumnya)
============================================================ */
(function () {
    var pp = 10, cp = 1;
    var activeFilter = 'all';

    var tbody   = document.querySelector('#tbl tbody');
    var allRows = tbody ? Array.from(tbody.querySelectorAll('tr')) : [];

    var cardList = document.getElementById('cardList');
    var allCards = cardList ? Array.from(cardList.querySelectorAll('.pengajuan-card')) : [];

    var totalItems = Math.max(allRows.length, allCards.length);
    if (totalItems === 0) return;

    var info = document.getElementById('pgInfo');
    var ctrl = document.getElementById('pgCtrl');
    var sel  = document.getElementById('pgSize');

    function getPassingIndices() {
        var ref     = allRows.length > 0 ? allRows : allCards;
        var passing = [];
        ref.forEach(function (item, idx) {
            var sla = item.dataset.sla || '';
            if (activeFilter === 'all' || sla === activeFilter) {
                passing.push(idx);
            }
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

    function render(page) {
        var passing    = getPassingIndices();
        var tot        = passing.length;
        var totalPages = Math.max(1, Math.ceil(tot / pp));

        if (page < 1)          page = 1;
        if (page > totalPages) page = totalPages;
        cp = page;

        var s = (cp - 1) * pp;
        var e = Math.min(cp * pp, tot);

        for (var i = 0; i < totalItems; i++) { setVisible(i, false); }

        passing.forEach(function (idx, pos) {
            if (pos >= s && pos < e) setVisible(idx, true);
        });

        if (info) {
            info.innerHTML = tot > 0
                ? 'Menampilkan <strong>' + (s + 1) + '–' + e + '</strong> dari <strong>' + tot + '</strong>'
                : '<strong>0</strong> data ditemukan';
        }

        buildPaging(totalPages);
    }

    function buildPaging(pages) {
        if (!ctrl) return;
        ctrl.innerHTML = '';
        if (pages <= 1) return;

        function mk(label, pg, dis, act) {
            var b = document.createElement('button');
            b.className = 'pg-btn' + (act ? ' on' : '');
            b.innerHTML = label;
            b.disabled  = dis;
            if (!dis && !act) b.onclick = function () { render(pg); };
            ctrl.appendChild(b);
        }

        mk('<i class="fas fa-chevron-left" style="font-size:9px"></i>', cp - 1, cp === 1, false);

        var lo = Math.max(1, cp - 2);
        var hi = Math.min(pages, lo + 4);
        lo = Math.max(1, hi - 4);

        if (lo > 1) { mk(1, 1, false, false); if (lo > 2) mk('…', null, true, false); }
        for (var i = lo; i <= hi; i++) mk(i, i, false, i === cp);
        if (hi < pages) { if (hi < pages - 1) mk('…', null, true, false); mk(pages, pages, false, false); }

        mk('<i class="fas fa-chevron-right" style="font-size:9px"></i>', cp + 1, cp === pages, false);
    }

    document.querySelectorAll('.chip').forEach(function (chip) {
        chip.addEventListener('click', function () {
            document.querySelectorAll('.chip').forEach(function (c) { c.classList.remove('on'); });
            this.classList.add('on');
            activeFilter = this.dataset.f;
            render(1);
        });
    });

    if (sel) {
        sel.onchange = function () {
            pp = parseInt(this.value, 10);
            render(1);
        };
    }

    render(1);
})();
</script>

<!-- ═══════════════════════════════════════════
     SCRIPT NOTIFIKASI (polling 10 detik)
═══════════════════════════════════════════ -->
<script>
function loadNotifications() {
    fetch('<?= base_url("approval/get_notifications") ?>')
        .then(response => response.json())
        .then(data => {
            const badge = document.getElementById('notifBadge');
            const list  = document.getElementById('notifList');
            if (data.unread_count > 0) {
                badge.style.display = 'inline-block';
                badge.textContent = data.unread_count;
            } else {
                badge.style.display = 'none';
            }
            if (list) {
                let html = '';
                if (data.notifications.length === 0) {
                    html = '<div style="padding:16px; text-align:center; color:#94a3b8;">Tidak ada notifikasi</div>';
                } else {
                    data.notifications.forEach(n => {
                        html += `<div class="notif-item ${n.is_read == 0 ? 'unread' : ''}" 
                                      onclick="window.location='<?= base_url('approval/mark_notification_read/') ?>${n.id}'">
                            <div style="font-weight:600;">${n.message}</div>
                            <div class="time">${n.created_at}</div>
                        </div>`;
                    });
                }
                list.innerHTML = html;
            }
        })
        .catch(err => console.error('Notifikasi gagal dimuat', err));
}

document.addEventListener('DOMContentLoaded', function() {
    var bell = document.getElementById('notificationBell');
    var dropdown = document.getElementById('notifDropdown');
    if (bell && dropdown) {
        bell.addEventListener('click', function(e) {
            e.stopPropagation();
            var isOpen = dropdown.style.display === 'block';
            dropdown.style.display = isOpen ? 'none' : 'block';
            if (!isOpen) loadNotifications();
        });
        document.addEventListener('click', function(e) {
            if (!dropdown.contains(e.target) && e.target !== bell) {
                dropdown.style.display = 'none';
            }
        });
    }

    // polling tiap 10 detik
    loadNotifications();
    setInterval(loadNotifications, 10000);
});
</script>
</body>
</html>