<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    public function index($type): JsonResponse
    {
        $stores=Store::where('type',$type)->get();
        return response()->json([
            'stores'=>$stores
        ]);
    }
    public function show($type,Store $store): JsonResponse
    {
        $result=$store->load('products');
        if ($store->type === $type ) {
            return response()->json([
                'store' => $result,
            ]);
        }
        return response()->json([
            'message' => 'Wrong store type or id'
        ]);
    }
}
