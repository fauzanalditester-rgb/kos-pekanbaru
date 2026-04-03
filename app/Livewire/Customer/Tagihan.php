<?php

namespace App\Livewire\Customer;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Notification;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class Tagihan extends Component
{
    use WithFileUploads;

    public $showPaymentModal = false;
    public $selectedInvoice = null;
    public $paymentAmount = '';
    public $paymentMethod = 'transfer';
    public $paymentProof = null;
    public $filterStatus = '';

    protected $rules = [
        'paymentAmount' => 'required|numeric|min:1',
        'paymentMethod' => 'required|in:transfer,cash,qris',
        'paymentProof' => 'nullable|image|max:2048',
    ];

    public function render()
    {
        $user = Auth::user();
        $tenant = $user->tenant;

        if (!$tenant) {
            return view('livewire.customer.tagihan', [
                'invoices' => collect(),
                'stats' => [
                    'total' => 0,
                    'paid' => 0,
                    'pending' => 0,
                    'overdue' => 0,
                ],
            ])->layout('layouts.customer', ['title' => 'Tagihan Saya']);
        }

        $invoices = Invoice::where('tenant_id', $tenant->id)
            ->with('room')
            ->when($this->filterStatus, function ($query) {
                $query->where('status', $this->filterStatus);
            })
            ->orderBy('issue_date', 'desc')
            ->get();

        $stats = [
            'total' => $invoices->count(),
            'paid' => $invoices->where('status', 'paid')->count(),
            'pending' => $invoices->where('status', 'sent')->count(),
            'overdue' => $invoices->where('status', 'overdue')->count(),
        ];

        return view('livewire.customer.tagihan', [
            'invoices' => $invoices,
            'stats' => $stats,
        ])->layout('layouts.customer', ['title' => 'Tagihan Saya']);
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
        $this->resetValidation();
    }

    public function submitPayment()
    {
        $this->validate();

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

        $payment = Payment::create([
            'tenant_id' => $tenant->id,
            'invoice_id' => $this->selectedInvoice,
            'amount' => $this->paymentAmount,
            'payment_method' => $this->paymentMethod,
            'payment_date' => now(),
            'proof_image' => $proofPath,
            'status' => 'pending',
            'notes' => 'Pembayaran dari customer portal',
        ]);

        // NOTIFY ALL ADMINS ABOUT NEW PAYMENT
        Notification::notifyAdmins(
            Notification::TYPE_PAYMENT_PENDING,
            'Pembayaran Baru - Menunggu Verifikasi',
            $tenant->name . ' telah mengajukan pembayaran sebesar Rp ' . number_format($this->paymentAmount, 0, ',', '.'),
            [
                'payment_id' => $payment->id,
                'tenant_name' => $tenant->name,
                'amount' => $this->paymentAmount,
                'invoice_id' => $this->selectedInvoice,
            ],
            '/admin/pembayaran'
        );

        $this->closePaymentModal();
        session()->flash('message', 'Pembayaran berhasil diajukan! Menunggu verifikasi admin.');
    }

    public function setFilter($status)
    {
        $this->filterStatus = $status;
    }
}
