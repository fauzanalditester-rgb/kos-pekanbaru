<div>
    <button wire:click="openModal" class="w-full bg-gray-700 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition-colors text-sm flex items-center justify-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
        </svg>
        Ganti Email
    </button>

    @if($showModal)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" wire:click.self="closeModal">
            <div class="bg-[#111827] p-6 rounded-2xl shadow-xl w-full max-w-md border border-gray-700 m-4">
                <h3 class="text-lg font-bold text-white mb-4">Ganti Email</h3>

                <form wire:submit="updateEmail" class="space-y-4">
                    <div>
                        <label class="block text-gray-400 text-sm font-medium mb-2">Password Saat Ini</label>
                        <input type="password" wire:model="current_password" 
                            class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]">
                        @error('current_password') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-gray-400 text-sm font-medium mb-2">Email Baru</label>
                        <input type="email" wire:model="new_email" 
                            class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]">
                        @error('new_email') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
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
