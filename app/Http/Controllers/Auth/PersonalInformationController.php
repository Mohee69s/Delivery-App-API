<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonalInformationController extends Controller
{
    public function index(User $user)
    {
        return $user;
    }
    public function store(Request $request){
        $data = $request->validate([
            'name' => 'required',
            'profile_picture' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'location' => 'required',
        ]);
        $user=Auth::user();
        $user->name = $data['name'];
        $user->profile_picture = $data['profile_picture'];
        $user->location = $data['location'];
        $user->save();
        return response()->json([
            'message' => 'Profile updated successfully',
            'user'=>$user
        ]);
    }
}
