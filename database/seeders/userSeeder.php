<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => "Admin",
            'password' => Hash::make("admin"),
            'role' => 'Admin',
        ]);
        User::create([
            'name' => "Cashier",
            'password' => Hash::make("cashier"),
            'role' => 'Cashier',
        ]);
        User::create([
            'name' => "Waiter",
            'password' => Hash::make("waiter"),
            'role' => 'Waiter',
        ]);
        User::create([
            'name' => "Kitchen",
            'password' => Hash::make("kitchen"),
            'role' => 'Kitchen',
        ]);
        User::create([
            'name' => "Store Keeper",
            'password' => Hash::make("store"),
            'role' => 'Store Keeper',
        ]);
        User::create([
            'name' => "Walk-In Customer",
            'password' => Hash::make("customer"),
            'role' => 'Customer',
        ]);
        User::create([
            'name' => "Customer",
            'password' => Hash::make("customer"),
            'role' => 'Customer',
        ]);
    }
}
