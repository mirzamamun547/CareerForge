<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Student Panel') - CareerForge</title>

        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <style>
            * { box-sizing: border-box; }

            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
                background-color: #F8F9FD;
                color: #2D3142;
                overflow-x: hidden;
                margin: 0;
            }

            /* ── Sidebar ── */
            .sidebar {
                width: 240px;
                height: 100vh;
                position: fixed;
                top: 0; bottom: 0; left: 0;
                z-index: 1030;
                background-color: #ffffff;
                border-right: 1px solid #E5E7EB;
                display: flex;
                flex-direction: column;
                transition: transform 0.3s ease-in-out;
                overflow: hidden;
            }
            .sidebar-top {
                padding: 1.25rem 1.25rem 0.5rem;
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

            /* ── Nav Links ── */
            .nav-link-custom {
                display: flex;
                align-items: center;
                gap: 0.7rem;
                padding: 0.65rem 0.85rem;
                border-radius: 0.65rem;
                color: #6B7280;
                font-size: 0.85rem;
                font-weight: 600;
                text-decoration: none;
                transition: all 0.18s;
                margin-bottom: 2px;
            }
            .nav-link-custom:hover {
                color: #4F46E5;
                background-color: #F5F5FF;
            }
            .nav-link-custom.active {
                color: #4F46E5;
                background-color: #EEF2FF;
            }
            .nav-link-custom i { font-size: 1.05rem; width: 1.25rem; text-align: center; }

            /* ── Notification dot on bell ── */
            .notif-badge {
                width: 7px; height: 7px;
                border-radius: 50%;
                background: #F43F5E;
                margin-left: auto;
                flex-shrink: 0;
            }

            /* ── Main Content ── */
            .main-content {
                margin-left: 240px;
                min-height: 100vh;
                padding: 2rem 2.25rem;
                display: flex;
                flex-direction: column;
                gap: 1.5rem;
                transition: margin-left 0.3s ease-in-out;
            }

            /* ── Top Header Bar ── */
            .top-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-wrap: wrap;
                gap: 0.75rem;
                padding-bottom: 1rem;
                border-bottom: 1px solid #F3F4F6;
            }
            .user-chip {
                display: flex;
                align-items: center;
                gap: 0.6rem;
                padding: 0.4rem 0.85rem 0.4rem 0.4rem;
                border: 1.5px solid #E5E7EB;
                border-radius: 50rem;
                background: #fff;
                cursor: pointer;
                transition: border-color 0.18s, box-shadow 0.18s;
            }
            .user-chip:hover { border-color: #C7D2FE; box-shadow: 0 2px 8px rgba(79,70,229,0.08); }
            .user-avatar {
                width: 1.85rem; height: 1.85rem;
                border-radius: 50%;
                background: linear-gradient(135deg, #4F46E5, #7C3AED);
                color: #fff;
                display: flex; align-items: center; justify-content: center;
                font-size: 0.7rem; font-weight: 800;
            }
            .user-name { font-size: 0.78rem; font-weight: 700; color: #2D3142; }
            .user-role { font-size: 0.62rem; color: #9CA3AF; }
            .notif-btn {
                position: relative;
                width: 2.2rem; height: 2.2rem;
                border-radius: 50%;
                border: 1.5px solid #E5E7EB;
                background: #fff;
                display: flex; align-items: center; justify-content: center;
                color: #6B7280; font-size: 1rem;
                transition: all 0.18s;
                text-decoration: none;
            }
            .notif-btn:hover { border-color: #4F46E5; color: #4F46E5; background: #EEF2FF; }
            .notif-btn .dot {
                position: absolute;
                top: 3px; right: 3px;
                width: 7px; height: 7px;
                border-radius: 50%; background: #F43F5E;
                border: 1.5px solid #fff;
            }

            /* ── Sidebar Backdrop ── */
            .sidebar-backdrop {
                position: fixed; top: 0; left: 0; right: 0; bottom: 0;
                background-color: rgba(0,0,0,0.28);
                backdrop-filter: blur(3px);
                z-index: 1020;
                display: none;
            }

            /* ── Global Card / Form Styles ── */
            .card-custom {
                border: none;
                border-radius: 1rem;
                box-shadow: 0 2px 16px rgba(0,0,0,0.04);
                background-color: #ffffff;
            }
            .form-control-custom {
                padding: 0.7rem 1rem;
                border-radius: 0.75rem;
                border: 1.5px solid #E5E7EB;
                font-size: 0.88rem;
                background-color: #F9FAFB;
                transition: all 0.2s;
                width: 100%;
                outline: none;
                font-family: inherit;
            }
            .form-control-custom:focus {
                background-color: #ffffff;
                border-color: #4F46E5;
                box-shadow: 0 0 0 4px rgba(79,70,229,0.09);
            }
            .btn-primary-custom {
                background-color: #4F46E5;
                border-color: #4F46E5;
                color: #ffffff;
                padding: 0.65rem 1.35rem;
                border-radius: 0.75rem;
                font-weight: 700;
                font-size: 0.875rem;
                transition: all 0.2s;
                border: none;
                cursor: pointer;
                font-family: inherit;
            }
            .btn-primary-custom:hover { background-color: #4338CA; color: #ffffff; }
            .btn-secondary-custom {
                background-color: #F3F4F6;
                border: 1.5px solid #E5E7EB;
                color: #4B5563;
                padding: 0.65rem 1.35rem;
                border-radius: 0.75rem;
                font-weight: 700;
                font-size: 0.875rem;
                transition: all 0.2s;
                cursor: pointer;
                font-family: inherit;
            }
            .btn-secondary-custom:hover { background-color: #E5E7EB; color: #1F2937; }
            .btn-outline-custom {
                background-color: #ffffff;
                border: 1.5px solid #E5E7EB;
                color: #4B5563;
                padding: 0.65rem 1.35rem;
                border-radius: 0.75rem;
                font-weight: 700;
                font-size: 0.875rem;
                transition: all 0.2s;
                cursor: pointer;
                font-family: inherit;
            }
            .btn-outline-custom:hover { border-color: #4F46E5; color: #4F46E5; background-color: #EEF2FF; }

            /* ── Badges ── */
            .badge-custom-indigo  { color:#4F46E5; background-color:#EEF2FF; font-weight:700; font-size:0.65rem; padding:0.3em 0.7em; border-radius:50rem; }
            .badge-custom-emerald { color:#10B981; background-color:#ECFDF5; font-weight:700; font-size:0.65rem; padding:0.3em 0.7em; border-radius:50rem; }
            .badge-custom-rose    { color:#F43F5E; background-color:#FFF1F2; font-weight:700; font-size:0.65rem; padding:0.3em 0.7em; border-radius:50rem; }
            .badge-custom-amber   { color:#D97706; background-color:#FEF3C7; font-weight:700; font-size:0.65rem; padding:0.3em 0.7em; border-radius:50rem; }

            /* ── Icon Shape ── */
            .icon-shape {
                width: 2.5rem; height: 2.5rem;
                display: flex; align-items: center; justify-content: center;
                border-radius: 0.5rem;
            }

            /* ── Progress ── */
            .progress-custom { height: 0.5rem; border-radius: 50rem; background-color: #E5E7EB; }
            .progress-custom .progress-bar { border-radius: 50rem; background-color: #4F46E5; }

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

        <!-- Sidebar Backdrop -->
        <div id="sidebarBackdrop" class="sidebar-backdrop"></div>

        <!-- ═══ SIDEBAR ═══ -->
        <aside id="sidebarMenu" class="sidebar">

            <!-- Logo -->
            <div class="sidebar-top">
                <a href="/" class="d-flex align-items-center gap-2 text-decoration-none mb-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:2.1rem;height:2.1rem;background:linear-gradient(135deg,#4F46E5,#7C3AED);">
                        <i class="bi bi-briefcase-fill text-white" style="font-size:0.95rem;"></i>
                    </div>
                    <div>
                        <div class="fw-extrabold text-dark lh-1" style="font-size:1rem;font-weight:800;">CareerForge</div>
                        <div class="fw-bold" style="font-size:0.55rem;letter-spacing:0.07em;color:#4F46E5;text-transform:uppercase;">Student Portal</div>
                    </div>
                </a>

                <!-- User Mini Card -->
                <div class="d-flex align-items-center gap-2 p-2 rounded-3 mb-1" style="background:#F9FAFB;border:1px solid #F3F4F6;">
                    <div class="user-avatar flex-shrink-0" style="width:2.2rem;height:2.2rem;font-size:0.75rem;">RU</div>
                    <div class="overflow-hidden">
                        <div class="fw-bold text-dark text-truncate" style="font-size:0.8rem;">Raihan Uddin</div>
                        <div class="text-secondary text-truncate" style="font-size:0.68rem;">Student</div>
                    </div>
                </div>
            </div>

            <!-- Nav Links -->
            <nav class="sidebar-nav">
                <div class="text-uppercase fw-bold mb-2" style="font-size:0.6rem;letter-spacing:0.08em;color:#C4C9D4;padding:0 0.5rem;">Main Menu</div>

                <a href="/student/dashboard" class="nav-link-custom {{ Request::is('student/dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-fill"></i> Dashboard
                </a>
                <a href="/student/profile" class="nav-link-custom {{ Request::is('student/profile') ? 'active' : '' }}">
                    <i class="bi bi-person-circle"></i> Profile
                </a>
                <a href="/student/resume" class="nav-link-custom {{ Request::is('student/resume') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-arrow-up"></i> Resume
                </a>
                <a href="/student/resume-review" class="nav-link-custom {{ Request::is('student/resume-review') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-check"></i> Resume Review
                </a>

                <div class="text-uppercase fw-bold mt-3 mb-2" style="font-size:0.6rem;letter-spacing:0.08em;color:#C4C9D4;padding:0 0.5rem;">Career</div>

                <a href="/student/skills" class="nav-link-custom {{ Request::is('student/skills') ? 'active' : '' }}">
                    <i class="bi bi-lightning-fill"></i> Skills
                </a>
                <a href="/student/jobs" class="nav-link-custom {{ Request::is('student/jobs') ? 'active' : '' }}">
                    <i class="bi bi-briefcase"></i> Browse Jobs
                </a>
                <a href="/student/applications" class="nav-link-custom {{ Request::is('student/applications') ? 'active' : '' }}">
                    <i class="bi bi-folder2-open"></i> My Applications
                </a>
                <a href="/student/interviews" class="nav-link-custom {{ Request::is('student/interviews') ? 'active' : '' }}">
                    <i class="bi bi-camera-video"></i> Interviews
                </a>

                <div class="text-uppercase fw-bold mt-3 mb-2" style="font-size:0.6rem;letter-spacing:0.08em;color:#C4C9D4;padding:0 0.5rem;">Account</div>

                <a href="/student/notifications" class="nav-link-custom {{ Request::is('student/notifications') ? 'active' : '' }}">
                    <i class="bi bi-bell"></i> Notifications
                    @if(auth()->user()->unreadNotifications()->count() > 0)
                        <span class="badge bg-danger ms-auto rounded-pill" style="font-size: 0.65rem; padding: 0.25em 0.55em;">{{ auth()->user()->unreadNotifications()->count() }}</span>
                    @endif
                </a>
            </nav>

            <!-- Logout -->
           <div class="sidebar-bottom">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <a href="{{ route('logout') }}" class="nav-link-custom" style="color:#F43F5E;"
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
                    <!-- Mobile toggle -->
                    <button id="sidebarToggle" class="d-lg-none btn btn-white border rounded-3 p-2 lh-1" style="border-color:#E5E7EB;">
                        <i class="bi bi-list fs-5 text-dark"></i>
                    </button>
                    <div>
                        <h1 class="m-0 lh-1" style="font-size:1.45rem;font-weight:800;color:#2D3142;">@yield('header_title', 'Dashboard')</h1>
                        @hasSection('header_subtitle')
                            <p class="m-0 mt-1 text-secondary" style="font-size:0.82rem;">@yield('header_subtitle')</p>
                        @endif
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2">
                    @yield('header_actions')
                    <a href="/student/notifications" class="notif-btn">
                        <i class="bi bi-bell"></i>
                        @if(auth()->user()->unreadNotifications()->count() > 0)
                            <span class="dot"></span>
                        @endif
                    </a>
                    <div class="user-chip">
                        @if(Auth::user()->studentProfile && Auth::user()->studentProfile->profile_picture)
                            <img src="{{ asset('storage/' . Auth::user()->studentProfile->profile_picture) }}" alt="Avatar" class="rounded-circle object-cover border" style="width: 32px; height: 32px;">
                        @else
                            <div class="user-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                        @endif
                        <div>
                            <div class="user-name">{{ Auth::user()->name }}</div>
                            <div class="user-role">Student</div>
                        </div>
                        <i class="bi bi-chevron-down ms-1" style="font-size:0.65rem;color:#9CA3AF;"></i>
                    </div>
                </div>
            </header>

            <div class="px-4 px-lg-5 pt-4">
                @if(session('status'))
                    <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 shadow-sm" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3 shadow-sm" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>

            @yield('content')
        </main>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Sidebar Toggle Script -->
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