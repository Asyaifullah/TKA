<?php
/**
 * views/admin/sidebar.php
 * Sidebar admin SITLAKEB TKA — kompatibel dengan dashboard yang punya topnav burger.
 */

 $ci =& get_instance();
 $current_uri = trim($ci->uri->uri_string(), '/');

/**
 * Cek apakah menu aktif.
 * Logika: cocokkan EXACT atau PREFIX (diikuti "/")
 * Contoh:
 *   - URI: "admin/manage_officers"          → menu "admin/manage_officers" → AKTIF
 *   - URI: "admin/manage_officers/edit/5"   → menu "admin/manage_officers" → AKTIF
 *   - URI: "admin/manage_officers"          → menu "admin/manage_users"    → TIDAK
 */
function adm_is_active($uri)
{
    global $current_uri;
    $uri = trim($uri, '/');

    // Exact match
    if ($uri === $current_uri) {
        return 'active';
    }

    // Prefix match: URI saat ini dimulai dengan $uri lalu "/" (sub-halaman)
    if (strpos($current_uri, $uri . '/') === 0) {
        return 'active';
    }

    return '';
}

 $nama_admin = $ci->session->userdata('nama') ?? 'Admin';
 $role_admin = 'ADMIN';
?>

<style>
/* ============================================================
   1. FONT & VARIABLES
   ============================================================ */
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

:root {
    --sidebar-bg: #ffffff;
    --sidebar-border: #e9ecef;
    --sidebar-accent: #1e6f5c;
    --sidebar-accent-soft: #e6f4f0;
    --sidebar-muted: #64748b;
    --sidebar-icon-bg: #f8fafc;
    --sidebar-icon-color: #94a3b8;
    --sidebar-danger: #f43f5e;
    --sb-width-expanded: 260px;
    --sb-width-collapsed: 70px;
}

/* ============================================================
   2. SIDEBAR UTAMA
   ============================================================ */
.admin-sidebar {
    background: var(--sidebar-bg);
    height: 100vh;
    width: var(--sb-width-expanded);
    position: fixed;
    top: 0;
    left: 0;
    display: flex;
    flex-direction: column;
    border-right: 1px solid var(--sidebar-border);
    box-shadow: 2px 0 12px rgba(0, 0, 0, 0.04);
    font-family: 'Plus Jakarta Sans', sans-serif;
    transition: width 0.3s ease, transform 0.3s ease;
    z-index: 1000;
}

.admin-sidebar.collapsed {
    width: var(--sb-width-collapsed);
}

/* --- Logo --- */
.admin-sidebar .sb-logo {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 20px 20px;
    border-bottom: 1px solid var(--sidebar-border);
    text-decoration: none;
}

.admin-sidebar .sb-logo img {
    width: 50px;
    height: 50px;
    object-fit: contain;
}

.admin-sidebar .sb-logo-text {
    display: flex;
    flex-direction: column;
}

.admin-sidebar .sb-logo-title {
    font-size: 0.95rem;
    font-weight: 800;
    color: var(--sidebar-accent);
    white-space: nowrap;
}

.admin-sidebar .sb-logo-sub {
    font-size: 0.62rem;
    font-weight: 600;
    color: #94a3b8;
    text-transform: uppercase;
}

.admin-sidebar.collapsed .sb-logo-text {
    display: none;
}

.admin-sidebar.collapsed .sb-logo {
    justify-content: center;
}

/* --- Role badge --- */
.admin-sidebar .sb-role {
    padding: 10px 16px;
    border-bottom: 1px solid var(--sidebar-border);
}

.admin-sidebar .sb-role-inner {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #eff6ff;
    border-radius: 10px;
    padding: 8px 12px;
}

.admin-sidebar .sb-role-icon {
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    background: #3b82f6;
    color: white;
    font-size: 11px;
}

.admin-sidebar .sb-role-name {
    font-size: 0.75rem;
    font-weight: 700;
    color: #1e40af;
}

.admin-sidebar .sb-role-label {
    font-size: 0.62rem;
    font-weight: 600;
    color: #3b82f6;
    text-transform: uppercase;
}

