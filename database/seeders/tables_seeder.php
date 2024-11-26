<?php

namespace Database\Seeders;

use App\Models\tables;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class tables_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => "Table 1", "location" => "Ground Floor"],
            ['name' => "Table 2", "location" => "Ground Floor"],
            ['name' => "Table 3", "location" => "Ground Floor"],
            ['name' => "Table 4", "location" => "First Floor"],
            ['name' => "Table 5", "location" => "First Floor"],
        ];
        tables::insert($data);
    }
}
