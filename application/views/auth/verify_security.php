<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<title>Verifikasi Keamanan - SITLAKEB TKA</title>

<link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
/* ========================================================
   1. RESET & BASE STYLES
   ======================================================== */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Inter',sans-serif;
    min-height:100vh;
    background:#eef5f3;
    overflow-x: hidden;
}

/* ========================================================
   2. LAYOUT CONTAINER (RESPONSIVE FLEXBOX)
   ======================================================== */
.login-page{
    width:100%;
    min-height:100vh;
    position:relative;

    background:
    linear-gradient(
        to right,
        rgba(255,255,255,.65) 35%, 
        rgba(255,255,255,.85) 100%
    ),
    url("<?= base_url('assets/images/bg-pemerintahan2.jpg') ?>");

    background-size:cover;
    background-position:center;
    background-repeat:no-repeat;

    display:flex;
    flex-direction: row;
    align-items:center;
    justify-content:center;
    gap:60px;

    padding:40px 5%;
}

.login-page::before{
    content:"";
    position:absolute;
    inset:0;
    background:
        radial-gradient(circle at 14% 10%, rgba(8,116,86,.05), transparent 30%),
        radial-gradient(circle at 88% 88%, rgba(8,116,86,.08), transparent 32%);
    pointer-events:none;
}

/* ========================================================
   3. LEFT SECTION (BRAND & FEATURES)
   ======================================================== */
.left-section{
    width:100%;
    max-width:700px;
    position:relative;
    z-index:2;

    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    text-align:center;
    flex: 1 1 0%;
}

.logo-box img{
    width:180px;
    height:180px;
    object-fit:contain;
    margin-bottom:18px;
}

.brand-title{
    font-size:46px;
    font-weight:800;
    color:#0f172a;
    letter-spacing:-1.5px;
    margin-bottom:12px;
}

.brand-title span{
    color:#087456;
}

.brand-subtitle{
    color:#111827;
    font-size:20px;
    line-height:1.6;
    margin-bottom:45px;
    font-weight:700;
}

/* Fitur Barisan Horizontal Moderen */
.feature-grid{
    display:flex;
    flex-direction:row;
    justify-content:center;
    align-items:flex-start;
    gap:24px;
    width:100%;
}

.feature-card{
    flex:1;
    max-width:150px;
    display:flex;
    flex-direction:column;
    align-items:center;
    text-align:center;
}

.feature-card i{
    width:48px;
    height:48px;

    display:flex;
    align-items:center;
    justify-content:center;

    background:#ffffff;
    color:#087456;
    border-radius:14px;
    font-size:20px;
    margin-bottom:12px;
    border:1px solid rgba(8,116,86,.12);
    box-shadow: 0 4px 12px rgba(0,0,0,0.04);
}

.feature-card p{
    color:#0f172a;
    font-size:13px;
    line-height:1.4;
    font-weight:700;
}

/* ========================================================
   4. RIGHT SECTION (WHITE CARD VERIFICATION)
   ======================================================== */
.right-section{
    position:relative;
    z-index:2;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:center;
    gap:20px;
    flex: 1 1 0%;
    max-width: 440px;
}

.login-card{
    width:100%;
    background:#ffffff;
    border:1px solid #ffffff;
    border-radius:32px;
    padding:45px 35px;
    box-shadow:0 30px 60px rgba(15,23,42,.12);
}

.form-title{
    margin-bottom:24px;
}

.form-title h2{
    color:#0f172a;
    font-size:26px;
    font-weight:800;
    margin-bottom:7px;
}

.form-title p{
    color:#64748b;
    font-size:14px;
    line-height:1.5;
}

/* ===== INFO BOX ===== */
.info-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 14px 16px;
    margin-bottom: 18px;
}
.info-row {
    display: flex; 
    align-items: flex-start; 
    gap: 10px;
    font-size: 13px; 
    color: #334155;
    padding: 6px 0;
}
.info-row:first-child { 
    border-bottom: 1px solid #edf2f7; 
    padding-bottom: 8px; 
    margin-bottom: 4px; 
}
.info-row i { 
    color: #087456; 
    font-size: 14px; 
    margin-top: 2px; 
    flex-shrink: 0; 
}
.info-row strong { 
    color: #0f172a; 
}

/* ===== ALERT BOXES ===== */
.alert-box {
    display: flex;
    align-items: center;
    gap: 10px;
    border-radius: 12px;
    padding: 12px 14px;
    margin-bottom: 18px;
    font-size: 13px;
}
.alert-box i {
    font-size: 13px;
    flex-shrink: 0;
}
.alert-err {
    background:#fff1f2;
    border:1px solid #fecdd3;
    color:#9f1239;
}
.alert-warn {
    background: #fffbeb;
    border: 1px solid #fde68a;
    color: #92400e;
}
.alert-lock {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #b91c1c;
}

