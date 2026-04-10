<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tenant;
use App\Models\Room;
use App\Models\Property;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create property first
        $property = Property::firstOrCreate(
            ['name' => 'Kos Pekanbaru'],
            [
                'address' => 'Jl. Sudirman No. 1',
                'total_rooms' => 10,
                'occupied_rooms' => 0,
                'is_active' => true
            ]
        );

        // Create a room first
        $room = Room::firstOrCreate(
            ['code' => 'K101'],
            [
                'property_id' => $property->id,
                'type' => 'Standard',
                'price_monthly' => 350000,
                'status' => 'available',
                'floor' => 1
            ]
        );

        // Create tenant
        $tenant = Tenant::firstOrCreate(
            ['email' => 'customer@harsasetialiving.com'],
            [
                'property_id' => $property->id,
                'room_id' => $room->id,
                'name' => 'Customer Test',
                'phone' => '08123456789',
                'move_in_date' => now(),
                'status' => 'active'
            ]
        );

        // Create customer user
        User::firstOrCreate(
            ['email' => 'customer@harsasetialiving.com'],
            [
                'name' => 'Customer',
                'password' => Hash::make('password'),
                'role' => 'customer',
                'tenant_id' => $tenant->id
            ]
        );

        $this->command->info('Test users created successfully!');
    }
}
