<?php

namespace App\Livewire\SuperAdmin;

use App\Livewire\Admin\TenantManager as BaseTenantManager;

class TenantManager extends BaseTenantManager
{
    public function render()
    {
        return parent::render()->layout('layouts.super-admin', ['title' => 'Manajemen Penyewa']);
    }
}