/* ===== FORM FIELDS ===== */
.field{
    margin-bottom:18px;
}

.field label{
    display:block;
    color:#1e293b;
    font-size:13px;
    font-weight:700;
    margin-bottom:7px;
}

.input-wrap{
    position:relative;
}

.input-icon{
    position:absolute;
    left:15px;
    top:50%;
    transform:translateY(-50%);
    color:#94a3b8;
    font-size:14px;
}

.form-input{
    width:100%;
    height:46px;
    border:1px solid #dbe4ee;
    border-radius:12px;
    background:#f8fafc;
    padding:0 44px;
    font-size:14px;
    color:#0f172a;
    outline:none;
    font-family:'Inter',sans-serif;
    transition:.2s ease;
}

.form-input:focus{
    background:#fff;
    border-color:#087456;
    box-shadow:0 0 0 4px rgba(8,116,86,.12);
}

.form-input:disabled {
    background: #f1f5f9;
    color: #94a3b8;
    border-color: #cbd5e1;
    cursor: not-allowed;
}

.hint{
    font-size:12px;
    color:#64748b;
    margin-top:5px;
    display:flex;
    align-items:flex-start;
    gap:5px;
    line-height:1.4;
}

.hint i{
    font-size:11px;
    margin-top:2px;
    flex-shrink:0;
}

/* ===== BUTTONS ===== */
.btn-submit{
    width:100%;
    height:48px;
    border:none;
    border-radius:12px;
    background:linear-gradient(135deg,#087456,#0f5f49);
    color:white;
    font-size:15px;
    font-weight:800;
    cursor:pointer;
    font-family:'Inter',sans-serif;
    margin-top:8px;
    box-shadow:0 10px 20px rgba(8,116,86,.2);
    transition:.2s ease;
}

.btn-submit:hover:not(:disabled){
    transform:translateY(-1px);
    box-shadow:0 14px 26px rgba(8,116,86,.28);
}

.btn-submit:disabled {
    background: #cbd5e1;
    color: #94a3b8;
    box-shadow: none;
    cursor: not-allowed;
}

.form-footer{
    text-align:center;
    margin-top:20px;
    font-size:13px;
    color:#64748b;
}

.form-footer a{
    color:#087456;
    font-weight:800;
    text-decoration:none;
}

.form-footer a:hover{
    text-decoration:underline;
}

.access-info {
    text-align:center;
    font-size:12px;
    color:#475569;
    line-height:1.5;
    background: rgba(255, 255, 255, 0.75);
    padding: 8px 16px;
    border-radius: 20px;
    backdrop-filter: blur(4px);
    border: 1px solid rgba(255,255,255,0.6);
}

/* ========================================================
   5. BREAKPOINTS MEDIA QUERIES (BREAKDOWN RESPONSIVE)
   ======================================================== */

@media(max-width:1200px){
    .login-page{
        gap:40px;
    }
    .brand-title{
        font-size:40px;
    }
    .brand-subtitle{
        font-size:17px;
    }
    .logo-box img{
        width:150px;
        height:150px;
    }
    .feature-grid{
        gap: 16px;
    }
}

@media(max-width:992px){
    body{
        overflow-y:auto;
    }
    .login-page{
        flex-direction:column;
        justify-content:flex-start;
        gap:40px;
        padding:60px 24px;
        background:
        linear-gradient(
            rgba(255,255,255,.80),
            rgba(255,255,255,.90)
        ),
        url("<?= base_url('assets/images/bg-pemerintahan2.jpg') ?>");
    }
    .left-section{
        max-width:100%;
        flex: none;
    }
    .feature-grid {
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
    }
    .right-section{
        width:100%;
        max-width:440px;
        flex: none;
    }
}

@media(max-width:600px){
    .login-page {
        padding: 40px 16px;
        gap: 30px;
    }
    .brand-title{
        font-size:32px;
        letter-spacing: -1px;
    }
    .brand-subtitle{
        font-size:15px;
        margin-bottom:30px;
    }
    .feature-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        max-width: 340px;
    }
    .feature-card {
        max-width: 100%;
    }
    .login-card{
        padding:35px 20px;
        border-radius:24px;
    }
}

