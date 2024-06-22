<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class checkUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
{
    Log::info('Middleware CheckUserRole called');
    
    if (Auth::check()) {
        // $userRole = Auth::user()->role;
        $userRole = trim(Auth::user()->role);
        $role = trim($role);

        Log::info('Authenticated user role: ' . $userRole);

        
        if ($userRole === $role) {
            return $next($request);
        } else {
            Log::warning('Unauthorized role: ' . $userRole);
            Log::warning('Required role: ' . $role);
        }
    } else {
        Log::warning('User not authenticated');
    }

    return response()->json(['message' => 'Unauthorized'], 403);
}

}


