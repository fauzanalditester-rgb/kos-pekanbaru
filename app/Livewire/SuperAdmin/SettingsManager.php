<?php

namespace App\Livewire\SuperAdmin;

use App\Livewire\Admin\SettingsManager as BaseSettingsManager;

class SettingsManager extends BaseSettingsManager
{
    public function render()
    {
        return parent::render()->layout('layouts.super-admin', ['title' => 'Pengaturan']);
    }
}
