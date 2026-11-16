<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $categories = [
            ['name' => 'GPU', 'description' => 'High-performance graphics cards for gaming and professional use.'],
            ['name' => 'CPU', 'description' => 'Powerful CPUs for desktops and laptops.'],
            ['name' => 'Motherboards', 'description' => 'Reliable motherboards for various platforms.'],
            ['name' => 'Memory (RAM)', 'description' => 'High-speed RAM modules for improved performance.'],
            ['name' => 'Storage Devices', 'description' => 'SSDs and HDDs for fast and reliable storage.'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
