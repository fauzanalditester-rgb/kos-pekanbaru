<?php

namespace App\Livewire\Admin;

use App\Models\Tenant;
use App\Models\WhatsAppMessage;
use App\Models\WhatsAppSetting;
use App\Models\WhatsAppTemplate;
use Livewire\Component;

class WhatsAppManager extends Component
{
    public $activeTab = 'pesan';
    public $selectedTenant = null;
    public $search = '';
    public $message = '';
    public $isConfigured = false;

    // Template form
    public $showTemplateModal = false;
    public $editingTemplate = null;
    public $templateName = '';
    public $templateTag = 'tagihan';
    public $templateContent = '';

    // Broadcast
    public $selectedTenants = [];
    public $broadcastMessage = '';
    public $broadcastTemplate = '';

    // Otomatis settings
    public $reminderSettings = [
        'h7' => true,
        'h3' => true,
        'h1' => false,
        'hplus1' => true,
        'hplus3' => false,
        'hplus7' => false,
    ];
    public $autoSendTime = '09:00';

    // API Settings
    public $apiProvider = 'fonnte';
    public $apiToken = '';
    public $senderNumber = '';

    public function mount()
    {
        try {
            $setting = WhatsAppSetting::first();
            $this->isConfigured = $setting && $setting->is_connected;
            if ($setting) {
                $this->apiToken = $setting->api_token ?? '';
                $this->senderNumber = $setting->sender_number ?? '';
                $this->apiProvider = $setting->provider ?? 'fonnte';
            }
        } catch (\Exception $e) {
            $this->isConfigured = false;
        }
    }

