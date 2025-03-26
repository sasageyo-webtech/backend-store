<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Repositories\Traits\SimpleCRUD;

class CustomerRepository
{
    use SimpleCRUD;
    private string $model = Customer::class;
}
