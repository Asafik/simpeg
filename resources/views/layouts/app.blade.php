<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIMPEG-SP - Dashboard Admin Dinas')</title>
    
    <!-- System Theme Initializer (Excludes Login & Landing) -->
    <script>
        (function() {
            if (window.location.pathname.includes('/login') || window.location.pathname.includes('/landing')) {
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
    <link rel="stylesheet" href="{{ asset('assets/css/dropdown.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datepicker.css') }}">
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans">

    @unless(View::hasSection('hideNav') || Request::is('login') || Request::is('landing*'))
        <!-- Mobile Sidebar Overlay -->
        <div class="fixed inset-0 bg-gray-900/50 z-40 md:hidden" id="sidebarOverlay"></div>
    @endunless

    <!-- Main Content Wrapper -->
    <main class="{{ (View::hasSection('hideNav') || Request::is('login') || Request::is('landing*')) ? 'w-full' : 'md:ml-[270px]' }} min-h-screen bg-gray-50 flex flex-col transition-all duration-300" id="mainContent">
        @unless(View::hasSection('hideNav') || Request::is('login') || Request::is('landing*'))
            <!-- Top Navbar Partial -->
            @include('layouts.navbar')
        @endunless

        <!-- Dynamic Content Section -->
        @yield('content')
    </main>

    <!-- Main System JS in public/ -->
    <script src="{{ asset('app.js') }}"></script>

    <!-- Component JS Assets in public/assets/js/ -->
    <script src="{{ asset('assets/js/charts.js') }}"></script>
    <script src="{{ asset('assets/js/calendar.js') }}"></script>
    <script src="{{ asset('assets/js/dropdown.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker.js') }}"></script>
    @stack('scripts')
</body>
</html>
