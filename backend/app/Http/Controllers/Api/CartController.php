<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\UpdateCartItemRequest;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $cart = $this->getOrCreateCart($request->user());
        $cart->load('items.product');

        return response()->json([
            'cart' => new CartResource($cart),
        ]);
    }

    public function add(AddToCartRequest $request): JsonResponse
    {
        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return response()->json([
                'message' => 'Insufficient stock available',
            ], 400);
        }

        $cart = $this->getOrCreateCart($request->user());

        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->quantity;

            if ($product->stock < $newQuantity) {
                return response()->json([
                    'message' => 'Insufficient stock available',
                ], 400);
            }

            $cartItem->update([
                'quantity' => $newQuantity,
            ]);
        } else {
            $cartItem = $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price,
            ]);
        }

        $cart->load('items.product');

        return response()->json([
            'message' => 'Item added to cart successfully',
            'cart' => new CartResource($cart),
        ]);
    }

    public function update(UpdateCartItemRequest $request, $itemId): JsonResponse
    {
        $cart = $this->getOrCreateCart($request->user());
        $cartItem = $cart->items()->findOrFail($itemId);

        $product = $cartItem->product;

        if ($product->stock < $request->quantity) {
            return response()->json([
                'message' => 'Insufficient stock available',
            ], 400);
        }

        $cartItem->update([
            'quantity' => $request->quantity,
        ]);

        $cart->load('items.product');

        return response()->json([
            'message' => 'Cart item updated successfully',
            'cart' => new CartResource($cart),
        ]);
    }

    public function remove(Request $request, $itemId): JsonResponse
    {
        $cart = $this->getOrCreateCart($request->user());
        $cartItem = $cart->items()->findOrFail($itemId);

        $cartItem->delete();

        $cart->load('items.product');

        return response()->json([
            'message' => 'Item removed from cart successfully',
            'cart' => new CartResource($cart),
        ]);
    }

    public function clear(Request $request): JsonResponse
    {
        $cart = $this->getOrCreateCart($request->user());
        $cart->items()->delete();

        return response()->json([
            'message' => 'Cart cleared successfully',
        ]);
    }

    private function getOrCreateCart($user): Cart
    {
        return Cart::firstOrCreate(['user_id' => $user->id]);
    }
}
