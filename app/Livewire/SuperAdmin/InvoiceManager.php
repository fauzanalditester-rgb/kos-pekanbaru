<?php

namespace App\Livewire\SuperAdmin;

use App\Livewire\Admin\InvoiceManager as BaseInvoiceManager;

class InvoiceManager extends BaseInvoiceManager
{
    public function render()
    {
        return parent::render()->layout('layouts.super-admin', ['title' => 'Manajemen Tagihan']);
    }
}
