<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function updateStatus(Request $request, Product $product)
    {
        $data = $request->validate([
            'status' => ['required', 'in:draft,published'],
        ]);
        $product->update(['status' => $data['status']]);
        return back()->with('status', 'Product status updated.');
    }

    public function destroy(Product $product)
    {
        if ($product->orderItems()->exists()) {
            return back()->withErrors('Cannot delete a product that has order history.');
        }
        if ($product->image_path) {
            Storage::delete($product->image_path);
        }
        $product->delete();
        return back()->with('status', 'Product deleted.');
    }
}
