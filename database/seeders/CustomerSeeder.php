<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $limit = 30;
        $exits = Customer::count();
        if ($limit > $exits) {
            Customer::factory()->count($limit)->create();
        }
    }
}
