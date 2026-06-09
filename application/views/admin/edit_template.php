<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Template Surat - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --bg-soft: #f8fafc;
            --white: #ffffff;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --primary: #1e6f5c;
            --primary-light: #e6f4f0;
            --border-light: #e9ecef;
            --card-shadow: 0 8px 30px rgba(0,0,0,0.04), 0 2px 4px rgba(0,0,0,0.02);
        }
        body {
            background: var(--bg-soft);
            font-family: 'Inter', sans-serif;
            color: var(--text-dark);
            margin: 0;
        }
        .content {
            margin-left: 260px;
            padding: 28px 32px;
            transition: margin-left 0.3s ease;
        }
        .sidebar.collapsed ~ .content {
            margin-left: 70px;
        }
        .card {
            background: var(--white);
            border-radius: 24px;
            box-shadow: var(--card-shadow);
            border: 1px solid var(--border-light);
            margin-bottom: 24px;
        }
        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--border-light);
            font-weight: 600;
            padding: 18px 24px;
        }
        .card-body {
            padding: 24px;
        }
        .form-label {
            font-weight: 500;
            color: var(--text-dark);
        }
        .form-control, .form-select {
            border-radius: 16px;
            border: 1px solid var(--border-light);
            padding: 10px 15px;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(30,111,92,0.1);
        }
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            border-radius: 16px;
            padding: 8px 24px;
        }
        .btn-primary:hover {
            background-color: #0f4c3f;
        }
        .preview-box {
            background: #fafcff;
            border-left: 4px solid var(--primary);
            padding: 16px;
            border-radius: 16px;
        }
        @media (max-width: 768px) {
            .content { margin-left: 0; padding: 20px; }
        }
    </style>
</head>
<body>
<?php $this->load->view('admin/sidebar'); ?>
<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-semibold"><i class="fas fa-edit me-2"></i> Edit Template Surat Keterangan TKA</h3>
        <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali ke Dashboard</a>
    </div>

    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">Konfigurasi Template Surat</div>
        <div class="card-body">
            <form action="<?= base_url('admin/update_template') ?>" method="post">
                <div class="mb-4">
                    <label class="form-label">Header Surat (HTML)</label>
                    <textarea name="header" class="form-control" rows="8" style="font-family: monospace;"><?= htmlspecialchars($template->header) ?></textarea>
                    <div class="form-text">Gunakan tag HTML untuk kop surat, instansi, alamat, dll.</div>
                </div>
                <div class="mb-4">
                    <label class="form-label">Footer Surat (HTML)</label>
                    <textarea name="footer" class="form-control" rows="5" style="font-family: monospace;"><?= htmlspecialchars($template->footer) ?></textarea>
                </div>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Nama Kepala Dinas</label>
                        <input type="text" name="kepala_dinas" class="form-control" value="<?= htmlspecialchars($template->kepala_dinas) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">NIP Kepala Dinas</label>
                        <input type="text" name="nip_kepala_dinas" class="form-control" value="<?= htmlspecialchars($template->nip_kepala_dinas) ?>">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="form-label">Format Nomor Surat</label>
                    <input type="text" name="nomor_surat_format" class="form-control" value="<?= htmlspecialchars($template->nomor_surat_format) ?>">
                    <div class="form-text">Gunakan <code>{id}</code> untuk ID TKA dan <code>{tahun}</code> untuk tahun berjalan.</div>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Template</button>
                <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Preview Hasil Template</div>
        <div class="card-body preview-box">
            <div class="small text-muted mb-2">Contoh output untuk TKA ID=123, tahun <?= date('Y') ?>:</div>
            <div class="bg-white p-3 rounded border">
                <strong>Nomor surat:</strong> <?= str_replace(['{id}', '{tahun}'], ['123', date('Y')], $template->nomor_surat_format) ?><br>
                <strong>Kepala Dinas:</strong> <?= htmlspecialchars($template->kepala_dinas) ?><br>
                <strong>NIP:</strong> <?= htmlspecialchars($template->nip_kepala_dinas) ?>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('footer'); ?>
</body>
</html>