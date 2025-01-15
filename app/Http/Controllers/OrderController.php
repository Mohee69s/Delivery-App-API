<?php

namespace App\Http\Controllers;

use App\Models\Order;
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
}
