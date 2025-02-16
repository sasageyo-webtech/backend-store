<?php

namespace App\Models\Enums;

enum OrderStatus: string
{
    case PENDING = 'PENDING';
    case SUCCESS = 'SUCCESS';

}
