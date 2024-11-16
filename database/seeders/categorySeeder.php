<?php

namespace Database\Seeders;

use App\Models\categories;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class categorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cats = [
            ['name' => 'Biryani'],
            ['name' => 'Broast'],
            ['name' => 'Chinese'],
            ['name' => 'Burgers'],
        ];

        categories::insert($cats);
    }
}
