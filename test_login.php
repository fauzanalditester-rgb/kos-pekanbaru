<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

echo "=== TESTING LOGIN ===\n\n";

// Test credentials
$testLogins = [
    ['email' => 'superadmin@sewavip.com', 'password' => 'password'],
    ['email' => 'admin@sewavip.com', 'password' => 'password'],
    ['email' => 'customer@sewavip.com', 'password' => 'password'],
];

foreach ($testLogins as $cred) {
    echo "Testing: {$cred['email']}\n";
    
    $user = User::where('email', $cred['email'])->first();
    if (!$user) {
        echo "  User not found!\n";
        continue;
    }
    
    // Verify password
    if (Hash::check($cred['password'], $user->password)) {
        echo "  Password: OK\n";
        echo "  Role: {$user->role}\n";
        
        // Test Auth::attempt
        $attempt = Auth::attempt(['email' => $cred['email'], 'password' => $cred['password']]);
        echo "  Auth::attempt: " . ($attempt ? "SUCCESS ✓" : "FAILED ✗") . "\n";
        
        if ($attempt) {
            Auth::logout();
        }
    } else {
        echo "  Password: INVALID\n";
    }
    echo "---\n";
}

echo "\nDone!\n";
