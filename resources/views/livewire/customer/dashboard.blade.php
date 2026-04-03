<div class="h-full">
    @if(!$tenant)
        <div class="flex flex-col items-center justify-center h-full text-center">
            <div class="w-20 h-20 bg-gray-800 rounded-full flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            </div>
            <h2 class="text-xl font-bold text-white mb-2">Akun Belum Terhubung</h2>
            <p class="text-gray-400 max-w-md">Akun Anda belum terhubung dengan data penyewa. Silakan hubungi admin untuk mengaktifkan akun Anda.</p>
        </div>
    @else
        <!-- Welcome Section -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-white">Halo, {{ $tenant->name }}!</h1>
            <p class="text-gray-400">Selamat datang di portal penyewa SewaVIP</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-[#1f2937] border border-gray-800/50 rounded-2xl p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-[#0d9488]/20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-[#0d9488]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-gray-400 text-sm">Total Dibayar</span>
                </div>
                <p class="text-2xl font-bold text-[#0d9488]">Rp {{ number_format($stats['total_paid'], 0, ',', '.') }}</p>
            </div>

            <div class="bg-[#1f2937] border border-gray-800/50 rounded-2xl p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-yellow-500/20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <span class="text-gray-400 text-sm">Menunggak</span>
                </div>
                <p class="text-2xl font-bold text-yellow-500">Rp {{ number_format($stats['total_pending'], 0, ',', '.') }}</p>
            </div>

            <div class="bg-[#1f2937] border border-gray-800/50 rounded-2xl p-5">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-10 h-10 bg-red-500/20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <span class="text-gray-400 text-sm">Jatuh Tempo</span>
                </div>
                <p class="text-2xl font-bold text-red-500">{{ $stats['overdue_count'] }} Tagihan</p>
            </div>
        </div>

        <!-- Room Info -->
        @if($room)
            <div class="bg-[#1f2937] border border-gray-800/50 rounded-2xl p-5 mb-6">
                <h3 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#0d9488]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Informasi Kamar
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <p class="text-gray-500 text-xs mb-1">Kode Kamar</p>
                        <p class="text-white font-medium">{{ $room->code }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs mb-1">Tipe</p>
                        <p class="text-white font-medium">{{ $room->type ?? 'Standar' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs mb-1">Harga/Bulan</p>
                        <p class="text-white font-medium">Rp {{ number_format($room->price_monthly ?? 0, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs mb-1">Status</p>
                        <span class="px-2 py-1 bg-[#0d9488]/20 text-[#0d9488] text-xs rounded">{{ $tenant->status_label }}</span>
                    </div>
                </div>
            </div>
        @endif

        <!-- Recent Invoices -->
        <div class="bg-[#1f2937] border border-gray-800/50 rounded-2xl overflow-hidden">
            <div class="p-5 border-b border-gray-800/50 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-white">Tagihan Terbaru</h3>
                <a href="/customer/tagihan" class="text-[#0d9488] text-sm hover:underline">Lihat Semua</a>
            </div>
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-800/50">
                        <th class="text-left text-gray-400 text-sm font-medium py-3 px-5">No Invoice</th>
                        <th class="text-left text-gray-400 text-sm font-medium py-3 px-5">Tanggal</th>
                        <th class="text-left text-gray-400 text-sm font-medium py-3 px-5">Jatuh Tempo</th>
                        <th class="text-left text-gray-400 text-sm font-medium py-3 px-5">Total</th>
                        <th class="text-left text-gray-400 text-sm font-medium py-3 px-5">Status</th>
                        <th class="text-right text-gray-400 text-sm font-medium py-3 px-5">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices->take(5) as $invoice)
                        <tr class="border-b border-gray-800/30 hover:bg-gray-800/30 transition-colors">
                            <td class="py-3 px-5 text-white">{{ $invoice->invoice_number }}</td>
                            <td class="py-3 px-5 text-gray-400 text-sm">{{ $invoice->issue_date->format('d M Y') }}</td>
                            <td class="py-3 px-5 text-gray-400 text-sm">{{ $invoice->due_date->format('d M Y') }}</td>
                            <td class="py-3 px-5 text-white font-medium">Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</td>
                            <td class="py-3 px-5">
                                @if($invoice->status === 'paid')
                                    <span class="px-2 py-1 bg-[#0d9488]/20 text-[#0d9488] text-xs rounded">Lunas</span>
                                @elseif($invoice->status === 'overdue')
                                    <span class="px-2 py-1 bg-red-500/20 text-red-400 text-xs rounded">Jatuh Tempo</span>
                                @else
                                    <span class="px-2 py-1 bg-yellow-500/20 text-yellow-400 text-xs rounded">Menunggu</span>
                                @endif
                            </td>
                            <td class="py-3 px-5 text-right">
                                @if($invoice->status !== 'paid')
                                    <button wire:click="openPaymentModal({{ $invoice->id }})" class="px-3 py-1.5 bg-[#0d9488] hover:bg-[#0f766e] text-white text-sm rounded-lg transition-colors">
                                        Bayar
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-500">
                                Tidak ada tagihan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Payment Modal -->
        @if($showPaymentModal)
            <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
                <div class="bg-[#111827] border border-gray-800/50 rounded-2xl w-full max-w-md">
                    <div class="p-6 border-b border-gray-800/50 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-white">Ajukan Pembayaran</h3>
                        <button wire:click="closePaymentModal" class="text-gray-500 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <form wire:submit="submitPayment" class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Jumlah Pembayaran</label>
                            <input type="number" wire:model="paymentAmount" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]" placeholder="Masukkan jumlah">
                            @error('paymentAmount') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Metode Pembayaran</label>
                            <select wire:model="paymentMethod" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]">
                                <option value="transfer">Transfer Bank</option>
                                <option value="cash">Tunai</option>
                                <option value="qris">QRIS</option>
                            </select>
                            @error('paymentMethod') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Bukti Pembayaran (Opsional)</label>
                            <input type="file" wire:model="paymentProof" accept="image/*" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#0d9488]">
                            <p class="text-gray-500 text-xs mt-1">Upload screenshot bukti transfer (max 2MB)</p>
                            @error('paymentProof') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4">
                            <button type="button" wire:click="closePaymentModal" class="px-4 py-2.5 text-gray-400 hover:text-white transition-colors">Batal</button>
                            <button type="submit" class="px-6 py-2.5 bg-[#0d9488] hover:bg-[#0f766e] text-white font-medium rounded-xl transition-colors">
                                Kirim Pembayaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    @endif
</div>
