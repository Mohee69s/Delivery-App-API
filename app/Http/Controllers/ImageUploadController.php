<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    public function upload(Request $request)
    {
// Validate the request
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
            'type' => 'required|string|in:store,product', // Specify if it's for a store or product
        ]);

// Handle the file upload
        $folder = $request->type === 'store' ? 'stores' : 'products';
        $filePath = $request->file('image')->store("images/$folder", 'public');

// Return the file path as the response
        return response()->json([
            'success' => true,
            'path' => $filePath, // Save this in the 'image' column
            'message' => 'Image uploaded successfully!',
        ]);
    }
}
