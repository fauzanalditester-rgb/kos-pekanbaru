<?php

namespace App\Livewire\Customer;

use App\Models\Invoice;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Kamar extends Component
{
    public function render()
    {
        $user = Auth::user();
        $tenant = $user->tenant;

        if (!$tenant || !$tenant->room) {
            return view('livewire.customer.kamar', [
                'room' => null,
                'property' => null,
                'tenant' => null,
                'invoices' => collect(),
            ])->layout('layouts.customer', ['title' => 'Info Kamar']);
        }

        $room = $tenant->room;
        $property = $room->property;

        $invoices = Invoice::where('tenant_id', $tenant->id)
            ->where('status', '!=', 'paid')
            ->orderBy('due_date', 'asc')
            ->get();

        return view('livewire.customer.kamar', [
            'room' => $room,
            'property' => $property,
            'tenant' => $tenant,
            'invoices' => $invoices,
        ])->layout('layouts.customer', ['title' => 'Info Kamar']);
    }
}
