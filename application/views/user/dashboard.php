<?php
// views/user/dashboard.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — SITLAKEB TKA</title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/shared.css') ?>">

    <style>

        /* ── Greeting banner ── */
        .greeting-banner {
            background: linear-gradient(135deg, var(--c-primary) 0%, #2a9d7f 100%);
            border-radius: var(--r-xl);
            padding: 24px 28px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            overflow: hidden;
            position: relative;
        }
        .greeting-banner::before {
            content: '';
            position: absolute; top: -30px; right: -30px;
            width: 180px; height: 180px; border-radius: 50%;
            background: rgba(255,255,255,0.06);
        }
        .greeting-banner::after {
            content: '';
            position: absolute; bottom: -50px; right: 80px;
            width: 140px; height: 140px; border-radius: 50%;
            background: rgba(255,255,255,0.04);
        }
        .greeting-text { z-index: 1; }
        .greeting-text h2 {
            font-family: var(--font-head);
            font-size: 1.25rem; font-weight: 800;
            color: white; margin-bottom: 4px; letter-spacing: -0.02em;
        }
        .greeting-text p { font-size: 0.8rem; color: rgba(255,255,255,0.75); margin: 0; }
        .greeting-badge {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: var(--r-xl);
            padding: 10px 16px;
            text-align: center; color: white;
            flex-shrink: 0; z-index: 1;
        }
        .greeting-badge .gb-date {
            font-family: var(--font-head);
            font-size: 1.4rem; font-weight: 800; line-height: 1;
        }
        .greeting-badge .gb-month { font-size: 0.7rem; opacity: 0.8; margin-top: 2px; }

        /* ── Pagination ── */
        .paging-wrap {
            padding: 14px 20px;
            border-top: 1px solid var(--c-border);
            display: flex; justify-content: space-between;
            align-items: center; flex-wrap: wrap; gap: 10px;
            background: var(--c-surface-2);
        }
        .paging-info { font-size: 0.72rem; color: var(--c-text-muted); }
        .paging-controls { display: flex; align-items: center; gap: 4px; }
        .page-btn {
            display: inline-flex; align-items: center; justify-content: center;
            min-width: 30px; height: 30px; padding: 0 8px;
            border: 1px solid var(--c-border-strong);
            border-radius: var(--r-sm); background: var(--c-surface);
            font-family: var(--font-body); font-size: 0.75rem; font-weight: 500;
            color: var(--c-text-mid); cursor: pointer;
            transition: background 0.12s, border-color 0.12s, color 0.12s;
            user-select: none;
        }
        .page-btn:hover:not(:disabled):not(.active) {
            background: var(--c-primary-light);
            border-color: var(--c-primary); color: var(--c-primary);
        }
        .page-btn.active { background: var(--c-primary); border-color: var(--c-primary); color: white; font-weight: 700; }
        .page-btn:disabled { opacity: 0.35; cursor: not-allowed; }
        .per-page-wrap { display: flex; align-items: center; gap: 6px; font-size: 0.72rem; color: var(--c-text-muted); }
        .per-page-select {
            padding: 3px 22px 3px 8px;
            border: 1px solid var(--c-border-strong); border-radius: var(--r-sm);
            background: var(--c-surface); font-size: 0.72rem; color: var(--c-text);
            outline: none; appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 7px center; cursor: pointer;
        }

        /* ── Empty state ── */
        .empty-state { padding: 40px; text-align: center; }
        .empty-state-icon { font-size: 2.5rem; color: var(--c-text-muted); margin-bottom: 12px; }
        .empty-state h4 { font-size: 1rem; font-weight: 700; margin-bottom: 6px; }
        .empty-state p { font-size: 0.8rem; color: var(--c-text-muted); }

        /* ── Mobile card list ── */
        .tka-card-list { display: none; }
        .tka-card-item {
            padding: 14px 16px;
            border-bottom: 1px solid var(--c-border);
        }
        .tka-card-item:last-child { border-bottom: none; }
        .tka-card-row1 {
            display: flex; align-items: flex-start;
            justify-content: space-between; gap: 10px;
            margin-bottom: 8px;
        }
        .tka-card-name {
            font-size: 0.9rem; font-weight: 600;
            color: var(--c-text); line-height: 1.3;
        }
        .tka-card-row2 {
            display: flex; align-items: center;
            justify-content: space-between; gap: 8px;
            flex-wrap: wrap;
        }
        .tka-card-meta {
            display: flex; flex-direction: column; gap: 3px;
        }
        .tka-card-date {
            font-size: 0.72rem; color: var(--c-text-muted);
            display: flex; align-items: center; gap: 4px;
        }
        .tka-card-progress { margin-top: 1px; }
        .tka-card-actions { display: flex; gap: 6px; flex-wrap: wrap; }

        /* ─────────────────────────────────
           MOBILE OVERRIDES (≤ 768px)
        ───────────────────────────────── */
        @media (max-width: 768px) {

            .page-content { padding: 12px !important; }

            /* greeting banner: tetap horizontal tapi lebih compact */
            .greeting-banner {
                padding: 16px;
                border-radius: 16px;
                margin-bottom: 14px;
                gap: 12px;
            }
            .greeting-text h2 { font-size: 1rem; margin-bottom: 3px; }
            .greeting-text p  { font-size: 0.73rem; }
            .greeting-badge { padding: 8px 12px; }
            .greeting-badge .gb-date  { font-size: 1.15rem; }
            .greeting-badge .gb-month { font-size: 0.65rem; }

            /* info banner */
            .info-banner {
                border-radius: 16px !important;
                padding: 14px 16px !important;
                gap: 12px !important;
                margin-bottom: 14px !important;
            }
            .info-banner-body h6 { font-size: 0.82rem !important; margin-bottom: 6px !important; }
            .info-banner ul { padding-left: 14px; margin-bottom: 0; }
            .info-banner ul li { font-size: 0.75rem; line-height: 1.5; margin-bottom: 3px; }
            .info-banner-icon { font-size: 1rem !important; }

            /* stat grid: 2x2 */
            .stats-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 10px !important;
                margin-bottom: 14px !important;
            }
            .stat-card {
                padding: 14px !important;
                border-radius: 16px !important;
            }
            .stat-label { font-size: 0.7rem !important; }
            .stat-value { font-size: 1.5rem !important; }
            .stat-icon  { width: 30px !important; height: 30px !important; font-size: 0.8rem !important; }
            .stat-top   { margin-bottom: 8px !important; }

            /* surface */
            .surface { border-radius: 16px !important; }
            .surface-header {
                padding: 13px 16px !important;
                flex-wrap: wrap !important;
                gap: 8px !important;
            }
            .surface-title { font-size: 0.88rem !important; }
            .surface-header .btn-primary {
                width: 100% !important;
                justify-content: center !important;
                padding: 11px 14px !important;
                font-size: 0.83rem !important;
                border-radius: 12px !important;
            }

            /* sembunyikan tabel, tampilkan card list */
            .table-wrap  { display: none !important; }
            .tka-card-list { display: block !important; }

            /* pagination compact */
            .paging-wrap {
                padding: 12px 14px;
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
                border-radius: 0 0 16px 16px;
            }
            .paging-controls { flex-wrap: wrap; }
            .page-btn { min-width: 32px; height: 32px; font-size: 0.72rem; }
            .per-page-wrap { font-size: 0.72rem; }
        }

        @media (max-width: 400px) {
            .page-content { padding: 10px !important; }
            .greeting-banner { padding: 14px 12px; }
            .stats-grid { gap: 8px !important; }
        }
    </style>
