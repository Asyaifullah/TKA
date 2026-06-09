<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Chat Perusahaan — Admin</title>
    <meta name="csrf-token" content="<?= $this->security->get_csrf_hash() ?>">
    <meta name="csrf-name"  content="<?= $this->security->get_csrf_token_name() ?>">
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/shared.css') ?>">
    <style>
    :root {
        --green:       #1e6f5c;
        --green-light: #e6f4f1;
        --green-mid:   #cde8e0;
        --ink:         #1e293b;
        --ink-2:       #3d4f60;
        --ink-3:       #64748b;
        --ink-4:       #94a3b8;
        --border:      #e9ecef;
        --bg:          #f4f6f9;
        --surface:     #ffffff;
        --danger:      #f43f5e;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html, body { height: 100%; overflow: hidden; }
    body { background: var(--bg); font-family: 'DM Sans', sans-serif; color: var(--ink); }

    .page-wrapper { display: flex; flex-direction: column; height: 100dvh; overflow: hidden; }
    .topnav { flex-shrink: 0; }
    .page-content { flex: 1; min-height: 0; overflow: hidden; padding: 16px 20px 20px; }

    /* ── Topnav ── */
    .topnav {
        background: var(--surface); border-bottom: 1px solid var(--border);
        padding: 0 20px; height: 54px;
        display: flex; align-items: center; justify-content: space-between;
        gap: 10px; z-index: 200;
    }
    .topnav-left { display: flex; align-items: center; gap: 12px; }
    .topnav-breadcrumb { display: flex; align-items: center; gap: 8px; font-size: 0.77rem; color: var(--ink-3); font-weight: 500; }
    .topnav-breadcrumb strong { color: var(--ink); }
    .topnav-breadcrumb .sep { font-size: 7px; color: var(--border); }
    .topnav-meta { font-size: 0.71rem; color: var(--ink-3); background: #f1f5f9; padding: 4px 10px; border-radius: 8px; border: 1px solid var(--border); white-space: nowrap; }

    /* ── Hamburger — SELALU ADA DI DOM, disembunyi di desktop via CSS ── */
    .btn-hamburger {
        display: none; /* desktop: tersembunyi */
        width: 34px; height: 34px; border-radius: 9px;
        border: 1px solid var(--border); background: var(--surface);
        align-items: center; justify-content: center;
        color: var(--ink-3); font-size: 15px;
        cursor: pointer; flex-shrink: 0;
        transition: background .15s, color .15s;
    }
    .btn-hamburger:hover { background: var(--green-light); color: var(--green); }

    /* ── Chat shell ── */
    .chat-shell {
        display: grid; grid-template-columns: 300px 1fr;
        gap: 14px; height: 100%;
    }

    /* ── User list ── */
    .user-list {
        background: var(--surface); border-radius: 16px;
        border: 1px solid var(--border); box-shadow: 0 2px 12px rgba(0,0,0,0.05);
        display: flex; flex-direction: column;
        overflow: hidden; height: 100%;
    }
    .ul-header { padding: 13px 15px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; }
    .ul-header-title { font-size: 0.83rem; font-weight: 700; color: var(--ink); display: flex; align-items: center; gap: 6px; }
    .ul-header-title i { color: var(--green); font-size: 11px; }
    .ul-count { font-size: 0.66rem; font-weight: 700; background: var(--green-light); color: var(--green); padding: 2px 8px; border-radius: 20px; }
    .ul-search-wrap { padding: 9px 12px; border-bottom: 1px solid var(--border); position: relative; flex-shrink: 0; }
    .ul-search-wrap i { position: absolute; left: 22px; top: 50%; transform: translateY(-50%); color: var(--ink-4); font-size: 10px; pointer-events: none; }
    .ul-search { width: 100%; border: 1px solid #e2e8f0; border-radius: 9px; padding: 7px 10px 7px 28px; font-size: 0.78rem; font-family: inherit; background: #f8fafc; outline: none; transition: border-color 0.15s; }
    .ul-search:focus { border-color: var(--green); background: #fff; box-shadow: 0 0 0 3px rgba(30,111,92,0.08); }
    .ul-items { flex: 1; overflow-y: auto; min-height: 0; }
    .ul-items::-webkit-scrollbar { width: 3px; }
    .ul-items::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 3px; }

    .user-item { padding: 11px 14px; border-bottom: 1px solid #f1f5f9; cursor: pointer; display: flex; gap: 10px; align-items: center; transition: background 0.12s; }
    .user-item:last-child { border-bottom: none; }
    .user-item:hover  { background: #f8fafc; }
    .user-item.active { background: var(--green-light); }
    .user-avatar { width: 40px; height: 40px; border-radius: 12px; background: var(--green-light); color: var(--green); display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700; flex-shrink: 0; }
    .user-info { flex: 1; min-width: 0; }
    .user-info-name { font-size: 0.82rem; font-weight: 600; color: var(--ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .user-info-preview { font-size: 0.68rem; color: var(--ink-3); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-top: 2px; }
    .user-info-time { font-size: 0.6rem; color: var(--ink-4); margin-top: 2px; }
    .unread-badge { background: var(--danger); color: #fff; border-radius: 20px; padding: 2px 7px; font-size: 0.62rem; font-weight: 700; flex-shrink: 0; }

    /* ── Chat panel ── */
    .chat-panel {
        background: var(--surface); border-radius: 16px;
        border: 1px solid var(--border); box-shadow: 0 2px 12px rgba(0,0,0,0.05);
        display: flex; flex-direction: column; height: 100%; overflow: hidden;
    }
    .chat-header { padding: 12px 16px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 11px; flex-shrink: 0; background: var(--surface); }
    .chat-header-avatar { width: 40px; height: 40px; border-radius: 12px; background: var(--green-light); color: var(--green); display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0; }
    .chat-header-info { flex: 1; min-width: 0; }
    .chat-header-name { font-size: 0.88rem; font-weight: 700; color: var(--ink); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin: 0; }
    .chat-header-pic  { font-size: 0.7rem; color: var(--ink-3); margin: 1px 0 0; }
    .chat-status { display: flex; align-items: center; gap: 5px; font-size: 0.69rem; color: #10b981; white-space: nowrap; flex-shrink: 0; }
    .chat-status::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: #10b981; flex-shrink: 0; }

    .btn-back-to-list {
        display: none; /* desktop: sembunyi, mobile: tampil via media query */
        width: 32px; height: 32px; border-radius: 9px;
        border: 1px solid var(--border); background: #f8fafc;
        align-items: center; justify-content: center;
        color: var(--ink-3); font-size: 12px; cursor: pointer; flex-shrink: 0;
        transition: background 0.15s;
    }
    .btn-back-to-list:hover { background: var(--green-light); color: var(--green); }

    .chat-messages {
        flex: 1; min-height: 0; overflow-y: auto; overflow-x: hidden;
        padding: 16px; background: var(--bg);
        display: flex; flex-direction: column; gap: 8px; scroll-behavior: smooth;
    }
    .chat-messages::-webkit-scrollbar { width: 3px; }
    .chat-messages::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 3px; }

    .message { display: flex; align-items: flex-end; gap: 7px; max-width: 72%; }
    .message.outgoing { align-self: flex-end; flex-direction: row-reverse; }
    .message.incoming { align-self: flex-start; }
    .msg-avatar { width: 28px; height: 28px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 10px; flex-shrink: 0; background: #f1f5f9; color: var(--ink-3); }
    .outgoing .msg-avatar { background: var(--green-light); color: var(--green); }
    .msg-bubble { padding: 9px 12px; border-radius: 14px; border: 1px solid #e9ecef; background: var(--surface); box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
    .outgoing .msg-bubble { background: var(--green-light); border-color: var(--green-mid); border-bottom-right-radius: 3px; }
    .incoming .msg-bubble { border-bottom-left-radius: 3px; }
    .msg-text { font-size: 0.84rem; color: var(--ink); line-height: 1.55; word-break: break-word; }
    .msg-meta { display: flex; align-items: center; justify-content: flex-end; gap: 4px; margin-top: 4px; }
    .msg-time { font-size: 0.62rem; color: var(--ink-4); }
    .outgoing .msg-time { color: #6b9e90; }

    .date-sep { text-align: center; font-size: 0.66rem; color: var(--ink-4); display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
    .date-sep::before, .date-sep::after { content: ''; flex: 1; height: 1px; background: #e9ecef; }

    .chat-empty { flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; color: var(--ink-4); gap: 10px; padding: 20px; text-align: center; }
    .chat-empty-icon { width: 56px; height: 56px; border-radius: 16px; background: #f1f5f9; color: var(--ink-4); display: flex; align-items: center; justify-content: center; font-size: 1.4rem; }
    .chat-empty p { font-size: 0.8rem; margin: 0; }
    .chat-empty small { font-size: 0.7rem; }

    .no-chat-selected { flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; color: var(--ink-4); gap: 12px; padding: 20px; text-align: center; }
    .no-chat-icon { width: 68px; height: 68px; border-radius: 20px; background: var(--green-light); color: var(--green); display: flex; align-items: center; justify-content: center; font-size: 1.6rem; }
    .no-chat-title { font-size: 0.93rem; font-weight: 700; color: var(--ink-2); margin: 0; }
    .no-chat-sub   { font-size: 0.76rem; color: var(--ink-4); margin: 0; }

    .chat-input-bar { padding: 10px 12px; border-top: 1px solid var(--border); background: var(--surface); display: flex; gap: 8px; align-items: center; flex-shrink: 0; padding-bottom: max(10px, env(safe-area-inset-bottom)); }
    .chat-input { flex: 1; border: 1px solid #e2e8f0; border-radius: 12px; padding: 9px 14px; font-size: 16px; font-family: inherit; outline: none; resize: none; transition: border-color 0.15s, box-shadow 0.15s; line-height: 1.4; max-height: 100px; overflow-y: auto; }
    .chat-input:focus { border-color: var(--green); box-shadow: 0 0 0 3px rgba(30,111,92,0.1); }
    .btn-send { background: var(--green); color: #fff; border: none; border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; font-size: 13px; cursor: pointer; flex-shrink: 0; transition: opacity 0.15s, transform 0.1s; }
    .btn-send:hover:not(:disabled)  { opacity: 0.88; }
    .btn-send:active:not(:disabled) { transform: scale(0.95); }
    .btn-send:disabled { opacity: 0.4; cursor: not-allowed; }

    /* ============================================================
       MOBILE
    ============================================================ */
    @media (max-width: 768px) {
        html, body { overflow: hidden !important; }

        /* Tampilkan hamburger */
        .btn-hamburger { display: flex; }

        .topnav { padding: 0 14px; }
        .topnav-left { gap: 8px; }

        .page-content { padding: 0; height: calc(100dvh - 54px); }

        .chat-shell { grid-template-columns: 1fr; gap: 0; height: 100%; position: relative; }

        /* View A: user list — full screen */
        .user-list {
            position: absolute; inset: 0;
            border-radius: 0; border: none; box-shadow: none;
            z-index: 10;
            transition: transform 0.3s cubic-bezier(0.4,0,0.2,1), opacity 0.3s;
        }
        .user-list.slide-out { transform: translateX(-100%); opacity: 0; pointer-events: none; }

        .ul-header { padding: 12px 14px; }
        .user-item { padding: 12px 14px; }
        .user-avatar { width: 44px; height: 44px; border-radius: 13px; font-size: 16px; }
        .user-info-name { font-size: 0.86rem; }
        .user-info-preview { font-size: 0.72rem; }

        /* View B: chat panel — full screen, muncul dari kanan */
        .chat-panel {
            position: absolute; inset: 0;
            border-radius: 0; border: none; box-shadow: none;
            z-index: 20;
            transform: translateX(100%);
            transition: transform 0.3s cubic-bezier(0.4,0,0.2,1);
        }
        .chat-panel.slide-in { transform: translateX(0); }

        /* Tombol back tampil di mobile */
        .btn-back-to-list { display: flex; }

        .message { max-width: 84%; }
        .chat-messages { padding: 12px; }
        .chat-header { padding: 10px 12px; }
        .chat-input-bar { padding: 8px 12px; padding-bottom: max(8px, env(safe-area-inset-bottom)); }
    }

    @media (max-width: 400px) {
        .message { max-width: 90%; }
        .msg-bubble { padding: 8px 10px; }
        .msg-text { font-size: 0.82rem; }
    }
    </style>
</head>
<body>

<?php $this->load->view('admin/sidebar'); ?>

<div class="page-wrapper">

    <header class="topnav">
        <div class="topnav-left">
            <!--
                Hamburger: id="btnHamburger"
                Memanggil window.openAdminSidebar() dari admin/sidebar.php.
                Fungsi tersebut di-set oleh jQuery ready di sidebar.php,
                maka kita gunakan onclick dengan pengecekan.
            -->
            <button class="btn-hamburger" id="btnHamburger" aria-label="Buka Menu" type="button">
                <i class="fas fa-bars"></i>
            </button>
            <div class="topnav-breadcrumb">
                <a href="<?= base_url('admin/dashboard') ?>" style="color:var(--ink-3);text-decoration:none;">
                    <i class="fas fa-home"></i>
                </a>
                <i class="fas fa-chevron-right sep"></i>
                <strong>Chat Perusahaan</strong>
            </div>
        </div>
        <div class="topnav-meta">
            <i class="fas fa-circle" style="font-size:6px;color:#10b981;margin-right:4px;"></i>
            <?= count($users) ?> Perusahaan
        </div>
    </header>

    <main class="page-content">
        <div class="chat-shell">

            <!-- VIEW A — Daftar Perusahaan -->
            <div class="user-list" id="userListPanel">
                <div class="ul-header">
                    <span class="ul-header-title">
                        <i class="fas fa-building"></i> Perusahaan
                    </span>
                    <span class="ul-count" id="userCount"><?= count($users) ?></span>
                </div>
                <div class="ul-search-wrap">
                    <i class="fas fa-search"></i>
                    <input type="text" class="ul-search" id="userSearch" placeholder="Cari perusahaan…" autocomplete="off">
                </div>
                <div class="ul-items" id="userListItems">
                    <?php foreach($users as $u):
                        $initials  = strtoupper(substr($u->perusahaan, 0, 1));
                        $is_active = isset($selected_user) && $selected_user->id == $u->id;
                        $lastMsg   = $u->last_message
                            ? (strlen($u->last_message) > 52 ? substr($u->last_message, 0, 52) . '…' : $u->last_message)
                            : 'Belum ada pesan';
                        if($u->last_message_from_me) $lastMsg = 'Anda: ' . $lastMsg;
                        $time_display = (!$u->last_message_time || $u->last_message_time === '0000-00-00 00:00:00')
                            ? '' : date('d/m H:i', strtotime($u->last_message_time));
                    ?>
                    <div class="user-item <?= $is_active ? 'active' : '' ?>"
                         data-user-id="<?= $u->id ?>"
                         data-name="<?= strtolower(htmlspecialchars($u->perusahaan)) ?>">
                        <div class="user-avatar"><?= $initials ?></div>
                        <div class="user-info">
                            <div class="user-info-name"><?= htmlspecialchars($u->perusahaan) ?></div>
                            <div class="user-info-preview"><?= htmlspecialchars($lastMsg) ?></div>
                            <?php if($time_display): ?>
                            <div class="user-info-time"><?= $time_display ?></div>
                            <?php endif; ?>
                        </div>
                        <?php if($u->unread_count > 0): ?>
                        <div class="unread-badge"><?= $u->unread_count ?></div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- VIEW B — Chat Panel -->
            <div class="chat-panel" id="chatPanel">
                <?php if(isset($selected_user)): ?>
                <div class="chat-header">
                    <button class="btn-back-to-list" id="btnBackToList" type="button" title="Kembali">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <div class="chat-header-avatar"><i class="fas fa-building"></i></div>
                    <div class="chat-header-info">
                        <p class="chat-header-name"><?= htmlspecialchars($selected_user->perusahaan) ?></p>
                        <p class="chat-header-pic">PIC: <?= htmlspecialchars($selected_user->nama) ?></p>
                    </div>
                    <div class="chat-status">Online</div>
                </div>

                <div class="chat-messages" id="chatMessages">
                    <?php if(empty($messages)): ?>
                    <div class="chat-empty">
                        <div class="chat-empty-icon"><i class="fas fa-comments"></i></div>
                        <p>Belum ada pesan</p>
                        <small>Mulai percakapan sekarang.</small>
                    </div>
                    <?php endif; ?>
                    <?php
                    $prev_date = '';
                    foreach($messages as $msg):
                        $msg_date = date('d M Y', strtotime($msg->created_at));
                        $is_out   = ($msg->from_user_id == $this->session->userdata('user_id'));
                    ?>
                    <?php if($msg_date !== $prev_date): ?>
                    <div class="date-sep"><?= $msg_date ?></div>
                    <?php $prev_date = $msg_date; endif; ?>
                    <div class="message <?= $is_out ? 'outgoing' : 'incoming' ?>">
                        <div class="msg-avatar">
                            <i class="fas <?= $is_out ? 'fa-user-tie' : 'fa-user' ?>"></i>
                        </div>
                        <div class="msg-bubble">
                            <div class="msg-text"><?= nl2br(htmlspecialchars($msg->message)) ?></div>
                            <div class="msg-meta">
                                <span class="msg-time"><?= date('H:i', strtotime($msg->created_at)) ?></span>
                                <?php if($is_out && $msg->is_read_user == 1): ?>
                                    <i class="fas fa-check-double" style="font-size:9px;color:#10b981;"></i>
                                <?php elseif($is_out): ?>
                                    <i class="fas fa-check" style="font-size:9px;color:var(--ink-4);"></i>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="chat-input-bar">
                    <input type="text" class="chat-input" id="messageInput"
                           placeholder="Tulis pesan…" autocomplete="off" enterkeyhint="send">
                    <button class="btn-send" id="sendBtn" type="button" disabled title="Kirim">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
                <?php else: ?>
                <div class="no-chat-selected">
                    <div class="no-chat-icon"><i class="fas fa-comments"></i></div>
                    <p class="no-chat-title">Pilih Perusahaan</p>
                    <p class="no-chat-sub">Pilih dari daftar di sebelah kiri untuk memulai percakapan.</p>
                </div>
                <?php endif; ?>
            </div>

        </div>
    </main>
</div>

<script>
(function () {

    /* ============================================================
       HAMBURGER
       sidebar.php menggunakan jQuery dan mendefinisikan
       window.openAdminSidebar() di dalam $(document).ready().
       Karena script sidebar.php dimuat SEBELUM halaman ini,
       fungsinya sudah tersedia saat DOMContentLoaded ini jalan.
       Kita daftarkan listener setelah DOM siap.
    ============================================================ */
    function initHamburger() {
        var btn = document.getElementById('btnHamburger');
        if (!btn) return;

        btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            /* Coba panggil fungsi global dari sidebar.php */
            if (typeof window.openAdminSidebar === 'function') {
                window.openAdminSidebar();
            } else {
                /* Fallback: buka sidebar langsung jika fungsi belum tersedia */
                var sidebar = document.getElementById('adminSidebar');
                var overlay = document.getElementById('adminOverlay');
                if (sidebar) sidebar.classList.add('mobile-open');
                if (overlay) overlay.classList.add('show');
                document.body.classList.add('body-no-scroll');
            }
        });
    }

    /* Jalankan setelah DOM selesai dan jQuery sidebar sudah ready */
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initHamburger);
    } else {
        /* DOM sudah siap (script di bawah body) */
        initHamburger();
    }

    /* ============================================================
       MOBILE CHAT: slide user-list ↔ chat panel
    ============================================================ */
    var userListPanel = document.getElementById('userListPanel');
    var chatPanel     = document.getElementById('chatPanel');
    var btnBack       = document.getElementById('btnBackToList');
    var chatMessages  = document.getElementById('chatMessages');
    var msgInput      = document.getElementById('messageInput');
    var sendBtn       = document.getElementById('sendBtn');
    var userSearch    = document.getElementById('userSearch');

    function isMobile() { return window.innerWidth <= 768; }

    function showChatPanel() {
        if (!isMobile()) return;
        if (userListPanel) userListPanel.classList.add('slide-out');
        if (chatPanel)     chatPanel.classList.add('slide-in');
    }

    function showUserList() {
        if (!isMobile()) return;
        if (chatPanel)     chatPanel.classList.remove('slide-in');
        if (userListPanel) userListPanel.classList.remove('slide-out');
    }

    if (btnBack) btnBack.addEventListener('click', showUserList);

    var resizeTimer;
    window.addEventListener('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function () {
            if (!isMobile()) {
                if (userListPanel) userListPanel.classList.remove('slide-out');
                if (chatPanel)     chatPanel.classList.remove('slide-in');
            }
        }, 200);
    });

    /* Klik user item → navigasi */
    document.querySelectorAll('.user-item').forEach(function (item) {
        item.addEventListener('click', function () {
            window.location.href = '<?= base_url("chat") ?>?user_id=' + this.dataset.userId;
        });
    });

    /* Filter pencarian */
    if (userSearch) {
        userSearch.addEventListener('input', function () {
            var q = this.value.toLowerCase().trim();
            document.querySelectorAll('.user-item').forEach(function (item) {
                item.style.display = (!q || (item.dataset.name || '').indexOf(q) !== -1) ? '' : 'none';
            });
        });
    }

    /* Jika ada selected user → buka chat panel di mobile langsung */
    <?php if(isset($selected_user)): ?>
    if (isMobile()) showChatPanel();
    <?php endif; ?>

    /* ============================================================
       CHAT FUNGSIONALITAS
    ============================================================ */
    <?php if(isset($selected_user)): ?>

    var partnerId = <?= (int)$selected_user->id ?>;
    var lastId    = <?= !empty($messages) ? (int)end($messages)->id : 0 ?>;
    var myId      = <?= (int)$this->session->userdata('user_id') ?>;
    var sending   = false;

    function getCsrf() {
        return {
            name:  document.querySelector('meta[name="csrf-name"]').content,
            token: document.querySelector('meta[name="csrf-token"]').content
        };
    }
    function updateCsrf(xhr) {
        var t = xhr.getResponseHeader('X-CSRF-Token');
        if (t) document.querySelector('meta[name="csrf-token"]').content = t;
    }
    function encode(obj) {
        return Object.keys(obj).map(function(k) {
            return encodeURIComponent(k) + '=' + encodeURIComponent(obj[k]);
        }).join('&');
    }
    function esc(str) {
        return String(str)
            .replace(/&/g,'&amp;').replace(/</g,'&lt;')
            .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    function scrollBottom() {
        if (chatMessages) chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function makeBubble(msg) {
        var isOut = (msg.from_user_id == myId);
        var d     = new Date(msg.created_at.replace(' ', 'T'));
        var time  = d.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        var wrap  = document.createElement('div');
        wrap.className = 'message ' + (isOut ? 'outgoing' : 'incoming');
        var ava   = document.createElement('div');
        ava.className = 'msg-avatar';
        ava.innerHTML = '<i class="fas ' + (isOut ? 'fa-user-tie' : 'fa-user') + '"></i>';
        var bubble = document.createElement('div');
        bubble.className = 'msg-bubble';
        var text   = document.createElement('div');
        text.className = 'msg-text';
        text.innerHTML = esc(msg.message).replace(/\n/g, '<br>');
        var meta   = document.createElement('div');
        meta.className = 'msg-meta';
        var timeEl = document.createElement('span');
        timeEl.className = 'msg-time';
        timeEl.textContent = time;
        meta.appendChild(timeEl);
        if (isOut) {
            var ick = document.createElement('i');
            ick.className = msg.is_read_user == 1
                ? 'fas fa-check-double'
                : 'fas fa-check';
            ick.style.cssText = msg.is_read_user == 1
                ? 'font-size:9px;color:#10b981;'
                : 'font-size:9px;color:var(--ink-4);';
            meta.appendChild(ick);
        }
        bubble.appendChild(text);
        bubble.appendChild(meta);
        wrap.appendChild(ava);
        wrap.appendChild(bubble);
        return wrap;
    }

    function pollMessages() {
        var c = getCsrf();
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '<?= base_url("chat/get_new") ?>', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onload = function () {
            updateCsrf(xhr);
            if (xhr.status !== 200) return;
            var msgs; try { msgs = JSON.parse(xhr.responseText); } catch(e) { return; }
            if (!msgs || !msgs.length) return;
            var emptyEl = chatMessages.querySelector('.chat-empty');
            if (emptyEl) emptyEl.remove();
            msgs.forEach(function(m) { chatMessages.appendChild(makeBubble(m)); if (m.id > lastId) lastId = m.id; });
            scrollBottom();
            markRead();
        };
        xhr.send(encode({ last_id: lastId, partner_id: partnerId, [getCsrf().name]: getCsrf().token }));
    }

    function sendMessage() {
        var msg = msgInput.value.trim();
        if (!msg || sending) return;
        sending = true; sendBtn.disabled = true; msgInput.disabled = true;
        var c = getCsrf();
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '<?= base_url("chat/send") ?>', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onload = function () {
            updateCsrf(xhr);
            if (xhr.status === 403) { location.reload(); return; }
            var res; try { res = JSON.parse(xhr.responseText); } catch(e) {}
            if (res && res.status === 'success') {
                msgInput.value = ''; sendBtn.disabled = true;
                pollMessages(); refreshUserList();
            } else { alert(res && res.message ? res.message : 'Gagal mengirim pesan.'); }
            sending = false; msgInput.disabled = false; msgInput.focus();
        };
        xhr.onerror = function () {
            alert('Tidak ada koneksi.'); sending = false; msgInput.disabled = false;
            sendBtn.disabled = !msgInput.value.trim();
        };
        xhr.send(encode({ to: partnerId, message: msg, [c.name]: c.token }));
    }

    function markRead() {
        var c = getCsrf();
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '<?= base_url("chat/mark_read") ?>', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onload = function () {
            updateCsrf(xhr);
            var badge = document.querySelector('.user-item[data-user-id="'+partnerId+'"] .unread-badge');
            if (badge) badge.remove();
        };
        xhr.send(encode({ partner_id: partnerId, [c.name]: c.token }));
    }

    function refreshUserList() {
        var c = getCsrf();
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '<?= base_url("chat/get_user_list") ?>', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.onload = function () {
            updateCsrf(xhr);
            if (xhr.status !== 200) return;
            var users; try { users = JSON.parse(xhr.responseText); } catch(e) { return; }
            var container = document.getElementById('userListItems');
            container.innerHTML = '';
            users.forEach(function(u) {
                var lastMsg = u.last_message ? (u.last_message.length > 52 ? u.last_message.substr(0,52)+'…' : u.last_message) : 'Belum ada pesan';
                if (u.last_message_from_me) lastMsg = 'Anda: ' + lastMsg;
                var d = u.last_message_time ? new Date(u.last_message_time.replace(' ','T')) : null;
                var time = d ? d.toLocaleString('id-ID', {day:'2-digit',month:'2-digit',hour:'2-digit',minute:'2-digit'}) : '';
                var item = document.createElement('div');
                item.className = 'user-item' + (u.id == partnerId ? ' active' : '');
                item.dataset.userId = u.id;
                item.dataset.name   = (u.perusahaan||'').toLowerCase();
                item.innerHTML =
                    '<div class="user-avatar">' + esc(u.initials||u.perusahaan.charAt(0).toUpperCase()) + '</div>'
                    + '<div class="user-info">'
                    +   '<div class="user-info-name">' + esc(u.perusahaan) + '</div>'
                    +   '<div class="user-info-preview">' + esc(lastMsg) + '</div>'
                    +   (time ? '<div class="user-info-time">'+time+'</div>' : '')
                    + '</div>'
                    + (u.unread_count > 0 ? '<div class="unread-badge">'+u.unread_count+'</div>' : '');
                item.addEventListener('click', function() {
                    window.location.href = '<?= base_url("chat") ?>?user_id=' + this.dataset.userId;
                });
                container.appendChild(item);
            });
            document.getElementById('userCount').textContent = users.length;
            var q = userSearch ? userSearch.value.toLowerCase().trim() : '';
            if (q) container.querySelectorAll('.user-item').forEach(function(it) {
                it.style.display = (it.dataset.name.indexOf(q) !== -1) ? '' : 'none';
            });
        };
        xhr.send(encode({ [c.name]: c.token }));
    }

    if (sendBtn) sendBtn.addEventListener('click', sendMessage);
    if (msgInput) {
        msgInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); }
        });
        msgInput.addEventListener('input', function() { sendBtn.disabled = !this.value.trim(); });
    }
    if (window.visualViewport) window.visualViewport.addEventListener('resize', scrollBottom);

    scrollBottom();
    markRead();
    setInterval(pollMessages, 2000);
    setInterval(refreshUserList, 5000);

    <?php endif; ?>

})();
</script>
</body>
</html>