<?php

namespace App\Models\Enums;

enum ProductAccessibility: string {
    case PUBLIC = 'PUBLIC';
    case PRIVATE = 'PRIVATE';
}
