<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {

        $user = User::find(Auth::id());
        $user_role = $user->role->role_name;

        if ($user_role == $role) {
            return $next($request);
        }
        return response()->json(['message' => 'Unauthorized.'], 403);

    }
}