.admin-sidebar.collapsed .sb-role {
    padding: 10px 12px;
}

.admin-sidebar.collapsed .sb-role-inner {
    justify-content: center;
    padding: 6px;
}

.admin-sidebar.collapsed .sb-role-info {
    display: none;
}

/* --- Menu scroll area --- */
.admin-sidebar .sb-menu {
    flex: 1;
    overflow-y: auto;
    padding: 8px 0;
}

.admin-sidebar .sb-menu::-webkit-scrollbar {
    width: 3px;
}

.admin-sidebar .sb-menu::-webkit-scrollbar-thumb {
    background: #e2e8f0;
    border-radius: 4px;
}

/* --- Section heading (collapsible group) --- */
.admin-sidebar .sb-section {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px 20px 4px 16px;
    margin-top: 4px;
    cursor: pointer;
    user-select: none;
}

.admin-sidebar .sb-heading {
    flex: 1;
    font-size: 0.62rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: #cbd5e1;
    transition: color 0.15s;
}

/* Highlight judul section yang sedang berisi menu aktif */
.admin-sidebar .sb-heading.sb-heading-active {
    color: var(--sidebar-accent);
    font-weight: 800;
}

.admin-sidebar .sb-icon-dot {
    display: inline-block;
    width: 5px;
    height: 5px;
    margin-left: 6px;
    border-radius: 50%;
    background: var(--sidebar-accent);
}

.admin-sidebar .sb-section .toggle-icon {
    width: 18px;
    text-align: center;
    font-size: 9px;
    color: #cbd5e1;
    transition: transform 0.2s;
}

.admin-sidebar .sb-section.collapsed .toggle-icon {
    transform: rotate(-90deg);
}

.admin-sidebar.collapsed .sb-section {
    height: 0;
    padding: 0;
    margin: 0;
    visibility: hidden;
}

.admin-sidebar .sb-section-group {
    overflow: hidden;
    transition: max-height 0.2s ease-out;
}

.admin-sidebar .sb-section-group.collapsed {
    max-height: 0 !important;
}

/* --- Divider --- */
.admin-sidebar .sb-divider {
    margin: 6px 16px;
    border: none;
    border-top: 1px solid #f1f5f9;
}

.admin-sidebar.collapsed .sb-divider {
    margin: 6px 10px;
}

/* --- Nav link --- */
.admin-sidebar .sb-link {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 9px 12px;
    margin: 2px 10px;
    border-radius: 10px;
    color: var(--sidebar-muted);
    text-decoration: none;
    font-size: 0.82rem;
    font-weight: 600;
    white-space: nowrap;
    position: relative;
    transition: background 0.15s, color 0.15s, box-shadow 0.15s;
}

.admin-sidebar .sb-link .sb-icon {
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    background: var(--sidebar-icon-bg);
    color: var(--sidebar-icon-color);
    font-size: 12px;
    flex-shrink: 0;
    transition: background 0.15s, color 0.15s;
}

.admin-sidebar .sb-link:hover {
    background: #f0fdf4;
    color: var(--sidebar-accent);
}

.admin-sidebar .sb-link:hover .sb-icon {
    background: #dcfce7;
    color: var(--sidebar-accent);
}

/* ============================================================
   ACTIVE STATE
   ============================================================ */
.admin-sidebar .sb-link.active {
    background: var(--sidebar-accent);
    color: #ffffff;
    font-weight: 700;
    box-shadow: 0 4px 10px rgba(30, 111, 92, 0.25);
}

.admin-sidebar .sb-link.active .sb-icon {
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

.admin-sidebar .sb-link.active::before {
    content: '';
    position: absolute;
    left: -10px;
    top: 50%;
    width: 3px;
    height: 18px;
    background: var(--sidebar-accent);
    border-radius: 0 3px 3px 0;
    transform: translateY(-50%);
}

.admin-sidebar .sb-link.active::after {
    content: '';
    position: absolute;
    right: 12px;
    top: 50%;
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.7);
    transform: translateY(-50%);
}

/* Collapsed mode: tooltip saat hover */
.admin-sidebar.collapsed .sb-link {
    justify-content: center;
    padding: 9px 0;
    margin: 2px 10px;
}

