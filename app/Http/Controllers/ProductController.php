<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $filters = [
            'q' => trim((string) $request->query('q', '')),
            'sort' => $request->query('sort', 'newest'),
            'min' => $request->query('min'),
            'max' => $request->query('max'),
            'in_stock' => $request->boolean('in_stock'),
        ];

        $query = Product::query()
            ->where('status', 'published');

        if ($filters['q'] !== '') {
            $search = $filters['q'];
            $query->where(function ($q) use ($search) {
                $like = "%{$search}%";
                $q->where('name', 'like', $like)
                    ->orWhere('sku', 'like', $like)
                    ->orWhere('description', 'like', $like);
            });
        }

        if ($filters['in_stock']) {
            $query->where(function ($q) {
                $q->whereNull('stock')
                    ->orWhere('stock', '>', 0);
            });
        }

        if (is_numeric($filters['min'])) {
            $query->where('price', '>=', (float) $filters['min']);
        }

        if (is_numeric($filters['max'])) {
            $query->where('price', '<=', (float) $filters['max']);
        }

        $sort = $filters['sort'];
        if (! in_array($sort, ['newest', 'price_asc', 'price_desc'], true)) {
            $sort = 'newest';
        }
        $filters['sort'] = $sort;

        $query = match ($sort) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            default => $query->orderByDesc('id'),
        };

        $products = $query->paginate(8)->withQueryString();

        return view('products.index', [
            'products' => $products,
            'filters' => $filters,
            'sortOptions' => [
                'newest' => 'Newest',
                'price_asc' => 'Price: Low to High',
                'price_desc' => 'Price: High to Low',
            ],
        ]);
    }

    public function show($id)
    {
        $product = Product::where('id', $id)
            ->where('status', 'published')
            ->firstOrFail();

        return view('products.show', compact('product'));
    }
}