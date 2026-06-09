<?php
// ============================================================
// views/operator/sidebar.php — Responsive (Desktop Collapse + Mobile Slide)
// ============================================================
$ci =& get_instance();
$current_uri = trim($ci->uri->uri_string(), '/');
function op_is_active($uri) {
    global $current_uri;
    return (trim($uri, '/') === $current_uri) ? 'active' : '';
}
$op_nama = $ci->session->userdata('nama') ?? 'Operator';
?>

<style>
/* ── Operator Sidebar — mengikuti shared.css vars ── */
.op-sidebar {
    background: #ffffff;
    height: 100vh;
    width: 260px;
    position: fixed;
    top: 0; left: 0;
    transition: width 0.3s ease, transform 0.3s ease;
    z-index: 1000;
    display: flex;
    flex-direction: column;
    box-shadow: 2px 0 12px rgba(0,0,0,0.04);
    border-right: 1px solid #e9ecef;
}
.op-sidebar.collapsed { width: 70px; }

/* ── Logo ── */
.op-sidebar .sb-logo {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 18px 16px;
    border-bottom: 1px solid #e9ecef;
    flex-shrink: 0;
    overflow: hidden;
    text-decoration: none;
}
.op-sidebar .sb-logo img {
    width: 50px; height: 50px;
    object-fit: contain; flex-shrink: 0;
}
.op-sidebar .sb-logo-text {
    display: flex; flex-direction: column; overflow: hidden;
}
.op-sidebar .sb-logo-title {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 0.95rem; font-weight: 800;
    color: #1e6f5c; white-space: nowrap;
    letter-spacing: -0.02em; line-height: 1.2;
}
.op-sidebar .sb-logo-sub {
    font-size: 0.62rem; font-weight: 600;
    color: #94a3b8; text-transform: uppercase;
    letter-spacing: 0.06em; white-space: nowrap;
}
.op-sidebar.collapsed .sb-logo-text { display: none; }
.op-sidebar.collapsed .sb-logo { justify-content: center; }

/* ── Role badge ── */
.op-sidebar .sb-role {
    padding: 10px 16px;
    border-bottom: 1px solid #e9ecef;
    flex-shrink: 0;
    overflow: hidden;
}
.op-sidebar .sb-role-inner {
    display: flex; align-items: center; gap: 10px;
    background: #eff6ff;
    border-radius: 10px;
    padding: 8px 12px;
}
.op-sidebar .sb-role-icon {
    width: 28px; height: 28px; border-radius: 8px;
    background: #3b82f6; color: white;
    display: flex; align-items: center; justify-content: center;
    font-size: 11px; flex-shrink: 0;
}
.op-sidebar .sb-role-info { overflow: hidden; }
.op-sidebar .sb-role-name {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 0.75rem; font-weight: 700;
    color: #1e40af; white-space: nowrap;
    overflow: hidden; text-overflow: ellipsis;
}
.op-sidebar .sb-role-label {
    font-size: 0.62rem; font-weight: 600;
    color: #3b82f6; text-transform: uppercase;
    letter-spacing: 0.05em;
}
.op-sidebar.collapsed .sb-role { padding: 10px 12px; }
.op-sidebar.collapsed .sb-role-inner { justify-content: center; padding: 6px; }
.op-sidebar.collapsed .sb-role-info { display: none; }
.op-sidebar.collapsed .sb-role-icon { width: 32px; height: 32px; }

/* ── Menu area ── */
.op-sidebar .sb-menu {
    flex: 1; overflow-y: auto; overflow-x: hidden;
    padding: 8px 0;
}
.op-sidebar .sb-menu::-webkit-scrollbar { width: 3px; }
.op-sidebar .sb-menu::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 4px; }

/* ── Section heading ── */
.op-sidebar .sb-heading {
    padding: 8px 20px 4px;
    font-size: 0.62rem; font-weight: 700;
    text-transform: uppercase; letter-spacing: 0.08em;
    color: #cbd5e1; white-space: nowrap; overflow: hidden;
    font-family: 'Plus Jakarta Sans', sans-serif;
}
.op-sidebar.collapsed .sb-heading { visibility: hidden; height: 0; padding: 0; }

/* ── Divider ── */
.op-sidebar .sb-divider {
    margin: 6px 16px;
    border: none; border-top: 1px solid #f1f5f9;
}
.op-sidebar.collapsed .sb-divider { margin: 6px 10px; }

/* ── Nav link ── */
.op-sidebar .sb-link {
    display: flex; align-items: center; gap: 10px;
    padding: 9px 12px; margin: 2px 10px;
    border-radius: 10px;
    color: #64748b;
    text-decoration: none;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 0.82rem; font-weight: 600;
    white-space: nowrap; overflow: hidden;
    transition: background 0.15s, color 0.15s;
    position: relative;
}
.op-sidebar .sb-link .sb-icon {
    width: 30px; height: 30px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; flex-shrink: 0;
    background: #f8fafc; color: #94a3b8;
    transition: background 0.15s, color 0.15s;
}
.op-sidebar .sb-link span { overflow: hidden; text-overflow: ellipsis; }

