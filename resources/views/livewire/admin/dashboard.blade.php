<div>
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-white tracking-tight mb-2">Dashboard</h1>
        <p class="text-sm font-medium text-gray-500">Selamat datang kembali! Berikut ringkasan keuangan dan operasional kos Anda.</p>
    </div>

    <!-- FINANCIAL SUMMARY CARDS -->
    <div class="mb-6">
        <h2 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-[#0f766e]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Ringkasan Keuangan
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Pemasukan Hari Ini -->
            <div class="bg-[#111827] rounded-2xl p-6 border border-gray-800/50 hover:border-[#0f766e]/30 transition-all">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Pemasukan Hari Ini</span>
                    <div class="w-10 h-10 rounded-xl bg-[#0f766e]/10 flex items-center justify-center text-[#0f766e]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <div class="text-2xl font-extrabold text-white">Rp {{ number_format($todayIncome, 0, ',', '.') }}</div>
                <p class="text-xs text-gray-500 mt-1">{{ $todayPayments }} transaksi</p>
            </div>

            <!-- Pemasukan Bulan Ini -->
            <div class="bg-[#111827] rounded-2xl p-6 border border-gray-800/50 hover:border-[#0f766e]/30 transition-all">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Pemasukan Bulan Ini</span>
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                </div>
                <div class="text-2xl font-extrabold text-white">Rp {{ number_format($monthIncome, 0, ',', '.') }}</div>
                <p class="text-xs text-gray-500 mt-1">Target: Rp {{ number_format($monthInvoiceTotal, 0, ',', '.') }}</p>
            </div>

            <!-- Pengeluaran Bulan Ini -->
            <div class="bg-[#111827] rounded-2xl p-6 border border-gray-800/50 hover:border-red-500/30 transition-all">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Pengeluaran Bulan Ini</span>
                    <div class="w-10 h-10 rounded-xl bg-red-500/10 flex items-center justify-center text-red-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/></svg>
                    </div>
                </div>
                <div class="text-2xl font-extrabold text-white">Rp {{ number_format($monthExpense, 0, ',', '.') }}</div>
                <p class="text-xs text-gray-500 mt-1">vs Pemasukan: {{ $monthIncome > 0 ? round(($monthExpense / $monthIncome) * 100) : 0 }}%</p>
            </div>

            <!-- Net Profit (Bulan) -->
            <div class="bg-[#111827] rounded-2xl p-6 border border-gray-800/50 hover:border-emerald-500/30 transition-all">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Profit Bulan Ini</span>
                    <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <div class="text-2xl font-extrabold {{ ($monthIncome - $monthExpense) >= 0 ? 'text-emerald-400' : 'text-red-400' }}">
                    Rp {{ number_format($monthIncome - $monthExpense, 0, ',', '.') }}
                </div>
                <p class="text-xs text-gray-500 mt-1">Net profit bulan ini</p>
            </div>
        </div>
    </div>

    <!-- INVOICE & PAYMENT STATUS -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-6">
        <!-- Invoice Statistics -->
        <div class="bg-[#111827] rounded-2xl p-6 border border-gray-800/50">
            <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Status Tagihan
            </h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-gray-800/30 rounded-xl p-4">
                    <p class="text-xs text-gray-500 mb-1">Total Tagihan</p>
                    <p class="text-xl font-bold text-white">{{ $totalInvoices }}</p>
                </div>
                <div class="bg-emerald-500/10 rounded-xl p-4">
                    <p class="text-xs text-emerald-400 mb-1">Sudah Lunas</p>
                    <p class="text-xl font-bold text-emerald-400">{{ $paidInvoices }}</p>
                </div>
                <div class="bg-amber-500/10 rounded-xl p-4">
                    <p class="text-xs text-amber-400 mb-1">Belum Bayar</p>
                    <p class="text-xl font-bold text-amber-400">{{ $unpaidInvoices }}</p>
                </div>
                <div class="bg-red-500/10 rounded-xl p-4">
                    <p class="text-xs text-red-400 mb-1">Overdue (Jatuh Tempo)</p>
                    <p class="text-xl font-bold text-red-400">{{ $overdueInvoices }}</p>
                    <p class="text-xs text-red-400/70">Rp {{ number_format($overdueAmount, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Payment Statistics -->
        <div class="bg-[#111827] rounded-2xl p-6 border border-gray-800/50">
            <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-[#0f766e]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                Status Pembayaran
            </h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-gray-800/30 rounded-xl p-4">
                    <p class="text-xs text-gray-500 mb-1">Pembayaran Hari Ini</p>
                    <p class="text-xl font-bold text-white">{{ $todayPayments }}</p>
                    <p class="text-xs text-gray-400">Rp {{ number_format($todayPaymentsAmount, 0, ',', '.') }}</p>
                </div>
                <div class="bg-[#0f766e]/10 rounded-xl p-4">
                    <p class="text-xs text-[#0f766e] mb-1">Total Bulan Ini</p>
                    <p class="text-xl font-bold text-[#0f766e]">Rp {{ number_format($monthPayments, 0, ',', '.') }}</p>
                </div>
                <div class="bg-amber-500/10 rounded-xl p-4 col-span-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-amber-400 mb-1">Menunggu Verifikasi</p>
                            <p class="text-xl font-bold text-amber-400">{{ $pendingPayments }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-amber-400/70">Total</p>
                            <p class="text-lg font-bold text-amber-400">Rp {{ number_format($pendingPaymentsAmount, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PROPERTY & TENANT SUMMARY -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-6">
        <!-- Room Occupancy -->
        <div class="bg-[#111827] rounded-2xl p-6 border border-gray-800/50">
            <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                Okupansi Kamar
            </h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-400">Total Kamar</span>
                    <span class="text-lg font-bold text-white">{{ $totalRooms }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-emerald-400">Terisi</span>
                    <span class="text-lg font-bold text-emerald-400">{{ $occupiedRooms }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-400">Kosong</span>
                    <span class="text-lg font-bold text-gray-400">{{ $availableRooms }}</span>
                </div>
                <div class="pt-3 border-t border-gray-700">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs text-gray-500">Tingkat Okupansi</span>
                        <span class="text-xs font-bold text-[#0f766e]">{{ $occupancyRate }}%</span>
                    </div>
                    <div class="h-2 bg-gray-800 rounded-full overflow-hidden">
                        <div class="h-full bg-[#0f766e] rounded-full" style="width: {{ $occupancyRate }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tenant Summary -->
        <div class="bg-[#111827] rounded-2xl p-6 border border-gray-800/50">
            <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                Penyewa
            </h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-gray-800/30 rounded-xl p-4 text-center">
                    <p class="text-xs text-gray-500 mb-1">Total</p>
                    <p class="text-2xl font-bold text-white">{{ $totalTenants }}</p>
                </div>
                <div class="bg-emerald-500/10 rounded-xl p-4 text-center">
                    <p class="text-xs text-emerald-400 mb-1">Aktif</p>
                    <p class="text-2xl font-bold text-emerald-400">{{ $activeTenants }}</p>
                </div>
            </div>
        </div>

        <!-- Yearly Summary -->
        <div class="bg-[#111827] rounded-2xl p-6 border border-gray-800/50">
            <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-[#0f766e]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Ringkasan Tahun {{ date('Y') }}
            </h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-400">Total Pemasukan</span>
                    <span class="text-lg font-bold text-emerald-400">Rp {{ number_format($yearIncome, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-400">Total Pengeluaran</span>
                    <span class="text-lg font-bold text-red-400">Rp {{ number_format($yearExpense, 0, ',', '.') }}</span>
                </div>
                <div class="pt-3 border-t border-gray-700">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-white font-medium">Net Profit Tahun</span>
                        <span class="text-lg font-bold {{ ($yearIncome - $yearExpense) >= 0 ? 'text-emerald-400' : 'text-red-400' }}">
                            Rp {{ number_format($yearIncome - $yearExpense, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CASHFLOW CHART -->
    <div class="bg-[#111827] rounded-2xl p-6 border border-gray-800/50 mb-6">
        <h3 class="text-lg font-bold text-white mb-6 flex items-center gap-2">
            <svg class="w-5 h-5 text-[#0f766e]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
            Cashflow 6 Bulan Terakhir (dalam jutaan Rupiah)
        </h3>
        
        <div class="flex items-end justify-between h-48 gap-4 px-4">
            @foreach($monthlyData as $data)
            <div class="flex-1 flex flex-col items-center gap-3 group relative">
                <div class="flex items-end gap-1.5 w-full justify-center">
                    <div class="w-6 bg-[#0f766e] rounded-t transition-all duration-500 group-hover:brightness-125 relative" 
                         style="height: {{ max(10, ($data['income'] / 30) * 100) }}px">
                        @if($data['income'] > 0)
                        <span class="absolute -top-5 left-1/2 -translate-x-1/2 text-[9px] text-[#0f766e] font-bold opacity-0 group-hover:opacity-100 transition-opacity">
                            {{ number_format($data['income'], 1) }}M
                        </span>
                        @endif
                    </div>
                    <div class="w-6 bg-red-500/80 rounded-t transition-all duration-500 group-hover:brightness-125 relative" 
                         style="height: {{ max(10, ($data['expense'] / 30) * 100) }}px">
                        @if($data['expense'] > 0)
                        <span class="absolute -top-5 left-1/2 -translate-x-1/2 text-[9px] text-red-400 font-bold opacity-0 group-hover:opacity-100 transition-opacity">
                            {{ number_format($data['expense'], 1) }}M
                        </span>
                        @endif
                    </div>
                </div>
                <span class="text-xs font-bold text-gray-500">{{ $data['month'] }}</span>
            </div>
            @endforeach
        </div>

        <!-- Legend -->
        <div class="flex items-center justify-center gap-8 mt-8">
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 bg-[#0f766e] rounded"></div>
                <span class="text-sm font-medium text-gray-400">Pemasukan</span>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-4 h-4 bg-red-500/80 rounded"></div>
                <span class="text-sm font-medium text-gray-400">Pengeluaran</span>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-[#111827] rounded-2xl p-6 border border-gray-800/50">
        <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            Aktivitas Booking Terbaru
        </h3>
        
        <div class="space-y-3">
            @forelse($recentBookings as $booking)
            <div class="flex items-center justify-between p-4 bg-gray-900/50 rounded-xl border border-gray-800/50 hover:border-[#0f766e]/20 transition-all">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-[#0f766e]/20 rounded-xl flex items-center justify-center text-[#0f766e] font-bold">
                        {{ strtoupper(substr($booking->guest_name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-white">{{ $booking->guest_name }}</p>
                        <p class="text-xs text-gray-500">{{ $booking->start_date->format('d M Y') }} - {{ $booking->end_date->format('d M Y') }} • Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                    </div>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $booking->status === 'confirmed' ? 'bg-emerald-500/20 text-emerald-400' : 'bg-amber-500/20 text-amber-400' }}">
                    {{ $booking->status === 'confirmed' ? 'Confirmed' : ucfirst($booking->status) }}
                </span>
            </div>
            @empty
            <div class="text-center py-8">
                <svg class="w-12 h-12 text-gray-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <p class="text-gray-500 text-sm">Belum ada booking terbaru</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
