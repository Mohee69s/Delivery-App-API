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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        try{
            $image = $request->file('image');
            $destinationPath = 'C:\Users\user\Desktop\Projecttest\storage\app\public\images';
            $imageName = time() . '.' . $image->getClientOriginalName();
            $image->move($destinationPath, $imageName);
        }catch (\Exception $exception){
            return response()->json(['error' => $exception->getMessage()]);
        }
        Store::create(['name' => $request->name, 'type' => $request->type,'image'=>$request->image]);
        return redirect('admin/page')->with('message', 'Store has been added');
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
