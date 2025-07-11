<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and has the 'admin' role
        if (auth()->guard('admin')->check()) {
            return $next($request);
        }

        // If not authenticated, redirect to the login page
        return redirect()->route('admin.login');
    }
}
