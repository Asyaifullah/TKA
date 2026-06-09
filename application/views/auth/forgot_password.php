<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - SITLAKEB TKA</title>

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

        .forgot-page{
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

        .forgot-page::before{
            content:"";
            position:absolute;
            inset:0;
            background:
                radial-gradient(circle at 14% 10%, rgba(8,116,86,.05), transparent 30%),
                radial-gradient(circle at 88% 88%, rgba(8,116,86,.08), transparent 32%);
            pointer-events:none;
        }

        .forgot-page::after{
            content:"";
            position:absolute;
            inset:0;
            background:rgba(255,255,255,.20);
            pointer-events:none;
        }

        .forgot-card{
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

        .forgot-icon{
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

        .forgot-icon i{
            line-height:1;
            transform:translateY(1px);
        }

        .forgot-title{
            margin-bottom:30px;
        }

        .forgot-title h2{
            font-size:30px;
            font-weight:800;
            color:#0f172a;
            margin-bottom:10px;
            letter-spacing:-.5px;
        }

        .forgot-title p{
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

        .alert-success{
            background:#ecfdf5;
            border:1px solid #a7f3d0;
            color:#065f46;
        }

        .field{
            margin-bottom:22px;
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

            padding:0 16px 0 46px;

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

        .btn-submit:active{
            transform:translateY(0);
        }

        .back-link{
            text-align:center;
            font-size:13px;
        }

        .back-link a{
            color:#087456;
            text-decoration:none;
            font-weight:700;
        }

        .back-link a:hover{
            text-decoration:underline;
        }

        @media(max-width:560px){
            .forgot-card{
                max-width:100%;
                padding:38px 24px 34px;
                border-radius:24px;
            }

            .forgot-title h2{
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

<div class="forgot-page">
    <div class="forgot-card">

        <div class="forgot-icon">
            <i class="fas fa-key"></i>
        </div>

        <div class="forgot-title">
            <h2>Lupa Password?</h2>
            <p>
                Masukkan email perusahaan yang terdaftar<br>
                untuk memulai proses reset password
            </p>
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

        <form action="<?= base_url('auth/verify_security') ?>" method="post">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                   value="<?= $this->security->get_csrf_hash(); ?>">

            <div class="field">
                <label for="email">Email Perusahaan</label>
                <div class="input-wrap">
                    <i class="fas fa-envelope input-icon"></i>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-input"
                        placeholder="contoh@perusahaan.com"
                        required
                        autocomplete="email">
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-paper-plane" style="font-size:12px; margin-right:7px;"></i>
                Verifikasi Email
            </button>
        </form>

        <div class="back-link">
            <a href="<?= base_url('auth/login') ?>">
                <i class="fas fa-arrow-left" style="font-size:10px; margin-right:4px;"></i>
                Kembali ke Login
            </a>
        </div>

    </div>
</div>

</body>
</html>