<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{

    public function index($type): JsonResponse
    {
        $stores = Store::where('type', $type)->get(['id', 'name', 'image']);

        $stores->transform(function ($store) {
            $store->image = $store->image ? asset($store->image) : null;

            $store->products->transform(function ($product) {
                $product->image = $product->image ? asset($product->image) : null;
                return $product;
            });

            return $store;
        });

        return response()->json([
            'stores' => $stores->load('products')
        ]);
    }


    public function show($type, Store $store): JsonResponse
    {
        $result = $store->load('products');

        if ($store->type === $type) {
            $result->image = $result->imgae ? url($result->image) : null;

            $result->products->transform(function ($product) {
                $product->image = $product->image ? url($product->image) : null;
                return $product;
            });

            return response()->json([
                'store' => $result,
            ]);
        }

        return response()->json([
            'message' => 'Wrong store type or id',
        ]);
    }


}
