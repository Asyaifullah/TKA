<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Manajemen Petugas — SITLAKEB TKA Admin</title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/shared.css') ?>">
    <style>

        /* ── Flash alert ── */
        .alert-flash {
            display: flex; align-items: center; gap: 8px;
            border-radius: var(--r-md); padding: 11px 14px;
            font-size: 0.82rem; margin-bottom: 16px;
        }
        .af-ok  { background:#ecfdf5; border-left:3px solid #10b981; color:#065f46; }
        .af-err { background:#fff1f2; border-left:3px solid #f43f5e; color:#9f1239; }

        /* ── Burger (mobile only, dalam topnav) ── */
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

        /* ── Page head ── */
        .page-head {
            display: flex; justify-content: space-between;
            align-items: flex-start; flex-wrap: wrap;
            gap: 12px; margin-bottom: 20px;
        }
        .page-head-title {
            font-size: 1.05rem; font-weight: 800;
            color: var(--c-text); display: flex; align-items: center; gap: 8px;
        }
        .page-head-sub { font-size: 0.77rem; color: var(--c-text-muted); margin-top: 3px; }

        /* ── Toolbar ── */
        .tbl-toolbar {
            padding: 12px 18px;
            border-bottom: 1px solid var(--c-border);
            display: flex; justify-content: space-between;
            align-items: center; flex-wrap: wrap; gap: 10px;
        }
        .search-wrap { position: relative; flex: 1; max-width: 300px; }
        .s-icon { position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: var(--c-text-muted); font-size: 11px; pointer-events: none; }
        .s-clear { position: absolute; right: 8px; top: 50%; transform: translateY(-50%); background: var(--c-border); border: none; border-radius: 50%; width: 17px; height: 17px; display: none; align-items: center; justify-content: center; cursor: pointer; font-size: 9px; }
        .search-wrap.has-value .s-clear { display: flex; }
        .search-wrap.has-value .s-icon { color: var(--c-primary); }
        .search-input { width: 100%; padding: 7px 28px; border: 1px solid var(--c-border); border-radius: var(--r-sm); font-family: var(--font-body); font-size: 0.82rem; background: var(--c-surface-2); outline: none; }
        .search-input:focus { background: #fff; border-color: var(--c-primary); box-shadow: 0 0 0 3px var(--c-primary-glow); }
        .tbl-counter { font-size: 0.73rem; color: var(--c-text-muted); white-space: nowrap; }

        /* ── Desktop table ── */
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table thead th { background: var(--c-surface-2); color: var(--c-text-muted); font-size: 0.66rem; font-weight: 700; text-transform: uppercase; padding: 10px 14px; border-bottom: 1px solid var(--c-border); white-space: nowrap; }
        .data-table tbody td { padding: 11px 14px; border-bottom: 1px solid var(--c-border); font-size: 0.82rem; vertical-align: middle; }
        .data-table tbody tr:hover td { background: var(--c-surface-2); }

        .officer-cell { display: flex; align-items: center; gap: 10px; }
        .off-avatar { width: 34px; height: 34px; border-radius: var(--r-md); background: var(--c-primary-light); color: var(--c-primary); font-weight: 800; display: flex; align-items: center; justify-content: center; text-transform: uppercase; flex-shrink: 0; font-size: 0.78rem; }
        .off-name { font-weight: 600; font-size: 0.83rem; }
        .off-nip  { font-size: 0.67rem; color: var(--c-text-muted); font-family: monospace; }
        .self-tag { font-size: 0.61rem; background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; border-radius: 4px; padding: 1px 5px; margin-left: 4px; }

        .role-pill { display: inline-flex; padding: 3px 8px; border-radius: 6px; font-size: 0.67rem; font-weight: 700; text-transform: uppercase; }
        .rp-admin   { background:#f5f3ff; color:#5b21b6; border:1px solid #ddd6fe; }
        .rp-kasi    { background:#fff7ed; color:#c2410c; border:1px solid #fed7aa; }
        .rp-kabid   { background:#eff6ff; color:#1e40af; border:1px solid #bfdbfe; }
        .rp-sekdis  { background:#fdf4ff; color:#86198f; border:1px solid #f0abfc; }
        .rp-kadis   { background:#ecfdf5; color:#065f46; border:1px solid #a7f3d0; }
        .rp-operator{ background:#f1f5f9; color:#475569; border:1px solid #cbd5e1; }

        .sts-badge { display: inline-flex; align-items: center; gap: 5px; padding: 3px 9px; border-radius: 6px; font-size: 0.67rem; font-weight: 700; }
        .sts-badge::before { content:''; width:6px; height:6px; border-radius:50%; }
        .sts-aktif          { background:#ecfdf5; color:#065f46; }
        .sts-aktif::before  { background:#10b981; }
        .sts-nonaktif       { background:#fff1f2; color:#9f1239; }
        .sts-nonaktif::before{ background:#f43f5e; }

        .contact-email, .contact-phone { display: flex; align-items: center; gap: 4px; }
        .contact-email i, .contact-phone i { font-size: 9px; color: var(--c-text-muted); }
        .contact-phone { margin-top: 2px; }

        .act-btn { display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 6px; border: 1px solid; font-size: 10px; cursor: pointer; text-decoration: none; transition: 0.15s; }
        .act-btn:hover { transform: translateY(-1px); }
        .ab-edit   { background:#fffbeb; color:#92400e; border-color:#fde68a; }
        .ab-reset  { background:#eff6ff; color:#1e40af; border-color:#bfdbfe; }
        .ab-off    { background:#f1f5f9; color:#475569; border-color:#e2e8f0; }
        .ab-on     { background:#ecfdf5; color:#065f46; border-color:#a7f3d0; }
        .ab-delete { background:#fff1f2; color:#9f1239; border-color:#fecdd3; }
        .ab-disabled { opacity:0.32; cursor:not-allowed; background:#f1f5f9; color:#94a3b8; border-color:#e2e8f0; pointer-events:none; }
        .act-row { display: flex; gap: 4px; }

        /* ── Pagination ── */
        .paging-wrap { padding: 12px 18px; border-top: 1px solid var(--c-border); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; background: var(--c-surface-2); }
        .paging-info { font-size: 0.71rem; }
        .paging-controls { display: flex; gap: 3px; flex-wrap: wrap; }
        .page-btn { min-width: 28px; height: 28px; padding: 0 6px; border: 1px solid var(--c-border); border-radius: var(--r-sm); background: var(--c-surface); font-size: 0.73rem; cursor: pointer; }
        .page-btn.active { background: var(--c-primary); border-color: var(--c-primary); color: #fff; }
        .per-page-sel { padding: 3px 22px 3px 8px; border: 1px solid var(--c-border); border-radius: var(--r-sm); font-size: 0.71rem; appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 7px center; }
        mark.hl { background:#fef9c3; color:#92400e; border-radius:2px; }

        .no-result { display: none; padding: 40px 20px; text-align: center; color: var(--c-text-muted); }

        /* ── Mobile card stack ── */
        .officer-cards { display: none; }
        .officer-card { padding: 14px 16px; border-bottom: 1px solid var(--c-border); }
        .officer-card.card-hidden { display: none; }
        .oc-top { display: flex; justify-content: space-between; align-items: flex-start; gap: 10px; margin-bottom: 10px; }
        .oc-info { flex: 1; }
        .oc-name { font-weight: 700; font-size: 0.88rem; margin-bottom: 2px; }
        .oc-nip  { font-size: 0.68rem; color: var(--c-text-muted); }
        .oc-badges { margin-bottom: 8px; display: flex; flex-wrap: wrap; gap: 5px; }
        .oc-contact { display: flex; flex-direction: column; gap: 3px; font-size: 0.76rem; margin-bottom: 10px; }
        .oc-contact span { display: flex; align-items: center; gap: 5px; }
        .oc-actions { display: flex; gap: 6px; flex-wrap: wrap; }
        .oc-actions .act-btn { width: 34px; height: 34px; font-size: 11px; }

        /* ══════════════════════════════════════════════
           MODAL TAMBAH PETUGAS — Redesign
        ══════════════════════════════════════════════ */
        .modal-overlay {
            position: fixed; inset: 0;
            background: rgba(15,25,35,0.5);
            backdrop-filter: blur(4px);
            display: flex; align-items: flex-end; justify-content: center;
            z-index: 1050;
            opacity: 0; pointer-events: none;
            transition: opacity 0.22s;
        }
        .modal-overlay.open { opacity: 1; pointer-events: all; }

        .modal-card {
            background: #fff;
            width: 100%; max-width: 680px;
            border-radius: 20px 20px 0 0;
            overflow: hidden;
            transform: translateY(40px);
            transition: transform 0.3s cubic-bezier(0.34,1.1,0.64,1);
            max-height: 92dvh;
            display: flex; flex-direction: column;
            box-shadow: 0 -8px 40px rgba(0,0,0,0.15);
        }
        .modal-overlay.open .modal-card { transform: translateY(0); }

        @media (min-width: 640px) {
            .modal-overlay { align-items: center; padding: 20px; }
            .modal-card {
                border-radius: 20px;
                transform: translateY(16px) scale(0.97);
                box-shadow: 0 24px 60px rgba(0,0,0,0.18);
            }
            .modal-overlay.open .modal-card { transform: translateY(0) scale(1); }
        }

        /* Modal drag handle (mobile) */
        .modal-handle {
            display: none;
            width: 36px; height: 4px;
            background: #e2e8f0; border-radius: 2px;
            margin: 10px auto 0;
        }
        @media (max-width: 639px) { .modal-handle { display: block; } }

        /* Modal header */
        .modal-header-bar {
            padding: 18px 22px 16px;
            border-bottom: 1px solid #f1f5f9;
            display: flex; justify-content: space-between; align-items: center;
            flex-shrink: 0;
        }
        .mh-left { display: flex; align-items: center; gap: 12px; }
        .mh-icon {
            width: 40px; height: 40px; border-radius: 12px;
            background: linear-gradient(135deg, #1e6f5c, #2a9d7f);
            color: white;
            display: flex; align-items: center; justify-content: center;
            font-size: 15px; flex-shrink: 0;
        }
        .mh-title { font-weight: 800; font-size: 0.95rem; color: #0f172a; margin-bottom: 1px; }
        .mh-sub   { font-size: 0.7rem; color: var(--c-text-muted); }
        .modal-close-btn {
            width: 32px; height: 32px;
            border: 1px solid #e2e8f0; border-radius: 9px;
            background: #f8fafc; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            color: #64748b; font-size: 12px;
            transition: background .15s, color .15s;
        }
        .modal-close-btn:hover { background: #fff1f2; color: #e11d48; border-color: #fecdd3; }

        /* Modal body */
        .modal-body { padding: 20px 22px; overflow-y: auto; flex: 1; }

        /* Step progress */
        .modal-steps {
            display: flex; gap: 0;
            margin-bottom: 22px;
            border-radius: 10px; overflow: hidden;
            border: 1px solid #e2e8f0;
        }
        .ms-item {
            flex: 1; padding: 8px 10px;
            display: flex; align-items: center; gap: 7px;
            font-size: 0.71rem; font-weight: 600;
            color: #94a3b8; background: #f8fafc;
            border-right: 1px solid #e2e8f0; cursor: pointer;
            transition: background .15s, color .15s;
        }
        .ms-item:last-child { border-right: none; }
        .ms-item.active { background: #fff; color: #1e6f5c; }
        .ms-item.done   { background: #f0fdf4; color: #16a34a; }
        .ms-num {
            width: 20px; height: 20px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 10px; font-weight: 700; flex-shrink: 0;
            background: #e2e8f0; color: #64748b;
        }
        .ms-item.active .ms-num { background: #1e6f5c; color: white; }
        .ms-item.done   .ms-num { background: #16a34a; color: white; }

        /* Section label dalam modal */
        .modal-section-label {
            font-size: 0.65rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.08em;
            color: #94a3b8; margin-bottom: 12px; margin-top: 18px;
            display: flex; align-items: center; gap: 8px;
        }
        .modal-section-label::after { content:''; flex:1; height:1px; background:#f1f5f9; }
        .modal-section-label:first-child { margin-top: 0; }

        /* Field grid */
        .field-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; margin-bottom: 0; }
        .field-group  { display: flex; flex-direction: column; gap: 5px; }
        .form-label-sm {
            font-size: 0.69rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.05em;
            color: #475569;
        }
        .form-label-sm .req { color: #ef4444; margin-left: 2px; }

        .field-input {
            width: 100%;
            padding: 9px 12px;
            border: 1px solid #e2e8f0; border-radius: 10px;
            font-size: 0.84rem; font-family: var(--font-body);
            color: #0f172a; background: #fafafa; outline: none;
            transition: border-color .15s, box-shadow .15s, background .15s;
        }
        .field-input:focus {
            border-color: #1e6f5c;
            box-shadow: 0 0 0 3px rgba(30,111,92,0.1);
            background: white;
        }
        .field-input.has-error { border-color: #f43f5e !important; }
        .field-input::placeholder { color: #c0ccd8; }

        .pw-wrap { position: relative; }
        .pw-wrap .field-input { padding-right: 36px; }
        .pw-toggle {
            position: absolute; right: 10px; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer;
            color: #94a3b8; font-size: 12px; padding: 4px;
            transition: color .15s;
        }
        .pw-toggle:hover { color: #475569; }

        .field-hint-msg {
            font-size: 0.68rem; color: #ef4444; margin-top: 3px;
            display: none; align-items: center; gap: 4px;
        }
        .field-hint-msg.show { display: flex; }
        .field-hint-note { font-size: 0.68rem; color: #94a3b8; margin-top: 3px; }

        /* Strength bar */
        .pw-strength-bar { height: 3px; border-radius: 3px; background: #e2e8f0; overflow: hidden; margin-top: 5px; }
        .pw-strength-fill { height: 100%; border-radius: 3px; width: 0; transition: width .3s, background .3s; }

        /* Role grid — redesign */
        .role-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }
        .role-card {
            border: 1.5px solid #e2e8f0; border-radius: 12px;
            padding: 12px 10px; cursor: pointer;
            position: relative; transition: border-color .15s, background .15s, box-shadow .15s;
            display: flex; flex-direction: column; gap: 4px;
        }
        .role-card:hover { border-color: #1e6f5c; background: #f0fdf4; }
        .role-card.selected { border-color: #1e6f5c; background: #f0fdf4; box-shadow: 0 0 0 3px rgba(30,111,92,0.1); }
        .role-card input[type="radio"] { display: none; }

        .rc-icon {
            width: 30px; height: 30px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; margin-bottom: 4px;
        }
        .rc-label { font-size: 0.8rem; font-weight: 700; color: #1e293b; }
        .rc-desc  { font-size: 0.65rem; color: #64748b; line-height: 1.3; }

        .rc-check {
            position: absolute; top: 8px; right: 8px;
            width: 16px; height: 16px; border-radius: 50%;
            background: #1e6f5c; color: white; font-size: 7px;
            display: none; align-items: center; justify-content: center;
        }
        .role-card.selected .rc-check { display: flex; }

        /* Role colors */
        .rc-kasi    .rc-icon { background:#fff7ed; color:#c2410c; }
        .rc-kabid   .rc-icon { background:#eff6ff; color:#1e40af; }
        .rc-sekdis  .rc-icon { background:#fdf4ff; color:#86198f; }
        .rc-kadis   .rc-icon { background:#ecfdf5; color:#065f46; }
        .rc-operator .rc-icon { background:#f1f5f9; color:#475569; }
        .rc-admin   .rc-icon { background:#f5f3ff; color:#5b21b6; }

        /* Modal footer */
        .modal-footer-bar {
            padding: 14px 22px;
            border-top: 1px solid #f1f5f9;
            display: flex; justify-content: space-between; align-items: center;
            flex-shrink: 0; gap: 10px; background: #fafafa;
        }
        .modal-footer-left { font-size: 0.72rem; color: #94a3b8; display: flex; align-items: center; gap: 5px; }
        .modal-footer-btns { display: flex; gap: 8px; }
        .btn-cancel {
            padding: 0 16px; height: 38px; border-radius: 10px;
            border: 1px solid #e2e8f0; background: white;
            font-size: 0.82rem; font-weight: 600; color: #475569;
            cursor: pointer; transition: background .15s;
        }
        .btn-cancel:hover { background: #f1f5f9; }
        .btn-submit-modal {
            padding: 0 20px; height: 38px; border-radius: 10px;
            background: #1e6f5c; color: white; border: none;
            font-size: 0.82rem; font-weight: 700;
            cursor: pointer; display: flex; align-items: center; gap: 7px;
            transition: background .15s;
        }
        .btn-submit-modal:hover { background: #155f4e; }

        /* ─────────────────────────────────────
           RESPONSIVE MOBILE (≤ 768px)
        ───────────────────────────────────── */
        @media (min-width: 769px) {
            .tbl-desktop { display: block; }
            .officer-cards { display: none !important; }
        }

        @media (max-width: 768px) {
            /* topnav */
            .topnav { padding: 0 12px !important; }
            .topnav-burger { display: flex; }

            /* page content */
            .page-content { padding: 12px !important; }

            /* page head */
            .page-head { gap: 10px; margin-bottom: 14px; }
            .page-head-title { font-size: 0.95rem; }
            .page-head .btn-primary {
                width: 100% !important;
                justify-content: center !important;
                height: 44px !important;
                font-size: 0.88rem !important;
                border-radius: 12px !important;
            }

            /* flash */
            .alert-flash { font-size: 0.79rem; padding: 10px 12px; }

            /* surface */
            .surface { border-radius: 14px !important; }

            /* toolbar */
            .tbl-toolbar { flex-direction: column; align-items: stretch; padding: 12px 14px; }
            .search-wrap { max-width: 100%; }
            .search-input { font-size: 16px !important; }

            /* tabel disembunyikan */
            .tbl-desktop { display: none !important; }
            .officer-cards { display: block; }

            /* card mobile */
            .officer-card { padding: 13px 14px; }
            .oc-name { font-size: 0.86rem; }
            .oc-actions .act-btn { width: 36px; height: 36px; font-size: 12px; }

            /* pagination */
            .paging-wrap { flex-direction: column; align-items: flex-start; padding: 12px 14px; }

            /* modal: full redesign mobile */
            .modal-body { padding: 16px 18px; }
            .modal-header-bar { padding: 14px 18px 12px; }
            .modal-footer-bar { padding: 12px 18px; }

            .modal-steps { margin-bottom: 16px; }
            .ms-item { padding: 7px 8px; font-size: 0.65rem; gap: 5px; }
            .ms-item .ms-label { display: none; } /* hanya tampilkan nomor di mobile */

            .field-grid-2 { grid-template-columns: 1fr !important; gap: 12px; }
            .field-input  { font-size: 16px !important; padding: 11px 12px !important; }
            .pw-wrap .field-input { padding-right: 38px !important; }

            .role-grid { grid-template-columns: 1fr 1fr !important; gap: 8px; }
            .role-card { padding: 11px 10px; }
            .rc-icon  { width: 28px; height: 28px; font-size: 11px; }
            .rc-label { font-size: 0.76rem; }
            .rc-desc  { font-size: 0.62rem; }

            .modal-footer-btns { flex: 1; }
            .btn-cancel, .btn-submit-modal {
                flex: 1; justify-content: center;
                height: 44px !important; font-size: 0.86rem !important;
                border-radius: 12px !important;
            }
        }

        @media (max-width: 400px) {
            .page-content { padding: 10px !important; }
            .role-grid { grid-template-columns: 1fr 1fr !important; }
        }
    </style>
</head>
<body>

<?php $this->load->view('admin/sidebar'); ?>

<div class="page-wrapper">

    <!-- Topnav -->
    <header class="topnav">
        <div class="topnav-breadcrumb">
            <button class="topnav-burger" id="mobileBurger" aria-label="Buka Menu">
                <i class="fas fa-bars"></i>
            </button>
            <a href="<?= base_url('dashboard') ?>" style="color:var(--c-text-muted);text-decoration:none;">
                <i class="fas fa-home"></i>
            </a>
            <i class="fas fa-chevron-right" style="font-size:8px;"></i>
            <strong>Manajemen Petugas</strong>
        </div>
        <div class="topnav-actions"></div>
    </header>

    <main class="page-content">

        <?php if($this->session->flashdata('success')): ?>
        <div class="alert-flash af-ok"><i class="fas fa-check-circle"></i> <?= $this->session->flashdata('success') ?></div>
        <?php endif; ?>
        <?php if($this->session->flashdata('error')): ?>
        <div class="alert-flash af-err"><i class="fas fa-exclamation-circle"></i> <?= $this->session->flashdata('error') ?></div>
        <?php endif; ?>

        <div class="page-head">
            <div>
                <div class="page-head-title">
                    <i class="fas fa-user-shield" style="color:var(--c-primary);"></i>
                    Manajemen Petugas
                </div>
                <div class="page-head-sub">Total <strong><?= count($users) ?></strong> petugas &amp; admin terdaftar</div>
            </div>
            <button id="openModalBtn" class="btn-primary" style="height:38px;padding:0 16px;">
                <i class="fas fa-plus"></i> Tambah Petugas
            </button>
        </div>

        <!-- ══════════════════════════════════════════════
             MODAL TAMBAH PETUGAS
        ══════════════════════════════════════════════ -->
        <div class="modal-overlay" id="addOfficerModal">
            <div class="modal-card">

                <div class="modal-handle"></div>

                <div class="modal-header-bar">
                    <div class="mh-left">
                        <div class="mh-icon"><i class="fas fa-user-plus"></i></div>
                        <div>
                            <div class="mh-title">Tambah Petugas Baru</div>
                            <div class="mh-sub">Lengkapi identitas, akun, dan pilih role</div>
                        </div>
                    </div>
                    <button class="modal-close-btn" id="closeModalBtn">
                        <i class="fas fa-xmark"></i>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="<?= base_url('admin/add_officer') ?>" method="post" id="addOfficerForm">
                        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>"
                               value="<?= $this->security->get_csrf_hash() ?>">

                        <!-- ── Identitas ── -->
                        <div class="modal-section-label">Identitas Petugas</div>
                        <div class="field-grid-2">
                            <div class="field-group">
                                <label class="form-label-sm">Nama Lengkap <span class="req">*</span></label>
                                <input type="text" id="f_nama" name="nama" class="field-input"
                                       placeholder="Masukkan nama lengkap"
                                       required value="<?= set_value('nama') ?>">
                            </div>
                            <div class="field-group">
                                <label class="form-label-sm">NIP <span class="req">*</span></label>
                                <input type="text" id="f_nip" name="nip" class="field-input"
                                       placeholder="19670512 199403 1 005"
                                       required value="<?= set_value('nip') ?>">
                            </div>
                        </div>

                        <!-- ── Akun ── -->
                        <div class="modal-section-label">Akun &amp; Kontak</div>
                        <div class="field-grid-2">
                            <div class="field-group">
                                <label class="form-label-sm">Email <span class="req">*</span></label>
                                <input type="email" id="f_email" name="email" class="field-input"
                                       placeholder="email@disnaker.go.id"
                                       required value="<?= set_value('email') ?>">
                            </div>
                            <div class="field-group">
                                <label class="form-label-sm">No. Handphone <span class="req">*</span></label>
                                <input type="tel" id="f_nohp" name="no_hp" class="field-input"
                                       placeholder="081234567890"
                                       inputmode="numeric"
                                       required value="<?= set_value('no_hp') ?>">
                            </div>
                            <div class="field-group">
                                <label class="form-label-sm">Password <span class="req">*</span></label>
                                <div class="pw-wrap">
                                    <input type="password" id="f_password" name="password"
                                           class="field-input" placeholder="Min. 8 karakter" required>
                                    <button type="button" class="pw-toggle" id="pwToggle">
                                        <i class="fas fa-eye" id="pwIcon"></i>
                                    </button>
                                </div>
                                <div class="pw-strength-bar"><div class="pw-strength-fill" id="pwStrengthFill"></div></div>
                                <div class="field-hint-note">Min. 8 karakter, huruf besar, angka, simbol</div>
                            </div>
                            <div class="field-group">
                                <label class="form-label-sm">Konfirmasi Password <span class="req">*</span></label>
                                <div class="pw-wrap">
                                    <input type="password" id="f_password2" class="field-input"
                                           placeholder="Ulangi password" required>
                                    <button type="button" class="pw-toggle" id="pwToggle2">
                                        <i class="fas fa-eye" id="pwIcon2"></i>
                                    </button>
                                </div>
                                <div class="field-hint-msg" id="pwMatchHint">
                                    <i class="fas fa-circle-xmark" style="font-size:10px;"></i>
                                    Password tidak cocok
                                </div>
                            </div>
                        </div>

                        <!-- ── Role ── -->
                        <div class="modal-section-label">Pilih Role <span class="req" style="font-size:0.7rem;">*</span></div>
                        <div class="role-grid" id="roleGrid">
                            <label class="role-card rc-kasi" data-role="kasi">
                                <input type="radio" name="role" value="kasi">
                                <div class="rc-check"><i class="fas fa-check"></i></div>
                                <div class="rc-icon"><i class="fas fa-user-check"></i></div>
                                <div class="rc-label">Kasi</div>
                                <div class="rc-desc">Verifikator Level 1</div>
                            </label>
                            <label class="role-card rc-kabid" data-role="kabid">
                                <input type="radio" name="role" value="kabid">
                                <div class="rc-check"><i class="fas fa-check"></i></div>
                                <div class="rc-icon"><i class="fas fa-user-tie"></i></div>
                                <div class="rc-label">Kabid</div>
                                <div class="rc-desc">Verifikator Level 2</div>
                            </label>
                            <label class="role-card rc-sekdis" data-role="sekdis">
                                <input type="radio" name="role" value="sekdis">
                                <div class="rc-check"><i class="fas fa-check"></i></div>
                                <div class="rc-icon"><i class="fas fa-user-shield"></i></div>
                                <div class="rc-label">Sekdis</div>
                                <div class="rc-desc">Verifikator Level 3</div>
                            </label>
                            <label class="role-card rc-kadis" data-role="kadis">
                                <input type="radio" name="role" value="kadis">
                                <div class="rc-check"><i class="fas fa-check"></i></div>
                                <div class="rc-icon"><i class="fas fa-crown"></i></div>
                                <div class="rc-label">Kadis</div>
                                <div class="rc-desc">Approval Final</div>
                            </label>
                            <label class="role-card rc-operator" data-role="operator">
                                <input type="radio" name="role" value="operator">
                                <div class="rc-check"><i class="fas fa-check"></i></div>
                                <div class="rc-icon"><i class="fas fa-stamp"></i></div>
                                <div class="rc-label">Operator</div>
                                <div class="rc-desc">Input nomor surat</div>
                            </label>
                            <label class="role-card rc-admin" data-role="admin">
                                <input type="radio" name="role" value="admin">
                                <div class="rc-check"><i class="fas fa-check"></i></div>
                                <div class="rc-icon"><i class="fas fa-user-cog"></i></div>
                                <div class="rc-label">Admin</div>
                                <div class="rc-desc">Akses penuh sistem</div>
                            </label>
                        </div>

                    </form>
                </div>

                <div class="modal-footer-bar">
                    <div class="modal-footer-left">
                        <i class="fas fa-shield-alt" style="color:var(--c-primary);"></i>
                        Field <span style="color:#ef4444;">*</span> wajib diisi
                    </div>
                    <div class="modal-footer-btns">
                        <button type="button" class="btn-cancel" id="closeModalBtn2">Batal</button>
                        <button type="submit" form="addOfficerForm" class="btn-submit-modal">
                            <i class="fas fa-user-plus"></i> Simpan Petugas
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <!-- ── TABEL & CARD STACK ── -->
        <div class="surface" style="overflow:hidden;">
            <div class="tbl-toolbar">
                <div class="search-wrap" id="searchWrap">
                    <i class="fas fa-search s-icon"></i>
                    <input type="text" class="search-input" id="searchInput"
                           placeholder="Cari nama, NIP, email, role…">
                    <button class="s-clear" id="searchClear"><i class="fas fa-xmark"></i></button>
                </div>
                <div class="tbl-counter">
                    <strong id="visibleCount"><?= count($users) ?></strong> dari <?= count($users) ?> petugas
                </div>
            </div>

            <?php
            $role_labels = [
                'admin'   =>['label'=>'Admin',    'class'=>'rp-admin'],
                'kasi'    =>['label'=>'Kasi',     'class'=>'rp-kasi'],
                'kabid'   =>['label'=>'Kabid',    'class'=>'rp-kabid'],
                'sekdis'  =>['label'=>'Sekdis',   'class'=>'rp-sekdis'],
                'kadis'   =>['label'=>'Kadis',    'class'=>'rp-kadis'],
                'operator'=>['label'=>'Operator', 'class'=>'rp-operator'],
            ];
            $logged_in_id = (int)$this->session->userdata('user_id');
            $users_data   = $users;
            ?>

            <!-- DESKTOP TABLE -->
            <div class="tbl-desktop">
                <div style="overflow-x:auto;">
                    <table class="data-table" id="officerTable">
                        <thead>
                            <tr>
                                <th style="width:40px;text-align:center;">#</th>
                                <th>Petugas</th>
                                <th>Role</th>
                                <th>Kontak</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                        <?php $no=1; foreach($users_data as $u):
                            $init = strtoupper(substr($u->nama,0,1));
                            if(strpos($u->nama,' ')!==false) $init .= strtoupper(substr(explode(' ',$u->nama)[1],0,1));
                            $isActive = $u->is_active == 1;
                            $rInfo = $role_labels[$u->role] ?? ['label'=>strtoupper($u->role),'class'=>'rp-operator'];
                            $is_self = $u->id == $logged_in_id;
                            $sv = strtolower($u->nama.' '.($u->nip??'').' '.$u->email.' '.$u->no_hp.' '.$u->role);
                        ?>
                        <tr data-search="<?= htmlspecialchars($sv) ?>">
                            <td style="text-align:center;"><?= $no++ ?></td>
                            <td>
                                <div class="officer-cell">
                                    <div class="off-avatar"><?= $init ?></div>
                                    <div>
                                        <div class="off-name" data-field="nama">
                                            <?= htmlspecialchars($u->nama) ?>
                                            <?php if($is_self): ?><span class="self-tag">ANDA</span><?php endif; ?>
                                        </div>
                                        <div class="off-nip" data-field="nip">NIP: <?= $u->nip ?? '-' ?></div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="role-pill <?= $rInfo['class'] ?>"><?= $rInfo['label'] ?></span></td>
                            <td>
                                <div class="contact-email" data-field="email"><i class="fas fa-envelope"></i> <?= htmlspecialchars($u->email) ?></div>
                                <div class="contact-phone" data-field="no_hp"><i class="fas fa-phone"></i> <?= htmlspecialchars($u->no_hp) ?></div>
                            </td>
                            <td><span class="sts-badge <?= $isActive ? 'sts-aktif' : 'sts-nonaktif' ?>"><?= $isActive ? 'Aktif' : 'Nonaktif' ?></span></td>
                            <td>
                                <div class="act-row">
                                    <a href="<?= base_url('admin/edit_officer/'.$u->id) ?>" class="act-btn ab-edit" title="Edit"><i class="fas fa-pen"></i></a>
                                    <?php if($is_self): ?>
                                        <span class="act-btn ab-disabled" title="Tidak dapat reset sendiri"><i class="fas fa-key"></i></span>
                                    <?php else: ?>
                                        <a href="<?= base_url('admin/reset_officer_password/'.$u->id) ?>" class="act-btn ab-reset" title="Reset Password" onclick="return confirm('Reset password?')"><i class="fas fa-key"></i></a>
                                    <?php endif; ?>
                                    <?php if($is_self): ?>
                                        <span class="act-btn ab-disabled"><i class="fas fa-ban"></i></span>
                                    <?php elseif($isActive): ?>
                                        <a href="<?= base_url('admin/toggle_officer_status/'.$u->id) ?>" class="act-btn ab-off" title="Nonaktifkan" onclick="return confirm('Nonaktifkan petugas ini?')"><i class="fas fa-ban"></i></a>
                                    <?php else: ?>
                                        <a href="<?= base_url('admin/toggle_officer_status/'.$u->id) ?>" class="act-btn ab-on" title="Aktifkan" onclick="return confirm('Aktifkan petugas ini?')"><i class="fas fa-check"></i></a>
                                    <?php endif; ?>
                                    <?php if($is_self || $u->id==1): ?>
                                        <span class="act-btn ab-disabled" title="Tidak dapat dihapus"><i class="fas fa-lock"></i></span>
                                    <?php else: ?>
                                        <a href="<?= base_url('admin/delete_officer/'.$u->id) ?>" class="act-btn ab-delete" title="Hapus" onclick="return confirm('Hapus petugas ini?')"><i class="fas fa-trash"></i></a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- MOBILE CARDS -->
            <div class="officer-cards" id="officerCards">
                <?php $no2=1; foreach($users_data as $u):
                    $init = strtoupper(substr($u->nama,0,1));
                    if(strpos($u->nama,' ')!==false) $init .= strtoupper(substr(explode(' ',$u->nama)[1],0,1));
                    $isActive = $u->is_active == 1;
                    $rInfo = $role_labels[$u->role] ?? ['label'=>strtoupper($u->role),'class'=>'rp-operator'];
                    $is_self = $u->id == $logged_in_id;
                    $sv = strtolower($u->nama.' '.($u->nip??'').' '.$u->email.' '.$u->no_hp.' '.$u->role);
                ?>
                <div class="officer-card" data-search="<?= htmlspecialchars($sv) ?>">
                    <div class="oc-top">
                        <div style="display:flex;gap:10px;flex:1;align-items:flex-start;">
                            <div class="off-avatar" style="width:40px;height:40px;"><?= $init ?></div>
                            <div class="oc-info">
                                <div class="oc-name">
                                    <?= htmlspecialchars($u->nama) ?>
                                    <?php if($is_self): ?><span class="self-tag">ANDA</span><?php endif; ?>
                                </div>
                                <div class="oc-nip">NIP: <?= $u->nip ?? '-' ?></div>
                            </div>
                        </div>
                        <span class="sts-badge <?= $isActive ? 'sts-aktif' : 'sts-nonaktif' ?>">
                            <?= $isActive ? 'Aktif' : 'Nonaktif' ?>
                        </span>
                    </div>
                    <div class="oc-badges">
                        <span class="role-pill <?= $rInfo['class'] ?>"><?= $rInfo['label'] ?></span>
                    </div>
                    <div class="oc-contact">
                        <span><i class="fas fa-envelope"></i> <?= htmlspecialchars($u->email) ?></span>
                        <span><i class="fas fa-phone"></i> <?= htmlspecialchars($u->no_hp) ?></span>
                    </div>
                    <div class="oc-actions">
                        <a href="<?= base_url('admin/edit_officer/'.$u->id) ?>" class="act-btn ab-edit" title="Edit"><i class="fas fa-pen"></i></a>
                        <?php if($is_self): ?>
                            <span class="act-btn ab-disabled"><i class="fas fa-key"></i></span>
                        <?php else: ?>
                            <a href="<?= base_url('admin/reset_officer_password/'.$u->id) ?>" class="act-btn ab-reset" onclick="return confirm('Reset password?')"><i class="fas fa-key"></i></a>
                        <?php endif; ?>
                        <?php if($is_self): ?>
                            <span class="act-btn ab-disabled"><i class="fas fa-ban"></i></span>
                        <?php elseif($isActive): ?>
                            <a href="<?= base_url('admin/toggle_officer_status/'.$u->id) ?>" class="act-btn ab-off" onclick="return confirm('Nonaktifkan?')"><i class="fas fa-ban"></i></a>
                        <?php else: ?>
                            <a href="<?= base_url('admin/toggle_officer_status/'.$u->id) ?>" class="act-btn ab-on" onclick="return confirm('Aktifkan?')"><i class="fas fa-check"></i></a>
                        <?php endif; ?>
                        <?php if($is_self || $u->id==1): ?>
                            <span class="act-btn ab-disabled"><i class="fas fa-lock"></i></span>
                        <?php else: ?>
                            <a href="<?= base_url('admin/delete_officer/'.$u->id) ?>" class="act-btn ab-delete" onclick="return confirm('Hapus?')"><i class="fas fa-trash"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="no-result" id="jsNoResult">
                <i class="fas fa-search" style="font-size:1.5rem;display:block;margin-bottom:8px;opacity:0.3;"></i>
                <p id="jsNoResultMsg"></p>
            </div>

            <div class="paging-wrap" id="pagingWrap">
                <div class="paging-info" id="pagingInfo">—</div>
                <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
                    <div style="display:flex;gap:5px;align-items:center;font-size:0.72rem;">
                        <span>Tampilkan</span>
                        <select id="perPageSelect" class="per-page-sel">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                        <span>per halaman</span>
                    </div>
                    <div class="paging-controls" id="pagingControls"></div>
                </div>
            </div>
        </div>

    </main>
    <?php $this->load->view('footer'); ?>
</div>

<script>
(function(){

    /* ── BURGER ── */
    var burger = document.getElementById('mobileBurger');
    if (burger) {
        burger.addEventListener('click', function(e) {
            e.stopPropagation();
            if (typeof window.openAdminSidebar === 'function') window.openAdminSidebar();
        });
    }

    /* ── MODAL ── */
    var modal    = document.getElementById('addOfficerModal');
    var openBtn  = document.getElementById('openModalBtn');
    var closeBtns = [document.getElementById('closeModalBtn'), document.getElementById('closeModalBtn2')];

    function openModal() {
        modal.classList.add('open');
        document.body.style.overflow = 'hidden';
        setTimeout(function(){ document.getElementById('f_nama').focus(); }, 250);
    }
    function closeModal() {
        modal.classList.remove('open');
        document.body.style.overflow = '';
    }

    openBtn.addEventListener('click', openModal);
    closeBtns.forEach(function(btn){ if(btn) btn.addEventListener('click', closeModal); });
    modal.addEventListener('click', function(e){ if(e.target === modal) closeModal(); });
    document.addEventListener('keydown', function(e){ if(e.key === 'Escape' && modal.classList.contains('open')) closeModal(); });

    /* ── ROLE CARDS ── */
    var roleCards = document.querySelectorAll('.role-card');
    roleCards.forEach(function(c) {
        c.addEventListener('click', function() {
            roleCards.forEach(function(rc){ rc.classList.remove('selected'); });
            this.classList.add('selected');
            this.querySelector('input').checked = true;
        });
    });
    // default: kasi
    var defCard = document.querySelector('.role-card[data-role="kasi"]');
    if (defCard) { defCard.classList.add('selected'); defCard.querySelector('input').checked = true; }

    /* ── PASSWORD TOGGLE ── */
    function makeToggle(btnId, inputId, iconId) {
        var btn = document.getElementById(btnId); if (!btn) return;
        btn.addEventListener('click', function() {
            var inp  = document.getElementById(inputId);
            var icon = document.getElementById(iconId);
            var show = inp.type === 'password';
            inp.type = show ? 'text' : 'password';
            icon.className = show ? 'fas fa-eye-slash' : 'fas fa-eye';
        });
    }
    makeToggle('pwToggle',  'f_password',  'pwIcon');
    makeToggle('pwToggle2', 'f_password2', 'pwIcon2');

    /* ── PASSWORD STRENGTH ── */
    var pw1 = document.getElementById('f_password');
    var pw2 = document.getElementById('f_password2');
    var hint = document.getElementById('pwMatchHint');
    var fill = document.getElementById('pwStrengthFill');

    function checkStrength(val) {
        if (!fill) return;
        var score = 0;
        if (val.length >= 8)          score++;
        if (/[A-Z]/.test(val))        score++;
        if (/[0-9]/.test(val))        score++;
        if (/[@$!%*?&]/.test(val))    score++;
        var levels = [
            { w: '25%',  bg: '#f43f5e' },
            { w: '50%',  bg: '#f97316' },
            { w: '75%',  bg: '#eab308' },
            { w: '100%', bg: '#10b981' },
        ];
        var lv = levels[Math.min(score, 3)];
        fill.style.width = val ? lv.w : '0';
        fill.style.background = lv.bg;
    }

    function checkMatch() {
        if (!pw2.value) { hint.classList.remove('show'); pw2.classList.remove('has-error'); return; }
        var bad = pw1.value !== pw2.value;
        hint.classList.toggle('show', bad);
        pw2.classList.toggle('has-error', bad);
    }

    if (pw1) pw1.addEventListener('input', function(){ checkStrength(this.value); checkMatch(); });
    if (pw2) pw2.addEventListener('input', checkMatch);

    /* ── FORM SUBMIT VALIDATION ── */
    document.getElementById('addOfficerForm')?.addEventListener('submit', function(e) {
        if (pw1.value !== pw2.value) { e.preventDefault(); checkMatch(); pw2.focus(); return; }
        if (!document.querySelector('.role-card.selected')) { e.preventDefault(); alert('Pilih role terlebih dahulu.'); }
    });

    /* ── SEARCH & PAGINATION ── */
    var searchInput    = document.getElementById('searchInput');
    var clearBtn       = document.getElementById('searchClear');
    var searchWrap     = document.getElementById('searchWrap');
    var visCount       = document.getElementById('visibleCount');
    var pagingInfo     = document.getElementById('pagingInfo');
    var pagingControls = document.getElementById('pagingControls');
    var perPageSelect  = document.getElementById('perPageSelect');
    var jsNoResult     = document.getElementById('jsNoResult');
    var jsNoMsg        = document.getElementById('jsNoResultMsg');
    var tableBody      = document.getElementById('tableBody');
    var cardList       = document.getElementById('officerCards');

    var allRows  = tableBody ? Array.from(tableBody.querySelectorAll('tr[data-search]')) : [];
    var allCards = cardList  ? Array.from(cardList.querySelectorAll('.officer-card[data-search]')) : [];
    var totalItems = Math.max(allRows.length, allCards.length);
    var perPage = 10, currentPage = 1, filtered = [];

    allRows.forEach(function(row){ row.querySelectorAll('[data-field]').forEach(function(el){ el.setAttribute('data-orig', el.textContent.trim()); }); });

    function escR(s){ return s.replace(/[.*+?^${}()|[\]\\]/g,'\\$&'); }
    function hl(text, q){ if(!q) return text; return text.replace(new RegExp('('+escR(q)+')','gi'),'<mark class="hl">$1</mark>'); }

    function setVisible(idx, show, q) {
        if (allRows[idx]) {
            allRows[idx].style.display = show ? '' : 'none';
            if (show) allRows[idx].querySelectorAll('[data-field]').forEach(function(el){ el.innerHTML = q ? hl(el.getAttribute('data-orig')||'', q) : el.getAttribute('data-orig')||''; });
        }
        if (allCards[idx]) { if (show) allCards[idx].classList.remove('card-hidden'); else allCards[idx].classList.add('card-hidden'); }
    }

    function doSearch(q) {
        q = q.trim().toLowerCase(); filtered = [];
        for (var i=0; i<totalItems; i++) {
            var ref = allRows[i] || allCards[i]; if (!ref) continue;
            var val = ref.getAttribute('data-search') || '';
            if (!q || val.indexOf(q) !== -1) filtered.push(i);
        }
        searchWrap.classList.toggle('has-value', q.length > 0);
        currentPage = 1; applyPage(q);
    }

    function applyPage(q) {
        if (q === undefined) q = searchInput.value.trim().toLowerCase();
        var total = filtered.length, tp = Math.max(1, Math.ceil(total/perPage));
        if (currentPage > tp) currentPage = tp;
        var start = (currentPage-1)*perPage, end = Math.min(currentPage*perPage, total);
        for (var i=0; i<totalItems; i++) setVisible(i, false, q);
        filtered.forEach(function(idx, pos){ if (pos >= start && pos < end) setVisible(idx, true, q); });
        if (visCount) visCount.textContent = total;
        if (jsNoResult) {
            jsNoResult.style.display = (total===0 && totalItems>0) ? 'block' : 'none';
            if (total===0 && q) jsNoMsg.innerHTML = 'Tidak ada hasil untuk &ldquo;<strong>'+q+'</strong>&rdquo;';
            else if (total===0) jsNoMsg.textContent = 'Tidak ada data.';
        }
        if (pagingInfo) pagingInfo.innerHTML = total > 0
            ? 'Menampilkan <strong>'+(start+1)+'–'+end+'</strong> dari <strong>'+total+'</strong> petugas'
            : '0 petugas ditemukan';
        buildPaging(total, tp);
    }

    function buildPaging(total, tp) {
        if (!pagingControls) return; pagingControls.innerHTML = ''; if (tp <= 1) return;
        function mkBtn(html, dis, cb){ var b=document.createElement('button'); b.className='page-btn'; b.innerHTML=html; b.disabled=dis; if(!dis) b.addEventListener('click',cb); return b; }
        function mkNum(num){ var b=document.createElement('button'); b.className='page-btn'+(num===currentPage?' active':''); b.textContent=num; b.addEventListener('click',function(){ currentPage=num; applyPage(); }); return b; }
        function mkDots(){ var s=document.createElement('span'); s.className='page-btn'; s.style.cursor='default'; s.textContent='…'; return s; }
        pagingControls.appendChild(mkBtn('<i class="fas fa-chevron-left"></i>', currentPage<=1, function(){ currentPage--; applyPage(); }));
        var sp=Math.max(1,currentPage-2), ep=Math.min(tp,sp+4); sp=Math.max(1,ep-4);
        if(sp>1){ pagingControls.appendChild(mkNum(1)); if(sp>2) pagingControls.appendChild(mkDots()); }
        for(var i=sp;i<=ep;i++) pagingControls.appendChild(mkNum(i));
        if(ep<tp){ if(ep<tp-1) pagingControls.appendChild(mkDots()); pagingControls.appendChild(mkNum(tp)); }
        pagingControls.appendChild(mkBtn('<i class="fas fa-chevron-right"></i>', currentPage>=tp, function(){ currentPage++; applyPage(); }));
    }

    searchInput.addEventListener('input', function(){ doSearch(this.value); });
    clearBtn.addEventListener('click',    function(){ searchInput.value=''; doSearch(''); searchInput.focus(); });
    perPageSelect.addEventListener('change', function(){ perPage=parseInt(this.value); currentPage=1; applyPage(); });

    document.addEventListener('keydown', function(e) {
        if (modal.classList.contains('open')) return;
        if ((e.key==='/' && document.activeElement!==searchInput) || (e.ctrlKey && e.key==='k')) { e.preventDefault(); searchInput.focus(); searchInput.select(); }
        if (e.key==='Escape' && document.activeElement===searchInput) { searchInput.value=''; doSearch(''); searchInput.blur(); }
    });

    doSearch('');

})();
</script>
</body>
</html>