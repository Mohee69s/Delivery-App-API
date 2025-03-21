<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index(Request $request){
        $id=$request->user()->id;
        $orders=Order::where('user_id',$id)->get();
        return response()->json([
            'message'=>'success',
            'orders'=>$orders
        ]);
    }
    public function show($id)
    {
        $user_id=Request()->user()->id;
        $order=Order::where('user_id',$user_id)->where('id',$id)->with('items')->first();
        if(!$order){
            return response()->json([
                'message'=>'empty',
            ]);
        }
        return response()->json([
            'message'=>'success',
            'order'=>$order
        ]);
    }
    public function destroy(Request $request,$order): JsonResponse
    {
        try {
            $userId = auth()->id();
            $orderId=$order;

            $order = Order::where('id', $orderId)->where('user_id', $userId)->first();

            if (!$order) {
                return response()->json(['message' => 'Order not found or does not belong to the user'], 404);
            }

            if ($order->status === 'canceled') {
                return response()->json(['message' => 'Order is already canceled'], 400);
            }

            $orderItems = OrderItem::where('order_id', $order->id)->get();

            foreach ($orderItems as $orderItem) {
                $product = Product::find($orderItem->product_id);

                if ($product) {
                    $product->quantity += $orderItem->quantity;
                    $product->save();
                }
            }

            $order->status = 'canceled';
            $order->save();

            return response()->json(['message' => 'Order canceled successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

}
