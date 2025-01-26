<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['title' => 'Пластик', 'slug' => 'plastic'],
            ['title' => '3Д друк', 'slug' => '3D resin'],
            ['title' => 'Литво (смола)', 'slug' => 'resin'],
            ['title' => 'Литво (метал)', 'slug' => 'metal-casting'],
        ];

        foreach ($types as $type) {
            ProductType::factory([
                'title' => $type['title'],
                'slug' => $type['slug'],
            ])->create();
        }
    }
}
