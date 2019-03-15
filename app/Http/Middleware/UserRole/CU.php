<?php

namespace App\Http\Middleware\UserRole;

use Closure;

class CU
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
        if (\App\User::with('userRole')->findOrFail(\Auth::id())->userRole->name === 'CU') {
            return $next($request);
        }

        return response()->json('user_not_contact', 403);
    }
}
