<div class="h-full">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white">Profil Saya</h1>
        <p class="text-gray-400 text-sm mt-1">Kelola informasi pribadi dan akun Anda</p>
    </div>

    <!-- Alert Messages -->
    @if (session()->has('message'))
        <div class="mb-4 bg-[#0d9488]/10 border border-[#0d9488]/20 text-[#0d9488] px-4 py-3 rounded-xl text-sm">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Info -->
            <div class="bg-[#1f2937] border border-gray-800/50 rounded-2xl p-6">
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-2xl bg-[#0d9488]/20 flex items-center justify-center text-[#0d9488] text-2xl font-bold">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-white">{{ $user->name }}</h2>
                            <p class="text-gray-400 text-sm">{{ $user->email }}</p>
                            <span class="inline-block mt-1 px-2 py-0.5 bg-green-500/20 text-green-400 text-xs rounded">Customer</span>
                        </div>
                    </div>
                    <button wire:click="openEditModal" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white text-sm rounded-lg transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Edit Profil
                    </button>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div>
                        <p class="text-gray-500 text-xs mb-1">Nama Lengkap</p>
                        <p class="text-white font-medium">{{ $user->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs mb-1">Email</p>
                        <p class="text-white font-medium">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs mb-1">Telepon</p>
                        <p class="text-white font-medium">{{ $tenant?->phone ?? '-' }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-gray-500 text-xs mb-1">Alamat</p>
                        <p class="text-white font-medium">{{ $tenant?->address ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs mb-1">Kontak Darurat</p>
                        <p class="text-white font-medium">{{ $tenant?->emergency_contact ?? '-' }}</p>
                    </div>
                </div>
            </div>

            @if($tenant)
                <!-- Tenant Info -->
                <div class="bg-[#1f2937] border border-gray-800/50 rounded-2xl p-6">
                    <h3 class="text-lg font-semibold text-white mb-4">Informasi Penyewa</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-gray-500 text-xs mb-1">No KTP</p>
                            <p class="text-white font-medium">{{ $tenant->id_card_number ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs mb-1">Tanggal Masuk</p>
                            <p class="text-white font-medium">{{ $tenant->move_in_date?->format('d M Y') ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs mb-1">Status</p>
                            <span class="px-2 py-1 {{ $tenant->status_color }} text-xs rounded">{{ $tenant->status_label }}</span>
                        </div>
                    </div>

                    @if($tenant->id_card_photo)
                        <div class="mt-4">
                            <p class="text-gray-500 text-xs mb-2">Foto KTP</p>
                            <a href="{{ asset('storage/' . $tenant->id_card_photo) }}" target="_blank" class="inline-flex items-center gap-2 text-[#0d9488] hover:underline text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Lihat Foto KTP
                            </a>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- Quick Links -->
        <div class="space-y-6">
            <div class="bg-[#1f2937] border border-gray-800/50 rounded-2xl p-6">
                <h3 class="text-lg font-semibold text-white mb-4">Menu Cepat</h3>
                <div class="space-y-2">
                    <a href="/customer/tagihan" class="flex items-center gap-3 p-3 bg-gray-900/50 rounded-xl hover:bg-gray-800 transition-colors">
                        <div class="w-10 h-10 bg-yellow-500/20 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-white text-sm font-medium">Tagihan Saya</p>
                            <p class="text-gray-500 text-xs">Lihat dan bayar tagihan</p>
                        </div>
                    </a>
                    <a href="/customer/kamar" class="flex items-center gap-3 p-3 bg-gray-900/50 rounded-xl hover:bg-gray-800 transition-colors">
                        <div class="w-10 h-10 bg-[#0d9488]/20 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-[#0d9488]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        </div>
                        <div>
                            <p class="text-white text-sm font-medium">Info Kamar</p>
                            <p class="text-gray-500 text-xs">Detail kamar Anda</p>
                        </div>
                    </a>
                    <a href="/customer/pembayaran" class="flex items-center gap-3 p-3 bg-gray-900/50 rounded-xl hover:bg-gray-800 transition-colors">
                        <div class="w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        </div>
                        <div>
                            <p class="text-white text-sm font-medium">Riwayat Pembayaran</p>
                            <p class="text-gray-500 text-xs">Lihat pembayaran sebelumnya</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Account Security -->
            <div class="bg-[#1f2937] border border-gray-800/50 rounded-2xl p-6">
                <h3 class="text-lg font-semibold text-white mb-4">Keamanan Akun</h3>
                <div class="space-y-3">
                    <livewire:customer.change-password />
                    <livewire:customer.change-email />
                </div>
                <div class="mt-4 pt-4 border-t border-gray-800/50">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-yellow-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <p class="text-gray-400 text-xs">Jaga kerahasiaan password Anda. Hubungi admin jika ada aktivitas mencurigakan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    @if($showEditModal)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-[#111827] border border-gray-800/50 rounded-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
                <div class="p-6 border-b border-gray-800/50 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-white">Edit Profil</h3>
                    <button wire:click="closeEditModal" class="text-gray-500 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form wire:submit="saveProfile" class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Nama Lengkap</label>
                        <input type="text" wire:model="name" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]">
                        @error('name') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Email</label>
                        <input type="email" wire:model="email" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]">
                        @error('email') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Nomor Telepon</label>
                        <input type="text" wire:model="phone" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]">
                        @error('phone') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Alamat</label>
                        <textarea wire:model="address" rows="3" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]"></textarea>
                        @error('address') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Kontak Darurat</label>
                        <input type="text" wire:model="emergency_contact" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]" placeholder="Nama - No Telepon">
                        @error('emergency_contact') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="border-t border-gray-800/50 pt-4">
                        <p class="text-gray-500 text-xs mb-3">Ubah Password (opsional)</p>
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-2">Password Saat Ini</label>
                                <input type="password" wire:model="currentPassword" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]" placeholder="Isi jika ingin ubah password">
                                @error('currentPassword') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-2">Password Baru</label>
                                <input type="password" wire:model="newPassword" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]" placeholder="Minimal 8 karakter">
                                @error('newPassword') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    @if($tenant)
                        <div class="border-t border-gray-800/50 pt-4">
                            <label class="block text-sm font-medium text-gray-400 mb-2">Update Foto KTP</label>
                            <input type="file" wire:model="idCardPhoto" accept="image/*" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#0d9488]">
                            @error('idCardPhoto') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>
                    @endif

                    <div class="flex items-center justify-end gap-3 pt-4">
                        <button type="button" wire:click="closeEditModal" class="px-4 py-2.5 text-gray-400 hover:text-white transition-colors">Batal</button>
                        <button type="submit" class="px-6 py-2.5 bg-[#0d9488] hover:bg-[#0f766e] text-white font-medium rounded-xl transition-colors">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
