<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $sellerId = $request->user()->id;
        $products = Product::where('user_id', $sellerId)
            ->orderBy('stock')
            ->orderBy('name')
            ->paginate(15);

        $lowStockThreshold = 5;

        return view('seller.inventory.index', compact('products', 'lowStockThreshold'));
    }
}

