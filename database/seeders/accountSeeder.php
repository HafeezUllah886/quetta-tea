<?php

namespace Database\Seeders;

use App\Models\accounts;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class accountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        accounts::create(
            [
                'title' => "Cash Account",
                'type' => "Business",
                'category' => "Cash",
                'userID' => 1,
            ]
        );

        accounts::create(
            [
                'title' => "Walk-In Customer",
                'type' => "Customer",
                'userID' => 2,
                
            ]
        );

        accounts::create(
            [
                'title' => "Walk-In Vendor",
                'type' => "Vendor",
                'userID' => 1,
            ]
        );
    }
}
