<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // GET /api/users
    public function index(Request $request)
    {
        $query = User::query();

        if ($role = $request->query('role')) {
            $query->where('role', $role);
        }

        if ($search = $request->query('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if (in_array($request->query('include'), ['products_count', 'products-count', 'count:products'])) {
            $query->withCount('products');
        }

        $perPage = (int) $request->query('per_page', 15);
        $perPage = max(1, min($perPage, 100));

        $users = $query
            ->orderBy('name')
            ->select(['id', 'name', 'email', 'role'])
            ->paginate($perPage)
            ->withQueryString();

        return response()->json($users);
    }

    // GET /api/users/{user}
    public function show(User $user, Request $request)
    {
        $user->setVisible(['id', 'name', 'email', 'role']);

        if (in_array($request->query('include'), ['products_count', 'products-count', 'count:products'])) {
            $user->loadCount('products');
        }

        return response()->json($user);
    }
}

