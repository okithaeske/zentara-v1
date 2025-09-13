<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function edit(Request $request, Product $product)
    {
        $return = $request->query('return');
        return view('admin.products.edit', compact('product', 'return'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['required', 'string', 'max:64', 'unique:products,sku,' . $product->id],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'status' => ['nullable', 'in:draft,published'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],
            'remove_image' => ['nullable', 'boolean'],
        ]);

        if ($request->filled('action')) {
            $data['status'] = $request->input('action') === 'publish' ? 'published' : 'draft';
        }

        if ($request->boolean('remove_image')) {
            if ($product->image_path) {
                Storage::delete($product->image_path);
            }
            $data['image_path'] = null;
        }

        if ($request->hasFile('image')) {
            if ($product->image_path) {
                Storage::delete($product->image_path);
            }
            $data['image_path'] = $request->file('image')->store('products');
        }

        $product->update($data);

        $return = $request->input('return');
        return redirect()
            ->route('admin.products.edit', ['product' => $product, 'return' => $return])
            ->with('status', 'Product updated.');
    }

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
