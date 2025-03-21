<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class AdminStoreController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageUrl = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/stores', 'public');
            $imageUrl = "storage/$imagePath"; // Generate the URL for the image
        } else {
            return redirect()->back()->with('error', 'Image upload failed');
        }

        Store::create([
            'name' => $request->name,
            'type' => $request->type,
            'image' => $imageUrl,
        ]);

        return redirect('admin/page')->with('message', 'Store has been added successfully');
    }


    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:stores,id',
        ]);
        $store = Store::findOrFail($request->id);
        $store->products()->delete();
        $store->delete();
        return redirect('/admin/page')->with('message', 'Store has been deleted');
    }
}