.op-sidebar .sb-link:hover {
    background: #f0fdf4;
    color: #1e6f5c;
}
.op-sidebar .sb-link:hover .sb-icon {
    background: #dcfce7; color: #1e6f5c;
}
.op-sidebar .sb-link.active {
    background: #e6f4f0; color: #1e6f5c;
}
.op-sidebar .sb-link.active .sb-icon {
    background: #1e6f5c; color: white;
}
/* active indicator bar */
.op-sidebar .sb-link.active::before {
    content: '';
    position: absolute; left: -10px; top: 50%;
    transform: translateY(-50%);
    width: 3px; height: 18px;
    background: #1e6f5c; border-radius: 0 3px 3px 0;
}

/* ── Collapsed: hide text, center icon ── */
.op-sidebar.collapsed .sb-link {
    justify-content: center;
    padding: 9px 0; margin: 2px 10px;
}
.op-sidebar.collapsed .sb-link span { display: none; }
.op-sidebar.collapsed .sb-link .sb-icon { margin: 0; }

/* ── Tooltip on collapsed ── */
.op-sidebar.collapsed .sb-link { position: relative; }
.op-sidebar.collapsed .sb-link::after {
    content: attr(data-tooltip);
    position: absolute; left: calc(100% + 10px); top: 50%;
    transform: translateY(-50%);
    background: #1e293b; color: white;
    font-size: 0.72rem; font-weight: 600;
    padding: 4px 10px; border-radius: 6px;
    white-space: nowrap; pointer-events: none;
    opacity: 0; transition: opacity 0.15s;
    z-index: 9999;
}
.op-sidebar.collapsed .sb-link:hover::after { opacity: 1; }

