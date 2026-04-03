<?php

namespace App\Livewire\Customer;

use App\Models\Payment;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Pembayaran extends Component
{
    public function render()
    {
        $user = Auth::user();
        $tenant = $user->tenant;

        if (!$tenant) {
            return view('livewire.customer.pembayaran', [
                'payments' => collect(),
                'stats' => [
                    'total' => 0,
                    'verified' => 0,
                    'pending' => 0,
                    'total_amount' => 0,
                ],
            ])->layout('layouts.customer', ['title' => 'Riwayat Pembayaran']);
        }

        $payments = Payment::where('tenant_id', $tenant->id)
            ->with(['invoice', 'invoice.room'])
            ->orderBy('payment_date', 'desc')
            ->get();

        $stats = [
            'total' => $payments->count(),
            'verified' => $payments->where('status', 'verified')->count(),
            'pending' => $payments->where('status', 'pending')->count(),
            'total_amount' => $payments->where('status', 'verified')->sum('amount'),
        ];

        return view('livewire.customer.pembayaran', [
            'payments' => $payments,
            'stats' => $stats,
        ])->layout('layouts.customer', ['title' => 'Riwayat Pembayaran']);
    }

    public function getStatusColor($status)
    {
        return match($status) {
            'verified' => 'bg-[#0d9488]/20 text-[#0d9488]',
            'pending' => 'bg-yellow-500/20 text-yellow-400',
            'rejected' => 'bg-red-500/20 text-red-400',
            default => 'bg-gray-500/20 text-gray-400',
        };
    }

    public function getStatusLabel($status)
    {
        return match($status) {
            'verified' => 'Terverifikasi',
            'pending' => 'Menunggu',
            'rejected' => 'Ditolak',
            default => 'Unknown',
        };
    }
}
