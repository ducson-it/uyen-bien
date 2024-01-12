<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Admin
{
    public function handle(Request $request, Closure $next)
    {
        if(auth()->check() && auth()->user()->isAdmin()) {
            return $next($request);
        }

        return redirect('/'); // Redirect to the home page or any other route
    }
}