</head>
<body>

<?php $this->load->view('user/sidebar'); ?>

<div class="page-wrapper">

    <header class="topnav">
        <div class="topnav-breadcrumb">
            <i class="fas fa-home"></i>
            <strong>Dashboard</strong>
        </div>
        <div class="topnav-actions">
            <div style="position:relative;">
                <button class="topnav-btn" id="notifBell" title="Notifikasi">
                    <i class="fas fa-bell"></i>
                    <span class="topnav-badge" id="notifBadge" style="display:none;">0</span>
                </button>
            </div>
            <a href="<?= base_url('user/profile') ?>" class="topnav-btn" title="Profil">
                <i class="fas fa-user-circle"></i>
            </a>
        </div>
    </header>

    <main class="page-content">

        <!-- Greeting Banner -->
        <div class="greeting-banner">
            <div class="greeting-text">
                <h2>Selamat Datang, <?= htmlspecialchars($this->session->userdata('nama')) ?> 👋</h2>
                <p>Pantau dan kelola pengajuan Tenaga Kerja Asing Anda dari sini.</p>
            </div>
            <div class="greeting-badge">
                <div class="gb-date" id="gbDate"></div>
                <div class="gb-month" id="gbMonth"></div>
            </div>
        </div>

        <!-- Info Banner -->
        <div class="info-banner">
            <div class="info-banner-icon">
                <i class="fas fa-triangle-exclamation"></i>
            </div>
            <div class="info-banner-body">
                <h6>Perhatian Sebelum Upload Data TKA</h6>
                <ul>
                    <li>Periksa kembali semua data — pastikan tidak ada kesalahan ketik.</li>
                    <li>Keaslian dokumen menjadi tanggung jawab perusahaan.</li>
                    <li>File PDF dan gambar maksimal 2 MB, format sesuai ketentuan.</li>
                    <li>Nama TKA harus sesuai paspor (huruf kapital).</li>
                    <li>Setelah upload, data akan diverifikasi petugas. Pantau status di menu Data TKA.</li>
                </ul>
            </div>
        </div>

        <!-- Stat Cards -->
        <?php
        $total  = count($tka);
        $proses = 0; $selesai = 0; $ditolak = 0;
        foreach($tka as $t) {
            if(in_array($t->status, ['MENUNGGU_KASI','MENUNGGU_KABID','MENUNGGU_SEKDIS','MENUNGGU_KADIS'])) $proses++;
            elseif($t->status == 'SELESAI') $selesai++;
            elseif($t->status == 'DITOLAK') $ditolak++;
        }
        ?>
        <div class="stats-grid">
            <div class="stat-card sc-total">
                <div class="stat-top"><div class="stat-icon"><i class="fas fa-file-alt"></i></div></div>
                <div><div class="stat-label">Total Pengajuan</div><div class="stat-value"><?= $total ?></div></div>
            </div>
            <div class="stat-card sc-proses">
                <div class="stat-top"><div class="stat-icon"><i class="fas fa-hourglass-half"></i></div></div>
                <div><div class="stat-label">Dalam Proses</div><div class="stat-value"><?= $proses ?></div></div>
            </div>
            <div class="stat-card sc-selesai">
                <div class="stat-top"><div class="stat-icon"><i class="fas fa-check-circle"></i></div></div>
                <div><div class="stat-label">Selesai</div><div class="stat-value"><?= $selesai ?></div></div>
            </div>
            <div class="stat-card sc-ditolak">
                <div class="stat-top"><div class="stat-icon"><i class="fas fa-times-circle"></i></div></div>
                <div><div class="stat-label">Ditolak</div><div class="stat-value"><?= $ditolak ?></div></div>
            </div>
        </div>

        <!-- Tabel / Card List TKA -->
        <div class="surface">
            <div class="surface-header">
                <div class="surface-title">
                    <i class="fas fa-layer-group"></i>
                    Daftar Pengajuan TKA
                </div>
                <a href="<?= base_url('user/upload') ?>" class="btn-primary">
                    <i class="fas fa-plus"></i> Upload Baru
                </a>
            </div>

            <?php if(empty($tka)): ?>
                <div class="empty-state">
                    <div class="empty-state-icon"><i class="fas fa-file-circle-plus"></i></div>
                    <h4>Belum Ada Data TKA</h4>
                    <p>Mulai dengan mengupload data TKA baru untuk memulai proses pengajuan.</p>
                    <a href="<?= base_url('user/upload') ?>" class="btn-primary" style="margin-top:12px;">
                        <i class="fas fa-plus"></i> Upload Sekarang
                    </a>
                </div>
            <?php else: ?>

                <!-- ── DESKTOP: tabel ── -->
                <div class="table-wrap table-responsive-card">
                    <table class="data-table" id="dashboardTable">
                        <thead>
                            <tr>
                                <th class="cell-no">#</th>
                                <th>Nama TKA</th>
                                <th>Status</th>
                                <th>Progress</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach($tka as $t):
                                if($t->status == 'DRAFT')                                                                        { $sb = 'badge-draft';   $bd = '#94a3b8'; $st = 'Draft'; }
                                elseif(in_array($t->status, ['MENUNGGU_KASI','MENUNGGU_KABID','MENUNGGU_SEKDIS','MENUNGGU_KADIS'])) { $sb = 'badge-proses';  $bd = '#3b82f6'; $st = 'Proses'; }
                                elseif($t->status == 'SELESAI')                                                                  { $sb = 'badge-selesai'; $bd = '#10b981'; $st = 'Selesai'; }
                                elseif($t->status == 'DITOLAK')                                                                  { $sb = 'badge-ditolak'; $bd = '#f43f5e'; $st = 'Ditolak'; }
                                else                                                                                             { $sb = 'badge-draft';   $bd = '#94a3b8'; $st = $t->status; }

                                $pp_label = ['DRAFT'=>'Belum Lengkap','MENUNGGU_KASI'=>'Verifikasi Kasi','MENUNGGU_KABID'=>'Verifikasi Kabid','MENUNGGU_SEKDIS'=>'Verifikasi Sekdis','MENUNGGU_KADIS'=>'Verifikasi Kadis','SELESAI'=>'Surat Terbit','DITOLAK'=>'Ditolak'];
                                $pl = $pp_label[$t->status] ?? $t->status;
                                if($t->status=='DRAFT') $pc='pp-draft';
                                elseif(in_array($t->status,['MENUNGGU_KASI','MENUNGGU_KABID','MENUNGGU_SEKDIS','MENUNGGU_KADIS'])) $pc='pp-kasi';
                                elseif($t->status=='SELESAI') $pc='pp-selesai';
                                elseif($t->status=='DITOLAK') $pc='pp-ditolak';
                                else $pc='pp-draft';
                            ?>
                            <tr>
                                <td class="cell-no"><?= $no++ ?></td>
                                <td class="cell-name" data-label="Nama TKA"><?= htmlspecialchars($t->nama_tka) ?></td>
                                <td data-label="Status">
                                    <span class="badge <?= $sb ?>">
                                        <span class="badge-dot" style="background:<?= $bd ?>;"></span> <?= $st ?>
                                    </span>
                                </td>
                                <td data-label="Progress">
                                    <span class="progress-pill <?= $pc ?>"><?= $pl ?></span>
                                </td>
                                <td data-label="Tanggal">
                                    <div class="cell-date-main"><?= date('d M Y', strtotime($t->created_at)) ?></div>
                                    <div class="cell-date-sub"><?= date('H:i', strtotime($t->created_at)) ?> WIB</div>
                                </td>
                                <td class="cell-action" data-label="Aksi">
                                    <div class="btn-row">
                                        <a href="<?= base_url('user/detail/'.$t->id) ?>" class="btn-xs bx-detail"><i class="fas fa-eye"></i> Detail</a>
                                        <?php if($t->status=='DRAFT'): ?>
                                            <a href="<?= base_url('user/detail_form/'.$t->id) ?>" class="btn-xs bx-lengkapi"><i class="fas fa-pen-fancy"></i> Lengkapi</a>
                                            <a href="<?= base_url('user/edit_tka/'.$t->id) ?>" class="btn-xs bx-ganti"><i class="fas fa-file-upload"></i> Ganti</a>
                                            <a href="<?= base_url('user/delete_tka/'.$t->id) ?>" class="btn-xs bx-delete" onclick="return confirm('Yakin hapus data TKA ini?')"><i class="fas fa-trash-alt"></i></a>
                                        <?php elseif($t->status=='DITOLAK'): ?>
                                            <a href="<?= base_url('user/perbaiki_tka/'.$t->id) ?>" class="btn-xs bx-edit"><i class="fas fa-wrench"></i> Perbaiki</a>
                                        <?php elseif($t->status=='SELESAI'): ?>
                                            <a href="<?= base_url('user/download_surat_word/'.$t->id) ?>" class="btn-xs bx-surat" target="_blank"><i class="fas fa-download"></i> Surat</a>
                                        <?php elseif(in_array($t->status,['MENUNGGU_KASI','MENUNGGU_KABID','MENUNGGU_SEKDIS','MENUNGGU_KADIS'])): ?>
                                            <a href="<?= base_url('user/edit_tka/'.$t->id) ?>" class="btn-xs bx-edit"><i class="fas fa-edit"></i> Edit</a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- ── MOBILE: card list ── -->
                <div class="tka-card-list" id="mobileCardList">
                    <?php foreach($tka as $t):
                        if($t->status=='DRAFT')                                                                        { $sb='badge-draft';   $bd='#94a3b8'; $st='Draft'; }
                        elseif(in_array($t->status,['MENUNGGU_KASI','MENUNGGU_KABID','MENUNGGU_SEKDIS','MENUNGGU_KADIS'])) { $sb='badge-proses';  $bd='#3b82f6'; $st='Proses'; }
                        elseif($t->status=='SELESAI')                                                                  { $sb='badge-selesai'; $bd='#10b981'; $st='Selesai'; }
                        elseif($t->status=='DITOLAK')                                                                  { $sb='badge-ditolak'; $bd='#f43f5e'; $st='Ditolak'; }
                        else                                                                                           { $sb='badge-draft';   $bd='#94a3b8'; $st=$t->status; }

                        $pp_label = ['DRAFT'=>'Belum Lengkap','MENUNGGU_KASI'=>'Verifikasi Kasi','MENUNGGU_KABID'=>'Verifikasi Kabid','MENUNGGU_SEKDIS'=>'Verifikasi Sekdis','MENUNGGU_KADIS'=>'Verifikasi Kadis','SELESAI'=>'Surat Terbit','DITOLAK'=>'Ditolak'];
                        $pl = $pp_label[$t->status] ?? $t->status;
                        if($t->status=='DRAFT') $pc='pp-draft';
                        elseif(in_array($t->status,['MENUNGGU_KASI','MENUNGGU_KABID','MENUNGGU_SEKDIS','MENUNGGU_KADIS'])) $pc='pp-kasi';
                        elseif($t->status=='SELESAI') $pc='pp-selesai';
                        elseif($t->status=='DITOLAK') $pc='pp-ditolak';
                        else $pc='pp-draft';
                    ?>
                    <div class="tka-card-item">
                        <div class="tka-card-row1">
                            <div>
                                <div class="tka-card-name"><?= htmlspecialchars($t->nama_tka) ?></div>
                            </div>
                            <span class="badge <?= $sb ?>">
                                <span class="badge-dot" style="background:<?= $bd ?>;"></span> <?= $st ?>
                            </span>
                        </div>
                        <div class="tka-card-row2">
                            <div class="tka-card-meta">
                                <div class="tka-card-date">
                                    <i class="fas fa-calendar-alt" style="font-size:10px;"></i>
                                    <?= date('d M Y', strtotime($t->created_at)) ?>
                                    <span style="opacity:.4;">·</span>
                                    <?= date('H:i', strtotime($t->created_at)) ?> WIB
                                </div>
                                <div class="tka-card-progress">
                                    <span class="progress-pill <?= $pc ?>"><?= $pl ?></span>
                                </div>
                            </div>
                            <div class="tka-card-actions">
                                <a href="<?= base_url('user/detail/'.$t->id) ?>" class="btn-xs bx-detail" title="Detail"><i class="fas fa-eye"></i></a>
                                <?php if($t->status=='DRAFT'): ?>
                                    <a href="<?= base_url('user/detail_form/'.$t->id) ?>" class="btn-xs bx-lengkapi" title="Lengkapi"><i class="fas fa-pen-fancy"></i></a>
                                    <a href="<?= base_url('user/edit_tka/'.$t->id) ?>" class="btn-xs bx-ganti" title="Ganti"><i class="fas fa-file-upload"></i></a>
                                    <a href="<?= base_url('user/delete_tka/'.$t->id) ?>" class="btn-xs bx-delete" title="Hapus" onclick="return confirm('Yakin hapus data TKA ini?')"><i class="fas fa-trash-alt"></i></a>
                                <?php elseif($t->status=='DITOLAK'): ?>
                                    <a href="<?= base_url('user/perbaiki_tka/'.$t->id) ?>" class="btn-xs bx-edit" title="Perbaiki"><i class="fas fa-wrench"></i></a>
                                <?php elseif($t->status=='SELESAI'): ?>
                                    <a href="<?= base_url('user/download_surat_word/'.$t->id) ?>" class="btn-xs bx-surat" title="Download Surat" target="_blank"><i class="fas fa-download"></i></a>
                                <?php elseif(in_array($t->status,['MENUNGGU_KASI','MENUNGGU_KABID','MENUNGGU_SEKDIS','MENUNGGU_KADIS'])): ?>
                                    <a href="<?= base_url('user/edit_tka/'.$t->id) ?>" class="btn-xs bx-edit" title="Edit"><i class="fas fa-edit"></i></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <div class="paging-wrap" id="pagingWrap">
                    <div class="paging-info" id="pagingInfo">—</div>
                    <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
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

            <?php endif; ?>
        </div>

    </main>
