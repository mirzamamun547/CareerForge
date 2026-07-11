<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Admin Panel') — CareerForge</title>

        <!-- Bootstrap 5 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <style>
            :root {
                --indigo: #4F46E5;
                --indigo-dark: #4338CA;
                --indigo-bg: #EEF2FF;
                --emerald: #10B981;
                --emerald-bg: #ECFDF5;
                --rose: #F43F5E;
                --rose-bg: #FFF1F2;
                --amber: #D97706;
                --amber-bg: #FEF3C7;
                --text: #2D3142;
                --muted: #6B7280;
                --muted-light: #9CA3AF;
                --border: #E5E7EB;
                --bg: #F8F9FD;
                --card: #ffffff;
            }

            * { box-sizing: border-box; }

            body {
                font-family: 'Plus Jakarta Sans', system-ui, -apple-system, 'Segoe UI', sans-serif;
                background: var(--bg);
                color: var(--text);
                overflow-x: hidden;
                margin: 0;
            }

            /* ── Sidebar ── */
            .sidebar {
                width: 260px;
                height: 100vh;
                position: fixed;
                top: 0; bottom: 0; left: 0;
                z-index: 1030;
                background: var(--card);
                border-right: 1px solid var(--border);
                display: flex;
                flex-direction: column;
                transition: transform 0.3s ease-in-out;
                overflow: hidden;
            }
            .sidebar-top {
                padding: 1.5rem 1.25rem 0.5rem;
                flex-shrink: 0;
            }
            .sidebar-nav {
                flex: 1;
                overflow-y: auto;
                padding: 0.5rem 1rem;
                scrollbar-width: thin;
                scrollbar-color: #E5E7EB transparent;
            }
            .sidebar-nav::-webkit-scrollbar { width: 4px; }
            .sidebar-nav::-webkit-scrollbar-track { background: transparent; }
            .sidebar-nav::-webkit-scrollbar-thumb { background: #E5E7EB; border-radius: 4px; }
            .sidebar-bottom {
                padding: 0.75rem 1rem 1.25rem;
                border-top: 1px solid #F3F4F6;
                flex-shrink: 0;
            }

            /* ── Nav ── */
            .nav-label-group {
                font-size: 0.62rem;
                text-transform: uppercase;
                letter-spacing: 0.07em;
                color: var(--muted-light);
                font-weight: 700;
                padding: 0.9rem 0.5rem 0.4rem;
            }
            .nav-link-custom {
                display: flex;
                align-items: center;
                gap: 0.7rem;
                padding: 0.6rem 0.85rem;
                border-radius: 0.65rem;
                color: var(--muted);
                font-size: 0.855rem;
                font-weight: 600;
                text-decoration: none;
                transition: all 0.18s;
                margin-bottom: 2px;
                border: none;
                background: none;
                width: 100%;
                text-align: left;
                cursor: pointer;
            }
            .nav-link-custom:hover { color: var(--indigo); background: #F5F5FF; }
            .nav-link-custom.active { color: var(--indigo); background: var(--indigo-bg); }
            .nav-link-custom i { font-size: 1rem; width: 1.25rem; text-align: center; flex-shrink: 0; }
            .nav-link-custom .count-pill {
                margin-left: auto;
                background: var(--rose);
                color: #fff;
                font-size: 0.62rem;
                font-weight: 700;
                padding: 0.15em 0.5em;
                border-radius: 50rem;
                min-width: 1.2em;
                text-align: center;
            }

            /* ── Main ── */
            .main-content {
                margin-left: 260px;
                min-height: 100vh;
                padding: 2.25rem 2.5rem;
                display: flex;
                flex-direction: column;
                gap: 1.5rem;
                transition: margin-left 0.3s ease-in-out;
            }

            /* ── Top Header ── */
            .top-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 0.75rem;
                padding-bottom: 1rem;
                border-bottom: 1px solid #F3F4F6;
            }
            .admin-chip {
                display: flex;
                align-items: center;
                gap: 0.6rem;
                background: var(--card);
                border: 1px solid var(--border);
                border-radius: 50rem;
                padding: 0.4rem 0.85rem 0.4rem 0.4rem;
            }
            .avatar-dot {
                width: 2rem; height: 2rem;
                border-radius: 50%;
                background: linear-gradient(135deg, #4F46E5, #7C3AED);
                color: #fff;
                display: flex; align-items: center; justify-content: center;
                font-weight: 800; font-size: 0.7rem;
            }

            /* ── Cards ── */
            .card-custom {
                border: none;
                border-radius: 1rem;
                box-shadow: 0 4px 18px rgba(0,0,0,0.03);
                background: var(--card);
            }

            /* ── Stat Cards ── */
            .stat-icon {
                width: 2.4rem; height: 2.4rem;
                border-radius: 0.65rem;
                display: flex; align-items: center; justify-content: center;
                flex-shrink: 0;
            }
            .stat-value { font-size: 1.65rem; font-weight: 800; line-height: 1.1; }
            .stat-trend { font-size: 0.72rem; font-weight: 700; }
            .trend-up { color: var(--emerald); }
            .trend-down { color: var(--rose); }

            /* ── Badges ── */
            .badge-custom-indigo  { color:var(--indigo); background:var(--indigo-bg); font-weight:700; font-size:0.65rem; padding:0.3em 0.7em; border-radius:50rem; white-space:nowrap; }
            .badge-custom-emerald { color:var(--emerald); background:var(--emerald-bg); font-weight:700; font-size:0.65rem; padding:0.3em 0.7em; border-radius:50rem; white-space:nowrap; }
            .badge-custom-rose    { color:var(--rose); background:var(--rose-bg); font-weight:700; font-size:0.65rem; padding:0.3em 0.7em; border-radius:50rem; white-space:nowrap; }
            .badge-custom-amber   { color:var(--amber); background:var(--amber-bg); font-weight:700; font-size:0.65rem; padding:0.3em 0.7em; border-radius:50rem; white-space:nowrap; }
            .badge-custom-gray    { color:var(--muted); background:#F3F4F6; font-weight:700; font-size:0.65rem; padding:0.3em 0.7em; border-radius:50rem; white-space:nowrap; }

            /* ── Buttons ── */
            .btn-primary-custom {
                background: var(--indigo); color: #fff;
                padding: 0.45rem 0.95rem; border-radius: 0.6rem;
                font-size: 0.78rem; font-weight: 700;
                border: none; cursor: pointer;
                display: inline-flex; align-items: center; gap: 0.35rem;
                text-decoration: none; transition: background 0.18s;
                font-family: inherit;
            }
            .btn-primary-custom:hover { background: var(--indigo-dark); color: #fff; }
            .btn-ghost-custom {
                background: #F3F4F6; color: #4B5563;
                padding: 0.45rem 0.9rem; border-radius: 0.6rem;
                font-size: 0.78rem; font-weight: 700;
                border: none; cursor: pointer;
                display: inline-flex; align-items: center; gap: 0.35rem;
                text-decoration: none; transition: background 0.18s;
                font-family: inherit;
            }
            .btn-ghost-custom:hover { background: #E5E7EB; color: #1F2937; }
            .btn-emerald-custom {
                background: var(--emerald-bg); color: var(--emerald);
                padding: 0.45rem 0.9rem; border-radius: 0.6rem;
                font-size: 0.78rem; font-weight: 700;
                border: none; cursor: pointer;
                display: inline-flex; align-items: center; gap: 0.35rem;
                text-decoration: none; transition: all 0.18s;
                font-family: inherit;
            }
            .btn-emerald-custom:hover { background: #D1FAE5; color: #059669; }
            .btn-rose-custom {
                background: var(--rose-bg); color: var(--rose);
                padding: 0.45rem 0.9rem; border-radius: 0.6rem;
                font-size: 0.78rem; font-weight: 700;
                border: none; cursor: pointer;
                display: inline-flex; align-items: center; gap: 0.35rem;
                text-decoration: none; transition: all 0.18s;
                font-family: inherit;
            }
            .btn-rose-custom:hover { background: #FFE4E6; color: #E11D48; }

            /* ── Tables ── */
            .admin-table { width: 100%; border-collapse: collapse; font-size: 0.83rem; }
            .admin-table thead th {
                text-align: left; color: var(--muted); font-weight: 700;
                font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.04em;
                padding: 0 0.75rem 0.75rem; border-bottom: 1px solid var(--border);
            }
            .admin-table tbody td { padding: 0.85rem 0.75rem; border-bottom: 1px solid #F3F4F6; vertical-align: middle; }
            .admin-table tbody tr:last-child td { border-bottom: none; }
            .admin-table tbody tr:hover { background: #FAFAFC; }

            /* ── Tab pills ── */
            .tab-pills { display: flex; gap: 0.35rem; background: #F3F4F6; padding: 0.3rem; border-radius: 0.75rem; }
            .tab-pill {
                border: none; background: none;
                padding: 0.45rem 0.9rem; border-radius: 0.55rem;
                font-size: 0.78rem; font-weight: 700; color: var(--muted);
                cursor: pointer; font-family: inherit; transition: all 0.15s;
            }
            .tab-pill.active { background: #fff; color: var(--indigo); box-shadow: 0 1px 4px rgba(0,0,0,0.06); }

            /* ── Search ── */
            .search-wrap { position: relative; }
            .search-wrap input {
                padding: 0.58rem 1rem 0.58rem 2.2rem;
                border-radius: 0.65rem;
                border: 1px solid var(--border);
                background: #F9FAFB;
                font-size: 0.82rem;
                width: 230px;
                font-family: inherit;
                outline: none;
                transition: border-color 0.18s;
            }
            .search-wrap input:focus { border-color: var(--indigo); }
            .search-wrap .search-icon {
                position: absolute; left: 0.7rem; top: 50%;
                transform: translateY(-50%); color: var(--muted-light);
                pointer-events: none;
            }

            /* ── Bar chart ── */
            .bar-chart-wrap { display: flex; align-items: flex-end; gap: 0.85rem; height: 150px; padding-top: 0.5rem; }
            .bar-col { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 0.45rem; height: 100%; justify-content: flex-end; }
            .bar-col-fill { width: 100%; max-width: 32px; border-radius: 0.4rem 0.4rem 0 0; }
            .bar-col-label { font-size: 0.67rem; color: var(--muted); font-weight: 600; }

            /* ── Horizontal bars ── */
            .hbar-row { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.8rem; }
            .hbar-label { width: 105px; font-size: 0.78rem; font-weight: 600; color: #4B5563; flex-shrink: 0; }
            .hbar-track { flex: 1; height: 9px; background: #F3F4F6; border-radius: 50rem; overflow: hidden; }
            .hbar-fill { height: 100%; border-radius: 50rem; }
            .hbar-value { width: 34px; text-align: right; font-size: 0.78rem; font-weight: 700; color: var(--muted); }

            /* ── Funnel ── */
            .funnel-row { display: flex; align-items: center; gap: 1rem; margin-bottom: 0.85rem; }
            .funnel-label { width: 110px; font-size: 0.8rem; font-weight: 600; color: #4B5563; flex-shrink: 0; }
            .funnel-bar-wrap { flex: 1; }
            .funnel-bar { height: 32px; border-radius: 0.45rem; display: flex; align-items: center; padding: 0 0.9rem; color: #fff; font-weight: 700; font-size: 0.78rem; }
            .funnel-count { width: 46px; text-align: right; font-size: 0.8rem; font-weight: 700; color: var(--muted); }

            /* ── Activity ── */
            .activity-item { display: flex; gap: 0.85rem; padding: 0.8rem 0; border-bottom: 1px solid #F3F4F6; }
            .activity-item:last-child { border-bottom: none; }
            .activity-dot { width: 2rem; height: 2rem; border-radius: 50%; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; }
            .activity-text { font-size: 0.82rem; }
            .activity-time { font-size: 0.71rem; color: var(--muted-light); }

            /* ── Lists ── */
            .attention-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.55rem; }
            .attention-list li {
                display: flex; align-items: center; justify-content: space-between;
                font-size: 0.82rem; background: #F9FAFB;
                border: 1px solid var(--border); border-radius: 0.65rem;
                padding: 0.6rem 0.85rem;
            }

            /* ── Taxonomy list ── */
            .item-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.55rem; }
            .item-list li {
                display: flex; align-items: center; justify-content: space-between;
                font-size: 0.83rem; background: #F9FAFB;
                border: 1px solid var(--border); border-radius: 0.65rem;
                padding: 0.6rem 0.85rem;
            }

            /* ── Settings toggle ── */
            .switch-row { display: flex; align-items: center; justify-content: space-between; padding: 1rem 0; border-bottom: 1px solid #F3F4F6; }
            .switch-row:last-child { border-bottom: none; }
            .switch-label { font-size: 0.88rem; font-weight: 700; color: var(--text); }
            .switch-desc { font-size: 0.75rem; color: var(--muted); margin-top: 0.15rem; }
            .toggle-switch { width: 42px; height: 24px; background: #E5E7EB; border-radius: 50rem; position: relative; cursor: pointer; flex-shrink: 0; transition: background 0.2s; }
            .toggle-switch.on { background: var(--indigo); }
            .toggle-switch .knob { width: 18px; height: 18px; background: #fff; border-radius: 50%; position: absolute; top: 3px; left: 3px; transition: left 0.18s; box-shadow: 0 1px 3px rgba(0,0,0,0.15); }
            .toggle-switch.on .knob { left: 21px; }

            /* ── Form ── */
            .form-control-custom {
                padding: 0.6rem 0.9rem; border-radius: 0.6rem;
                border: 1px solid var(--border); font-size: 0.83rem;
                background: #F9FAFB; outline: none; font-family: inherit;
                transition: border-color 0.18s;
            }
            .form-control-custom:focus { border-color: var(--indigo); background: #fff; }

            /* ── Section heading ── */
            .section-title {
                font-size: 0.93rem; font-weight: 800; margin-bottom: 1rem;
                display: flex; align-items: center; gap: 0.5rem; color: var(--text);
            }

            /* ── Sidebar backdrop ── */
            .sidebar-backdrop {
                position: fixed; top: 0; left: 0; right: 0; bottom: 0;
                background: rgba(0,0,0,0.28); backdrop-filter: blur(3px);
                z-index: 1020; display: none;
            }

            /* ── Responsive ── */
            @media (max-width: 991.98px) {
                .sidebar { transform: translateX(-100%); }
                .sidebar.show { transform: translateX(0); }
                .main-content { margin-left: 0; padding: 1.25rem; }
                .sidebar-backdrop.show { display: block; }
            }
        </style>

        @stack('styles')
    </head>
    <body>
        <div id="sidebarBackdrop" class="sidebar-backdrop"></div>

        <!-- ═══ SIDEBAR ═══ -->
        <aside id="sidebarMenu" class="sidebar">
            <div class="sidebar-top">
                <!-- Brand -->
                <a href="/" class="d-flex align-items-center gap-2 text-decoration-none mb-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:2.1rem;height:2.1rem;background:linear-gradient(135deg,#4F46E5,#7C3AED);">
                        <i class="bi bi-shield-lock-fill text-white" style="font-size:0.9rem;"></i>
                    </div>
                    <div>
                        <div class="fw-bold text-dark lh-1" style="font-size:1rem;font-weight:800;">CareerForge</div>
                        <div class="fw-bold" style="font-size:0.55rem;letter-spacing:0.07em;color:#4F46E5;text-transform:uppercase;">Admin Panel</div>
                    </div>
                </a>

                <!-- Admin chip -->
                <div class="d-flex align-items-center gap-2 p-2 rounded-3 mb-1" style="background:#F9FAFB;border:1px solid #F3F4F6;">
                    <div class="avatar-dot flex-shrink-0">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                    <div class="overflow-hidden">
                        <div class="fw-bold text-dark text-truncate" style="font-size:0.8rem;">{{ Auth::user()->name }}</div>
                        <div class="text-secondary text-truncate" style="font-size:0.68rem;">Super Admin</div>
                    </div>
                </div>
            </div>

            <!-- Nav -->
            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" class="nav-link-custom {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-fill"></i> Dashboard
                </a>

                <div class="nav-label-group">People</div>
                <a href="{{ route('admin.users') }}" class="nav-link-custom {{ Request::is('admin/users') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i> Manage Users
                </a>
                <a href="{{ route('admin.verification') }}" class="nav-link-custom {{ Request::is('admin/verification') ? 'active' : '' }}">
                    <i class="bi bi-envelope-check-fill"></i>
                    Employer Verification
                    @php $pendingCount = \App\Models\User::where('role','employer')->where('verified', false)->count(); @endphp
                    @if($pendingCount > 0)
                        <span class="count-pill">{{ $pendingCount }}</span>
                    @endif
                </a>

                <div class="nav-label-group">Content</div>
                <a href="{{ route('admin.jobs') }}" class="nav-link-custom {{ Request::is('admin/jobs') ? 'active' : '' }}">
                    <i class="bi bi-briefcase-fill"></i> Manage Jobs
                </a>
                <a href="{{ route('admin.taxonomy') }}" class="nav-link-custom {{ Request::is('admin/taxonomy') ? 'active' : '' }}">
                    <i class="bi bi-tags-fill"></i> Categories &amp; Skills
                </a>
                <a href="{{ route('admin.resumes') }}" class="nav-link-custom {{ Request::is('admin/resumes') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-check-fill"></i> Resume Reviews
                </a>

                <div class="nav-label-group">Insights</div>
                <a href="{{ route('admin.reports') }}" class="nav-link-custom {{ Request::is('admin/reports') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart-fill"></i> Reports &amp; Analytics
                </a>
                <a href="{{ route('admin.activity') }}" class="nav-link-custom {{ Request::is('admin/activity') ? 'active' : '' }}">
                    <i class="bi bi-clock-history"></i> Activity Log
                </a>
                <a href="{{ route('admin.settings') }}" class="nav-link-custom {{ Request::is('admin/settings') ? 'active' : '' }}">
                    <i class="bi bi-gear-fill"></i> Settings
                </a>
            </nav>

            <!-- Logout -->
            <div class="sidebar-bottom">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" class="nav-link-custom" style="color:var(--rose);"
                       onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </form>
            </div>
        </aside>

        <!-- ═══ MAIN CONTENT ═══ -->
        <main class="main-content">
            <!-- Top Header -->
            <header class="top-header">
                <div class="d-flex align-items-center gap-3">
                    <button id="sidebarToggle" class="d-lg-none btn btn-white border rounded-3 p-2 lh-1" style="border-color:#E5E7EB;">
                        <i class="bi bi-list fs-5 text-dark"></i>
                    </button>
                    <div>
                        <h1 class="m-0 lh-1" style="font-size:1.45rem;font-weight:800;">@yield('header_title', 'Admin Dashboard')</h1>
                        @hasSection('header_subtitle')
                            <p class="m-0 mt-1 text-secondary" style="font-size:0.82rem;">@yield('header_subtitle')</p>
                        @endif
                    </div>
                </div>
                <div class="admin-chip">
                    <div class="avatar-dot">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                    <div>
                        <div style="font-weight:700; font-size:0.82rem;">{{ Auth::user()->name }}</div>
                        <div style="font-size:0.68rem; color:var(--muted);">Super Admin</div>
                    </div>
                </div>
            </header>

            @yield('content')
        </main>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Sidebar toggle -->
        <script>
            const sidebar  = document.getElementById('sidebarMenu');
            const backdrop = document.getElementById('sidebarBackdrop');
            const toggleBtn = document.getElementById('sidebarToggle');
            function toggleSidebar() {
                sidebar.classList.toggle('show');
                backdrop.classList.toggle('show');
            }
            if (toggleBtn)  toggleBtn.addEventListener('click', toggleSidebar);
            if (backdrop)   backdrop.addEventListener('click', toggleSidebar);
        </script>

        @stack('scripts')
    </body>
</html>
