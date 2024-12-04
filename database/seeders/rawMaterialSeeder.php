<?php

namespace Database\Seeders;

use App\Models\rawMaterial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class rawMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => "Ghee", "unitID" => 2, "catID" => 1, "price" => 500],
            ['name' => "Chicken", "unitID" => 2, "catID" => 1, "price" => 600],
            ['name' => "Rice", "unitID" => 2, "catID" => 1, "price" => 340],
            ['name' => "Oil", "unitID" => 4, "catID" => 1, "price" => 540],
            ['name' => "Salt", "unitID" => 1, "catID" => 1, "price" => 10],
            ['name' => "Eggs", "unitID" => 5, "catID" => 1, "price" => 300],
            ['name' => "Tomato", "unitID" => 2, "catID" => 1, "price" => 100],
            ['name' => "Milk", "unitID" => 4, "catID" => 1, "price" => 200],
            ['name' => "Next Cola 1.5ltr", "unitID" => 1,"catID" => 2, "price" => 200],
            ['name' => "Next Cola 1ltr", "unitID" => 1,"catID" => 2, "price" => 150],
        ];
        rawMaterial::insert($data);
    }
}
