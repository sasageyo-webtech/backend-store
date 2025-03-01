<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brand_names = [
            'Mizumi',
            'Orental Princess',
            'Rojukiss',
            'Srichand',
            'Mistine'
        ];

        foreach ($brand_names as $brand_name) {
            Brand::factory()->create([
                'name' => $brand_name
            ]);
        }
    }
}
