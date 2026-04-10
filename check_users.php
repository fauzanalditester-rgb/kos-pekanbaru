<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "=== CHECKING USERS ===\n\n";

$users = User::all();
foreach ($users as $user) {
    echo "Email: {$user->email}\n";
    echo "Role: {$user->role}\n";
    echo "Password Hash: " . substr($user->password, 0, 30) . "...\n";
    
    // Test password verification
    $testPassword = 'password';
    $isValid = Hash::check($testPassword, $user->password);
    echo "Password '{$testPassword}' valid: " . ($isValid ? "YES ✓" : "NO ✗") . "\n";
    echo "---\n";
}

echo "\nTotal users: " . User::count() . "\n";
