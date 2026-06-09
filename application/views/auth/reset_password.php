<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - SITLAKEB TKA</title>

    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:'Inter',sans-serif;
            min-height:100vh;
            overflow:hidden;
            background:#eef5f3;
        }

        .reset-page{
            width:100%;
            height:100vh;
            position:relative;
            overflow:hidden;

            background:
                linear-gradient(
                    to right,
                    rgba(255,255,255,.52) 32%,
                    rgba(192,189,189,.84) 100%
                ),
                url("<?= base_url('assets/images/bg-pemerintahan2.jpg') ?>");

            background-size:cover;
            background-position:center;
            background-repeat:no-repeat;

            display:flex;
            align-items:center;
            justify-content:center;
            padding:24px;
        }

        .reset-page::before{
            content:"";
            position:absolute;
            inset:0;
            background:
                radial-gradient(circle at 14% 10%, rgba(8,116,86,.05), transparent 30%),
                radial-gradient(circle at 88% 88%, rgba(8,116,86,.08), transparent 32%);
            pointer-events:none;
        }

        .reset-page::after{
            content:"";
            position:absolute;
            inset:0;
            background:rgba(255,255,255,.20);
            pointer-events:none;
        }

        .reset-card{
            width:100%;
            max-width:520px;
            position:relative;
            z-index:2;

            background:rgb(251,251,251);
            border:1px solid rgba(255,255,255,.85);
            border-radius:28px;

            padding:48px 42px 42px;

            box-shadow:
                0 28px 70px rgba(15,23,42,.18),
                0 8px 24px rgba(15,23,42,.08);

            text-align:center;
        }

        .reset-icon{
            width:72px;
            height:72px;
            margin:0 auto 22px;

            display:flex;
            align-items:center;
            justify-content:center;

            background:#eaf5f1;
            color:#087456;

            border-radius:50%;
            font-size:30px;

            box-shadow:0 12px 28px rgba(8,116,86,.12);
        }

        .reset-icon i{
            line-height:1;
            transform:translateY(1px);
        }

        .reset-title{
            margin-bottom:30px;
        }

        .reset-title h2{
            font-size:30px;
            font-weight:800;
            color:#0f172a;
            margin-bottom:10px;
            letter-spacing:-.5px;
        }

        .reset-title p{
            font-size:14px;
            line-height:1.6;
            color:#64748b;
        }

        .alert-box{
            display:flex;
            align-items:flex-start;
            gap:10px;

            border-radius:12px;
            padding:12px 14px;
            margin-bottom:20px;

            font-size:13px;
            text-align:left;
        }

        .alert-box i{
            font-size:13px;
            margin-top:2px;
            flex-shrink:0;
        }

        .alert-err{
            background:#fff1f2;
            border:1px solid #fecdd3;
            color:#9f1239;
        }

        .field{
            margin-bottom:20px;
            text-align:left;
        }

        .field label{
            display:block;
            font-size:13px;
            font-weight:700;
            color:#0f172a;
            margin-bottom:8px;
        }

        .input-wrap{
            position:relative;
        }

        .input-icon{
            position:absolute;
            left:16px;
            top:50%;
            transform:translateY(-50%);
            color:#94a3b8;
            font-size:14px;
            pointer-events:none;
        }

        .form-input{
            width:100%;
            height:56px;

            border:1.5px solid #dbe4ee;
            border-radius:12px;

            background:#ffffff;

            padding:0 48px 0 46px;

            font-size:15px;
            font-weight:500;
            color:#0f172a;

            font-family:'Inter',sans-serif;
            outline:none;

            transition:.2s ease;
        }

        .form-input:focus{
            border-color:#087456;
            box-shadow:0 0 0 4px rgba(8,116,86,.12);
            background:#ffffff;
        }

        .form-input::placeholder{
            color:#cbd5e1;
        }

        .toggle-password{
            position:absolute;
            right:15px;
            top:50%;
            transform:translateY(-50%);

            border:none;
            background:none;

            color:#94a3b8;
            font-size:15px;
            cursor:pointer;
        }

        .toggle-password:hover{
            color:#087456;
        }

        .strength-wrap{
            margin-top:10px;
            display:none;
        }

        .strength-bar{
            height:5px;
            border-radius:99px;
            background:#e2e8f0;
            overflow:hidden;
            margin-bottom:6px;
        }

        .strength-fill{
            height:100%;
            width:0;
            border-radius:99px;
            transition:.25s ease;
        }

        .strength-label{
            display:flex;
            justify-content:space-between;
            font-size:11px;
            color:#94a3b8;
            font-weight:600;
        }

        .hint{
            font-size:12px;
            color:#94a3b8;
            margin-top:7px;
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

        .match-hint{
            display:none;
            align-items:center;
            gap:5px;
            font-size:12px;
            margin-top:7px;
            font-weight:600;
        }

        .match-hint.show{
            display:flex;
        }

        .match-hint.ok{
            color:#10b981;
        }

        .match-hint.no{
            color:#f43f5e;
        }

        .btn-submit{
            width:100%;
            height:52px;

            border:none;
            border-radius:12px;

            background:linear-gradient(135deg,#087456,#0f5f49);
            color:white;

            font-size:15px;
            font-weight:800;
            font-family:'Inter',sans-serif;

            cursor:pointer;
            transition:.2s ease;

            box-shadow:0 14px 28px rgba(8,116,86,.22);
            margin-top:4px;
            margin-bottom:18px;
        }

        .btn-submit:hover{
            transform:translateY(-2px);
            box-shadow:0 18px 34px rgba(8,116,86,.30);
        }

        .btn-submit:disabled{
            background:#e2e8f0;
            color:#94a3b8;
            box-shadow:none;
            cursor:not-allowed;
            transform:none;
        }

        .back-link{
            text-align:center;
            font-size:13px;
        }

        .back-link a{
            color:#94a3b8;
            text-decoration:none;
            font-weight:600;
        }

        .back-link a:hover{
            color:#64748b;
            text-decoration:underline;
        }

        @media(max-width:560px){
            body{
                overflow:auto;
            }

            .reset-page{
                height:auto;
                min-height:100vh;
            }

            .reset-card{
                max-width:100%;
                padding:38px 24px 34px;
                border-radius:24px;
            }

            .reset-title h2{
                font-size:26px;
            }

            .form-input{
                height:52px;
                font-size:14px;
            }
        }
    </style>
</head>

<body>

<div class="reset-page">
    <div class="reset-card">

        <div class="reset-icon">
            <i class="fas fa-shield-halved"></i>
        </div>

        <div class="reset-title">
            <h2>Reset Password</h2>
            <p>
                Buat password baru yang kuat<br>
                untuk keamanan akun Anda
            </p>
        </div>

        <?php if($this->session->flashdata('error')): ?>
            <div class="alert-box alert-err">
                <i class="fas fa-exclamation-circle"></i>
                <?= $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('auth/do_reset_password') ?>" method="post" id="resetForm">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                   value="<?= $this->security->get_csrf_hash(); ?>">

            <div class="field">
                <label for="password">Password Baru</label>
                <div class="input-wrap">
                    <i class="fas fa-lock input-icon"></i>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-input"
                        placeholder="Masukkan password baru"
                        required
                        oninput="checkStrength(this.value); checkMatch();">

                    <button type="button" class="toggle-password"
                            onclick="togglePassword('password', this)"
                            aria-label="Tampilkan password">
                        <i class="far fa-eye"></i>
                    </button>
                </div>

                <div class="strength-wrap" id="strengthWrap">
                    <div class="strength-bar">
                        <div class="strength-fill" id="strengthFill"></div>
                    </div>
                    <div class="strength-label">
                        <span id="strengthText">Terlalu lemah</span>
                        <span id="strengthPct"></span>
                    </div>
                </div>

                <div class="hint">
                    <i class="fas fa-circle-info"></i>
                    <span>Min. 8 karakter, huruf besar, huruf kecil, angka, dan simbol (@$!%*?&amp;)</span>
                </div>
            </div>

            <div class="field">
                <label for="confirm_password">Konfirmasi Password Baru</label>
                <div class="input-wrap">
                    <i class="fas fa-lock input-icon"></i>
                    <input
                        type="password"
                        name="confirm_password"
                        id="confirm_password"
                        class="form-input"
                        placeholder="Ulangi password baru"
                        required
                        oninput="checkMatch();">

                    <button type="button" class="toggle-password"
                            onclick="togglePassword('confirm_password', this)"
                            aria-label="Tampilkan konfirmasi password">
                        <i class="far fa-eye"></i>
                    </button>
                </div>

                <div class="match-hint" id="matchHint">
                    <i class="fas fa-circle-check" style="font-size:11px;"></i>
                    <span id="matchText"></span>
                </div>
            </div>

            <button type="submit" class="btn-submit" id="btnSubmit">
                <i class="fas fa-check" style="font-size:12px; margin-right:7px;"></i>
                Reset Password
            </button>
        </form>

        <div class="back-link">
            <a href="<?= base_url('auth/login') ?>">
                <i class="fas fa-arrow-left" style="font-size:10px; margin-right:3px;"></i>
                Kembali
            </a>
        </div>

    </div>
</div>

<script>
function togglePassword(fieldId, btn){
    var input = document.getElementById(fieldId);
    var icon  = btn.querySelector('i');

    if(input.type === 'password'){
        input.type = 'text';
        icon.classList.replace('fa-eye','fa-eye-slash');
    }else{
        input.type = 'password';
        icon.classList.replace('fa-eye-slash','fa-eye');
    }
}

function checkStrength(val){
    var wrap = document.getElementById('strengthWrap');
    var fill = document.getElementById('strengthFill');
    var text = document.getElementById('strengthText');
    var pct  = document.getElementById('strengthPct');

    if(!val){
        wrap.style.display = 'none';
        return;
    }

    wrap.style.display = 'block';

    var score = 0;

    if(val.length >= 8) score++;
    if(/[A-Z]/.test(val)) score++;
    if(/[a-z]/.test(val)) score++;
    if(/[0-9]/.test(val)) score++;
    if(/[@$!%*?&]/.test(val)) score++;

    var levels = [
        {pct:20, color:'#f43f5e', label:'Terlalu lemah'},
        {pct:40, color:'#f97316', label:'Lemah'},
        {pct:60, color:'#eab308', label:'Sedang'},
        {pct:80, color:'#3b82f6', label:'Kuat'},
        {pct:100, color:'#10b981', label:'Sangat kuat'}
    ];

    var lv = levels[Math.max(0, score - 1)];

    fill.style.width = lv.pct + '%';
    fill.style.background = lv.color;

    text.textContent = lv.label;
    text.style.color = lv.color;

    pct.textContent = lv.pct + '%';
}

function checkMatch(){
    var pw = document.getElementById('password').value;
    var cpw = document.getElementById('confirm_password').value;
    var hint = document.getElementById('matchHint');
    var txt = document.getElementById('matchText');
    var btn = document.getElementById('btnSubmit');
    var icon = hint.querySelector('i');

    if(!cpw){
        hint.className = 'match-hint';
        btn.disabled = false;
        return;
    }

    if(pw === cpw){
        hint.className = 'match-hint show ok';
        icon.className = 'fas fa-circle-check';
        txt.textContent = 'Password cocok';
        btn.disabled = false;
    }else{
        hint.className = 'match-hint show no';
        icon.className = 'fas fa-circle-xmark';
        txt.textContent = 'Password tidak cocok';
        btn.disabled = true;
    }
}
</script>

</body>
</html>