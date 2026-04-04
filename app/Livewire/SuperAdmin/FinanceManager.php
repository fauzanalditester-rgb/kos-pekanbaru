<?php

namespace App\Livewire\SuperAdmin;

use App\Livewire\Admin\FinanceManager as BaseFinanceManager;

class FinanceManager extends BaseFinanceManager
{
    public function render()
    {
        return parent::render()->layout('layouts.super-admin', ['title' => 'Laporan Keuangan']);
    }
}
