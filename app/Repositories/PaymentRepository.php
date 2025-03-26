<?php

namespace App\Repositories;

use App\Models\Payment;
use App\Repositories\Traits\SimpleCRUD;

class PaymentRepository
{
    use SimpleCRUD;
    private string $model = Payment::class;
}
