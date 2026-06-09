<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Chat Admin — SITLAKEB TKA</title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/shared.css') ?>">

    <meta name="csrf-token" content="<?= $this->security->get_csrf_hash() ?>">
    <meta name="csrf-name"  content="<?= $this->security->get_csrf_token_name() ?>">

    <style>
        /* ============================================================
           KUNCI UTAMA: html, body, dan page-wrapper TIDAK boleh scroll.
           Hanya .chat-messages yang overflow-y: auto.
           Ini mencegah "halaman ikut scroll" di semua device.
        ============================================================ */
        html, body {
            height: 100%;
            overflow: hidden; /* ← kunci: halaman tidak scroll */
        }

        /* page-wrapper mengisi viewport penuh, tidak lebih */
        .page-wrapper {
            height: 100%;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* topnav dari shared.css — flex-shrink:0 agar tidak terkompresi */
        .topnav { flex-shrink: 0; }

        /* main mengisi sisa tinggi setelah topnav */
        .page-content {
            flex: 1;
            min-height: 0; /* ← penting agar flex child bisa shrink */
            display: flex;
            flex-direction: column;
            padding: 16px 24px 20px;
            overflow: hidden;
        }

        /* page-header: tetap fix di atas */
        .page-header { flex-shrink: 0; margin-bottom: 14px; }

        /* ── Chat surface: mengisi sisa ruang ─────────────────── */
        .chat-surface {
            flex: 1;
            min-height: 0; /* ← penting */
            display: flex;
            flex-direction: column;
            background: var(--c-surface);
            border: 1px solid var(--c-border);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 2px 16px rgba(0,0,0,0.06);
        }

        /* ── Chat header (fixed di atas) ──────────────────────── */
        .chat-header {
            background: var(--c-primary);
            padding: 13px 18px;
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
            border-radius: 16px 16px 0 0;
        }

        .chat-avatar {
            width: 38px;
            height: 38px;
            background: rgba(255,255,255,0.18);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: #fff;
            flex-shrink: 0;
        }

        .chat-header-info { flex: 1; min-width: 0; }
        .chat-header-info h5 {
            margin: 0;
            font-size: 0.88rem;
            font-weight: 700;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .chat-header-info p {
            margin: 0;
            font-size: 0.68rem;
            color: rgba(255,255,255,0.72);
        }

        .online-badge {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.68rem;
            color: rgba(255,255,255,0.85);
            flex-shrink: 0;
        }

        .online-dot {
            width: 7px;
            height: 7px;
            background: #4ade80;
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0.3; }
        }

        /* ── Area pesan: HANYA INI yang scroll ────────────────── */
        .chat-messages {
            flex: 1;
            min-height: 0; /* ← penting */
            overflow-y: auto;
            overflow-x: hidden;
            padding: 16px 18px;
            background: var(--c-surface-2, #f8fafc);
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* Scrollbar tipis hanya di area pesan */
        .chat-messages::-webkit-scrollbar { width: 3px; }
        .chat-messages::-webkit-scrollbar-thumb {
            background: var(--c-border);
            border-radius: 3px;
        }

        /* ── Bubble ────────────────────────────────────────────── */
        .msg {
            display: flex;
            align-items: flex-end;
            gap: 7px;
            max-width: 68%;
        }

        .msg.out {
            align-self: flex-end;
            flex-direction: row-reverse;
        }

        .msg.in { align-self: flex-start; }

        .msg-ava {
            width: 26px;
            height: 26px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.62rem;
            flex-shrink: 0;
        }

        .msg.in  .msg-ava { background: var(--c-primary-light); color: var(--c-primary); }
        .msg.out .msg-ava { background: var(--c-border); color: var(--c-text-muted); }

        .msg-body { min-width: 0; }

        .msg-bubble {
            padding: 9px 13px;
            border-radius: 14px;
            font-size: 0.84rem;
            line-height: 1.55;
            word-break: break-word;
            border: 1px solid transparent;
        }

        .msg.in .msg-bubble {
            background: var(--c-surface);
            border-color: var(--c-border);
            border-bottom-left-radius: 3px;
            color: var(--c-text);
        }

        .msg.out .msg-bubble {
            background: var(--c-primary-light);
            border-color: var(--c-primary-light);
            border-bottom-right-radius: 3px;
            color: var(--c-text);
        }

        .msg-meta {
            display: flex;
            align-items: center;
            gap: 4px;
            font-size: 0.6rem;
            color: var(--c-text-muted);
            margin-top: 3px;
        }

        .msg.out .msg-meta { justify-content: flex-end; }

        /* ── Date separator ────────────────────────────────────── */
        .date-sep {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.64rem;
            color: var(--c-text-muted);
            flex-shrink: 0;
        }

        .date-sep::before,
        .date-sep::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--c-border);
        }

        /* ── Empty state ────────────────────────────────────────── */
        .chat-empty {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--c-text-muted);
            gap: 8px;
        }

        .chat-empty i { font-size: 1.8rem; opacity: 0.2; }
        .chat-empty p { font-size: 0.78rem; margin: 0; }

        /* ── Typing dots ────────────────────────────────────────── */
        .typing {
            display: none;
            align-self: flex-start;
            align-items: center;
            gap: 4px;
            padding: 9px 13px;
            background: var(--c-surface);
            border: 1px solid var(--c-border);
            border-radius: 14px;
            border-bottom-left-radius: 3px;
            flex-shrink: 0;
        }

        .typing.show { display: flex; }

        .tdot {
            width: 6px;
            height: 6px;
            background: var(--c-text-muted);
            border-radius: 50%;
            animation: tdot 1.2s infinite;
        }

        .tdot:nth-child(2) { animation-delay: 0.2s; }
        .tdot:nth-child(3) { animation-delay: 0.4s; }

        @keyframes tdot {
            0%, 60%, 100% { transform: translateY(0); opacity: 0.35; }
            30%            { transform: translateY(-4px); opacity: 1; }
        }

        /* ── Sending indicator ──────────────────────────────────── */
        .sending-ind {
            display: none;
            align-self: flex-end;
            font-size: 0.64rem;
            color: var(--c-text-muted);
            font-style: italic;
            flex-shrink: 0;
        }

        .sending-ind.show { display: block; }

        /* ── Input area (fixed di bawah) ────────────────────────── */
        .chat-input-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border-top: 1px solid var(--c-border);
            background: var(--c-surface);
            flex-shrink: 0;
            border-radius: 0 0 16px 16px;
            /* Safe area iOS (notch/home bar) */
            padding-bottom: max(10px, env(safe-area-inset-bottom));
        }

        .chat-input {
            flex: 1;
            min-width: 0;
            border: 1px solid var(--c-border);
            border-radius: 40px;
            padding: 9px 16px;
            font-family: var(--font-body);
            font-size: 16px; /* ← cegah iOS zoom */
            color: var(--c-text);
            background: var(--c-surface-2, #f8fafc);
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
            resize: none;
            line-height: 1.4;
        }

        .chat-input:focus {
            border-color: var(--c-primary);
            box-shadow: 0 0 0 3px var(--c-primary-glow);
            background: var(--c-surface);
        }

        .chat-input::placeholder { color: var(--c-text-muted); }
        .chat-input:disabled { opacity: 0.5; cursor: not-allowed; }

        .send-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            background: var(--c-primary);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.85rem;
            cursor: pointer;
            flex-shrink: 0;
            transition: opacity 0.15s, transform 0.1s;
        }

        .send-btn:hover:not(:disabled)  { opacity: 0.88; }
        .send-btn:active:not(:disabled) { transform: scale(0.93); }
        .send-btn:disabled { opacity: 0.35; cursor: not-allowed; }

        /* ── Error toast ─────────────────────────────────────────── */
        .err-toast {
            position: fixed;
            bottom: 80px;
            left: 50%;
            transform: translateX(-50%);
            background: #fff1f2;
            border: 1px solid #fecdd3;
            color: #9f1239;
            padding: 7px 16px;
            border-radius: 20px;
            font-size: 0.76rem;
            font-weight: 500;
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
            z-index: 9999;
            display: none;
            max-width: calc(100vw - 32px);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* ── DESKTOP: chat tidak full-screen, ada padding wajar ── */
        @media (min-width: 769px) {
            .msg { max-width: 68%; }

            /* Restorasi scroll halaman di desktop */
            html, body { overflow: auto; height: auto; }
            .page-wrapper { height: auto; min-height: 100vh; overflow: visible; }
            .page-content { overflow: visible; padding: 16px 28px 24px; }

            /* Chat surface punya max-height tetap di desktop */
            .chat-surface {
                max-height: calc(100vh - 200px);
                /* flex masih berlaku tapi dibatasi */
            }
        }

        /* ── MOBILE: full-screen chat, halaman tidak scroll ─────── */
        @media (max-width: 768px) {
            /* Pastikan html/body terkunci */
            html, body { overflow: hidden !important; height: 100% !important; }

            .page-content { padding: 10px 12px 12px; }
            .page-header  { margin-bottom: 10px; }

            /* Surface mengisi sisa layar — tidak ada scroll halaman */
            .chat-surface {
                border-radius: 12px;
                /* Hitung tepat: viewport - topnav (~52px) - page-header (~60px) - page-content padding */
                max-height: calc(100dvh - 130px);
            }

            .msg { max-width: 84%; }

            .chat-messages { padding: 12px 12px; }
            .chat-input-wrap { padding: 8px 10px; padding-bottom: max(8px, env(safe-area-inset-bottom)); }

            /* Input sedikit lebih kecil */
            .chat-input { padding: 8px 14px; }
        }

        @media (max-width: 400px) {
            .msg { max-width: 90%; }
            .msg-bubble { font-size: 0.82rem; padding: 8px 11px; }
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
            <strong>Chat Admin</strong>
        </div>
    </header>

    <main class="page-content">

        <div class="page-header">
            <div class="page-title">Chat Admin Support</div>
            <div class="page-subtitle">Hubungi petugas Dinas Tenaga Kerja untuk bantuan</div>
        </div>

        <div class="chat-surface">

            <!-- Header -->
            <div class="chat-header">
                <div class="chat-avatar">
                    <i class="fas fa-headset"></i>
                </div>
                <div class="chat-header-info">
                    <h5>Admin Support</h5>
                    <p>Dinas Tenaga Kerja Kota Bekasi</p>
                </div>
                <div class="online-badge">
                    <span class="online-dot"></span> Online
                </div>
            </div>

            <!-- ══════════════════════════════
                 Area pesan — HANYA INI scroll
            ══════════════════════════════ -->
            <div class="chat-messages" id="chatMessages">

                <?php if(empty($messages)): ?>
                <div class="chat-empty" id="chatEmpty">
                    <i class="fas fa-comments"></i>
                    <p>Belum ada pesan. Mulai percakapan!</p>
                </div>
                <?php else: ?>
                <div class="date-sep">Riwayat Percakapan</div>
                <?php foreach($messages as $msg):
                    $isOut = ($msg->from_user_id == $this->session->userdata('user_id'));
                ?>
                <div class="msg <?= $isOut ? 'out' : 'in' ?>">
                    <div class="msg-ava">
                        <i class="fas <?= $isOut ? 'fa-user' : 'fa-user-tie' ?>"></i>
                    </div>
                    <div class="msg-body">
                        <div class="msg-bubble">
                            <?= nl2br(htmlspecialchars($msg->message)) ?>
                        </div>
                        <div class="msg-meta">
                            <?= date('H:i', strtotime($msg->created_at)) ?>
                            <?php if($isOut): ?>
                                <?php if($msg->is_read_admin == 1): ?>
                                    <i class="fas fa-check-double" style="color:var(--c-primary);" title="Dibaca"></i>
                                <?php else: ?>
                                    <i class="fas fa-check" title="Terkirim"></i>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>

                <!-- Typing dots -->
                <div class="typing" id="typingDots">
                    <div class="tdot"></div>
                    <div class="tdot"></div>
                    <div class="tdot"></div>
                </div>

                <!-- Sending indicator -->
                <div class="sending-ind" id="sendingInd">Mengirim…</div>

            </div><!-- /chat-messages -->

            <!-- Input area (tidak scroll bersama pesan) -->
            <div class="chat-input-wrap">
                <input type="text"
                       id="msgInput"
                       class="chat-input"
                       placeholder="Tulis pesan…"
                       autocomplete="off"
                       maxlength="1000"
                       enterkeyhint="send">
                <button id="sendBtn" class="send-btn" title="Kirim" disabled>
                    <i class="fas fa-paper-plane"></i>
                </button>
            </div>

        </div><!-- /chat-surface -->

    </main>

    <?php $this->load->view('footer'); ?>
</div>

<div class="err-toast" id="errToast"></div>

<script>
/* ============================================================
   Chat — vanilla JS
   Kunci arsitektur:
   - Halaman TIDAK scroll (overflow:hidden di html/body mobile)
   - Hanya #chatMessages yang overflow-y:auto
   - scrollToBottom() hanya panggil chatMessages.scrollTop
============================================================ */
(function () {
    var lastId    = <?= !empty($messages) ? end($messages)->id : 0 ?>;
    var partnerId = <?= (int)$partner->id ?>;
    var myId      = <?= (int)$this->session->userdata('user_id') ?>;
    var sending   = false;
    var toastTimer;

    var el = {
        messages : document.getElementById('chatMessages'),
        input    : document.getElementById('msgInput'),
        sendBtn  : document.getElementById('sendBtn'),
        sendingInd: document.getElementById('sendingInd'),
        errToast : document.getElementById('errToast'),
        typing   : document.getElementById('typingDots')
    };

    /* ── CSRF ─────────────────────────────────────────────── */
    function csrf() {
        return {
            name : document.querySelector('meta[name="csrf-name"]').content,
            token: document.querySelector('meta[name="csrf-token"]').content
        };
    }

    function updateCsrf(xhr) {
        var t = xhr.getResponseHeader('X-CSRF-Token');
        if (t) document.querySelector('meta[name="csrf-token"]').content = t;
    }

    /* ── Scroll HANYA area pesan ke bawah ─────────────────── */
    function scrollBottom() {
        el.messages.scrollTop = el.messages.scrollHeight;
    }

    /* ── Encode form body ─────────────────────────────────── */
    function encode(obj) {
        return Object.keys(obj).map(function(k) {
            return encodeURIComponent(k) + '=' + encodeURIComponent(obj[k]);
        }).join('&');
    }

    /* ── Escape HTML ──────────────────────────────────────── */
    function esc(str) {
        return str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    }

    /* ── Error toast ──────────────────────────────────────── */
    function showErr(msg) {
        clearTimeout(toastTimer);
        el.errToast.textContent   = msg;
        el.errToast.style.display = 'block';
        toastTimer = setTimeout(function() {
            el.errToast.style.display = 'none';
        }, 3500);
    }

    /* ── State kirim ──────────────────────────────────────── */
    function setSending(state) {
        sending = state;
        el.sendBtn.disabled  = state || !el.input.value.trim();
        el.input.disabled    = state;
        el.sendingInd.classList.toggle('show', state);
        el.typing.classList.toggle('show', state);
    }

    /* ── Buat elemen bubble ────────────────────────────────── */
    function makeBubble(msg) {
        var isOut = (msg.from_user_id == myId);
        var d     = new Date(msg.created_at.replace(' ','T'));
        var time  = d.toLocaleTimeString('id-ID', {hour:'2-digit', minute:'2-digit'});

        var wrap  = document.createElement('div');
        wrap.className = 'msg ' + (isOut ? 'out' : 'in');

        /* Avatar */
        var ava  = document.createElement('div');
        ava.className = 'msg-ava';
        var ico  = document.createElement('i');
        ico.className = 'fas ' + (isOut ? 'fa-user' : 'fa-user-tie');
        ava.appendChild(ico);

        /* Body */
        var body   = document.createElement('div');
        body.className = 'msg-body';

        var bubble = document.createElement('div');
        bubble.className = 'msg-bubble';
        bubble.innerHTML = esc(msg.message).replace(/\n/g,'<br>');

        var meta = document.createElement('div');
        meta.className = 'msg-meta';
        meta.textContent = time;

        if (isOut) {
            var ick = document.createElement('i');
            if (msg.is_read_admin == 1) {
                ick.className = 'fas fa-check-double';
                ick.style.color = 'var(--c-primary)';
                ick.title = 'Dibaca';
            } else {
                ick.className = 'fas fa-check';
                ick.title = 'Terkirim';
            }
            meta.appendChild(ick);
        }

        body.appendChild(bubble);
        body.appendChild(meta);
        wrap.appendChild(ava);
        wrap.appendChild(body);
        return wrap;
    }

    /* ── Poll pesan baru ───────────────────────────────────── */
    function poll() {
        var c = csrf();
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '<?= base_url("chat/get_new") ?>', true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        xhr.setRequestHeader('X-Requested-With','XMLHttpRequest');
        xhr.onload = function() {
            updateCsrf(xhr);
            if (xhr.status !== 200) return;
            var msgs;
            try { msgs = JSON.parse(xhr.responseText); } catch(e) { return; }
            if (!msgs || !msgs.length) return;

            var empty = document.getElementById('chatEmpty');
            if (empty) empty.remove();

            var ref = document.getElementById('sendingInd');
            msgs.forEach(function(m) {
                el.messages.insertBefore(makeBubble(m), ref);
                if (m.id > lastId) lastId = m.id;
            });
            scrollBottom();
        };
        xhr.send(encode({ last_id: lastId, partner_id: partnerId, [c.name]: c.token }));
    }

    /* ── Kirim pesan ───────────────────────────────────────── */
    function send() {
        var msg = el.input.value.trim();
        if (!msg || sending) return;
        setSending(true);

        var c = csrf();
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '<?= base_url("chat/send") ?>', true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        xhr.setRequestHeader('X-Requested-With','XMLHttpRequest');

        xhr.onload = function() {
            updateCsrf(xhr);
            if (xhr.status === 403) {
                showErr('Sesi keamanan kedaluwarsa. Memuat ulang…');
                setTimeout(function() { location.reload(); }, 2000);
            } else {
                var res;
                try { res = JSON.parse(xhr.responseText); } catch(e) {}
                if (res && res.status === 'success') {
                    el.input.value = '';
                    poll();
                } else {
                    showErr(res && res.message ? res.message : 'Gagal mengirim pesan.');
                }
            }
            setSending(false);
            el.input.focus();
        };

        xhr.onerror = function() {
            showErr('Tidak ada koneksi internet.');
            setSending(false);
        };

        xhr.send(encode({ to: partnerId, message: msg, [c.name]: c.token }));
    }

    /* ── Events ────────────────────────────────────────────── */
    el.sendBtn.addEventListener('click', send);

    el.input.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); send(); }
    });

    el.input.addEventListener('input', function() {
        el.sendBtn.disabled = !this.value.trim();
    });

    /* ── Saat keyboard mobile muncul, scroll ke bawah ────── */
    if (window.visualViewport) {
        window.visualViewport.addEventListener('resize', function() {
            scrollBottom();
        });
    }

    /* ── Init ──────────────────────────────────────────────── */
    scrollBottom();
    setInterval(poll, 2000);

})();
</script>
</body>
</html>