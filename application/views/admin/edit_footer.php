<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Footer - Admin</title>
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
            border: 1px solid var(--border-light);
            box-shadow: var(--card-shadow);
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
            margin-bottom: 8px;
        }
        .form-control, .form-select {
            border-radius: 16px;
            border: 1px solid var(--border-light);
            padding: 10px 15px;
            transition: 0.2s;
        }
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(30,111,92,0.1);
        }
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
            border-radius: 40px;
            padding: 10px 28px;
            font-weight: 500;
        }
        .btn-primary:hover {
            background-color: #0f4c3f;
        }
        .btn-secondary {
            border-radius: 40px;
            padding: 10px 28px;
        }
        .preview-box {
            background: #fafcff;
            border-left: 4px solid var(--primary);
            padding: 20px;
            border-radius: 20px;
            margin-top: 16px;
        }
        .preview-content {
            background: white;
            border: 1px solid var(--border-light);
            border-radius: 16px;
            padding: 20px;
            font-size: 0.9rem;
        }
        @media (max-width: 768px) {
            .content {
                margin-left: 0;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
<?php $this->load->view('admin/sidebar'); ?>
<div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h3 class="fw-semibold"><i class="fas fa-copyright me-2"></i> Edit Footer Website</h3>
        <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali ke Dashboard</a>
    </div>

    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> <?= $this->session->flashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <i class="fas fa-pen-ruler me-2"></i> Pengaturan Footer
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/update_footer') ?>" method="post">
                <div class="mb-4">
                    <label class="form-label">Teks Footer (mendukung HTML)</label>
                    <textarea name="footer_text" class="form-control" rows="5" placeholder="Contoh: &copy; Copyright Bekasi 2026. All Rights Reserved<br>Designed by IT BSI 2026"><?= htmlspecialchars($settings->footer_text) ?></textarea>
                    <div class="form-text mt-2">
                        <i class="fas fa-info-circle"></i> Anda dapat menggunakan tag HTML seperti <code>&lt;br&gt;</code>, <code>&lt;strong&gt;</code>, <code>&lt;em&gt;</code>, dll.
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Footer</button>
                    <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="fas fa-eye me-2"></i> Preview Footer
        </div>
        <div class="card-body">
            <div class="preview-box">
                <div class="preview-content">
                    <?= $settings->footer_text ?>
                </div>
            </div>
            <div class="mt-3 text-muted small">
                <i class="fas fa-lightbulb"></i> Perubahan akan langsung terlihat di semua halaman setelah disimpan.
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('footer'); ?>
</body>
</html>