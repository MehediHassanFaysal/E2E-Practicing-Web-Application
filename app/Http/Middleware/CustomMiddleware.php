<?php
// app/Http/Middleware/CustomMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CustomMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            // Redirect to home page if not authenticated
            return redirect('/');
        }

        return $next($request); // Pass the request to the next middleware or controller
    }
}
