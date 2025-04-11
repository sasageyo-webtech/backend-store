<?php

namespace Database\Seeders;

use App\Models\AddressCustomer;
use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            for ($i = $exits; $i < $limit; $i++) {
                $customer = Customer::factory()->create();
                AddressCustomer::factory()->create([
                    'customer_id' => $customer->id,
                ]);
            }

        }

        $customer = Customer::factory()->create();
        $customer->user->email = "test@gmail.com";
        $customer->user->save();


        AddressCustomer::factory()->create([
            'customer_id' => $customer->id,
        ]);
    }
}
