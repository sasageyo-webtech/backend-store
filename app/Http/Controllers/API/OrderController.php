<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Customer;
use App\Models\Enums\OrderStatus;
use App\Models\Enums\PaymentMethod;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Repositories\AddressCustomerRepository;
use App\Repositories\CartRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\OrderProductRepository;
use App\Repositories\OrderRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        private OrderRepository $orderRepository,
        private AddressCustomerRepository $addressCustomerRepository,
        private PaymentRepository $paymentRepository,
        private CartRepository $cartRepository,
        private CustomerRepository $customerRepository,
        private OrderProductRepository $orderProductRepository,
        private ProductRepository $productRepository,
    ){}

    public function index()
    {
        $orders = $this->orderRepository->get(20);
        return new OrderCollection($orders);
    }

    public function store(CreateOrderRequest $request)
    {
        $request->validated();

        $customer_id = $request->input('customer_id');
        $address_customer_id = $request->input('address_customer_id');

        if(!$this->customerRepository->isExists($customer_id))
            return response([
                'message' => 'Customer not found',
                'errors' => [
                    'customer_id' => "Customer {$customer_id} not found",
                ]
            ], 404);

        $customer = $this->customerRepository->getById($customer_id);

        if(!$this->addressCustomerRepository->isExists($address_customer_id))
            return response([
                'message' => 'Address not found',
                'errors' => [
                    'address_customer_id' => "Address {$address_customer_id} not found",
                ]
            ]);

        // ตรวจสอบว่า Address เป็นของ Customer หรือไม่
        if (!$customer->address_customers->contains('id', $address_customer_id)) {
            return response([
                'message' => 'Address does not belong to this customer',
                'errors' => [
                    'address_customer_id' => "Address {$address_customer_id} does not belong to customer {$customer_id}",
                ]
            ], 403);
        }

        $carts = $customer->carts;

        if ($carts->isEmpty())
            return response()->json([
                'message' => 'Customer Cart is empty',
                'errors' => [
                    'cart' => "Customer Cart is empty",
                ],
            ], 422);

        // ตรวจสอบว่ามีสินค้าเพียงพอหรือไม่
        foreach ($carts as $cart) {
            $product = $this->productRepository->getById($cart->product_id);
            if ($product->stock < $cart->quantity) {
                return response()->json([
                    'message' => 'Insufficient stock for product: ' . $product->name . ' stock: ' . $product->stock,
                    'errors' => [
                        'product' => "Insufficient stock for product: " . $product->name . ' stock: ' . $product->stock,
                    ]
                ], 422);
            }
        }

        // คำนวณราคาทั้งหมด
        $totalPrice = $carts->sum(fn($cart) => $cart->product->price * $cart->quantity);
        $deliveryFee = 45;

        // สร้าง Order
        $order = $this->orderRepository->create([
            'customer_id' => $customer_id,
            'address_customer_id' => $address_customer_id,
            'total_price' => $totalPrice + $deliveryFee,
        ]);

        // สร้าง payment
        // ตรวจสอบว่ามีไฟล์ภาพหรือไม่
        // อัปโหลดไฟล์ใบเสร็จ
        $receiptImage = $request->file('image_receipt_path');
        $filename = time() . '-' . $receiptImage->getClientOriginalName();
        $path = $receiptImage->storeAs('receipts', $filename, 'public');


        // สร้าง Payment
        $payment = $this->paymentRepository->create([
            'order_id' => $order->id,
            'amount' => $totalPrice + $deliveryFee,
            'method' => PaymentMethod::BANK_TRANSFER,
            'image_receipt_path' => $path,
        ]);

        // บันทึกข้อมูลใน order_product
        foreach ($carts as $cart) {
            $this->orderProductRepository->create([
                'order_id' => $order->id,
                'product_id' => $cart->product_id,
                'quantity' => $cart->quantity,
                'total_price' => $cart->product->price * $cart->quantity,
            ]);

            // ลบ stock
            $product = $this->productRepository->getById($cart->product_id);
            $product->stock -= $cart->quantity;
            $this->productRepository->update(['stock' => $product->stock], $product->id);
        }


        // ลบ cart หลังจากสร้าง order เสร็จ
        $this->cartRepository->deleteByCustomerId($customer_id);

        return new OrderResource($order);
    }

    public function show(int $order_id)
    {
        if(!$this->orderRepository->isExists($order_id))
            return response()->json([
                'message' => 'Order not found',
                'errors' => [
                    'order_id' => "Order {$order_id} not found",
                ]
            ]);
        $order = $this->orderRepository->getById($order_id);
        return new OrderResource($order);
    }

    public function update(UpdateOrderRequest $request, int $order_id)
    {
        $request->validated();

        if(!$this->orderRepository->isExists($order_id))
            return response()->json([
                'message' => 'Order not found',
                'errors' => [
                    'order_id' => "Order {$order_id} not found",
                ]
            ]);

        $order = $this->orderRepository->getById($order_id);

        $this->orderRepository->update([
            "status" => $request->input('status'),
        ], $order_id);

        return new OrderResource($order->refresh());
    }

    public function getOrderCustomer(int $customer_id){
        if(!$this->customerRepository->isExists($customer_id))
            return response()->json([
                'message' => 'Customer not found',
                'errors' => [
                    'customer_id' => "Customer {$customer_id} not found",
                ]
            ]);

        $orders = $this->orderRepository->getByCustomerId($customer_id);
        return new OrderCollection($orders);
    }

}
