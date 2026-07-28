{{-- Loading Overlay Component --}}
@props([
    'id' => 'loadingOverlay',
    'title' => 'Memuat & Menyaring Data...',
    'subtitle' => 'Mohon tunggu sebentar, sistem sedang memproses data Pegawai (PTK).'
])

<div id="{{ $id }}" class="fixed inset-0 z-[9999] hidden flex items-center justify-center bg-slate-950/65 backdrop-blur-md transition-all duration-300">
    <div id="{{ $id }}Card" class="loading-card bg-white rounded-2xl p-6 md:p-8 max-w-sm w-full mx-4 shadow-2xl border border-gray-100 text-center space-y-4 transition-colors duration-300">
        
        <!-- Animated Spinner & Pulse Ring Container with Official App Logo -->
        <div class="relative w-20 h-20 mx-auto flex items-center justify-center">
            <!-- Outer Pulse Ring -->
            <div id="{{ $id }}PulseRing" class="absolute inset-0 rounded-full border-4 border-blue-600/30 animate-ping"></div>
            <!-- Spinning Gradient Border -->
            <div id="{{ $id }}Spinner" class="w-20 h-20 rounded-full border-4 border-t-blue-800 border-r-indigo-600 border-b-blue-300 border-l-transparent animate-spin"></div>
            <!-- Center Official App Logo -->
            <div class="absolute inset-0 flex items-center justify-center p-3">
                <img src="{{ asset('logo/logo.svg') }}" alt="SIMPEG-SP Logo" class="w-10 h-10 object-contain drop-shadow-md animate-pulse">
            </div>
        </div>

        <!-- System Name & Loading Text Content -->
        <div class="space-y-1">
            <span id="{{ $id }}Badge" class="inline-block px-2.5 py-0.5 bg-blue-50 text-blue-800 text-[10px] font-extrabold tracking-wider uppercase rounded-full border border-blue-100 mb-1">
                SIMPEG-SP Kab. Jember
            </span>
            <h4 class="text-sm font-extrabold text-gray-900 tracking-tight" id="{{ $id }}Title">
                {{ $title }}
            </h4>
            <p class="text-xs text-gray-500 font-normal leading-relaxed" id="{{ $id }}Subtitle">
                {{ $subtitle }}
            </p>
        </div>

        <!-- Progress Indicator Dots -->
        <div class="flex items-center justify-center gap-1.5 pt-1">
            <span id="{{ $id }}Dot1" class="w-2 h-2 rounded-full bg-blue-800 animate-bounce" style="animation-delay: 0s"></span>
            <span id="{{ $id }}Dot2" class="w-2 h-2 rounded-full bg-indigo-600 animate-bounce" style="animation-delay: 0.15s"></span>
            <span id="{{ $id }}Dot3" class="w-2 h-2 rounded-full bg-blue-400 animate-bounce" style="animation-delay: 0.3s"></span>
        </div>

    </div>
</div>

