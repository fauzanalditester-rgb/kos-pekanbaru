<?php

namespace App\Livewire\SuperAdmin;

use App\Livewire\Admin\PaymentManager as BasePaymentManager;

class PaymentManager extends BasePaymentManager
{
    public function render()
    {
        return parent::render()->layout('layouts.super-admin', ['title' => 'Manajemen Pembayaran']);
    }
}
