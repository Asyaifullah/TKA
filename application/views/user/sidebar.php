<?php
// ============================================================
// views/user/sidebar.php — tema PUTIH / terang
// ============================================================
$nama_user  = $this->session->userdata('nama') ?? 'Pengguna';
$perusahaan = $this->session->userdata('perusahaan') ?? 'Perusahaan';
$initials   = strtoupper(substr($nama_user, 0, 1));
$current    = trim(uri_string(), '/');
function usr_active($uri) {
    global $current;
    return (trim($uri, '/') === $current) ? 'active' : '';
}
?>

<style>
/* ══════════════════════════════════════════════════
   USER SIDEBAR — Light / White Theme
══════════════════════════════════════════════════ */
:root {
    --usb-bg:         #ffffff;
    --usb-surface:    #f8fafc;
    --usb-border:     #e9ecef;
    --usb-accent:     #1e6f5c;
    --usb-accent-dim: rgba(30,111,92,0.08);
    --usb-accent-mid: rgba(30,111,92,0.15);
    --usb-text:       #1e293b;
    --usb-muted:      #64748b;
    --usb-faint:      #94a3b8;
    --usb-danger:     #f43f5e;
    --usb-width:      252px;
    --usb-width-col:  66px;
    --usb-r:          9px;
    --usb-tr:         0.26s cubic-bezier(.4,0,.2,1);
    --usb-shadow:     2px 0 16px rgba(0,0,0,0.06);
}

/* ── Base ── */
.sidebar {
    position: fixed;
    top: 0; left: 0;
    width: var(--usb-width);
    height: 100vh;
    background: var(--usb-bg);
    display: flex;
    flex-direction: column;
    z-index: 1000;
    transition: width var(--usb-tr), transform var(--usb-tr);
    overflow: hidden;
    font-family: 'Inter', sans-serif;
    border-right: 1px solid var(--usb-border);
    box-shadow: var(--usb-shadow);
}
/* top accent stripe */
.sidebar::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--usb-accent) 0%, #2a9d7f 100%);
    pointer-events: none; z-index: 1;
}
.sidebar.collapsed { width: var(--usb-width-col); }

/* ── Brand (Disesuaikan dengan Struktur Operator & Approval) ── */
.sb-brand {
    display: flex; 
    align-items: center; 
    gap: 10px;
    padding: 18px 16px; 
    border-bottom: 1px solid var(--usb-border);
    flex-shrink: 0; 
    overflow: hidden;
    text-decoration: none;
}
.sb-brand img { 
    width: 50px; 
    height: 50px; 
    object-fit: contain; 
    flex-shrink: 0; 
}
.sb-brand-text { 
    display: flex; 
    flex-direction: column; 
    overflow: hidden; 
}
.sb-brand-name {
    display: block; font-size: 0.95rem; font-weight: 800;
    color: var(--usb-accent); letter-spacing: -0.02em; line-height: 1.2;
    white-space: nowrap;
}
.sb-brand-sub {
    display: block; font-size: 0.62rem; font-weight: 600;
    color: #94a3b8; text-transform: uppercase;
    letter-spacing: 0.06em; white-space: nowrap;
}
.sidebar.collapsed .sb-brand-text { display: none; }
.sidebar.collapsed .sb-brand { justify-content: center; }

