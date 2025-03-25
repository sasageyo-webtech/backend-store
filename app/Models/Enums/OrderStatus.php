<?php

namespace App\Models\Enums;

enum OrderStatus: string
{
    case RECEIVED = ' RECEIVED'; // ได้รับ order, เตรียม pack ของ
    case DELIVERED = ' DELIVERED'; // จัดส่งแล้ว
    case SUCCESS = 'SUCCESS'; // รับสินค้าแล้ว
    case FAIL = 'FAIL'; // ไม่ได้รับสินค้า
}
