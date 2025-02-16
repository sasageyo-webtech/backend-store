<?php

namespace App\Models\Enums;

enum UserRole: string {
    case CUSTOMER = 'CUSTOMER';
    case STAFF = 'STAFF';
}
