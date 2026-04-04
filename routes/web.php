<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\BookingManager;
use App\Livewire\Admin\FinanceManager;
use App\Livewire\Admin\CommentModerator;
use App\Livewire\Admin\RoomSettings;
use App\Livewire\Admin\PropertyManager;
use App\Livewire\Admin\RoomManager;
use App\Livewire\Admin\TenantManager;
use App\Livewire\Admin\InvoiceManager;
use App\Livewire\Admin\PaymentManager;
use App\Livewire\Admin\ExpenseManager;
use App\Livewire\Admin\TemplateInventoryManager;
use App\Livewire\Admin\SettingsManager;
use App\Livewire\Admin\UserManager;
use App\Livewire\Admin\WhatsAppManager;
use App\Livewire\SuperAdmin\Dashboard as SuperAdminDashboard;
use App\Livewire\SuperAdmin\PropertyManager as SuperAdminPropertyManager;
use App\Livewire\SuperAdmin\RoomManager as SuperAdminRoomManager;
use App\Livewire\SuperAdmin\TenantManager as SuperAdminTenantManager;
use App\Livewire\SuperAdmin\InvoiceManager as SuperAdminInvoiceManager;
use App\Livewire\SuperAdmin\PaymentManager as SuperAdminPaymentManager;
use App\Livewire\SuperAdmin\FinanceManager as SuperAdminFinanceManager;
use App\Livewire\SuperAdmin\UserManager as SuperAdminUserManager;
use App\Livewire\SuperAdmin\SettingsManager as SuperAdminSettingsManager;
use App\Livewire\Customer\Dashboard as CustomerDashboard;
use App\Livewire\Customer\Tagihan as CustomerTagihan;
use App\Livewire\Customer\Pembayaran as CustomerPembayaran;
use App\Livewire\Customer\Kamar as CustomerKamar;
use App\Livewire\Customer\Profil as CustomerProfil;

Route::get('/', function () {
    return view('welcome');
});

// Redirect /login to custom login (fix for auth middleware)
Route::get('/login', function () {
    return redirect('/login-superadmin');
})->name('login');

// Simple Login Routes (Separate for each role)
Route::get('/login-superadmin', [LoginController::class, 'showSuperAdminLoginForm'])->name('login.superadmin');
Route::post('/login-superadmin', [LoginController::class, 'loginSuperAdmin'])->name('login.superadmin.post');

Route::get('/login-admin', [LoginController::class, 'showAdminLoginForm'])->name('login.admin');
Route::post('/login-admin', [LoginController::class, 'loginAdmin'])->name('login.admin.post');

Route::get('/login-customer', [LoginController::class, 'showCustomerLoginForm'])->name('login.customer');
Route::post('/login-customer', [LoginController::class, 'loginCustomer'])->name('login.customer.post');

// Legacy simple login (fallback)
Route::get('/login-simple', [LoginController::class, 'showLoginForm'])->name('login.simple');
Route::post('/login-simple', [LoginController::class, 'login'])->name('login.simple.post');

// Super Admin Routes - Dedicated Super Admin Dashboard
Route::middleware(['auth', 'role:super_admin'])->prefix('super-admin')->group(function () {
    Route::get('/', SuperAdminDashboard::class)->name('superadmin.dashboard');
    Route::get('/properties', SuperAdminPropertyManager::class)->name('superadmin.properties');
    Route::get('/kamar', SuperAdminRoomManager::class)->name('superadmin.kamar');
    Route::get('/penyewa', SuperAdminTenantManager::class)->name('superadmin.penyewa');
    Route::get('/tagihan', SuperAdminInvoiceManager::class)->name('superadmin.tagihan');
    Route::get('/pembayaran', SuperAdminPaymentManager::class)->name('superadmin.pembayaran');
    Route::get('/laporan', SuperAdminFinanceManager::class)->name('superadmin.laporan');
    Route::get('/users', SuperAdminUserManager::class)->name('superadmin.users');
    Route::get('/pengaturan', SuperAdminSettingsManager::class)->name('superadmin.pengaturan');
});

// Customer Routes
Route::middleware(['auth', 'role:customer'])->prefix('customer')->group(function () {
    Route::get('/', CustomerDashboard::class)->name('customer.dashboard');
    Route::get('/dashboard', CustomerDashboard::class)->name('customer.dashboard');
    Route::get('/tagihan', CustomerTagihan::class)->name('customer.tagihan');
    Route::get('/pembayaran', CustomerPembayaran::class)->name('customer.pembayaran');
    Route::get('/kamar', CustomerKamar::class)->name('customer.kamar');
    Route::get('/profil', CustomerProfil::class)->name('customer.profil');
});

// Admin Routes - Admin & Super Admin can access
Route::middleware(['auth', 'role:admin,super_admin'])->prefix('admin')->group(function () {
    Route::get('/', Dashboard::class)->name('admin.dashboard');
    Route::get('/properties', PropertyManager::class)->name('admin.properties');
    Route::get('/kamar', RoomManager::class)->name('admin.kamar');
    Route::get('/penyewa', TenantManager::class)->name('admin.penyewa');
    Route::get('/tagihan', InvoiceManager::class)->name('admin.tagihan');
    Route::get('/pembayaran', PaymentManager::class)->name('admin.pembayaran');
    Route::get('/pengeluaran', ExpenseManager::class)->name('admin.pengeluaran');
    Route::get('/inventaris', TemplateInventoryManager::class)->name('admin.inventaris');
    Route::get('/bookings', BookingManager::class)->name('admin.bookings');
    Route::get('/whatsapp', WhatsAppManager::class)->name('admin.whatsapp');
    Route::get('/comments', CommentModerator::class)->name('admin.comments');
    Route::get('/settings', RoomSettings::class)->name('admin.settings');
    Route::get('/pengaturan', SettingsManager::class)->name('admin.pengaturan');
    Route::get('/users', UserManager::class)->name('admin.users');
});

// Super Admin Only Routes (Financial Reports)
Route::middleware(['auth', 'role:super_admin'])->prefix('admin')->group(function () {
    Route::get('/finances', FinanceManager::class)->name('admin.finances');
    Route::get('/laporan', FinanceManager::class)->name('admin.laporan');
    Route::get('/finances/export', function () {
        $finances = \App\Models\Finance::latest()->get();
        $filename = "laporan_keuangan_sewavip_" . date('Y-m-d') . ".csv";
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];
        $columns = ['Tanggal', 'Jenis', 'Nominal', 'Keterangan'];
        $callback = function() use($finances, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($finances as $row) {
                fputcsv($file, [
                    $row->transaction_date->format('Y-m-d'),
                    $row->type === 'income' ? 'Pemasukan' : 'Pengeluaran',
                    $row->amount,
                    $row->description
                ]);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    })->name('admin.finances.export');
});

Route::post('/logout', function () {
    Auth::guard('web')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

require __DIR__.'/auth.php';