/* ── Logout link — merah ── */
.op-sidebar .sb-link.sb-logout:hover { background: #fff1f2; color: #9f1239; }
.op-sidebar .sb-link.sb-logout:hover .sb-icon { background: #ffe4e6; color: #9f1239; }

/* ── Toggle button ── */
.op-sidebar .sb-toggle {
    border-top: 1px solid #e9ecef;
    flex-shrink: 0; padding: 8px 10px;
    background: #fafafa;
}
.op-sidebar .sb-toggle-btn {
    display: flex; align-items: center; gap: 10px;
    padding: 8px 10px; border-radius: 10px;
    cursor: pointer; background: none; border: none; width: 100%;
    color: #94a3b8;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 0.75rem; font-weight: 600;
    transition: background 0.15s, color 0.15s;
}
.op-sidebar .sb-toggle-btn:hover { background: #f1f5f9; color: #475569; }
.op-sidebar .sb-toggle-icon {
    width: 28px; height: 28px; border-radius: 8px;
    background: #f1f5f9; color: #94a3b8;
    display: flex; align-items: center; justify-content: center;
    font-size: 11px; flex-shrink: 0;
    transition: background 0.15s;
}
.op-sidebar.collapsed .sb-toggle-btn { justify-content: center; }
.op-sidebar.collapsed .sb-toggle-btn span { display: none; }

/* ── Page offset ── */
.page-wrapper { margin-left: 260px; transition: margin-left 0.3s ease; }
.op-sidebar.collapsed ~ .page-wrapper { margin-left: 70px; }

/* ── MOBILE OVERLAY & TOGGLE ── */
.mobile-menu-toggle {
    display: none;
    width: 36px; height: 36px;
    border-radius: 9px;
    border: 1px solid #e9ecef;
    background: #fff;
    align-items: center; justify-content: center;
    color: #64748b; font-size: 15px;
    cursor: pointer; flex-shrink: 0;
    transition: background .15s, color .15s;
}
.mobile-menu-toggle:hover { background: rgba(30,111,92,0.08); color: #1e6f5c; }

.sidebar-overlay {
    display: none;
    position: fixed; inset: 0;
    background: rgba(0,0,0,0.5);
    z-index: 999;
    backdrop-filter: blur(2px);
    -webkit-backdrop-filter: blur(2px);
}
.sidebar-overlay.show { display: block; }

.body-no-scroll { overflow: hidden !important; }

/* ── MOBILE BREAKPOINT ── */
@media (max-width: 768px) {
    .op-sidebar {
        transform: translateX(-100%);
        width: 280px !important;
        box-shadow: none;
    }
    .op-sidebar.mobile-open {
        transform: translateX(0);
        box-shadow: 4px 0 32px rgba(0,0,0,0.2);
    }
    /* Paksa semua teks tampil di mobile */
    .op-sidebar .sb-logo-text,
    .op-sidebar .sb-role-info,
    .op-sidebar .sb-heading,
    .op-sidebar .sb-link span,
    .op-sidebar .sb-toggle-btn span {
        display: block !important;
        opacity: 1 !important;
    }
    .op-sidebar .sb-link {
        justify-content: flex-start !important;
        padding: 9px 12px !important;
    }
    .op-sidebar .sb-toggle-btn {
        justify-content: flex-start !important;
    }
    .page-wrapper { margin-left: 0 !important; }
    .mobile-menu-toggle { display: flex; }
    .op-sidebar .sb-toggle { display: none; } /* hide collapse button on mobile */
}
</style>

<nav class="op-sidebar" id="operatorSidebar">

    <!-- Logo -->
    <a href="<?= base_url('operator/dashboard') ?>" class="sb-logo">
        <img src="<?= base_url('assets/images/logo_bekasi.png') ?>" alt="Logo Bekasi">
        <div class="sb-logo-text">
            <div class="sb-logo-title">SITLAKEB TKA</div>
            <div class="sb-logo-sub">Kota Bekasi</div>
        </div>
    </a>

    <!-- Role badge -->
    <div class="sb-role">
        <div class="sb-role-inner">
            <div class="sb-role-icon"><i class="fas fa-headset"></i></div>
            <div class="sb-role-info">
                <div class="sb-role-name"><?= htmlspecialchars($op_nama) ?></div>
                <div class="sb-role-label">Operator</div>
            </div>
        </div>
    </div>

    <!-- Menu -->
    <div class="sb-menu">

        <!-- Dashboard -->
        <a href="<?= base_url('operator/dashboard') ?>"
           class="sb-link <?= op_is_active('operator/dashboard') ?>"
           data-tooltip="Dashboard">
            <div class="sb-icon"><i class="fas fa-gauge-high"></i></div>
            <span>Dashboard</span>
        </a>

        <hr class="sb-divider">
        <div class="sb-heading">Surat & Notifikasi</div>

        <a href="<?= base_url('operator/semua_tka') ?>"
           class="sb-link <?= op_is_active('operator/semua_tka') ?>"
           data-tooltip="Semua Pengajuan">
            <div class="sb-icon"><i class="fas fa-file-alt"></i></div>
            <span>Semua Pengajuan</span>
        </a>

        <a href="<?= base_url('operator/kirim_notifikasi') ?>"
           class="sb-link <?= op_is_active('operator/kirim_notifikasi') ?>"
           data-tooltip="Kirim Notifikasi">
            <div class="sb-icon"><i class="fas fa-bell"></i></div>
            <span>Kirim Notifikasi</span>
        </a>

        <hr class="sb-divider">

        <a href="<?= base_url('auth/logout') ?>"
           class="sb-link sb-logout"
           data-tooltip="Logout"
           onclick="return confirm('Yakin ingin keluar?')">
            <div class="sb-icon"><i class="fas fa-right-from-bracket"></i></div>
            <span>Logout</span>
        </a>

    </div><!-- /sb-menu -->

    <!-- Toggle button (desktop only) -->
    <div class="sb-toggle">
        <button class="sb-toggle-btn" id="opSidebarToggle">
            <div class="sb-toggle-icon">
                <i class="fas fa-chevron-left" id="opToggleChevron"></i>
            </div>
            <span>Tutup Sidebar</span>
        </button>
    </div>

</nav>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {

    var $sidebar = $('#operatorSidebar');
    var $toggleBtn = $('#opSidebarToggle');
    var $chevron = $('#opToggleChevron');

    // ── 1. DESKTOP COLLAPSE ──
    function applyCollapse(isCollapsed) {
        $sidebar.toggleClass('collapsed', isCollapsed);
        if ($chevron.length) {
            $chevron.css('transform', isCollapsed ? 'rotate(180deg)' : 'rotate(0deg)');
        }
        localStorage.setItem('opSidebarCollapsed', isCollapsed ? '1' : '0');
    }

    var savedState = localStorage.getItem('opSidebarCollapsed');
    if (savedState === '1' && $(window).width() > 768) {
        applyCollapse(true);
    }

    $toggleBtn.on('click', function(e) {
        e.preventDefault();
        applyCollapse(!$sidebar.hasClass('collapsed'));
    });

    // ── 2. MOBILE TOGGLE & OVERLAY ──
    function ensureMobileElements() {
        if ($(window).width() <= 768) {
            if ($('.mobile-menu-toggle').length === 0) {
                $('.topnav').prepend(
                    '<button class="mobile-menu-toggle" aria-label="Buka Menu">' +
                    '<i class="fas fa-bars"></i></button>'
                );
            }
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

    $(document).on('click', '.mobile-menu-toggle', function(e) {
        e.preventDefault();
        openSidebar();
    });

    $(document).on('click', '.sidebar-overlay', function() {
        closeSidebar();
    });

    $(document).on('click', '.op-sidebar .sb-link', function() {
        if ($(window).width() <= 768) {
            setTimeout(closeSidebar, 150);
        }
    });

    var resizeDebounce;
    $(window).on('resize', function() {
        clearTimeout(resizeDebounce);
        resizeDebounce = setTimeout(function() {
            if ($(window).width() > 768) {
                closeSidebar();
                var saved = localStorage.getItem('opSidebarCollapsed');
                if (saved === '1') {
                    $sidebar.addClass('collapsed');
                    $chevron.css('transform', 'rotate(180deg)');
                } else {
                    $sidebar.removeClass('collapsed');
                    $chevron.css('transform', 'rotate(0deg)');
                }
            } else {
                ensureMobileElements();
            }
        }, 200);
    });

});
</script>