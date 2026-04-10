<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\User;

echo "=== DATABASE CHECK ===\n\n";

echo "Tables:\n";
$tables = DB::select("SELECT name FROM sqlite_master WHERE type='table' ORDER BY name");
foreach ($tables as $table) {
    echo "  - " . $table->name . "\n";
}

echo "\n=== USERS ===\n";
$users = User::all();
foreach ($users as $user) {
    echo "Email: {$user->email}, Role: {$user->role}\n";
    echo "  Password starts with: " . substr($user->password, 0, 20) . "...\n";
}

echo "\n=== SESSION TABLE ===\n";
try {
    $hasSession = DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name='sessions'");
    echo "Sessions table: " . (count($hasSession) > 0 ? "EXISTS" : "MISSING") . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\nDone!\n";
