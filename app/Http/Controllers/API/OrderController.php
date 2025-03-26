<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Enums\OrderStatus;
use App\Models\Enums\PaymentMethod;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Repositories\CartRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\OrderProductRepository;
use App\Repositories\OrderRepository;
use App\Repositories\PaymentRepository;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        private OrderRepository $orderRepository,
        private PaymentRepository $paymentRepository,
        private CartRepository $cartRepository,
        private CustomerRepository $customerRepository,
        private OrderProductRepository $orderProductRepository,
    ){}

    public function index()
    {
        //
    }


    public function store(Request $request)
    {

        $customer_id = $request->input('customer_id');

        $customer = $this->customerRepository->getById($customer_id);

        if (!$customer) return response()->json(['message' => 'Customer not found'], 404);

        $carts = $customer->carts;

        if ($carts->isEmpty()) return response()->json(['message' => 'Cart is empty'], 400);

        // สร้าง order
        $totalPrice = $carts->sum(function($cart) {
            return $cart->product->price * $cart->quantity;
        });


        // สร้าง order
        $order = $this->orderRepository->create([
            'customer_id' => $customer_id,
            'total_price' => $totalPrice,
        ]);

        // สร้าง payment
        // ตรวจสอบว่ามีไฟล์ภาพหรือไม่
        if ($request->hasFile('image_receipt_path')) {
            $receiptImage = $request->file('image_receipt_path');

            // อัปโหลดไฟล์ไปยัง storage
            $filename = time() . '-' . $receiptImage->getClientOriginalName();
            $path = $receiptImage->storeAs('receipts', $filename, 'public');
//            return response()->json([
//                "order" => $order,
//                "amount" => $totalPrice,
//                "method" => PaymentMethod::BANK_TRANSFER,
//                "receipt" => $path,
//            ]);
            // ใช้ path ที่ได้ในการบันทึกลง payment
            $payment = $this->paymentRepository->create([
                'order_id' => $order->id,
                'amount' => $totalPrice,
                'method' => PaymentMethod::BANK_TRANSFER,
                'image_receipt_path' => $path, // ใช้ path ที่ได้จากการอัปโหลด
            ]);

        } else {
            return response()->json(['message' => 'Image receipt is required'], 400);
        }


        // บันทึกข้อมูลใน order_product
        foreach ($carts as $cart) {
            $this->orderProductRepository->create([
                'order_id' => $order->id,
                'product_id' => $cart->product_id,
                'quantity' => $cart->quantity,
                'total_price' => $cart->product->price * $cart->quantity,
            ]);
        }


        // ลบ cart หลังจากสร้าง order เสร็จ
        $this->cartRepository->deleteByCustomerId($customer_id);

        return new OrderResource($order);
    }


    public function show(Order $order)
    {
        //
    }

    public function update(Request $request, Order $order)
    {
        //
    }

}
