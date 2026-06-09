<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengajuan - <?= ucfirst($role) ?></title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">
    <!-- Shared Design System -->
    <link rel="stylesheet" href="<?= base_url('assets/css/shared.css') ?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* ── Styling tambahan khusus halaman detail ── */
        .file-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 12px;
            margin-bottom: 20px;
        }
        .file-card {
            background: var(--c-surface-2);
            border-radius: var(--r-lg);
            padding: 14px;
            text-align: center;
            border: 1px solid var(--c-border);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .file-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }
        .file-card strong {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--c-text);
            margin-bottom: 8px;
        }
        .preview-img {
            max-width: 120px;
            border-radius: var(--r-md);
            border: 1px solid var(--c-border);
        }
        .detail-table {
            width: 100%;
            border-collapse: collapse;
        }
        .detail-table th,
        .detail-table td {
            padding: 10px 14px;
            border-bottom: 1px solid var(--c-border);
            font-size: 0.82rem;
        }
        .detail-table th {
            background: var(--c-surface-2);
            font-weight: 600;
            color: var(--c-text);
            width: 30%;
            text-align: left;
        }
        .detail-table td {
            color: var(--c-text-mid);
        }

        /* ── Timeline ── */
        .timeline {
            position: relative;
            padding-left: 24px;
        }
        .timeline-item {
            position: relative;
            padding-left: 24px;
            margin-bottom: 18px;
            border-left: 2px solid var(--c-border);
        }
        .timeline-badge {
            position: absolute;
            left: -11px;
            top: 0;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 0 2px white;
        }

        /* Catatan box — approve (hijau kiri) */
        .catatan-box {
            background: var(--c-surface-2);
            border-radius: var(--r-md);
            padding: 10px 14px;
            margin-top: 8px;
            font-size: 0.8rem;
            border-left: 3px solid var(--c-primary);
        }
        /* Catatan box — reject (merah kiri) */
        .catatan-box.reject {
            border-left-color: #e53e3e;
            background: #fff1f2;
        }
        /* Catatan box — sistem otomatis (abu-abu dashed) */
        .catatan-box.system {
            border-left: none;
            border: 1px dashed var(--c-border);
            background: transparent;
            color: var(--c-text-muted);
            font-style: italic;
            font-size: 0.76rem;
        }

        /* ── Mobile Menu Toggle & Overlay ── */
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

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .mobile-menu-toggle { display: flex; }
            .file-grid { grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); }
            .detail-table th, .detail-table td { font-size: 0.78rem; }
            .timeline { padding-left: 16px; }
            .timeline-item { padding-left: 16px; }
        }
        @media (max-width: 576px) {
            .page-content { padding: 16px 12px; }
            .file-grid { grid-template-columns: 1fr 1fr; gap: 8px; }
            .file-card { padding: 10px; }
            .btn-primary, .btn-xs.bx-delete { width: 100%; justify-content: center; }
            .detail-table th, .detail-table td { padding: 8px 10px; }
        }
    </style>
</head>
<body>

<?php $this->load->view('approval/sidebar'); ?>

<?php
$system_note_patterns = [
    'Auto-created by fallback',
    'Pengajuan baru oleh perusahaan',
    'Diteruskan dari Kepala Seksi',
    'Diteruskan dari',
    'Auto-created',
];

function is_system_log($catatan, $patterns) {
    if (empty($catatan)) return false;
    foreach ($patterns as $p) {
        if (stripos($catatan, $p) !== false) return true;
    }
    return false;
}
?>

