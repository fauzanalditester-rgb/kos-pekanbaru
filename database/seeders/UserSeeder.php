<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin - akses penuh
        User::updateOrCreate(
            ['email' => 'superadmin@sewavip.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'),
                'role' => User::ROLE_SUPER_ADMIN,
                'tenant_id' => null,
            ]
        );

        // Admin biasa - tidak akses laporan
        User::updateOrCreate(
            ['email' => 'admin@sewavip.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password123'),
                'role' => User::ROLE_ADMIN,
                'tenant_id' => null,
            ]
        );

        // Customer - akan di-link ke tenant
        // Note: tenant_id harus di-set manual setelah ada data tenant
        User::updateOrCreate(
            ['email' => 'customer@sewavip.com'],
            [
                'name' => 'Customer Demo',
                'password' => Hash::make('password123'),
                'role' => User::ROLE_CUSTOMER,
                'tenant_id' => null, // Update setelah ada tenant
            ]
        );
    }
}
