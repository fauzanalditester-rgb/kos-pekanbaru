<?php

namespace App\Livewire\SuperAdmin;

use App\Livewire\Admin\UserManager as BaseUserManager;

class UserManager extends BaseUserManager
{
    public function render()
    {
        return parent::render()->layout('layouts.super-admin', ['title' => 'Manajemen User']);
    }
}
