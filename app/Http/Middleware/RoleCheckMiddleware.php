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
        dd($user);
      
        if ($user->hasAccess($jobType, $access)) {
            return $next($request);
        }
        return error('Unauthorized access.',403);
    }
    
        // return error('Unauthorized access.', 403);
    }