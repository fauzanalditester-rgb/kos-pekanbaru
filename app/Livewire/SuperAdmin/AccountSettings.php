<?php

namespace App\Livewire\SuperAdmin;

use App\Livewire\Admin\AccountSettings as BaseAccountSettings;

class AccountSettings extends BaseAccountSettings
{
    public function render()
    {
        return view('livewire.super-admin.account-settings');
    }
}
