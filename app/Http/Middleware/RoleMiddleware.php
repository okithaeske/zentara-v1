<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        $user = $request->user();

        // Support multiple roles e.g. 'seller,admin' or 'seller|admin'
        $allowed = preg_split('/[|,]/', $roles);
        $allowed = array_map('trim', $allowed);

        $role = $user && method_exists($user, 'getAttribute') ? $user->getAttribute('role') : null;
        if (!$user || !in_array((string) $role, $allowed, true)) {
            abort(403);
        }
        $banned = $user && method_exists($user, 'getAttribute') ? (bool) $user->getAttribute('banned') : false;
        if ($banned) {
            abort(403, 'Account is disabled.');
        }
        return $next($request);
    }
}
