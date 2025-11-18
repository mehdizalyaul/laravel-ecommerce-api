<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '+1234567890',
            'address' => '123 Admin Street, Admin City, AC 12345',
        ]);

        $customers = [
            ['John Doe', 'john@example.com', '+1234567891', '456 Customer Ave, Customer City, CC 67890'],
            ['Jane Smith', 'jane@example.com', '+1234567892', '789 Buyer Boulevard, Shopper Town, ST 11111'],
            ['Mike Johnson', 'mike@example.com', '+1234567893', '321 Consumer Lane, Purchase City, PC 22222'],
            ['Sarah Williams', 'sarah@example.com', '+1234567894', '654 Market Street, Commerce Town, CT 33333'],
        ];

        foreach ($customers as [$name, $email, $phone, $address]) {
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make('password'),
                'role' => 'customer',
                'phone' => $phone,
                'address' => $address,
            ]);
        }

        User::factory()->count(10)->create();
    }
}
