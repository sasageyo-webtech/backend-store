<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartCollection;
use App\Http\Resources\CartResource;
use App\Models\Cart;
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
        $carts = $this->cartRepository->getByCustomerId($customer_id);
        return new CartCollection($carts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::updateOrCreate(
            ['customer_id' => auth()->id(), 'product_id' => $request->product_id],
            ['quantity' => $request->quantity]
        );

        return new CartResource($cart->refresh());
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        $this->cartRepository->delete($cart->id);
        response()->json([
            'message' => 'Product removed from cart'
        ]);
    }

    public function confirmOrder()
    {
        $carts = Cart::where('customer_id', auth()->id())->get();

        // ลบรายการในตะกร้า
        foreach ($carts as $cart) {
            $cart->delete();
        }

        return response()->json(['message' => 'Order confirmed and cart cleared']);
    }
}
