<?php

namespace App\Livewire\SuperAdmin;

use App\Livewire\Admin\PropertyManager as BasePropertyManager;

class PropertyManager extends BasePropertyManager
{
    public function render()
    {
        return parent::render()->layout('layouts.super-admin', ['title' => 'Manajemen Properti']);
    }
}
