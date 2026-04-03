<?php

namespace App\Livewire\Customer;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Tenant;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public $activeTab = 'overview';
    public $showPaymentModal = false;
    public $selectedInvoice = null;
    public $paymentAmount = '';
    public $paymentMethod = 'transfer';
    public $paymentProof = null;

    public function mount()
    {
        // Ensure only customers can access
        if (!Auth::user()->isCustomer()) {
            return redirect()->route('admin.dashboard');
        }
    }

    public function render()
    {
        $user = Auth::user();
        $tenant = $user->tenant;

        if (!$tenant) {
            return view('livewire.customer.dashboard', [
                'tenant' => null,
                'invoices' => collect(),
                'payments' => collect(),
                'room' => null,
                'stats' => [
                    'total_paid' => 0,
                    'total_pending' => 0,
                    'overdue_count' => 0,
                ],
            ])->layout('layouts.customer', ['title' => 'Dashboard Customer']);
        }

        $invoices = Invoice::where('tenant_id', $tenant->id)
            ->with('room')
            ->orderBy('issue_date', 'desc')
            ->get();

        $payments = Payment::where('tenant_id', $tenant->id)
            ->with('invoice')
            ->orderBy('payment_date', 'desc')
            ->get();

        $room = $tenant->room;

        $stats = [
            'total_paid' => $payments->where('status', 'verified')->sum('amount'),
            'total_pending' => $invoices->where('status', 'sent')->sum('total_amount'),
            'overdue_count' => $invoices->where('status', 'overdue')->count(),
        ];

        return view('livewire.customer.dashboard', [
            'tenant' => $tenant,
            'invoices' => $invoices,
            'payments' => $payments,
            'room' => $room,
            'stats' => $stats,
        ])->layout('layouts.customer', ['title' => 'Dashboard Customer']);
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function openPaymentModal($invoiceId)
    {
        $this->selectedInvoice = $invoiceId;
        $invoice = Invoice::find($invoiceId);
        if ($invoice) {
            $this->paymentAmount = $invoice->total_amount;
        }
        $this->showPaymentModal = true;
    }

    public function closePaymentModal()
    {
        $this->showPaymentModal = false;
        $this->selectedInvoice = null;
        $this->paymentAmount = '';
        $this->paymentMethod = 'transfer';
        $this->paymentProof = null;
    }

    public function submitPayment()
    {
        $this->validate([
            'paymentAmount' => 'required|numeric|min:1',
            'paymentMethod' => 'required|in:transfer,cash,qris',
            'paymentProof' => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();
        $tenant = $user->tenant;

        if (!$tenant) {
            session()->flash('error', 'Data penyewa tidak ditemukan.');
            return;
        }

        $proofPath = null;
        if ($this->paymentProof) {
            $proofPath = $this->paymentProof->store('payments', 'public');
        }

        Payment::create([
            'tenant_id' => $tenant->id,
            'invoice_id' => $this->selectedInvoice,
            'amount' => $this->paymentAmount,
            'payment_method' => $this->paymentMethod,
            'payment_date' => now(),
            'proof_image' => $proofPath,
            'status' => 'pending',
            'notes' => 'Pembayaran dari customer portal',
        ]);

        $this->closePaymentModal();
        session()->flash('message', 'Pembayaran berhasil diajukan! Menunggu verifikasi admin.');
    }
}
