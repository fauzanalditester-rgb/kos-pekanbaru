<?php

namespace App\Livewire\SuperAdmin;

use App\Livewire\Admin\ChangePassword as BaseChangePassword;

class ChangePassword extends BaseChangePassword
{
    public function render()
    {
        return view('livewire.super-admin.change-password');
    }
}
