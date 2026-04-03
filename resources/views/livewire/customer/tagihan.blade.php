<div class="h-full">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white">Tagihan Saya</h1>
            <p class="text-gray-400 text-sm mt-1">Kelola dan bayar tagihan kamar Anda</p>
        </div>
    </div>

    <!-- Alert Messages -->
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

    @if(!$invoices->count() && !$filterStatus)
        <div class="flex flex-col items-center justify-center py-16 text-center">
            <div class="w-20 h-20 bg-gray-800 rounded-full flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <h2 class="text-xl font-bold text-white mb-2">Tidak Ada Tagihan</h2>
            <p class="text-gray-400">Anda tidak memiliki tagihan saat ini.</p>
        </div>
    @else
        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <button wire:click="setFilter('')" class="bg-[#1f2937] border {{ $filterStatus === '' ? 'border-[#0d9488]' : 'border-gray-800/50' }} rounded-2xl p-4 text-left hover:border-gray-700 transition-colors">
                <p class="text-gray-400 text-xs mb-1">Total Tagihan</p>
                <p class="text-2xl font-bold text-white">{{ $stats['total'] }}</p>
            </button>
            <button wire:click="setFilter('paid')" class="bg-[#1f2937] border {{ $filterStatus === 'paid' ? 'border-[#0d9488]' : 'border-gray-800/50' }} rounded-2xl p-4 text-left hover:border-gray-700 transition-colors">
                <p class="text-gray-400 text-xs mb-1">Lunas</p>
                <p class="text-2xl font-bold text-[#0d9488]">{{ $stats['paid'] }}</p>
            </button>
            <button wire:click="setFilter('sent')" class="bg-[#1f2937] border {{ $filterStatus === 'sent' ? 'border-[#0d9488]' : 'border-gray-800/50' }} rounded-2xl p-4 text-left hover:border-gray-700 transition-colors">
                <p class="text-gray-400 text-xs mb-1">Menunggu</p>
                <p class="text-2xl font-bold text-yellow-500">{{ $stats['pending'] }}</p>
            </button>
            <button wire:click="setFilter('overdue')" class="bg-[#1f2937] border {{ $filterStatus === 'overdue' ? 'border-[#0d9488]' : 'border-gray-800/50' }} rounded-2xl p-4 text-left hover:border-gray-700 transition-colors">
                <p class="text-gray-400 text-xs mb-1">Jatuh Tempo</p>
                <p class="text-2xl font-bold text-red-500">{{ $stats['overdue'] }}</p>
            </button>
        </div>

        <!-- Invoices Table -->
        <div class="bg-[#1f2937] border border-gray-800/50 rounded-2xl overflow-hidden">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-800/50">
                        <th class="text-left text-gray-400 text-sm font-medium py-4 px-6">No Invoice</th>
                        <th class="text-left text-gray-400 text-sm font-medium py-4 px-6">Kamar</th>
                        <th class="text-left text-gray-400 text-sm font-medium py-4 px-6">Tanggal</th>
                        <th class="text-left text-gray-400 text-sm font-medium py-4 px-6">Jatuh Tempo</th>
                        <th class="text-left text-gray-400 text-sm font-medium py-4 px-6">Total</th>
                        <th class="text-left text-gray-400 text-sm font-medium py-4 px-6">Status</th>
                        <th class="text-right text-gray-400 text-sm font-medium py-4 px-6">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $invoice)
                        <tr class="border-b border-gray-800/30 hover:bg-gray-800/30 transition-colors">
                            <td class="py-4 px-6 text-white font-medium">{{ $invoice->invoice_number }}</td>
                            <td class="py-4 px-6 text-gray-400 text-sm">{{ $invoice->room?->code ?? '-' }}</td>
                            <td class="py-4 px-6 text-gray-400 text-sm">{{ $invoice->issue_date->format('d M Y') }}</td>
                            <td class="py-4 px-6 text-gray-400 text-sm">{{ $invoice->due_date->format('d M Y') }}</td>
                            <td class="py-4 px-6 text-white font-medium">Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</td>
                            <td class="py-4 px-6">
                                @if($invoice->status === 'paid')
                                    <span class="px-2 py-1 bg-[#0d9488]/20 text-[#0d9488] text-xs rounded">Lunas</span>
                                @elseif($invoice->status === 'overdue')
                                    <span class="px-2 py-1 bg-red-500/20 text-red-400 text-xs rounded">Jatuh Tempo</span>
                                @else
                                    <span class="px-2 py-1 bg-yellow-500/20 text-yellow-400 text-xs rounded">Menunggu</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                @if($invoice->status !== 'paid')
                                    <button wire:click="openPaymentModal({{ $invoice->id }})" class="px-3 py-1.5 bg-[#0d9488] hover:bg-[#0f766e] text-white text-sm rounded-lg transition-colors">
                                        Bayar
                                    </button>
                                @else
                                    <span class="text-gray-500 text-sm">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-gray-500">
                                Tidak ada tagihan {{ $filterStatus ? 'dengan status ini' : '' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif

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
</div>
