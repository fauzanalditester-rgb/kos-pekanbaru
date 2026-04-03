<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Customer Portal - SewaVIP' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        body { font-family: 'Poppins', sans-serif; letter-spacing: -0.01em; }
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: #111827; }
        ::-webkit-scrollbar-thumb { background: #374151; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #4b5563; }
    </style>
</head>
<body class="h-full bg-[#0a0e14] text-gray-400 antialiased selection:bg-[#0f766e] selection:text-white overflow-hidden">
    <div class="flex h-full">
        <!-- Sidebar -->
        <aside id="sidebar" class="w-72 bg-[#111827] flex-shrink-0 flex flex-col fixed inset-y-0 left-0 z-40 transform -translate-x-full md:translate-x-0 transition-transform duration-300 border-r border-gray-800/50">
            <!-- Logo Section -->
            <div class="p-8 flex items-center justify-between">
                <a href="/customer" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6 text-[#0f766e]" fill="currentColor" viewBox="0 0 24 24"><path d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path d="M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-10a10 10 0 100 20 10 10 0 000-20z"/></svg>
                    </div>
                    <div>
                        <span class="text-xl font-extrabold tracking-tight text-white block">Sewa<span class="text-[#0f766e]">VIP.</span></span>
                        <span class="text-[10px] text-gray-500 font-bold tracking-widest uppercase">Customer Portal</span>
                    </div>
                </a>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 overflow-y-auto px-4 space-y-1 mt-4 scrollbar-hide">
                <div class="text-[10px] font-bold text-gray-600 uppercase tracking-widest px-4 mb-2">Menu</div>
                
                <a href="/customer" class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-semibold transition-all duration-300 {{ request()->is('customer') && !request()->is('customer/*') ? 'bg-[#0f766e]/10 text-[#0f766e]' : 'text-gray-400 hover:bg-gray-800/50 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    <span>Dashboard</span>
                </a>

                <a href="/customer/tagihan" class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-semibold transition-all duration-300 {{ request()->is('customer/tagihan') ? 'bg-[#0f766e]/10 text-[#0f766e]' : 'text-gray-400 hover:bg-gray-800/50 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>Tagihan Saya</span>
                </a>

                <a href="/customer/pembayaran" class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-semibold transition-all duration-300 {{ request()->is('customer/pembayaran') ? 'bg-[#0f766e]/10 text-[#0f766e]' : 'text-gray-400 hover:bg-gray-800/50 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    <span>Riwayat Pembayaran</span>
                </a>

                <a href="/customer/kamar" class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-semibold transition-all duration-300 {{ request()->is('customer/kamar') ? 'bg-[#0f766e]/10 text-[#0f766e]' : 'text-gray-400 hover:bg-gray-800/50 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span>Info Kamar</span>
                </a>

                <a href="/customer/profil" class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-semibold transition-all duration-300 {{ request()->is('customer/profil') ? 'bg-[#0f766e]/10 text-[#0f766e]' : 'text-gray-400 hover:bg-gray-800/50 hover:text-white' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>Profil Saya</span>
                </a>
                
                <div class="pt-8">
                    <div class="text-[10px] font-bold text-gray-600 uppercase tracking-widest px-4 mb-2">Lainnya</div>
                    <a href="/" class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-sm font-semibold text-gray-400 hover:bg-gray-800/50 hover:text-white transition-all">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <span>Lihat Website</span>
                    </a>
                </div>
            </nav>

            <!-- Bottom Section (User & Exit) -->
            <div class="p-6 border-t border-gray-800/50 space-y-3">
                <div class="flex items-center gap-3 px-4 py-3 bg-gray-800/30 rounded-2xl border border-gray-800/50">
                    <div class="w-10 h-10 rounded-xl bg-[#0f766e]/20 flex items-center justify-center text-[#0f766e] font-bold">
                        {{ strtoupper(substr(Auth::user()->name ?? 'C', 0, 1)) }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs font-bold text-white truncate">{{ Auth::user()->name ?? 'Customer' }}</p>
                        <div class="flex items-center gap-2">
                            <p class="text-[10px] text-gray-500 truncate">{{ Auth::user()->email ?? 'customer@email.com' }}</p>
                            <span class="px-1.5 py-0.5 bg-green-500/20 text-green-400 text-[9px] rounded">Customer</span>
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <button type="submit" class="flex items-center gap-3.5 w-full px-4 py-3 rounded-2xl text-sm font-bold text-red-500/80 hover:bg-red-500/10 hover:text-red-500 transition-all">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 md:ml-72 flex flex-col h-full bg-[#0a0e14] relative">
            <!-- Header/Top Bar -->
            <header class="h-20 bg-[#0a0e14]/50 backdrop-blur-xl border-b border-gray-800/30 px-8 flex items-center justify-between sticky top-0 z-30">
                <div class="flex items-center gap-4 flex-1">
                    <button onclick="document.getElementById('sidebar').classList.toggle('-translate-x-full')" class="md:hidden p-2.5 bg-gray-800 text-white rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <h1 class="text-xl font-bold text-white">{{ $title ?? 'Dashboard' }}</h1>
                </div>

                <div class="flex items-center gap-4">
                    @livewire('customer.notification-widget')
                    <div class="w-10 h-10 bg-[#0f766e] text-white rounded-xl flex items-center justify-center font-bold text-sm shadow-lg shadow-[#0f766e]/20 border border-[#0f766e]/50">
                        {{ strtoupper(substr(Auth::user()->name ?? 'C', 0, 1)) }}
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="flex-1 overflow-y-auto p-8 scrollbar-hide">
                @if (session()->has('message'))
                    <div class="mb-4 bg-[#0d9488]/10 border border-[#0d9488]/20 text-[#0d9488] px-4 py-3 rounded-xl text-sm">
                        {{ session('message') }}
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="mb-4 bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl text-sm">
                        {{ session('error') }}
                    </div>
                @endif
                {{ $slot }}
            </div>
        </main>
    </div>

    <!-- OVERLAY for mobile sidebar -->
    <div id="sidebar-overlay" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-30 md:hidden" onclick="document.getElementById('sidebar').classList.add('-translate-x-full'); this.classList.add('hidden')"></div>

    @livewireScripts
</body>
</html>
