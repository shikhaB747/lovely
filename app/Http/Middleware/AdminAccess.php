<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAccess
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
        // Check if the user is authenticated
        if (Auth::check()) {
            $user = Auth::user();

//  dd($user);
            
            // Check if the user has the admin role
            if ($user->id === '1') {
                return $next($request);
            }

            // If user is not admin, redirect to home with an error message
            return redirect('/')->with('error', 'You do not have admin access.');
        }

        // If user is not authenticated, redirect to login page
        return redirect('/login')->with('error', 'Please login to access this page.');
    }
}
