<div class="h-full">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white">Info Kamar</h1>
        <p class="text-gray-400 text-sm mt-1">Detail kamar dan kontrak sewa Anda</p>
    </div>

    @if(!$room)
        <div class="flex flex-col items-center justify-center py-16 text-center">
            <div class="w-20 h-20 bg-gray-800 rounded-full flex items-center justify-center mb-4">
                <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            </div>
            <h2 class="text-xl font-bold text-white mb-2">Belum Ada Kamar</h2>
            <p class="text-gray-400">Anda belum terdaftar sebagai penyewa kamar.</p>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Room Info Card -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Main Room Card -->
                <div class="bg-[#1f2937] border border-gray-800/50 rounded-2xl p-6">
                    <div class="flex items-start justify-between mb-6">
                        <div>
                            <h2 class="text-xl font-bold text-white">{{ $room->code }}</h2>
                            <p class="text-gray-400 text-sm">{{ $property?->name ?? 'Properti' }}</p>
                        </div>
                        <span class="px-3 py-1.5 bg-[#0d9488]/20 text-[#0d9488] text-sm rounded-lg">{{ $tenant->status_label }}</span>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <div class="bg-gray-900/50 rounded-xl p-4">
                            <p class="text-gray-500 text-xs mb-1">Tipe</p>
                            <p class="text-white font-medium">{{ $room->type ?? 'Standar' }}</p>
                        </div>
                        <div class="bg-gray-900/50 rounded-xl p-4">
                            <p class="text-gray-500 text-xs mb-1">Lantai</p>
                            <p class="text-white font-medium">{{ $room->floor ?? '-' }}</p>
                        </div>
                        <div class="bg-gray-900/50 rounded-xl p-4">
                            <p class="text-gray-500 text-xs mb-1">Luas</p>
                            <p class="text-white font-medium">{{ $room->size ? $room->size . ' m²' : '-' }}</p>
                        </div>
                        <div class="bg-gray-900/50 rounded-xl p-4">
                            <p class="text-gray-500 text-xs mb-1">Harga/Bulan</p>
                            <p class="text-[#0d9488] font-medium">Rp {{ number_format($room->price_monthly ?? 0, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    @if($room->facilities)
                        <div class="mb-4">
                            <p class="text-gray-500 text-xs mb-2">Fasilitas</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach(explode(',', $room->facilities) as $facility)
                                    <span class="px-2 py-1 bg-gray-800 text-gray-300 text-xs rounded">{{ trim($facility) }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($room->description)
                        <div>
                            <p class="text-gray-500 text-xs mb-2">Keterangan</p>
                            <p class="text-gray-300 text-sm">{{ $room->description }}</p>
                        </div>
                    @endif
                </div>

                <!-- Contract Info -->
                <div class="bg-[#1f2937] border border-gray-800/50 rounded-2xl p-6">
                    <h3 class="text-lg font-semibold text-white mb-4">Informasi Kontrak</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-gray-500 text-xs mb-1">Tanggal Masuk</p>
                            <p class="text-white font-medium">{{ $tenant->move_in_date?->format('d M Y') ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs mb-1">Tanggal Keluar</p>
                            <p class="text-white font-medium">{{ $tenant->move_out_date?->format('d M Y') ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs mb-1">Durasi</p>
                            <p class="text-white font-medium">{{ $tenant->duration }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs mb-1">Deposit</p>
                            <p class="text-white font-medium">Rp {{ number_format($tenant->deposit ?? 0, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Contact Admin -->
                <div class="bg-[#1f2937] border border-gray-800/50 rounded-2xl p-6">
                    <h3 class="text-lg font-semibold text-white mb-4">Butuh Bantuan?</h3>
                    <p class="text-gray-400 text-sm mb-4">Hubungi admin jika ada masalah dengan kamar Anda.</p>
                    <a href="/admin/whatsapp" class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-[#0d9488] hover:bg-[#0f766e] text-white rounded-xl transition-colors text-sm font-medium">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.292-1.705-1.68-1.967-1.875-.264-.196-.576-.292-.888-.292a1.42 1.42 0 00-.486.078c-.252.084-1.056.39-2.403 1.144-1.695.9-2.805 1.35-3.33 1.35-.33 0-.537-.105-.63-.315-.093-.21-.047-.63.14-1.26.184-.63.427-1.26.73-1.89.302-.63.616-1.155.94-1.575.328-.42.643-.735.94-.945.298-.21.553-.315.766-.315.213 0 .403.07.57.21.166.14.35.35.553.63.203.28.37.507.5.682.13.175.28.385.448.63.17.245.305.437.407.575.103.14.184.257.245.35.062.095.098.178.11.252.01.073-.003.14-.04.196-.04.06-.087.1-.14.126-.054.025-.14.05-.26.073-.118.023-.267.035-.448.035-.298 0-.622-.082-.972-.245-.35-.164-.738-.415-1.166-.756-.428-.34-.87-.758-1.326-1.253-.455-.495-.87-1.048-1.246-1.66-.377-.61-.68-1.276-.91-1.996-.23-.72-.345-1.43-.345-2.13 0-.69.16-1.357.48-2 .32-.64.755-1.14 1.304-1.5.548-.36 1.134-.54 1.758-.54.64 0 1.23.2 1.77.6.54.4.98.92 1.32 1.56.34.64.51 1.32.51 2.04 0 .5-.093.96-.28 1.38-.186.42-.406.76-.66 1.02l-.045.045c.06.08.128.173.203.27.076.1.22.283.434.55.214.266.495.61.842 1.03.348.42.75.92 1.206 1.5.456.58.94 1.25 1.452 2.01z"/></svg>
                        Hubungi via WhatsApp
                    </a>
                </div>

                <!-- Pending Invoices -->
                @if($invoices->count())
                    <div class="bg-[#1f2937] border border-gray-800/50 rounded-2xl p-6">
                        <h3 class="text-lg font-semibold text-white mb-4">Tagihan Menunggak</h3>
                        <div class="space-y-3">
                            @foreach($invoices as $invoice)
                                <div class="flex items-center justify-between p-3 bg-gray-900/50 rounded-lg">
                                    <div>
                                        <p class="text-white text-sm font-medium">{{ $invoice->invoice_number }}</p>
                                        <p class="text-gray-500 text-xs">Jatuh tempo: {{ $invoice->due_date->format('d M Y') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-red-400 text-sm font-medium">Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <a href="/customer/tagihan" class="block mt-4 text-center text-[#0d9488] text-sm hover:underline">
                            Lihat Semua Tagihan →
                        </a>
                    </div>
                @endif
            </div>
        </div>
    @endif
</div>
