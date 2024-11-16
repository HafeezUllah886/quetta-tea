<?php

namespace Database\Seeders;

use App\Models\items;
use App\Models\sizes;
use Illuminate\Database\Seeder;

class itemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => "Chicken Baryani", 'kitchenID' => 4, 'catID' => 1],
            ['name' => "Chicken Broast", 'kitchenID' => 4, 'catID' => 2],
            ['name' => "Zinger Burger", 'kitchenID' => 4, 'catID' => 3],
        ];

        $sizes = [
            ['itemID' => 1,'label' => "Singel", 'price' => 230, 'dprice' => 200],
            ['itemID' => 1,'label' => "Double", 'price' => 380, 'dprice' => 350],
            ['itemID' => 2,'label' => "Quater", 'price' => 300, 'dprice' => 260],
            ['itemID' => 2,'label' => "Full", 'price' => 600, 'dprice' => 550],
            ['itemID' => 3,'label' => "Standered", 'price' => 630, 'dprice' => 600],
        ];
        items::insert($data);
        sizes::insert($sizes);
    }
}