.admin-sidebar.collapsed .sb-link span:not(.sb-badge) {
    display: none;
}

.admin-sidebar.collapsed .sb-link.active::after {
    display: none;
}

.admin-sidebar.collapsed .sb-link::after {
    content: attr(data-tooltip);
    position: absolute;
    left: calc(100% + 10px);
    top: 50%;
    padding: 4px 10px;
    border-radius: 6px;
    background: #1e293b;
    color: white;
    font-size: 0.72rem;
    white-space: nowrap;
    opacity: 0;
    pointer-events: none;
    transform: translateY(-50%);
    transition: opacity 0.15s;
    z-index: 9999;
    width: auto;
    height: auto;
    border-radius: 6px;
    background: #1e293b;
}

.admin-sidebar.collapsed .sb-link:hover::after {
    opacity: 1;
}

/* --- Logout (merah) --- */
.admin-sidebar .sb-link.sb-logout:hover {
    background: #fff1f2;
    color: #9f1239;
}

.admin-sidebar .sb-link.sb-logout:hover .sb-icon {
    background: #ffe4e6;
    color: #9f1239;
}

/* --- Toggle collapse (desktop) --- */
.admin-sidebar .sb-toggle {
    padding: 8px 10px;
    background: #fafafa;
    border-top: 1px solid var(--sidebar-border);
}

.admin-sidebar .sb-toggle-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    width: 100%;
    padding: 8px 10px;
    border: none;
    border-radius: 10px;
    background: none;
    color: #94a3b8;
    font-size: 0.75rem;
    font-weight: 600;
    cursor: pointer;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

.admin-sidebar .sb-toggle-btn:hover {
    background: #f1f5f9;
    color: #475569;
}

.admin-sidebar .sb-toggle-icon {
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    background: #f1f5f9;
    font-size: 11px;
    flex-shrink: 0;
}

.admin-sidebar.collapsed .sb-toggle-btn {
    justify-content: center;
}

.admin-sidebar.collapsed .sb-toggle-btn span {
    display: none;
}

/* ============================================================
   3. OVERLAY (mobile)
   ============================================================ */
.sidebar-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(2px);
    z-index: 999;
}

.sidebar-overlay.show {
    display: block;
}

.body-no-scroll {
    overflow: hidden !important;
}

/* ============================================================
   4. MOBILE
   ============================================================ */
@media (max-width: 768px) {
    .admin-sidebar {
        width: 280px !important;
        transform: translateX(-100%);
    }

    .admin-sidebar.mobile-open {
        transform: translateX(0);
        box-shadow: 4px 0 32px rgba(0, 0, 0, 0.2);
    }

    .admin-sidebar .sb-logo-text,
    .admin-sidebar .sb-role-info,
    .admin-sidebar .sb-heading,
    .admin-sidebar .sb-link span,
    .admin-sidebar .sb-toggle-btn span {
        display: block !important;
    }

    .admin-sidebar .sb-link,
    .admin-sidebar .sb-toggle-btn {
        justify-content: flex-start !important;
        padding: 9px 12px !important;
    }

    .admin-sidebar.collapsed .sb-section {
        height: auto !important;
        padding: 8px 20px 4px 16px !important;
        visibility: visible !important;
    }

    .admin-sidebar .sb-toggle {
        display: none;
    }
}
</style>

<!-- Overlay untuk mobile -->
<div class="sidebar-overlay" id="adminOverlay"></div>

