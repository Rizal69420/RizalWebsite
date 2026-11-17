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
            ['name' => 'GPU', 'description' => 'Graphics Processing Units (dipakai untuk gaming dan pekerjaan profesional).'],
            ['name' => 'CPU', 'description' => 'Central Processing Units (otak dari komputer).'],
            ['name' => 'PSU', 'description' => 'Power Supply Unit (memberikan listrik keseluruh perangkat keras).'],
            ['name' => 'Motherboards', 'description' => 'Perangkat keras yang menghubungkan seluruh perangkat keras lainnya.'],
            ['name' => 'Memory (RAM)', 'description' => 'Random Access Memory (Modul RAM berkecepatan tinggi untuk kinerja yang lebih baik).'],
            ['name' => 'Storage Devices', 'description' => 'SSD (Solid State Drive) dan HDD (Hard Disk Drive) untuk penyimpanan yang cepat dan andal.'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
