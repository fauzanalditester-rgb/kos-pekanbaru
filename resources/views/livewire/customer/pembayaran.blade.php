<div class="h-full">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white">Riwayat Pembayaran</h1>
            <p class="text-gray-400 text-sm mt-1">Lihat semua pembayaran yang telah Anda lakukan</p>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session()->has('message'))
        <div class="mb-4 bg-[#0d9488]/10 border border-[#0d9488]/20 text-[#0d9488] px-4 py-3 rounded-xl text-sm">
            {{ session('message') }}
        </div>
    @endif

    @if(!$payments->count())
        <div class="flex flex-col items-center justify-center py-16 text-center">
            <div class="w-20 h-20 bg-gray-800 rounded-full flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
            </div>
            <h2 class="text-xl font-bold text-white mb-2">Belum Ada Pembayaran</h2>
            <p class="text-gray-400">Anda belum melakukan pembayaran apapun.</p>
            <a href="/customer/tagihan" class="mt-4 px-4 py-2 bg-[#0d9488] hover:bg-[#0f766e] text-white rounded-lg transition-colors text-sm">
                Lihat Tagihan
            </a>
        </div>
    @else
        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-[#1f2937] border border-gray-800/50 rounded-2xl p-4">
                <p class="text-gray-400 text-xs mb-1">Total Pembayaran</p>
                <p class="text-2xl font-bold text-white">{{ $stats['total'] }}</p>
            </div>
            <div class="bg-[#1f2937] border border-gray-800/50 rounded-2xl p-4">
                <p class="text-gray-400 text-xs mb-1">Terverifikasi</p>
                <p class="text-2xl font-bold text-[#0d9488]">{{ $stats['verified'] }}</p>
            </div>
            <div class="bg-[#1f2937] border border-gray-800/50 rounded-2xl p-4">
                <p class="text-gray-400 text-xs mb-1">Menunggu</p>
                <p class="text-2xl font-bold text-yellow-500">{{ $stats['pending'] }}</p>
            </div>
            <div class="bg-[#1f2937] border border-gray-800/50 rounded-2xl p-4">
                <p class="text-gray-400 text-xs mb-1">Total Dibayar</p>
                <p class="text-2xl font-bold text-[#0d9488]">Rp {{ number_format($stats['total_amount'], 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Payments Table -->
        <div class="bg-[#1f2937] border border-gray-800/50 rounded-2xl overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-800/50">
                        <th class="text-left text-gray-400 text-sm font-medium py-4 px-6">Tanggal</th>
                        <th class="text-left text-gray-400 text-sm font-medium py-4 px-6">No Invoice</th>
                        <th class="text-left text-gray-400 text-sm font-medium py-4 px-6">Jumlah</th>
                        <th class="text-left text-gray-400 text-sm font-medium py-4 px-6">Metode</th>
                        <th class="text-left text-gray-400 text-sm font-medium py-4 px-6">Status</th>
                        <th class="text-left text-gray-400 text-sm font-medium py-4 px-6">Bukti</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                        <tr class="border-b border-gray-800/30 hover:bg-gray-800/30 transition-colors">
                            <td class="py-4 px-6 text-gray-400 text-sm">{{ $payment->payment_date->format('d M Y') }}</td>
                            <td class="py-4 px-6 text-white text-sm">{{ $payment->invoice?->invoice_number ?? '-' }}</td>
                            <td class="py-4 px-6 text-white font-medium">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                            <td class="py-4 px-6 text-gray-400 text-sm capitalize">{{ $payment->payment_method }}</td>
                            <td class="py-4 px-6">
                                <span class="px-2 py-1 {{ $this->getStatusColor($payment->status) }} text-xs rounded">
                                    {{ $this->getStatusLabel($payment->status) }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                @if($payment->proof_image)
                                    <a href="{{ asset('storage/' . $payment->proof_image) }}" target="_blank" class="text-[#0d9488] hover:underline text-sm flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        Lihat
                                    </a>
                                @else
                                    <span class="text-gray-500 text-sm">-</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
