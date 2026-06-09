<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes, shrink-to-fit=no">
    <title>TKA App - Tenaga Kerja Asing</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Fonts (Plus Jakarta Sans & DM Sans) -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- CSS Utama Anda -->
    <link rel="stylesheet" href="<?= base_url('assets/css/shared.css') ?>">
    
    <!-- CSRF Token -->
    <meta name="csrf-token-name" content="<?= $this->security->get_csrf_token_name() ?>">
    <meta name="csrf-token-value" content="<?= $this->security->get_csrf_hash() ?>">
</head>
<!-- Variabel base_url untuk JS -->
<script>
    var base_url = '<?= base_url() ?>';
    // Tandai apakah user sudah login (opsional)
    $('body').attr('data-user-logged', '<?= isset($user) ? "true" : "false" ?>');
</script>
<body>