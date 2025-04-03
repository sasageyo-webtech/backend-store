<?php

namespace App\Models\Enums;

enum OrderStatus: string
{
    case PENDING = 'PENDING'; // pending approval รอการอนุมัติ
    case APPROVED = 'APPROVED'; // ยืนยันการจ่ายเงินแล้ว
    case DELIVERED = 'DELIVERED'; // จัดส่งแล้ว
    case SUCCEED = 'SUCCEED'; // รับสินค้าแล้ว
    case FAIL = 'FAILED'; // ไม่ได้รับสินค้า
}
