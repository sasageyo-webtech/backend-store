<?php

namespace App\Repositories;

use App\Models\AddressCustomer;
use App\Repositories\Traits\SimpleCRUD;
use Illuminate\Database\Eloquent\Collection;

class AddressCustomerRepository
{
    use SimpleCRUD;

    private string $model = AddressCustomer::class;

    public function getByCustomerId(int $customerId): Collection {
        return $this->model::where("customer_id", $customerId)->get();
    }
}
