// ============================================================
// SITLAKEB TKA - Shared JS (Responsive + Security + UX)
// Versi: 2.1 - Mobile Enhanced
// ============================================================

$(document).ready(function () {

    // ---------- 0. BASE URL FALLBACK ----------
    if (typeof base_url === 'undefined') {
        window.base_url = window.location.origin + '/';
    }

    // ---------- 1. SIDEBAR MOBILE TOGGLE ----------
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

    function closeSidebarMobile() {
        $('.sidebar').removeClass('mobile-open');
        $('.sidebar-overlay').removeClass('show');
        $('body').removeClass('body-no-scroll');
    }

    function openSidebarMobile() {
        $('.sidebar').addClass('mobile-open');
        $('.sidebar-overlay').addClass('show');
        $('body').addClass('body-no-scroll');
    }

    ensureMobileElements();

    // Hamburger click → buka sidebar
    $(document).on('click', '.mobile-menu-toggle', function (e) {
        e.preventDefault();
        openSidebarMobile();
    });

    // Overlay click → tutup sidebar
    $(document).on('click', '.sidebar-overlay', function () {
        closeSidebarMobile();
    });

    // Klik link di dalam sidebar saat mobile → tutup sidebar
    $(document).on('click', '.sidebar .sb-link', function () {
        if ($(window).width() <= 768) {
            setTimeout(closeSidebarMobile, 150);
        }
    });

    // Resize handler dengan debounce
    let resizeDebounce;
    $(window).on('resize', function () {
        clearTimeout(resizeDebounce);
        resizeDebounce = setTimeout(function () {
            if ($(window).width() > 768) {
                closeSidebarMobile();
            }
            ensureMobileElements();
        }, 200);
    });

    // ---------- 2. DESKTOP SIDEBAR COLLAPSE ----------
    if ($('.sb-toggle-btn').length === 0 && $('.sidebar').length) {
        $('.sidebar').append(`
            <div class="sb-toggle">
                <button class="sb-toggle-btn" id="sidebarCollapseBtn">
                    <span class="sb-toggle-icon"><i class="fas fa-chevron-left"></i></span>
                    <span class="sb-toggle-label">Sembunyikan menu</span>
                </button>
            </div>
        `);
    }

    $(document).on('click', '#sidebarCollapseBtn', function () {
        $('.sidebar').toggleClass('collapsed');
        var isCollapsed = $('.sidebar').hasClass('collapsed');
        localStorage.setItem('sidebarCollapsed', isCollapsed);
        var icon = $(this).find('.sb-toggle-icon i');
        if (isCollapsed) {
            icon.removeClass('fa-chevron-left').addClass('fa-chevron-right');
            $('.sb-toggle-label').text('Perluas menu');
        } else {
            icon.removeClass('fa-chevron-right').addClass('fa-chevron-left');
            $('.sb-toggle-label').text('Sembunyikan menu');
        }
    });

    // Restore collapse state (desktop only)
    if ($(window).width() > 768) {
        var savedState = localStorage.getItem('sidebarCollapsed');
        if (savedState === 'true') {
            $('.sidebar').addClass('collapsed');
            $('#sidebarCollapseBtn').find('.sb-toggle-icon i')
                .removeClass('fa-chevron-left').addClass('fa-chevron-right');
            $('.sb-toggle-label').text('Perluas menu');
        }
    }

    // ---------- 3. CSRF TOKEN ----------
    var csrfName = $('meta[name="csrf-token-name"]').attr('content');
    var csrfHash = $('meta[name="csrf-token-hash"]').attr('content');

    if (csrfName && csrfHash) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfHash
            },
            beforeSend: function (xhr, settings) {
                if (settings.type === 'POST' || settings.type === 'PUT' || settings.type === 'DELETE') {
                    if (typeof settings.data === 'string') {
                        settings.data += '&' + csrfName + '=' + encodeURIComponent(csrfHash);
                    } else if (typeof settings.data === 'object') {
                        settings.data[csrfName] = csrfHash;
                    }
                }
            }
        });

        $(document).ajaxComplete(function (event, xhr) {
            var newToken = xhr.getResponseHeader('X-CSRF-TOKEN');
            if (newToken) {
                $('meta[name="csrf-token-hash"]').attr('content', newToken);
                csrfHash = newToken;
            }
        });
    }

    // ---------- 4. NOTIFIKASI POLLING (dengan pause saat tab tidak aktif) ----------
    var pollIntervalId = null;
    var POLL_DELAY = 10000;

    function loadNotifications() {
        if ($('.topnav-badge').length === 0) return;

        $.ajax({
            url: base_url + 'notifikasi/get_unread_count',
            method: 'GET',
            dataType: 'json',
            timeout: 5000,
            success: function (res) {
                if (res && res.count > 0) {
                    $('.topnav-badge').text(res.count).show();
                } else {
                    $('.topnav-badge').hide();
                }
            },
            error: function () {
                // silent fail
            }
        });
    }

    function startPolling() {
        stopPolling();
        loadNotifications();
        pollIntervalId = setInterval(loadNotifications, POLL_DELAY);
    }

    function stopPolling() {
        if (pollIntervalId) {
            clearInterval(pollIntervalId);
            pollIntervalId = null;
        }
    }

    if ($('body').data('user-logged') === true || $('.topnav-badge').length) {
        startPolling();

        document.addEventListener('visibilitychange', function () {
            if (document.hidden) {
                stopPolling();
            } else {
                startPolling();
            }
        });
    }

    // ---------- 5. CHART RESIZE HANDLER ----------
    function resizeAllCharts() {
        if (typeof Chart !== 'undefined' && Chart.instances) {
            Chart.instances.forEach(function (chart) {
                if (chart && chart.resize) {
                    chart.resize();
                }
            });
        }
    }

    var chartResizeDebounce;
    $(window).on('resize', function () {
        clearTimeout(chartResizeDebounce);
        chartResizeDebounce = setTimeout(resizeAllCharts, 250);
    });

    // ---------- 6. CUSTOM FILE UPLOAD (MOBILE FRIENDLY) ----------
    $(document).on('click', '.upload-file-trigger', function () {
        var targetId = $(this).data('target');
        $('#' + targetId).click();
    });

    $(document).on('change', 'input[type="file"]', function () {
        var fileName = $(this).val().split('\\').pop();
        var displayEl = $('.upload-file-name[data-target="' + $(this).attr('id') + '"]');
        if (fileName) {
            displayEl.text('📎 ' + fileName).addClass('has-file');
        } else {
            displayEl.text('Belum ada file').removeClass('has-file');
        }
    });

    // ---------- 7. AUTO CLOSE ALERT ----------
    setTimeout(function () {
        $('.alert:not(.alert-permanent)').fadeOut('slow', function () {
            $(this).remove();
        });
    }, 5000);

    // ---------- 8. BOOTSTRAP TOOLTIP ----------
    if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (el) {
            return new bootstrap.Tooltip(el);
        });
    }

});