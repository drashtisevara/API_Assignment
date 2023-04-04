<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;



class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        dd($user);

        $roleId = DB::table('user_role')
            ->where('user_id', $user->id)
            ->value('role_id');

        $hasPermission = DB::table('permissions')
            ->join('permisionmodels', 'permissions.id', '=', 'permisionmodels.permission_id')
            ->join('modules', 'permisionmodels.module_id', '=', 'modules.id')
            ->join('role_permission', 'permissions.id', '=', 'role_permission.permission_id')
            ->where('role_permission.role_id', $roleId)
            ->where('permissions.name', $permission)
            ->where('modules.name', Route::getCurrentRoute()->getName())
            ->exists();

        if (!$hasPermission) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
   