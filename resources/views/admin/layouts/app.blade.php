<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') · {{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --sw: 265px;
            --th: 62px;
            --indigo: #6366f1;
            --indigo-d: #4f46e5;
            --indigo-l: #eef2ff;
            --emerald: #10b981;
            --amber: #f59e0b;
            --rose: #f43f5e;
            --sky: #0ea5e9;
            --bg: #f0f4ff;
            --white: #ffffff;
            --sidebar: #0f172a;
            --text: #0f172a;
            --muted: #64748b;
            --border: #e2e8f0;
            --r: 14px;
            --r-sm: 9px;
            --shadow: 0 1px 2px rgba(0,0,0,.04), 0 4px 20px rgba(99,102,241,.06);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', system-ui, sans-serif;
            background: var(--bg);
            color: var(--text);
            font-size: 13.5px;
            line-height: 1.5;
        }

        /* ═══════════════════════════════════════
           SIDEBAR
        ═══════════════════════════════════════ */
        .sidebar {
            position: fixed; top: 0; left: 0;
            width: var(--sw); height: 100vh;
            background: var(--sidebar);
            display: flex; flex-direction: column;
            z-index: 200;
        }

        /* top glow blob */
        .sidebar::after {
            content: '';
            position: absolute; top: -60px; left: -60px;
            width: 260px; height: 260px;
            background: radial-gradient(circle, rgba(99,102,241,.18) 0%, transparent 65%);
            pointer-events: none;
        }

        .sb-brand {
            height: var(--th);
            display: flex; align-items: center; gap: 11px;
            padding: 0 20px;
            border-bottom: 1px solid rgba(255,255,255,.05);
            flex-shrink: 0; position: relative; z-index: 1;
        }

        .sb-logo {
            width: 34px; height: 34px;
            background: linear-gradient(135deg, #6366f1, #818cf8);
            border-radius: 9px;
            display: flex; align-items: center; justify-content: center;
            font-size: 17px; color: #fff;
            box-shadow: 0 4px 14px rgba(99,102,241,.45);
            flex-shrink: 0;
        }

        .sb-brand-text { line-height: 1.2; }
        .sb-brand-name { font-size: 14.5px; font-weight: 700; color: #f1f5f9; letter-spacing: -.2px; }
        .sb-brand-sub  { font-size: 10px; color: #475569; font-weight: 500; letter-spacing: .4px; text-transform: uppercase; }

        .sb-nav { flex: 1; overflow-y: auto; padding: 12px 10px; scrollbar-width: none; }
        .sb-nav::-webkit-scrollbar { display: none; }

        .sb-label {
            font-size: 9.5px; font-weight: 700; letter-spacing: 1.2px;
            text-transform: uppercase; color: #334155;
            padding: 16px 12px 6px;
        }

        .sb-link {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 12px; border-radius: var(--r-sm);
            color: #94a3b8; text-decoration: none;
            font-size: 13px; font-weight: 500;
            transition: all .16s; margin-bottom: 1px;
            position: relative;
        }

        .sb-link .sb-icon {
            width: 30px; height: 30px;
            border-radius: 7px;
            display: flex; align-items: center; justify-content: center;
            font-size: 15px; flex-shrink: 0;
            background: rgba(255,255,255,.04);
            transition: all .16s;
        }

        .sb-link:hover { color: #c7d2fe; background: rgba(99,102,241,.1); }
        .sb-link:hover .sb-icon { background: rgba(99,102,241,.2); color: #a5b4fc; }

        .sb-link.active { color: #fff; background: rgba(99,102,241,.18); }
        .sb-link.active .sb-icon { background: rgba(99,102,241,.35); color: #a5b4fc; }
        .sb-link.active::before {
            content: '';
            position: absolute; left: 0; top: 25%; bottom: 25%;
            width: 3px; background: #6366f1;
            border-radius: 0 3px 3px 0;
        }

        .sb-badge {
            margin-left: auto;
            background: rgba(99,102,241,.25);
            color: #a5b4fc;
            font-size: 10px; font-weight: 600;
            padding: 2px 7px; border-radius: 20px;
        }

        .sb-footer {
            padding: 12px;
            border-top: 1px solid rgba(255,255,255,.05);
            flex-shrink: 0;
        }

        .sb-user {
            display: flex; align-items: center; gap: 10px;
            padding: 9px 10px; border-radius: var(--r-sm);
            background: rgba(255,255,255,.04);
            cursor: pointer; transition: background .15s;
        }
        .sb-user:hover { background: rgba(255,255,255,.07); }

        .sb-avatar {
            width: 30px; height: 30px;
            background: linear-gradient(135deg, #6366f1, #818cf8);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700; color: #fff; flex-shrink: 0;
        }

        .sb-uname { font-size: 12.5px; font-weight: 600; color: #e2e8f0; }
        .sb-urole { font-size: 10.5px; color: #475569; }

        /* ═══════════════════════════════════════
           TOPBAR
        ═══════════════════════════════════════ */
        .topbar {
            position: fixed; top: 0;
            left: var(--sw); right: 0;
            height: var(--th);
            background: rgba(255,255,255,.92);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center;
            justify-content: space-between;
            padding: 0 24px; z-index: 199;
        }

        .tb-page { font-size: 15px; font-weight: 700; color: var(--text); letter-spacing: -.2px; }
        .tb-crumb { font-size: 11.5px; color: var(--muted); margin-top: 1px; }

        .tb-actions { display: flex; align-items: center; gap: 6px; }

        .tb-btn {
            width: 34px; height: 34px;
            border-radius: var(--r-sm);
            border: 1px solid var(--border);
            background: var(--white);
            display: flex; align-items: center; justify-content: center;
            color: var(--muted); cursor: pointer;
            font-size: 15px; transition: all .14s;
        }
        .tb-btn:hover { background: var(--indigo-l); color: var(--indigo); border-color: #c7d2fe; }

        .tb-divider { width: 1px; height: 20px; background: var(--border); margin: 0 4px; }

        .tb-user-pill {
            display: flex; align-items: center; gap: 8px;
            padding: 5px 12px 5px 6px;
            border: 1px solid var(--border);
            border-radius: 30px; background: var(--white);
            cursor: pointer; transition: all .14s;
        }
        .tb-user-pill:hover { border-color: #c7d2fe; background: var(--indigo-l); }

        .tb-pill-avatar {
            width: 24px; height: 24px;
            background: linear-gradient(135deg, #6366f1, #818cf8);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 10px; font-weight: 700; color: #fff;
        }

        .tb-pill-name { font-size: 12px; font-weight: 600; color: var(--text); }

        /* ═══════════════════════════════════════
           MAIN
        ═══════════════════════════════════════ */
        .main-wrap {
            margin-left: var(--sw);
            padding-top: var(--th);
            min-height: 100vh;
        }

        .main-body { padding: 24px 28px; }

        /* ═══════════════════════════════════════
           PAGE HEADER
        ═══════════════════════════════════════ */
        .page-hdr {
            display: flex; align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
        }

        .page-title { font-size: 19px; font-weight: 800; color: var(--text); letter-spacing: -.3px; }
        .page-sub   { font-size: 12px; color: var(--muted); margin-top: 2px; }

        /* ═══════════════════════════════════════
           CARDS
        ═══════════════════════════════════════ */
        .card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--r);
            box-shadow: var(--shadow);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid var(--border);
            padding: 14px 20px;
            font-size: 13px; font-weight: 700;
            color: var(--text);
            display: flex; align-items: center;
            justify-content: space-between;
        }

        .card-body { padding: 20px; }
        .card-body.p-0 { padding: 0; }

        /* ═══════════════════════════════════════
           STAT CARDS
        ═══════════════════════════════════════ */
        .stat-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--r);
            padding: 20px;
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
            transition: transform .18s, box-shadow .18s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(99,102,241,.12);
        }

        .stat-card::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0;
            height: 3px;
        }

        .stat-card.indigo::before { background: linear-gradient(90deg, #6366f1, #818cf8); }
        .stat-card.emerald::before { background: linear-gradient(90deg, #10b981, #34d399); }
        .stat-card.amber::before { background: linear-gradient(90deg, #f59e0b, #fbbf24); }
        .stat-card.rose::before { background: linear-gradient(90deg, #f43f5e, #fb7185); }
        .stat-card.sky::before { background: linear-gradient(90deg, #0ea5e9, #38bdf8); }
        .stat-card.violet::before { background: linear-gradient(90deg, #8b5cf6, #a78bfa); }

        .stat-top { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 14px; }

        .stat-icon {
            width: 44px; height: 44px;
            border-radius: 11px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; flex-shrink: 0;
        }

        .stat-icon.indigo  { background: #eef2ff; color: #6366f1; }
        .stat-icon.emerald { background: #d1fae5; color: #059669; }
        .stat-icon.amber   { background: #fef3c7; color: #d97706; }
        .stat-icon.rose    { background: #ffe4e6; color: #e11d48; }
        .stat-icon.sky     { background: #e0f2fe; color: #0284c7; }
        .stat-icon.violet  { background: #ede9fe; color: #7c3aed; }

        .stat-trend {
            font-size: 11px; font-weight: 600;
            padding: 3px 8px; border-radius: 20px;
        }

        .stat-trend.up   { background: #d1fae5; color: #065f46; }
        .stat-trend.down { background: #ffe4e6; color: #9f1239; }
        .stat-trend.neu  { background: #f1f5f9; color: #64748b; }

        .stat-val   { font-size: 26px; font-weight: 800; color: var(--text); line-height: 1; letter-spacing: -.5px; }
        .stat-label { font-size: 12px; color: var(--muted); margin-top: 4px; font-weight: 500; }

        /* ═══════════════════════════════════════
           TABLES
        ═══════════════════════════════════════ */
        .table { font-size: 13px; color: var(--text); margin: 0; }

        .table thead th {
            font-size: 10.5px; font-weight: 700;
            text-transform: uppercase; letter-spacing: .7px;
            color: var(--muted); background: #f8fafc;
            border-bottom: 1px solid var(--border);
            padding: 11px 16px; white-space: nowrap;
        }

        .table tbody td {
            padding: 12px 16px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        .table tbody tr:last-child td { border-bottom: none; }
        .table tbody tr { transition: background .1s; }
        .table tbody tr:hover { background: #fafbff; }

        /* ═══════════════════════════════════════
           BUTTONS
        ═══════════════════════════════════════ */
        .btn {
            font-size: 13px; font-weight: 600;
            border-radius: var(--r-sm);
            padding: 8px 16px;
            transition: all .15s;
            display: inline-flex; align-items: center; gap: 6px;
            cursor: pointer; border: none; line-height: 1.4;
        }

        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: #fff;
            box-shadow: 0 2px 10px rgba(99,102,241,.3);
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #4f46e5, #3730a3);
            box-shadow: 0 4px 16px rgba(99,102,241,.4);
            color: #fff; transform: translateY(-1px);
        }

        .btn-sm { font-size: 12px; padding: 6px 12px; border-radius: 7px; }

        .btn-outline-secondary {
            background: var(--white); border: 1.5px solid var(--border); color: var(--muted);
        }
        .btn-outline-secondary:hover { background: #f8fafc; color: var(--text); border-color: #cbd5e1; }

        .btn-outline-danger {
            background: var(--white); border: 1.5px solid #fecaca; color: #e11d48;
        }
        .btn-outline-danger:hover { background: #fff1f2; border-color: #f43f5e; }

        .btn-outline-primary {
            background: var(--white); border: 1.5px solid #c7d2fe; color: #6366f1;
        }
        .btn-outline-primary:hover { background: var(--indigo-l); }

        /* ═══════════════════════════════════════
           BADGES
        ═══════════════════════════════════════ */
        .badge {
            font-size: 10.5px; font-weight: 600;
            padding: 3px 9px; border-radius: 20px; letter-spacing: .1px;
        }

        .badge.bg-success   { background: #d1fae5 !important; color: #065f46 !important; }
        .badge.bg-secondary { background: #f1f5f9 !important; color: #475569 !important; }
        .badge.bg-danger    { background: #ffe4e6 !important; color: #9f1239 !important; }
        .badge.bg-warning   { background: #fef3c7 !important; color: #92400e !important; }
        .badge.bg-info      { background: #e0f2fe !important; color: #075985 !important; }
        .badge.bg-light     { background: #f8fafc !important; color: var(--muted) !important; }

        /* ═══════════════════════════════════════
           FORMS
        ═══════════════════════════════════════ */
        .form-label { font-size: 12px; font-weight: 700; color: var(--text); margin-bottom: 5px; }

        .form-control, .form-select {
            font-size: 13px;
            border: 1.5px solid var(--border);
            border-radius: var(--r-sm);
            padding: 9px 12px;
            color: var(--text); background: var(--white);
            transition: border-color .14s, box-shadow .14s;
        }

        .form-control:focus, .form-select:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,.1);
            outline: none;
        }

        .form-control.is-invalid, .form-select.is-invalid { border-color: #f43f5e; }
        .form-control.is-invalid:focus { box-shadow: 0 0 0 3px rgba(244,63,94,.1); }
        .invalid-feedback { font-size: 11.5px; color: #e11d48; margin-top: 4px; }

        .input-group-text {
            background: #f8fafc; border: 1.5px solid var(--border);
            color: var(--muted); font-size: 13px;
        }

        .input-group .input-group-text { border-right: none; border-radius: var(--r-sm) 0 0 var(--r-sm); }
        .input-group .form-control     { border-left: none;  border-radius: 0 var(--r-sm) var(--r-sm) 0; }

        .form-check-input:checked { background-color: #6366f1; border-color: #6366f1; }
        .form-control-color { padding: 4px 6px; height: 36px; width: 52px; cursor: pointer; }

        /* ═══════════════════════════════════════
           ALERTS
        ═══════════════════════════════════════ */
        .alert { border-radius: var(--r-sm); font-size: 13px; padding: 12px 16px; border: none; }
        .alert-success { background: #d1fae5; color: #065f46; }
        .alert-danger  { background: #ffe4e6; color: #9f1239; }

        /* ═══════════════════════════════════════
           BOOTSTRAP 5 PAGINATION OVERRIDE
        ═══════════════════════════════════════ */
        .pagination { gap: 3px; }

        .pagination .page-item .page-link {
            font-size: 12.5px; font-weight: 500;
            border-radius: 7px !important;
            border: 1.5px solid var(--border);
            color: var(--muted);
            padding: 6px 12px;
            background: var(--white);
            transition: all .14s;
            line-height: 1.4;
        }

        .pagination .page-item .page-link:hover {
            background: var(--indigo-l);
            border-color: #c7d2fe;
            color: #6366f1;
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #6366f1, #4f46e5) !important;
            border-color: #6366f1 !important;
            color: #fff !important;
            box-shadow: 0 2px 8px rgba(99,102,241,.35);
        }

        .pagination .page-item.disabled .page-link {
            background: #f8fafc; color: #cbd5e1; border-color: var(--border);
        }

        /* ═══════════════════════════════════════
           MISC
        ═══════════════════════════════════════ */
        .empty-state {
            text-align: center; padding: 52px 20px; color: var(--muted);
        }
        .empty-state i { font-size: 36px; opacity: .3; display: block; margin-bottom: 10px; }
        .empty-state p { font-size: 13px; }

        .progress { height: 6px; border-radius: 10px; background: #f1f5f9; }
        .progress-bar { border-radius: 10px; }

        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

        code {
            background: #f1f5f9; color: #6366f1;
            padding: 2px 7px; border-radius: 5px;
            font-size: 12px;
        }
    </style>
</head>
<body>

{{-- ═══ SIDEBAR ═══ --}}
<aside class="sidebar">
    <div class="sb-brand">
        <div class="sb-logo"><i class="bi bi-shop-window"></i></div>
        <div class="sb-brand-text">
            <div class="sb-brand-name">{{ config('app.name') }}</div>
            <div class="sb-brand-sub">Admin Panel</div>
        </div>
    </div>

    <nav class="sb-nav">
        <div class="sb-label">Overview</div>

        <a href="{{ route('admin.dashboard') }}"
           class="sb-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="sb-icon"><i class="bi bi-grid-1x2"></i></span>
            Dashboard
        </a>

        <div class="sb-label">Catalogue</div>

        <a href="{{ route('admin.products.index') }}"
           class="sb-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <span class="sb-icon"><i class="bi bi-box-seam"></i></span>
            Products
        </a>

        <a href="{{ route('admin.categories.index') }}"
           class="sb-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <span class="sb-icon"><i class="bi bi-diagram-3"></i></span>
            Categories
        </a>

        <a href="{{ route('admin.brands.index') }}"
           class="sb-link {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
            <span class="sb-icon"><i class="bi bi-award"></i></span>
            Brands
        </a>

        <div class="sb-label">Configuration</div>

        <a href="{{ route('admin.properties.index') }}"
           class="sb-link {{ request()->routeIs('admin.properties.*') ? 'active' : '' }}">
            <span class="sb-icon"><i class="bi bi-sliders2"></i></span>
            Properties
        </a>
    </nav>

    <div class="sb-footer">
        <div class="sb-user">
            <div class="sb-avatar">A</div>
            <div>
                <div class="sb-uname">Admin</div>
                <div class="sb-urole">Super Admin</div>
            </div>
            <i class="bi bi-three-dots-vertical ms-auto" style="color:#475569;font-size:13px"></i>
        </div>
    </div>
</aside>

{{-- ═══ TOPBAR ═══ --}}
<header class="topbar">
    <div>
        <div class="tb-page">@yield('title', 'Dashboard')</div>
        <div class="tb-crumb">
            <i class="bi bi-house" style="font-size:10px"></i>
            Admin @hasSection('title') &rsaquo; @yield('title') @endif
        </div>
    </div>
    <div class="tb-actions">
        <button class="tb-btn" title="Search"><i class="bi bi-search"></i></button>
        <button class="tb-btn" title="Notifications"><i class="bi bi-bell"></i></button>
        <div class="tb-divider"></div>
        <div class="tb-user-pill">
            <div class="tb-pill-avatar">A</div>
            <span class="tb-pill-name">Admin</span>
            <i class="bi bi-chevron-down" style="font-size:10px;color:var(--muted)"></i>
        </div>
    </div>
</header>

{{-- ═══ MAIN ═══ --}}
<div class="main-wrap">
    <div class="main-body">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 mb-4">
                <i class="bi bi-check-circle-fill"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 mb-4">
                <i class="bi bi-exclamation-circle-fill"></i>
                <span>{{ session('error') }}</span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
