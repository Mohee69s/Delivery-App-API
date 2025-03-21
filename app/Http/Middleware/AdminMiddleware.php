<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('admin')->check()) {
            $user=Auth::guard('admin')->user();
            if($user->is_admin)
            return $next($request);
            else
                return redirect('/admin/login');
        }

        return redirect('/admin/login');

    }
}
