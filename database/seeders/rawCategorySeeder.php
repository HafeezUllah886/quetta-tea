<?php

namespace Database\Seeders;

use App\Models\raw_categories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class rawcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cats = [
            ['name' => 'Kitchen Items'],
            ['name' => 'Beverage'],
        ];

        raw_categories::insert($cats);
    }
}