<!-- Page Wrapper -->
<div class="page-wrapper">
    <!-- Top Navigation -->
    <div class="topnav">
        <div class="topnav-breadcrumb">
            <span>Approval</span>
            <i class="fas fa-chevron-right"></i>
            <a href="<?= base_url('approval/index') ?>" style="color:var(--c-text-muted);text-decoration:none;">Daftar Pengajuan</a>
            <i class="fas fa-chevron-right"></i>
            <strong><?= htmlspecialchars($tka->nama_tka) ?></strong>
        </div>
    </div>

    <!-- Page Content -->
    <div class="page-content">

        <!-- Header Informasi Utama -->
        <div class="surface" style="margin-bottom:24px;">
            <div class="surface-header">
                <div class="surface-title">
                    <i class="fas fa-user"></i> <?= htmlspecialchars($tka->nama_tka) ?>
                </div>
                <span class="badge badge-proses"><?= $tka->status ?></span>
            </div>
            <div class="surface-body">
                <div style="display:flex; gap:24px; flex-wrap:wrap;">
                    <div>
                        <span class="field-hint">Perusahaan</span>
                        <div style="font-weight:600;"><?= htmlspecialchars($perusahaan_nama ?? '-') ?></div>
                    </div>
                    <div>
                        <span class="field-hint">Tanggal Pengajuan</span>
                        <div style="font-weight:600;"><?= date('d M Y H:i', strtotime($tka->created_at)) ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dokumen yang Diupload -->
        <div class="surface" style="margin-bottom:24px;">
            <div class="surface-header">
                <div class="surface-title">
                    <i class="fas fa-file-alt"></i> Dokumen yang Diupload
                </div>
            </div>
            <div class="surface-body">
                <div class="file-grid">
                    <?php 
                    $file_fields = [
                        'surat_permohonan' => 'Surat Permohonan',
                        'passport'         => 'Passport',
                        'kitas'            => 'KITAS',
                        'stm'              => 'STM',
                        'rptka'            => 'RPTKA',
                        'notifikasi'       => 'Notifikasi',
                        'bukti_bayar'      => 'Bukti Bayar',
                        'surat_kuasa'      => 'Surat Kuasa',
                        'surat_wajib_lapor'=> 'Surat Wajib Lapor',
                        'ktp'              => 'KTP',
                        'foto'             => 'Foto',
                    ];
                    foreach($file_fields as $field => $label): 
                        $file = isset($berkas->$field) ? $berkas->$field : '';
                    ?>
                        <div class="file-card">
                            <strong><?= $label ?></strong>
                            <?php if($file): ?>
                                <?php 
                                $ext      = strtolower(pathinfo($file, PATHINFO_EXTENSION)); 
                                $is_image = in_array($ext, ['jpg','jpeg','png']); 
                                $url      = base_url('uploads/'.$tka->id.'/'.$file); 
                                ?>
                                <?php if($is_image): ?>
                                    <a href="<?= $url ?>" target="_blank">
                                        <img src="<?= $url ?>" class="preview-img" alt="<?= $label ?>">
                                    </a>
                                <?php else: ?>
                                    <a href="<?= $url ?>" target="_blank" class="btn-xs bx-detail" style="margin-top:8px;">
                                        <i class="fas fa-file-pdf"></i> Lihat
                                    </a>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="field-hint" style="display:block;margin-top:8px;">Tidak ada</span>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Data Detail -->
        <div class="surface" style="margin-bottom:24px;">
            <div class="surface-header">
                <div class="surface-title">
                    <i class="fas fa-edit"></i> Data Detail yang Diisi Perusahaan
                </div>
            </div>
            <div class="surface-body">
                <!-- Table Responsive Card -->
                <div class="table-wrap table-responsive-card">
                    <table class="detail-table">
                        <tr><th>Nomor Passport</th><td data-label="Nomor Passport"><?= $tka->passport_no ?? '<span class="field-hint">Belum diisi</span>' ?></td></tr>
                        <tr><th>Masa Berlaku Passport</th><td data-label="Masa Berlaku Passport"><?= $tka->passport_expiry ? date('d-m-Y', strtotime($tka->passport_expiry)) : '<span class="field-hint">-</span>' ?></td></tr>
                        <tr><th>Nomor KITAS</th><td data-label="Nomor KITAS"><?= $tka->kitas_no ?? '<span class="field-hint">Belum diisi</span>' ?></td></tr>
                        <tr><th>Nomor STM</th><td data-label="Nomor STM"><?= $tka->stm_no ?? '<span class="field-hint">-</span>' ?></td></tr>
                        <tr><th>Nomor RPTKA</th><td data-label="Nomor RPTKA"><?= $tka->rptka_no ?? '<span class="field-hint">-</span>' ?></td></tr>
                        <tr><th>Tanggal RPTKA</th><td data-label="Tanggal RPTKA"><?= $tka->rptka_date ? date('d-m-Y', strtotime($tka->rptka_date)) : '<span class="field-hint">-</span>' ?></td></tr>
                        <tr><th>Nomor Notifikasi</th><td data-label="Nomor Notifikasi"><?= $tka->notifikasi_no ?? '<span class="field-hint">-</span>' ?></td></tr>
                        <tr><th>Tanggal Notifikasi</th><td data-label="Tanggal Notifikasi"><?= $tka->notifikasi_date ? date('d-m-Y', strtotime($tka->notifikasi_date)) : '<span class="field-hint">-</span>' ?></td></tr>
                        <tr><th>Jabatan</th><td data-label="Jabatan"><?= $tka->jabatan ?? '<span class="field-hint">-</span>' ?></td></tr>
                        <tr><th>Tempat Lahir</th><td data-label="Tempat Lahir"><?= $tka->tempat_lahir ?? '<span class="field-hint">-</span>' ?></td></tr>
                        <tr><th>Tanggal Lahir</th><td data-label="Tanggal Lahir"><?= $tka->tanggal_lahir ? date('d-m-Y', strtotime($tka->tanggal_lahir)) : '<span class="field-hint">-</span>' ?></td></tr>
                        <tr><th>Kebangsaan</th><td data-label="Kebangsaan"><?= $tka->negara_asal ?? '<span class="field-hint">-</span>' ?></td></tr>
                        <tr><th>Jenis Kelamin</th><td data-label="Jenis Kelamin"><?= $tka->jenis_kelamin ?? '<span class="field-hint">-</span>' ?></td></tr>
                        <tr><th>Alamat Tinggal</th><td data-label="Alamat Tinggal"><?= nl2br(htmlspecialchars($tka->alamat_tinggal ?? '-')) ?></td></tr>
                        <tr><th>Lokasi Kerja</th><td data-label="Lokasi Kerja"><?= $tka->lokasi_kerja ?? '<span class="field-hint">-</span>' ?></td></tr>
                        <tr><th>Jenis Notifikasi</th><td data-label="Jenis Notifikasi"><?= $tka->jenis_notifikasi ?? '-' ?></td></tr>
                        <tr><th>Masa Berlaku Notifikasi</th><td data-label="Masa Berlaku Notifikasi"><?= $tka->masa_berlaku_notifikasi ?? '-' ?></td></tr>
                        <tr><th>Lunas DKP</th><td data-label="Lunas DKP"><?= $tka->lunas_dkp ?? '-' ?></td></tr>
                        <tr><th>Bidang Usaha</th><td data-label="Bidang Usaha"><?= $tka->bidang_usaha ?? '-' ?></td></tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Riwayat Approval -->
        <div class="surface" style="margin-bottom:24px;">
            <div class="surface-header">
                <div class="surface-title">
                    <i class="fas fa-history"></i> Riwayat Approval
                </div>
            </div>
            <div class="surface-body">
                <?php if(!empty($logs)): ?>
                    <div class="timeline">
                        <?php 
                        $logs_sorted = array_reverse($logs);
                        foreach($logs_sorted as $log):
                            $is_sys     = is_system_log($log->catatan, $system_note_patterns);
                            $is_approve = ($log->status == 'approve');
                        ?>

                        <?php if($is_sys): ?>
                            <div class="timeline-item">
                                <div class="timeline-badge">
                                    <i class="fas fa-info-circle" style="color:var(--c-text-muted); font-size:13px;"></i>
                                </div>
                                <div>
                                    <strong style="color:var(--c-text-muted); font-weight:600;">Sistem</strong>
                                    <span class="badge" style="margin-left:8px; background:var(--c-surface-2); color:var(--c-text-muted); border:1px solid var(--c-border); font-size:0.65rem;">INFO</span>
                                    <br>
                                    <span class="field-hint"><?= date('d M Y H:i:s', strtotime($log->created_at)) ?></span>
                                    <?php if($log->catatan): ?>
                                        <div class="catatan-box system">
                                            <i class="fas fa-info-circle" style="margin-right:4px;"></i>
                                            <?= nl2br(htmlspecialchars($log->catatan)) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <?php
                            $badge_class = $is_approve ? 'badge-selesai' : 'badge-ditolak';
                            $icon        = $is_approve ? 'fa-check-circle' : 'fa-times-circle';
                            $icon_color  = $is_approve ? 'var(--c-selesai-text)' : 'var(--c-ditolak-text)';
                            ?>
                            <div class="timeline-item">
                                <div class="timeline-badge">
                                    <i class="fas <?= $icon ?>" style="color:<?= $icon_color ?>;"></i>
                                </div>
                                <div>
                                    <strong><?= ucfirst($log->role) ?></strong>
                                    <span class="badge <?= $badge_class ?>" style="margin-left:8px;"><?= strtoupper($log->status) ?></span>
                                    <br>
                                    <span class="field-hint"><?= date('d M Y H:i:s', strtotime($log->created_at)) ?></span>
                                    <?php if($log->catatan): ?>
                                        <div class="catatan-box <?= $is_approve ? '' : 'reject' ?>">
                                            <i class="fas fa-comment" style="margin-right:4px;"></i>
                                            <strong>Catatan:</strong> <?= nl2br(htmlspecialchars($log->catatan)) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <div class="empty-state-icon"><i class="fas fa-history"></i></div>
                        <h4>Belum ada proses approval</h4>
                        <p>Riwayat akan muncul setelah petugas melakukan aksi.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Form Approval -->
        <div class="surface">
            <div class="surface-header">
                <div class="surface-title">
                    <i class="fas fa-check-double"></i> Form Approval
                </div>
            </div>
            <div class="surface-body">
                <form action="<?= base_url('approval/process/'.$tka->id) ?>" method="post">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    
                    <div class="field-wrap">
                        <label for="catatan" class="field-label">Catatan <span class="field-hint">(wajib jika menolak)</span></label>
                        <textarea name="catatan" id="catatan" class="form-input" rows="4" placeholder="Tulis catatan approval..."></textarea>
                    </div>
                    
                    <div style="display:flex; gap:8px; flex-wrap:wrap;">
                        <button type="submit" name="action" value="approve" class="btn-primary" onclick="return confirm('Approve pengajuan ini?')">
                            <i class="fas fa-check"></i> Approve
                        </button>
                        <button type="submit" name="action" value="reject" class="btn-xs bx-delete" style="padding:9px 18px;font-size:0.82rem;" onclick="return confirm('Tolak pengajuan ini?')">
                            <i class="fas fa-times"></i> Reject
                        </button>
                        <a href="<?= base_url('approval/index') ?>" class="btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<?php $this->load->view('footer'); ?>

<!-- jQuery + Sidebar Mobile Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
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
        applyCollapse(!$sidebar.hasClass('collapsed'));
    });

    // Mobile elements
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