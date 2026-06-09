<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lengkapi Detail — <?= isset($tka) && is_object($tka) ? htmlspecialchars($tka->nama_tka) : 'Error' ?></title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/shared.css') ?>">
    <style>

        /* ── Form controls ── */
        .form-control,
        .form-select {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #dce3e9 !important;
            border-radius: 10px !important;
            background: #ffffff !important;
            font-family: var(--font-body) !important;
            font-size: 0.84rem !important;
            color: var(--c-text) !important;
            outline: none;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02) !important;
            transition: all 0.2s ease;
            -webkit-appearance: none;
            appearance: none;
        }
        .form-control:focus,
        .form-select:focus {
            border-color: var(--c-primary) !important;
            box-shadow: 0 0 0 4px rgba(26,107,82,0.08), 0 2px 6px rgba(0,0,0,0.04) !important;
        }
        .form-control::placeholder { color: #a6b6c3; }
        textarea.form-control { resize: vertical; min-height: 80px; }
        .form-select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%238fa0b3' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") !important;
            background-repeat: no-repeat !important;
            background-position: right 14px center !important;
            padding-right: 38px !important;
        }

        /* ── Labels ── */
        .form-label {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 0.72rem;
            font-weight: 600;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 6px;
        }
        .form-label .opt {
            font-weight: 400; font-size: 0.68rem;
            text-transform: none; letter-spacing: 0;
            color: #94a3b8; margin-left: 2px;
        }
        .form-label.required::after {
            content: "*"; color: #ef4444;
            margin-left: 2px; font-size: 0.8rem;
        }
        .form-text {
            font-size: 0.68rem; color: #64748b;
            margin-top: 5px; display: flex;
            align-items: center; gap: 4px;
        }

        /* ── Layout desktop ── */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px 22px;
        }
        .form-grid .span-full { grid-column: 1 / -1; }
        .field { margin-bottom: 0; }
        .surf-body { padding: 28px; }

        /* ── Section divider ── */
        .section-divider {
            grid-column: 1 / -1;
            margin: 20px 0 6px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #64748b;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.07em;
        }
        .section-divider::before,
        .section-divider::after {
            content: ""; flex: 1;
            height: 1px; background: #e2e8f0;
        }

        /* ── Section icon ── */
        .section-icon {
            width: 36px; height: 36px;
            border-radius: 10px;
            background: #ecfdf5; color: #0f766e;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; margin-right: 10px;
        }

        /* ── Info strip ── */
        .info-strip {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            border-left: 4px solid #0ea5e9;
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 0.82rem;
            color: #0c4a6e;
            margin-bottom: 24px;
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }
        .info-strip i { color: #0ea5e9; margin-top: 2px; }

        /* ── Action bar (sticky bottom) ── */
        .action-bar {
            position: sticky;
            bottom: 0;
            z-index: 50;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-top: 1px solid #e2e8f0;
            padding: 14px 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            border-radius: 0 0 16px 16px;
            margin-top: 28px;
        }
        .btn-save {
            background: var(--c-primary);
            color: white; border: none;
            border-radius: 40px;
            padding: 0 28px; height: 44px;
            font-family: var(--font-body);
            font-size: 0.86rem; font-weight: 600;
            cursor: pointer;
            display: inline-flex; align-items: center; gap: 8px;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(26,107,82,0.3);
        }
        .btn-save:hover {
            background: #145c44;
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(26,107,82,0.35);
        }
        .btn-save:active { transform: translateY(0); }
        .btn-lewati {
            background: #ffffff; color: #475569;
            border: 1px solid #cbd5e1;
            border-radius: 40px;
            padding: 0 24px; height: 44px;
            font-family: var(--font-body);
            font-size: 0.86rem; font-weight: 600;
            cursor: pointer; text-decoration: none;
            display: inline-flex; align-items: center; gap: 8px;
            transition: all 0.2s ease;
        }
        .btn-lewati:hover {
            background: #f8fafc;
            border-color: #94a3b8;
            color: #0f172a; text-decoration: none;
        }

        /* ── Notifikasi 3-col (desktop) ── */
        .notif-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 18px;
        }

        /* ── Lahir+gender mini grid ── */
        .dob-gender-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        /* ─────────────────────────────────────
           MOBILE OVERRIDES (≤ 768px)
        ───────────────────────────────────── */
        @media (max-width: 768px) {

            .page-content { padding: 12px !important; }

            /* page header */
            .page-header-row {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 10px !important;
                margin-bottom: 14px !important;
            }
            .page-header-row h2 { font-size: 1rem !important; }
            .page-header-row .back-link { font-size: 0.75rem !important; }

            /* surface */
            .surface { border-radius: 16px !important; }
            .surface-header { padding: 14px 16px !important; }
            .surface-title  { font-size: 0.88rem !important; }
            .surf-body      { padding: 16px !important; }

            /* info strip */
            .info-strip {
                padding: 12px 14px !important;
                font-size: 0.78rem !important;
                border-radius: 12px !important;
                margin-bottom: 14px !important;
                gap: 10px !important;
            }

            /* form grid: 1 kolom */
            .form-grid {
                grid-template-columns: 1fr !important;
                gap: 14px !important;
            }
            .form-grid .span-full { grid-column: 1 !important; }

            /* kolom kiri & kanan: jadi 1 kolom, tampilkan semua field vertikal */
            .form-grid > div { display: flex; flex-direction: column; gap: 14px; }

            /* notif 3-col → 1 kolom */
            .notif-grid {
                grid-template-columns: 1fr !important;
                gap: 14px !important;
            }

            /* dob+gender: tetap 2 kolom di mobile (cukup lebar) */
            .dob-gender-grid { gap: 10px !important; }

            /* form controls: font 16px cegah zoom iOS */
            .form-control,
            .form-select { font-size: 16px !important; padding: 10px 12px !important; }

            /* labels */
            .form-label { font-size: 0.68rem !important; margin-bottom: 5px !important; }
            .form-text  { font-size: 0.65rem !important; }

            /* section divider */
            .section-divider {
                font-size: 0.65rem !important;
                margin: 14px 0 2px !important;
            }

            /* action bar: full width stack */
            .action-bar {
                padding: 12px 16px !important;
                border-radius: 0 0 16px 16px !important;
                gap: 8px !important;
                flex-direction: column !important;
            }
            .btn-save,
            .btn-lewati {
                width: 100% !important;
                justify-content: center !important;
                height: 48px !important;
                font-size: 0.9rem !important;
                border-radius: 14px !important;
            }
            .btn-save { order: 1; }
            .btn-lewati { order: 2; }
        }

        @media (max-width: 400px) {
            .page-content { padding: 10px !important; }
            .surf-body { padding: 14px !important; }
            .dob-gender-grid { grid-template-columns: 1fr !important; }
        }
    </style>
