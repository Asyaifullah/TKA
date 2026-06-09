<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya — SITLAKEB TKA</title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/shared.css') ?>">

    <style>
        /* ── Avatar ───────────────────────────────────────────── */
        .profile-avatar {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            background: var(--c-primary-light);
            color: var(--c-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            flex-shrink: 0;
        }

        .profile-name {
            font-size: 1rem;
            font-weight: 700;
            color: var(--c-text);
            line-height: 1.3;
        }

        .profile-email {
            font-size: 0.8rem;
            color: var(--c-text-muted);
            margin-top: 2px;
        }

        /* ── Field label ──────────────────────────────────────── */
        .f-label {
            display: block;
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--c-text-muted);
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin-bottom: 5px;
        }

        .f-hint {
            font-weight: 400;
            text-transform: none;
            letter-spacing: 0;
            font-size: 0.7rem;
        }

        /* ── Input ────────────────────────────────────────────── */
        .f-input {
            width: 100%;
            border: 1px solid var(--c-border);
            border-radius: var(--r-md);
            padding: 9px 12px;
            font-family: var(--font-body);
            font-size: 0.875rem;
            color: var(--c-text);
            background: var(--c-surface);
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
            -webkit-appearance: none;
        }

        .f-input:focus {
            border-color: var(--c-primary);
            box-shadow: 0 0 0 3px var(--c-primary-glow);
        }

        textarea.f-input {
            resize: vertical;
            line-height: 1.6;
            min-height: 80px;
        }

        /* ── Password field ───────────────────────────────────── */
        .pw-wrap {
            position: relative;
        }

        .pw-wrap .f-input {
            padding-right: 42px;
        }

        .pw-eye {
            position: absolute;
            right: 0;
            top: 0;
            height: 100%;
            width: 38px;
            border: none;
            background: transparent;
            color: var(--c-text-muted);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.82rem;
            transition: color 0.15s;
        }

        .pw-eye:hover { color: var(--c-text); }

        /* ── Strength bar ─────────────────────────────────────── */
        .pw-strength { display: none; margin-top: 5px; }

        .pw-strength-bar {
            height: 3px;
            border-radius: 3px;
            background: var(--c-border);
            overflow: hidden;
            margin-bottom: 3px;
        }

        .pw-strength-fill {
            height: 100%;
            border-radius: 3px;
            width: 0%;
            transition: width 0.25s, background 0.25s;
        }

        .pw-strength-label { font-size: 0.7rem; color: var(--c-text-muted); }

        /* ── Tombol simpan ────────────────────────────────────── */
        .btn-save {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 0 18px;
            height: 38px;
            border-radius: var(--r-md);
            border: none;
            background: var(--c-primary);
            color: #fff;
            font-family: var(--font-body);
            font-size: 0.84rem;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.15s, transform 0.1s;
        }

        .btn-save:hover  { opacity: 0.88; }
        .btn-save:active { transform: scale(0.98); }

        /* ── Alert ────────────────────────────────────────────── */
        .alert-custom {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            padding: 11px 14px;
            border-radius: var(--r-md);
            font-size: 0.84rem;
            margin-bottom: 16px;
            line-height: 1.5;
        }

        .alert-success-c { background:#f0fdf4; border:1px solid #a7f3d0; color:#065f46; }
        .alert-danger-c  { background:#fef2f2; border:1px solid #fecaca; color:#991b1b; }

        /* ── Grid layout utama ────────────────────────────────── */
        .profil-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            align-items: start;
        }

        /* ── Field row: 2 kolom sejajar ───────────────────────── */
        .field-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .field-group { margin-bottom: 14px; }
        .field-group:last-of-type { margin-bottom: 0; }

        /* ── Responsive ───────────────────────────────────────── */
        @media (max-width: 900px) {
            .profil-grid { grid-template-columns: 1fr; gap: 14px; }
        }

        @media (max-width: 576px) {
            .page-content { padding: 14px 12px; }
            .f-input      { font-size: 16px; } /* cegah iOS zoom */
            .btn-save     { width: 100%; justify-content: center; }
            .field-row    { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<?php $this->load->view('user/sidebar'); ?>

<div class="page-wrapper">

    <header class="topnav">
        <div class="topnav-breadcrumb">
            <a href="<?= base_url('dashboard') ?>" style="color:var(--c-text-muted);text-decoration:none;">
                <i class="fas fa-home"></i>
            </a>
            <i class="fas fa-chevron-right" style="font-size:8px;"></i>
            <strong>Profil Saya</strong>
        </div>
    </header>

    <main class="page-content">

        <div class="page-header">
            <div class="page-title">Profil Saya</div>
            <div class="page-subtitle">Kelola informasi akun dan keamanan</div>
        </div>

        <!-- Flash Messages -->
        <?php if($this->session->flashdata('success')): ?>
        <div class="alert-custom alert-success-c">
            <i class="fas fa-circle-check" style="margin-top:1px;flex-shrink:0;"></i>
            <span><?= $this->session->flashdata('success') ?></span>
        </div>
        <?php endif; ?>
        <?php if($this->session->flashdata('error')): ?>
        <div class="alert-custom alert-danger-c">
            <i class="fas fa-circle-exclamation" style="margin-top:1px;flex-shrink:0;"></i>
            <span><?= $this->session->flashdata('error') ?></span>
        </div>
        <?php endif; ?>

        <div class="profil-grid">

            <!-- ══════════════════════════════════════════════════
                 KARTU KIRI: Avatar + Edit Profil (jadi satu)
            ══════════════════════════════════════════════════ -->
            <div class="surface" style="overflow:hidden;">

                <div class="surface-header">
                    <div class="surface-title">
                        <i class="fas fa-user-circle"></i> Informasi Profile
                    </div>
                </div>

                <div style="padding:20px 22px;">

                    <!-- Avatar + nama (diperbarui realtime saat mengetik) -->
                    <div style="display:flex;align-items:center;gap:14px;padding-bottom:18px;margin-bottom:18px;border-bottom:1px solid var(--c-border);">
                        <div class="profile-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <div class="profile-name" id="display-nama">
                                <?= htmlspecialchars($user->nama) ?>
                            </div>
                            <div class="profile-email">
                                <?= htmlspecialchars($user->email) ?>
                            </div>
                        </div>
                    </div>

                    <!-- Form edit profil langsung di bawah avatar -->
                    <form action="<?= base_url('user/update_profile') ?>" method="post" id="formEditProfil">
                        <input type="hidden"
                               name="<?= $this->security->get_csrf_token_name(); ?>"
                               value="<?= $this->security->get_csrf_hash(); ?>">

                        <!-- Nama PIC + Nomor HP dalam satu baris -->
                        <div class="field-row">
                            <div class="field-group">
                                <label class="f-label" for="nama">Nama PIC</label>
                                <input type="text" name="nama" id="nama" class="f-input"
                                       value="<?= htmlspecialchars($user->nama) ?>"
                                       placeholder="Nama penanggung jawab"
                                       required
                                       oninput="document.getElementById('display-nama').textContent = this.value || '—'">
                            </div>
                            <div class="field-group">
                                <label class="f-label" for="no_hp">Nomor HP</label>
                                <input type="tel" name="no_hp" id="no_hp" class="f-input"
                                       value="<?= htmlspecialchars($user->no_hp ?? '') ?>"
                                       placeholder="08xxxxxxxxxx">
                            </div>
                        </div>

                        <!-- Nama perusahaan -->
                        <div class="field-group">
                            <label class="f-label" for="perusahaan">Nama Perusahaan</label>
                            <input type="text" name="perusahaan" id="perusahaan" class="f-input"
                                   value="<?= htmlspecialchars($user->perusahaan) ?>"
                                   placeholder="PT. / CV. ..."
                                   required>
                        </div>

                        <!-- Alamat -->
                        <div class="field-group" style="margin-bottom:18px;">
                            <label class="f-label" for="alamat">Alamat Perusahaan</label>
                            <textarea name="alamat" id="alamat" class="f-input"
                                      rows="3"
                                      placeholder="Alamat lengkap perusahaan"><?= htmlspecialchars($user->alamat ?? '') ?></textarea>
                        </div>

                        <button type="submit" class="btn-save">
                            <i class="fas fa-floppy-disk"></i> Simpan Perubahan
                        </button>

                    </form>
                </div>
            </div><!-- /kartu profil -->

            <!-- ══════════════════════════════════════════════════
                 KARTU KANAN: Ganti Password
            ══════════════════════════════════════════════════ -->
            <div class="surface" style="overflow:hidden;">

                <div class="surface-header">
                    <div class="surface-title">
                        <i class="fas fa-key"></i> Ganti Password
                    </div>
                </div>

                <div style="padding:20px 22px;">

                    <!-- Tips keamanan ringkas -->
                    <div style="display:flex;gap:9px;align-items:flex-start;padding:10px 12px;background:var(--c-surface-2);border-radius:var(--r-md);margin-bottom:18px;">
                        <i class="fas fa-shield-halved" style="color:var(--c-primary);font-size:0.85rem;margin-top:2px;flex-shrink:0;"></i>
                        <p style="font-size:0.76rem;color:var(--c-text-muted);margin:0;line-height:1.6;">
                            Gunakan kombinasi huruf besar, angka, dan simbol. Minimal <strong>8 karakter</strong>.
                        </p>
                    </div>

                    <form action="<?= base_url('user/change_password') ?>" method="post" id="formGantiPw">
                        <input type="hidden"
                               name="<?= $this->security->get_csrf_token_name(); ?>"
                               value="<?= $this->security->get_csrf_hash(); ?>">

                        <!-- Password saat ini -->
                        <div class="field-group">
                            <label class="f-label" for="current_password">Password Saat Ini</label>
                            <div class="pw-wrap">
                                <input type="password" name="current_password" id="current_password"
                                       class="f-input"
                                       placeholder="••••••••"
                                       required autocomplete="current-password">
                                <button type="button" class="pw-eye" data-target="current_password" aria-label="Tampilkan password">
                                    <i class="far fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Password baru -->
                        <div class="field-group">
                            <label class="f-label" for="new_password">
                                Password Baru
                                <span class="f-hint">(min. 8 karakter)</span>
                            </label>
                            <div class="pw-wrap">
                                <input type="password" name="new_password" id="new_password"
                                       class="f-input"
                                       placeholder="••••••••"
                                       required autocomplete="new-password"
                                       oninput="checkStrength(this.value)">
                                <button type="button" class="pw-eye" data-target="new_password" aria-label="Tampilkan password">
                                    <i class="far fa-eye"></i>
                                </button>
                            </div>
                            <div class="pw-strength" id="pw-strength">
                                <div class="pw-strength-bar">
                                    <div class="pw-strength-fill" id="pw-strength-fill"></div>
                                </div>
                                <span class="pw-strength-label" id="pw-strength-label"></span>
                            </div>
                        </div>

                        <!-- Konfirmasi password -->
                        <div class="field-group" style="margin-bottom:18px;">
                            <label class="f-label" for="confirm_password">Konfirmasi Password Baru</label>
                            <div class="pw-wrap">
                                <input type="password" name="confirm_password" id="confirm_password"
                                       class="f-input"
                                       placeholder="••••••••"
                                       required autocomplete="new-password"
                                       oninput="checkMatch()">
                                <button type="button" class="pw-eye" data-target="confirm_password" aria-label="Tampilkan password">
                                    <i class="far fa-eye"></i>
                                </button>
                            </div>
                            <div id="pw-match-msg" style="font-size:0.7rem;margin-top:4px;display:none;"></div>
                        </div>

                        <button type="submit" class="btn-save">
                            <i class="fas fa-floppy-disk"></i> Update Password
                        </button>

                    </form>
                </div>
            </div><!-- /kartu password -->

        </div><!-- /profil-grid -->

    </main>
</div>

<?php $this->load->view('footer'); ?>

<script>
/* ── Toggle show/hide password ───────────────────────────── */
document.querySelectorAll('.pw-eye').forEach(function(btn) {
    btn.addEventListener('click', function() {
        var el   = document.getElementById(this.dataset.target);
        var icon = this.querySelector('i');
        if (el.type === 'password') {
            el.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            el.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    });
});

/* ── Password strength meter ─────────────────────────────── */
function checkStrength(val) {
    var wrap  = document.getElementById('pw-strength');
    var fill  = document.getElementById('pw-strength-fill');
    var label = document.getElementById('pw-strength-label');

    if (!val) { wrap.style.display = 'none'; return; }
    wrap.style.display = 'block';

    var score = 0;
    if (val.length >= 8)           score++;
    if (/[A-Z]/.test(val))        score++;
    if (/[0-9]/.test(val))        score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    var levels = [
        { pct:'25%',  color:'#ef4444', text:'Lemah'  },
        { pct:'50%',  color:'#f97316', text:'Cukup'  },
        { pct:'75%',  color:'#eab308', text:'Sedang' },
        { pct:'100%', color:'#22c55e', text:'Kuat'   }
    ];

    var lvl = levels[score - 1] || levels[0];
    fill.style.width      = lvl.pct;
    fill.style.background = lvl.color;
    label.textContent     = 'Kekuatan: ' + lvl.text;
    label.style.color     = lvl.color;
}

/* ── Cek kecocokan password ──────────────────────────────── */
function checkMatch() {
    var pw1 = document.getElementById('new_password').value;
    var pw2 = document.getElementById('confirm_password').value;
    var msg = document.getElementById('pw-match-msg');

    if (!pw2) { msg.style.display = 'none'; return; }
    msg.style.display = 'block';

    if (pw1 === pw2) {
        msg.textContent = '✓ Password cocok';
        msg.style.color = '#16a34a';
    } else {
        msg.textContent = '✗ Password tidak cocok';
        msg.style.color = '#dc2626';
    }
}

/* ── Validasi submit ganti password ──────────────────────── */
document.getElementById('formGantiPw').addEventListener('submit', function(e) {
    var pw1 = document.getElementById('new_password').value;
    var pw2 = document.getElementById('confirm_password').value;
    if (pw1.length < 8) {
        e.preventDefault();
        alert('Password baru minimal 8 karakter.');
        return;
    }
    if (pw1 !== pw2) {
        e.preventDefault();
        alert('Konfirmasi password tidak cocok.');
    }
});
</script>
</body>
</html>