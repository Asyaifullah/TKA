<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - SITLAKEB TKA</title>

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

        .otp-page{
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

        .otp-page::before{
            content:"";
            position:absolute;
            inset:0;
            background:
                radial-gradient(circle at 14% 10%, rgba(8,116,86,.05), transparent 30%),
                radial-gradient(circle at 88% 88%, rgba(8,116,86,.08), transparent 32%);
            pointer-events:none;
        }

        .otp-page::after{
            content:"";
            position:absolute;
            inset:0;
            background:rgba(255,255,255,.20);
            pointer-events:none;
        }

        .otp-card{
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

        .otp-icon{
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

        .otp-icon i{
            line-height:1;
            transform:translateY(2px);
        }

        .otp-title{
            margin-bottom:30px;
        }

        .otp-title h2{
            font-size:30px;
            font-weight:800;
            color:#0f172a;
            margin-bottom:10px;
            letter-spacing:-.5px;
        }

        .otp-title p{
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

        .alert-info{
            background:#eff6ff;
            border:1px solid #bfdbfe;
            color:#1e40af;
        }

        .otp-group{
            display:flex;
            align-items:center;
            justify-content:center;
            gap:12px;
            margin-bottom:22px;
        }

        .otp-input{
            width:50px;
            height:56px;
            border:1.5px solid #dbe4ee;
            border-radius:12px;
            background:#ffffff;
            font-size:22px;
            font-weight:800;
            text-align:center;
            color:#0f172a;
            font-family:'Inter',sans-serif;
            outline:none;
            transition:.2s ease;
            -moz-appearance:textfield;
        }

        .otp-input::-webkit-outer-spin-button,
        .otp-input::-webkit-inner-spin-button{
            -webkit-appearance:none;
            margin:0;
        }

        .otp-input:focus{
            border-color:#087456;
            box-shadow:0 0 0 4px rgba(8,116,86,.12);
            background:#ffffff;
        }

        .otp-input.filled{
            border-color:#087456;
            background:#eaf5f1;
        }

        #otpHidden{
            display:none;
        }

        .timer-wrap{
            display:flex;
            align-items:center;
            justify-content:center;
            margin-bottom:22px;
        }

        .timer-badge{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:7px;
            padding:7px 15px;
            border-radius:999px;
            font-size:13px;
            font-weight:800;
        }

        .timer-badge.active{
            background:#dcfce7;
            color:#047857;
        }

        .timer-badge.expired{
            background:#ffe4e6;
            color:#be123c;
        }

        .timer-dot{
            width:7px;
            height:7px;
            border-radius:50%;
            background:#10b981;
            animation:blink 1s infinite;
        }

        .timer-dot.stopped{
            background:#f43f5e;
            animation:none;
        }

        @keyframes blink{
            0%,100%{ opacity:1; }
            50%{ opacity:.35; }
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

        .resend-wrap{
            text-align:center;
            font-size:13px;
            color:#64748b;
            margin-bottom:12px;
        }

        .resend-wrap a{
            color:#087456;
            text-decoration:none;
            font-weight:800;
        }

        .resend-wrap a:hover{
            text-decoration:underline;
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
            .otp-card{
                max-width:100%;
                padding:38px 24px 34px;
                border-radius:24px;
            }

            .otp-title h2{
                font-size:26px;
            }

            .otp-group{
                gap:8px;
            }

            .otp-input{
                width:42px;
                height:50px;
                font-size:20px;
            }
        }

        @media(max-width:390px){
            .otp-input{
                width:38px;
                height:46px;
                font-size:18px;
            }

            .otp-group{
                gap:6px;
            }
        }
    </style>
</head>

<body>

<div class="otp-page">
    <div class="otp-card">

        <div class="otp-icon">
            <i class="fas fa-envelope"></i>
        </div>

        <div class="otp-title">
            <h2>Verifikasi OTP</h2>
            <p>
                Masukkan kode OTP yang telah<br>
                dikirim ke email Anda
            </p>
        </div>

        <?php if($this->session->flashdata('error')): ?>
            <div class="alert-box alert-err">
                <i class="fas fa-exclamation-circle"></i>
                <?= $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if($this->session->flashdata('success')): ?>
            <div class="alert-box alert-info">
                <i class="fas fa-circle-info"></i>
                <?= $this->session->flashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if($this->session->flashdata('info')): ?>
            <div class="alert-box alert-info">
                <i class="fas fa-circle-info"></i>
                <?= $this->session->flashdata('info') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('auth/verify_otp') ?>" method="post" id="otpForm">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                   value="<?= $this->security->get_csrf_hash(); ?>">

            <input type="hidden" name="otp" id="otpHidden">

            <div class="otp-group">
                <input type="number" class="otp-input" maxlength="1" min="0" max="9" data-idx="0" inputmode="numeric">
                <input type="number" class="otp-input" maxlength="1" min="0" max="9" data-idx="1" inputmode="numeric">
                <input type="number" class="otp-input" maxlength="1" min="0" max="9" data-idx="2" inputmode="numeric">
                <input type="number" class="otp-input" maxlength="1" min="0" max="9" data-idx="3" inputmode="numeric">
                <input type="number" class="otp-input" maxlength="1" min="0" max="9" data-idx="4" inputmode="numeric">
                <input type="number" class="otp-input" maxlength="1" min="0" max="9" data-idx="5" inputmode="numeric">
            </div>

            <div class="timer-wrap">
                <div class="timer-badge active" id="timerBadge">
                    <div class="timer-dot" id="timerDot"></div>
                    <span id="timerText">Memuat...</span>
                </div>
            </div>

            <button type="submit" class="btn-submit" id="submitBtn">
                <i class="fas fa-check" style="font-size:12px; margin-right:7px;"></i>
                Verifikasi Kode
            </button>
        </form>

        <div class="resend-wrap">
            Tidak menerima kode?
            <span id="resendCounter"></span>
            <a href="<?= base_url('auth/resend_otp') ?>" id="resendLink" style="display:none;">
                Kirim ulang
            </a>
        </div>

        <div class="back-link">
            <a href="<?= base_url('auth/register') ?>">
                <i class="fas fa-arrow-left" style="font-size:10px; margin-right:3px;"></i>
                Kembali
            </a>
        </div>

    </div>
</div>

<script>
var inputs = document.querySelectorAll('.otp-input');
var hidden = document.getElementById('otpHidden');
var submitBtn = document.getElementById('submitBtn');

inputs.forEach(function(inp, i){
    inp.addEventListener('input', function(){
        var val = this.value.replace(/[^0-9]/g, '');
        this.value = val ? val.slice(-1) : '';

        if(this.value){
            this.classList.add('filled');

            if(i < inputs.length - 1){
                inputs[i + 1].focus();
            }
        }else{
            this.classList.remove('filled');
        }

        syncOtp();
    });

    inp.addEventListener('keydown', function(e){
        if(e.key === 'Backspace' && !this.value && i > 0){
            inputs[i - 1].focus();
            inputs[i - 1].value = '';
            inputs[i - 1].classList.remove('filled');
            syncOtp();
        }
    });

    inp.addEventListener('paste', function(e){
        e.preventDefault();

        var paste = (e.clipboardData || window.clipboardData)
            .getData('text')
            .replace(/[^0-9]/g, '');

        paste.split('').slice(0, 6).forEach(function(ch, j){
            if(inputs[j]){
                inputs[j].value = ch;
                inputs[j].classList.add('filled');
            }
        });

        if(inputs[Math.min(paste.length, 5)]){
            inputs[Math.min(paste.length, 5)].focus();
        }

        syncOtp();
    });
});

function syncOtp(){
    var val = Array.from(inputs).map(function(i){
        return i.value;
    }).join('');

    hidden.value = val;
    submitBtn.disabled = val.length < 6;
}

syncOtp();

var remaining = <?= isset($remaining_seconds) ? (int)$remaining_seconds : 0 ?>;
var timerText = document.getElementById('timerText');
var timerBadge = document.getElementById('timerBadge');
var timerDot = document.getElementById('timerDot');
var resendCounter = document.getElementById('resendCounter');
var resendLink = document.getElementById('resendLink');

function updateTimer(){
    if(remaining <= 0){
        timerBadge.className = 'timer-badge expired';
        timerDot.className = 'timer-dot stopped';
        timerText.textContent = 'Kode sudah kadaluarsa';

        resendCounter.style.display = 'none';
        resendLink.style.display = 'inline';

        return;
    }

    var m = Math.floor(remaining / 60);
    var s = remaining % 60;

    timerText.textContent = 'Berlaku: ' + m + ':' + String(s).padStart(2, '0');
    resendCounter.innerHTML = '(<b>' + m + ':' + String(s).padStart(2,'0') + '</b>)';

    remaining--;

    setTimeout(updateTimer, 1000);
}

updateTimer();
</script>

</body>
</html>