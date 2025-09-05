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

    public function toggleBan(Request $request, User $user)
    {
        $currentId = $request->user()?->getKey();
        if ($currentId === $user->getKey()) {
            return redirect()->back()->withErrors('You cannot ban yourself.');
        }
        $newBanned = !((bool) $user->getAttribute('banned'));
        $user->setAttribute('banned', $newBanned);
        $user->save();
        return redirect()->back()->with('status', $newBanned ? 'User banned.' : 'User unbanned.');
    }

    public function destroy(Request $request, User $user)
    {
        $currentId = $request->user()?->getKey();
        if ($currentId === $user->getKey()) {
            return redirect()->back()->withErrors('You cannot delete yourself.');
        }
        // Optionally prevent deleting other admins
        // if ($user->role === 'admin') {
        //     return redirect()->back()->withErrors('Cannot delete an admin account.');
        // }
        $user->delete();
        return redirect()->route('admin.users.index')->with('status', 'User deleted.');
    }
}
