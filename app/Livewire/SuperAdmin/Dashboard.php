<?php

namespace App\Livewire\SuperAdmin;

use App\Models\User;
use App\Models\Tenant;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Finance;
use Livewire\Component;
use Carbon\Carbon;

class Dashboard extends Component
{
    public function render()
    {
        // Statistics
        $totalUsers = User::count();
        $totalCustomers = User::where('role', 'customer')->count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalSuperAdmins = User::where('role', 'super_admin')->count();
        
        $totalTenants = Tenant::count();
        $activeTenants = Tenant::where('status', 'active')->count();
        
        $totalInvoices = Invoice::count();
        $paidInvoices = Invoice::where('status', 'paid')->count();
        $pendingInvoices = Invoice::where('status', 'sent')->count();
        $overdueInvoices = Invoice::where('status', 'overdue')->count();
        
        $totalPayments = Payment::count();
        $verifiedPayments = Payment::where('status', 'verified')->count();
        $pendingPayments = Payment::where('status', 'pending')->count();
        
        // Financial Summary
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        
        $todayIncome = Finance::where('type', 'income')
            ->whereDate('transaction_date', $today)
            ->sum('amount');
        
        $monthIncome = Finance::where('type', 'income')
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->sum('amount');
        
        $totalIncome = Finance::where('type', 'income')->sum('amount');
        $totalExpense = Finance::where('type', 'expense')->sum('amount');
        $netProfit = $totalIncome - $totalExpense;
        
        // Recent Activity
        $recentUsers = User::latest()->take(5)->get();
        $recentTenants = Tenant::latest()->take(5)->get();
        $recentPayments = Payment::with('tenant')->latest()->take(5)->get();
        
        return view('livewire.super-admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalCustomers' => $totalCustomers,
            'totalAdmins' => $totalAdmins,
            'totalSuperAdmins' => $totalSuperAdmins,
            'totalTenants' => $totalTenants,
            'activeTenants' => $activeTenants,
            'totalInvoices' => $totalInvoices,
            'paidInvoices' => $paidInvoices,
            'pendingInvoices' => $pendingInvoices,
            'overdueInvoices' => $overdueInvoices,
            'totalPayments' => $totalPayments,
            'verifiedPayments' => $verifiedPayments,
            'pendingPayments' => $pendingPayments,
            'todayIncome' => $todayIncome,
            'monthIncome' => $monthIncome,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'netProfit' => $netProfit,
            'recentUsers' => $recentUsers,
            'recentTenants' => $recentTenants,
            'recentPayments' => $recentPayments,
        ])->layout('layouts.super-admin');
    }
}
