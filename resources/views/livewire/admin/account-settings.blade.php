<div>
    <button wire:click="openModal" class="flex items-center gap-2 px-4 py-2 bg-gray-600 hover:bg-gray-500 text-white rounded-lg transition-colors text-sm w-full">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        Pengaturan Akun
    </button>

    @if($showModal)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" wire:click.self="closeModal">
            <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md m-4">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Pengaturan Akun</h3>

                <!-- Tabs -->
                <div class="flex border-b border-gray-200 mb-4">
                    <button wire:click="setTab('password')" 
                        class="flex-1 pb-2 text-sm font-medium {{ $activeTab === 'password' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                        Ganti Password
                    </button>
                    <button wire:click="setTab('email')" 
                        class="flex-1 pb-2 text-sm font-medium {{ $activeTab === 'email' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-gray-500 hover:text-gray-700' }}">
                        Ganti Email
                    </button>
                </div>

                @if($activeTab === 'password')
                    <form wire:submit="updatePassword" class="space-y-4">
                        @if(session()->has('message_password'))
                            <div class="bg-green-100 border border-green-300 text-green-700 px-3 py-2 rounded-lg text-sm">
                                {{ session('message_password') }}
                            </div>
                        @endif

                        <div>
                            <label class="block text-gray-600 text-sm font-medium mb-2">Password Saat Ini</label>
                            <input type="password" wire:model="current_password" 
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500">
                            @error('current_password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-gray-600 text-sm font-medium mb-2">Password Baru</label>
                            <input type="password" wire:model="new_password" 
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500"
                                placeholder="Minimal 8 karakter">
                            @error('new_password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-gray-600 text-sm font-medium mb-2">Konfirmasi Password</label>
                            <input type="password" wire:model="new_password_confirmation" 
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500">
                        </div>

                        <div class="flex gap-3 pt-2">
                            <button type="button" wire:click="closeModal" 
                                class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium py-2 rounded-lg">
                                Tutup
                            </button>
                            <button type="submit" 
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 rounded-lg">
                                Simpan
                            </button>
                        </div>
                    </form>
                @endif

                @if($activeTab === 'email')
                    <form wire:submit="updateEmail" class="space-y-4">
                        @if(session()->has('message_email'))
                            <div class="bg-green-100 border border-green-300 text-green-700 px-3 py-2 rounded-lg text-sm">
                                {{ session('message_email') }}
                            </div>
                        @endif

                        <div>
                            <label class="block text-gray-600 text-sm font-medium mb-2">Email Saat Ini</label>
                            <input type="email" value="{{ Auth::user()->email }}" disabled
                                class="w-full bg-gray-100 border border-gray-300 rounded-lg px-4 py-2 text-gray-500 cursor-not-allowed">
                        </div>

                        <div>
                            <label class="block text-gray-600 text-sm font-medium mb-2">Password (Verifikasi)</label>
                            <input type="password" wire:model="email_current_password" 
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500">
                            @error('email_current_password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-gray-600 text-sm font-medium mb-2">Email Baru</label>
                            <input type="email" wire:model="new_email" 
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-blue-500">
                            @error('new_email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="bg-yellow-50 border border-yellow-300 rounded-lg p-3">
                            <p class="text-yellow-700 text-xs">⚠️ Setelah mengganti email, Anda perlu login ulang.</p>
                        </div>

                        <div class="flex gap-3 pt-2">
                            <button type="button" wire:click="closeModal" 
                                class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium py-2 rounded-lg">
                                Tutup
                            </button>
                            <button type="submit" 
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 rounded-lg">
                                Simpan
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    @endif
</div>
