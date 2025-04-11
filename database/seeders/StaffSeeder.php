<?php

namespace Database\Seeders;

use App\Models\Staff;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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

        $staff = Staff::factory()->create();
        $staff->user->username = 'admin';
        $staff->user->email = 'admin@gmail.com';
        $staff->user->save();

    }
}
