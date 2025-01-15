<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyerAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
         if (!Auth::check() || Auth::user()->type !== 'buyer') {
            return redirect()->route('home')->with('error', 'Unauthorized access.'); // Redirect if not buyer. Make sure you have a login route named portal. If not replace it with your login route name
        }

        return $next($request);
    }
}
