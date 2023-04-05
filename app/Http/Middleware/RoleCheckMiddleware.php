<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class RoleCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $jobType, $access)
    {
        $user = auth()->user();
      
        if($user->hasAccess($jobType, $access)) {
            // User has permission, continue to the next middleware or route handler
            return $next($request);
        } else {
            // User does not have permission, return a 403 Forbidden response
            return response('You do not have permission to access this module', 403);
        }
    }
}