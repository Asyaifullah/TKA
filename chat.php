<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Chat dengan Perusahaan - Operator</title>
    <meta name="csrf-token" content="<?= $this->security->get_csrf_hash() ?>">
    <meta name="csrf-name"  content="<?= $this->security->get_csrf_token_name() ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #1e6f5c;
            --primary-light: #e6f4f1;
            --primary-mid: #cde8e0;
            --border-light: #e9ecef;
            --card-shadow: 0 8px 30px rgba(0,0,0,0.04);
        }
        body { background: #f8fafc; font-family: 'Inter', sans-serif; margin: 0; }
        .content { margin-left: 260px; padding: 24px 32px; transition: margin-left 0.3s ease; }
        .sidebar.collapsed ~ .content { margin-left: 70px; }
        .page-header { margin-bottom: 20px; }
        .page-header h3 { font-size: 1.2rem; font-weight: 600; margin: 0; }
        .page-header p  { font-size: 0.8rem; color: #64748b; margin: 4px 0 0; }
        .chat-wrapper { display: flex; gap: 20px; height: calc(100vh - 148px); min-height: 480px; max-height: 780px; }
        .user-list { width: 300px; flex-shrink: 0; background: white; border-radius: 20px; border: 1px solid var(--border-light); box-shadow: var(--card-shadow); display: flex; flex-direction: column; overflow: hidden; }
        .user-list-header { padding: 14px 18px; border-bottom: 1px solid var(--border-light); display: flex; align-items: center; justify-content: space-between; }
        .user-list-header span { font-size: 0.82rem; font-weight: 600; color: #1e293b; }
        .user-list-count { font-size: 0.7rem; background: var(--primary-light); color: var(--primary); padding: 2px 8px; border-radius: 99px; font-weight: 600; }
        .user-search-wrap { padding: 10px 12px; border-bottom: 1px solid var(--border-light); position: relative; }
        .user-search { width: 100%; border: 1px solid #e2e8f0; border-radius: 8px; padding: 6px 10px 6px 28px; font-size: 0.78rem; outline: none; background: #f8fafc; }
        .user-search:focus { border-color: var(--primary); background: white; }
        .user-search-wrap i { position: absolute; left: 22px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 11px; }
        .user-list-items { flex: 1; overflow-y: auto; }
        .user-item { padding: 12px 16px; border-bottom: 1px solid #f1f5f9; cursor: pointer; display: flex; gap: 10px; transition: background 0.15s; align-items: center; }
        .user-item:hover { background: #f8fafc; }
        .user-item.active { background: var(--primary-light); }
        .user-avatar { width: 40px; height: 40px; border-radius: 12px; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0; }
        .user-info { flex: 1; min-width: 0; }
        .user-info-name { font-size: 0.85rem; font-weight: 600; color: #1e293b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .user-info-preview { font-size: 0.7rem; color: #64748b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-top: 2px; }
        .user-info-time { font-size: 0.6rem; color: #94a3b8; margin-top: 2px; }
        .unread-badge { background: #f43f5e; color: white; border-radius: 30px; padding: 2px 8px; font-size: 0.65rem; font-weight: 600; margin-left: 8px; flex-shrink: 0; }
        .chat-container { flex: 1; background: white; border-radius: 20px; border: 1px solid var(--border-light); box-shadow: var(--card-shadow); display: flex; flex-direction: column; overflow: hidden; }
        .chat-header { padding: 14px 20px; border-bottom: 1px solid var(--border-light); display: flex; align-items: center; gap: 12px; background: white; }
        .chat-header-avatar { width: 38px; height: 38px; border-radius: 10px; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 14px; }
        .chat-header-info { flex: 1; }
        .chat-header-name { font-size: 0.9rem; font-weight: 600; color: #1e293b; margin: 0; }
        .chat-header-pic { font-size: 0.75rem; color: #64748b; margin: 0; }
        .chat-header-status { display: flex; align-items: center; gap: 5px; font-size: 0.72rem; color: #10b981; }
        .chat-header-status::before { content: ''; width: 7px; height: 7px; border-radius: 50%; background: #10b981; }
        .chat-messages { flex: 1; overflow-y: auto; padding: 20px; background: #f8fafc; display: flex; flex-direction: column; gap: 10px; }
        .message { display: flex; align-items: flex-end; gap: 8px; max-width: 72%; }
        .message.outgoing { align-self: flex-end; flex-direction: row-reverse; }
        .message.incoming { align-self: flex-start; }
        .message-avatar { width: 28px; height: 28px; border-radius: 8px; background: #f1f5f9; color: #64748b; display: flex; align-items: center; justify-content: center; font-size: 11px; flex-shrink: 0; }
        .outgoing .message-avatar { background: var(--primary-light); color: var(--primary); }
        .message-bubble { padding: 9px 14px; border-radius: 14px; border: 1px solid #e9ecef; background: white; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
        .outgoing .message-bubble { background: var(--primary-light); border-color: var(--primary-mid); border-bottom-right-radius: 4px; }
        .incoming .message-bubble { border-bottom-left-radius: 4px; }
        .message-text { font-size: 0.85rem; color: #1e293b; line-height: 1.5; word-break: break-word; }
        .message-meta { display: flex; align-items: center; justify-content: flex-end; gap: 4px; margin-top: 4px; }
        .message-time { font-size: 0.65rem; color: #94a3b8; }
        .outgoing .message-time { color: #6b9e90; }
        .date-separator { text-align: center; font-size: 0.7rem; color: #94a3b8; margin: 8px 0; display: flex; align-items: center; gap: 10px; }
        .date-separator::before, .date-separator::after { content: ''; flex: 1; height: 1px; background: #e9ecef; }
        .chat-empty { flex: 1; display: flex; align-items: center; justify-content: center; color: #94a3b8; gap: 10px; flex-direction: column; }
        .chat-header-empty { padding: 14px 20px; border-bottom: 1px solid var(--border-light); color: #94a3b8; font-size: 0.85rem; }
        .chat-input-wrap { padding: 14px 16px; border-top: 1px solid var(--border-light); background: white; display: flex; gap: 10px; }
        .chat-input-wrap input { flex: 1; border: 1px solid #e2e8f0; border-radius: 10px; padding: 9px 14px; font-size: 0.875rem; outline: none; }
        .chat-input-wrap input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(30,111,92,0.1); }
        .btn-send { background: var(--primary); color: white; border: none; border-radius: 10px; padding: 9px 18px; font-size: 0.85rem; font-weight: 500; cursor: pointer; }
        .btn-send:hover { background: #165a4a; }
        @media (max-width: 768px) {
            .content { margin-left: 0; padding: 16px; }
            .chat-wrapper { flex-direction: column; height: auto; }
            .user-list { width: 100%; max-height: 220px; }
        }
    </style>
</head>
<body>
<?php $this->load->view('operator/sidebar'); ?>
<div class="content">
    <div class="page-header">
        <h3><i class="fas fa-comments me-2" style="color:var(--primary);"></i> Chat dengan Perusahaan</h3>
        <p>Komunikasi langsung dengan perusahaan pengguna sistem TKA.</p>
    </div>
    <div class="chat-wrapper">
        <!-- DAFTAR PERUSAHAAN -->
        <div class="user-list">
            <div class="user-list-header">
                <span>Perusahaan</span>
                <span class="user-list-count" id="userCount"><?= count($users) ?></span>
            </div>
            <div class="user-search-wrap">
                <i class="fas fa-search"></i>
                <input type="text" class="user-search" id="userSearch" placeholder="Cari perusahaan...">
            </div>
            <div class="user-list-items" id="userListItems">
                <?php foreach ($users as $u):
                    $initials = strtoupper(substr($u->perusahaan, 0, 1));
                    $is_active = (isset($selected_user) && $selected_user->id == $u->id);
                    $lastMsg = $u->last_message ? (strlen($u->last_message) > 50 ? substr($u->last_message, 0, 50).'...' : $u->last_message) : 'Belum ada pesan';
                    if ($u->last_message_from_me) $lastMsg = 'Anda: '.$lastMsg;
                    $time = date('d/m H:i', strtotime($u->last_message_time));
                    $time_display = ($u->last_message_time == '0000-00-00 00:00:00') ? '' : $time;
                ?>
                <div class="user-item <?= $is_active ? 'active' : '' ?>" data-user-id="<?= $u->id ?>" data-name="<?= strtolower(htmlspecialchars($u->perusahaan)) ?>">
                    <div class="user-avatar"><?= $initials ?></div>
                    <div class="user-info">
                        <div class="user-info-name"><?= htmlspecialchars($u->perusahaan) ?></div>
                        <div class="user-info-preview"><?= htmlspecialchars($lastMsg) ?></div>
                        <div class="user-info-time"><?= $time_display ?></div>
                    </div>
                    <?php if($u->unread_count > 0): ?>
                        <div class="unread-badge"><?= $u->unread_count ?></div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- CHAT AREA -->
        <div class="chat-container" id="chatContainer">
            <?php if(isset($selected_user)): ?>
            <div class="chat-header">
                <div class="chat-header-avatar"><i class="fas fa-building"></i></div>
                <div class="chat-header-info">
                    <p class="chat-header-name"><?= htmlspecialchars($selected_user->perusahaan) ?></p>
                    <p class="chat-header-pic">PIC: <?= htmlspecialchars($selected_user->nama) ?></p>
                </div>
                <div class="chat-header-status">Online</div>
            </div>
            <div class="chat-messages" id="chatMessages">
                <?php if(empty($messages)): ?>
                    <div class="chat-empty">Belum ada pesan. Mulai percakapan sekarang.</div>
                <?php endif; ?>
                <?php 
                $prev_date = '';
                foreach($messages as $msg):
                    $msg_date = date('d M Y', strtotime($msg->created_at));
                    $is_out = ($msg->from_user_id == $this->session->userdata('user_id'));
                ?>
                    <?php if($msg_date !== $prev_date): ?>
                        <div class="date-separator"><?= $msg_date ?></div>
                    <?php $prev_date = $msg_date; endif; ?>
                    <div class="message <?= $is_out ? 'outgoing' : 'incoming' ?>">
                        <div class="message-avatar"><i class="fas <?= $is_out ? 'fa-user-tie' : 'fa-user' ?>"></i></div>
                        <div class="message-bubble">
                            <div class="message-text"><?= nl2br(htmlspecialchars($msg->message)) ?></div>
                            <div class="message-meta">
                                <span class="message-time"><?= date('H:i', strtotime($msg->created_at)) ?></span>
                                <?php if($is_out && $msg->is_read_user == 1): ?>
                                    <i class="fas fa-check-double" style="font-size:9px; color:#10b981;" title="Dibaca"></i>
                                <?php elseif($is_out): ?>
                                    <i class="fas fa-check" style="font-size:9px; color:#94a3b8;" title="Terkirim"></i>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="chat-input-wrap">
                <input type="text" id="messageInput" placeholder="Tulis pesan..." autocomplete="off">
                <button class="btn-send" id="sendBtn"><i class="fas fa-paper-plane"></i> Kirim</button>
            </div>
            <?php else: ?>
            <div class="chat-header-empty">Pilih perusahaan dari daftar untuk memulai chat</div>
            <div class="chat-empty">
                <i class="fas fa-comments fa-2x" style="opacity:0.3;"></i>
                <p>Pilih perusahaan di sebelah kiri.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// CSRF HELPER
function getCsrf() {
    return { name: $('meta[name="csrf-name"]').attr('content'), token: $('meta[name="csrf-token"]').attr('content') };
}
function updateCsrf(newToken) { if(newToken) $('meta[name="csrf-token"]').attr('content', newToken); }

// Filter user list
$('#userSearch').on('input', function() {
    var q = $(this).val().toLowerCase();
    $('.user-item').each(function() { $(this).toggle($(this).data('name').indexOf(q) !== -1); });
});

// Navigasi klik user
$('.user-item').on('click', function() {
    window.location.href = '<?= base_url("chat") ?>?user_id=' + $(this).data('user-id');
});

<?php if(isset($selected_user)): ?>
var partnerId = <?= $selected_user->id ?>;
var lastId    = <?= !empty($messages) ? end($messages)->id : 0 ?>;
var myId      = <?= $this->session->userdata('user_id') ?>;

function scrollToBottom() {
    var el = document.getElementById('chatMessages');
    if (el) el.scrollTop = el.scrollHeight;
}

function escapeHtml(str) {
    return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
}

// Load pesan baru
function loadNewMessages() {
    var csrf = getCsrf();
    var data = { last_id: lastId, partner_id: partnerId };
    data[csrf.name] = csrf.token;
    $.ajax({
        url: '<?= base_url("chat/get_new") ?>',
        type: 'POST', data: data, dataType: 'json',
        success: function(messages, status, xhr) {
            updateCsrf(xhr.getResponseHeader('X-CSRF-Token'));
            if (!messages || !messages.length) return;
            messages.forEach(function(msg) {
                var isOut = (msg.from_user_id == myId);
                var readHtml = isOut ? (msg.is_read_user == 1 ? '<i class="fas fa-check-double"></i>' : '<i class="fas fa-check"></i>') : '';
                var time = new Date(msg.created_at).toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'});
                var html = `<div class="message ${isOut ? 'outgoing' : 'incoming'}">
                    <div class="message-avatar"><i class="fas ${isOut ? 'fa-user-tie' : 'fa-user'}"></i></div>
                    <div class="message-bubble">
                        <div class="message-text">${escapeHtml(msg.message).replace(/\n/g,'<br>')}</div>
                        <div class="message-meta"><span class="message-time">${time}</span> ${readHtml}</div>
                    </div>
                </div>`;
                $('#chatMessages').append(html);
                if (msg.id > lastId) lastId = msg.id;
            });
            scrollToBottom();
            // Tandai pesan sudah dibaca
            markMessagesRead();
        },
        error: function(xhr) { if(xhr.status === 403) location.reload(); }
    });
}

// Kirim pesan
$('#sendBtn').on('click', function() {
    var msg = $('#messageInput').val().trim();
    if (!msg) return;
    var csrf = getCsrf();
    var data = { to: partnerId, message: msg };
    data[csrf.name] = csrf.token;
    $.ajax({
        url: '<?= base_url("chat/send") ?>',
        type: 'POST', data: data, dataType: 'json',
        success: function(res, status, xhr) {
            updateCsrf(xhr.getResponseHeader('X-CSRF-Token'));
            if (res.status === 'success') {
                $('#messageInput').val('');
                loadNewMessages();
                refreshUserList(); // update daftar user (preview, badge)
            } else alert(res.message);
        },
        error: function(xhr) { if(xhr.status === 403) location.reload(); else alert('Gagal kirim'); }
    });
});

$('#messageInput').on('keydown', function(e) {
    if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); $('#sendBtn').click(); }
});

function markMessagesRead() {
    var csrf = getCsrf();
    var data = { partner_id: partnerId };
    data[csrf.name] = csrf.token;
    $.post('<?= base_url("chat/mark_read") ?>', data, function(res) {
        $('#userListItems .user-item[data-user-id="'+partnerId+'"] .unread-badge').remove();
    });
}

// Refresh daftar user (tanpa reload halaman)
function refreshUserList() {
    var csrf = getCsrf();
    var data = {};
    data[csrf.name] = csrf.token;
    $.ajax({
        url: '<?= base_url("chat/get_user_list") ?>',
        type: 'POST', data: data, dataType: 'json',
        success: function(users, status, xhr) {
            updateCsrf(xhr.getResponseHeader('X-CSRF-Token'));
            var currentActive = $('#userListItems .user-item.active').data('user-id');
            $('#userListItems').empty();
            $.each(users, function(i, u) {
                var lastMsg = u.last_message ? (u.last_message.length>50 ? u.last_message.substr(0,50)+'...' : u.last_message) : 'Belum ada pesan';
                if (u.last_message_from_me) lastMsg = 'Anda: '+lastMsg;
                var time = u.last_message_time ? new Date(u.last_message_time).toLocaleString('id-ID', {day:'2-digit', month:'2-digit', hour:'2-digit', minute:'2-digit'}) : '';
                var activeClass = (currentActive == u.id) ? 'active' : '';
                var badge = u.unread_count > 0 ? `<div class="unread-badge">${u.unread_count}</div>` : '';
                var html = `<div class="user-item ${activeClass}" data-user-id="${u.id}" data-name="${u.perusahaan.toLowerCase()}">
                    <div class="user-avatar">${u.initials}</div>
                    <div class="user-info">
                        <div class="user-info-name">${escapeHtml(u.perusahaan)}</div>
                        <div class="user-info-preview">${escapeHtml(lastMsg)}</div>
                        <div class="user-info-time">${time}</div>
                    </div>
                    ${badge}
                </div>`;
                $('#userListItems').append(html);
            });
            $('#userCount').text(users.length);
            // re-attach event
            $('.user-item').off('click').on('click', function() {
                window.location.href = '<?= base_url("chat") ?>?user_id=' + $(this).data('user-id');
            });
            if ($('#userSearch').val()) {
                var q = $('#userSearch').val().toLowerCase();
                $('.user-item').each(function() { $(this).toggle($(this).data('name').indexOf(q) !== -1); });
            }
        }
    });
}

setInterval(loadNewMessages, 2000);
setInterval(refreshUserList, 5000);
scrollToBottom();
<?php endif; ?>
</script>
</body>
</html>