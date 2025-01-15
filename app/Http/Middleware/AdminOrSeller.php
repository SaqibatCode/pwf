<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOrSeller
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || (!in_array(Auth::user()->type, ['admin', 'seller']))) {
            return redirect()->route('home')->with('error', 'Unauthorized access.');
        }

        return $next($request);
    }
}
