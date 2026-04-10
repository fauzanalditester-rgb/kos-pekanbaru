<?php
// Test login directly
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

header('Content-Type: text/plain');

echo "=== LOGIN DEBUG ===\n\n";

// Check database connection
try {
    $count = User::count();
    echo "Database connected. Users: $count\n\n";
} catch (Exception $e) {
    echo "Database ERROR: " . $e->getMessage() . "\n\n";
}

// Test each user
$users = User::all();
foreach ($users as $user) {
    echo "User: {$user->email} ({$user->role})\n";
    
    // Check password hash
    $hashValid = password_verify('password', $user->password);
    $hashCheck = Hash::check('password', $user->password);
    
    echo "  - Password 'password': " . ($hashCheck ? "VALID ✓" : "INVALID ✗") . "\n";
    echo "  - Hash format: " . substr($user->password, 0, 30) . "...\n";
    
    // Try Auth::attempt
    $attempt = Auth::attempt(['email' => $user->email, 'password' => 'password']);
    echo "  - Auth::attempt: " . ($attempt ? "SUCCESS ✓" : "FAILED ✗") . "\n";
    
    if ($attempt) {
        Auth::logout();
    }
    
    echo "\n";
}

echo "=== CONFIG ===\n";
echo "DB Connection: " . config('database.default') . "\n";
echo "Session Driver: " . config('session.driver') . "\n";
echo "App Key exists: " . (config('app.key') ? 'YES' : 'NO') . "\n";
