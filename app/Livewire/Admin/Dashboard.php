<?php

namespace App\Livewire\Admin;

use App\Models\Finance;
use App\Models\Booking;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Room;
use App\Models\Tenant;
use Livewire\Component;
use Carbon\Carbon;

class Dashboard extends Component
{
    public function render()
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $startOfYear = Carbon::now()->startOfYear();

        // Finance Statistics
        $todayIncome = Finance::where('type', 'income')
            ->whereDate('transaction_date', $today)
            ->sum('amount');

        $monthIncome = Finance::where('type', 'income')
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $monthExpense = Finance::where('type', 'expense')
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $yearIncome = Finance::where('type', 'income')
            ->whereBetween('transaction_date', [$startOfYear, $endOfMonth])
            ->sum('amount');

        $yearExpense = Finance::where('type', 'expense')
            ->whereBetween('transaction_date', [$startOfYear, $endOfMonth])
            ->sum('amount');

        $totalIncome = Finance::where('type', 'income')->sum('amount');
        $totalExpense = Finance::where('type', 'expense')->sum('amount');
        $netProfit = $totalIncome - $totalExpense;

        // Invoice Statistics
        $totalInvoices = Invoice::count();
        $paidInvoices = Invoice::where('status', 'paid')->count();
        $unpaidInvoices = Invoice::whereIn('status', ['sent', 'overdue'])->count();
        $overdueInvoices = Invoice::where('status', 'overdue')
            ->orWhere(function($query) use ($today) {
                $query->where('status', 'sent')
                      ->where('due_date', '<', $today);
            })->count();
        $overdueAmount = Invoice::where('status', 'overdue')
            ->orWhere(function($query) use ($today) {
                $query->where('status', 'sent')
                      ->where('due_date', '<', $today);
            })->sum('total_amount');

        $monthInvoiceTotal = Invoice::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('total_amount');

        // Payment Statistics
        $todayPayments = Payment::whereDate('payment_date', $today)
            ->where('status', 'verified')
            ->count();
        $todayPaymentsAmount = Payment::whereDate('payment_date', $today)
            ->where('status', 'verified')
            ->sum('amount');

        $monthPayments = Payment::whereBetween('payment_date', [$startOfMonth, $endOfMonth])
            ->where('status', 'verified')
            ->sum('amount');

        $pendingPayments = Payment::where('status', 'pending')->count();
        $pendingPaymentsAmount = Payment::where('status', 'pending')->sum('amount');

        // Property Statistics
        $totalRooms = Room::count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $availableRooms = Room::where('status', 'available')->count();
        $occupancyRate = $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100) : 0;

        // Tenant Statistics
        $totalTenants = Tenant::count();
        $activeTenants = Tenant::where('status', 'active')->count();

        // Recent Bookings
        $recentBookings = Booking::latest()->take(5)->get();
        $activeBookings = Booking::where('status', 'confirmed')
            ->where('end_date', '>=', $today)
            ->count();

        // Monthly data for charts (last 6 months)
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $monthStart = Carbon::now()->subMonths($i)->startOfMonth();
            $monthEnd = Carbon::now()->subMonths($i)->endOfMonth();
            $monthlyData[] = [
                'month' => $monthStart->format('M'),
                'income' => Finance::where('type', 'income')
                    ->whereBetween('transaction_date', [$monthStart, $monthEnd])
                    ->sum('amount') / 1000000, // Convert to millions
                'expense' => Finance::where('type', 'expense')
                    ->whereBetween('transaction_date', [$monthStart, $monthEnd])
                    ->sum('amount') / 1000000,
            ];
        }

        return view('livewire.admin.dashboard', [
            // Finance
            'todayIncome' => $todayIncome,
            'monthIncome' => $monthIncome,
            'monthExpense' => $monthExpense,
            'yearIncome' => $yearIncome,
            'yearExpense' => $yearExpense,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'netProfit' => $netProfit,

            // Invoices
            'totalInvoices' => $totalInvoices,
            'paidInvoices' => $paidInvoices,
            'unpaidInvoices' => $unpaidInvoices,
            'overdueInvoices' => $overdueInvoices,
            'overdueAmount' => $overdueAmount,
            'monthInvoiceTotal' => $monthInvoiceTotal,

            // Payments
            'todayPayments' => $todayPayments,
            'todayPaymentsAmount' => $todayPaymentsAmount,
            'monthPayments' => $monthPayments,
            'pendingPayments' => $pendingPayments,
            'pendingPaymentsAmount' => $pendingPaymentsAmount,

            // Property
            'totalRooms' => $totalRooms,
            'occupiedRooms' => $occupiedRooms,
            'availableRooms' => $availableRooms,
            'occupancyRate' => $occupancyRate,

            // Tenants
            'totalTenants' => $totalTenants,
            'activeTenants' => $activeTenants,

            // Bookings
            'recentBookings' => $recentBookings,
            'activeBookings' => $activeBookings,

            // Chart Data
            'monthlyData' => $monthlyData,
        ])->layout('layouts.admin');
    }
}
