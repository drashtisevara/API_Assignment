<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;

class JobMiddleware
{
    public function handle(Request $request, Closure $next)
    {
       
    
        $permission_module = 'jobs'; // The permission module you want to check for
        $permission = 'view_jobs'; // The permission you want to check for
        $role = 'teacher'; // The role you want to check for

        if (auth()->check() && auth()->user()->hasRole($role) && auth()->user()->hasPermissionTo($permission, $permission_module)) {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}