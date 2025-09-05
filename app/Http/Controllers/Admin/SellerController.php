<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'seller');
        if ($q = $request->query('q')) {
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            });
        }
        $sellers = $query->withCount('products')->orderBy('name')->paginate(15)->withQueryString();
        return view('admin.sellers.index', compact('sellers'));
    }

    public function products(User $seller, Request $request)
    {
        abort_unless($seller->role === 'seller', 404);

        $query = Product::where('user_id', $seller->id)->latest();
        if ($q = $request->query('q')) {
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('sku', 'like', "%{$q}%");
            });
        }
        $products = $query->paginate(15)->withQueryString();

        return view('admin.sellers.products', compact('seller', 'products'));
    }
}

