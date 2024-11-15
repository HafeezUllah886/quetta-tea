<?php

namespace Database\Seeders;

use App\Models\items;
use App\Models\products;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class itemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => "Test Product 1", "price" => 640, 'dprice' => 620, 'kitchenID' => 1, 'catID' => 1],
            ['name' => "Test Product 2", "price" => 300, 'dprice' => 280, 'kitchenID' => 1, 'catID' => 1],
            ['name' => "Test Product 3", "price" => 1050, 'dprice' => 900, 'kitchenID' => 1, 'catID' => 1],
        ];
        items::insert($data);
    }
}