</div>

<?php $this->load->view('footer'); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
(function(){
    var d = new Date();
    var months = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
    document.getElementById('gbDate').textContent = String(d.getDate()).padStart(2,'0');
    document.getElementById('gbMonth').textContent = months[d.getMonth()] + ' ' + d.getFullYear();
})();

$(document).ready(function(){
    function fetchNotif(){
        $.ajax({
            url: '<?= base_url("user/get_notifications") ?>',
            type: 'GET', dataType: 'json',
            success: function(data){
                if(data.unread_count > 0) $('#notifBadge').text(data.unread_count).show();
                else $('#notifBadge').hide();
                window._notifData = data.notifications;
            }
        });
    }
    fetchNotif();
    setInterval(fetchNotif, 10000);

    $('#notifBell').on('click', function(e){
        e.stopPropagation();
        var $d = $('.notif-dropdown');
        if($d.length){ $d.toggle(); return; }
        var html = '<div class="notif-dropdown"><div class="notif-dropdown-header"><i class="fas fa-bell me-2"></i>Notifikasi</div>';
        var notifs = window._notifData || [];
        if(notifs.length){
            $.each(notifs, function(i,n){
                var dt = new Date(n.created_at);
                var ds = dt.toLocaleDateString('id-ID') + ' ' + dt.toLocaleTimeString('id-ID',{hour:'2-digit',minute:'2-digit'});
                html += '<a class="notif-item" href="<?= base_url("user/mark_notification_read/") ?>'+n.id+'">'
                      + '<div class="notif-item-title">'+n.title+'</div>'
                      + '<div class="notif-item-msg">'+n.message+'</div>'
                      + '<div class="notif-item-time">'+ds+'</div></a>';
            });
        } else {
            html += '<div class="notif-item" style="color:var(--c-text-muted);">Tidak ada notifikasi</div>';
        }
        html += '</div>';
        $(this).parent().append(html);
        $(document).one('click', function(){ $('.notif-dropdown').remove(); });
    });
});

