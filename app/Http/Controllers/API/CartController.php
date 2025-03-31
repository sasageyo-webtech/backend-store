<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCartRequest;
use App\Http\Resources\CartCollection;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Customer;
use App\Repositories\CartRepository;
use App\Repositories\CustomerRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class CartController extends Controller
{

    public function __construct(
        private CartRepository $cartRepository,
        private CustomerRepository $customerRepository
    ){}


    public function index(Request $request)
    {
        $customer_id = $request->input('customer_id');
        if(!$this->customerRepository->isExists($customer_id)) {
            return response()->json([
                'message' => 'Customer not found',
                'errors' => [
                    'customer_id' => [
                        'Customer not found.'
                    ]
                ]
            ], 404);
        }

        $carts = $this->cartRepository->getByCustomerId($customer_id);
        return new CartCollection($carts);
    }

    public function store(CreateCartRequest $request)
    {
        $request->validated();

        // อัปเดตหรือสร้างใหม่
        $cart = Cart::updateOrCreate(
            [
                'customer_id' => $request->input('customer_id'),
                'product_id' => $request->input('product_id'),
            ],
            [
                'quantity' => $request->input('amount'), // เปลี่ยนค่าจำนวนสินค้า
            ]
        );

        return response()->json([
            'message' => 'Cart saved',
            'data' => new CartResource($cart)
        ], 201);
    }

    public function destroy(int $cart_id)
    {
        if(!$this->cartRepository->isExists($cart_id)){
            return response()->json([
                'message' => 'Cart not found',
                'errors' => [
                    'cart_id' => 'Cart not found.'
                ]
            ], 404);
        }

        $this->cartRepository->delete($cart_id);
        return response()->json([
            'message' => 'Product removed from cart successfully'
        ]);
    }
}
