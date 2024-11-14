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
            ['name' => "Test Product 1", "unitID" => 1, "price" => 540],
            ['name' => "Test Product 2", "unitID" => 1, "price" => 300],
            ['name' => "Test Product 3", "unitID" => 1, "price" => 900],
        ];
        rawMaterial::insert($data);
    }
}
