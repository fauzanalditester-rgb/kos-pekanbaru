<?php

namespace App\Livewire\SuperAdmin;

use App\Livewire\Admin\RoomManager as BaseRoomManager;

class RoomManager extends BaseRoomManager
{
    public function render()
    {
        return parent::render()->layout('layouts.super-admin', ['title' => 'Manajemen Kamar']);
    }
}
