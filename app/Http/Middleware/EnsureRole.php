<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\NullableType;

class EnsureRole
{
    /**
     * Handle an incoming request.
     *
     *
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('/login'); // Redirect to login if user is not authenticated
        }

        // Get user roles as an array of role names
        $userRoles = Auth::user()->roles->pluck('name')->toArray();
        // Check if the user has the required role
        if (!in_array($role, $userRoles)) {
            return redirect('/unauthorized'); // Redirect to unauthorized page if user does not have the required role
        }

        return $next($request);
    }
}
