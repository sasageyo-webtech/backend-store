<?php

namespace App\Models\Enums;

enum ShipmentStatus: string {
    case PENDING = 'PENDING';
    case SUCCESS = 'SUCCESS';
}
