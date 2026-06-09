<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Nomor Surat — SITLAKEB TKA Admin</title>
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

        /* ── Hero ── */
        .doc-hero {
            background: linear-gradient(135deg, #1e40af 0%, #3b6dd4 100%);
            border-radius: var(--r-xl); padding: 24px 28px;
            display: flex; align-items: center; gap: 20px;
            margin-bottom: 20px; position: relative; overflow: hidden;
        }
        .doc-hero::before { content: ''; position: absolute; top: -40px; right: -40px; width: 180px; height: 180px; border-radius: 50%; background: rgba(255,255,255,0.06); }
        .doc-hero::after  { content: ''; position: absolute; bottom: -50px; right: 120px; width: 120px; height: 120px; border-radius: 50%; background: rgba(255,255,255,0.04); }
        .doc-hero-icon { width: 64px; height: 64px; border-radius: var(--r-lg); background: rgba(255,255,255,0.2); border: 2px solid rgba(255,255,255,0.25); display: flex; align-items: center; justify-content: center; font-size: 1.6rem; color: white; flex-shrink: 0; z-index: 1; }
        .doc-hero-info { flex: 1; z-index: 1; }
        .doc-hero-info .dh-name { font-family: var(--font-head); font-size: 1.1rem; font-weight: 800; color: white; margin-bottom: 3px; letter-spacing: -0.01em; }
        .doc-hero-info .dh-sub  { font-size: 0.78rem; color: rgba(255,255,255,0.75); display: flex; align-items: center; gap: 6px; }
        .doc-hero-info .dh-sub i { font-size: 10px; }
        .doc-hero-badges { display: flex; flex-direction: column; align-items: flex-end; gap: 6px; z-index: 1; }
        .hero-badge { display: inline-flex; align-items: center; gap: 5px; padding: 4px 12px; border-radius: 20px; font-size: 0.7rem; font-weight: 700; font-family: var(--font-head); }
        .hb-selesai { background: #4ade80; color: #064e3b; }
        .hb-locked  { background: rgba(255,255,255,0.18); color: rgba(255,255,255,0.85); }
        .hb-mode    { background: rgba(255,255,255,0.22); color: white; }

        /* ── Warning banner ── */
        .warn-banner { display: flex; align-items: flex-start; gap: 14px; background: #fffbeb; border: 1px solid #fde68a; border-radius: var(--r-lg); padding: 16px 20px; margin-bottom: 20px; }
        .warn-banner .wb-icon { width: 36px; height: 36px; flex-shrink: 0; border-radius: var(--r-sm); background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center; font-size: 14px; margin-top: 1px; }
        .warn-banner .wb-title { font-family: var(--font-head); font-size: 0.84rem; font-weight: 700; color: #92400e; margin-bottom: 4px; }
        .warn-banner .wb-body  { font-size: 0.8rem; color: #78350f; line-height: 1.6; }
        .warn-banner .wb-body strong { font-weight: 700; }

        /* ── 2-col layout ── */
        .main-grid { display: grid; grid-template-columns: 1fr 300px; gap: 20px; align-items: start; }

        /* ── Form grid ── */
        .form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 0; }
        .form-row { display: flex; align-items: flex-start; gap: 12px; padding: 16px 22px; border-bottom: 1px solid var(--c-border); }
        .form-row:nth-child(odd) { border-right: 1px solid var(--c-border); }
        .form-row:last-child,
        .form-row:nth-last-child(2):nth-child(odd) { border-bottom: none; }
        .form-row.full-width { grid-column: 1 / -1; border-right: none; }
        .form-icon { width: 32px; height: 32px; border-radius: var(--r-sm); background: #eff6ff; color: #3b82f6; display: flex; align-items: center; justify-content: center; font-size: 12px; flex-shrink: 0; margin-top: 6px; }
        .form-icon.locked { background: #f1f5f9; color: #94a3b8; }
        .form-field { flex: 1; }
        .form-label-inline { font-size: 0.67rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em; color: var(--c-text-muted); margin-bottom: 5px; display: block; }
        .form-control-clean { width: 100%; font-family: 'Courier New', monospace; font-size: 0.84rem; font-weight: 500; color: var(--c-primary); background: var(--c-surface, #fff); border: 1px solid var(--c-border); border-radius: var(--r-sm); padding: 7px 11px; transition: border-color 0.18s, box-shadow 0.18s; outline: none; }
        .form-control-clean:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px #eff6ff; }
        .form-control-clean:disabled { background: #f8fafc; color: #94a3b8; cursor: not-allowed; }
        .field-hint { font-size: 0.69rem; color: var(--c-text-muted); margin-top: 4px; display: flex; align-items: center; gap: 4px; }

        /* ── Info rows ── */
        .info-row { display: flex; align-items: flex-start; gap: 12px; padding: 14px 22px; border-bottom: 1px solid var(--c-border); }
        .info-row:last-child { border-bottom: none; }
        .info-icon { width: 32px; height: 32px; border-radius: var(--r-sm); background: var(--c-primary-light); color: var(--c-primary); display: flex; align-items: center; justify-content: center; font-size: 12px; flex-shrink: 0; margin-top: 1px; }
        .info-label { font-size: 0.67rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em; color: var(--c-text-muted); margin-bottom: 3px; }
        .info-value { font-size: 0.84rem; font-weight: 500; color: var(--c-text); }

        /* ── Status inline ── */
        .sts-inline { display: inline-flex; align-items: center; gap: 5px; padding: 3px 10px; border-radius: 6px; font-size: 0.68rem; font-weight: 700; font-family: var(--font-head); }
        .sts-inline::before { content: ''; width: 6px; height: 6px; border-radius: 50%; }
        .sts-selesai { background: #dcfce7; color: #15803d; }
        .sts-selesai::before { background: #10b981; }
        .sts-lainnya { background: #fef3c7; color: #92400e; }
        .sts-lainnya::before { background: #f59e0b; }

        /* ── Hamburger ── */
        .btn-hamburger { display: none; width: 36px; height: 36px; border-radius: 9px; border: 1px solid var(--c-border); background: var(--c-surface); align-items: center; justify-content: center; color: #64748b; font-size: 15px; cursor: pointer; flex-shrink: 0; transition: background .15s, color .15s; }
        .btn-hamburger:hover { background: var(--c-primary-light); color: var(--c-primary); }

        /* ══════════════════════════════════════════
           MOBILE  ≤ 768px
        ══════════════════════════════════════════ */
        @media (max-width: 768px) {
            .btn-hamburger { display: flex; }
            .topnav { padding: 0 14px; gap: 10px; }
            /* Sembunyikan breadcrumb tengah, tampilkan hanya halaman aktif */
            .topnav-breadcrumb a:not(:last-child),
            .topnav-breadcrumb .fa-chevron-right { display: none; }
            .page-content { padding: 14px; }

            /* Hero — lebih compact */
            .doc-hero { padding: 16px 18px; gap: 14px; margin-bottom: 14px; }
            .doc-hero-icon { width: 48px; height: 48px; font-size: 1.2rem; }
            .doc-hero-info .dh-name { font-size: 0.92rem; }
            .doc-hero-info .dh-sub  { font-size: 0.72rem; }
            .hero-badge { font-size: 0.65rem; padding: 3px 9px; }

            /* Warning banner */
            .warn-banner { padding: 12px 14px; gap: 10px; margin-bottom: 14px; }
            .warn-banner .wb-title { font-size: 0.8rem; }
            .warn-banner .wb-body  { font-size: 0.75rem; }

            /* 2-col grid → 1 col, aksi naik ke atas */
            .main-grid {
                grid-template-columns: 1fr;
                gap: 14px;
            }
            /* Pindahkan kolom kanan (aksi) ke urutan pertama di mobile */
            .main-grid > div:last-child  { order: -1; }
            .main-grid > div:first-child { order: 0; }

            /* Aksi card — tombol horizontal */
            .surface-body-actions { display: flex; flex-direction: row; gap: 8px; }
            .surface-body-actions .btn-primary,
            .surface-body-actions .btn-secondary { flex: 1; justify-content: center; }

            /* Form grid → 1 kolom */
            .form-grid { grid-template-columns: 1fr; }
            .form-row { border-right: none !important; padding: 12px 14px; }
            .form-row:last-child { border-bottom: none; }
            .form-row.full-width { border-right: none; }
            .form-control-clean { font-size: 0.82rem; padding: 9px 11px; }
            .field-hint { font-size: 0.67rem; }

            /* Info rows */
            .info-row { padding: 11px 14px; }
        }
    </style>
</head>
<body>

<?php $this->load->view('admin/sidebar'); ?>

<div class="page-wrapper">

    <header class="topnav">
        <div style="display:flex; align-items:center; gap:10px;">
            <button class="btn-hamburger" id="btnHamburger" type="button" aria-label="Buka Menu">
                <i class="fas fa-bars"></i>
            </button>
            <div class="topnav-breadcrumb">
                <a href="<?= base_url('dashboard') ?>" style="color:var(--c-text-muted);text-decoration:none;"><i class="fas fa-home"></i></a>
                <i class="fas fa-chevron-right" style="font-size:8px;"></i>
                <a href="<?= base_url('admin/semua_tka') ?>" style="color:var(--c-text-muted);text-decoration:none;">Seluruh TKA</a>
                <i class="fas fa-chevron-right" style="font-size:8px;"></i>
                <strong>Edit Nomor Surat</strong>
            </div>
        </div>
        <div class="topnav-actions">
            <!--<a href="<?= base_url('admin/semua_tka') ?>" class="topnav-btn" title="Kembali">
                <i class="fas fa-arrow-left"></i>
            </a>-->
        </div>
    </header>

    <main class="page-content">

        <?php $isSelesai = ($tka->status === 'SELESAI'); ?>

        <!-- Hero -->
        <div class="doc-hero">
            <div class="doc-hero-icon"><i class="fas fa-file-signature"></i></div>
            <div class="doc-hero-info">
                <div class="dh-name"><?= htmlspecialchars($tka->nama_tka) ?></div>
                <div class="dh-sub">
                    <i class="fas fa-building"></i>
                    <?= htmlspecialchars($tka->perusahaan ?? '-') ?>
                </div>
            </div>
            <div class="doc-hero-badges">
                <?php if($isSelesai): ?>
                    <span class="hero-badge hb-selesai"><i class="fas fa-check-circle"></i> Selesai</span>
                    <span class="hero-badge hb-mode"><i class="fas fa-pen-to-square"></i> Mode Edit</span>
                <?php else: ?>
                    <span class="hero-badge hb-locked"><i class="fas fa-lock"></i> Terkunci</span>
                <?php endif; ?>
            </div>
        </div>

        <?php if(!$isSelesai): ?>
        <div class="warn-banner">
            <div class="wb-icon"><i class="fas fa-triangle-exclamation"></i></div>
            <div>
                <div class="wb-title">Nomor Surat Belum Dapat Diedit</div>
                <div class="wb-body">
                    Nomor surat hanya dapat diedit jika status pengajuan sudah <strong>SELESAI</strong>.
                    Status saat ini: <strong><?= $tka->status ?></strong>. Selesaikan proses approval terlebih dahulu.
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="main-grid">

            <!-- LEFT: Info + Form -->
            <div>
                <!-- Info TKA (readonly) -->
                <div class="surface" style="margin-bottom:16px;">
                    <div class="surface-header">
                        <div class="surface-title">
                            <i class="fas fa-circle-info" style="color:#3b82f6;"></i>
                            Info Pengajuan
                        </div>
                    </div>
                    <div>
                        <div class="info-row">
                            <div class="info-icon"><i class="fas fa-user-tie"></i></div>
                            <div>
                                <div class="info-label">Nama TKA</div>
                                <div class="info-value"><?= htmlspecialchars($tka->nama_tka) ?></div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-icon"><i class="fas fa-building"></i></div>
                            <div>
                                <div class="info-label">Perusahaan</div>
                                <div class="info-value"><?= htmlspecialchars($tka->perusahaan ?? '-') ?></div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-icon"><i class="fas fa-circle-dot"></i></div>
                            <div>
                                <div class="info-label">Status Pengajuan</div>
                                <div class="info-value" style="margin-top:2px;">
                                    <?php if($isSelesai): ?>
                                        <span class="sts-inline sts-selesai">Selesai</span>
                                    <?php else: ?>
                                        <span class="sts-inline sts-lainnya"><?= $tka->status ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form nomor surat -->
                <div class="surface">
                    <div class="surface-header">
                        <div class="surface-title">
                            <i class="fas fa-hashtag" style="color:#3b82f6;"></i>
                            Nomor Surat
                            <?php if(!$isSelesai): ?>
                                <span style="background:#fef3c7;color:#92400e;padding:2px 8px;border-radius:20px;font-size:0.67rem;font-weight:600;">
                                    <i class="fas fa-lock" style="font-size:9px;"></i> Terkunci
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <form action="<?= base_url('admin/update_nomor_surat/'.$tka->id) ?>" method="post"
                          <?= !$isSelesai ? 'style="pointer-events:none;opacity:0.6;"' : '' ?>>
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <div class="form-grid">
                            <div class="form-row">
                                <div class="form-icon <?= !$isSelesai ? 'locked' : '' ?>"><i class="fas fa-paper-plane"></i></div>
                                <div class="form-field">
                                    <label class="form-label-inline" for="nomor_keluar">Nomor Surat Keluar</label>
                                    <input type="text" id="nomor_keluar" name="nomor_surat_keluar"
                                           class="form-control-clean"
                                           value="<?= htmlspecialchars($tka->nomor_surat_keluar ?? '') ?>"
                                           placeholder="005/HR/WI/I/2026"
                                           <?= !$isSelesai ? 'disabled' : 'required' ?>>
                                    <div class="field-hint"><i class="fas fa-circle-info" style="font-size:9px;"></i> Surat dari Disnaker</div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-icon <?= !$isSelesai ? 'locked' : '' ?>"><i class="fas fa-inbox"></i></div>
                                <div class="form-field">
                                    <label class="form-label-inline" for="nomor_permohonan">Nomor Surat Permohonan</label>
                                    <input type="text" id="nomor_permohonan" name="nomor_surat_permohonan"
                                           class="form-control-clean"
                                           value="<?= htmlspecialchars($tka->nomor_surat_permohonan ?? '') ?>"
                                           placeholder="005/HR/VI/2026"
                                           <?= !$isSelesai ? 'disabled' : 'required' ?>>
                                    <div class="field-hint"><i class="fas fa-circle-info" style="font-size:9px;"></i> Surat dari perusahaan</div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- RIGHT: Aksi + Panduan -->
            <div>
                <div class="surface">
                    <div class="surface-header">
                        <div class="surface-title"><i class="fas fa-bolt" style="color:#f59e0b;"></i> Aksi</div>
                    </div>
                    <div class="surface-body-actions" style="padding:16px; display:flex; flex-direction:column; gap:8px;">
                        <?php if($isSelesai): ?>
                            <button type="submit" onclick="document.querySelector('form').submit();"
                                    class="btn-primary" style="justify-content:center; border:none; cursor:pointer;">
                                <i class="fas fa-floppy-disk"></i> Simpan & Setujui
                            </button>
                        <?php else: ?>
                            <button class="btn-primary" disabled style="justify-content:center; opacity:0.45; cursor:not-allowed; border:none;">
                                <i class="fas fa-lock"></i> Tidak Dapat Diedit
                            </button>
                        <?php endif; ?>
                        <a href="<?= base_url('admin/semua_tka') ?>" class="btn-secondary" style="justify-content:center;">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="surface" style="margin-top:14px;">
                    <div class="surface-header">
                        <div class="surface-title"><i class="fas fa-lightbulb" style="color:#f59e0b;"></i> Panduan</div>
                    </div>
                    <div style="padding:14px 18px;">
                        <div style="font-size:0.78rem;color:var(--c-text-muted);line-height:1.7;">
                            <div style="display:flex;gap:8px;margin-bottom:8px;">
                                <i class="fas fa-circle-check" style="color:#10b981;margin-top:3px;font-size:10px;flex-shrink:0;"></i>
                                <span>Nomor surat <strong>hanya bisa diedit</strong> setelah status <strong>SELESAI</strong>.</span>
                            </div>
                            <div style="display:flex;gap:8px;margin-bottom:8px;">
                                <i class="fas fa-circle-check" style="color:#10b981;margin-top:3px;font-size:10px;flex-shrink:0;"></i>
                                <span><strong>Surat Keluar</strong> adalah nomor resmi dari Disnaker.</span>
                            </div>
                            <div style="display:flex;gap:8px;">
                                <i class="fas fa-circle-check" style="color:#10b981;margin-top:3px;font-size:10px;flex-shrink:0;"></i>
                                <span><strong>Surat Permohonan</strong> adalah nomor dari perusahaan.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /main-grid -->
    </main>

    <?php $this->load->view('footer'); ?>
</div>

<script>
(function () {
    function initHamburger() {
        var btn = document.getElementById('btnHamburger');
        if (!btn) return;
        btn.addEventListener('click', function (e) {
            e.preventDefault(); e.stopPropagation();
            if (typeof window.openAdminSidebar === 'function') {
                window.openAdminSidebar();
            } else {
                var sb = document.getElementById('adminSidebar');
                var ov = document.getElementById('adminOverlay');
                if (sb) sb.classList.add('mobile-open');
                if (ov) ov.classList.add('show');
                document.body.classList.add('body-no-scroll');
            }
        });
    }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', initHamburger);
    else initHamburger();
})();
</script>
</body>
</html>