<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'store_id' => 'required|exists:stores,id',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'quantity' => 'required|numeric'
        ]);


        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/products', 'public');
            $imageUrl = "storage/$imagePath";
        }

        Product::create([
            'name' => $request->input('name'),
            'store_id' => $request->input('store_id'),
            'price' => $request->input('price'),
            'image' => $imageUrl,
            'quantity' => $request->input('quantity'),
        ]);

        return redirect('/admin/page')->with('message', 'Product added!');
    }


    public function destroy(Request $request)
    {

        $product = Product::findOrFail($request->id);
        $product->delete();
        return redirect('/admin/page')->with('message', 'Product has been deleted');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:products,id',
            'name' => 'required',
            'price' => 'required|numeric',
            'image' => 'mimes:jpg,jpeg,png|max:2048',
            'quantity' => 'required|image|numeric',
            'description' => 'required',
        ]);
        try{
            $image = $request->file('image');
            $destinationPath = 'C:\\Users\\user\\Desktop\\Projecttest\\storage\\app\\public\\images';
            $imageName = time() . '.' . $image->getClientOriginalName();
            $image->move($destinationPath, $imageName);
        }catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()]);
        }
        $product = Product::find($request->id);
        $product->update($request->except(['_token', '_method']));
        return redirect('admin/page')->with('message', 'Product updated successfully');

    }
}