<nav class="admin-sidebar" id="adminSidebar">

    <!-- Logo -->
    <a href="<?= base_url('dashboard') ?>" class="sb-logo">
        <img src="<?= base_url('assets/images/logo_kota_bekasi.png') ?>" alt="Logo Bekasi">
        <div class="sb-logo-text">
            <div class="sb-logo-title">SITLAKEB TKA</div>
            <div class="sb-logo-sub">Disnaker Kota Bekasi</div>
        </div>
    </a>

    <!-- Role badge -->
    <div class="sb-role">
        <div class="sb-role-inner">
            <div class="sb-role-icon"><i class="fas fa-user-shield"></i></div>
            <div class="sb-role-info">
                <div class="sb-role-name"><?= htmlspecialchars($nama_admin) ?></div>
                <div class="sb-role-label">Admin</div>
            </div>
        </div>
    </div>

    <div class="sb-menu">

        <!-- Dashboard -->
        <a href="<?= base_url('dashboard') ?>"
           class="sb-link <?= adm_is_active('dashboard') ?>"
           data-tooltip="Dashboard">
            <div class="sb-icon"><i class="fas fa-tachometer-alt"></i></div>
            <span>Dashboard</span>
        </a>
        <hr class="sb-divider">

        <!-- Section: Instansi -->
        <div class="sb-section" data-section="instansi">
            <div class="sb-heading">Instansi<span class="sb-icon-dot"></span></div>
            <div class="toggle-icon"><i class="fas fa-chevron-down"></i></div>
        </div>
        <div class="sb-section-group" data-group="instansi">
            <a href="<?= base_url('admin/manage_officers') ?>"
               class="sb-link <?= adm_is_active('admin/manage_officers') ?>"
               data-tooltip="Manajemen Petugas">
                <div class="sb-icon"><i class="fas fa-users-gear"></i></div>
                <span>Manajemen Petugas</span>
            </a>
            <a href="<?= base_url('admin/upload_ttd') ?>"
               class="sb-link <?= adm_is_active('admin/upload_ttd') ?>"
               data-tooltip="Pengaturan Surat & TTD">
                <div class="sb-icon"><i class="fas fa-stamp"></i></div>
                <span>Pengaturan Surat & TTD</span>
            </a>
            <a href="<?= base_url('admin/sla') ?>"
               class="sb-link <?= adm_is_active('admin/sla') ?>"
               data-tooltip="Pengaturan SLA">
                <div class="sb-icon"><i class="fas fa-clock"></i></div>
                <span>Pengaturan SLA</span>
            </a>
        </div>

        <!-- Section: Perusahaan -->
        <div class="sb-section" data-section="perusahaan">
            <div class="sb-heading">Perusahaan<span class="sb-icon-dot"></span></div>
            <div class="toggle-icon"><i class="fas fa-chevron-down"></i></div>
        </div>
        <div class="sb-section-group" data-group="perusahaan">
            <a href="<?= base_url('admin/manage_users') ?>"
               class="sb-link <?= adm_is_active('admin/manage_users') ?>"
               data-tooltip="Manajemen Perusahaan">
                <div class="sb-icon"><i class="fas fa-users-cog"></i></div>
                <span>Manajemen Perusahaan</span>
            </a>
            <a href="<?= base_url('admin/perusahaan') ?>"
               class="sb-link <?= adm_is_active('admin/perusahaan') ?>"
               data-tooltip="Daftar Perusahaan">
                <div class="sb-icon"><i class="fas fa-building"></i></div>
                <span>Daftar Perusahaan</span>
            </a>
            <a href="<?= base_url('admin/semua_tka') ?>"
               class="sb-link <?= adm_is_active('admin/semua_tka') ?>"
               data-tooltip="Semua TKA">
                <div class="sb-icon"><i class="fas fa-id-badge"></i></div>
                <span>Semua TKA</span>
            </a>
        </div>

        <!-- Section: Komunikasi -->
        <div class="sb-section" data-section="komunikasi">
            <div class="sb-heading">Komunikasi<span class="sb-icon-dot"></span></div>
            <div class="toggle-icon"><i class="fas fa-chevron-down"></i></div>
        </div>
        <div class="sb-section-group" data-group="komunikasi">
            <a href="<?= base_url('admin/kirim_notifikasi') ?>"
               class="sb-link <?= adm_is_active('admin/kirim_notifikasi') ?>"
               data-tooltip="Kirim Notifikasi">
                <div class="sb-icon"><i class="fas fa-paper-plane"></i></div>
                <span>Kirim Notifikasi</span>
            </a>
            <a href="<?= base_url('chat') ?>"
               class="sb-link <?= adm_is_active('chat') ?>"
               data-tooltip="Chat Perusahaan"
               style="position: relative;">
                <div class="sb-icon"><i class="fas fa-comment-dots"></i></div>
                <span>Chat Perusahaan</span>
                <span id="chatBadge" class="sb-badge" style="display: none;">0</span>
            </a>
        </div>

        <!-- Section: Lainnya -->
        <div class="sb-section" data-section="lainnya">
            <div class="sb-heading">Lainnya<span class="sb-icon-dot"></span></div>
            <div class="toggle-icon"><i class="fas fa-chevron-down"></i></div>
        </div>
        <div class="sb-section-group" data-group="lainnya">
            <a href="<?= base_url('admin/laporan') ?>"
               class="sb-link <?= adm_is_active('admin/laporan') ?>"
               data-tooltip="Laporan Bulanan">
                <div class="sb-icon"><i class="fas fa-chart-line"></i></div>
                <span>Laporan Bulanan</span>
            </a>
            <a href="<?= base_url('admin/logs') ?>"
               class="sb-link <?= adm_is_active('admin/logs') ?>"
               data-tooltip="Log Aktivitas">
                <div class="sb-icon"><i class="fas fa-scroll"></i></div>
                <span>Log Aktivitas</span>
            </a>
        </div>

        <hr class="sb-divider">

        <a href="<?= base_url('auth/logout') ?>"
           class="sb-link sb-logout"
           data-tooltip="Logout"
           onclick="return confirm('Yakin ingin keluar?')">
            <div class="sb-icon"><i class="fas fa-right-from-bracket"></i></div>
            <span>Logout</span>
        </a>
    </div>

    <!-- Toggle collapse sidebar (desktop only) -->
    <div class="sb-toggle">
        <button class="sb-toggle-btn" id="adminSidebarToggle">
            <div class="sb-toggle-icon"><i class="fas fa-chevron-left" id="adminToggleChevron"></i></div>
            <span>Tutup Sidebar</span>
        </button>
    </div>
