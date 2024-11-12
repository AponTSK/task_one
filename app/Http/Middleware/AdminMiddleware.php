<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::guard('admin')->check())
        {
            return $next($request);
        }

        // If not admin, redirect back
        return redirect()->route('admin.login')->with('error', 'You are not authorized to access this page.');
    }
}
