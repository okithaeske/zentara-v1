<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        if ($search = $request->query('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        $users = $query->orderByDesc('id')->paginate(15)->withQueryString();
        return view('admin.users.index', compact('users'));
    }

    public function toggleBan(User $user)
    {
        $user->banned = !$user->banned;
        $user->save();
        return redirect()->back()->with('status', $user->banned ? 'User banned.' : 'User unbanned.');
    }
}

