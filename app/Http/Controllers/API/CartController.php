<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartCollection;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Customer;
use App\Repositories\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class CartController extends Controller
{

    public function __construct(
        private CartRepository $cartRepository
    ){}


    public function index(Request $request)
    {
        $customer_id = $request->query('customer_id');
        if (!$customer_id) {
            return response()->json([
                'message' => 'customer_id is required'
            ], 400);
        }
        $carts = $this->cartRepository->getByCustomerId($customer_id);
        return new CartCollection($carts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//        $request->validate([
//            'product_id' => 'required|exists:products,id',
//            'quantity' => 'required|integer|min:1',
//        ]);

        $customer_id = $request->input('customer_id');
        $product_id = $request->input('product_id');
        $amount = $request->input('amount');


        // อัปเดตหรือสร้างใหม่
        $cart = Cart::updateOrCreate(
            [
                'customer_id' => $customer_id,
                'product_id' => $product_id,
            ],
            [
                'quantity' => $amount, // เปลี่ยนค่าจำนวนสินค้า
            ]
        );

        return new CartResource($cart->refresh());
    }

    public function destroy(Cart $cart)
    {
        if(!$this->cartRepository->isExists($cart->id)){
            return response()->json([
                'message' => 'Cart not found'
            ], 404);
        }

        $this->cartRepository->delete($cart->id);
        return response()->json([
            'message' => 'Product removed from cart successfully'
        ], 200);
    }
}
