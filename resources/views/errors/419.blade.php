<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sesi Berakhir - SewaVIP</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="h-full bg-[#0a0e14] text-gray-400 antialiased">
    <div class="min-h-full flex items-center justify-center p-4">
        <div class="max-w-md w-full text-center">
            <!-- Icon -->
            <div class="w-24 h-24 bg-amber-500/10 rounded-full flex items-center justify-center mx-auto mb-6 border border-amber-500/20">
                <svg class="w-12 h-12 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>

            <!-- Title -->
            <h1 class="text-2xl font-bold text-white mb-2">Sesi Berakhir</h1>
            <p class="text-gray-400 mb-2">Halaman tidak dapat diproses karena sesi Anda telah berakhir.</p>
            <p class="text-sm text-gray-500 mb-8">Silakan login kembali untuk melanjutkan.</p>

            <!-- Error Code -->
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-gray-800/50 rounded-lg mb-8">
                <span class="text-xs text-gray-500">Error Code:</span>
                <span class="text-xs font-mono text-amber-400">419 Page Expired</span>
            </div>

            <!-- Actions -->
            <div class="space-y-3">
                @auth
                    @if(Auth::user()->isSuperAdmin())
                        <a href="{{ route('super-admin.dashboard') }}" class="flex items-center justify-center gap-2 w-full px-6 py-3 bg-purple-600 hover:bg-purple-500 text-white rounded-xl font-medium transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Ke Dashboard Super Admin
                        </a>
                    @elseif(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-center gap-2 w-full px-6 py-3 bg-[#0f766e] hover:bg-[#0d9488] text-white rounded-xl font-medium transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Ke Dashboard Admin
                        </a>
                    @else
                        <a href="{{ route('customer.dashboard') }}" class="flex items-center justify-center gap-2 w-full px-6 py-3 bg-[#0f766e] hover:bg-[#0d9488] text-white rounded-xl font-medium transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Ke Dashboard Customer
                        </a>
                    @endif
                @endauth

                <a href="{{ route('login') }}" class="flex items-center justify-center gap-2 w-full px-6 py-3 bg-gray-800 hover:bg-gray-700 text-white rounded-xl font-medium transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    Login Ulang
                </a>

                <button onclick="window.location.reload()" class="flex items-center justify-center gap-2 w-full px-6 py-3 border border-gray-700 hover:bg-gray-800 text-gray-400 rounded-xl font-medium transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Coba Lagi
                </button>
            </div>

            <!-- Help Text -->
            <p class="text-xs text-gray-600 mt-8">
                Jika masalah berlanjut, silakan hubungi admin.
            </p>
        </div>
    </div>
</body>
</html>