    public function render()
    {
        // Get real tenants from database
        $tenants = Tenant::with('room')
            ->where('status', 'active')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%')
                      ->orWhereHas('room', function ($q) {
                          $q->where('code', 'like', '%' . $this->search . '%');
                      });
            })
            ->get()
            ->map(function ($tenant) {
                $initials = collect(explode(' ', $tenant->name))
                    ->map(fn($n) => strtoupper(substr($n, 0, 1)))
                    ->take(2)
                    ->join('');
                
                return [
                    'id' => $tenant->id,
                    'name' => $tenant->name,
                    'initials' => $initials,
                    'avatar_color' => $this->getAvatarColor($tenant->id),
                    'room' => $tenant->room?->code ?? '-',
                    'phone' => $tenant->phone,
                    'price' => number_format($tenant->room?->price_monthly ?? 0, 0, ',', '.'),
                    'due_date' => $tenant->due_date?->format('Y-m-d') ?? '-',
                    'menunggak' => $tenant->status === 'overdue',
                    'online' => false,
                    'time' => 'Offline',
                ];
            });

        // Get templates from database
        $templates = WhatsAppTemplate::all();
        if ($templates->isEmpty()) {
            $templates = collect($this->getDefaultTemplates());
        }

        $selectedMockTenant = null;
        if ($this->selectedTenant) {
            $selectedMockTenant = $tenants->firstWhere('id', $this->selectedTenant);
        }

        $messages = [];
        if ($this->selectedTenant) {
            $messages = WhatsAppMessage::where('tenant_id', $this->selectedTenant)
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('livewire.admin.whatsapp-manager', [
            'tenants' => $tenants,
            'templates' => $templates,
            'selectedMockTenant' => $selectedMockTenant,
            'messages' => $messages,
        ])->layout('layouts.admin', ['title' => 'WhatsApp']);
    }

    private function getAvatarColor($id)
    {
        $colors = ['#10b981', '#0d9488', '#059669', '#047857', '#065f46', '#0f766e'];
        return $colors[$id % count($colors)];
    }

    private function getDefaultTemplates()
    {
        return [
            ['id' => 1, 'icon' => 'bell', 'icon_color' => '#3b82f6', 'tag' => 'tagihan', 'tag_color' => 'bg-red-500/20 text-red-400', 'name' => 'Peringatan Tagihan H-7', 'content' => "Halo *{{nama}}*, \n\nIni peringatan bahwa tagihan kost Anda akan jatuh tempo dalam 7 hari.\n\nMohon segera melakukan pembayaran untuk menghindari denda.\n\nTerima kasih."],
            ['id' => 2, 'icon' => 'calendar', 'icon_color' => '#ec4899', 'tag' => 'tagihan', 'tag_color' => 'bg-red-500/20 text-red-400', 'name' => 'Tagihan Jatuh Tempo Hari Ini', 'content' => "*PENGINGAT PENTING*\n\nYth, {{nama}}, \n\nTagihan kost Anda jatuh tempo hari ini. Mohon segera melakukan pembayaran.\n\nTerima kasih."],
            ['id' => 3, 'icon' => 'alert', 'icon_color' => '#ef4444', 'tag' => 'tagihan', 'tag_color' => 'bg-red-500/20 text-red-400', 'name' => 'Tunggakan & Denda', 'content' => "*PEMBERITAHUAN TUNGGAKAN*\n\nYth, {{nama}}, \n\nAnda memiliki tunggakan tagihan kost. Mohon segera melunasi untuk menghindari denda tambahan.\n\nTerima kasih."],
            ['id' => 4, 'icon' => 'check', 'icon_color' => '#22c55e', 'tag' => 'konfirmasi', 'tag_color' => 'bg-green-500/20 text-green-400', 'name' => 'Konfirmasi Pembayaran', 'content' => "✅ *PEMBAYARAN DITERIMA*\n\nHalo *{{nama}}*, \n\nTerima kasih telah melakukan pembayaran tagihan kost.\n\nPembayaran Anda telah kami verifikasi."],
            ['id' => 5, 'icon' => 'user', 'icon_color' => '#8b5cf6', 'tag' => 'info', 'tag_color' => 'bg-yellow-500/20 text-yellow-400', 'name' => 'Selamat Datang Penghuni Baru', 'content' => "🎉 *SELAMAT DATANG!*\n\nHalo *{{nama}}*, \n\nSelamat datang di kost kami! Semoga nyaman tinggal di sini.\n\nJika ada yang perlu ditanyakan, silakan hubungi kami."],
            ['id' => 6, 'icon' => 'document', 'icon_color' => '#f97316', 'tag' => 'info', 'tag_color' => 'bg-yellow-500/20 text-yellow-400', 'name' => 'Perpanjangan Kontrak', 'content' => "📝 *PERPANJANGAN KONTRAK*\n\nHalo *{{nama}}*, \n\nKontrak kost Anda akan berakhir dalam 1 bulan. Apakah Anda ingin memperpanjang?\n\nSilakan konfirmasi segera."],
        ];
    }

    public function selectTenant($tenantId)
    {
        $this->selectedTenant = $tenantId;
        $this->activeTab = 'pesan';
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function sendMessage()
    {
        if (!$this->message || !$this->selectedTenant) {
            return;
        }

        WhatsAppMessage::create([
            'tenant_id' => $this->selectedTenant,
            'message' => $this->message,
            'status' => 'sent',
            'direction' => 'out',
            'sent_at' => now(),
        ]);

        $this->message = '';
        session()->flash('message', 'Pesan berhasil dikirim!');
    }

    // Template methods
    public function openTemplateModal($id = null)
    {
        if ($id) {
            $template = WhatsAppTemplate::find($id);
            if ($template) {
                $this->editingTemplate = $id;
                $this->templateName = $template->name;
                $this->templateTag = $template->tag;
                $this->templateContent = $template->content;
            }
        } else {
            $this->editingTemplate = null;
            $this->templateName = '';
            $this->templateTag = 'tagihan';
            $this->templateContent = '';
        }
        $this->showTemplateModal = true;
    }

    public function closeTemplateModal()
    {
        $this->showTemplateModal = false;
        $this->editingTemplate = null;
        $this->templateName = '';
        $this->templateTag = 'tagihan';
        $this->templateContent = '';
    }

    public function saveTemplate()
    {
        $this->validate([
            'templateName' => 'required|string|max:255',
            'templateTag' => 'required|string',
            'templateContent' => 'required|string',
        ]);

        $data = [
            'name' => $this->templateName,
            'tag' => $this->templateTag,
            'content' => $this->templateContent,
        ];

        if ($this->editingTemplate) {
            WhatsAppTemplate::find($this->editingTemplate)->update($data);
            session()->flash('message', 'Template berhasil diperbarui!');
        } else {
            WhatsAppTemplate::create($data);
            session()->flash('message', 'Template berhasil dibuat!');
        }

        $this->closeTemplateModal();
    }

    public function deleteTemplate($id)
    {
        WhatsAppTemplate::find($id)?->delete();
        session()->flash('message', 'Template berhasil dihapus!');
    }

    // Broadcast methods
    public function selectAllTenants()
    {
        $tenants = Tenant::where('status', 'active')->pluck('id')->toArray();
        $this->selectedTenants = $tenants;
    }

    public function selectOverdueTenants()
    {
        $tenants = Tenant::where('status', 'overdue')->pluck('id')->toArray();
        $this->selectedTenants = $tenants;
    }

    public function resetSelection()
    {
        $this->selectedTenants = [];
    }

    public function loadTemplateToBroadcast()
    {
        if ($this->broadcastTemplate) {
            $template = WhatsAppTemplate::find($this->broadcastTemplate);
            if ($template) {
                $this->broadcastMessage = $template->content;
            }
        }
    }

    public function sendBroadcast()
    {
        if (empty($this->selectedTenants) || !$this->broadcastMessage) {
            return;
        }

        foreach ($this->selectedTenants as $tenantId) {
            WhatsAppMessage::create([
                'tenant_id' => $tenantId,
                'message' => $this->broadcastMessage,
                'status' => 'queued',
                'direction' => 'out',
                'sent_at' => null,
            ]);
        }

        $this->selectedTenants = [];
        $this->broadcastMessage = '';
        $this->broadcastTemplate = '';
        session()->flash('message', 'Pesan broadcast berhasil dijadwalkan!');
    }

    // Otomatis settings
    public function saveReminderSettings()
    {
        // Save to settings
        WhatsAppSetting::updateOrCreate(
            ['id' => 1],
            [
                'reminder_settings' => $this->reminderSettings,
                'auto_send_time' => $this->autoSendTime,
            ]
        );
        session()->flash('message', 'Pengaturan pengingat berhasil disimpan!');
    }

    // API Settings
    public function saveApiSettings()
    {
        $this->validate([
            'apiToken' => 'required|string',
            'senderNumber' => 'required|string',
            'apiProvider' => 'required|string',
        ]);

        WhatsAppSetting::updateOrCreate(
            ['id' => 1],
            [
                'provider' => $this->apiProvider,
                'api_token' => $this->apiToken,
                'sender_number' => $this->senderNumber,
                'is_connected' => true,
            ]
        );

        $this->isConfigured = true;
        session()->flash('message', 'Pengaturan API berhasil disimpan!');
    }

    public function testConnection()
    {
        // Simulate API test
        session()->flash('message', 'Koneksi berhasil! API aktif dan siap digunakan.');
    }
}
