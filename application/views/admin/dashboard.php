<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin — SITLAKEB TKA</title>
    <link rel="icon" type="image/x-icon" href="<?= base_url('favicon.ico') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <style>
    :root {
        --bg:         #f4f6f9;
        --surface:    #ffffff;
        --surface-2:  #f8fafc;
        --border:     #e8ecf0;
        --border-2:   #d0d7e0;
        --ink:        #0f1923;
        --ink-2:      #3d4f60;
        --ink-3:      #7a8fa6;
        --green:      #1a6b52;
        --green-mid:  #22896a;
        --green-light:#e8f5f0;
        --green-glow: rgba(26,107,82,0.12);
        --amber:      #c06500;
        --amber-light:#fff4e6;
        --blue:       #1557a5;
        --blue-light: #e8f0fb;
        --red:        #b81c1c;
        --red-light:  #fef0f0;
        --r-sm:  8px;
        --r-md:  12px;
        --r-lg:  18px;
        --shadow-card: 0 1px 3px rgba(0,0,0,0.05), 0 4px 16px rgba(0,0,0,0.05);
        --shadow-lift: 0 4px 20px rgba(0,0,0,0.10);
        --font: 'Plus Jakarta Sans', sans-serif;
        --mono: 'DM Mono', monospace;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        background: var(--bg);
        font-family: var(--font);
        font-size: 14px;
        color: var(--ink);
        line-height: 1.6;
    }

    .page-wrapper { display: flex; flex-direction: column; min-height: 100vh; }
    .dash-inner { padding: 24px 28px 48px; }

    /* ── Topnav ── */
    .topnav {
        background: var(--surface);
        border-bottom: 1px solid var(--border);
        padding: 0 28px;
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        top: 0;
        z-index: 300;
        flex-shrink: 0;
        gap: 10px;
    }

    .topnav-breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.78rem;
        color: var(--ink-3);
        font-weight: 500;
        flex: 1;
        min-width: 0;
    }
    .topnav-breadcrumb strong { color: var(--ink); font-weight: 700; white-space: nowrap; }
    .topnav-breadcrumb .sep   { font-size: 7px; color: var(--border-2); }

    /* Burger button — di dalam topnav, mobile only */
    .topnav-burger {
        display: none;
        width: 34px; height: 34px;
        border-radius: 9px;
        border: 1px solid var(--border);
        background: var(--surface-2);
        align-items: center; justify-content: center;
        color: var(--ink-3); font-size: 13px;
        cursor: pointer; flex-shrink: 0;
        transition: background .15s, color .15s;
    }
    .topnav-burger:hover { background: var(--green-light); color: var(--green); }

    .topnav-right {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-shrink: 0;
    }

    .topnav-date {
        font-size: 0.73rem;
        color: var(--ink-3);
        font-weight: 500;
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: var(--r-sm);
        padding: 5px 11px;
        white-space: nowrap;
    }

    .admin-chip {
        display: flex; align-items: center; gap: 7px;
        background: var(--green-light);
        border: 1px solid rgba(26,107,82,0.2);
        border-radius: var(--r-sm);
        padding: 5px 11px;
        font-size: 0.73rem; font-weight: 600;
        color: var(--green); white-space: nowrap;
    }
    .admin-chip-avatar {
        width: 20px; height: 20px;
        background: var(--green); color: #fff;
        border-radius: 5px;
        display: flex; align-items: center; justify-content: center;
        font-size: 9px; flex-shrink: 0;
    }

    .notif-btn {
        position: relative;
        width: 36px; height: 36px;
        background: var(--surface-2);
        border: 1px solid var(--border);
        border-radius: var(--r-sm);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; color: var(--ink-2); font-size: 0.85rem;
        transition: all 0.15s; flex-shrink: 0;
    }
    .notif-btn:hover, .notif-btn.active {
        background: var(--green-light); border-color: var(--green); color: var(--green);
    }
    .notif-badge {
        position: absolute; top: -5px; right: -5px;
        background: var(--red); color: #fff;
        font-size: 9px; font-weight: 700;
        min-width: 17px; height: 17px;
        border-radius: 10px;
        display: none; align-items: center; justify-content: center;
        padding: 0 4px; border: 2px solid var(--surface);
        animation: pop 0.3s cubic-bezier(0.34,1.56,0.64,1);
    }
    @keyframes pop { from{transform:scale(0);} to{transform:scale(1);} }
    .notif-btn.ringing i { animation: ring 0.6s ease; }
    @keyframes ring {
        0%,100%{transform:rotate(0);} 20%{transform:rotate(20deg);}
        40%{transform:rotate(-18deg);} 60%{transform:rotate(14deg);} 80%{transform:rotate(-10deg);}
    }

    /* ── Notif dropdown ── */
    .notif-dropdown {
        position: absolute;
        top: calc(100% + 10px); right: 0;
        width: 340px;
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--r-lg);
        box-shadow: var(--shadow-lift);
        z-index: 1050; overflow: hidden;
        animation: dropIn 0.2s cubic-bezier(0.4,0,0.2,1);
        transform-origin: top right;
    }
    @keyframes dropIn {
        from{opacity:0;transform:scale(0.95) translateY(-6px);}
        to  {opacity:1;transform:scale(1)    translateY(0);}
    }
    .nd-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 12px 15px; border-bottom: 1px solid var(--border);
        background: var(--surface-2);
    }
    .nd-header-left { display: flex; align-items: center; gap: 8px; font-size: 0.8rem; font-weight: 700; color: var(--ink); }
    .nd-icon { width: 26px; height: 26px; background: var(--green-light); color: var(--green); border-radius: 7px; display: flex; align-items: center; justify-content: center; font-size: 11px; }
    .nd-mark-all { font-size: 0.68rem; font-weight: 600; color: var(--green); text-decoration: none; padding: 3px 9px; border-radius: 20px; border: 1px solid rgba(26,107,82,0.2); background: var(--green-light); transition: background 0.15s; white-space: nowrap; }
    .nd-mark-all:hover { background: #c5e8e1; }
    .nd-tabs { display: flex; border-bottom: 1px solid var(--border); }
    .nd-tab { flex: 1; padding: 9px 0; text-align: center; font-size: 0.72rem; font-weight: 600; color: var(--ink-3); cursor: pointer; border-bottom: 2px solid transparent; transition: color 0.15s, border-color 0.15s; user-select: none; }
    .nd-tab:hover { color: var(--ink); }
    .nd-tab.active { color: var(--green); border-bottom-color: var(--green); }
    .nd-tab .nd-tab-badge { display: none; align-items: center; justify-content: center; min-width: 16px; height: 16px; background: var(--red); color: #fff; font-size: 9px; font-weight: 700; border-radius: 10px; padding: 0 4px; margin-left: 5px; vertical-align: middle; }
    .nd-list { max-height: 300px; overflow-y: auto; }
    .nd-list::-webkit-scrollbar { width: 3px; }
    .nd-list::-webkit-scrollbar-thumb { background: var(--border-2); border-radius: 4px; }
    .nd-item { display: flex; gap: 10px; padding: 11px 15px; border-bottom: 1px solid var(--border); cursor: pointer; align-items: flex-start; transition: background 0.12s; }
    .nd-item:last-child { border-bottom: none; }
    .nd-item:hover { background: var(--surface-2); }
    .nd-item.unread { background: #f0faf6; }
    .nd-item.unread:hover { background: #e6f5ef; }
    .nd-item-icon { width: 32px; height: 32px; border-radius: 9px; display: flex; align-items: center; justify-content: center; font-size: 11px; flex-shrink: 0; margin-top: 1px; }
    .nd-item-icon.chat   { background: var(--blue-light);  color: var(--blue); }
    .nd-item-icon.system { background: var(--green-light); color: var(--green); }
    .nd-item-icon.warn   { background: var(--amber-light); color: var(--amber); }
    .nd-item-icon.reject { background: var(--red-light);   color: var(--red); }
    .nd-item-body { flex: 1; min-width: 0; }
    .nd-item-title { font-size: 0.77rem; font-weight: 600; color: var(--ink); margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .nd-item.unread .nd-item-title { color: var(--green); }
    .nd-item-msg { font-size: 0.71rem; color: var(--ink-3); line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .nd-item-meta { display: flex; align-items: center; gap: 6px; margin-top: 4px; }
    .nd-item-time { font-size: 0.64rem; color: var(--ink-3); font-family: var(--mono); }
    .nd-item-type { font-size: 0.6rem; font-weight: 700; padding: 1px 6px; border-radius: 4px; text-transform: uppercase; letter-spacing: 0.04em; }
    .nd-item-type.chat   { background: var(--blue-light);  color: var(--blue); }
    .nd-item-type.system { background: var(--green-light); color: var(--green); }
    .nd-item-unread-dot { width: 7px; height: 7px; background: var(--green); border-radius: 50%; flex-shrink: 0; margin-top: 6px; }
    .nd-empty { padding: 32px 16px; text-align: center; color: var(--ink-3); }
    .nd-empty i { font-size: 1.8rem; opacity: 0.22; margin-bottom: 8px; display: block; }
    .nd-empty p { font-size: 0.76rem; }
    .nd-footer { padding: 10px 15px; border-top: 1px solid var(--border); background: var(--surface-2); text-align: center; }
    .nd-footer a { font-size: 0.72rem; font-weight: 600; color: var(--green); text-decoration: none; display: inline-flex; align-items: center; gap: 5px; }
    .nd-footer a:hover { text-decoration: underline; }

    /* ── Page header ── */
    .page-head {
        display: flex; align-items: flex-end; justify-content: space-between;
        margin-bottom: 20px; padding-top: 4px;
        flex-wrap: wrap; gap: 10px;
    }
    .page-head-title { font-size: 1.3rem; font-weight: 800; color: var(--ink); letter-spacing: -0.4px; line-height: 1.2; }
    .page-head-sub { font-size: 0.8rem; color: var(--ink-3); margin-top: 3px; font-weight: 400; }
    .page-head-meta { font-size: 0.73rem; color: var(--ink-3); background: var(--surface); border: 1px solid var(--border); border-radius: var(--r-sm); padding: 6px 12px; font-weight: 500; white-space: nowrap; }
    .page-head-meta span { color: var(--green); font-weight: 700; }

    /* ── Stat grid ── */
    .stat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; margin-bottom: 20px; }
    .stat-card {
        background: var(--surface); border: 1px solid var(--border);
        border-radius: var(--r-lg); padding: 18px 16px;
        position: relative; overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
        box-shadow: var(--shadow-card);
        animation: fadeUp 0.4s ease both;
    }
    .stat-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-lift); }
    .stat-card:nth-child(1){animation-delay:0.05s;} .stat-card:nth-child(2){animation-delay:0.10s;}
    .stat-card:nth-child(3){animation-delay:0.15s;} .stat-card:nth-child(4){animation-delay:0.20s;}
    .stat-card::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 3px; border-radius: 0 0 var(--r-lg) var(--r-lg); }
    .stat-card.c-total::after  { background: var(--green); }
    .stat-card.c-proses::after { background: var(--amber); }
    .stat-card.c-selesai::after{ background: var(--blue); }
    .stat-card.c-ditolak::after{ background: var(--red); }
    .stat-icon { width: 38px; height: 38px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 0.88rem; margin-bottom: 12px; }
    .stat-icon.total   { background: var(--green-light); color: var(--green); }
    .stat-icon.proses  { background: var(--amber-light); color: var(--amber); }
    .stat-icon.selesai { background: var(--blue-light);  color: var(--blue); }
    .stat-icon.ditolak { background: var(--red-light);   color: var(--red); }
    .stat-label { font-size: 0.67rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.6px; color: var(--ink-3); margin-bottom: 5px; }
    .stat-value { font-size: 2rem; font-weight: 800; letter-spacing: -1px; line-height: 1; font-family: var(--mono); }
    .stat-value.total   { color: var(--green); }
    .stat-value.proses  { color: var(--amber); }
    .stat-value.selesai { color: var(--blue); }
    .stat-value.ditolak { color: var(--red); }
    .stat-footer { font-size: 0.7rem; color: var(--ink-3); margin-top: 8px; display: flex; align-items: center; gap: 5px; }

    /* ── Surface ── */
    .surface { background: var(--surface); border: 1px solid var(--border); border-radius: var(--r-lg); box-shadow: var(--shadow-card); overflow: hidden; animation: fadeUp 0.4s ease both; }
    .surface-head { padding: 14px 18px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px; }
    .surface-title { font-size: 0.82rem; font-weight: 700; color: var(--ink); display: flex; align-items: center; gap: 8px; }
    .surface-title-icon { width: 26px; height: 26px; background: var(--green-light); color: var(--green); border-radius: 7px; display: flex; align-items: center; justify-content: center; font-size: 0.68rem; }
    .surface-badge { font-size: 0.66rem; font-weight: 700; padding: 3px 9px; border-radius: 20px; background: var(--green-light); color: var(--green); border: 1px solid rgba(26,107,82,0.15); white-space: nowrap; }

    /* ── Funnel table ── */
    .funnel-table { width: 100%; border-collapse: collapse; }
    .funnel-table th { font-size: 0.66rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--ink-3); padding: 9px 18px; background: var(--surface-2); border-bottom: 1px solid var(--border); text-align: left; white-space: nowrap; }
    .funnel-table td { padding: 12px 18px; border-bottom: 1px solid var(--border); vertical-align: middle; font-size: 0.8rem; }
    .funnel-table tbody tr:last-child td { border-bottom: none; }
    .funnel-table tbody tr { transition: background 0.12s; }
    .funnel-table tbody tr:hover { background: var(--surface-2); }
    .stage-pill { display: inline-flex; align-items: center; gap: 6px; font-size: 0.73rem; font-weight: 600; padding: 3px 9px; border-radius: 20px; white-space: nowrap; }
    .stage-pill .dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
    .funnel-bar-wrap { background: var(--bg); border-radius: 20px; height: 7px; overflow: hidden; width: 100%; }
    .funnel-bar { height: 100%; border-radius: 20px; transition: width 0.8s cubic-bezier(0.4,0,0.2,1); }
    .count-chip { font-family: var(--mono); font-size: 0.84rem; font-weight: 500; color: var(--ink); }
    .count-unit { font-size: 0.68rem; color: var(--ink-3); margin-left: 2px; }
    .avg-time { display: inline-flex; align-items: center; gap: 4px; font-size: 0.73rem; color: var(--ink-3); font-family: var(--mono); }

    /* ── KPI ── */
    .kpi-surface { display: flex; flex-direction: column; }
    .kpi-row { display: flex; flex-direction: column; flex: 1; }
    .kpi-item { flex: 1; display: flex; align-items: center; justify-content: space-between; padding: 14px 18px; border-bottom: 1px solid var(--border); transition: background 0.12s; gap: 12px; }
    .kpi-item:last-child { border-bottom: none; }
    .kpi-item:hover { background: var(--surface-2); }
    .kpi-left { display: flex; align-items: center; gap: 12px; flex: 1; min-width: 0; }
    .kpi-icon-wrap { width: 34px; height: 34px; border-radius: 9px; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; flex-shrink: 0; }
    .kpi-text { display: flex; flex-direction: column; gap: 1px; min-width: 0; }
    .kpi-label { font-size: 0.77rem; font-weight: 600; color: var(--ink-2); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .kpi-sub { font-size: 0.65rem; color: var(--ink-3); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .kpi-value { font-family: var(--mono); font-size: 1.4rem; font-weight: 500; letter-spacing: -0.5px; flex-shrink: 0; text-align: right; }
    .kpi-value.green { color: var(--green); }
    .kpi-value.red   { color: var(--red); }
    .kpi-value.amber { color: var(--amber); }
    .kpi-value.blue  { color: var(--blue); }

    /* ── Chart ── */
    .chart-wrap { padding: 18px; position: relative; }
    .chart-legend { display: flex; gap: 14px; justify-content: center; padding: 0 18px 14px; flex-wrap: wrap; }
    .legend-item { display: flex; align-items: center; gap: 5px; font-size: 0.73rem; color: var(--ink-3); font-weight: 500; }
    .legend-dot  { width: 8px; height: 8px; border-radius: 50%; }

    /* ── Reject ── */
    .reject-item { padding: 12px 18px; border-bottom: 1px solid var(--border); transition: background 0.12s; }
    .reject-item:last-child { border-bottom: none; }
    .reject-item:hover { background: var(--surface-2); }
    .reject-meta { display: flex; align-items: center; justify-content: space-between; margin-bottom: 4px; gap: 8px; }
    .reject-role { font-size: 0.66rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.4px; padding: 2px 8px; border-radius: 4px; background: var(--red-light); color: var(--red); white-space: nowrap; }
    .reject-date { font-size: 0.66rem; color: var(--ink-3); font-family: var(--mono); white-space: nowrap; }
    .reject-text { font-size: 0.78rem; color: var(--ink-2); line-height: 1.5; }
    .reject-quote { color: var(--green); margin-right: 3px; }

    /* ── Data table ── */
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { font-size: 0.66rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--ink-3); padding: 9px 14px; background: var(--surface-2); border-bottom: 1px solid var(--border); text-align: left; white-space: nowrap; }
    .data-table td { padding: 11px 14px; border-bottom: 1px solid var(--border); vertical-align: middle; font-size: 0.79rem; color: var(--ink-2); }
    .data-table tbody tr:last-child td { border-bottom: none; }
    .data-table tbody tr { transition: background 0.12s; }
    .data-table tbody tr:hover { background: var(--surface-2); }
    .company-cell { display: flex; align-items: center; gap: 8px; }
    .company-icon { width: 28px; height: 28px; background: var(--green-light); color: var(--green); border-radius: 7px; display: flex; align-items: center; justify-content: center; font-size: 0.66rem; font-weight: 700; flex-shrink: 0; }
    .company-name { font-weight: 600; color: var(--ink); font-size: 0.79rem; }
    .ppill { display: inline-flex; align-items: center; gap: 5px; padding: 3px 8px; border-radius: 6px; font-size: 0.69rem; font-weight: 600; white-space: nowrap; }
    .ppill::before { content: ''; width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
    .ppill-draft::before{background:#94a3b8;} .ppill-draft{background:#f1f5f9;color:#475569;}
    .ppill-kasi::before{background:#f97316;}  .ppill-kasi{background:#fff7ed;color:#9a3412;}
    .ppill-kabid::before{background:#3b82f6;} .ppill-kabid{background:#eff6ff;color:#1e40af;}
    .ppill-sekdis::before{background:#8b5cf6;}.ppill-sekdis{background:#f5f3ff;color:#5b21b6;}
    .ppill-kadis::before{background:#10b981;} .ppill-kadis{background:#ecfdf5;color:#065f46;}
    .ppill-selesai::before{background:#16a34a;}.ppill-selesai{background:#dcfce7;color:#14532d;}
    .ppill-ditolak::before{background:#f43f5e;}.ppill-ditolak{background:#fff1f2;color:#9f1239;}
    .date-cell { font-family: var(--mono); font-size: 0.71rem; color: var(--ink-3); }
    .btn-view { display: inline-flex; align-items: center; gap: 4px; font-size: 0.7rem; font-weight: 600; color: var(--green); background: var(--green-light); border: 1px solid rgba(26,107,82,0.15); border-radius: var(--r-sm); padding: 4px 10px; text-decoration: none; transition: all 0.15s; white-space: nowrap; }
    .btn-view:hover { background: var(--green); color: #fff; border-color: var(--green); }
    .empty-state { text-align: center; padding: 40px 20px; color: var(--ink-3); }
    .empty-state i { font-size: 1.8rem; margin-bottom: 10px; opacity: 0.35; display: block; }
    .empty-state p { font-size: 0.8rem; }

    @keyframes fadeUp { from{opacity:0;transform:translateY(10px);} to{opacity:1;transform:translateY(0);} }

    /* ── Row layouts ── */
    .row-stretch { display: flex; gap: 16px; align-items: stretch; margin-bottom: 20px; }
    .col-funnel { flex: 7; min-width: 0; }
    .col-kpi    { flex: 5; min-width: 0; display: flex; flex-direction: column; }
    .col-kpi .surface.kpi-surface { flex: 1; display: flex; flex-direction: column; }
    .row-stretch-bottom { display: flex; gap: 16px; align-items: stretch; margin-bottom: 20px; }
    .col-reject { flex: 5; min-width: 0; }
    .col-recent { flex: 7; min-width: 0; }
    .gap-section { margin-bottom: 20px; }

    /* ══════════════════════════════════════════
       RESPONSIVE
    ══════════════════════════════════════════ */
    @media (max-width: 1100px) {
        .stat-grid { grid-template-columns: repeat(2, 1fr); }
        .row-stretch, .row-stretch-bottom { flex-direction: column; }
    }

    @media (max-width: 768px) {

        /* Topnav: burger muncul di dalam, padding normal */
        .topnav { padding: 0 12px; height: 52px; }
        .topnav-burger { display: flex; }
        .topnav-date { display: none; }
        .admin-chip .chip-name { display: none; }
        .admin-chip { padding: 5px 8px; }

        /* Dash inner */
        .dash-inner { padding: 14px 12px 40px; }

        /* Page header */
        .page-head { flex-direction: column; align-items: flex-start; gap: 8px; margin-bottom: 16px; }
        .page-head-title { font-size: 1.1rem; }
        .page-head-meta  { font-size: 0.71rem; padding: 5px 10px; }

        /* Stat grid 2 kolom */
        .stat-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; margin-bottom: 16px; }
        .stat-card { padding: 14px 12px; border-radius: var(--r-md); }
        .stat-icon { width: 32px; height: 32px; font-size: 0.78rem; margin-bottom: 10px; border-radius: 9px; }
        .stat-value { font-size: 1.6rem; }
        .stat-label { font-size: 0.62rem; }
        .stat-footer { font-size: 0.62rem; margin-top: 6px; }

        /* Surface */
        .surface { border-radius: var(--r-md) !important; }
        .surface-head { padding: 11px 14px; }
        .surface-title { font-size: 0.79rem; }

        /* Funnel mobile card stack */
        .funnel-table thead { display: none; }
        .funnel-table, .funnel-table tbody, .funnel-table tr, .funnel-table td { display: block; width: 100%; }
        .funnel-table tr {
            padding: 10px 14px; border-bottom: 1px solid var(--border);
            display: grid; grid-template-columns: 1fr auto;
            grid-template-rows: auto auto; gap: 4px 8px; align-items: center;
        }
        .funnel-table tr:last-child { border-bottom: none; }
        .funnel-table td:nth-child(1) { grid-column: 1; grid-row: 1; padding: 0; }
        .funnel-table td:nth-child(2) { grid-column: 2; grid-row: 1; padding: 0; text-align: right; }
        .funnel-table td:nth-child(3) { display: none; }
        .funnel-table td:nth-child(4) { grid-column: 1 / -1; grid-row: 2; padding: 0; }

        /* KPI */
        .kpi-item { padding: 11px 14px; }
        .kpi-value { font-size: 1.2rem; }
        .kpi-label { font-size: 0.74rem; }
        .kpi-sub   { display: none; }
        .kpi-icon-wrap { width: 30px; height: 30px; font-size: 0.75rem; }

        /* Chart */
        .chart-wrap { padding: 14px; }

        /* Reject */
        .reject-item { padding: 10px 14px; }

        /* Recent table */
        .data-table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .data-table .col-date { display: none; }

        /* Notif dropdown full width */
        .notif-dropdown {
            position: fixed;
            top: 52px; right: 0; left: 0; width: 100%;
            border-radius: 0 0 var(--r-lg) var(--r-lg);
            border-top: none; transform-origin: top center;
        }
        .nd-list { max-height: 55vh; }
    }

    @media (max-width: 480px) {
        .stat-grid { gap: 8px; }
        .stat-value { font-size: 1.4rem; }
        .data-table .col-tka { display: none; }
    }
    </style>
</head>
<body>

<?php $this->load->view('admin/sidebar'); ?>

<div class="page-wrapper">

    <!-- ── TOP NAV ── -->
    <div class="topnav">
        <div class="topnav-breadcrumb">
            <!-- Burger terintegrasi di dalam topnav, mobile only -->
            <button class="topnav-burger" id="adminBurger" aria-label="Buka Menu">
                <i class="fas fa-bars"></i>
            </button>
            <i class="fas fa-home"></i>
            <i class="fas fa-chevron-right sep"></i>
            <strong>Dashboard</strong>
        </div>
        <div class="topnav-right">

            <div class="topnav-date">
                <i class="far fa-calendar-alt" style="margin-right:5px;"></i>
                <span id="liveDate"></span>
            </div>

            <!-- Notification Bell -->
            <!--<div style="position:relative;" id="notifWrapper">
                <button class="notif-btn" id="notifBell" title="Notifikasi" type="button">
                    <i class="fas fa-bell"></i>
                    <span class="notif-badge" id="notifBadge"></span>
                </button>
                <div class="notif-dropdown" id="notifDropdown" style="display:none;">
                    <div class="nd-header">
                        <div class="nd-header-left">
                            <div class="nd-icon"><i class="fas fa-bell"></i></div>
                            Notifikasi
                        </div>
                        <a href="<?= base_url('admin/mark_all_notif_read') ?>" class="nd-mark-all" id="markAllBtn">
                            <i class="fas fa-check-double" style="font-size:9px;"></i> Tandai Semua
                        </a>
                    </div>
                    <div class="nd-tabs">
                        <div class="nd-tab active" data-tab="all">Semua <span class="nd-tab-badge" id="tabBadgeAll"></span></div>
                        <div class="nd-tab" data-tab="chat"><i class="fas fa-comment-dots" style="font-size:9px;margin-right:3px;"></i>Chat <span class="nd-tab-badge" id="tabBadgeChat"></span></div>
                        <div class="nd-tab" data-tab="system"><i class="fas fa-cog" style="font-size:9px;margin-right:3px;"></i>Sistem <span class="nd-tab-badge" id="tabBadgeSystem"></span></div>
                    </div>
                    <div class="nd-list" id="notifList">
                        <div class="nd-empty"><i class="fas fa-bell-slash"></i><p>Belum ada notifikasi</p></div>
                    </div>
                    <div class="nd-footer">
                        <a href="<?= base_url('admin/notifications') ?>">Lihat Semua <i class="fas fa-arrow-right" style="font-size:9px;"></i></a>
                    </div>
                </div>
            </div>

            <!-- Admin chip -->
            <div class="admin-chip">
                <div class="admin-chip-avatar"><i class="fas fa-user-shield"></i></div>
                <span class="chip-name"><?= htmlspecialchars($this->session->userdata('nama')) ?></span>
            </div>
        </div>
    </div>

    <!-- ── DASHBOARD CONTENT ── -->
    <div class="dash-inner">

        <div class="page-head">
            <div>
                <div class="page-head-title">Dashboard Admin</div>
                <div class="page-head-sub">Monitoring pengajuan notifikasi TKA secara real-time</div>
            </div>
            <div class="page-head-meta">
                Total aktif: <span><?= ($total_tka_all ?? 0) - ($stage_counts['DITOLAK'] ?? 0) ?></span> pengajuan berjalan
            </div>
        </div>

        <!-- Stat cards -->
        <div class="stat-grid">
            <div class="stat-card c-total">
                <div class="stat-icon total"><i class="fas fa-layer-group"></i></div>
                <div class="stat-label">Total Pengajuan</div>
                <div class="stat-value total"><?= $total_tka_all ?? 0 ?></div>
                <div class="stat-footer"><i class="fas fa-database"></i> Semua periode</div>
            </div>
            <div class="stat-card c-proses">
                <div class="stat-icon proses"><i class="fas fa-spinner"></i></div>
                <div class="stat-label">Sedang Diproses</div>
                <div class="stat-value proses"><?=
                    ($stage_counts['MENUNGGU_KASI']   ?? 0) +
                    ($stage_counts['MENUNGGU_KABID']  ?? 0) +
                    ($stage_counts['MENUNGGU_SEKDIS'] ?? 0) +
                    ($stage_counts['MENUNGGU_KADIS']  ?? 0)
                ?></div>
                <div class="stat-footer"><i class="fas fa-hourglass-half"></i> Menunggu verifikasi</div>
            </div>
            <div class="stat-card c-selesai">
                <div class="stat-icon selesai"><i class="fas fa-check-circle"></i></div>
                <div class="stat-label">Selesai</div>
                <div class="stat-value selesai"><?= $stage_counts['SELESAI'] ?? 0 ?></div>
                <div class="stat-footer"><i class="fas fa-file-alt"></i> Surat terbit</div>
            </div>
            <div class="stat-card c-ditolak">
                <div class="stat-icon ditolak"><i class="fas fa-times-circle"></i></div>
                <div class="stat-label">Ditolak</div>
                <div class="stat-value ditolak"><?= $stage_counts['DITOLAK'] ?? 0 ?></div>
                <div class="stat-footer"><i class="fas fa-ban"></i> Perlu tindak lanjut</div>
            </div>
        </div>

        <!-- Funnel + KPI -->
        <div class="row-stretch">
            <div class="col-funnel">
                <div class="surface" style="animation-delay:0.25s; height:100%;">
                    <div class="surface-head">
                        <div class="surface-title">
                            <div class="surface-title-icon"><i class="fas fa-filter"></i></div>
                            Tahapan Approval
                        </div>
                        <div class="surface-badge">Pipeline Aktif</div>
                    </div>
                    <table class="funnel-table">
                        <thead>
                            <tr>
                                <th>Tahap</th><th>Jumlah</th><th>Avg. Waktu</th><th>Proporsi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $stages_order = [
                            'MENUNGGU_KASI'   => ['label'=>'Menunggu Kasi',   'color'=>'#f97316'],
                            'MENUNGGU_KABID'  => ['label'=>'Menunggu Kabid',  'color'=>'#3b82f6'],
                            'MENUNGGU_SEKDIS' => ['label'=>'Menunggu Sekdis', 'color'=>'#8b5cf6'],
                            'MENUNGGU_KADIS'  => ['label'=>'Menunggu Kadis',  'color'=>'#10b981'],
                            'SELESAI'         => ['label'=>'Selesai',         'color'=>'#16a34a'],
                            'DITOLAK'         => ['label'=>'Ditolak',         'color'=>'#f43f5e'],
                        ];
                        $max_count = !empty($stage_counts) ? max(array_values($stage_counts) ?: [1]) : 1;
                        if ($max_count == 0) $max_count = 1;
                        foreach($stages_order as $key => $s):
                            $count   = $stage_counts[$key] ?? 0;
                            $percent = round(($count / $max_count) * 100);
                        ?>
                        <tr>
                            <td>
                                <span class="stage-pill" style="background:<?= $s['color'] ?>18; color:<?= $s['color'] ?>;">
                                    <span class="dot" style="background:<?= $s['color'] ?>;"></span>
                                    <?= $s['label'] ?>
                                </span>
                            </td>
                            <td><span class="count-chip"><?= $count ?></span><span class="count-unit">pengajuan</span></td>
                            <td><span class="avg-time"><i class="far fa-clock"></i> <?= $avg_time_stage[$key] ?? 0 ?> hari</span></td>
                            <td style="width:38%;">
                                <div class="funnel-bar-wrap">
                                    <div class="funnel-bar" style="width:<?= $percent ?>%; background:<?= $s['color'] ?>;"></div>
                                </div>
                                <div style="font-size:0.65rem; color:var(--ink-3); margin-top:2px; font-family:var(--mono);"><?= $percent ?>%</div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-kpi">
                <div class="surface kpi-surface" style="animation-delay:0.3s;">
                    <div class="surface-head">
                        <div class="surface-title">
                            <div class="surface-title-icon"><i class="fas fa-chart-pie"></i></div>
                            Metrik Utama
                        </div>
                    </div>
                    <?php
                    $total     = $total_tka_all ?? 0;
                    $selesai   = $stage_counts['SELESAI'] ?? 0;
                    $conv_rate = $total > 0 ? round(($selesai / $total) * 100, 1) : 0;
                    ?>
                    <div class="kpi-row">
                        <div class="kpi-item">
                            <div class="kpi-left">
                                <div class="kpi-icon-wrap" style="background:var(--green-light); color:var(--green);"><i class="fas fa-layer-group"></i></div>
                                <div class="kpi-text"><span class="kpi-label">Total leads count</span><span class="kpi-sub">Semua periode pengajuan</span></div>
                            </div>
                            <div class="kpi-value green"><?= $total_tka_all ?? 0 ?></div>
                        </div>
                        <div class="kpi-item">
                            <div class="kpi-left">
                                <div class="kpi-icon-wrap" style="background:var(--amber-light); color:var(--amber);"><i class="fas fa-clock"></i></div>
                                <div class="kpi-text"><span class="kpi-label">Rata-rata konversi</span><span class="kpi-sub">Hari rata-rata hingga selesai</span></div>
                            </div>
                            <div class="kpi-value amber"><?= $avg_convert_days ?? 0 ?> hr</div>
                        </div>
                        <div class="kpi-item">
                            <div class="kpi-left">
                                <div class="kpi-icon-wrap" style="background:var(--red-light); color:var(--red);"><i class="fas fa-ban"></i></div>
                                <div class="kpi-text"><span class="kpi-label">Inactive leads</span><span class="kpi-sub">Pengajuan tidak dilanjut</span></div>
                            </div>
                            <div class="kpi-value red"><?= $inactive_leads ?? 0 ?></div>
                        </div>
                        <div class="kpi-item">
                            <div class="kpi-left">
                                <div class="kpi-icon-wrap" style="background:var(--blue-light); color:var(--blue);"><i class="fas fa-percentage"></i></div>
                                <div class="kpi-text"><span class="kpi-label">Conversion rate</span><span class="kpi-sub">Persentase pengajuan selesai</span></div>
                            </div>
                            <div class="kpi-value blue"><?= $conv_rate ?>%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart -->
        <div class="surface gap-section" style="animation-delay:0.35s;">
            <div class="surface-head">
                <div class="surface-title">
                    <div class="surface-title-icon"><i class="fas fa-chart-line"></i></div>
                    Leads Tracking — 6 Bulan Terakhir
                </div>
                <div class="surface-badge">Tren</div>
            </div>
            <div class="chart-wrap" style="height:240px;">
                <canvas id="leadsChart"></canvas>
            </div>
            <div class="chart-legend">
                <div class="legend-item"><span class="legend-dot" style="background:#16a34a;"></span> Selesai</div>
                <div class="legend-item"><span class="legend-dot" style="background:#f43f5e;"></span> Ditolak</div>
                <div class="legend-item"><span class="legend-dot" style="background:#3b82f6;"></span> Dalam Proses</div>
            </div>
        </div>

        <!-- Reject + Recent -->
        <div class="row-stretch-bottom">
            <div class="col-reject">
                <div class="surface" style="animation-delay:0.4s; height:100%;">
                    <div class="surface-head">
                        <div class="surface-title">
                            <div class="surface-title-icon" style="background:var(--red-light); color:var(--red);"><i class="fas fa-comment-slash"></i></div>
                            Reasons of Leads Lost
                        </div>
                    </div>
                    <?php if(empty($recent_rejects)): ?>
                        <div class="empty-state"><i class="fas fa-inbox"></i><p>Belum ada data penolakan.</p></div>
                    <?php else: ?>
                    <div style="max-height:300px; overflow-y:auto;">
                        <?php foreach($recent_rejects as $reject): ?>
                        <div class="reject-item">
                            <div class="reject-meta">
                                <span class="reject-role"><?= ucfirst($reject->role) ?></span>
                                <span class="reject-date"><?= date('d/m/Y H:i', strtotime($reject->created_at)) ?></span>
                            </div>
                            <div class="reject-text"><span class="reject-quote"><i class="fas fa-quote-left"></i></span><?= htmlspecialchars($reject->catatan) ?></div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-recent">
                <div class="surface" style="animation-delay:0.45s; height:100%;">
                    <div class="surface-head">
                        <div class="surface-title">
                            <div class="surface-title-icon"><i class="fas fa-history"></i></div>
                            Pengajuan Terbaru
                        </div>
                        <a href="<?= base_url('admin/semua_tka') ?>" style="font-size:0.71rem; color:var(--green); font-weight:600; text-decoration:none; white-space:nowrap;">
                            Lihat Semua <i class="fas fa-arrow-right" style="font-size:9px; margin-left:3px;"></i>
                        </a>
                    </div>
                    <?php
                    function getProgressPill($status) {
                        $map = [
                            'DRAFT'           => ['Belum Lengkap', 'ppill-draft'],
                            'MENUNGGU_KASI'   => ['Verif. Kasi',   'ppill-kasi'],
                            'MENUNGGU_KABID'  => ['Verif. Kabid',  'ppill-kabid'],
                            'MENUNGGU_SEKDIS' => ['Verif. Sekdis', 'ppill-sekdis'],
                            'MENUNGGU_KADIS'  => ['Verif. Kadis',  'ppill-kadis'],
                            'SELESAI'         => ['Surat Terbit',  'ppill-selesai'],
                            'DITOLAK'         => ['Ditolak',       'ppill-ditolak'],
                        ];
                        return isset($map[$status]) ? $map[$status] : [$status, 'ppill-draft'];
                    }
                    $recent = !empty($all_tka) ? array_slice($all_tka, 0, 6) : [];
                    ?>
                    <?php if(empty($recent)): ?>
                        <div class="empty-state"><i class="fas fa-inbox"></i><p>Belum ada pengajuan.</p></div>
                    <?php else: ?>
                    <div class="data-table-wrap" style="overflow-x:auto;">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Perusahaan</th>
                                    <th class="col-tka">Nama TKA</th>
                                    <th>Progress</th>
                                    <th class="col-date">Tanggal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($recent as $r):
                                list($pillLabel, $pillClass) = getProgressPill($r->status);
                                $initials = strtoupper(substr($r->perusahaan, 0, 2));
                            ?>
                            <tr>
                                <td>
                                    <div class="company-cell">
                                        <div class="company-icon"><?= $initials ?></div>
                                        <div class="company-name"><?= htmlspecialchars($r->perusahaan) ?></div>
                                    </div>
                                </td>
                                <td class="col-tka" style="font-weight:500; color:var(--ink);"><?= htmlspecialchars($r->nama_tka) ?></td>
                                <td><span class="ppill <?= $pillClass ?>"><?= $pillLabel ?></span></td>
                                <td class="col-date"><span class="date-cell"><?= date('d/m/y', strtotime($r->created_at)) ?></span></td>
                                <td><a href="<?= base_url('admin/semua_tka/'.$r->id) ?>" class="btn-view"><i class="fas fa-eye"></i> Detail</a></td>
                            </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div><!-- /dash-inner -->

    <?php $this->load->view('footer'); ?>

</div><!-- /page-wrapper -->

<script>
/* ── Live date ── */
(function(){
    var d    = new Date();
    var opts = { weekday:'short', day:'numeric', month:'short', year:'numeric' };
    var el   = document.getElementById('liveDate');
    if (el) el.textContent = d.toLocaleDateString('id-ID', opts);
})();

/* ── Burger: hubungkan ke sidebar admin ── */
(function(){
    var burger  = document.getElementById('adminBurger');
    var sidebar = document.getElementById('adminSidebar');
    var overlay = document.getElementById('adminOverlay');

    if (!burger || !sidebar) return;

    function openSidebar() {
        sidebar.classList.add('mobile-open');
        if (overlay) overlay.classList.add('show');
        document.body.style.overflow = 'hidden';
        var closeBtn = document.getElementById('adminSidebarClose');
        if (closeBtn) closeBtn.style.display = 'flex';
    }

    burger.addEventListener('click', function(e) {
        e.stopPropagation();
        openSidebar();
    });
})();

/* ── Chart.js ── */
(function(){
    var ctx = document.getElementById('leadsChart');
    if (!ctx) return;
    new Chart(ctx.getContext('2d'), {
        type: 'line',
        data: {
            labels: <?= $months ?? '[]' ?>,
            datasets: [
                { label:'Selesai', data: <?= $closed_won ?? '[]' ?>, borderColor:'#16a34a', backgroundColor:'rgba(22,163,74,0.07)', fill:true, tension:0.4, borderWidth:2, pointRadius:4, pointBackgroundColor:'#16a34a', pointBorderColor:'#fff', pointBorderWidth:2 },
                { label:'Ditolak', data: <?= $closed_lost ?? '[]' ?>, borderColor:'#f43f5e', backgroundColor:'rgba(244,63,94,0.06)', fill:true, tension:0.4, borderWidth:2, pointRadius:4, pointBackgroundColor:'#f43f5e', pointBorderColor:'#fff', pointBorderWidth:2 },
                { label:'Dalam Proses', data: <?= $in_progress ?? '[]' ?>, borderColor:'#3b82f6', backgroundColor:'rgba(59,130,246,0.06)', fill:true, tension:0.4, borderWidth:2, pointRadius:4, pointBackgroundColor:'#3b82f6', pointBorderColor:'#fff', pointBorderWidth:2 }
            ]
        },
        options: {
            responsive:true, maintainAspectRatio:false,
            interaction:{ mode:'index', intersect:false },
            plugins: {
                legend:{ display:false },
                tooltip:{ backgroundColor:'#0f1923', titleColor:'#fff', bodyColor:'#94a3b8', padding:12, cornerRadius:10 }
            },
            scales: {
                y:{ beginAtZero:true, grid:{ color:'#f0f2f5', drawBorder:false }, ticks:{ font:{ family:"'DM Mono',monospace", size:10 }, color:'#94a3b8', precision:0 }, border:{ display:false } },
                x:{ grid:{ display:false }, ticks:{ font:{ family:"'Plus Jakarta Sans',sans-serif", size:10 }, color:'#94a3b8' }, border:{ display:false } }
            }
        }
    });
})();

/* ── Notification System ── */
var _notifData = { all:[], chat:[], system:[] };
var _activeTab = 'all';
var _prevUnread = 0;
var _dropOpen   = false;

function relTime(dateStr) {
    var d = new Date(dateStr), diff = Math.floor((new Date() - d) / 1000);
    if (diff < 60)    return 'Baru saja';
    if (diff < 3600)  return Math.floor(diff/60) + ' mnt lalu';
    if (diff < 86400) return Math.floor(diff/3600) + ' jam lalu';
    return d.toLocaleDateString('id-ID', {day:'numeric', month:'short'});
}

function getNotifMeta(n) {
    var type  = n.type || 'system';
    if (type === 'chat') return { iconClass:'chat', icon:'fa-comment-dots', typeLabel:'Chat', tabKey:'chat' };
    var title = (n.title || '').toLowerCase();
    if (title.indexOf('tolak') !== -1 || title.indexOf('reject') !== -1) return { iconClass:'reject', icon:'fa-times-circle', typeLabel:'Sistem', tabKey:'system' };
    if (title.indexOf('peringatan') !== -1 || title.indexOf('sla') !== -1) return { iconClass:'warn', icon:'fa-exclamation-triangle', typeLabel:'Sistem', tabKey:'system' };
    return { iconClass:'system', icon:'fa-bell', typeLabel:'Sistem', tabKey:'system' };
}

function escHtml(str) { return (str||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }

function setBadge(id, count) {
    var el = document.getElementById(id);
    if (!el) return;
    if (count > 0) { el.textContent = count > 99 ? '99+' : count; el.style.display = 'inline-flex'; }
    else           { el.style.display = 'none'; }
}

function renderNotifList(tab) {
    _activeTab = tab;
    var list = _notifData[tab] || [];
    var el   = document.getElementById('notifList');
    document.querySelectorAll('.nd-tab').forEach(function(t){ t.classList.toggle('active', t.dataset.tab === tab); });
    if (!list.length) { el.innerHTML = '<div class="nd-empty"><i class="fas fa-bell-slash"></i><p>Tidak ada notifikasi di sini</p></div>'; return; }
    var html = '';
    list.forEach(function(n) {
        var meta = getNotifMeta(n), unread = (n.is_read == 0);
        var url  = '<?= base_url("admin/mark_notif_read/") ?>' + n.id;
        html += '<div class="nd-item '+(unread?'unread':'')+'" data-id="'+n.id+'" data-url="'+url+'">';
        html += '<div class="nd-item-icon '+meta.iconClass+'"><i class="fas '+meta.icon+'"></i></div>';
        html += '<div class="nd-item-body">';
        html += '<div class="nd-item-title">'+escHtml(n.title)+'</div>';
        html += '<div class="nd-item-msg">'+escHtml(n.message)+'</div>';
        html += '<div class="nd-item-meta"><span class="nd-item-time"><i class="far fa-clock" style="font-size:8px;"></i> '+relTime(n.created_at)+'</span><span class="nd-item-type '+meta.iconClass+'">'+meta.typeLabel+'</span></div>';
        html += '</div>';
        if (unread) html += '<div class="nd-item-unread-dot"></div>';
        html += '</div>';
    });
    el.innerHTML = html;
    el.querySelectorAll('.nd-item').forEach(function(item){
        item.addEventListener('click', function(){
            var xhr = new XMLHttpRequest();
            xhr.open('POST', this.dataset.url, true);
            xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
            xhr.send('<?= $this->security->get_csrf_token_name() ?>=<?= $this->security->get_csrf_hash() ?>');
            this.classList.remove('unread');
            var dot = this.querySelector('.nd-item-unread-dot');
            if (dot) dot.remove();
            fetchNotifications();
        });
    });
}

function fetchNotifications() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '<?= base_url("admin/get_notifications") ?>', true);
    xhr.setRequestHeader('X-Requested-With','XMLHttpRequest');
    xhr.onload = function() {
        if (xhr.status !== 200) return;
        var data; try { data = JSON.parse(xhr.responseText); } catch(e){ return; }
        var notifs = data.notifications || [], unread = data.unread_count || 0;
        _notifData.all    = notifs;
        _notifData.chat   = notifs.filter(function(n){ return (n.type||'system') === 'chat'; });
        _notifData.system = notifs.filter(function(n){ return (n.type||'system') !== 'chat'; });
        var unreadChat   = _notifData.chat.filter(function(n){ return n.is_read == 0; }).length;
        var unreadSystem = _notifData.system.filter(function(n){ return n.is_read == 0; }).length;
        var badge = document.getElementById('notifBadge');
        if (badge) { if (unread > 0) { badge.textContent = unread > 99 ? '99+' : unread; badge.style.display = 'flex'; } else { badge.style.display = 'none'; } }
        setBadge('tabBadgeAll', unread);
        setBadge('tabBadgeChat', unreadChat);
        setBadge('tabBadgeSystem', unreadSystem);
        if (unread > _prevUnread && _prevUnread !== -1) {
            var bell = document.getElementById('notifBell');
            bell.classList.remove('ringing'); void bell.offsetWidth; bell.classList.add('ringing');
            setTimeout(function(){ bell.classList.remove('ringing'); }, 700);
        }
        _prevUnread = unread;
        if (_dropOpen) renderNotifList(_activeTab);
    };
    xhr.send();
}

document.getElementById('notifBell').addEventListener('click', function(e){
    e.stopPropagation();
    var dd = document.getElementById('notifDropdown');
    _dropOpen = !_dropOpen;
    dd.style.display = _dropOpen ? 'block' : 'none';
    this.classList.toggle('active', _dropOpen);
    if (_dropOpen) renderNotifList(_activeTab);
});

document.querySelectorAll('.nd-tab').forEach(function(tab){
    tab.addEventListener('click', function(e){ e.stopPropagation(); renderNotifList(this.dataset.tab); });
});

document.getElementById('markAllBtn').addEventListener('click', function(e){
    e.preventDefault(); e.stopPropagation();
    var xhr = new XMLHttpRequest();
    xhr.open('POST','<?= base_url("admin/mark_all_notif_read") ?>',true);
    xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    xhr.onload = function(){ fetchNotifications(); };
    xhr.send('<?= $this->security->get_csrf_token_name() ?>=<?= $this->security->get_csrf_hash() ?>');
});

document.addEventListener('click', function(e){
    var wrapper = document.getElementById('notifWrapper');
    if (wrapper && !wrapper.contains(e.target)) {
        document.getElementById('notifDropdown').style.display = 'none';
        document.getElementById('notifBell').classList.remove('active');
        _dropOpen = false;
    }
});

_prevUnread = -1;
fetchNotifications();
setInterval(fetchNotifications, 8000);
</script>
</body>
</html>