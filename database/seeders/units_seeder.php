<?php

namespace Database\Seeders;

use App\Models\units;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class units_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => "Nos", "value" => 1],
            ['name' => "KG", "value" => 1000],
            ['name' => "Gram", "value" => 1],
            ['name' => "Ltr", "value" => 1000],
            ['name' => "Dzn", "value" => 12],
        ];
        units::insert($data);
    }
}
