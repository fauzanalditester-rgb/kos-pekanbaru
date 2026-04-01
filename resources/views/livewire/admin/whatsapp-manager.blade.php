<div class="h-[calc(100vh-80px)] flex flex-col">
    <!-- Header -->
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-[#0d9488]/20 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-[#0d9488]" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-bold text-white">WhatsApp Manager</h1>
                <p class="text-gray-400 text-sm">Kelola komunikasi dengan penghuni kost</p>
            </div>
        </div>
        <div class="flex items-center gap-2 px-3 py-1.5 {{ $isConfigured ? 'bg-green-500/20' : 'bg-gray-800/50' }} rounded-full text-sm {{ $isConfigured ? 'text-green-500' : 'text-gray-400' }}">
            <span class="w-2 h-2 {{ $isConfigured ? 'bg-green-500' : 'bg-gray-500' }} rounded-full"></span>
            {{ $isConfigured ? 'Terkoneksi' : 'Belum Dikonfigurasi' }}
        </div>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 bg-[#0d9488]/10 border border-[#0d9488]/20 text-[#0d9488] px-4 py-3 rounded-xl text-sm">
            {{ session('message') }}
        </div>
    @endif

    <!-- Tabs -->
    <div class="flex items-center gap-1 mb-4 bg-[#111827] p-1 rounded-xl w-fit">
        <button wire:click="setTab('pesan')" class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ $activeTab === 'pesan' ? 'bg-[#0d9488] text-white' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                Pesan
            </span>
        </button>
        <button wire:click="setTab('penghuni')" class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ $activeTab === 'penghuni' ? 'bg-[#0d9488] text-white' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Penghuni
            </span>
        </button>
        <button wire:click="setTab('templat')" class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ $activeTab === 'templat' ? 'bg-[#0d9488] text-white' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Templat
            </span>
        </button>
        <button wire:click="setTab('broadcast')" class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ $activeTab === 'broadcast' ? 'bg-[#0d9488] text-white' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                Broadcast
            </span>
        </button>
        <button wire:click="setTab('otomatis')" class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ $activeTab === 'otomatis' ? 'bg-[#0d9488] text-white' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Otomatis
            </span>
        </button>
        <button wire:click="setTab('pengaturan')" class="px-4 py-2 text-sm font-medium rounded-lg transition-colors {{ $activeTab === 'pengaturan' ? 'bg-[#0d9488] text-white' : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Pengaturan
            </span>
        </button>
    </div>

    <!-- Content Area -->
    <div class="flex-1 bg-[#111827] border border-gray-800/50 rounded-2xl overflow-hidden">
        @if($activeTab === 'pesan')
            <!-- Tab Pesan - Chat Layout -->
            <div class="flex h-full">
                <!-- Left Sidebar - Tenant List -->
                <div class="w-80 border-r border-gray-800/50 flex flex-col">
                    <!-- Search -->
                    <div class="p-4 border-b border-gray-800/50">
                        <div class="relative">
                            <svg class="w-5 h-5 text-gray-500 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="text" wire:model.live="search" placeholder="Cari penghuni..." class="w-full bg-[#0f172a] border border-gray-700 rounded-xl pl-10 pr-4 py-2.5 text-white text-sm focus:outline-none focus:border-[#0d9488]">
                        </div>
                    </div>

                    <!-- Tenant List -->
                    <div class="flex-1 overflow-y-auto">
                        @forelse($tenants as $tenant)
                            <div wire:click="selectTenant({{ $tenant['id'] }})" class="flex items-center gap-3 p-4 hover:bg-gray-800/50 cursor-pointer transition-colors border-b border-gray-800/30 {{ $selectedTenant == $tenant['id'] ? 'bg-gray-800/50' : '' }}">
                                <div class="relative">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold text-white" style="background-color: {{ $tenant['avatar_color'] }};">
                                        {{ $tenant['initials'] }}
                                    </div>
                                    @if($tenant['online'])
                                        <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-green-500 rounded-full border-2 border-[#111827]"></span>
                                    @else
                                        <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-gray-500 rounded-full border-2 border-[#111827]"></span>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2">
                                        <h4 class="text-white font-medium text-sm truncate">{{ $tenant['name'] }}</h4>
                                        @if($tenant['menunggak'])
                                            <span class="px-2 py-0.5 bg-red-500 text-white text-xs rounded-full font-medium">Menunggak</span>
                                        @endif
                                    </div>
                                    <p class="text-gray-400 text-xs">{{ $tenant['room'] }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-gray-500 text-xs">{{ $tenant['time'] }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center">
                                <p class="text-gray-500 text-sm">Tidak ada penghuni aktif</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Right Content - Chat -->
                <div class="flex-1 flex flex-col items-center justify-center">
                    @if($selectedTenant && $selectedMockTenant)
                        <!-- Chat Interface -->
                        <div class="w-full h-full flex flex-col">
                            <!-- Chat Header -->
                            <div class="flex items-center gap-3 p-4 border-b border-gray-800/50">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold text-white" style="background-color: {{ $selectedMockTenant['avatar_color'] }};">
                                    {{ $selectedMockTenant['initials'] }}
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2">
                                        <h4 class="text-white font-medium">{{ $selectedMockTenant['name'] }}</h4>
                                        @if($selectedMockTenant['menunggak'])
                                            <span class="px-2 py-0.5 bg-red-500 text-white text-xs rounded-full font-medium">Menunggak</span>
                                        @endif
                                    </div>
                                    <p class="text-gray-400 text-xs">{{ $selectedMockTenant['room'] }}</p>
                                </div>
                            </div>

                            <!-- Messages -->
                            <div class="flex-1 overflow-y-auto p-4 space-y-4">
                                @forelse($messages as $msg)
                                    <div class="flex {{ $msg->direction == 'out' ? 'justify-end' : 'justify-start' }}">
                                        <div class="max-w-[70%] px-4 py-2 rounded-2xl {{ $msg->direction == 'out' ? 'bg-[#0d9488] text-white rounded-br-none' : 'bg-gray-800 text-white rounded-bl-none' }}">
                                            <p class="text-sm">{{ $msg->message }}</p>
                                            <p class="text-xs mt-1 {{ $msg->direction == 'out' ? 'text-[#0d9488]/70' : 'text-gray-500' }}">{{ $msg->sent_at?->format('H:i') }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="flex items-center justify-center h-full">
                                        <p class="text-gray-500 text-sm">Belum ada pesan. Mulai chat sekarang!</p>
                                    </div>
                                @endforelse
                            </div>

                            <!-- Message Input -->
                            <div class="p-4 border-t border-gray-800/50">
                                <form wire:submit="sendMessage" class="flex items-center gap-2">
                                    <input type="text" wire:model="message" placeholder="Ketik pesan..." class="flex-1 bg-[#0f172a] border border-gray-700 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:border-[#0d9488]">
                                    <button type="submit" class="p-2.5 bg-[#0d9488] hover:bg-[#0f766e] text-white rounded-xl transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="text-center">
                            <div class="w-20 h-20 mx-auto mb-4 text-[#0d9488]/30">
                                <svg class="w-full h-full" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                </svg>
                            </div>
                            <p class="text-gray-400 text-sm">Pilih penghuni untuk mulai chat</p>
                        </div>
                    @endif
                </div>
            </div>
        @elseif($activeTab === 'penghuni')
            <!-- Tab Penghuni - Grid Card Layout -->
            <div class="p-6 overflow-y-auto h-full">
                <!-- Stats Cards -->
                <div class="flex gap-4 mb-6">
                    <div class="bg-[#0d9488]/20 border border-[#0d9488]/30 rounded-2xl p-4 flex-1">
                        <p class="text-gray-400 text-sm mb-1">Total Aktif</p>
                        <p class="text-3xl font-bold text-[#0d9488]">{{ $tenants->count() }}</p>
                    </div>
                    <div class="bg-red-500/10 border border-red-500/30 rounded-2xl p-4 flex-1">
                        <p class="text-gray-400 text-sm mb-1">Menunggak</p>
                        <p class="text-3xl font-bold text-red-500">{{ $tenants->where('menunggak', true)->count() }}</p>
                    </div>
                </div>

                <!-- Grid Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($tenants as $p)
                        <div class="bg-[#1f2937] border border-gray-800/50 rounded-2xl p-4">
                            <!-- Header -->
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-12 h-12 rounded-full flex items-center justify-center text-sm font-bold text-white" style="background-color: {{ $p['avatar_color'] }};">
                                    {{ $p['initials'] }}
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2">
                                        <h4 class="text-white font-medium">{{ $p['name'] }}</h4>
                                    </div>
                                    <span class="px-2 py-0.5 {{ $p['menunggak'] ? 'bg-red-500/20 text-red-400' : 'bg-[#0d9488]/20 text-[#0d9488]' }} text-xs rounded-full">{{ $p['menunggak'] ? 'Menunggak' : 'Aktif' }}</span>
                                </div>
                            </div>

                            <!-- Info -->
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center gap-2 text-sm">
                                    <svg class="w-4 h-4 text-orange-500" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/></svg>
                                    <span class="text-gray-300">{{ $p['room'] }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm">
                                    <svg class="w-4 h-4 text-blue-400" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/></svg>
                                    <span class="text-gray-300">{{ $p['phone'] }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm">
                                    <svg class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v1.698c.22-.071.412-.164.567-.267.364-.243.433-.468.433-.582 0-.114-.07-.34-.433-.582a2.305 2.305 0 00-.567-.267z"/><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/></svg>
                                    <span class="text-gray-300">Rp {{ $p['price'] }}/bln</span>
                                </div>
                                <div class="flex items-center gap-2 text-sm">
                                    <svg class="w-4 h-4 text-blue-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
                                    <span class="text-gray-400">Jatuh tempo: {{ $p['due_date'] }}</span>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex gap-2">
                                <button wire:click="selectTenant({{ $p['id'] }})" class="flex-1 flex items-center justify-center gap-2 px-3 py-2 bg-[#0f172a] hover:bg-gray-800 text-white text-sm rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                    Chat
                                </button>
                                <a href="https://wa.me/{{ $p['phone'] }}" target="_blank" class="flex-1 flex items-center justify-center gap-2 px-3 py-2 bg-[#0f172a] hover:bg-gray-800 text-white text-sm rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                    WA
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-12">
                            <p class="text-gray-500 text-sm">Tidak ada penghuni aktif</p>
                        </div>
                    @endforelse
                </div>
            </div>
        @elseif($activeTab === 'templat')
            <!-- Tab Templat - Template Grid Layout -->
            <div class="p-6 overflow-y-auto h-full">
                <!-- Header -->
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-white">Templat Pesan</h2>
                    <button wire:click="openTemplateModal" class="flex items-center gap-2 px-4 py-2 bg-[#0d9488] hover:bg-[#0f766e] text-white text-sm font-medium rounded-xl transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Buat Templat +
                    </button>
                </div>

                <!-- Template Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($templates as $t)
                        <div class="bg-[#1f2937] border border-gray-800/50 rounded-2xl p-4">
                            <!-- Header -->
                            <div class="flex items-start gap-3 mb-3">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background-color: {{ $t['icon_color'] ?? '#3b82f6' }}20;">
                                    @if(($t['icon'] ?? 'bell') === 'bell')
                                        <svg class="w-5 h-5" style="color: {{ $t['icon_color'] ?? '#3b82f6' }};" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/></svg>
                                    @elseif(($t['icon'] ?? '') === 'calendar')
                                        <svg class="w-5 h-5" style="color: {{ $t['icon_color'] ?? '#3b82f6' }};" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
                                    @elseif(($t['icon'] ?? '') === 'alert')
                                        <svg class="w-5 h-5" style="color: {{ $t['icon_color'] ?? '#3b82f6' }};" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    @elseif(($t['icon'] ?? '') === 'check')
                                        <svg class="w-5 h-5" style="color: {{ $t['icon_color'] ?? '#3b82f6' }};" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    @elseif(($t['icon'] ?? '') === 'user')
                                        <svg class="w-5 h-5" style="color: {{ $t['icon_color'] ?? '#3b82f6' }};" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 012 2v7a2 2 0 01-2 2h-1a2 2 0 01-2-2v-1H5v1a2 2 0 01-2 2H2a2 2 0 01-2-2v-7a2 2 0 012-2 18 18 0 001.579-.943 4.38 4.38 0 001.9-.723A7.008 7.008 0 0113 8z"/></svg>
                                    @elseif(($t['icon'] ?? '') === 'document')
                                        <svg class="w-5 h-5" style="color: {{ $t['icon_color'] ?? '#3b82f6' }};" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/></svg>
                                    @else
                                        <svg class="w-5 h-5" style="color: {{ $t['icon_color'] ?? '#3b82f6' }};" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 3a1 1 0 00-1.447-.894L8.763 6H5a3 3 0 000 6h.28l1.771 5.316A1 1 0 008 18h1a1 1 0 001-1v-4.382l6.553 3.276A1 1 0 0018 15V3z" clip-rule="evenodd"/></svg>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <span class="px-2 py-0.5 {{ $t['tag_color'] ?? 'bg-blue-500/20 text-blue-400' }} text-xs rounded-full">{{ $t['tag'] ?? 'info' }}</span>
                                    <h4 class="text-white font-medium mt-1">{{ $t['name'] }}</h4>
                                </div>
                            </div>

                            <!-- Content Preview -->
                            <p class="text-gray-400 text-sm mb-4 line-clamp-3">{{ $t['content'] }}</p>

                            <!-- Actions -->
                            <div class="flex gap-2">
                                <button wire:click="selectTenant({{ $t['id'] }})" class="flex-1 px-3 py-2 bg-[#22c55e] hover:bg-[#16a34a] text-white text-sm font-medium rounded-lg transition-colors">
                                    Kirim ke Penghuni
                                </button>
                                <button wire:click="openTemplateModal({{ $t['id'] }})" class="px-3 py-2 bg-gray-700 hover:bg-gray-600 text-white text-sm rounded-lg transition-colors">
                                    Edit
                                </button>
                                <button wire:click="deleteTemplate({{ $t['id'] }})" wire:confirm="Hapus template ini?" class="px-3 py-2 bg-red-500/20 hover:bg-red-500/30 text-red-400 text-sm rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-12">
                            <p class="text-gray-500 text-sm mb-4">Belum ada template</p>
                            <button wire:click="openTemplateModal" class="px-4 py-2 bg-[#0d9488] hover:bg-[#0f766e] text-white text-sm font-medium rounded-lg transition-colors">
                                Buat Template Pertama
                            </button>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Template Modal -->
            @if($showTemplateModal)
                <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
                    <div class="bg-[#111827] border border-gray-800/50 rounded-2xl w-full max-w-lg">
                        <div class="p-6 border-b border-gray-800/50 flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-white">{{ $editingTemplate ? 'Edit Template' : 'Buat Template Baru' }}</h3>
                            <button wire:click="closeTemplateModal" class="text-gray-500 hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                        <form wire:submit="saveTemplate" class="p-6 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-2">Nama Template</label>
                                <input type="text" wire:model="templateName" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]" placeholder="Contoh: Peringatan Tagihan">
                                @error('templateName') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-2">Tag</label>
                                <select wire:model="templateTag" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]">
                                    <option value="tagihan">Tagihan</option>
                                    <option value="konfirmasi">Konfirmasi</option>
                                    <option value="info">Info</option>
                                    <option value="broadcast">Broadcast</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-2">Isi Pesan</label>
                                <textarea wire:model="templateContent" rows="6" class="w-full bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]" placeholder="Tulis pesan template..."></textarea>
                                @error('templateContent') <span class="text-red-400 text-xs">{{ $message }}</span> @enderror
                                <p class="text-gray-500 text-xs mt-2">Gunakan @{{nama}} untuk nama penghuni, @{{kamar}} untuk nomor kamar</p>
                            </div>
                            <div class="flex items-center justify-end gap-3 pt-4">
                                <button type="button" wire:click="closeTemplateModal" class="px-4 py-2.5 text-gray-400 hover:text-white transition-colors">Batal</button>
                                <button type="submit" class="px-6 py-2.5 bg-[#0d9488] hover:bg-[#0f766e] text-white font-medium rounded-xl transition-colors">
                                    {{ $editingTemplate ? 'Simpan' : 'Buat' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        @elseif($activeTab === 'broadcast')
            <!-- Tab Broadcast - Broadcast Message Layout -->
            <div class="flex h-full">
                <!-- Left Side - Tenant Selection -->
                <div class="w-[45%] border-r border-gray-800/50 flex flex-col p-4">
                    <!-- Filter Buttons -->
                    <div class="flex gap-2 mb-4">
                        <button wire:click="selectAllTenants" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white text-sm rounded-lg transition-colors">Pilih Semua</button>
                        <button wire:click="selectOverdueTenants" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white text-sm rounded-lg transition-colors">Hanya Menunggak</button>
                        <button wire:click="resetSelection" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white text-sm rounded-lg transition-colors">Reset</button>
                    </div>

                    <!-- Tenant List with Checkboxes -->
                    <div class="flex-1 overflow-y-auto space-y-2">
                        @forelse($tenants as $tenant)
                            <div class="flex items-center gap-3 p-3 bg-[#1f2937] rounded-xl border border-gray-800/50">
                                <input type="checkbox" wire:model.live="selectedTenants" value="{{ $tenant['id'] }}" class="w-4 h-4 rounded border-gray-600 bg-gray-700 text-[#0d9488] focus:ring-[#0d9488]">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold text-white" style="background-color: {{ $tenant['avatar_color'] }};">
                                    {{ $tenant['initials'] }}
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2">
                                        <h4 class="text-white font-medium text-sm">{{ $tenant['name'] }}</h4>
                                    </div>
                                    <p class="text-gray-400 text-xs">{{ $tenant['room'] }}</p>
                                </div>
                                @if($tenant['menunggak'])
                                    <span class="px-2 py-0.5 bg-red-500 text-white text-xs rounded-full">Menunggak</span>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <p class="text-gray-500 text-sm">Tidak ada penghuni aktif</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Footer Counter -->
                    <div class="mt-4 pt-4 border-t border-gray-800/50">
                        <p class="text-gray-400 text-sm">Terpilih: <span class="text-white font-medium">{{ count($selectedTenants) }}</span> penghuni</p>
                    </div>
                </div>

                <!-- Right Side - Message Composer -->
                <div class="flex-1 flex flex-col p-4">
                    <!-- Template Dropdown -->
                    <div class="mb-4">
                        <select wire:model="broadcastTemplate" wire:change="loadTemplateToBroadcast" class="w-full bg-[#0f172a] border border-gray-700 rounded-xl px-4 py-3 text-gray-400 text-sm focus:outline-none focus:border-[#0d9488] cursor-pointer">
                            <option value="">Pilih templat...</option>
                            @foreach($templates as $t)
                                <option value="{{ $t['id'] }}">{{ $t['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Message Textarea -->
                    <div class="flex-1 mb-4">
                        <textarea wire:model="broadcastMessage" placeholder="Tulis pesan broadcast..." class="w-full h-full bg-[#0f172a] border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#0d9488] resize-none"></textarea>
                    </div>

                    <!-- Footer -->
                    <div class="space-y-3">
                        <p class="text-gray-500 text-sm">{{ count($selectedTenants) }} penerima</p>
                        <button wire:click="sendBroadcast" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-[#22c55e] hover:bg-[#16a34a] text-white text-sm font-medium rounded-xl transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                            Kirim ke {{ count($selectedTenants) }} Penghuni
                        </button>
                    </div>
                </div>
            </div>
        @elseif($activeTab === 'otomatis')
            <!-- Tab Otomatis - Automatic Reminder Settings -->
            <div class="flex h-full p-6 gap-6 overflow-y-auto">
                <!-- Left Side - Jadwal Peringat -->
                <div class="flex-1 bg-[#1f2937] border border-gray-800/50 rounded-2xl p-5">
                    <div class="flex items-center gap-2 mb-5">
                        <svg class="w-5 h-5 text-[#0d9488]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                        <h3 class="text-white font-semibold">Jadwal Peringatan</h3>
                    </div>

                    <div class="space-y-3">
                        @php
                            $reminders = [
                                ['id' => 'h7', 'label' => 'H-7', 'desc' => '7 hari sebelum jatuh tempo', 'icon' => 'calendar', 'icon_color' => '#3b82f6'],
                                ['id' => 'h3', 'label' => 'H-3', 'desc' => '3 hari sebelum jatuh tempo', 'icon' => 'clock', 'icon_color' => '#0d9488'],
                                ['id' => 'h1', 'label' => 'H-1', 'desc' => '1 hari sebelum jatuh tempo', 'icon' => 'alert', 'icon_color' => '#f59e0b'],
                                ['id' => 'hplus1', 'label' => 'H+1', 'desc' => '1 hari setelah jatuh tempo', 'icon' => 'bell', 'icon_color' => '#ef4444'],
                                ['id' => 'hplus3', 'label' => 'H+3', 'desc' => '3 hari tunggakan + denda', 'icon' => 'money', 'icon_color' => '#22c55e'],
                                ['id' => 'hplus7', 'label' => 'H+7', 'desc' => '7 hari tunggakan, peringatan keras', 'icon' => 'warning', 'icon_color' => '#8b5cf6'],
                            ];
                        @endphp
                        @foreach($reminders as $r)
                            <div class="flex items-center justify-between p-3 bg-[#0f172a] rounded-xl border border-gray-800/30">
                                <div class="flex items-center gap-3">
                                    @if($r['icon'] === 'calendar')
                                        <svg class="w-5 h-5" style="color: {{ $r['icon_color'] }};" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/></svg>
                                    @elseif($r['icon'] === 'clock')
                                        <svg class="w-5 h-5" style="color: {{ $r['icon_color'] }};" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                                    @elseif($r['icon'] === 'alert')
                                        <svg class="w-5 h-5" style="color: {{ $r['icon_color'] }};" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    @elseif($r['icon'] === 'bell')
                                        <svg class="w-5 h-5" style="color: {{ $r['icon_color'] }};" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/></svg>
                                    @elseif($r['icon'] === 'money')
                                        <svg class="w-5 h-5" style="color: {{ $r['icon_color'] }};" fill="currentColor" viewBox="0 0 20 20"><path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v1.698c.22-.071.412-.164.567-.267.364-.243.433-.468.433-.582 0-.114-.07-.34-.433-.582a2.305 2.305 0 00-.567-.267z"/><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/></svg>
                                    @else
                                        <svg class="w-5 h-5" style="color: {{ $r['icon_color'] }};" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                    @endif
                                    <div>
                                        <span class="text-white font-medium">{{ $r['label'] }}</span>
                                        <p class="text-gray-400 text-xs">{{ $r['desc'] }}</p>
                                    </div>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:model="reminderSettings.{{ $r['id'] }}" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#22c55e]"></div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Right Side - Pengaturan -->
                <div class="w-[380px] space-y-4">
                    <!-- Settings Card -->
                    <div class="bg-[#1f2937] border border-gray-800/50 rounded-2xl p-5">
                        <div class="flex items-center gap-2 mb-5">
                            <svg class="w-5 h-5 text-[#0d9488]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <h3 class="text-white font-semibold">Pengaturan</h3>
                        </div>

                        <div class="space-y-4">
                            <!-- Jam Kirim -->
                            <div>
                                <label class="text-gray-400 text-sm mb-2 block">Jam Kirim Otomatis</label>
                                <div class="relative">
                                    <input type="text" wire:model="autoSendTime" class="w-full bg-[#0f172a] border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#0d9488]">
                                    <svg class="w-4 h-4 text-gray-500 absolute right-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                            </div>

                            <!-- Template H-7 -->
                            <div>
                                <label class="text-gray-400 text-sm mb-2 block">Template H-7</label>
                                <select class="w-full bg-[#0f172a] border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#0d9488]">
                                    <option>Peringatan Tagihan H-7</option>
                                </select>
                            </div>

                            <!-- Template Jatuh Tempo -->
                            <div>
                                <label class="text-gray-400 text-sm mb-2 block">Template Jatuh Tempo</label>
                                <select class="w-full bg-[#0f172a] border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#0d9488]">
                                    <option>Tagihan Jatuh Tempo Hari Ini</option>
                                </select>
                            </div>

                            <!-- Template Tunggakan -->
                            <div>
                                <label class="text-gray-400 text-sm mb-2 block">Template Tunggakan</label>
                                <select class="w-full bg-[#0f172a] border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#0d9488]">
                                    <option>Tunggakan & Denda</option>
                                </select>
                            </div>
                        </div>

                        <!-- Save Button -->
                        <button wire:click="saveReminderSettings" class="w-full mt-5 py-3 bg-gradient-to-r from-[#0d9488] to-[#059669] hover:from-[#0f766e] hover:to-[#047857] text-white font-medium rounded-xl transition-all">
                            Simpan Pengaturan
                        </button>
                    </div>

                    <!-- Statistics Card -->
                    <div class="bg-[#1f2937] border border-gray-800/50 rounded-2xl p-5">
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-5 h-5 text-[#0d9488]" fill="currentColor" viewBox="0 0 20 20"><path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zm6-4a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zm6-3a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/></svg>
                            <h3 class="text-white font-semibold">Statistik Hari Ini</h3>
                        </div>

                        <div class="grid grid-cols-3 gap-4">
                            <div class="text-center">
                                <p class="text-2xl font-bold text-[#0d9488]">12</p>
                                <p class="text-gray-400 text-xs">Terkirim</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-bold text-white">5</p>
                                <p class="text-gray-400 text-xs">Dijadwalkan</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-bold text-red-500">0</p>
                                <p class="text-gray-400 text-xs">Gagal</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($activeTab === 'pengaturan')
            <!-- Tab Pengaturan - WhatsApp API Settings -->
            <div class="p-6 overflow-y-auto h-full">
                <!-- Status Koneksi -->
                <div class="bg-[#1f2937] border border-gray-800/50 rounded-2xl p-5 mb-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 {{ $isConfigured ? 'bg-green-500/20' : 'bg-gray-800' }} rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 {{ $isConfigured ? 'text-green-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/></svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <h3 class="text-white font-semibold">Status Koneksi WhatsApp</h3>
                                <span class="px-2 py-0.5 {{ $isConfigured ? 'bg-green-500/20 text-green-500' : 'bg-gray-700 text-gray-300' }} text-xs rounded-full">{{ $isConfigured ? 'Terkoneksi' : 'Belum Diatur' }}</span>
                            </div>
                            <p class="text-gray-400 text-sm">{{ $isConfigured ? 'API WhatsApp aktif dan siap digunakan' : 'Konfigurasi API WhatsApp Anda untuk mulai mengirim pesan otomatis' }}</p>
                        </div>
                    </div>
                </div>

                <div class="flex gap-6">
                    <!-- Left Side - Konfigurasi API -->
                    <div class="flex-1 bg-[#1f2937] border border-gray-800/50 rounded-2xl p-5">
                        <div class="flex items-center gap-2 mb-5">
                            <svg class="w-5 h-5 text-[#0d9488]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <h3 class="text-white font-semibold">Konfigurasi API</h3>
                        </div>

                        <!-- Provider WhatsApp -->
                        <div class="mb-5">
                            <label class="text-gray-400 text-sm mb-2 block">Provider WhatsApp</label>
                            <div class="relative">
                                <select wire:model="apiProvider" class="w-full bg-[#0f172a] border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#0d9488] appearance-none">
                                    <option value="fonnte">Fonnte</option>
                                    <option value="wablas">Wablas</option>
                                </select>
                                <svg class="w-4 h-4 text-gray-500 absolute right-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>

                        <!-- API Token -->
                        <div class="mb-5">
                            <label class="text-gray-400 text-sm mb-2 block">API Token / Key</label>
                            <div class="relative">
                                <input type="password" wire:model="apiToken" placeholder="Masukkan token dari dashboard Fonnte" class="w-full bg-[#0f172a] border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#0d9488]">
                                <svg class="w-4 h-4 text-gray-500 absolute right-3 top-1/2 -translate-y-1/2 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </div>
                            <p class="text-gray-500 text-xs mt-2">Dapatkan token di <span class="text-gray-400">fonnte.com</span> → <span class="text-gray-400">Dashboard</span> → <span class="text-gray-400">API Token</span></p>
                        </div>

                        <!-- Nomor Pengirim -->
                        <div class="mb-5">
                            <label class="text-gray-400 text-sm mb-2 block">Nomor Pengirim</label>
                            <input type="text" wire:model="senderNumber" placeholder="081234567890" class="w-full bg-[#0f172a] border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:border-[#0d9488]">
                            <p class="text-gray-500 text-xs mt-2">Nomor WhatsApp yang terdaftar di Fonnte</p>
                        </div>

                        <!-- Tes Koneksi -->
                        <div wire:click="testConnection" class="flex items-center justify-between p-3 bg-[#0f172a] rounded-xl border border-gray-800/30 mb-4 cursor-pointer hover:bg-gray-800/50 transition-colors">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#0d9488]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/></svg>
                                <div>
                                    <p class="text-white text-sm font-medium">Tes Koneksi</p>
                                    <p class="text-gray-500 text-xs">Verifikasi token dan koneksi device</p>
                                </div>
                            </div>
                        </div>

                        <!-- Save Button -->
                        <button wire:click="saveApiSettings" class="w-full py-3 bg-gradient-to-r from-[#22c55e] to-[#16a34a] hover:from-[#16a34a] hover:to-[#15803d] text-white font-medium rounded-xl transition-all flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            Simpan Pengaturan API
                        </button>
                    </div>

                    <!-- Right Side - Panduan & Info -->
                    <div class="w-[420px] space-y-4">
                        <!-- Panduan Fonnte -->
                        <div class="bg-[#1f2937] border border-gray-800/50 rounded-2xl p-5">
                            <div class="flex items-center gap-2 mb-4">
                                <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/></svg>
                                <h3 class="text-white font-semibold">Panduan Fonnte</h3>
                            </div>
                            <ol class="space-y-2 text-sm text-gray-400">
                                <li>1. Daftar akun di <a href="https://fonnte.com" class="text-white hover:underline">fonnte.com</a></li>
                                <li>2. Tambahkan device dan scan QR Code WhatsApp</li>
                                <li>3. Salin <span class="text-[#0d9488]">API Token</span> dari halaman dashboard</li>
                                <li>4. Tempel token di kolom API Token di samping</li>
                                <li>5. Isi nomor pengirim, lalu klik <span class="text-[#0d9488]">Tes Koneksi</span></li>
                                <li>6. Jika berhasil, klik <span class="text-[#22c55e]">Simpan Pengaturan API</span></li>
                            </ol>
                        </div>

                        <!-- Tentang Integrasi WA -->
                        <div class="bg-[#1f2937] border border-gray-800/50 rounded-2xl p-5">
                            <div class="flex items-center gap-2 mb-4">
                                <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zm-1 4a1 1 0 00-1 1v3a1 1 0 102 0V11a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                <h3 class="text-white font-semibold">Tentang Integrasi WA</h3>
                            </div>
                            <p class="text-gray-400 text-sm mb-4">Setiap tenant mengatur koneksi WhatsApp API sendiri. Pilih salah satu provider:</p>
                            
                            <div class="grid grid-cols-2 gap-3 mb-3">
                                <div>
                                    <p class="text-white font-medium text-sm mb-2">Fonnte</p>
                                    <ul class="text-gray-500 text-xs space-y-1">
                                        <li>• Mudah digunakan</li>
                                        <li>• Harga terjangkau</li>
                                        <li>• Support bahasa Indonesia</li>
                                    </ul>
                                </div>
                                <div>
                                    <p class="text-white font-medium text-sm mb-2">Wablas</p>
                                    <ul class="text-gray-500 text-xs space-y-1">
                                        <li>• Fitur lengkap</li>
                                        <li>• API stabil</li>
                                        <li>• Dashboard detail</li>
                                    </ul>
                                </div>
                            </div>
                            
                            <div class="flex items-start gap-2 p-3 bg-yellow-500/10 rounded-xl border border-yellow-500/20">
                                <svg class="w-4 h-4 text-yellow-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                <p class="text-yellow-500/80 text-xs">Pastikan nomor WhatsApp yang didaftarkan aktif dan terhubung di provider.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Other Tabs Placeholder -->
            <div class="flex items-center justify-center h-full">
                <p class="text-gray-400">Fitur ini akan segera hadir</p>
            </div>
        @endif
    </div>
</div>
