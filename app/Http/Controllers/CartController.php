<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function index(Request $request)
    {
        $cartItems = Cart::where('user_id', $request->user()->id)->with('products')->get();
        if (!$cartItems) {
            return response()->json([
                'message' => 'Cart is empty',
            ]);
        }

        return response()->json([
            'cartItems' => $cartItems,
        ]);
    }


    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $userId = auth()->id();

        Cart::create([
            'user_id' => $userId,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'price' => Product::where('id', $request->product_id)->first()->price,
        ]);

        return response()->json(['message' => 'Product added to cart successfully']);
    }

    public function update(Request $request, $cartItemId): JsonResponse
    {
        $userId = auth()->id();

        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::where('id', $cartItemId)
            ->where('user_id', $userId)
            ->first();


        if (!$cartItem) {
            return response()->json(['message' => 'Cart item not found or does not belong to the user'], 404);
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();


        return response()->json([
            'message' => 'Cart item quantity updated successfully',
            'cartItem' => $cartItem
        ]);
    }

    public function destroy(Request $request, $cartItemId)
    {
        $userId = auth()->id();

        $cartItem = Cart::where('id', $cartItemId)
            ->where('user_id', $userId)
            ->first();

        if (!$cartItem) {
            return response()->json(['message' => 'Cart item not found or does not belong to the user'], 404);
        }
        $cartItem->delete();

        return response()->json(['message' => 'Product removed from cart successfully']);
    }
    public function placeOrder(Request $request)
    {
        try {
            $userId = auth()->id();

            $cartItems = Cart::where('user_id', $userId)->with('products')->get();

            if ($cartItems->isEmpty()) {
                return response()->json(['message' => 'Cart is empty'], 400);
            }

            $totalPrice = 0;

            foreach ($cartItems as $cartItem) {
                $product = Product::find($cartItem->product_id);

                if (!$product) {
                    return response()->json(['message' => 'Product not found'], 404);
                }

                if ($product->quantity < $cartItem->quantity) {
                    return response()->json([
                        'message' => "Insufficient stock for product: {$product->name}",
                    ], 400);
                }

                $totalPrice += $product->price * $cartItem->quantity;

                $product->quantity -= $cartItem->quantity;
                $product->save();
            }


            $order = Order::create([
                'user_id' => $userId,
                'total' => $totalPrice,
            ]);

            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => Product::find($cartItem->product_id)->price,
                ]);
            }

            Cart::where('user_id', $userId)->delete();

            return response()->json([
                'message' => 'Order created successfully',
                'order' => $order,
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

}