</head>
<body>

<?php $this->load->view('user/sidebar'); ?>

<div class="page-wrapper">

    <header class="topnav">
        <div class="topnav-breadcrumb">
            <a href="<?= base_url('dashboard') ?>" style="color:var(--c-text-muted);text-decoration:none;"><i class="fas fa-home"></i></a>
            <i class="fas fa-chevron-right" style="font-size:8px;"></i>
            <a href="<?= base_url('user/data_tka') ?>" style="color:var(--c-text-muted);text-decoration:none;">Data TKA</a>
            <i class="fas fa-chevron-right" style="font-size:8px;"></i>
            <strong>Lengkapi Detail</strong>
        </div>
        <div class="topnav-actions"></div>
    </header>

    <main class="page-content">

        <?php if(!isset($tka) || !is_object($tka)): ?>
            <div style="background:#fff1f2;border:1px solid #fecdd3;border-left:4px solid #f43f5e;border-radius:12px;padding:14px 18px;font-size:0.84rem;color:#9f1239;">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Data TKA tidak ditemukan.
                <a href="<?= base_url('user/data_tka') ?>" style="color:#9f1239;font-weight:700;margin-left:6px;">← Kembali</a>
            </div>
        <?php else: ?>

        <!-- Page header -->
        <div class="page-header-row" style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:12px;">
            <div>
                <h2 style="font-size:1.2rem;font-weight:700;margin:0;display:flex;align-items:center;gap:10px;">
                    <div class="section-icon"><i class="fas fa-user-edit"></i></div>
                    Lengkapi Data Detail TKA
                </h2>
                <div style="display:flex;align-items:center;gap:8px;margin-top:8px;flex-wrap:wrap;">
                    <span style="background:#ecfdf5;color:#0f766e;padding:3px 12px;border-radius:20px;font-size:0.73rem;font-weight:700;display:inline-flex;align-items:center;gap:5px;">
                        <i class="fas fa-user-tie" style="font-size:9px;"></i><?= htmlspecialchars($tka->nama_tka) ?>
                    </span>
                    <?php if($tka->status == 'DRAFT'): ?>
                    <span style="background:#f1f5f9;color:#475569;padding:3px 12px;border-radius:20px;font-size:0.73rem;font-weight:700;">Draft</span>
                    <?php endif; ?>
                </div>
            </div>
            <a href="<?= base_url('user/data_tka') ?>" class="back-link" style="color:#64748b;font-size:0.78rem;text-decoration:none;display:flex;align-items:center;gap:5px;">
                <i class="fas fa-arrow-left"></i> Kembali ke daftar
            </a>
        </div>

        <!-- Flash error -->
        <?php if($this->session->flashdata('error')): ?>
            <div style="background:#fff1f2;border:1px solid #fecdd3;border-left:4px solid #f43f5e;border-radius:12px;padding:12px 16px;font-size:0.82rem;color:#9f1239;margin-bottom:18px;">
                <i class="fas fa-exclamation-circle me-1"></i><?= $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>

        <!-- Info strip -->
        <?php if($tka->status == 'DRAFT'): ?>
        <div class="info-strip">
            <i class="fas fa-info-circle"></i>
            <span><strong>Lengkapi semua data wajib (*)</strong> — setelah disimpan, pengajuan akan otomatis masuk ke antrian verifikasi.</span>
        </div>
        <?php endif; ?>

        <!-- FORM -->
        <form action="<?= base_url('user/save_detail/'.$tka->id) ?>" method="post" id="detailForm">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

            <div class="surface" style="border-radius:16px;box-shadow:0 4px 24px rgba(0,0,0,0.04);">
                <div class="surface-header" style="padding:18px 28px;">
                    <div class="surface-title" style="font-size:0.95rem;">
                        <i class="fas fa-id-card" style="color:var(--c-primary);"></i> Formulir Data TKA
                    </div>
                </div>

                <div class="surf-body">
                    <div class="form-grid">

                        <!-- ─── KIRI: Dokumen ─── -->
                        <div>
                            <div class="field">
                                <label class="form-label required">Nomor Passport</label>
                                <input type="text" name="passport_no" class="form-control" required placeholder="M45608921">
                            </div>
                            <div class="field">
                                <label class="form-label required">Masa Berlaku Passport</label>
                                <input type="date" name="passport_expiry" class="form-control" required>
                            </div>
                            <div class="field">
                                <label class="form-label required">Nomor Kitas</label>
                                <input type="text" name="kitas_no" class="form-control" required placeholder="2D4564511LA8-B">
                            </div>
                            <div class="field">
                                <label class="form-label required">Nomor STM</label>
                                 <input type="text" name="stm_no" class="form-control" required placeholder="Nomor STM">
                            </div>
                            <div class="section-divider" style="grid-column:unset;"><span>Data RPTKA</span></div>
                            <div class="field">
                                <label class="form-label required">Nomor RPTKA</label>
                                <input type="text" name="rptka_no" class="form-control" required placeholder="B.3/54643/PK.04.00/VIII/2025">
                            </div>
                            <div class="field">
                                <label class="form-label required">Tanggal RPTKA</label>
                                <input type="date" name="rptka_date" class="form-control" required>
                            </div>
                        </div>

                        <!-- ─── KANAN: Data Pribadi ─── -->
                        <div>
                            <div class="field">
                                <label class="form-label required">Jabatan</label>
                                <input type="text" name="jabatan" class="form-control" required placeholder="Direktur Teknik">
                            </div>
                            <div class="field">
                                <label class="form-label required">Kebangsaan</label>
                                <input type="text" name="negara_asal" class="form-control" required placeholder="Tiongkok">
                            </div>
                            <div class="field">
                                <label class="form-label required">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control" required placeholder="Beijing">
                            </div>
                            <div class="dob-gender-grid">
                                <div class="field">
                                    <label class="form-label required">Tgl Lahir</label>
                                    <input type="date" name="tanggal_lahir" class="form-control" required>
                                </div>
                                <div class="field">
                                    <label class="form-label required">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-select" required>
                                        <option value="">—</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="field">
                                <label class="form-label required">Alamat Tinggal</label>
                                <textarea name="alamat_tinggal" class="form-control" rows="3" required placeholder="Alamat lengkap di Indonesia"></textarea>
                            </div>
                        </div>

                        <!-- ─── FULL WIDTH: Notifikasi & Pekerjaan ─── -->
                        <div class="section-divider span-full">
                            <span><i class="fas fa-bell" style="margin-right:4px;"></i> Notifikasi &amp; Pekerjaan</span>
                        </div>

                        <div class="span-full">
                            <div class="notif-grid">
                                <!-- Kolom 1 -->
                                <div style="display:flex;flex-direction:column;gap:14px;">
                                    <div class="field">
                                        <label class="form-label required">No Notifikasi</label>
                                        <input type="text" name="notifikasi_no" class="form-control" required placeholder="B.3/115909/...">
                                    </div>
                                    <div class="field">
                                        <label class="form-label required">Tgl Notifikasi</label>
                                        <input type="date" name="notifikasi_date" class="form-control" required>
                                    </div>
                                    <div class="field">
                                        <label class="form-label required">Jenis</label>
                                        <select name="jenis_notifikasi" class="form-select" required>
                                            <option value="">—</option>
                                            <option value="Baru">Baru</option>
                                            <option value="Perpanjangan">Perpanjangan</option>
                                            <option value="jangka pendek">Jangka Pendek</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- Kolom 2 -->
                                <div style="display:flex;flex-direction:column;gap:14px;">
                                    <div class="field">
                                        <label class="form-label required">Masa Berlaku</label>
                                        <input type="text" name="masa_berlaku_notifikasi" class="form-control" required placeholder="01-01-2025 s/d ...">
                                    </div>
                                    <div class="field">
                                        <label class="form-label required">Lokasi Kerja</label>
                                        <input type="text" name="lokasi_kerja" class="form-control" required placeholder="Kawasan Industri...">
                                    </div>
                                </div>
                                <!-- Kolom 3 -->
                                <div style="display:flex;flex-direction:column;gap:14px;">
                                    <div class="field">
                                        <label class="form-label required">Lunas DKP</label>
                                        <select name="lunas_dkp" class="form-select" required>
                                            <option value="">—</option>
                                            <option value="Lunas">Lunas</option>
                                            <option value="Belum Lunas">Belum Lunas</option>
                                        </select>
                                    </div>
                                    <div class="field">
                                        <label class="form-label required">Bidang Usaha</label>
                                        <input type="text" name="bidang_usaha" class="form-control" required placeholder="Manufaktur">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div><!-- /form-grid -->

                    <!-- Action bar -->
                    <div class="action-bar">
                        <button type="submit" class="btn-save" id="btnSimpan">
                            <i class="fas fa-paper-plane"></i> Simpan &amp; Ajukan
                        </button>
                        <a href="<?= base_url('user/data_tka') ?>" class="btn-lewati">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>

                </div><!-- /surf-body -->
            </div><!-- /surface -->
        </form>

        <?php endif; ?>
    </main>
