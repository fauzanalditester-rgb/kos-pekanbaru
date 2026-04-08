<?php

namespace App\Livewire\SuperAdmin;

use App\Livewire\Admin\ChangeEmail as BaseChangeEmail;

class ChangeEmail extends BaseChangeEmail
{
    public function render()
    {
        return view('livewire.super-admin.change-email');
    }
}
