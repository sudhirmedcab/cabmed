<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('admin')->check()) {
            session()->flash('access_error', 'You must be logged in as an admin to access this page.');
            return redirect()->route('login.processing'); // Redirect to the admin login route if not authenticated
        }

        return $next($request);
    }
}
