<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kirim Notifikasi — Operator SITLAKEB</title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Shared Design System -->
    <link rel="stylesheet" href="<?= base_url('assets/css/shared.css') ?>">

    <style>
        /* ============================================================
           MOBILE-RESPONSIVE — Kirim Notifikasi
           Breakpoint utama: <= 768px (mobile), > 768px (desktop)
        ============================================================ */

        /* --- Layout Utama ----------------------------------------- */
        .notif-layout {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 20px;
            align-items: start;
        }

        /* --- Radio Card (pengganti radio button biasa) ------------- */
        .radio-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 4px;
        }

        .radio-card {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border: 1px solid var(--c-border);
            border-radius: var(--r-md);
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 500;
            transition: border-color 0.15s, background 0.15s;
            user-select: none;
            -webkit-user-select: none;
        }

        .radio-card input[type="radio"] {
            display: none; /* Sembunyikan radio asli, gunakan tampilan card */
        }

        .radio-card i {
            font-size: 1rem;
            color: var(--c-text-muted);
        }

        .radio-card.active {
            border-color: var(--c-primary);
            background: color-mix(in srgb, var(--c-primary) 6%, var(--c-bg));
            color: var(--c-primary);
        }

        .radio-card.active i {
            color: var(--c-primary);
        }

        /* --- Template Grid ---------------------------------------- */
        .tpl-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .tpl-card {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 0;
            padding: 12px;
            border: 1px solid var(--c-border);
            border-radius: var(--r-md);
            background: transparent;
            cursor: pointer;
            text-align: left;
            width: 100%;
            transition: border-color 0.15s, background 0.15s;
        }

        .tpl-card:hover {
            background: var(--c-surface-2);
        }

        .tpl-card.active {
            border: 1.5px solid var(--c-primary);
            background: color-mix(in srgb, var(--c-primary) 5%, var(--c-bg));
        }

        .tpl-icon {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 8px;
        }

        .tpl-icon i {
            font-size: 0.9rem;
        }

        .tpl-name {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--c-text);
            line-height: 1.3;
        }

        .tpl-desc {
            display: block;
            font-size: 0.7rem;
            color: var(--c-text-muted);
            margin-top: 2px;
            line-height: 1.4;
        }

        /* --- Preview Box ------------------------------------------ */
        .preview-box {
            background: var(--c-bg);
            border: 1px dashed var(--c-border);
            border-radius: var(--r-md);
            padding: 14px;
            min-height: 80px;
        }

        .preview-empty {
            color: #cbd5e1;
            font-style: italic;
            font-size: 0.82rem;
            text-align: center;
            padding: 6px 0;
        }

        .preview-title {
            font-family: var(--font-head);
            font-weight: 700;
            color: var(--c-text);
            margin-bottom: 6px;
            font-size: 0.9rem;
        }

        .preview-msg {
            font-size: 0.8rem;
            color: var(--c-text-muted);
            line-height: 1.6;
        }

        /* --- Template Selected Info ------------------------------- */
        .tpl-selected-wrap {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-top: 10px;
            background: var(--c-surface-2);
            border-radius: var(--r-md);
            padding: 10px 12px;
        }

        .tpl-selected-info {
            flex: 1;
        }

        .tpl-selected-info strong {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 2px;
        }

        .tpl-selected-info p {
            font-size: 0.72rem;
            color: var(--c-text-muted);
            line-height: 1.4;
        }

        /* --- Char Counter ----------------------------------------- */
        .char-count {
            font-size: 0.72rem;
            color: var(--c-text-muted);
            text-align: right;
            margin-top: 4px;
        }

        /* --- Link Field dengan Prefix ----------------------------- */
        .link-field-wrap {
            display: flex;
            align-items: center;
            border: 1px solid var(--c-border);
            border-radius: var(--r-md);
            overflow: hidden;
            transition: border-color 0.15s;
        }

        .link-field-wrap:focus-within {
            border-color: var(--c-primary);
        }

        .link-field-prefix {
            padding: 0 10px;
            height: 40px;
            display: flex;
            align-items: center;
            background: var(--c-surface-2);
            border-right: 1px solid var(--c-border);
            color: var(--c-text-muted);
            font-size: 0.85rem;
            flex-shrink: 0;
        }

        .link-field-wrap .form-input {
            border: none !important;
            border-radius: 0 !important;
            flex: 1;
            min-width: 0;
        }

        .link-field-wrap .form-input:focus {
            box-shadow: none !important;
        }

        /* --- Aksi Tombol ------------------------------------------ */
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        /* --- Btn xs ----------------------------------------------- */
        .btn-xs {
            padding: 4px 10px;
            border: 1px solid var(--c-border);
            border-radius: 6px;
            background: transparent;
            font-size: 0.72rem;
            cursor: pointer;
            color: var(--c-text-muted);
            display: inline-flex;
            align-items: center;
            gap: 4px;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .btn-xs:hover {
            background: var(--c-surface-2);
        }

        /* ============================================================
           MOBILE STYLES (max-width: 768px)
        ============================================================ */
        @media (max-width: 768px) {

            /* Layout: grid 2 kolom → 1 kolom */
            .notif-layout {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            

            /* Template: tampilkan di baris atas, lebih compact */
            .tpl-grid {
                grid-template-columns: 1fr 1fr;
                gap: 8px;
            }

            .tpl-card {
                padding: 10px;
            }

            .tpl-icon {
                width: 28px;
                height: 28px;
                margin-bottom: 6px;
            }

            .tpl-name {
                font-size: 0.75rem;
            }

            .tpl-desc {
                font-size: 0.68rem;
            }

            /* Tombol Aksi: vertikal → horizontal di mobile */
            .action-buttons {
                flex-direction: row;
            }

            .action-buttons .btn-primary,
            .action-buttons .btn-secondary {
                flex: 1;
                justify-content: center;
            }

            /* Radio card: tetap 2 kolom, tap target lebih besar */
            .radio-group {
                gap: 8px;
            }

            .radio-card {
                padding: 10px 10px;
                font-size: 0.82rem;
            }

            /* Surface body padding sedikit dikurangi */
            .surface-body {
                padding: 14px;
            }

            /* Page header lebih ringkas */
            .page-title {
                font-size: 1.1rem;
            }

            .page-subtitle {
                font-size: 0.8rem;
            }

            /* Preview box min-height lebih kecil */
            .preview-box {
                min-height: 60px;
            }
        }

        @media (max-width: 480px) {
            /* Layar sangat kecil: padding konten dikurangi */
            .page-content {
                padding: 12px;
            }

            .radio-card {
                flex-direction: column;
                align-items: center;
                gap: 4px;
                text-align: center;
                padding: 10px 6px;
            }

            .radio-card i {
                font-size: 1.1rem;
            }
        }
    </style>
</head>
<body>

<?php $this->load->view('operator/sidebar'); ?>

<div class="page-wrapper">

    <!-- Top Navigation -->
    <div class="topnav">
        <div class="topnav-breadcrumb">
            <a href="<?= base_url('operator/dashboard') ?>" style="color:var(--c-text-muted); text-decoration:none;">
                <i class="fas fa-home"></i>
            </a>
            <i class="fas fa-chevron-right" style="font-size:8px;"></i>
            <strong>Kirim Notifikasi</strong>
        </div>
    </div>

    <div class="page-content">

        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-paper-plane" style="color:var(--c-primary); margin-right:8px;"></i>
                Kirim Notifikasi Manual
            </h1>
            <p class="page-subtitle">Kirim notifikasi langsung ke satu perusahaan atau semua perusahaan terdaftar.</p>
        </div>

        <!-- Flash Messages -->
        <?php if($this->session->flashdata('success')): ?>
        <div class="alert-form" style="background:#f0fdf4; border:1px solid #a7f3d0; color:#065f46; margin-bottom:16px;">
            <i class="fas fa-circle-check"></i> <?= $this->session->flashdata('success') ?>
        </div>
        <?php endif; ?>
        <?php if($this->session->flashdata('error')): ?>
        <div class="alert-form alert-danger" style="margin-bottom:16px;">
            <i class="fas fa-circle-exclamation"></i> <?= $this->session->flashdata('error') ?>
        </div>
        <?php endif; ?>

        <form action="<?= base_url('operator/kirim_notifikasi_action') ?>" method="post" id="formNotif">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

            <!-- Di mobile: notif-col-right (template + aksi) akan naik via order:-1 -->
            <div class="notif-layout">

                <!-- ================================================
                     KOLOM KIRI: Form Isi Notifikasi
                ================================================ -->
                <div class="notif-col-left">
                    <div class="surface">
                        <div class="surface-header">
                            <div class="surface-title">
                                <i class="fas fa-envelope"></i> Isi Notifikasi
                            </div>
                        </div>

                        <div class="surface-body">

                            <!-- MODE PENGIRIMAN -->
                            <div class="field-wrap">
                                <label class="field-label required">Tujuan Pengiriman</label>

                                <div class="radio-group">
                                    <!-- Card: Perusahaan Tertentu -->
                                    <label class="radio-card active" id="card-single" onclick="setMode('single')">
                                        <input type="radio" name="send_mode" value="single" checked>
                                        <i class="fas fa-building"></i>
                                        <span>Perusahaan Tertentu</span>
                                    </label>
                                    <!-- Card: Semua Perusahaan -->
                                    <label class="radio-card" id="card-all" onclick="setMode('all')">
                                        <input type="radio" name="send_mode" value="all">
                                        <i class="fas fa-users"></i>
                                        <span>Semua Perusahaan</span>
                                    </label>
                                </div>
                            </div>

                            <!-- PILIH PERUSAHAAN (hanya muncul jika mode single) -->
                            <div class="field-wrap" id="user-select-wrapper">
                                <label class="field-label required" for="user_id">Pilih Perusahaan</label>
                                <select name="user_id" id="user_id" class="form-select" required>
                                    <option value="">— Pilih Perusahaan —</option>
                                    <?php
                                    $perusahaan_list = $this->db->where('role','user')->get('users')->result();
                                    foreach($perusahaan_list as $u): ?>
                                    <option value="<?= $u->id ?>">
                                        <?= htmlspecialchars($u->perusahaan) ?> (<?= htmlspecialchars($u->email) ?>)
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- JUDUL -->
                            <div class="field-wrap">
                                <label class="field-label required" for="input-title">Judul Notifikasi</label>
                                <input type="text" name="title" id="input-title" class="form-input"
                                       placeholder="Contoh: Surat Keterangan TKA Telah Siap"
                                       maxlength="150"
                                       required>
                            </div>

                            <!-- PESAN -->
                            <div class="field-wrap">
                                <label class="field-label required" for="input-message">Pesan Notifikasi</label>
                                <textarea name="message" id="input-message" class="form-input"
                                          rows="5"
                                          placeholder="Tulis pesan notifikasi di sini..."
                                          maxlength="500"
                                          required></textarea>
                                <div class="char-count"><span id="char-count">0</span> / 500 karakter</div>
                            </div>

                            <!-- LINK (dengan prefix icon) -->
                            <div class="field-wrap">
                                <label class="field-label" for="input-link">
                                    Link Tujuan <span class="field-hint">(opsional)</span>
                                </label>
                                <div class="link-field-wrap">
                                    <span class="link-field-prefix">
                                        <i class="fas fa-link"></i>
                                    </span>
                                    <input type="text" name="link" id="input-link" class="form-input"
                                           placeholder="/user/data_tka atau https://...">
                                </div>
                            </div>

                            <!-- PREVIEW -->
                            <div class="field-wrap" style="margin-bottom:0;">
                                <label class="field-label">Preview Notifikasi</label>
                                <div class="preview-box" id="preview-box">
                                    <div class="preview-empty" id="preview-empty">
                                        Isi judul dan pesan untuk melihat preview.
                                    </div>
                                    <div id="preview-content" style="display:none;">
                                        <div class="preview-title" id="preview-title"></div>
                                        <div class="preview-msg"   id="preview-msg"></div>
                                    </div>
                                </div>
                            </div>

                        </div><!-- /surface-body -->
                    </div><!-- /surface -->
                </div><!-- /notif-col-left -->

                <!-- ================================================
                     KOLOM KANAN: Template + Aksi
                     Di mobile: naik ke atas via CSS order:-1
                ================================================ -->
                <div class="notif-col-right">

                    <!-- TEMPLATE CEPAT -->
                    <div class="surface" style="margin-bottom:12px;">
                        <div class="surface-header">
                            <div class="surface-title">
                                <i class="fas fa-wand-magic-sparkles"></i> Template Cepat
                            </div>
                        </div>
                        <div class="surface-body">
                            <p class="field-hint" style="margin-bottom:12px;">
                                Klik template untuk mengisi form otomatis.
                            </p>

                            <div class="tpl-grid">

                                <!-- Surat Selesai -->
                                <button type="button" class="tpl-card" id="tpl-1"
                                        onclick="fillTemplate(1, this)">
                                    <div class="tpl-icon" style="background:#f0fdf4;">
                                        <i class="fas fa-file-circle-check" style="color:#10b981;"></i>
                                    </div>
                                    <span class="tpl-name">Surat Selesai</span>
                                    <span class="tpl-desc">Surat TKA siap diunduh.</span>
                                </button>

                                <!-- Verifikasi -->
                                <button type="button" class="tpl-card" id="tpl-2"
                                        onclick="fillTemplate(2, this)">
                                    <div class="tpl-icon" style="background:#eff6ff;">
                                        <i class="fas fa-circle-check" style="color:#3b82f6;"></i>
                                    </div>
                                    <span class="tpl-name">Verifikasi</span>
                                    <span class="tpl-desc">Pengajuan disetujui.</span>
                                </button>

                                <!-- Perlu Dilengkapi -->
                                <button type="button" class="tpl-card" id="tpl-3"
                                        onclick="fillTemplate(3, this)">
                                    <div class="tpl-icon" style="background:#fffbeb;">
                                        <i class="fas fa-triangle-exclamation" style="color:#d97706;"></i>
                                    </div>
                                    <span class="tpl-name">Perlu Dilengkapi</span>
                                    <span class="tpl-desc">Minta kelengkapan data.</span>
                                </button>

                                <!-- Pengumuman (set mode all otomatis) -->
                                <button type="button" class="tpl-card" id="tpl-4"
                                        onclick="fillTemplate(4, this, 'all')">
                                    <div class="tpl-icon" style="background:#f1f5f9;">
                                        <i class="fas fa-bullhorn" style="color:#475569;"></i>
                                    </div>
                                    <span class="tpl-name">Pengumuman</span>
                                    <span class="tpl-desc">Info penting ke semua.</span>
                                </button>

                            </div><!-- /tpl-grid -->

                            <!-- Info template yang dipilih -->
                            <div id="tpl-selected" style="display:none;" class="tpl-selected-wrap">
                                <div class="tpl-selected-info">
                                    <strong id="detail-title"></strong>
                                    <p id="detail-msg"></p>
                                </div>
                                <button type="button" class="btn-xs" onclick="clearTemplate()">
                                    <i class="fas fa-xmark"></i> Hapus
                                </button>
                            </div>

                        </div><!-- /surface-body -->
                    </div><!-- /surface template -->

                    <!-- TOMBOL AKSI -->
                    <div class="surface">
                        <div class="surface-header">
                            <div class="surface-title">
                                <i class="fas fa-bolt"></i> Aksi
                            </div>
                        </div>
                        <div class="surface-body">
                            <div class="action-buttons">
                                <button type="button" class="btn-secondary" onclick="resetForm()">
                                    <i class="fas fa-rotate-left"></i> Reset
                                </button>
                                <button type="submit" class="btn-primary">
                                    <i class="fas fa-paper-plane"></i> Kirim Notifikasi
                                </button>
                            </div>
                        </div>
                    </div>

                </div><!-- /notif-col-right -->

            </div><!-- /notif-layout -->
        </form>

    </div><!-- /page-content -->

    <?php $this->load->view('footer'); ?>
</div><!-- /page-wrapper -->

<script>
/* ============================================================
   Data template notifikasi
============================================================ */
var templates = {
    1: {
        title  : 'Surat Keterangan TKA Siap',
        message: 'Surat keterangan untuk TKA atas nama [Nama TKA] telah selesai diproses. Silakan unduh dokumen di menu Data TKA.',
        link   : '/user/data_tka'
    },
    2: {
        title  : 'Verifikasi TKA Berhasil',
        message: 'Pengajuan TKA Anda telah diverifikasi dan disetujui oleh petugas. Status terkini dapat dilihat pada dashboard Anda.',
        link   : '/user/dashboard'
    },
    3: {
        title  : 'Data TKA Perlu Dilengkapi',
        message: 'Terdapat data detail TKA Anda yang belum lengkap. Harap segera lengkapi melalui menu Data TKA agar proses dapat dilanjutkan.',
        link   : '/user/data_tka'
    },
    4: {
        title  : 'Pengumuman Penting dari Disnaker',
        message: 'Terdapat pembaruan informasi dari Dinas Ketenagakerjaan Kota Bekasi. Mohon perhatikan informasi terbaru di website resmi kami.',
        link   : ''
    }
};

/* ============================================================
   Toggle tampilan radio card & select perusahaan
============================================================ */
function setMode(mode) {
    var isAll = (mode === 'all');

    /* Sinkronkan input radio tersembunyi */
    document.querySelector('input[name="send_mode"][value="' + mode + '"]').checked = true;

    /* Aktifkan / nonaktifkan tampilan card */
    document.getElementById('card-single').classList.toggle('active', !isAll);
    document.getElementById('card-all').classList.toggle('active',  isAll);

    /* Tampilkan / sembunyikan select perusahaan */
    var wrapper = document.getElementById('user-select-wrapper');
    var select  = document.getElementById('user_id');
    if (isAll) {
        wrapper.style.display = 'none';
        select.removeAttribute('required');
        select.value = '';
    } else {
        wrapper.style.display = '';
        select.setAttribute('required', 'required');
    }
}

/* ============================================================
   Isi form dari template
============================================================ */
function fillTemplate(id, btn, mode) {
    var tpl = templates[id];
    if (!tpl) return;

    /* Isi field */
    document.getElementById('input-title').value   = tpl.title;
    document.getElementById('input-message').value = tpl.message;
    document.getElementById('input-link').value    = tpl.link;

    /* Reset semua border template, aktifkan yang dipilih */
    for (var i = 1; i <= 4; i++) {
        document.getElementById('tpl-' + i).classList.remove('active');
    }
    btn.classList.add('active');

    /* Atur mode jika perlu */
    setMode(mode === 'all' ? 'all' : 'single');

    /* Tampilkan info template yang dipilih */
    document.getElementById('detail-title').textContent = tpl.title;
    document.getElementById('detail-msg').textContent   = tpl.message.length > 80
        ? tpl.message.substring(0, 80) + '…'
        : tpl.message;
    document.getElementById('tpl-selected').style.display = 'flex';

    updatePreview();
    updateCharCount();
}

/* ============================================================
   Hapus pilihan template
============================================================ */
function clearTemplate() {
    for (var i = 1; i <= 4; i++) {
        document.getElementById('tpl-' + i).classList.remove('active');
    }
    document.getElementById('tpl-selected').style.display = 'none';
}

/* ============================================================
   Reset seluruh form
============================================================ */
function resetForm() {
    document.getElementById('input-title').value   = '';
    document.getElementById('input-message').value = '';
    document.getElementById('input-link').value    = '';
    document.getElementById('user_id').value       = '';
    clearTemplate();
    setMode('single');
    updatePreview();
    updateCharCount();
}

/* ============================================================
   Update preview notifikasi real-time
============================================================ */
function updatePreview() {
    var title = document.getElementById('input-title').value.trim();
    var msg   = document.getElementById('input-message').value.trim();

    if (title || msg) {
        document.getElementById('preview-empty').style.display   = 'none';
        document.getElementById('preview-content').style.display = 'block';
        document.getElementById('preview-title').textContent = title || '(Judul belum diisi)';
        document.getElementById('preview-msg').textContent   = msg   || '(Pesan belum diisi)';
    } else {
        document.getElementById('preview-empty').style.display   = 'block';
        document.getElementById('preview-content').style.display = 'none';
    }
}

/* ============================================================
   Update penghitung karakter
============================================================ */
function updateCharCount() {
    var len = document.getElementById('input-message').value.length;
    document.getElementById('char-count').textContent = len;
}

/* ============================================================
   Event listeners
============================================================ */
document.getElementById('input-title').addEventListener('input', updatePreview);
document.getElementById('input-message').addEventListener('input', function () {
    updatePreview();
    updateCharCount();
});

/* Inisialisasi saat halaman dimuat */
document.addEventListener('DOMContentLoaded', function () {
    setMode('single');
    updateCharCount();
});
</script>
</body>
</html>