@media(max-width:400px){
    .logo-box img{
        width:110px;
        height:110px;
    }
    .brand-title{
        font-size:28px;
    }
    .feature-card p {
        font-size: 11px;
    }
    .form-title h2 {
        font-size: 22px;
    }
}
</style>
</head>
<body>

<div class="login-page">

    <section class="left-section">
        <div class="logo-box">
            <img src="<?= base_url('assets/images/logo_kota_bekasi.png') ?>" alt="Logo Kota Bekasi">
        </div>

        <h1 class="brand-title">
            SITLAKEB <span>TKA</span>
        </h1>

        <p class="brand-subtitle">
            Sistem Informasi Tenaga Kerja Asing<br>
            Dinas Tenaga Kerja Kota Bekasi
        </p>

        <div class="feature-grid">
            <div class="feature-card">
                <i class="fas fa-file-alt"></i>
                <p>Pengajuan izin TKA online</p>
            </div>

            <div class="feature-card">
                <i class="fas fa-tasks"></i>
                <p>Alur persetujuan terstruktur</p>
            </div>

            <div class="feature-card">
                <i class="fas fa-bell"></i>
                <p>Notifikasi real-time pengajuan</p>
            </div>

            <div class="feature-card">
                <i class="fas fa-download"></i>
                <p>Download surat keterangan digital</p>
            </div>
        </div>
    </section>

    <section class="right-section">
        <div class="login-card">
            <div class="form-title">
                <h2>Verifikasi Keamanan </h2>
                <p>Jawab pertanyaan keamanan yang Anda daftarkan untuk melanjutkan reset password.</p>
            </div>

            <?php if($this->session->flashdata('error')): ?>
                <div class="alert-box alert-err">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= $this->session->flashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php
            // Validasi Backend Terintegrasi: Sisa percobaan & Status penguncian akun
            $this->load->model('Security_attempts_model');
            $attempts_row = $this->Security_attempts_model->get_attempts($email);
            $is_locked = false;

            if ($attempts_row && !$attempts_row->locked_until):
                $attempts_left = 5 - ($attempts_row->attempts % 5);
                if ($attempts_left > 0 && $attempts_left < 5):
            ?>
                <div class="alert-box alert-warn">
                    <i class="fas fa-triangle-exclamation"></i>
                    <span>Sisa percobaan: <strong><?= $attempts_left ?> kali</strong> lagi sebelum akun dikunci sementara.</span>
                </div>
            <?php
                endif;
            elseif ($attempts_row && $attempts_row->locked_until && strtotime($attempts_row->locked_until) > time()):
                $is_locked = true;
                $rem = strtotime($attempts_row->locked_until) - time();
                $h = floor($rem / 3600);
                $m = floor(($rem % 3600) / 60);
            ?>
                <div class="alert-box alert-lock">
                    <i class="fas fa-lock"></i>
                    <span>Akun dikunci. Coba lagi setelah <strong><?= $h ?> jam <?= $m ?> menit</strong>.</span>
                </div>
            <?php endif; ?>

            <div class="info-box">
                <div class="info-row">
                    <i class="fas fa-envelope"></i>
                    <span><strong>Email:</strong> <?= htmlspecialchars($email) ?></span>
                </div>
                <div class="info-row">
                    <i class="fas fa-circle-question"></i>
                    <span><strong>Pertanyaan:</strong> <?= htmlspecialchars($question) ?></span>
                </div>
            </div>

            <form action="<?= base_url('auth/check_security_answer') ?>" method="post">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                       value="<?= $this->security->get_csrf_hash(); ?>">

                <div class="field">
                    <label for="sec_answer">Jawaban Anda</label>
                    <div class="input-wrap">
                        <i class="fas fa-key input-icon"></i>
                        <input type="text" id="sec_answer" name="security_answer" class="form-input"
                               placeholder="Ketik jawaban di sini" required autocomplete="off"
                               <?php if($is_locked) echo 'disabled'; ?>>
                    </div>
                    <div class="hint">
                        <i class="fas fa-circle-info"></i>
                        Jawaban tidak case-sensitive (huruf besar/kecil diabaikan)
                    </div>
                </div>

                <button type="submit" class="btn-submit" <?php if($is_locked) echo 'disabled'; ?>>
                    <i class="fas fa-shield-check"></i> Verifikasi Jawaban
                </button>
            </form>

            <div class="form-footer">
                <a href="<?= base_url('auth/forgot_password') ?>">
                    <i class="fas fa-arrow-left" style="font-size:11px; margin-right:4px Pap;"></i> Kembali ke Lupa Password
                </a>
            </div>
        </div>

    </section>

</div>



</body>
</html>