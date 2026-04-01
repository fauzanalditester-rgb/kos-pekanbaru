<div class="h-[calc(100vh-80px)] flex flex-col overflow-y-auto">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white">Pengaturan</h1>
        <p class="text-gray-400 text-sm">Kelola profil usaha dan preferensi.</p>
    </div>

    <!-- Main Card -->
    <div class="bg-[#1f2937] border border-gray-800/50 rounded-2xl p-6 max-w-3xl">
        <!-- Profil Usaha -->
        <div class="mb-8">
            <div class="flex items-center gap-2 mb-5">
                <svg class="w-5 h-5 text-[#0d9488]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4zm3 1a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/></svg>
                <h3 class="text-white font-semibold">Profil Usaha</h3>
            </div>

            <div class="space-y-4">
                <!-- Nama Brand -->
                <div>
                    <label class="text-gray-400 text-sm mb-2 block">Nama Brand</label>
                    <input type="text" wire:model="brandName" class="w-full bg-[#0f172a] border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#0d9488]">
                </div>

                <!-- Email Kontak -->
                <div>
                    <label class="text-gray-400 text-sm mb-2 block">Email Kontak</label>
                    <input type="email" wire:model="email" class="w-full bg-[#0f172a] border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#0d9488]">
                </div>

                <!-- No. WhatsApp -->
                <div>
                    <label class="text-gray-400 text-sm mb-2 block">No. WhatsApp</label>
                    <input type="text" wire:model="whatsapp" class="w-full bg-[#0f172a] border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#0d9488]">
                </div>

                <!-- Rekening Bank -->
                <div>
                    <label class="text-gray-400 text-sm mb-2 block">Rekening Bank</label>
                    <input type="text" wire:model="bankAccount" class="w-full bg-[#0f172a] border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#0d9488]">
                </div>
            </div>
        </div>

        <!-- Divider -->
        <div class="border-t border-gray-800/50 my-6"></div>

        <!-- Aturan Billing & Denda -->
        <div>
            <h3 class="text-white font-semibold mb-5">Aturan Billing & Denda</h3>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <!-- Tanggal Billing -->
                <div>
                    <label class="text-gray-400 text-sm mb-2 block">Tanggal Billing</label>
                    <input type="number" wire:model="billingDate" class="w-full bg-[#0f172a] border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#0d9488]">
                </div>

                <!-- Tipe Denda -->
                <div>
                    <label class="text-gray-400 text-sm mb-2 block">Tipe Denda</label>
                    <div class="relative">
                        <select wire:model="penaltyType" class="w-full bg-[#0f172a] border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#0d9488] appearance-none">
                            <option value="flat">Flat (Rp/hari)</option>
                            <option value="percentage">Persentase (%)</option>
                        </select>
                        <svg class="w-4 h-4 text-gray-500 absolute right-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>
            </div>

            <!-- Denda/Hari -->
            <div class="max-w-xs">
                <label class="text-gray-400 text-sm mb-2 block">Denda/Hari (Rp)</label>
                <input type="number" wire:model="penaltyAmount" class="w-full bg-[#0f172a] border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#0d9488]">
            </div>
        </div>

        <!-- Save Button -->
        <div class="mt-8 flex justify-end">
            <button wire:click="save" class="flex items-center gap-2 px-6 py-3 bg-[#0d9488] hover:bg-[#0f766e] text-white font-medium rounded-xl transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Simpan Pengaturan
            </button>
        </div>

        @if(session()->has('message'))
            <div class="mt-4 p-3 bg-green-500/20 border border-green-500/30 rounded-xl text-green-400 text-sm">
                {{ session('message') }}
            </div>
        @endif
    </div>
</div>
