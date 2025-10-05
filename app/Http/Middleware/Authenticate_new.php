<?php
// In app/Http/Middleware/Authenticate.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
   /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        
        $guards = empty($guards) ? [null] : $guards;
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect('/'); // Redirect to a route for unauthenticated users
            }
        }
        return $next($request); // Proceed to the next middleware or the intended route
   

    //    // Check if the user is authenticated
    //     if (!Auth::check()) {
    //         // Allow the user to proceed to the next request/route
    //         return redirect('/')->with('message', 'Unauthorized User. You need to log in to access this page.');
    //     }

    
    //     return $next($request); // Proceed to the next middleware or the intended route

       

    }
}

