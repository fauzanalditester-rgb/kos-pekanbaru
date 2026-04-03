<div class="h-full">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white">Manajemen User</h1>
            <p class="text-gray-400 text-sm mt-1">Kelola akses admin, super admin, dan customer</p>
        </div>
        <button wire:click="openModal" class="flex items-center gap-2 px-4 py-2.5 bg-[#0d9488] hover:bg-[#0f766e] text-white font-medium rounded-xl transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah User
        </button>
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

    <!-- Search -->
    <div class="mb-6">
        <div class="relative max-w-md">
            <svg class="w-5 h-5 text-gray-500 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" wire:model.live="search" placeholder="Cari user..." class="w-full bg-[#1f2937] border border-gray-700 rounded-xl pl-10 pr-4 py-2.5 text-white text-sm focus:outline-none focus:border-[#0d9488]">
        </div>
    </div>

    <!-- Users Table -->
    <div class="bg-[#1f2937] border border-gray-800/50 rounded-2xl overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-800/50">
                    <th class="text-left text-gray-400 text-sm font-medium py-4 px-6">User</th>
                    <th class="text-left text-gray-400 text-sm font-medium py-4 px-6">Email</th>
                    <th class="text-left text-gray-400 text-sm font-medium py-4 px-6">Role</th>
                    <th class="text-left text-gray-400 text-sm font-medium py-4 px-6">Tenant</th>
                    <th class="text-left text-gray-400 text-sm font-medium py-4 px-6">Dibuat</th>
                    <th class="text-right text-gray-400 text-sm font-medium py-4 px-6">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr class="border-b border-gray-800/30 hover:bg-gray-800/30 transition-colors">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-[#0d9488]/20 flex items-center justify-center text-[#0d9488] font-bold">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span class="text-white font-medium">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-gray-400 text-sm">{{ $user->email }}</td>
                        <td class="py-4 px-6">
                            @if($user->isSuperAdmin())
                                <span class="px-2 py-1 bg-purple-500/20 text-purple-400 text-xs rounded-lg">Super Admin</span>
                            @elseif($user->isAdmin())
                                <span class="px-2 py-1 bg-blue-500/20 text-blue-400 text-xs rounded-lg">Admin</span>
                            @else
                                <span class="px-2 py-1 bg-green-500/20 text-green-400 text-xs rounded-lg">Customer</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-gray-400 text-sm">
                            {{ $user->tenant?->name ?? '-' }}
                        </td>
                        <td class="py-4 px-6 text-gray-400 text-sm">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="py-4 px-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button wire:click="editUser({{ $user->id }})" class="p-2 bg-gray-800 hover:bg-gray-700 text-gray-400 hover:text-white rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <button wire:click="deleteUser({{ $user->id }})" wire:confirm="Yakin hapus user {{ $user->name }}?" class="p-2 bg-red-500/20 hover:bg-red-500/30 text-red-400 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-gray-500">
                            Tidak ada user ditemukan
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $users->links() }}
    </div>

    <!-- Modal -->
    @if($showModal)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
            <div class="bg-[#111827] border border-gray-800/50 rounded-2xl w-full max-w-md">
                <div class="p-6 border-b border-gray-800/50 flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-white">{{ $isEditing ? 'Edit User' : 'Tambah User Baru' }}</h3>
                    <button wire:click="closeModal" class="text-gray-500 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <form wire:submit="saveUser" class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Nama</label>
                        <input type="text" wire:model="name" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]" placeholder="Nama lengkap">
                        @error('name') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Email</label>
                        <input type="email" wire:model="email" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]" placeholder="email@example.com">
                        @error('email') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Password {{ $isEditing ? '(kosongkan jika tidak diubah)' : '' }}</label>
                        <input type="password" wire:model="password" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]" placeholder="Minimal 8 karakter">
                        @error('password') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-400 mb-2">Role</label>
                        <select wire:model.live="role" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]">
                            <option value="admin">Admin</option>
                            <option value="super_admin">Super Admin</option>
                            <option value="customer">Customer</option>
                        </select>
                        @error('role') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                    </div>

                    @if($role === 'customer')
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Link ke Tenant</label>
                            <select wire:model="tenant_id" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]">
                                <option value="">Pilih Penghuni...</option>
                                @foreach($tenants as $tenant)
                                    <option value="{{ $tenant->id }}">{{ $tenant->name }} ({{ $tenant->room?->code ?? '-' }})</option>
                                @endforeach
                            </select>
                            @error('tenant_id') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                        </div>
                    @endif

                    <div class="flex items-center justify-end gap-3 pt-4">
                        <button type="button" wire:click="closeModal" class="px-4 py-2.5 text-gray-400 hover:text-white transition-colors">Batal</button>
                        <button type="submit" class="px-6 py-2.5 bg-[#0d9488] hover:bg-[#0f766e] text-white font-medium rounded-xl transition-colors">
                            {{ $isEditing ? 'Simpan' : 'Tambah' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
