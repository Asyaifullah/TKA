<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
<title>Daftar Perusahaan - SITLAKEB TKA</title>

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
.register-page{
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

.register-page::before{
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
   4. RIGHT SECTION (WHITE REGISTER CARD)
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
    max-width: 520px;
}

.register-card{
    width:100%;
    max-height:85vh;
    overflow-y:auto;

    background:#ffffff;
    border:1px solid #ffffff;
    border-radius:32px;

    padding:40px 35px;
    box-shadow:0 30px 60px rgba(15,23,42,.12);
}

.register-card::-webkit-scrollbar{
    width:6px;
}

.register-card::-webkit-scrollbar-track{
    background:transparent;
}

.register-card::-webkit-scrollbar-thumb{
    background:rgba(8,116,86,.25);
    border-radius:999px;
}

.form-title{
    margin-bottom:20px;
}

.form-title h2{
    color:#0f172a;
    font-size:26px;
    font-weight:800;
    margin-bottom:6px;
}

.form-title p{
    color:#64748b;
    font-size:14px;
}

.alert-box{
    display:flex;
    align-items:center;
    gap:10px;
    border-radius:12px;
    padding:12px 14px;
    margin-bottom:18px;
    font-size:13px;
}

.alert-box i{
    font-size:13px;
    flex-shrink:0;
}

.alert-err{
    background:#fff1f2;
    border:1px solid #fecdd3;
    color:#9f1239;
}

.alert-success{
    background:#ecfdf5;
    border:1px solid #a7f3d0;
    color:#065f46;
}

.section-title{
    font-size:11px;
    font-weight:800;
    text-transform:uppercase;
    letter-spacing:.08em;
    color:#64748b;
    margin:24px 0 12px;
    display:flex;
    align-items:center;
    gap:8px;
}

.section-title::after{
    content:"";
    flex:1;
    height:1px;
    background:rgba(148,163,184,.25);
}

.section-title:first-of-type{
    margin-top:0;
}

.field{
    margin-bottom:16px;
}

.field label{
    display:block;
    font-size:13px;
    font-weight:700;
    color:#1e293b;
    margin-bottom:7px;
}

.field label .req{
    color:#f43f5e;
    margin-left:2px;
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
    pointer-events:none;
}

.input-icon.top{
    top:14px;
    transform:none;
}

.form-input{
    width:100%;
    height:44px;
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

textarea.form-input{
    height:auto;
    min-height:78px;
    resize:vertical;
    padding-top:12px;
}

select.form-input{
    cursor:pointer;
}

.toggle-btn{
    position:absolute;
    right:14px;
    top:50%;
    transform:translateY(-50%);
    border:none;
    background:transparent;
    color:#94a3b8;
    cursor:pointer;
    padding:5px;
}

.hint{
    font-size:12px;
    color:#64748b;
    margin-top:5px;
    display:flex;
    align-items:flex-start;
    gap:5px;
}

.hint i{
    font-size:11px;
    margin-top:2px;
    flex-shrink:0;
}

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
    margin-top:10px;
    box-shadow:0 10px 20px rgba(8,116,86,.2);
    transition:.2s ease;
}

.btn-submit:hover{
    transform:translateY(-1px);
    box-shadow:0 14px 26px rgba(8,116,86,.28);
}

.form-footer{
    text-align:center;
    margin-top:20px;
    font-size:13px;
    color:#64748b;
}

.form-footer a{
    color:#087456;
    text-decoration:none;
    font-weight:800;
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
    .register-page{
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
    .register-page{
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
        max-width:520px;
        flex: none;
    }
    .register-card{
        max-height: none; /* Hilangkan scroll area jika di tablet/HP */
    }
}

@media(max-width:600px){
    .register-page {
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
    .register-card{
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

<div class="register-page">

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
        <div class="register-card">

            <div class="form-title">
                <h2>Buat Akun Perusahaan</h2>
                <p>Isi formulir di bawah untuk mendaftar</p>
            </div>

            <?php if($this->session->flashdata('error')): ?>
                <div class="alert-box alert-err">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= $this->session->flashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if($this->session->flashdata('success')): ?>
                <div class="alert-box alert-success">
                    <i class="fas fa-check-circle"></i>
                    <?= $this->session->flashdata('success') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('auth/do_register') ?>" method="post">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                       value="<?= $this->security->get_csrf_hash(); ?>">

                <div class="section-title">Data Perusahaan</div>

                <div class="field">
                    <label>Nama Perusahaan <span class="req">*</span></label>
                    <div class="input-wrap">
                        <i class="fas fa-building input-icon"></i>
                        <input type="text" name="perusahaan" class="form-input"
                               placeholder="PT. Contoh Abadi"
                               value="<?= set_value('perusahaan') ?>" required>
                    </div>
                </div>

                <div class="field">
                    <label>Nama PIC (Penanggung Jawab) <span class="req">*</span></label>
                    <div class="input-wrap">
                        <i class="fas fa-user input-icon"></i>
                        <input type="text" name="nama" class="form-input"
                               placeholder="Nama lengkap"
                               value="<?= set_value('nama') ?>" required>
                    </div>
                </div>

                <div class="field">
                    <label>Nomor Handphone <span class="req">*</span></label>
                    <div class="input-wrap">
                        <i class="fas fa-phone input-icon"></i>
                        <input type="tel" name="no_hp" class="form-input"
                               placeholder="081234567890"
                               value="<?= set_value('no_hp') ?>"
                               pattern="[0-9]+"
                               maxlength="13"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                               required>
                    </div>
                    <div class="hint">
                        <i class="fas fa-circle-info"></i>
                        Hanya angka, maksimal 13 digit
                    </div>
                </div>

                <div class="field">
                    <label>Alamat Perusahaan <span class="req">*</span></label>
                    <div class="input-wrap">
                        <i class="fas fa-map-marker-alt input-icon top"></i>
                        <textarea name="alamat" class="form-input"
                                  placeholder="Jalan, Kelurahan, Kecamatan, Kota"
                                  required><?= set_value('alamat') ?></textarea>
                    </div>
                </div>

                <div class="section-title">Akun Login</div>

                <div class="field">
                    <label>Email Perusahaan <span class="req">*</span></label>
                    <div class="input-wrap">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" name="email" class="form-input"
                               placeholder="email@perusahaan.com"
                               value="<?= set_value('email') ?>" required autocomplete="email">
                    </div>
                </div>

                <div class="field">
                    <label>Password <span class="req">*</span></label>
                    <div class="input-wrap">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" name="password" id="password" class="form-input"
                               placeholder="Minimal 8 karakter"
                               required style="padding-right:44px;">
                        <button type="button" class="toggle-btn" onclick="togglePass('password', this)">
                            <i class="far fa-eye"></i>
                        </button>
                    </div>
                    <div class="hint">
                        <i class="fas fa-circle-info"></i>
                        Wajib minimal 8 karakter. Disarankan menggunakan kombinasi huruf besar, huruf kecil, angka, dan simbol (@$!%*?&) agar lebih aman.
                    </div>
                </div>

                <div class="section-title">Keamanan Akun</div>

                <div class="field">
                    <label>Pertanyaan Keamanan <span class="req">*</span></label>
                    <div class="input-wrap">
                        <i class="fas fa-shield-halved input-icon"></i>
                        <select name="security_question" class="form-input" required>
                            <option value="">— Pilih Pertanyaan —</option>
                            <option value="Siapa nama ibu kandung Anda?">Siapa nama ibu kandung Anda?</option>
                            <option value="Siapa nama hewan peliharaan pertama Anda?">Siapa nama hewan peliharaan pertama Anda?</option>
                            <option value="Apa nama sekolah dasar Anda?">Apa nama sekolah dasar Anda?</option>
                            <option value="Di kota mana Anda lahir?">Di kota mana Anda lahir?</option>
                            <option value="Apa makanan favorit Anda?">Apa makanan favorit Anda?</option>
                        </select>
                    </div>
                </div>

                <div class="field">
                    <label>Jawaban Keamanan <span class="req">*</span></label>
                    <div class="input-wrap">
                        <i class="fas fa-key input-icon"></i>
                        <input type="text" name="security_answer" class="form-input"
                               placeholder="Jawaban pertanyaan di atas" required>
                    </div>
                    <div class="hint">
                        <i class="fas fa-circle-info"></i>
                        Gunakan huruf kecil saat reset password nanti
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="fas fa-user-plus" style="font-size:13px; margin-right:8px;"></i>
                    Daftar Sekarang
                </button>
            </form>

            <div class="form-footer">
                Sudah punya akun? <a href="<?= base_url('auth/login') ?>">Login di sini</a>
            </div>

        </div>

    </section>

</div>

<script>
// Fungsi Show/Hide Password
function togglePass(id, btn){
    const input = document.getElementById(id);
    const icon = btn.querySelector('i');

    if(input.type === 'password'){
        input.type = 'text';
        icon.classList.replace('fa-eye','fa-eye-slash');
    }else{
        input.type = 'password';
        icon.classList.replace('fa-eye-slash','fa-eye');
    }
}

// Fungsi Update Jam & Tanggal Digital Real-time
function updateAccessInfo(){
    const now = new Date();

    const dateOptions = {
        day: '2-digit',
        month: 'long',
        year: 'numeric'
    };

    const dayOptions = {
        weekday: 'long'
    };

    const timeOptions = {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false
    };

    const dateText = now.toLocaleDateString('id-ID', dateOptions);
    const dayText = now.toLocaleDateString('id-ID', dayOptions);
    const timeText = now.toLocaleTimeString('id-ID', timeOptions);

    document.getElementById('current-date').innerHTML = dayText + ', ' + dateText;
    document.getElementById('current-time').innerHTML = timeText + ' WIB';
}

// Eksekusi fungsi waktu
updateAccessInfo();
setInterval(updateAccessInfo, 1000);
</script>

</body>
</html>