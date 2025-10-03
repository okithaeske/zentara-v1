<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::query()
            ->where('status', 'published')
            ->latest()
            ->take(4)
            ->get();

        return view('pages.home', [
            'featuredProducts' => $featuredProducts,
        ]);
    }
}
