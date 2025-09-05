<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DisallowAdminShopping
{
    /**
     * Prevent admin users from accessing cart/checkout actions.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $role = $request->user()?->getAttribute('role');
        if ($role === 'admin') {
            abort(403, 'Admins cannot perform shopping actions.');
        }
        return $next($request);
    }
}

