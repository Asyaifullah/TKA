<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — <?= $role_display ?></title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/shared.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0/dist/chartjs-plugin-datalabels.min.js"></script>
    <style>
        /* ── Stat cards — 3 kolom sejajar ── */
        .approval-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 14px;
            margin-bottom: 20px;
        }

        .astat {
            background: var(--c-surface);
            border: 1px solid var(--c-border);
            border-radius: var(--r-xl);
            padding: 20px 20px 18px;
            display: flex;
            align-items: center;
            gap: 14px;
            box-shadow: var(--shadow-sm);
            transition: transform 0.18s, box-shadow 0.18s;
            position: relative;
            overflow: hidden;
        }
        .astat:hover { transform: translateY(-2px); box-shadow: var(--shadow-md); }

        .astat::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 4px;
            border-radius: var(--r-xl) 0 0 var(--r-xl);
        }
        .astat-pending::before  { background: #f59e0b; }
        .astat-approve::before  { background: #10b981; }
        .astat-reject::before   { background: #f43f5e; }

        .astat-icon {
            width: 46px; height: 46px;
            border-radius: var(--r-lg);
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }
        .astat-pending .astat-icon  { background: #fffbeb; color: #d97706; }
        .astat-approve .astat-icon  { background: #ecfdf5; color: #059669; }
        .astat-reject  .astat-icon  { background: #fff1f2; color: #e11d48; }

        .astat-body {}
        .astat-label {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--c-text-muted);
            margin-bottom: 4px;
        }
        .astat-value {
            font-family: var(--font-head);
            font-size: 2rem;
            font-weight: 800;
            line-height: 1;
            letter-spacing: -0.04em;
        }
        .astat-pending .astat-value  { color: #d97706; }
        .astat-approve .astat-value  { color: #059669; }
        .astat-reject  .astat-value  { color: #e11d48; }

        /* ── Charts row — 60/40 split ── */
        .charts-row {
            display: grid;
            grid-template-columns: 3fr 2fr;
            gap: 14px;
            margin-bottom: 20px;
        }

        .chart-surface {
            background: var(--c-surface);
            border: 1px solid var(--c-border);
            border-radius: var(--r-xl);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            min-height: 0;
            height: fit-content;
        }

        .chart-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-bottom: 1px solid var(--c-border);
            background: var(--c-surface-2);
            flex-shrink: 0;
        }
        .chart-title {
            font-family: var(--font-head);
            font-size: 0.84rem;
            font-weight: 700;
            color: var(--c-text);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .chart-title i { color: var(--c-primary); font-size: 13px; }

        .chart-body {
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        .chart-canvas-wrap {
            position: relative;
            width: 100%;
            height: 240px;
            flex-shrink: 0;
        }

        .btn-refresh {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--c-primary);
            background: var(--c-primary-light);
            border: 1px solid rgba(26,107,82,0.15);
            border-radius: 20px;
            padding: 4px 12px;
            cursor: pointer;
            transition: background 0.15s;
        }
        .btn-refresh:hover { background: #c5e8e1; }

        .donut-legend {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 16px;
            flex-wrap: wrap;
        }
        .donut-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 600;
        }
        .donut-pill-approve { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
        .donut-pill-reject  { background: #fff1f2; color: #9f1239; border: 1px solid #fecdd3; }
        .donut-dot { width: 7px; height: 7px; border-radius: 50%; }

        /* ── Table ── */
        .table-surface {
            background: var(--c-surface);
            border: 1px solid var(--c-border);
            border-radius: var(--r-xl);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }
        .table-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-bottom: 1px solid var(--c-border);
            background: var(--c-surface-2);
        }
        .table-title {
            font-family: var(--font-head);
            font-size: 0.84rem;
            font-weight: 700;
            color: var(--c-text);
            display: flex; align-items: center; gap: 8px;
        }
        .table-title i { color: var(--c-primary); font-size: 13px; }
        .table-count {
            font-size: 0.7rem; font-weight: 700;
            background: var(--c-primary-light);
            color: var(--c-primary);
            padding: 3px 10px;
            border-radius: 20px;
        }

        .btn-proses {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.71rem;
            font-weight: 700;
            color: var(--c-primary);
            background: var(--c-primary-light);
            border: 1px solid rgba(26,107,82,0.15);
            border-radius: var(--r-sm);
            padding: 5px 12px;
            text-decoration: none;
            transition: all 0.15s;
            white-space: nowrap;
        }
        .btn-proses:hover {
            background: var(--c-primary);
            color: white;
            border-color: var(--c-primary);
            text-decoration: none;
        }

        .co-avatar {
            width: 32px; height: 32px;
            border-radius: var(--r-sm);
            background: var(--c-primary-light);
            color: var(--c-primary);
            display: flex; align-items: center; justify-content: center;
            font-size: 0.72rem; font-weight: 800;
            font-family: var(--font-head);
            flex-shrink: 0;
        }

        .role-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: var(--c-primary-light);
            color: var(--c-primary);
            font-size: 0.73rem; font-weight: 700;
            padding: 5px 13px; border-radius: 20px;
            border: 1px solid rgba(26,107,82,0.15);
        }
        .role-badge i { font-size: 11px; }

        .empty-block { padding: 48px 24px; text-align: center; color: var(--c-text-muted); }
        .empty-block-icon {
            width: 56px; height: 56px;
            background: var(--c-primary-light);
            color: var(--c-primary);
            border-radius: var(--r-xl);
            display: flex; align-items: center; justify-content: center;
            font-size: 22px;
            margin: 0 auto 14px;
        }
        .empty-block h4 { font-family: var(--font-head); font-size: 0.9rem; font-weight: 700; color: var(--c-text); margin-bottom: 4px; }
        .empty-block p  { font-size: 0.78rem; }

        /* ── Mobile menu toggle & overlay ── */
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

        /* ════════════════════════════════════════
           MOBILE STYLES (≤ 768px)
        ════════════════════════════════════════ */
        @media (max-width: 900px) {
            .charts-row { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            .mobile-menu-toggle { display: flex; }

            /* Stat cards: 3 kolom ramping */
            .approval-stats {
                grid-template-columns: repeat(3, 1fr);
                gap: 10px;
                margin-bottom: 16px;
            }
            .astat {
                padding: 14px 12px 12px;
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
                border-radius: 12px;
            }
            .astat-icon { width: 38px; height: 38px; font-size: 15px; border-radius: 8px; }
            .astat-label { font-size: 0.62rem; letter-spacing: 0.04em; }
            .astat-value { font-size: 1.55rem; }

            .charts-row { gap: 12px; margin-bottom: 16px; }
            .chart-head { padding: 12px 16px; }
            .chart-title { font-size: 0.78rem; }
            .chart-body { padding: 14px; }
            .chart-canvas-wrap { height: 200px; }

            /* Donut compact */
            .chart-surface:last-child .chart-body {
                flex-direction: row;
                align-items: center;
                gap: 16px;
                flex-wrap: wrap;
            }
            .chart-surface:last-child .chart-body > div:first-child {
                max-width: 130px;
                flex-shrink: 0;
            }
            .donut-legend {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
                margin-top: 0;
            }
            .donut-pill { font-size: 0.75rem; padding: 5px 12px; }

            .table-head { padding: 12px 16px; }
            .table-title { font-size: 0.8rem; }

            /* Table → Card list */
            .data-table thead { display: none; }
            .data-table tbody { display: flex; flex-direction: column; gap: 0; }
            .data-table tr {
                display: flex;
                flex-direction: column;
                padding: 14px 16px;
                border-bottom: 1px solid #f1f4f7;
                gap: 0;
                position: relative;
            }
            .data-table tr:last-child { border-bottom: none; }
            .data-table tr:hover td { background: transparent; }
            .data-table td {
                display: block;
                padding: 0;
                border: none;
                font-size: 0.82rem;
            }
            .data-table td.cell-no { display: none; }

            .data-table td[data-label="Perusahaan"] {
                margin-bottom: 6px;
            }
            .data-table td[data-label="Perusahaan"] > div {
                display: flex; align-items: center; gap: 9px;
            }
            .data-table td[data-label="Perusahaan"] .cell-name {
                font-size: 0.86rem; font-weight: 700;
            }

            .data-table td[data-label="Nama TKA"] {
                font-size: 0.78rem;
                color: var(--c-text-muted);
                margin-bottom: 4px;
                padding-left: 41px;
            }
            .data-table td[data-label="Nama TKA"]::before {
                content: 'TKA: ';
                font-weight: 600;
                color: #aab4bf;
                font-size: 0.7rem;
                text-transform: uppercase;
                letter-spacing: 0.04em;
            }

            .data-table td[data-label="Tanggal"] {
                padding-left: 41px;
                margin-bottom: 10px;
            }
            .cell-date-main { font-size: 0.75rem; }
            .cell-date-sub  { font-size: 0.68rem; }

            .data-table td[data-label="Aksi"] {
                padding-left: 0;
                text-align: left !important;
            }
            .data-table td[data-label="Aksi"] .btn-proses {
                display: flex;
                justify-content: center;
                width: 100%;
                padding: 9px 0;
                font-size: 0.78rem;
                border-radius: 8px;
            }
        }

        @media (max-width: 420px) {
            .approval-stats { gap: 8px; }
            .astat { padding: 12px 10px 10px; }
            .astat-value { font-size: 1.35rem; }
            .astat-label { font-size: 0.58rem; }
            .astat-icon { width: 32px; height: 32px; font-size: 13px; }
        }
    </style>
</head>
<body>

<?php $this->load->view('approval/sidebar'); ?>

<div class="page-wrapper">

    <header class="topnav">
        <div class="topnav-breadcrumb">
            <a href="#" style="color:var(--c-text-muted); text-decoration:none;"><i class="fas fa-home"></i></a>
            <i class="fas fa-chevron-right" style="font-size:8px;"></i>
            <span style="color:var(--c-text-muted);">Approval</span>
            <i class="fas fa-chevron-right" style="font-size:8px;"></i>
            <strong>Dashboard</strong>
        </div>
        <div class="topnav-actions">
            <div class="role-badge">
                <i class="fas fa-user-check"></i>
                <?= strtoupper($role) ?> — <?= $role_display ?>
            </div>
        </div>
    </header>

    <main class="page-content">

        <div class="page-header" style="margin-bottom:20px;">
            <div class="page-title">Dashboard <?= $role_display ?></div>
            <div class="page-subtitle">
                Selamat datang, <strong><?= htmlspecialchars($this->session->userdata('nama')) ?></strong>.
                Pantau dan proses pengajuan yang masuk ke antrian Anda.
            </div>
        </div>

        <!-- Stat Cards -->
        <div class="approval-stats">
            <div class="astat astat-pending">
                <div class="astat-icon"><i class="fas fa-hourglass-half"></i></div>
                <div class="astat-body">
                    <div class="astat-label">Menunggu Proses</div>
                    <div class="astat-value" id="totalPending"><?= $total_pending ?></div>
                </div>
            </div>
            <div class="astat astat-approve">
                <div class="astat-icon"><i class="fas fa-check-circle"></i></div>
                <div class="astat-body">
                    <div class="astat-label">Disetujui</div>
                    <div class="astat-value" id="totalApproved"><?= $total_approved ?></div>
                </div>
            </div>
            <div class="astat astat-reject">
                <div class="astat-icon"><i class="fas fa-times-circle"></i></div>
                <div class="astat-body">
                    <div class="astat-label">Ditolak</div>
                    <div class="astat-value" id="totalRejected"><?= $total_rejected ?></div>
                </div>
            </div>
        </div>

        <!-- Charts row -->
        <div class="charts-row">

            <div class="chart-surface">
                <div class="chart-head">
                    <div class="chart-title">
                        <i class="fas fa-chart-bar"></i>
                        Tren Pengajuan per Bulan
                    </div>
                    <button class="btn-refresh" id="refreshChartBtn">
                        <i class="fas fa-sync-alt"></i> Refresh
                    </button>
                </div>
                <div class="chart-body">
                    <div class="chart-canvas-wrap">
                        <canvas id="barChart"></canvas>
                    </div>
                    <div style="text-align:center; margin-top:10px; font-size:0.68rem; color:var(--c-text-muted);">
                        <i class="fas fa-hand-pointer" style="font-size:9px;"></i>
                        Klik batang untuk detail bulan
                    </div>
                </div>
            </div>

            <div class="chart-surface">
                <div class="chart-head">
                    <div class="chart-title">
                        <i class="fas fa-chart-pie"></i>
                        Perbandingan Keputusan
                    </div>
                </div>
                <div class="chart-body" style="align-items:center; justify-content:center;">
                    <div style="width:100%; max-width:200px; margin:0 auto;">
                        <canvas id="pieChart"></canvas>
                    </div>
                    <div class="donut-legend">
                        <span class="donut-pill donut-pill-approve">
                            <span class="donut-dot" style="background:#10b981;"></span>
                            Approve <?= $total_approved ?>
                        </span>
                        <span class="donut-pill donut-pill-reject">
                            <span class="donut-dot" style="background:#f43f5e;"></span>
                            Reject <?= $total_rejected ?>
                        </span>
                    </div>
                    <div style="text-align:center; margin-top:8px; font-size:0.68rem; color:var(--c-text-muted);">
                        <i class="fas fa-hand-pointer" style="font-size:9px;"></i>
                        Klik potongan untuk daftar
                    </div>
                </div>
            </div>

        </div>

        <!-- Tabel Pengajuan -->
        <div class="table-surface">
            <div class="table-head">
                <div class="table-title">
                    <i class="fas fa-inbox"></i>
                    Pengajuan Perlu Diproses
                </div>
                <?php if(!empty($recent_pending)): ?>
                <span class="table-count"><?= count($recent_pending) ?> item</span>
                <?php endif; ?>
            </div>

            <?php if(empty($recent_pending)): ?>
                <div class="empty-block">
                    <div class="empty-block-icon"><i class="fas fa-check-double"></i></div>
                    <h4>Semua Beres!</h4>
                    <p>Tidak ada pengajuan yang perlu diproses saat ini.</p>
                </div>
            <?php else: ?>
                <div class="table-wrap">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th class="cell-no">#</th>
                                <th>Perusahaan</th>
                                <th>Nama TKA</th>
                                <th>Tanggal Pengajuan</th>
                                <th style="width:110px; text-align:center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach($recent_pending as $t): ?>
                            <tr>
                                <td class="cell-no"><?= $no++ ?></td>
                                <td data-label="Perusahaan">
                                    <div style="display:flex; align-items:center; gap:9px;">
                                        <div class="co-avatar"><?= strtoupper(substr($t->perusahaan, 0, 2)) ?></div>
                                        <span class="cell-name"><?= htmlspecialchars($t->perusahaan) ?></span>
                                    </div>
                                </td>
                                <td data-label="Nama TKA" style="font-weight:500; color:var(--c-text);"><?= htmlspecialchars($t->nama_tka) ?></td>
                                <td data-label="Tanggal">
                                    <div class="cell-date-main"><?= date('d M Y', strtotime($t->created_at)) ?></div>
                                    <div class="cell-date-sub"><?= date('H:i', strtotime($t->created_at)) ?> WIB</div>
                                </td>
                                <td class="cell-action" data-label="Aksi" style="text-align:center;">
                                    <a href="<?= base_url('approval/detail/'.$t->id) ?>" class="btn-proses">
                                        <i class="fas fa-eye"></i> Proses
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

    </main>
</div>

<?php $this->load->view('footer'); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
Chart.register(ChartDataLabels);

let barChart, pieChart;

const barLabels = <?= $chart_labels ?>;
const barData   = <?= $chart_data ?>;
const pieData   = <?= $pie_data ?>;
const total     = pieData[0] + pieData[1];

/* Bar Chart */
(function(){
    const ctx = document.getElementById('barChart')?.getContext('2d');
    if (!ctx) return;

    const grad = ctx.createLinearGradient(0, 0, 0, 260);
    grad.addColorStop(0, 'rgba(26,107,82,0.85)');
    grad.addColorStop(1, 'rgba(26,107,82,0.45)');

    barChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: barLabels,
            datasets: [{
                label: 'Pengajuan',
                data: barData,
                backgroundColor: grad,
                borderColor: '#1a6b52',
                borderWidth: 0,
                borderRadius: 7,
                borderSkipped: false,
                barPercentage: 0.6,
                hoverBackgroundColor: '#145c44',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0f1923',
                    titleColor: '#fff',
                    bodyColor: '#94a3b8',
                    padding: 10,
                    cornerRadius: 8,
                    callbacks: {
                        label: ctx => ` ${ctx.raw} pengajuan`
                    }
                },
                datalabels: {
                    anchor: 'end',
                    align: 'top',
                    color: '#1a6b52',
                    font: { weight: 'bold', size: 11, family: "'DM Sans', sans-serif" },
                    formatter: v => v > 0 ? v : ''
                }
            },
            onClick: (e, active) => {
                if (active.length > 0) {
                    const bulan = barChart.data.labels[active[0].index];
                    const jml   = barChart.data.datasets[0].data[active[0].index];
                    alert(`${bulan}: ${jml} pengajuan`);
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#f1f4f8', drawBorder: false },
                    border: { display: false },
                    ticks: {
                        precision: 0,
                        font: { size: 10, family: "'DM Sans', sans-serif" },
                        color: '#8fa0b3'
                    }
                },
                x: {
                    grid: { display: false },
                    border: { display: false },
                    ticks: {
                        font: { size: 10, family: "'DM Sans', sans-serif" },
                        color: '#8fa0b3'
                    }
                }
            }
        }
    });
})();

/* Donut Chart */
(function(){
    const ctx = document.getElementById('pieChart')?.getContext('2d');
    if (!ctx) return;

    const centerPlugin = {
        id: 'centerText',
        afterDraw(chart) {
            const { ctx: c, chartArea } = chart;
            if (!chartArea) return;
            const mx = (chartArea.left + chartArea.right) / 2;
            const my = (chartArea.top  + chartArea.bottom) / 2;
            c.save();
            c.font = 'bold 20px "Plus Jakarta Sans", sans-serif';
            c.fillStyle = '#1a2332';
            c.textAlign = 'center';
            c.textBaseline = 'middle';
            c.fillText(total, mx, my - 8);
            c.font = '10px "DM Sans", sans-serif';
            c.fillStyle = '#8fa0b3';
            c.fillText('Total', mx, my + 12);
            c.restore();
        }
    };

    pieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Disetujui', 'Ditolak'],
            datasets: [{
                data: pieData,
                backgroundColor: ['#10b981', '#f43f5e'],
                borderColor: 'white',
                borderWidth: 3,
                hoverOffset: 8,
                borderRadius: 4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            cutout: '68%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0f1923',
                    titleColor: '#fff',
                    bodyColor: '#94a3b8',
                    padding: 10,
                    cornerRadius: 8,
                    callbacks: {
                        label: ctx => {
                            const pct = total > 0 ? ((ctx.raw / total) * 100).toFixed(1) : 0;
                            return ` ${ctx.label}: ${ctx.raw} (${pct}%)`;
                        }
                    }
                },
                datalabels: { display: false }
            },
            onClick: (e, active) => {
                if (active.length > 0) {
                    const status = active[0].index === 0 ? 'approve' : 'reject';
                    window.location.href = '<?= base_url("approval/logs?status=") ?>' + status;
                }
            }
        },
        plugins: [centerPlugin]
    });
})();

/* Refresh chart + stats */
document.getElementById('refreshChartBtn')?.addEventListener('click', function(){
    var icon = this.querySelector('i');
    icon.classList.add('fa-spin');
    fetch('<?= base_url("approval/dashboard_data") ?>')
        .then(r => r.json())
        .then(data => {
            document.getElementById('totalPending').textContent  = data.total_pending;
            document.getElementById('totalApproved').textContent = data.total_approved;
            document.getElementById('totalRejected').textContent = data.total_rejected;
            if (barChart) { barChart.data.datasets[0].data = data.chart_data; barChart.update(); }
            if (pieChart) { pieChart.data.datasets[0].data = [data.total_approved, data.total_rejected]; pieChart.update(); }
        })
        .catch(e => console.warn(e))
        .finally(() => icon.classList.remove('fa-spin'));
});

/* Sidebar Collapse + Mobile Hamburger */
$(document).ready(function() {

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
        var isNowCollapsed = !$sidebar.hasClass('collapsed');
        applyCollapse(isNowCollapsed);
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

});
</script>
</body>
</html>