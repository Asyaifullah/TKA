<?php
// ============================================================
// views/approval/sidebar.php — Responsive (Desktop Tetap Aman)
// ============================================================
$nama_admin = $this->session->userdata('nama') ?? 'Approval';
$role_admin = strtoupper($this->session->userdata('role') ?? 'approval');
$initials   = strtoupper(mb_substr($nama_admin, 0, 1, 'UTF-8'));
$current    = trim(uri_string(), '/');
function appr_active($uri) {
    global $current;
    return (trim($uri, '/') === $current) ? 'active' : '';
}
?>

<style>
/* ══════════════════════════════════════════════════
   APPROVAL SIDEBAR — Light / White Theme (mirip admin)
   ══════════════════════════════════════════════════ */
:root {
    --sb-bg:         #ffffff;
    --sb-surface:    #f8fafc;
    --sb-border:     #e9ecef;
    --sb-accent:     #1e6f5c;
    --sb-accent-dim: rgba(30,111,92,0.08);
    --sb-accent-mid: rgba(30,111,92,0.15);
    --sb-text:       #1e293b;
    --sb-muted:      #64748b;
    --sb-faint:      #94a3b8;
    --sb-danger:     #f43f5e;
    --sb-width:      252px;
    --sb-width-col:  66px;
    --sb-r:          9px;
    --sb-tr:         0.26s cubic-bezier(.4,0,.2,1);
    --sb-shadow:     2px 0 12px rgba(0,0,0,0.05);
}

/* ── Base ── */
.sidebar {
    position: fixed;
    top: 0; left: 0;
    width: var(--sb-width);
    height: 100vh;
    background: var(--sb-bg);
    display: flex;
    flex-direction: column;
    z-index: 1000;
    transition: width var(--sb-tr), transform var(--sb-tr);
    overflow: hidden;
    font-family: 'Inter', sans-serif;
    border-right: 1px solid var(--sb-border);
    box-shadow: var(--sb-shadow);
}
/* top accent stripe */
.sidebar::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--sb-accent) 0%, #2a9d7f 100%);
    pointer-events: none; z-index: 1;
}
.sidebar.collapsed { width: var(--sb-width-col); }

/* ── Brand (PENGATURAN DISAMAKAN DENGAN SIDEBAR OPERATOR) ── */
.sb-brand {
    display: flex; 
    align-items: center; 
    gap: 10px;
    padding: 18px 16px; /* Menyamakan padding dengan sidebar operator */
    border-bottom: 1px solid var(--sb-border);
    flex-shrink: 0;
    overflow: hidden;
    text-decoration: none;
}
.sb-brand img { 
    width: 50px; 
    height: 50px; 
    object-fit: contain; 
    flex-shrink: 0; /* Menghilangkan pembungkus .sb-brand-mark dan langsung menerapkan gaya ke gambar seperti operator */
}
.sb-brand-text { 
    display: flex; 
    flex-direction: column; 
    overflow: hidden; 
}
.sb-brand-name {
    display: block; font-size: 0.95rem; font-weight: 800; /* Menyamakan font-size dan weight dengan operator */
    color: var(--sb-accent); letter-spacing: -0.02em; line-height: 1.2;
    white-space: nowrap;
}
.sb-brand-sub {
    display: block; font-size: 0.62rem; font-weight: 600; /* Menyamakan sub-text style dengan operator */
    color: #94a3b8; text-transform: uppercase;
    letter-spacing: 0.06em; white-space: nowrap;
}
.sidebar.collapsed .sb-brand-text { display: none; }
.sidebar.collapsed .sb-brand { justify-content: center; }