</nav>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
 $(document).ready(function () {
    var $sidebar = $('#adminSidebar');
    var $toggleBtn = $('#adminSidebarToggle');
    var $chevron = $('#adminToggleChevron');

    // ========================================================
    // 1. MARGIN KONTEN MENYESUAIKAN LEBAR SIDEBAR
    // ========================================================
    function adjustContentMargin() {
        var isMobile = $(window).width() <= 768;
        var sidebarWidth = $sidebar.hasClass('collapsed') ? 70 : 260;
        if (isMobile) sidebarWidth = 0;

        var $wrapper = $('.page-wrapper');
        if ($wrapper.length === 0) {
            $wrapper = $('body').children().not('.admin-sidebar, .sidebar-overlay').first();
        }
        $wrapper.css('margin-left', sidebarWidth + 'px');
    }

    // ========================================================
    // 2. COLLAPSE SIDEBAR (DESKTOP)
    // ========================================================
    function applyCollapse(isCollapsed) {
        $sidebar.toggleClass('collapsed', isCollapsed);

        if ($chevron.length) {
            $chevron.css('transform', isCollapsed ? 'rotate(180deg)' : 'rotate(0deg)');
        }

        localStorage.setItem('adminSidebarCollapsed', isCollapsed ? '1' : '0');
        adjustContentMargin();
        $(window).trigger('resize');
    }

    var savedCollapse = localStorage.getItem('adminSidebarCollapsed');
    if (savedCollapse === '1' && $(window).width() > 768) {
        applyCollapse(true);
    } else {
        adjustContentMargin();
    }

    $toggleBtn.on('click', function (e) {
        e.preventDefault();
        if ($(window).width() > 768) {
            applyCollapse(!$sidebar.hasClass('collapsed'));
        }
    });

    // ========================================================
    // 3. COLLAPSE/EXPAND PER SECTION + AUTO-HIGHLIGHT SECTION AKTIF
    // ========================================================
    function initSectionToggle() {
        $('.sb-section').each(function () {
            var $section = $(this);
            var sectionName = $section.data('section');
            var $group = $('.sb-section-group[data-group="' + sectionName + '"]');

            // Cek apakah section ini memuat link yang sedang aktif
            var hasActiveLink = $group.find('.sb-link.active').length > 0;
            var isCollapsed = localStorage.getItem('adminSection_' + sectionName) === '1';

            // Section yang berisi menu aktif WAJIB terbuka & ditandai
            if (hasActiveLink) {
                isCollapsed = false;
                $section.addClass('sb-section-has-active');
                $section.find('.sb-heading').addClass('sb-heading-active');
            } else {
                $section.removeClass('sb-section-has-active');
                $section.find('.sb-heading').removeClass('sb-heading-active');
            }

            if (isCollapsed) {
                $section.addClass('collapsed');
                $group.addClass('collapsed').css('max-height', '0');
            } else {
                $section.removeClass('collapsed');
                $group.removeClass('collapsed').css('max-height', $group[0].scrollHeight + 'px');
            }

            $section.off('click').on('click', function (e) {
                e.stopPropagation();

                var $this = $(this);
                var $targetGroup = $('.sb-section-group[data-group="' + sectionName + '"]');

                if ($this.hasClass('collapsed')) {
                    $this.removeClass('collapsed');
                    $targetGroup.removeClass('collapsed').css('max-height', $targetGroup[0].scrollHeight + 'px');
                    localStorage.setItem('adminSection_' + sectionName, '0');
                } else {
                    $this.addClass('collapsed');
                    $targetGroup.addClass('collapsed').css('max-height', '0');
                    localStorage.setItem('adminSection_' + sectionName, '1');
                }
            });
        });
    }
    initSectionToggle();

    $(window).on('resize', function () {
        $('.sb-section-group:not(.collapsed)').each(function () {
            $(this).css('max-height', this.scrollHeight + 'px');
        });
        adjustContentMargin();
    });

    // ========================================================
    // 4. MOBILE SLIDE
    // ========================================================
    window.openAdminSidebar = function () {
        $sidebar.addClass('mobile-open');
        $('#adminOverlay').addClass('show');
        $('body').addClass('body-no-scroll');
    };

    window.closeAdminSidebar = function () {
        $sidebar.removeClass('mobile-open');
        $('#adminOverlay').removeClass('show');
        $('body').removeClass('body-no-scroll');
    };

    $('#adminOverlay').on('click', function () {
        window.closeAdminSidebar();
    });

    $('.admin-sidebar .sb-link').on('click', function () {
        if ($(window).width() <= 768) {
            setTimeout(window.closeAdminSidebar, 150);
        }
    });

    // ========================================================
    // 5. RESIZE HANDLER (DEBOUNCED)
    // ========================================================
    var resizeTimer;
    $(window).on('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function () {
            if ($(window).width() > 768) {
                window.closeAdminSidebar();

                var saved = localStorage.getItem('adminSidebarCollapsed');
                if (saved === '1') {
                    $sidebar.addClass('collapsed');
                    $chevron.css('transform', 'rotate(180deg)');
                } else {
                    $sidebar.removeClass('collapsed');
                    $chevron.css('transform', 'rotate(0deg)');
                }

                adjustContentMargin();

                $('.sb-section-group:not(.collapsed)').each(function () {
                    $(this).css('max-height', this.scrollHeight + 'px');
                });
            } else {
                $sidebar.removeClass('collapsed');
                adjustContentMargin();
                window.closeAdminSidebar();
            }
        }, 200);
    });

    // ========================================================
    // 6. CHAT BADGE POLLING
    // ========================================================
    function pollChat() {
        $.ajax({
            url: '<?= base_url("chat/unread_count") ?>',
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                var $badge = $('#chatBadge');
                if (data.unread > 0) {
                    $badge.text(data.unread).css({
                        'display': 'inline-flex',
                        'align-items': 'center',
                        'justify-content': 'center',
                        'margin-left': 'auto',
                        'background': 'var(--sidebar-danger)',
                        'color': '#fff',
                        'border-radius': '9px',
                        'min-width': '16px',
                        'height': '16px',
                        'padding': '0 4px',
                        'font-size': '8px',
                        'font-weight': '700'
                    }).show();
                } else {
                    $badge.hide();
                }
            },
            error: function () {
                setTimeout(pollChat, 15000);
            }
        });
        setTimeout(pollChat, 10000);
    }
    pollChat();
});
</script>