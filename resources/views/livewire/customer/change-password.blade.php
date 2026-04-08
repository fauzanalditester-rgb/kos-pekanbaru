<div>
    <button wire:click="openModal" class="w-full bg-gray-700 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition-colors text-sm flex items-center justify-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
        </svg>
        Ganti Password
    </button>

    @if($showModal)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" wire:click.self="closeModal">
            <div class="bg-[#111827] p-6 rounded-2xl shadow-xl w-full max-w-md border border-gray-700 m-4">
                <h3 class="text-lg font-bold text-white mb-4">Ganti Password</h3>

                <form wire:submit="updatePassword" class="space-y-4">
                    <div>
                        <label class="block text-gray-400 text-sm font-medium mb-2">Password Saat Ini</label>
                        <input type="password" wire:model="current_password" 
                            class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]">
                        @error('current_password') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-gray-400 text-sm font-medium mb-2">Password Baru</label>
                        <input type="password" wire:model="new_password" 
                            class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]">
                        @error('new_password') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-gray-400 text-sm font-medium mb-2">Konfirmasi Password Baru</label>
                        <input type="password" wire:model="new_password_confirmation" 
                            class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]">
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="button" wire:click="closeModal" 
                            class="flex-1 bg-gray-700 hover:bg-gray-600 text-white font-medium py-2 rounded-xl transition-colors">
                            Batal
                        </button>
                        <button type="submit" 
                            class="flex-1 bg-[#0d9488] hover:bg-[#0f766e] text-white font-medium py-2 rounded-xl transition-colors">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
