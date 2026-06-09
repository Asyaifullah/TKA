<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit TKA — <?= htmlspecialchars($tka->nama_tka) ?></title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/shared.css') ?>">

    <style>
        /* ============================================================
           EDIT TKA — semua warna pakai var(--c-*) dari shared.css
           Desktop : 2-kolom grid
           Mobile  : 1-kolom stack
        ============================================================ */

        /* ── Page content ─────────────────────────────────────── */
        .page-content { padding: 20px 28px 32px; }

        /* ── TKA Header ───────────────────────────────────────── */
        .tka-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 20px;
        }

        .tka-avatar {
            width: 46px;
            height: 46px;
            border-radius: 12px;
            background: var(--c-primary-light);
            color: var(--c-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .tka-name {
            font-size: 1rem;
            font-weight: 700;
            color: var(--c-text);
            line-height: 1.3;
        }

        .tka-sub {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.76rem;
            color: var(--c-text-muted);
            margin-top: 3px;
            flex-wrap: wrap;
        }

        /* ── Status badge ─────────────────────────────────────── */
        .s-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 2px 9px;
            border-radius: 20px;
            font-size: 0.66rem;
            font-weight: 700;
            letter-spacing: 0.4px;
            text-transform: uppercase;
        }

        .s-draft   { background: #fef3c7; color: #92400e; }
        .s-waiting { background: #dbeafe; color: #1e3a8a; }
        .s-other   { background: var(--c-surface-2); color: var(--c-text-muted); }

        /* ── Flash / alert ────────────────────────────────────── */
        .flash {
            display: flex;
            align-items: flex-start;
            gap: 9px;
            border-radius: var(--r-md);
            font-size: 0.82rem;
            padding: 11px 14px;
            margin-bottom: 12px;
            line-height: 1.5;
        }

        .flash i { margin-top: 1px; flex-shrink: 0; }

        .flash-err  { background: #fff5f5; border: 1px solid #feb2b2; color: #822727; }
        .flash-ok   { background: #f0fff4; border: 1px solid #9ae6b4; color: #1a5c35; }
        .flash-info { background: #ebf8ff; border: 1px solid #90cdf4; color: #1a3c6b; }
        .flash-warn { background: #fffbeb; border: 1px solid #f6e05e; color: #7a5000; }

        .flash-reject {
            flex-direction: column;
            gap: 5px;
        }

        .flash-reject-title {
            display: flex;
            align-items: center;
            gap: 7px;
            font-weight: 700;
        }

        /* ── Surface card ─────────────────────────────────────── */
        .surface {
            background: var(--c-surface);
            border: 1px solid var(--c-border);
            border-radius: var(--r-md);
            overflow: hidden;
            margin-bottom: 16px;
        }

        .surface-header {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 12px 20px;
            border-bottom: 1px solid var(--c-border);
            background: var(--c-surface-2);
        }

        .surface-icon {
            width: 28px;
            height: 28px;
            border-radius: 7px;
            background: var(--c-primary-light);
            color: var(--c-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            flex-shrink: 0;
        }

        .surface-title {
            font-size: 0.86rem;
            font-weight: 700;
            color: var(--c-text);
            margin: 0;
        }

        .surface-body { padding: 20px 22px; }

        /* ── Section label ────────────────────────────────────── */
        .sec-label {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.7px;
            text-transform: uppercase;
            color: var(--c-primary);
            padding-bottom: 8px;
            margin-bottom: 14px;
            border-bottom: 1px solid var(--c-border);
        }

        .sec-label-icon {
            width: 20px;
            height: 20px;
            border-radius: 5px;
            background: var(--c-primary-light);
            color: var(--c-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.6rem;
        }

        /* ── Field group ──────────────────────────────────────── */
        .fgroup { margin-bottom: 14px; }
        .fgroup:last-child { margin-bottom: 0; }

        .fl {
            display: block;
            font-size: 0.71rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--c-text-muted);
            margin-bottom: 5px;
        }

        .fl .req { color: #e53e3e; }

        /* ── Input / select / textarea ────────────────────────── */
        .f-input,
        .f-select,
        .f-textarea {
            width: 100%;
            border: 1px solid var(--c-border);
            border-radius: var(--r-md);
            padding: 9px 12px;
            font-family: var(--font-body);
            font-size: 0.875rem;
            color: var(--c-text);
            background: var(--c-surface);
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
            -webkit-appearance: none;
        }

        .f-input:focus,
        .f-select:focus,
        .f-textarea:focus {
            border-color: var(--c-primary);
            box-shadow: 0 0 0 3px var(--c-primary-glow);
        }

        .f-input:disabled,
        .f-select:disabled,
        .f-textarea:disabled {
            background: var(--c-surface-2);
            color: var(--c-text-muted);
            cursor: not-allowed;
        }

        .f-input::placeholder,
        .f-textarea::placeholder { color: var(--c-border); }

        .f-textarea {
            min-height: 72px;
            resize: vertical;
            line-height: 1.6;
        }

        .f-select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 30px;
            cursor: pointer;
        }

        /* Disabled form (status tidak bisa diedit) */
        .disabled-form { opacity: 0.62; pointer-events: none; }

        /* ── Grid field ───────────────────────────────────────── */
        .field-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }

        .field-grid.cols-3 { grid-template-columns: repeat(3, 1fr); }
        .field-grid.cols-4 { grid-template-columns: repeat(4, 1fr); }

        /* Span full lebar */
        .col-full  { grid-column: 1 / -1; }
        .col-2-3   { grid-column: span 2; }

        /* ── File upload ──────────────────────────────────────── */
        .file-item {
            background: var(--c-surface-2);
            border: 1.5px dashed var(--c-border);
            border-radius: var(--r-md);
            padding: 10px 12px;
            transition: border-color 0.15s, background 0.15s;
        }

        .file-item.is-error {
            border-color: #fc8181;
            background: #fff5f5;
        }

        .file-item.is-ok {
            border-color: var(--c-primary);
            background: var(--c-primary-light);
        }

        .file-item-label {
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--c-text-muted);
            margin-bottom: 5px;
        }

        .file-item-label span {
            font-weight: 400;
            text-transform: none;
            letter-spacing: 0;
        }

        .file-item input[type="file"] {
            width: 100%;
            font-size: 0.78rem;
            color: var(--c-text);
            background: none;
            border: none;
            padding: 2px 0;
            cursor: pointer;
        }

        .file-current {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.7rem;
            color: var(--c-text-muted);
            margin-top: 5px;
            word-break: break-all;
        }

        .file-current i { color: var(--c-primary); flex-shrink: 0; }

        .file-err-msg {
            display: none;
            align-items: center;
            gap: 5px;
            font-size: 0.7rem;
            color: #e53e3e;
            margin-top: 4px;
        }

        .img-preview {
            display: none;
            align-items: center;
            gap: 10px;
            background: var(--c-surface);
            padding: 7px;
            border-radius: 8px;
            border: 1px solid var(--c-border);
            margin-top: 8px;
        }

        .img-preview img {
            width: 44px;
            height: 44px;
            object-fit: cover;
            border-radius: 6px;
        }

        .img-preview span {
            font-size: 0.68rem;
            color: var(--c-text-muted);
        }

        /* ── Keterangan file size di atas upload ──────────────── */
        .upload-note {
            font-size: 0.78rem;
            color: var(--c-text-muted);
            margin-bottom: 16px;
            line-height: 1.5;
        }

        /* ── Tombol ───────────────────────────────────────────── */
        .btn-save {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: var(--c-primary);
            color: #fff;
            border: none;
            border-radius: var(--r-md);
            padding: 0 20px;
            height: 40px;
            font-family: var(--font-body);
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.15s, transform 0.1s;
        }

        .btn-save:hover:not(:disabled)  { opacity: 0.88; }
        .btn-save:active:not(:disabled) { transform: scale(0.98); }
        .btn-save:disabled { opacity: 0.5; cursor: not-allowed; }

        .btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            color: var(--c-text-muted);
            background: none;
            border: 1px solid var(--c-border);
            border-radius: var(--r-md);
            padding: 0 18px;
            height: 40px;
            font-family: var(--font-body);
            font-size: 0.84rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: border-color 0.15s, color 0.15s;
        }

        .btn-ghost:hover {
            border-color: var(--c-primary);
            color: var(--c-primary);
        }

        /* ── Form footer ──────────────────────────────────────── */
        .form-foot {
            display: flex;
            align-items: center;
            gap: 10px;
            padding-top: 16px;
            border-top: 1px solid var(--c-border);
            margin-top: 4px;
            flex-wrap: wrap;
        }

        /* ── Back row ─────────────────────────────────────────── */
        .back-row { margin-top: 4px; }

        /* ============================================================
           RESPONSIVE
        ============================================================ */
        @media (max-width: 768px) {
            .page-content { padding: 14px 12px 28px; }

            /* Semua grid jadi 1 kolom */
            .field-grid,
            .field-grid.cols-3,
            .field-grid.cols-4 {
                grid-template-columns: 1fr;
            }

            /* Reset span */
            .col-full,
            .col-2-3 { grid-column: 1; }

            .surface-body { padding: 16px 14px; }
            .surface-header { padding: 10px 14px; }

            .tka-avatar { width: 40px; height: 40px; font-size: 1rem; }
            .tka-name   { font-size: 0.92rem; }

            /* Input font-size 16px cegah iOS zoom */
            .f-input,
            .f-select,
            .f-textarea { font-size: 16px; }

            /* Tombol full width di mobile */
            .btn-save,
            .btn-ghost {
                flex: 1;
                justify-content: center;
            }

            .form-foot { gap: 8px; }
        }

        @media (max-width: 400px) {
            .tka-sub { flex-direction: column; align-items: flex-start; gap: 4px; }
        }
    </style>
</head>
<body>

<?php $this->load->view('user/sidebar'); ?>

<div class="page-wrapper">

    <header class="topnav">
        <div class="topnav-breadcrumb">
            <a href="<?= base_url('dashboard') ?>" style="color:var(--c-text-muted);text-decoration:none;">
                <i class="fas fa-home"></i>
            </a>
            <i class="fas fa-chevron-right" style="font-size:8px;"></i>
            <a href="<?= base_url('user/data_tka') ?>" style="color:var(--c-text-muted);text-decoration:none;">
                Data TKA
            </a>
            <i class="fas fa-chevron-right" style="font-size:8px;"></i>
            <strong>Edit TKA</strong>
        </div>
    </header>

    <main class="page-content">

        <?php
        $status  = $tka->status;
        $bc      = $status === 'DRAFT' ? 'draft' : ($status === 'MENUNGGU_KASI' ? 'waiting' : 'other');
        $can_edit = in_array($status, ['DRAFT', 'MENUNGGU_KASI']);
        ?>

        <!-- TKA header -->
        <div class="tka-header">
            <div class="tka-avatar"><i class="fas fa-user-tie"></i></div>
            <div>
                <div class="tka-name"><?= htmlspecialchars($tka->nama_tka) ?></div>
                <div class="tka-sub">
                    <span class="s-badge s-<?= $bc ?>">
                        <i class="fas fa-circle" style="font-size:5px;"></i>
                        <?= $status ?>
                    </span>
                    Edit Data TKA
                </div>
            </div>
        </div>

        <!-- Flash messages -->
        <?php if($this->session->flashdata('error')): ?>
        <div class="flash flash-err">
            <i class="fas fa-exclamation-circle"></i>
            <?= $this->session->flashdata('error') ?>
        </div>
        <?php endif; ?>

        <?php if($this->session->flashdata('success')): ?>
        <div class="flash flash-ok">
            <i class="fas fa-check-circle"></i>
            <?= $this->session->flashdata('success') ?>
        </div>
        <?php endif; ?>

        <?php if($this->session->flashdata('info')): ?>
        <div class="flash flash-info">
            <i class="fas fa-info-circle"></i>
            <?= $this->session->flashdata('info') ?>
        </div>
        <?php endif; ?>

        <!-- Catatan penolakan -->
        <?php if($tka->status == 'DRAFT'):
            $this->load->model('Approval_log_model');
            $last_reject = $this->Approval_log_model->get_last_reject($tka->id);
            if($last_reject && !empty($last_reject->catatan)): ?>
        <div class="flash flash-err flash-reject">
            <div class="flash-reject-title">
                <i class="fas fa-exclamation-triangle"></i> Catatan Penolakan
            </div>
            <div><?= nl2br(htmlspecialchars($last_reject->catatan)) ?></div>
        </div>
        <?php endif; endif; ?>

        <!-- Tidak bisa diedit -->
        <?php if(!$can_edit): ?>
        <div class="flash flash-warn">
            <i class="fas fa-lock"></i>
            <div>
                Pengajuan sudah diproses lebih lanjut (status: <strong><?= $status ?></strong>).
                Data tidak dapat diedit. Hubungi admin jika diperlukan perubahan.
            </div>
        </div>
        <?php endif; ?>

        <!-- ══════════════════════════════════════════════════════
             CARD 1: Data Diri TKA
        ══════════════════════════════════════════════════════ -->
        <div class="surface">
            <div class="surface-header">
                <div class="surface-icon"><i class="fas fa-id-card"></i></div>
                <div class="surface-title">Data Diri TKA</div>
            </div>
            <div class="surface-body">
                <form action="<?= base_url('user/update_tka/'.$tka->id) ?>" method="post"
                      <?= !$can_edit ? 'class="disabled-form"' : '' ?>>
                    <input type="hidden"
                           name="<?= $this->security->get_csrf_token_name() ?>"
                           value="<?= $this->security->get_csrf_hash() ?>">

                    <!-- ── Identitas ──────────────────────────── -->
                    <div class="sec-label">
                        <div class="sec-label-icon"><i class="fas fa-user"></i></div>
                        Identitas
                    </div>

                    <div class="field-grid">
                        <div class="fgroup">
                            <label class="fl">Nama TKA <span class="req">*</span></label>
                            <input type="text" name="nama_tka" class="f-input"
                                   value="<?= htmlspecialchars($tka->nama_tka) ?>"
                                   required <?= !$can_edit ? 'disabled' : '' ?>>
                        </div>
                        <div class="fgroup">
                            <label class="fl">Kebangsaan</label>
                            <input type="text" name="negara_asal" class="f-input"
                                   value="<?= htmlspecialchars($tka->negara_asal) ?>"
                                   <?= !$can_edit ? 'disabled' : '' ?>>
                        </div>
                    </div>

                    <div class="field-grid cols-3">
                        <div class="fgroup">
                            <label class="fl">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="f-input"
                                   value="<?= htmlspecialchars($tka->tempat_lahir) ?>"
                                   <?= !$can_edit ? 'disabled' : '' ?>>
                        </div>
                        <div class="fgroup">
                            <label class="fl">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="f-input"
                                   value="<?= $tka->tanggal_lahir ?>"
                                   <?= !$can_edit ? 'disabled' : '' ?>>
                        </div>
                        <div class="fgroup">
                            <label class="fl">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="f-select"
                                    <?= !$can_edit ? 'disabled' : '' ?>>
                                <option value="">— Pilih —</option>
                                <option value="Laki-laki"  <?= $tka->jenis_kelamin=='Laki-laki'  ?'selected':'' ?>>Laki-laki</option>
                                <option value="Perempuan"  <?= $tka->jenis_kelamin=='Perempuan'  ?'selected':'' ?>>Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="field-grid">
                        <div class="fgroup">
                            <label class="fl">Jabatan</label>
                            <input type="text" name="jabatan" class="f-input"
                                   value="<?= htmlspecialchars($tka->jabatan) ?>"
                                   <?= !$can_edit ? 'disabled' : '' ?>>
                        </div>
                        <div class="fgroup">
                            <label class="fl">Bidang Usaha</label>
                            <input type="text" name="bidang_usaha" class="f-input"
                                   value="<?= htmlspecialchars($tka->bidang_usaha) ?>"
                                   <?= !$can_edit ? 'disabled' : '' ?>>
                        </div>
                        <div class="fgroup col-2-3">
                            <label class="fl">Alamat Tinggal</label>
                            <textarea name="alamat_tinggal" class="f-textarea"
                                      <?= !$can_edit ? 'disabled' : '' ?>><?= htmlspecialchars($tka->alamat_tinggal) ?></textarea>
                        </div>
                        <div class="fgroup">
                            <label class="fl">Lokasi Kerja</label>
                            <input type="text" name="lokasi_kerja" class="f-input"
                                   value="<?= htmlspecialchars($tka->lokasi_kerja) ?>"
                                   <?= !$can_edit ? 'disabled' : '' ?>>
                        </div>
                    </div>

                    <!-- ── Dokumen Perjalanan ─────────────────── -->
                    <div class="sec-label">
                        <div class="sec-label-icon"><i class="fas fa-passport"></i></div>
                        Dokumen Perjalanan
                    </div>

                    <div class="field-grid">
                        <div class="fgroup">
                            <label class="fl">Nomor Passport</label>
                            <input type="text" name="passport_no" class="f-input"
                                   value="<?= htmlspecialchars($tka->passport_no) ?>"
                                   <?= !$can_edit ? 'disabled' : '' ?>>
                        </div>
                        <div class="fgroup">
                            <label class="fl">Masa Berlaku Passport</label>
                            <input type="date" name="passport_expiry" class="f-input"
                                   value="<?= $tka->passport_expiry ?>"
                                   <?= !$can_edit ? 'disabled' : '' ?>>
                        </div>
                        <div class="fgroup">
                            <label class="fl">Nomor KITAS</label>
                            <input type="text" name="kitas_no" class="f-input"
                                   value="<?= htmlspecialchars($tka->kitas_no) ?>"
                                   <?= !$can_edit ? 'disabled' : '' ?>>
                        </div>
                        <div class="fgroup">
                            <label class="fl">Nomor STM</label>
                            <input type="text" name="stm_no" class="f-input"
                                   value="<?= htmlspecialchars($tka->stm_no) ?>"
                                   <?= !$can_edit ? 'disabled' : '' ?>>
                        </div>
                    </div>

                    <!-- ── Notifikasi & RPTKA ─────────────────── -->
                    <div class="sec-label">
                        <div class="sec-label-icon"><i class="fas fa-file-alt"></i></div>
                        Notifikasi &amp; RPTKA
                    </div>

                    <div class="field-grid">
                        <div class="fgroup">
                            <label class="fl">Nomor RPTKA</label>
                            <input type="text" name="rptka_no" class="f-input"
                                   value="<?= htmlspecialchars($tka->rptka_no) ?>"
                                   <?= !$can_edit ? 'disabled' : '' ?>>
                        </div>
                        <div class="fgroup">
                            <label class="fl">Tanggal RPTKA</label>
                            <input type="date" name="rptka_date" class="f-input"
                                   value="<?= $tka->rptka_date ?>"
                                   <?= !$can_edit ? 'disabled' : '' ?>>
                        </div>
                        <div class="fgroup">
                            <label class="fl">Nomor Notifikasi</label>
                            <input type="text" name="notifikasi_no" class="f-input"
                                   value="<?= htmlspecialchars($tka->notifikasi_no) ?>"
                                   <?= !$can_edit ? 'disabled' : '' ?>>
                        </div>
                        <div class="fgroup">
                            <label class="fl">Tanggal Notifikasi</label>
                            <input type="date" name="notifikasi_date" class="f-input"
                                   value="<?= $tka->notifikasi_date ?>"
                                   <?= !$can_edit ? 'disabled' : '' ?>>
                        </div>
                    </div>

                    <div class="field-grid cols-3">
                        <div class="fgroup">
                            <label class="fl">Jenis Notifikasi</label>
                            <select name="jenis_notifikasi" class="f-select"
                                    <?= !$can_edit ? 'disabled' : '' ?>>
                                <option value="">— Pilih —</option>
                                <option value="Baru"          <?= $tka->jenis_notifikasi=='Baru'          ?'selected':'' ?>>Baru</option>
                                <option value="Jangka Pendek" <?= $tka->jenis_notifikasi=='Jangka Pendek' ?'selected':'' ?>>Jangka Pendek</option>
                                <option value="Perpanjangan"  <?= $tka->jenis_notifikasi=='Perpanjangan'  ?'selected':'' ?>>Perpanjangan</option>
                            </select>
                        </div>
                        <div class="fgroup">
                            <label class="fl">Masa Berlaku Notifikasi</label>
                            <input type="text" name="masa_berlaku_notifikasi" class="f-input"
                                   value="<?= htmlspecialchars($tka->masa_berlaku_notifikasi) ?>"
                                   <?= !$can_edit ? 'disabled' : '' ?>>
                        </div>
                        <div class="fgroup">
                            <label class="fl">Lunas DKP-TKA</label>
                            <select name="lunas_dkp" class="f-select"
                                    <?= !$can_edit ? 'disabled' : '' ?>>
                                <option value="">— Pilih —</option>
                                <option value="Lunas"       <?= $tka->lunas_dkp=='Lunas'       ?'selected':'' ?>>Lunas</option>
                                <option value="Belum Lunas" <?= $tka->lunas_dkp=='Belum Lunas' ?'selected':'' ?>>Belum Lunas</option>
                            </select>
                        </div>
                    </div>

                    <?php if($can_edit): ?>
                    <div class="form-foot">
                        <button type="submit" class="btn-save">
                            <i class="fas fa-floppy-disk"></i> Simpan Perubahan
                        </button>
                        <a href="<?= base_url('user/data_tka') ?>" class="btn-ghost">
                            <i class="fas fa-xmark"></i> Batal
                        </a>
                    </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- ══════════════════════════════════════════════════════
             CARD 2: Ganti Berkas (hanya muncul jika bisa diedit)
        ══════════════════════════════════════════════════════ -->
        <?php if($can_edit): ?>
        <div class="surface">
            <div class="surface-header">
                <div class="surface-icon"><i class="fas fa-file-upload"></i></div>
                <div class="surface-title">Ganti Berkas</div>
            </div>
            <div class="surface-body">

                <p class="upload-note">
                    Upload ulang untuk mengganti berkas lama. Kosongkan field jika tidak ingin mengubah.
                    Maks. <strong>2 MB</strong> per file.
                </p>

                <form action="<?= base_url('user/update_berkas/'.$tka->id) ?>"
                      method="post" enctype="multipart/form-data" id="fBerkas">
                    <input type="hidden"
                           name="<?= $this->security->get_csrf_token_name() ?>"
                           value="<?= $this->security->get_csrf_hash() ?>">

                    <!-- PDF -->
                    <div class="sec-label">
                        <div class="sec-label-icon"><i class="fas fa-file-pdf"></i></div>
                        Dokumen PDF
                    </div>

                    <div class="field-grid" style="margin-bottom:20px;">
                        <?php
                        $pdfs = [
                            'surat_permohonan' => 'Surat Permohonan',
                            'passport'         => 'Passport',
                            'kitas'            => 'KITAS',
                            'stm'              => 'STM',
                            'rptka'            => 'RPTKA',
                            'notifikasi'       => 'Notifikasi',
                            'bukti_bayar'      => 'Bukti Bayar',
                            'surat_kuasa'      => 'Surat Kuasa',
                        ];
                        foreach($pdfs as $k => $v): ?>
                        <div>
                            <div class="file-item" id="fi_<?= $k ?>">
                                <div class="file-item-label">
                                    <?= $v ?> <span>(PDF, maks 2MB)</span>
                                </div>
                                <input type="file" name="<?= $k ?>" accept=".pdf"
                                       onchange="vFile(this,'<?= $k ?>','pdf')">
                                <?php if(!empty($berkas->$k)): ?>
                                <div class="file-current" id="fc_<?= $k ?>">
                                    <i class="fas fa-paperclip"></i>
                                    <?= htmlspecialchars($berkas->$k) ?>
                                </div>
                                <?php endif; ?>
                                <div class="file-err-msg" id="fe_<?= $k ?>">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Gambar -->
                    <div class="sec-label">
                        <div class="sec-label-icon"><i class="fas fa-image"></i></div>
                        Dokumen Gambar
                    </div>

                    <div class="field-grid" style="margin-bottom:20px;">
                        <?php
                        $imgs = [
                            'ktp'  => 'KTP Penanggung Jawab',
                            'foto' => 'Foto TKA',
                        ];
                        foreach($imgs as $k => $v): ?>
                        <div>
                            <div class="file-item" id="fi_<?= $k ?>">
                                <div class="file-item-label">
                                    <?= $v ?> <span>(JPG/PNG, maks 2MB)</span>
                                </div>
                                <input type="file" name="<?= $k ?>"
                                       accept="image/jpeg,image/jpg,image/png"
                                       onchange="vFile(this,'<?= $k ?>','img');prevImg(this,'<?= $k ?>')">
                                <?php if(!empty($berkas->$k)): ?>
                                <div class="file-current" id="fc_<?= $k ?>">
                                    <i class="fas fa-paperclip"></i>
                                    <?= htmlspecialchars($berkas->$k) ?>
                                </div>
                                <?php endif; ?>
                                <div class="file-err-msg" id="fe_<?= $k ?>">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span></span>
                                </div>
                                <div class="img-preview" id="pv_<?= $k ?>">
                                    <img id="pvi_<?= $k ?>" src="" alt="preview">
                                    <span>Preview gambar baru</span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="form-foot">
                        <button type="submit" class="btn-save" id="btnUpload">
                            <i class="fas fa-upload"></i> Ganti Berkas
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <?php endif; ?>

        <!-- Back -->
        <div class="back-row">
            <a href="<?= base_url('user/data_tka') ?>" class="btn-ghost">
                <i class="fas fa-arrow-left"></i>
                <?= $can_edit ? 'Batal &amp; Kembali' : 'Kembali ke Data TKA' ?>
            </a>
        </div>

    </main>
</div>

<?php $this->load->view('footer'); ?>

<script>
/* ============================================================
   Validasi file upload
============================================================ */
function setErr(k, msg) {
    var fi = document.getElementById('fi_' + k);
    var fe = document.getElementById('fe_' + k);
    if (fi) fi.classList.add('is-error');
    if (fe) { fe.style.display = 'flex'; fe.querySelector('span').textContent = msg; }
}

function clrErr(k) {
    var fi = document.getElementById('fi_' + k);
    var fe = document.getElementById('fe_' + k);
    if (fi) { fi.classList.remove('is-error'); fi.classList.remove('is-ok'); }
    if (fe) fe.style.display = 'none';
}

function vFile(inp, k, type) {
    clrErr(k);
    var f = inp.files[0];
    if (!f) { return; }

    var ok = true, msg = '';
    if (type === 'pdf') {
        if (!f.name.toLowerCase().endsWith('.pdf')) { ok = false; msg = 'Harap unggah file PDF.'; }
    } else {
        if (!/\.(jpg|jpeg|png)$/i.test(f.name)) { ok = false; msg = 'Harap unggah JPG/PNG.'; }
    }
    if (ok && f.size > 2 * 1024 * 1024) { ok = false; msg = 'Ukuran melebihi 2 MB.'; }

    if (!ok) {
        inp.value = '';
        setErr(k, msg);
        hidePrev(k);
        return;
    }

    var fi = document.getElementById('fi_' + k);
    if (fi) fi.classList.add('is-ok');
    var fc = document.getElementById('fc_' + k);
    if (fc) {
        fc.innerHTML = '<i class="fas fa-check" style="color:var(--c-primary)"></i> (diganti) ' + f.name;
        fc.style.color = 'var(--c-primary)';
    }
}

function prevImg(inp, k) {
    if (!inp.files || !inp.files[0]) return;
    var r = new FileReader();
    r.onload = function(e) {
        var c = document.getElementById('pv_' + k);
        var i = document.getElementById('pvi_' + k);
        if (c && i) { i.src = e.target.result; c.style.display = 'flex'; }
    };
    r.readAsDataURL(inp.files[0]);
}

function hidePrev(k) {
    var c = document.getElementById('pv_' + k);
    if (c) c.style.display = 'none';
}

/* Validasi submit form berkas */
var fBerkas = document.getElementById('fBerkas');
if (fBerkas) {
    fBerkas.addEventListener('submit', function(e) {
        var err = false;
        this.querySelectorAll('input[type=file]').forEach(function(inp) {
            if (!inp.files.length) return;
            var f   = inp.files[0];
            var k   = inp.name;
            var pdf = inp.accept.includes('pdf');
            var ok  = true, msg = '';

            if (pdf) {
                if (!f.name.toLowerCase().endsWith('.pdf')) { ok = false; msg = 'Harap unggah file PDF.'; }
            } else {
                if (!/\.(jpg|jpeg|png)$/i.test(f.name)) { ok = false; msg = 'Harap unggah JPG/PNG.'; }
            }
            if (ok && f.size > 2 * 1024 * 1024) { ok = false; msg = 'Ukuran melebihi 2 MB.'; }

            if (!ok) { setErr(k, msg); err = true; } else { clrErr(k); }
        });

        if (err) {
            e.preventDefault();
            var first = document.querySelector('.is-error');
            if (first) first.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return;
        }

        var b = document.getElementById('btnUpload');
        if (b) {
            b.disabled = true;
            b.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengupload…';
        }
    });
}
</script>
</body>
</html>