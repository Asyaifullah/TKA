<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo OTP - TKA App</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .demo-container { max-width: 550px; width: 100%; }
        .card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 35px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        .card-header {
            background: #1e6f5c;
            color: white;
            padding: 20px 25px;
            text-align: center;
        }
        .card-header h3 { margin: 0; font-weight: 600; }
        .card-body { padding: 30px; }
        .otp-display {
            background: #f8f9fa;
            border: 2px dashed #2c7da0;
            border-radius: 16px;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
        }
        .otp-code {
            font-size: 48px;
            font-weight: 700;
            letter-spacing: 8px;
            color: #1e6f5c;
            font-family: monospace;
        }
        .timer {
            color: #dc3545;
            font-weight: 500;
        }
        .btn-verify {
            background: #2c7da0;
            border: none;
            border-radius: 12px;
            padding: 12px;
            width: 100%;
            font-weight: 600;
        }
        .alert-info {
            background: #e0f2fe;
            border-left: 4px solid #0ea5e9;
        }
    </style>
</head>
<body>
<div class="demo-container">
    <div class="card">
        <div class="card-header">
            <h3>📧 Simulasi Email OTP</h3>
            <p class="mb-0 small">Halaman ini hanya untuk testing - menggantikan pengiriman email</p>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> Berikut adalah kode OTP yang seharusnya dikirim ke email:
                <strong><?= htmlspecialchars($email) ?></strong>
            </div>
            
            <div class="otp-display">
                <p style="margin-bottom: 10px;">🔐 Kode Verifikasi Anda</p>
                <div class="otp-code"><?= $otp_code ?></div>
                <p class="mt-3 mb-0 small">Kode berlaku selama <span class="timer" id="timerDisplay"><?= $remaining_seconds ?></span> detik</p>
            </div>
            
            <div class="text-center mb-3">
                <a href="<?= base_url('auth/otp_form') ?>" class="btn btn-verify btn-primary">
                    ➡️ Lanjutkan ke Halaman Verifikasi OTP
                </a>
            </div>
            <div class="text-center">
                <small class="text-muted">Atau salin kode di atas dan masukkan ke form verifikasi.</small>
            </div>
        </div>
    </div>
</div>
<script>
let remaining = <?= (int)$remaining_seconds ?>;
const timerDisplay = document.getElementById('timerDisplay');
function updateTimer() {
    if (remaining <= 0) {
        timerDisplay.innerHTML = '0 - KODE KADALUARSA';
        timerDisplay.style.color = 'red';
        return;
    }
    timerDisplay.innerHTML = remaining;
    remaining--;
    setTimeout(updateTimer, 1000);
}
updateTimer();
</script>
</body>
</html>