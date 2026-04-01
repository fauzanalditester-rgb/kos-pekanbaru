<?php

namespace App\Livewire\Admin;

use App\Models\Tenant;
use App\Models\WhatsAppMessage;
use App\Models\WhatsAppSetting;
use Livewire\Component;

class WhatsAppManager extends Component
{
    public $activeTab = 'pesan';
    public $selectedTenant = null;
    public $search = '';
    public $message = '';
    public $isConfigured = false;

    public function mount()
    {
        try {
            $setting = WhatsAppSetting::first();
            $this->isConfigured = $setting && $setting->is_connected;
        } catch (\Exception $e) {
            $this->isConfigured = false;
        }
    }

    public function render()
    {
        // Mock tenant data for display
        $mockTenants = [
            ['id' => 1, 'name' => 'Budi Santoso', 'initials' => 'BS', 'avatar_color' => '#10b981', 'room' => 'Kamar A1', 'time' => 'Baru saja', 'online' => true, 'menunggak' => false],
            ['id' => 2, 'name' => 'Siti Rahayu', 'initials' => 'SR', 'avatar_color' => '#0d9488', 'room' => 'Kamar B3', 'time' => '10 menit lalu', 'online' => true, 'menunggak' => false],
            ['id' => 3, 'name' => 'Andi Prasetyo', 'initials' => 'AP', 'avatar_color' => '#059669', 'room' => 'Kamar C2', 'time' => '2 jam lalu', 'online' => false, 'menunggak' => true],
            ['id' => 4, 'name' => 'Dewi Kusuma', 'initials' => 'DK', 'avatar_color' => '#047857', 'room' => 'Kamar A4', 'time' => '1 jam lalu', 'online' => false, 'menunggak' => false],
            ['id' => 5, 'name' => 'Reza Firmansyah', 'initials' => 'RF', 'avatar_color' => '#065f46', 'room' => 'Kamar D1', 'time' => '5 jam lalu', 'online' => false, 'menunggak' => true],
        ];

        // Find selected mock tenant
        $selectedMockTenant = null;
        foreach ($mockTenants as $tenant) {
            if ($tenant['id'] == $this->selectedTenant) {
                $selectedMockTenant = $tenant;
                break;
            }
        }

        $messages = [];
        if ($this->selectedTenant) {
            $messages = WhatsAppMessage::where('tenant_id', $this->selectedTenant)
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('livewire.admin.whatsapp-manager', [
            'mockTenants' => $mockTenants,
            'selectedMockTenant' => $selectedMockTenant,
            'messages' => $messages,
        ])->layout('layouts.admin', ['title' => 'WhatsApp']);
    }

    public function selectTenant($tenantId)
    {
        $this->selectedTenant = $tenantId;
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
}