(function(){
    var tableBody   = document.querySelector('#dashboardTable tbody');
    var cardList    = document.getElementById('mobileCardList');
    var tableRows   = tableBody  ? Array.from(tableBody.querySelectorAll('tr'))             : [];
    var mobileCards = cardList   ? Array.from(cardList.querySelectorAll('.tka-card-item'))  : [];
    if(tableRows.length === 0 && mobileCards.length === 0) return;

    var perPage = 10, currentPage = 1;
    var total   = tableRows.length || mobileCards.length;
    var infoEl  = document.getElementById('pagingInfo');
    var ctrlEl  = document.getElementById('pagingControls');
    var ppSel   = document.getElementById('perPageSelect');

    function showPage(page){
        var totalPages = Math.ceil(total / perPage) || 1;
        if(page < 1) page = 1;
        if(page > totalPages) page = totalPages;
        currentPage = page;
        var start = (currentPage-1)*perPage;
        var end   = Math.min(currentPage*perPage, total);

        tableRows.forEach(function(r,i){ r.style.display = (i>=start&&i<end)?'':'none'; });
        mobileCards.forEach(function(c,i){ c.style.display = (i>=start&&i<end)?'':'none'; });

        infoEl.innerHTML = total > 0
            ? 'Menampilkan <strong>'+(start+1)+'–'+end+'</strong> dari <strong>'+total+'</strong> pengajuan'
            : '0 pengajuan';
        renderCtrl(totalPages);
    }

    function renderCtrl(totalPages){
        ctrlEl.innerHTML = '';
        if(totalPages<=1) return;
        var prev = makeBtn('<i class="fas fa-chevron-left" style="font-size:10px;"></i>', function(){ showPage(currentPage-1); });
        prev.disabled = currentPage===1;
        ctrlEl.appendChild(prev);
        var sP = Math.max(1, currentPage-2);
        var eP = Math.min(totalPages, sP+4);
        sP = Math.max(1, eP-4);
        if(sP>1){ ctrlEl.appendChild(makePB(1)); if(sP>2) ctrlEl.appendChild(makeDots()); }
        for(var i=sP;i<=eP;i++) ctrlEl.appendChild(makePB(i));
        if(eP<totalPages){ if(eP<totalPages-1) ctrlEl.appendChild(makeDots()); ctrlEl.appendChild(makePB(totalPages)); }
        var next = makeBtn('<i class="fas fa-chevron-right" style="font-size:10px;"></i>', function(){ showPage(currentPage+1); });
        next.disabled = currentPage===totalPages;
        ctrlEl.appendChild(next);
    }

    function makeBtn(html, fn){ var b=document.createElement('button'); b.className='page-btn'; b.innerHTML=html; b.addEventListener('click',fn); return b; }
    function makePB(num){ var b=makeBtn(num,function(){ showPage(num); }); if(num===currentPage) b.classList.add('active'); return b; }
    function makeDots(){ var s=document.createElement('span'); s.className='page-btn'; s.style.cursor='default'; s.textContent='…'; return s; }

    if(ppSel) ppSel.addEventListener('change', function(){ perPage=parseInt(this.value); showPage(1); });
    showPage(1);
})();
</script>
</body>
</html>