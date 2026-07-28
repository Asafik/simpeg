<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIMPEG-SP - Dashboard Admin Dinas')</title>
    
    <!-- System Theme Initializer (Excludes Login, /, and Public Landing Pages) -->
    <script>
        (function() {
            const path = window.location.pathname;
            const isPublicPage = path === '/' || path === '/login' || path.startsWith('/landing') || 
                                 path.startsWith('/statistik') || path.startsWith('/layanan') || 
                                 path.startsWith('/cek-ptk') || (path.startsWith('/pengumuman') && !path.startsWith('/admin'));
            if (isPublicPage) {
                document.documentElement.setAttribute('data-theme', 'deep_blue');
            } else {
                const savedTheme = localStorage.getItem('simpegTheme') || 'deep_blue';
                document.documentElement.setAttribute('data-theme', savedTheme);
            }
        })();
    </script>

    <!-- Favicon Logo -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo/logo.svg') }}">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts (Plus Jakarta Sans & Inter) -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <!-- Tailwind Custom Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
                        'inter': ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 300: '#93c5fd', 400: '#60a5fa',
                            500: '#3b82f6', 600: '#2563eb', 700: '#1d4ed8', 800: '#1e40af', 900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Main System CSS in public/ -->
    <link rel="stylesheet" href="{{ asset('app.css') }}">

    <!-- Component CSS Assets in public/assets/css/ -->
    <link rel="stylesheet" href="{{ asset('assets/css/header-banner.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/calendar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/tables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dropdown.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datepicker.css') }}">

    <!-- Select2 CSS CDN & Custom Hope UI Styling -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        select.select2-hidden-accessible {
            display: none !important;
            position: absolute !important;
            width: 1px !important;
            height: 1px !important;
            opacity: 0 !important;
            pointer-events: none !important;
        }

        /* Select2 Tailwind & Hope UI Styling Fixes */
        .select2-container--default .select2-selection--single {
            background-color: #f9fafb !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 0.5rem !important;
            height: 38px !important;
            display: flex !important;
            align-items: center !important;
            transition: all 0.2s ease-in-out !important;
        }
        .select2-container--default.select2-container--open .select2-selection--single,
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #1e3a8a !important;
            box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1) !important;
            outline: none !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #1f2937 !important;
            font-weight: 600 !important;
            font-size: 0.75rem !important;
            padding-left: 0.75rem !important;
            padding-right: 1.5rem !important;
            line-height: normal !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px !important;
            right: 8px !important;
        }
        .select2-dropdown {
            border: 1px solid #e5e7eb !important;
            border-radius: 0.75rem !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
            font-size: 0.75rem !important;
            overflow: hidden !important;
            z-index: 9999 !important;
        }
        .select2-search--dropdown {
            padding: 8px !important;
        }
        .select2-search__field {
            border: 1px solid #d1d5db !important;
            border-radius: 0.5rem !important;
            padding: 6px 10px !important;
            font-size: 0.75rem !important;
            outline: none !important;
        }
        .select2-search__field:focus {
            border-color: #1e3a8a !important;
            box-shadow: 0 0 0 2px rgba(30, 58, 138, 0.1) !important;
        }
        .select2-results__option {
            padding: 8px 12px !important;
            font-size: 0.75rem !important;
            font-weight: 500 !important;
        }
        .select2-results__option--highlighted[aria-selected] {
            background-color: #1e3a8a !important;
            color: #ffffff !important;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans">

    @php
        $isPublicPage = View::hasSection('hideNav') || Request::is('/') || Request::is('login') || Request::is('landing*') || Request::is('statistik*') || Request::is('layanan*') || Request::is('cek-ptk*') || (Request::is('pengumuman*') && !Request::is('admin*'));
    @endphp

    @unless($isPublicPage)
        <!-- Global Sidebar Navigation Partial -->
        @include('layouts.sidebar')

        <!-- Mobile Sidebar Overlay (Dark Dimmed + Backdrop Blur via app.css) -->
        <div id="sidebarOverlay"></div>
    @endunless

    <!-- Main Content Wrapper (w-full 100% on public pages) -->
    <main class="{{ $isPublicPage ? 'w-full' : 'md:ml-[80px] lg:ml-[270px]' }} min-h-screen bg-gray-50 flex flex-col transition-all duration-300" id="mainContent">
        @unless($isPublicPage)
            <!-- Top Navbar Partial -->
            @include('layouts.navbar')
        @endunless

        <!-- Dynamic Content Section -->
        <div class="flex-1 flex flex-col">
            @yield('content')
        </div>

        @unless($isPublicPage)
            <!-- Admin Footer Partial (Full Width Edge-to-Edge & Sticks to Bottom) -->
            @include('layouts.footer')
        @endunless
    </main>

    <!-- jQuery & Select2 JS CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Main System JS in public/ -->
    <script src="{{ asset('app.js') }}"></script>

    <!-- Component JS Assets in public/assets/js/ -->
    <script src="{{ asset('assets/js/charts.js') }}"></script>
    <script src="{{ asset('assets/js/calendar.js') }}"></script>
    <script src="{{ asset('assets/js/dropdown.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/tables.js') }}"></script>
    <script>
        $(document).ready(function() {
            function initSelect2() {
                $('.select2').each(function() {
                    $(this).select2({
                        width: '100%',
                        dropdownParent: $(this).parent()
                    });
                });
            }
            initSelect2();
        });
    </script>
    @stack('scripts')
</body>
</html>
