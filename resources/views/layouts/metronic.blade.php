<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') - Helpdesk</title>
    
    <!-- Global CSS (WAJIB dari template) -->
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet">
    
    @stack('styles')
</head>
<body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" class="app-default">
    
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>
    
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            
            <!-- ========== HEADER SEDERHANA ========== -->
            <div id="kt_app_header" class="app-header d-flex flex-column flex-stack">
                <div class="d-flex flex-stack flex-grow-1">
                    <div class="app-header-logo d-flex align-items-center ps-lg-12" id="kt_app_header_logo">
                        <div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-sm btn-icon bg-body btn-color-gray-500 btn-active-color-primary w-30px h-30px ms-n2 me-4 d-none d-lg-flex" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
                            <i class="ki-outline ki-abstract-14 fs-3 mt-1"></i>
                        </div>
                        <div class="btn btn-icon btn-active-color-primary w-35px h-35px ms-3 me-2 d-flex d-lg-none" id="kt_app_sidebar_mobile_toggle">
                            <i class="ki-outline ki-abstract-14 fs-2"></i>
                        </div>
                        <a href="{{ url('/') }}" class="app-sidebar-logo">
                            <h2 class="text-dark fw-bold">Helpdesk</h2>
                        </a>
                    </div>
                    <div class="app-navbar flex-grow-1 justify-content-end" id="kt_app_header_navbar">
                        <div class="app-navbar-item ms-2 ms-lg-6" id="kt_header_user_menu_toggle">
                            <div class="cursor-pointer symbol symbol-circle symbol-30px symbol-lg-45px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                <img src="{{ asset('assets/media/avatars/300-2.jpg') }}" alt="user">
                            </div>
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                                <div class="menu-item px-3">
                                    <div class="menu-content d-flex align-items-center px-3">
                                        <div class="symbol symbol-50px me-5">
                                            <img alt="Logo" src="{{ asset('assets/media/avatars/300-2.jpg') }}">
                                        </div>
                                        <div class="d-flex flex-column">
                                            <div class="fw-bold d-flex align-items-center fs-5">{{ Auth::user()->name ?? 'User' }}</div>
                                            <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">{{ Auth::user()->email ?? 'user@example.com' }}</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="separator my-2"></div>
                                <div class="menu-item px-5">
                                    <a href="#" class="menu-link px-5">Profil Saya</a>
                                </div>
                                <div class="menu-item px-5">
                                    <a class="menu-link px-5" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="app-header-separator"></div>
            </div>
            <!-- ========== END HEADER ========== -->
            
            <!-- ========== WRAPPER (SIDEBAR + KONTEN) ========== -->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                
                <!-- ========== SIDEBAR KIRI ========== -->
                <div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
                    <div id="kt_app_sidebar_wrapper" class="app-sidebar-wrapper">
                        <div class="hover-scroll-y my-5 my-lg-2 mx-4" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header" data-kt-scroll-wrappers="#kt_app_sidebar_wrapper" data-kt-scroll-offset="5px">
                            <div id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false" class="app-sidebar-menu-primary menu menu-column menu-rounded menu-sub-indention menu-state-bullet-primary px-3 mb-5">
                                
                                <!-- Dashboard -->
                                <div class="menu-item">
                                    <a class="menu-link" href="{{ route('dashboard') }}">
                                        <span class="menu-icon">
                                            <i class="ki-outline ki-home-2 fs-2"></i>
                                        </span>
                                        <span class="menu-title">Dashboard</span>
                                    </a>
                                </div>
                                
                                <!-- Semua Pengaduan -->
                                <div class="menu-item">
                                    <a class="menu-link" href="{{ route('tickets.index') }}">
                                        <span class="menu-icon">
                                            <i class="ki-outline ki-message-text-2 fs-2"></i>
                                        </span>
                                        <span class="menu-title">Semua Pengaduan</span>
                                    </a>
                                </div>
                                
                                <!-- Buat Pengaduan -->
                                <div class="menu-item">
                                    <a class="menu-link" href="{{ route('tickets.create') }}">
                                        <span class="menu-icon">
                                            <i class="ki-outline ki-add-files fs-2"></i>
                                        </span>
                                        <span class="menu-title">Buat Pengaduan</span>
                                    </a>
                                </div>
                                
                                <!-- Separator -->
                                <div class="separator my-4"></div>
                                
                                <!-- Profil Saya -->
                                <div class="menu-item">
                                    <a class="menu-link" href="{{ route('profile') }}">
                                        <span class="menu-icon">
                                            <i class="ki-outline ki-profile-circle fs-2"></i>
                                        </span>
                                        <span class="menu-title">Profil Saya</span>
                                    </a>
                                </div>
                                
                                <!-- Logout -->
                                <div class="menu-item">
                                    <a class="menu-link" href="#" onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">
                                        <span class="menu-icon">
                                            <i class="ki-outline ki-exit-right fs-2"></i>
                                        </span>
                                        <span class="menu-title">Keluar</span>
                                    </a>
                                    <form id="sidebar-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ========== END SIDEBAR ========== -->
                
                <!-- ========== MAIN CONTENT (KANAN) ========== -->
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    <div class="d-flex flex-column flex-column-fluid">
                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <div id="kt_app_content_container" class="app-container container-fluid">
                                
                                @yield('content')
                                
                            </div>
                        </div>
                    </div>
                    <div id="kt_app_footer" class="app-footer">
                        <div class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3">
                            <div class="text-dark order-2 order-md-1">
                                <span class="text-muted fw-semibold me-1">{{ date('Y') }}&copy;</span>
                                <a href="#" class="text-gray-800 text-hover-primary">Helpdesk App</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ========== END MAIN CONTENT ========== -->
                
            </div>
            <!-- ========== END WRAPPER ========== -->
            
        </div>
    </div>
    
    <!-- Global JS (WAJIB dari template) -->
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    
    @stack('scripts')
    
</body>
</html>