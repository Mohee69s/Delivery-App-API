<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function show($id)
    {
        $product=Product::where('$id',$id)->first();
        $product->transform(function ($product) {
            $product->image = $product->image ? asset($product->image) : null;
            return $product;
        });
        return response()->json([
            'product' => $product,
            'store' => $product->store,
        ]);
    }

}
