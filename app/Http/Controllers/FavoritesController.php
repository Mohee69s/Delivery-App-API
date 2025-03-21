<?php

namespace App\Http\Controllers;

use App\Models\Favorites;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $favorites = $user->favorites;

        return response()->json(['favorites' => $favorites]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id'=>'required|exists:products,id'
        ]);
        Favorites::create([
            'user_id'=>$request->user()->id,
            'product_id' => $request->product_id,
        ]);
        return response()->json([
            'message'=>'product added to favorites'
        ]);
    }
    public function destroy($favorite)
    {
        $user_id = auth()->id();

        $favored = Favorites::where('id',$favorite)
            ->where('user_id',$user_id)
            ->first();
        if (!$favored){
            return response()->json([
                'message'=>'product not found in favorites'
            ]);
        }
        $favored->delete();

        return response()->json(['message' => 'Product removed from favorites']);
    }
}
