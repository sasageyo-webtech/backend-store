<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $limit = 5;
        $exits = Staff::count();
        if ($limit > $exits) {
            Staff::factory()->count($limit)->create();
        }
    }
}