/* ── User chip ── */
.sb-user {
    display: flex; align-items: center; gap: 9px;
    padding: 10px 14px;
    border-bottom: 1px solid var(--sb-border);
    background: var(--sb-surface);
    flex-shrink: 0;
}
.sb-user-avatar {
    width: 30px; height: 30px; border-radius: 9px;
    background: var(--sb-accent-dim);
    border: 1px solid var(--sb-accent-mid);
    color: var(--sb-accent);
    font-size: 0.7rem; font-weight: 800;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.sb-user-name {
    font-size: 0.74rem; font-weight: 700;
    color: var(--sb-text);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.sb-user-role {
    font-size: 0.59rem; font-weight: 500;
    color: var(--sb-muted);
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
    color: var(--sb-faint);
    padding: 12px 18px 4px; white-space: nowrap;
}
.sidebar.collapsed .sb-section { display: none; }

/* Divider */
.sb-divider { height: 1px; background: var(--sb-border); margin: 4px 12px; }

/* Nav link */
.sb-link {
    display: flex; align-items: center; gap: 9px;
    padding: 8px 10px; margin: 1px 9px;
    border-radius: var(--sb-r);
    color: var(--sb-muted); text-decoration: none;
    font-size: 0.79rem; font-weight: 500;
    white-space: nowrap;
    transition: background var(--sb-tr), color var(--sb-tr);
    position: relative;
}
.sb-link:hover {
    background: var(--sb-surface);
    color: var(--sb-text);
    text-decoration: none;
}
.sb-link.active {
    background: var(--sb-accent-dim);
    color: var(--sb-accent);
    font-weight: 600;
}
.sb-link.active::after {
    content: '';
    position: absolute;
    left: 0; top: 22%; bottom: 22%;
    width: 2.5px; background: var(--sb-accent);
    border-radius: 0 2px 2px 0;
}

/* Nav icon */
.sb-icon {
    width: 30px; height: 30px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.76rem; flex-shrink: 0;
    background: #f1f5f9;
    color: inherit;
    transition: background var(--sb-tr), color var(--sb-tr);
}
.sb-link:hover .sb-icon  { background: #e2e8f0; color: var(--sb-text); }
.sb-link.active .sb-icon { background: var(--sb-accent-mid); color: var(--sb-accent); }

/* Nav label */
.sb-label { flex: 1; line-height: 1; }
.sidebar.collapsed .sb-label { display: none; }

/* Badge */
.sb-badge {
    min-width: 17px; height: 17px;
    background: var(--sb-danger);
    color: #fff; font-size: 8px; font-weight: 700;
    border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    padding: 0 4px; flex-shrink: 0;
}
.sidebar.collapsed .sb-badge {
    position: absolute; top: 4px; right: 4px;
    min-width: 13px; height: 13px; font-size: 7px;
}

/* Logout khusus */
.sb-link.sb-logout:hover {
    background: #fff1f2; color: #e11d48;
}
.sb-link.sb-logout:hover .sb-icon {
    background: #ffe4e6; color: #e11d48;
}

/* Collapsed state centering */
.sidebar.collapsed .sb-link {
    justify-content: center; padding: 8px; margin: 1px 9px;
}
.sidebar.collapsed .sb-link .sb-icon { margin: 0; }

/* ── Toggle button ── */
.sb-toggle {
    flex-shrink: 0;
    border-top: 1px solid var(--sb-border);
    padding: 8px 9px;
    background: var(--sb-bg);
}
.sb-toggle-btn {
    display: flex; align-items: center; gap: 9px;
    width: 100%; padding: 8px 10px;
    border-radius: var(--sb-r);
    background: transparent; border: none; cursor: pointer;
    color: var(--sb-muted);
    font-family: 'Inter', sans-serif;
    font-size: 0.74rem; font-weight: 500;
    transition: background var(--sb-tr), color var(--sb-tr);
    white-space: nowrap;
}
.sb-toggle-btn:hover { background: var(--sb-surface); color: var(--sb-text); }
.sb-toggle-icon {
    width: 30px; height: 30px; border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.7rem; flex-shrink: 0;
    background: #f1f5f9;
    transition: background var(--sb-tr), transform var(--sb-tr);
}
.sb-toggle-btn:hover .sb-toggle-icon { background: #e2e8f0; }
.sidebar.collapsed .sb-toggle-icon { transform: rotate(180deg); }
.sb-toggle-label { line-height: 1; }
.sidebar.collapsed .sb-toggle-label { display: none; }

/* ── Content margin ── */
.content {
    margin-left: var(--sb-width);
    transition: margin-left var(--sb-tr);
}
.sidebar.collapsed ~ .content { margin-left: var(--sb-width-col); }

/* ── MOBILE ── */
@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
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
    .content { margin-left: 0 !important; }
    .sb-toggle { display: none; }
}
</style>

<nav class="sidebar" id="approvalSidebar">

    <a class="sb-brand" href="<?= base_url('approval/dashboard') ?>">
        <img src="<?= base_url('assets/images/logo_bekasi.png') ?>" alt="Logo Bekasi">
        <div class="sb-brand-text">
            <span class="sb-brand-name">SITLAKEB TKA</span>
            <span class="sb-brand-sub">KOTA BEKASI</span>
        </div>
    </a>

    <div class="sb-user">
        <div class="sb-user-avatar"><?= $initials ?></div>
        <div style="overflow:hidden; min-width:0;">
            <div class="sb-user-name"><?= htmlspecialchars($nama_admin) ?></div>
            <div class="sb-user-role"><?= $role_admin ?></div>
        </div>
    </div>

    <div class="sb-nav">

        <a class="sb-link <?= appr_active('approval/dashboard') ?>" href="<?= base_url('approval/dashboard') ?>">
            <span class="sb-icon"><i class="fas fa-tachometer-alt"></i></span>
            <span class="sb-label">Dashboard</span>
        </a>

        <div class="sb-divider"></div>
        <div class="sb-section">Approval</div>

        <a class="sb-link <?= appr_active('approval/index') ?>" href="<?= base_url('approval/index') ?>">
            <span class="sb-icon"><i class="fas fa-tasks"></i></span>
            <span class="sb-label">Daftar Pengajuan</span>
        </a>

        <div class="sb-divider"></div>
        <div class="sb-section">Riwayat</div>

        <a class="sb-link <?= appr_active('approval/logs') ?>" href="<?= base_url('approval/logs') ?>">
            <span class="sb-icon"><i class="fas fa-history"></i></span>
            <span class="sb-label">Log Aktivitas</span>
        </a>

        <div class="sb-divider"></div>

        <a href="<?= base_url('auth/logout') ?>"
        class="sb-link sb-logout"
        data-tooltip="Logout"
        onclick="return confirm('Yakin ingin keluar?')">
            <div class="sb-icon"><i class="fas fa-right-from-bracket"></i></div>
            <span class="sb-label">Logout</span>
        </a>

    </div><div class="sb-toggle">
        <button class="sb-toggle-btn" id="approvalSidebarToggle">
            <span class="sb-toggle-icon"><i class="fas fa-chevron-left"></i></span>
            <span class="sb-toggle-label">Tutup Sidebar</span>
        </button>
    </div>

</nav>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {

    // ================================================================
    // 1. SIDEBAR COLLAPSE (DESKTOP)
    // ================================================================
    var $sidebar = $('#approvalSidebar');
    var $toggleBtn = $('#approvalSidebarToggle');
    var $toggleLabel = $toggleBtn.find('.sb-toggle-label');

    function applyCollapse(isCollapsed) {
        $sidebar.toggleClass('collapsed', isCollapsed);
        $toggleLabel.text(isCollapsed ? 'Buka Sidebar' : 'Tutup Sidebar');
        localStorage.setItem('approvalSidebarCollapsed', isCollapsed ? '1' : '0');
    }

    // Restore dari localStorage (hanya di desktop)
    var savedState = localStorage.getItem('approvalSidebarCollapsed');
    if (savedState === '1' && $(window).width() > 768) {
        applyCollapse(true);
    }

    $toggleBtn.on('click', function(e) {
        e.preventDefault();
        var isNowCollapsed = !$sidebar.hasClass('collapsed');
        applyCollapse(isNowCollapsed);
    });

    // ================================================================
    // 2. MOBILE: OVERLAY + HAMBURGER
    // ================================================================
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

    // Resize handler
    var resizeDebounce;
    $(window).on('resize', function() {
        clearTimeout(resizeDebounce);
        resizeDebounce = setTimeout(function() {
            if ($(window).width() > 768) {
                closeSidebar();
                // Kembalikan collapse state sesuai localStorage
                var saved = localStorage.getItem('approvalSidebarCollapsed');
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

    // ================================================================
    // 3. PAGINATION + FILTER (dari kode asli)
    // ================================================================
    var tbody = document.querySelector('#tbl tbody');
    if (tbody) {
        var all = Array.from(tbody.querySelectorAll('tr')),
            fil = all,
            pp = 10,
            cp = 1;
        var info = document.getElementById('pgInfo'),
            ctrl = document.getElementById('pgCtrl'),
            sel = document.getElementById('pgSize');

        function render(p) {
            var tot = fil.length,
                pages = Math.max(1, Math.ceil(tot / pp));
            cp = Math.min(Math.max(1, p), pages);
            var s = (cp - 1) * pp,
                e = Math.min(cp * pp, tot);

            all.forEach(function(r) { r.style.display = 'none'; });
            fil.forEach(function(r, i) {
                r.style.display = (i >= s && i < e) ? '' : 'none';
            });

            info.innerHTML = tot > 0
                ? 'Menampilkan <strong>' + (s+1) + '–' + e + '</strong> dari <strong>' + tot + '</strong>'
                : '<strong>0</strong> data ditemukan';

            buildPg(pages);
        }

        function buildPg(pages) {
            ctrl.innerHTML = '';
            if (pages <= 1) return;

            function mk(label, pg, dis, act) {
                var b = document.createElement('button');
                b.className = 'pg-btn' + (act ? ' on' : '');
                b.innerHTML = label;
                b.disabled = dis;
                if (!dis && !act) b.onclick = function() { render(pg); };
                ctrl.appendChild(b);
            }

            mk('<i class="fas fa-chevron-left" style="font-size:9px"></i>', cp-1, cp===1);
            var lo = Math.max(1, cp-2),
                hi = Math.min(pages, lo+4);
            lo = Math.max(1, hi-4);
            if (lo > 1) { mk(1, 1, false, false); if (lo > 2) mk('…', null, true); }
            for (var i = lo; i <= hi; i++) mk(i, i, false, i === cp);
            if (hi < pages) { if (hi < pages-1) mk('…', null, true); mk(pages, pages, false, false); }
            mk('<i class="fas fa-chevron-right" style="font-size:9px"></i>', cp+1, cp===pages);
        }

        document.querySelectorAll('.chip').forEach(function(c) {
            c.addEventListener('click', function() {
                document.querySelectorAll('.chip').forEach(function(x) { x.classList.remove('on'); });
                this.classList.add('on');
                var f = this.dataset.f;
                fil = f === 'all' ? all : all.filter(function(r) { return r.dataset.sla === f; });
                render(1);
            });
        });

        sel.onchange = function() {
            pp = +sel.value;
            render(1);
        };

        render(1);
    }

});
</script>