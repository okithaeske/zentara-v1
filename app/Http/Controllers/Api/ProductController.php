<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // GET /api/products
    public function index(Request $request)
    {
        $query = Product::query()
            ->with(['user:id,name,email'])
            ->where('status', 'published')
            ->latest();

        if ($search = $request->query('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if ($sellerId = $request->query('seller_id')) {
            $query->where('user_id', $sellerId);
        }

        if ($seller = $request->query('seller')) {
            $query->whereHas('user', function ($uq) use ($seller) {
                $uq->where('name', 'like', "%{$seller}%")
                   ->orWhere('email', 'like', "%{$seller}%");
            });
        }

        $perPage = (int) $request->query('per_page', 15);
        $perPage = max(1, min($perPage, 100));

        $products = $query->paginate($perPage)->withQueryString();

        return response()->json($products);
    }
}

