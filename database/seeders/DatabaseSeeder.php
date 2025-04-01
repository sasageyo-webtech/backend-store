<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Database\Factories\ProductFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CustomerSeeder::class,

            CategorySeeder::class,
            BrandSeeder::class,
            ProductSeeder::class, // ต้องใช้ customer
            StaffSeeder::class,
            CartSeeder::class,
        ]);
    }
}
