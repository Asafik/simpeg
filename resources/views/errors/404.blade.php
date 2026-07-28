<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan | SIMPEG-SP</title>

    <!-- Favicon Logo -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo/logo.svg') }}">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full text-center">
        <!-- Icon Container -->
        <div class="relative mb-8 inline-flex items-center justify-center">
            <div class="w-24 h-24 bg-blue-50 rounded-full flex items-center justify-center text-blue-800">
                <i class="fas fa-compass text-4xl animate-spin" style="animation-duration: 10s;"></i>
            </div>
            <span class="absolute -top-1 -right-1 bg-blue-800 text-white text-xs font-bold px-2 py-0.5 rounded-full shadow-sm">404</span>
        </div>

        <!-- Error Message -->
        <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight mb-2">Halaman Tidak Ditemukan!</h1>
        <p class="text-sm text-gray-500 mb-8 leading-relaxed">
            Maaf, halaman yang Anda cari tidak dapat ditemukan atau telah dipindahkan ke alamat lain. Silakan periksa kembali URL Anda.
        </p>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-blue-800 hover:bg-blue-900 text-white text-xs font-bold rounded-xl shadow-md shadow-blue-900/10 transition">
                <i class="fas fa-house"></i>
                <span>Kembali ke Dashboard</span>
            </a>
            <button onclick="window.history.back()" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 text-xs font-bold rounded-xl transition">
                <i class="fas fa-arrow-left"></i>
                <span>Halaman Sebelumnya</span>
            </button>
        </div>

        <!-- Footer -->
        <div class="mt-12 text-center">
            <p class="text-[10px] text-gray-400 font-medium uppercase tracking-wider">SIMPEG-SP &copy; {{ date('Y') }} - Dinas Pendidikan</p>
        </div>
    </div>
</body>
</html>
