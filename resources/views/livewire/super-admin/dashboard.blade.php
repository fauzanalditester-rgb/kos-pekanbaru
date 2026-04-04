<div>
    <!-- Page Title -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-white">Super Admin Dashboard</h1>
        <p class="text-gray-400 mt-1">Selamat datang, {{ Auth::user()->name }}. Berikut ringkasan sistem.</p>
    </div>

    <!-- Stats Cards Row 1 -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <div class="bg-[#111827] rounded-2xl p-6 border border-gray-800">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-600/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-purple-400 bg-purple-400/10 px-2 py-1 rounded-full">+{{ $recentUsers->count() }} baru</span>
            </div>
            <h3 class="text-3xl font-bold text-white">{{ $totalUsers }}</h3>
            <p class="text-gray-400 text-sm mt-1">Total Users</p>
            <div class="mt-3 flex gap-2 text-xs">
                <span class="text-gray-500">👤 {{ $totalCustomers }} Customer</span>
                <span class="text-gray-500">🔧 {{ $totalAdmins }} Admin</span>
            </div>
        </div>

        <!-- Total Tenants -->
        <div class="bg-[#111827] rounded-2xl p-6 border border-gray-800">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-600/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-blue-400 bg-blue-400/10 px-2 py-1 rounded-full">{{ $activeTenants }} Aktif</span>
            </div>
            <h3 class="text-3xl font-bold text-white">{{ $totalTenants }}</h3>
            <p class="text-gray-400 text-sm mt-1">Total Penyewa</p>
        </div>

        <!-- Invoices -->
        <div class="bg-[#111827] rounded-2xl p-6 border border-gray-800">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-600/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-yellow-400 bg-yellow-400/10 px-2 py-1 rounded-full">{{ $pendingInvoices }} Pending</span>
            </div>
            <h3 class="text-3xl font-bold text-white">{{ $totalInvoices }}</h3>
            <p class="text-gray-400 text-sm mt-1">Total Tagihan</p>
            <div class="mt-3 flex gap-2 text-xs">
                <span class="text-green-500">✓ {{ $paidInvoices }} Lunas</span>
                <span class="text-red-500">⚠ {{ $overdueInvoices }} Jatuh Tempo</span>
            </div>
        </div>

        <!-- Payments -->
        <div class="bg-[#111827] rounded-2xl p-6 border border-gray-800">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-amber-600/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
                <span class="text-xs font-medium text-amber-400 bg-amber-400/10 px-2 py-1 rounded-full">{{ $pendingPayments }} Verifikasi</span>
            </div>
            <h3 class="text-3xl font-bold text-white">{{ $totalPayments }}</h3>
            <p class="text-gray-400 text-sm mt-1">Total Pembayaran</p>
            <div class="mt-3 text-xs">
                <span class="text-green-500">✓ {{ $verifiedPayments }} Terverifikasi</span>
            </div>
        </div>
    </div>

    <!-- Financial Summary -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Today's Income -->
        <div class="bg-gradient-to-br from-purple-600/20 to-purple-800/20 rounded-2xl p-6 border border-purple-500/30">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <span class="text-purple-400 font-medium">Pemasukan Hari Ini</span>
            </div>
            <h3 class="text-3xl font-bold text-white">Rp {{ number_format($todayIncome, 0, ',', '.') }}</h3>
        </div>

        <!-- Monthly Income -->
        <div class="bg-gradient-to-br from-blue-600/20 to-blue-800/20 rounded-2xl p-6 border border-blue-500/30">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="text-blue-400 font-medium">Pemasukan Bulan Ini</span>
            </div>
            <h3 class="text-3xl font-bold text-white">Rp {{ number_format($monthIncome, 0, ',', '.') }}</h3>
        </div>

        <!-- Net Profit -->
        <div class="bg-gradient-to-br from-green-600/20 to-green-800/20 rounded-2xl p-6 border border-green-500/30">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <span class="text-green-400 font-medium">Laba Bersih Total</span>
            </div>
            <h3 class="text-3xl font-bold text-white">Rp {{ number_format($netProfit, 0, ',', '.') }}</h3>
            <p class="text-gray-400 text-sm mt-1">Pemasukan: Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Users -->
        <div class="bg-[#111827] rounded-2xl border border-gray-800 overflow-hidden">
            <div class="p-6 border-b border-gray-800">
                <h3 class="text-lg font-semibold text-white">User Terbaru</h3>
            </div>
            <div class="divide-y divide-gray-800">
                @forelse($recentUsers as $user)
                    <div class="p-4 flex items-center justify-between hover:bg-gray-800/50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gray-700 rounded-full flex items-center justify-center text-white font-medium">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-white font-medium">{{ $user->name }}</p>
                                <p class="text-gray-400 text-sm">{{ $user->email }}</p>
                            </div>
                        </div>
                        <span class="text-xs px-2 py-1 rounded-full 
                            @if($user->role === 'super_admin') bg-purple-500/20 text-purple-400
                            @elseif($user->role === 'admin') bg-blue-500/20 text-blue-400
                            @else bg-green-500/20 text-green-400 @endif">
                            {{ $user->role }}
                        </span>
                    </div>
                @empty
                    <div class="p-4 text-gray-400 text-center">Belum ada user</div>
                @endforelse
            </div>
        </div>

        <!-- Recent Payments -->
        <div class="bg-[#111827] rounded-2xl border border-gray-800 overflow-hidden">
            <div class="p-6 border-b border-gray-800">
                <h3 class="text-lg font-semibold text-white">Pembayaran Terbaru</h3>
            </div>
            <div class="divide-y divide-gray-800">
                @forelse($recentPayments as $payment)
                    <div class="p-4 flex items-center justify-between hover:bg-gray-800/50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-amber-600/20 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-white font-medium">{{ $payment->tenant->name ?? 'Unknown' }}</p>
                                <p class="text-gray-400 text-sm">Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        <span class="text-xs px-2 py-1 rounded-full 
                            @if($payment->status === 'verified') bg-green-500/20 text-green-400
                            @elseif($payment->status === 'pending') bg-yellow-500/20 text-yellow-400
                            @else bg-red-500/20 text-red-400 @endif">
                            {{ $payment->status }}
                        </span>
                    </div>
                @empty
                    <div class="p-4 text-gray-400 text-center">Belum ada pembayaran</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
