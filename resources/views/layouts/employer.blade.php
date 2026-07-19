<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'Employer Panel') - CareerForge</title>

        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
                background-color: #F8F9FD;
                color: #2D3142;
                overflow-x: hidden;
            }
            .sidebar {
                width: 260px;
                height: 100vh;
                position: fixed;
                top: 0;
                bottom: 0;
                left: 0;
                z-index: 1030;
                background-color: #ffffff;
                border-right: 1px solid #E5E7EB;
                transition: transform 0.3s ease-in-out;
            }
            .main-content {
                margin-left: 260px;
                min-height: 100vh;
                padding: 2.5rem;
                transition: margin-left 0.3s ease-in-out;
            }
            .nav-link-custom {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                padding: 0.75rem 1rem;
                border-radius: 0.75rem;
                color: #6B7280;
                font-size: 0.875rem;
                font-weight: 600;
                text-decoration: none;
                transition: all 0.2s;
            }
            .nav-link-custom:hover {
                color: #4F46E5;
                background-color: #F9FAFB;
            }
            .nav-link-custom.active {
                color: #4F46E5;
                background-color: #EEF2FF;
            }
            .badge-custom-indigo {
                color: #4F46E5;
                background-color: #EEF2FF;
                font-weight: 700;
                font-size: 0.65rem;
                padding: 0.35em 0.65em;
                border-radius: 50rem;
            }
            .badge-custom-emerald {
                color: #10B981;
                background-color: #ECFDF5;
                font-weight: 700;
                font-size: 0.65rem;
                padding: 0.35em 0.65em;
                border-radius: 50rem;
            }
            .badge-custom-rose {
                color: #F43F5E;
                background-color: #FFF1F2;
                font-weight: 700;
                font-size: 0.65rem;
                padding: 0.35em 0.65em;
                border-radius: 50rem;
            }
            .badge-custom-amber {
                color: #D97706;
                background-color: #FEF3C7;
                font-weight: 700;
                font-size: 0.65rem;
                padding: 0.35em 0.65em;
                border-radius: 50rem;
            }
            .icon-shape {
                width: 2.5rem;
                height: 2.5rem;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 0.5rem;
            }
            .sidebar-backdrop {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.3);
                backdrop-filter: blur(4px);
                z-index: 1020;
                display: none;
            }
            
            /* Custom form and card styling matching high aesthetic standard */
            .card-custom {
                border: none;
                border-radius: 1rem;
                box-shadow: 0 4px 18px 0 rgba(0, 0, 0, 0.03);
                background-color: #ffffff;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }
            .form-control-custom {
                padding: 0.75rem 1rem;
                border-radius: 0.75rem;
                border: 1px solid #E5E7EB;
                font-size: 0.9rem;
                background-color: #F9FAFB;
                transition: all 0.2s;
            }
            .form-control-custom:focus {
                background-color: #ffffff;
                border-color: #4F46E5;
                box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
            }
            .btn-primary-custom {
                background-color: #4F46E5;
                border-color: #4F46E5;
                color: #ffffff;
                padding: 0.75rem 1.5rem;
                border-radius: 0.75rem;
                font-weight: 600;
                font-size: 0.9rem;
                transition: all 0.2s;
            }
            .btn-primary-custom:hover {
                background-color: #4338CA;
                border-color: #4338CA;
                color: #ffffff;
            }
            .btn-secondary-custom {
                background-color: #F3F4F6;
                border-color: #F3F4F6;
                color: #4B5563;
                padding: 0.75rem 1.5rem;
                border-radius: 0.75rem;
                font-weight: 600;
                font-size: 0.9rem;
                transition: all 0.2s;
            }
            .btn-secondary-custom:hover {
                background-color: #E5E7EB;
                border-color: #E5E7EB;
                color: #1F2937;
            }
            .btn-warning-custom {
                background-color: #FEF3C7;
                border: 1px solid #FDE68A;
                color: #D97706;
                padding: 0.5rem 1rem;
                border-radius: 0.5rem;
                font-weight: 600;
                font-size: 0.85rem;
                transition: all 0.2s;
            }
            .btn-warning-custom:hover {
                background-color: #FDE68A;
                color: #B45309;
            }
            
            @media (max-width: 991.98px) {
                .sidebar {
                    transform: translateX(-100%);
                }
                .sidebar.show {
                    transform: translateX(0);
                }
                .main-content {
                    margin-left: 0;
                    padding: 1.5rem;
                }
                .sidebar-backdrop.show {
                    display: block;
                }
            }
        </style>
    </head>
    <body>

        <!-- Sidebar Backdrop Overlay -->
        <div id="sidebarBackdrop" class="sidebar-backdrop"></div>

        <!-- Sidebar Navigation -->
        <aside id="sidebarMenu" class="sidebar d-flex flex-column justify-content-between p-4">
            <div>
                <!-- Logo -->
                <a href="/" class="d-flex align-items-center gap-3 text-decoration-none px-2 mb-4">
                    <div class="bg-primary bg-gradient rounded-3 d-flex align-items-center justify-content-center" style="width: 2.25rem; height: 2.25rem; background-color: #4F46E5 !important;">
                        <i class="bi bi-briefcase-fill text-white fs-5"></i>
                    </div>
                    <div>
                        <span class="fw-bolder text-dark block m-0 leading-tight" style="font-size: 1.05rem;">CareerForge</span>
                        <span class="text-uppercase block text-primary fw-bold" style="font-size: 0.55rem; letter-spacing: 0.05em; background-color: transparent !important; color: #4F46E5 !important;">Employer</span>
                    </div>
                </a>

                <!-- Navigation List -->
                <nav class="d-flex flex-column gap-1">
                    <a href="/employer/dashboard" class="nav-link-custom {{ Request::is('employer/dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid-fill fs-5"></i>
                        Dashboard
                    </a>
                    <a href="/employer/jobs" class="nav-link-custom {{ Request::is('employer/jobs') ? 'active' : '' }}">
                        <i class="bi bi-plus-circle fs-5"></i>
                        Post a Job
                    </a>
                    <a href="/employer/manage-jobs" class="nav-link-custom {{ Request::is('employer/manage-jobs') ? 'active' : '' }}">
                        <i class="bi bi-list-task fs-5"></i>
                        Manage Jobs
                    </a>
                    <a href="/employer/applicants" class="nav-link-custom {{ Request::is('employer/applicants') || Request::is('employer/applicant-details') ? 'active' : '' }}">
                        <i class="bi bi-people fs-5"></i>
                        Applicants
                    </a>
                    <a href="/employer/interview-schedule" class="nav-link-custom {{ Request::is('employer/interview-schedule') || Request::is('employer/schedule-interview') ? 'active' : '' }}">
                        <i class="bi bi-calendar-event fs-5"></i>
                        Interview Schedule
                    </a>
                    <a href="/employer/company-profile" class="nav-link-custom {{ Request::is('employer/company-profile') ? 'active' : '' }}">
                        <i class="bi bi-building fs-5"></i>
                        Company Profile
                    </a>
                    <a href="/employer/notifications" class="nav-link-custom {{ Request::is('employer/notifications') ? 'active' : '' }}">
                        <i class="bi bi-bell fs-5"></i>
                        Notifications
                        @if(auth()->user()->unreadNotifications()->count() > 0)
                            <span class="badge bg-danger ms-auto rounded-pill" style="font-size: 0.65rem; padding: 0.25em 0.55em;">{{ auth()->user()->unreadNotifications()->count() }}</span>
                        @endif
                    </a>
                </nav>
            </div>

            <!-- Logout -->
          <!-- Logout -->
<div class="pt-3 border-top border-light">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <a href="{{ route('logout') }}" class="nav-link-custom text-danger hover:bg-danger-subtle"
           onclick="event.preventDefault(); this.closest('form').submit();">
            <i class="bi bi-box-arrow-right fs-5"></i>
            Logout
        </a>
    </form>
</div>
        </aside>

        <!-- Main Content Area -->
        <main class="main-content d-flex flex-column gap-4">
            <!-- Header section with toggle -->
            <header class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <button id="sidebarToggle" class="btn btn-white border border-light-subtle rounded-3 d-lg-none py-2 px-2.5">
                        <i class="bi bi-list fs-4 text-dark"></i>
                    </button>
                    <div>
                        <h1 class="fw-extrabold text-dark m-0 leading-tight" style="font-size: 1.5rem; font-weight: 800;">@yield('header_title', 'Employer Panel')</h1>
                        <p class="text-secondary m-0 mt-1" style="font-size: 0.85rem;">@yield('header_subtitle', '')</p>
                    </div>
                </div>
            </header>

            @yield('content')
        </main>

        <!-- Bootstrap Bundle with Popper JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

        @stack('scripts')

        <!-- Toggle Sidebar Script -->
        <script>
            const sidebar = document.getElementById('sidebarMenu');
            const backdrop = document.getElementById('sidebarBackdrop');
            const toggleBtn = document.getElementById('sidebarToggle');

            function toggleSidebar() {
                sidebar.classList.toggle('show');
                backdrop.classList.toggle('show');
            }

            if (toggleBtn && backdrop) {
                toggleBtn.addEventListener('click', toggleSidebar);
                backdrop.addEventListener('click', toggleSidebar);
            }
        </script>
    </body>
</html>
