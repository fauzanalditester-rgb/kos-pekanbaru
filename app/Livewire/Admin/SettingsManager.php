<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class SettingsManager extends Component
{
    public $brandName = 'Kost Harmoni Group';
    public $email = 'admin@harmonigroup.com';
    public $whatsapp = '081234567890';
    public $bankAccount = 'BCA 1234567890 a.n. Harmoni Group';
    public $billingDate = '1';
    public $penaltyType = 'flat';
    public $penaltyAmount = '50000';

    public function save()
    {
        session()->flash('message', 'Pengaturan berhasil disimpan!');
    }

    public function render()
    {
        return view('livewire.admin.settings-manager')
            ->layout('layouts.admin', ['title' => 'Pengaturan']);
    }
}
