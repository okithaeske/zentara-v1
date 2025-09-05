<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected function cart()
    {
        return session()->get('cart', [
            'items' => [], // product_id => [id,name,price,qty,image]
            'count' => 0,
            'subtotal' => 0,
        ]);
    }

    protected function saveCart($cart)
    {
        // Recompute count and subtotal
        $count = 0; $subtotal = 0.0;
        foreach ($cart['items'] as $item) {
            $count += $item['qty'];
            $subtotal += $item['price'] * $item['qty'];
        }
        $cart['count'] = $count;
        $cart['subtotal'] = round($subtotal, 2);
        session(['cart' => $cart]);
    }

    public function index()
    {
        $cart = $this->cart();
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'qty' => ['nullable', 'integer', 'min:1', 'max:999'],
        ]);

        if ($product->status !== 'published') {
            return back()->withErrors('This product is not available.');
        }

        $qty = (int) ($request->input('qty', 1));
        if ($product->stock !== null && $product->stock < $qty) {
            return back()->withErrors('Not enough stock for this product.');
        }

        $cart = $this->cart();
        $items = $cart['items'];
        $existing = $items[$product->id]['qty'] ?? 0;
        $newQty = $existing + $qty;
        if ($product->stock !== null && $newQty > $product->stock) {
            $newQty = $product->stock;
        }

        $items[$product->id] = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => (float) $product->price,
            'qty' => $newQty,
            'image' => $product->image_path,
            'sku' => $product->sku,
        ];
        $cart['items'] = $items;
        $this->saveCart($cart);

        return redirect()->route('cart.index')->with('status', 'Added to cart.');
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'qty' => ['required', 'integer', 'min:0', 'max:999'],
        ]);

        $cart = $this->cart();
        $items = $cart['items'];

        if (!isset($items[$product->id])) {
            return back()->withErrors('Item not in cart.');
        }

        if ((int)$data['qty'] === 0) {
            unset($items[$product->id]);
        } else {
            $qty = (int) $data['qty'];
            if ($product->stock !== null && $qty > $product->stock) {
                $qty = $product->stock;
            }
            $items[$product->id]['qty'] = $qty;
        }

        $cart['items'] = $items;
        $this->saveCart($cart);
        return back()->with('status', 'Cart updated.');
    }

    public function remove(Product $product)
    {
        $cart = $this->cart();
        $items = $cart['items'];
        unset($items[$product->id]);
        $cart['items'] = $items;
        $this->saveCart($cart);
        return back()->with('status', 'Item removed.');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('status', 'Cart cleared.');
    }
}