</div>

<?php $this->load->view('footer'); ?>

<script>
(function(){
    var sidebar = document.getElementById('mainSidebar');
    var btn     = document.getElementById('sidebarToggle');
    var chevron = document.getElementById('toggleChevron');
    if(sidebar && btn){
        if(localStorage.getItem('sidebarCollapsed') === '1'){
            sidebar.classList.add('collapsed');
            if(chevron) chevron.style.transform = 'rotate(180deg)';
        }
        btn.addEventListener('click', function(){
            sidebar.classList.toggle('collapsed');
            var c = sidebar.classList.contains('collapsed');
            localStorage.setItem('sidebarCollapsed', c ? '1' : '0');
            if(chevron) chevron.style.transform = c ? 'rotate(180deg)' : 'rotate(0deg)';
        });
    }

    var form      = document.getElementById('detailForm');
    var btnSimpan = document.getElementById('btnSimpan');

    form.addEventListener('submit', function(e){
        e.preventDefault();
        var fields = form.querySelectorAll('[required]');
        var kosong = [];
        fields.forEach(function(field){
            field.style.borderColor = '';
            if(!field.value.trim()){ kosong.push(field); field.style.borderColor = '#ef4444'; }
        });
        if(kosong.length > 0){
            kosong[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
            kosong[0].focus();
            return;
        }
        if(!confirm('Simpan data dan ajukan?')) return;
        form.submit();
    });

    form.querySelectorAll('[required]').forEach(function(field){
        field.addEventListener('input',  function(){ if(field.value.trim()) field.style.borderColor = ''; });
        field.addEventListener('change', function(){ if(field.value.trim()) field.style.borderColor = ''; });
    });
})();
</script>
</body>
</html>