/* ── User chip ── */
.sb-user {
    display: flex; align-items: center; gap: 9px;
    padding: 10px 14px;
    border-bottom: 1px solid var(--usb-border);
    background: var(--usb-surface);
    flex-shrink: 0;
}
.sb-user-avatar {
    width: 30px; height: 30px; border-radius: 9px;
    background: var(--usb-accent-dim);
    border: 1px solid var(--usb-accent-mid);
    color: var(--usb-accent);
    font-size: 0.7rem; font-weight: 800;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.sb-user-name {
    font-size: 0.74rem; font-weight: 700;
    color: var(--usb-text);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.sb-user-role {
    font-size: 0.59rem; font-weight: 500;
    color: var(--usb-muted);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    margin-top: 1px;
}
.sidebar.collapsed .sb-user-name,
.sidebar.collapsed .sb-user-role { display: none; }

/* ── Scrollable nav ── */
.sb-nav {
    flex: 1; overflow-y: auto; overflow-x: hidden;
    padding: 8px 0 6px;
}
.sb-nav::-webkit-scrollbar { width: 3px; }
.sb-nav::-webkit-scrollbar-track { background: transparent; }
.sb-nav::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 3px; }

/* Section label */
.sb-section {
    font-size: 0.57rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.9px;
    color: var(--usb-faint);
    padding: 12px 18px 4px; white-space: nowrap;
}
.sidebar.collapsed .sb-section { display: none; }

/* Divider */
.sb-divider { height: 1px; background: var(--usb-border); margin: 4px 12px; }

/* Nav link */
.sb-link {
    display: flex; align-items: center; gap: 9px;
    padding: 8px 10px; margin: 1px 9px;
    border-radius: var(--usb-r);
    color: var(--usb-muted); text-decoration: none;
    font-size: 0.79rem; font-weight: 500;
    white-space: nowrap;
    transition: background var(--usb-tr), color var(--usb-tr);
    position: relative;
}
.sb-link:hover {
    background: var(--usb-surface);
    color: var(--usb-text);
    text-decoration: none;
}
.sb-link.active {
    background: var(--usb-accent-dim);
    color: var(--usb-accent);
    font-weight: 600;
}
.sb-link.active::after {
    content: '';
    position: absolute;
    left: 0; top: 22%; bottom: 22%;
    width: 2.5px; background: var(--usb-accent);
    border-radius: 0 2px 2px 0;
}

/* Nav icon */
.sb-icon {
    width: 30px; height: 30px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.76rem; flex-shrink: 0;
    background: #f1f5f9;
    color: inherit;
    transition: background var(--usb-tr), color var(--usb-tr);
}
.sb-link:hover .sb-icon  { background: #e2e8f0; color: var(--usb-text); }
.sb-link.active .sb-icon { background: var(--usb-accent-mid); color: var(--usb-accent); }

/* Nav label */
.sb-label { flex: 1; line-height: 1; }
.sidebar.collapsed .sb-label { display: none; }

/* Badge */
.sb-badge {
    min-width: 17px; height: 17px;
    background: var(--usb-danger);
    color: #fff; font-size: 8px; font-weight: 700;
    border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    padding: 0 4px; flex-shrink: 0;
}
.sidebar.collapsed .sb-badge {
    position: absolute; top: 4px; right: 4px;
    min-width: 13px; height: 13px; font-size: 7px;
}

/* Logout */
.sb-link.sb-logout:hover {
    background: #fff1f2; color: #e11d48;
}
.sb-link.sb-logout:hover .sb-icon {
    background: #ffe4e6; color: #e11d48;
}

/* Collapsed centering */
.sidebar.collapsed .sb-link {
    justify-content: center; padding: 8px; margin: 1px 9px;
}
.sidebar.collapsed .sb-link .sb-icon { margin: 0; }

/* ── Toggle button ── */
.sb-toggle {
    flex-shrink: 0;
    border-top: 1px solid var(--usb-border);
    padding: 8px 9px;
    background: var(--usb-bg);
}
.sb-toggle-btn {
    display: flex; align-items: center; gap: 9px;
    width: 100%; padding: 8px 10px;
    border-radius: var(--usb-r);
    background: transparent; border: none; cursor: pointer;
    color: var(--usb-muted);
    font-family: 'Inter', sans-serif;
    font-size: 0.74rem; font-weight: 500;
    transition: background var(--usb-tr), color var(--usb-tr);
    white-space: nowrap;
}
.sb-toggle-btn:hover { background: var(--usb-surface); color: var(--usb-text); }
.sb-toggle-icon {
    width: 30px; height: 30px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.7rem; flex-shrink: 0;
    background: #f1f5f9;
    transition: background var(--usb-tr), transform var(--usb-tr);
}
.sb-toggle-btn:hover .sb-toggle-icon { background: #e2e8f0; }
.sidebar.collapsed .sb-toggle-icon { transform: rotate(180deg); }
.sb-toggle-label { line-height: 1; }
.sidebar.collapsed .sb-toggle-label { display: none; }

/* ── Content margin ── */
.content {
    margin-left: var(--usb-width);
    transition: margin-left var(--usb-tr);
}
.sidebar.collapsed ~ .content { margin-left: var(--usb-width-col); }

/* ── MOBILE BREAKPOINT ── */
@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
        transition: transform var(--usb-tr);
        width: 280px !important;
        box-shadow: none;
    }
    .sidebar.mobile-open {
        transform: translateX(0);
        box-shadow: 4px 0 32px rgba(0,0,0,0.2);
    }
    .sidebar .sb-brand-text,
    .sidebar .sb-user-name,
    .sidebar .sb-user-role,
    .sidebar .sb-label,
    .sidebar .sb-section,
    .sidebar .sb-toggle-label {
        display: block !important;
        opacity: 1 !important;
        width: auto !important;
    }
    .sidebar .sb-link {
        justify-content: flex-start !important;
        padding: 8px 10px !important;
    }
    .sidebar .sb-badge {
        position: static !important;
    }
    .content { margin-left: 0 !important; padding: 20px; }
    .sb-toggle { display: none; }
}
</style>

<nav class="sidebar" id="userSidebar">

    <a class="sb-brand" href="<?= base_url('dashboard') ?>">
        <img src="<?= base_url('assets/images/logo_kota_bekasi.png') ?>" alt="Logo Bekasi">
        <div class="sb-brand-text">
            <span class="sb-brand-name">SITLAKEB TKA</span>
            <span class="sb-brand-sub">DISNAKER KOTA BEKASI</span>
        </div>
    </a>

    <div class="sb-user">
        <div class="sb-user-avatar"><?= $initials ?></div>
        <div style="overflow:hidden; min-width:0;">
            <div class="sb-user-name"><?= htmlspecialchars($nama_user) ?></div>
            <div class="sb-user-role"><?= htmlspecialchars($perusahaan) ?></div>
        </div>
    </div>

    <div class="sb-nav">

        <a class="sb-link <?= usr_active('dashboard') ?>" href="<?= base_url('dashboard') ?>">
            <span class="sb-icon"><i class="fas fa-home"></i></span>
            <span class="sb-label">Dashboard</span>
        </a>

        <div class="sb-divider"></div>
        <div class="sb-section">Pengajuan TKA</div>

        <a class="sb-link <?= usr_active('user/data_tka') ?>" href="<?= base_url('user/data_tka') ?>">
            <span class="sb-icon"><i class="fas fa-layer-group"></i></span>
            <span class="sb-label">Data TKA</span>
        </a>

        <div class="sb-divider"></div>
        <div class="sb-section">Komunikasi</div>

        <a class="sb-link <?= usr_active('chat') ?>" href="<?= base_url('chat') ?>" style="position:relative;">
            <span class="sb-icon"><i class="fas fa-comment-dots"></i></span>
            <span class="sb-label">Chat Admin</span>
            <span id="chatBadge" class="sb-badge" style="display:none;">0</span>
        </a>
        <a class="sb-link <?= usr_active('user/notifications') ?>" href="<?= base_url('user/notifications') ?>" style="position:relative;">
            <span class="sb-icon"><i class="fas fa-bell"></i></span>
            <span class="sb-label">Notifikasi</span>
            <span id="notifBadgeSidebar" class="sb-badge" style="display:none;">0</span>
        </a>

        <div class="sb-divider"></div>
        <div class="sb-section">Akun</div>

        <a class="sb-link <?= usr_active('user/profile') ?>" href="<?= base_url('user/profile') ?>">
            <span class="sb-icon"><i class="fas fa-user-circle"></i></span>
            <span class="sb-label">Profil Saya</span>
        </a>

        <div class="sb-divider"></div>

        <a href="<?= base_url('auth/logout') ?>"
        class="sb-link sb-logout"
        data-tooltip="Logout"
        onclick="return confirm('Yakin ingin keluar?')">
            <div class="sb-icon"><i class="fas fa-right-from-bracket"></i></div>
            <span class="sb-label">Logout</span>
        </a>

    </div>

    <div class="sb-toggle">
        <button class="sb-toggle-btn" id="userSidebarToggle">
            <span class="sb-toggle-icon"><i class="fas fa-chevron-left"></i></span>
            <span class="sb-toggle-label">Tutup Sidebar</span>
        </button>
    </div>

</nav>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {

    // ── 1. SIDEBAR COLLAPSE (DESKTOP) ──
    var $sidebar = $('#userSidebar');
    var $toggleBtn = $('#userSidebarToggle');
    var $toggleLabel = $toggleBtn.find('.sb-toggle-label');

    function applyCollapse(isCollapsed) {
        $sidebar.toggleClass('collapsed', isCollapsed);
        $toggleLabel.text(isCollapsed ? 'Buka Sidebar' : 'Tutup Sidebar');
        localStorage.setItem('userSidebarCollapsed', isCollapsed ? '1' : '0');
    }

    // Restore dari localStorage
    var savedState = localStorage.getItem('userSidebarCollapsed');
    if (savedState === '1' && $(window).width() > 768) {
        applyCollapse(true);
    }

    $toggleBtn.on('click', function() {
        var isNowCollapsed = !$sidebar.hasClass('collapsed');
        applyCollapse(isNowCollapsed);
    });

    // ── 2. MOBILE: OVERLAY + HAMBURGER ──
    function ensureMobileElements() {
        if ($(window).width() <= 768) {
            // Tambah hamburger jika belum ada
            if ($('.mobile-menu-toggle').length === 0) {
                $('.topnav').prepend(
                    '<button class="mobile-menu-toggle" aria-label="Buka Menu">' +
                    '<i class="fas fa-bars"></i></button>'
                );
            }
            // Tambah overlay jika belum ada
            if ($('.sidebar-overlay').length === 0) {
                $('body').append('<div class="sidebar-overlay"></div>');
            }
        }
    }

    function openSidebar() {
        $sidebar.addClass('mobile-open');
        $('.sidebar-overlay').addClass('show');
        $('body').addClass('body-no-scroll');
    }

    function closeSidebar() {
        $sidebar.removeClass('mobile-open');
        $('.sidebar-overlay').removeClass('show');
        $('body').removeClass('body-no-scroll');
    }

    ensureMobileElements();

    // Hamburger click → buka sidebar
    $(document).on('click', '.mobile-menu-toggle', function(e) {
        e.preventDefault();
        openSidebar();
    });

    // Overlay click → tutup sidebar
    $(document).on('click', '.sidebar-overlay', function() {
        closeSidebar();
    });

    // Klik link di sidebar saat mobile → tutup sidebar setelah 150ms
    $(document).on('click', '.sidebar .sb-link', function() {
        if ($(window).width() <= 768) {
            setTimeout(closeSidebar, 150);
        }
    });

    // Resize handler: bersihkan state mobile jika layar membesar
    var resizeDebounce;
    $(window).on('resize', function() {
        clearTimeout(resizeDebounce);
        resizeDebounce = setTimeout(function() {
            if ($(window).width() > 768) {
                closeSidebar();
                // Pastikan collapse state sesuai localStorage
                var saved = localStorage.getItem('userSidebarCollapsed');
                if (saved === '1') {
                    $sidebar.addClass('collapsed');
                    $toggleLabel.text('Buka Sidebar');
                } else {
                    $sidebar.removeClass('collapsed');
                    $toggleLabel.text('Tutup Sidebar');
                }
            } else {
                ensureMobileElements();
            }
        }, 200);
    });

    // ── 3. BADGE POLLING ──
    function pollBadges() {
        $.ajax({
            url: '<?= base_url("user/get_notifications") ?>',
            type: 'GET',
            dataType: 'json',
            success: function(d) {
                var $b = $('#notifBadgeSidebar');
                if (d.unread_count > 0) {
                    $b.text(d.unread_count).show();
                } else {
                    $b.hide();
                }
            }
        });
        setTimeout(pollBadges, 10000);
    }
    pollBadges();

});
</script>