<script>
    window.applyOverlayTheme = function() {
        const theme = localStorage.getItem('simpegTheme') || document.documentElement.getAttribute('data-theme') || 'deep_blue';
        const card = document.getElementById('{{ $id }}Card');
        const pulseRing = document.getElementById('{{ $id }}PulseRing');
        const spinner = document.getElementById('{{ $id }}Spinner');
        const badge = document.getElementById('{{ $id }}Badge');
        const title = document.getElementById('{{ $id }}Title');
        const subtitle = document.getElementById('{{ $id }}Subtitle');
        const dot1 = document.getElementById('{{ $id }}Dot1');
        const dot2 = document.getElementById('{{ $id }}Dot2');
        const dot3 = document.getElementById('{{ $id }}Dot3');

        if (!card) return;

        if (theme === 'emerald') {
            card.className = "loading-card bg-white rounded-2xl p-6 md:p-8 max-w-sm w-full mx-4 shadow-2xl border border-emerald-100 text-center space-y-4";
            pulseRing.className = "absolute inset-0 rounded-full border-4 border-emerald-500/30 animate-ping";
            spinner.className = "w-20 h-20 rounded-full border-4 border-t-emerald-600 border-r-teal-500 border-b-emerald-200 border-l-transparent animate-spin";
            badge.className = "inline-block px-2.5 py-0.5 bg-emerald-50 text-emerald-800 text-[10px] font-extrabold tracking-wider uppercase rounded-full border border-emerald-100 mb-1";
            title.className = "text-sm font-extrabold text-gray-900 tracking-tight";
            subtitle.className = "text-xs text-gray-500 font-normal leading-relaxed";
            dot1.className = "w-2 h-2 rounded-full bg-emerald-600 animate-bounce";
            dot2.className = "w-2 h-2 rounded-full bg-teal-500 animate-bounce";
            dot3.className = "w-2 h-2 rounded-full bg-emerald-300 animate-bounce";
        } else if (theme === 'purple') {
            card.className = "loading-card bg-white rounded-2xl p-6 md:p-8 max-w-sm w-full mx-4 shadow-2xl border border-purple-100 text-center space-y-4";
            pulseRing.className = "absolute inset-0 rounded-full border-4 border-purple-600/30 animate-ping";
            spinner.className = "w-20 h-20 rounded-full border-4 border-t-purple-700 border-r-indigo-600 border-b-purple-300 border-l-transparent animate-spin";
            badge.className = "inline-block px-2.5 py-0.5 bg-purple-50 text-purple-800 text-[10px] font-extrabold tracking-wider uppercase rounded-full border border-purple-100 mb-1";
            title.className = "text-sm font-extrabold text-gray-900 tracking-tight";
            subtitle.className = "text-xs text-gray-500 font-normal leading-relaxed";
            dot1.className = "w-2 h-2 rounded-full bg-purple-700 animate-bounce";
            dot2.className = "w-2 h-2 rounded-full bg-indigo-600 animate-bounce";
            dot3.className = "w-2 h-2 rounded-full bg-purple-300 animate-bounce";
        } else if (theme === 'dark') {
            card.className = "loading-card bg-slate-900 rounded-2xl p-6 md:p-8 max-w-sm w-full mx-4 shadow-2xl border border-slate-800 text-center space-y-4";
            pulseRing.className = "absolute inset-0 rounded-full border-4 border-sky-500/30 animate-ping";
            spinner.className = "w-20 h-20 rounded-full border-4 border-t-sky-400 border-r-blue-500 border-b-slate-700 border-l-transparent animate-spin";
            badge.className = "inline-block px-2.5 py-0.5 bg-slate-800 text-sky-400 text-[10px] font-extrabold tracking-wider uppercase rounded-full border border-slate-700 mb-1";
            title.className = "text-sm font-extrabold text-white tracking-tight";
            subtitle.className = "text-xs text-slate-400 font-normal leading-relaxed";
            dot1.className = "w-2 h-2 rounded-full bg-sky-400 animate-bounce";
            dot2.className = "w-2 h-2 rounded-full bg-blue-500 animate-bounce";
            dot3.className = "w-2 h-2 rounded-full bg-slate-600 animate-bounce";
        } else { // deep_blue default
            card.className = "loading-card bg-white rounded-2xl p-6 md:p-8 max-w-sm w-full mx-4 shadow-2xl border border-blue-100 text-center space-y-4";
            pulseRing.className = "absolute inset-0 rounded-full border-4 border-blue-600/30 animate-ping";
            spinner.className = "w-20 h-20 rounded-full border-4 border-t-blue-800 border-r-indigo-600 border-b-blue-300 border-l-transparent animate-spin";
            badge.className = "inline-block px-2.5 py-0.5 bg-blue-50 text-blue-800 text-[10px] font-extrabold tracking-wider uppercase rounded-full border border-blue-100 mb-1";
            title.className = "text-sm font-extrabold text-gray-900 tracking-tight";
            subtitle.className = "text-xs text-gray-500 font-normal leading-relaxed";
            dot1.className = "w-2 h-2 rounded-full bg-blue-800 animate-bounce";
            dot2.className = "w-2 h-2 rounded-full bg-indigo-600 animate-bounce";
            dot3.className = "w-2 h-2 rounded-full bg-blue-400 animate-bounce";
        }
    };

    window.showLoadingOverlay = function(titleText = null, subtitleText = null) {
        if (typeof window.applyOverlayTheme === 'function') {
            window.applyOverlayTheme();
        }

        const overlay = document.getElementById('{{ $id }}');
        if (overlay) {
            if (titleText) {
                const titleEl = document.getElementById('{{ $id }}Title');
                if (titleEl) titleEl.innerText = titleText;
            }
            if (subtitleText) {
                const subEl = document.getElementById('{{ $id }}Subtitle');
                if (subEl) subEl.innerText = subtitleText;
            }
            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
        }
    };

    window.hideLoadingOverlay = function() {
        const overlay = document.getElementById('{{ $id }}');
        if (overlay) {
            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
        }
    };

    document.addEventListener('DOMContentLoaded', function() {
        if (typeof window.applyOverlayTheme === 'function') {
            window.applyOverlayTheme();
        }
    });
</script>
