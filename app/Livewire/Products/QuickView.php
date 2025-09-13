<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Livewire\Component;

class QuickView extends Component
{
    public bool $open = false;
    public ?Product $product = null;
    public int $qty = 1;

    protected $listeners = [
        'quick-view-open' => 'openModal',
    ];

    public function openModal($payload): void
    {
        $id = is_array($payload) ? ($payload['id'] ?? null) : $payload;
        if ($id) {
            $this->product = Product::find($id);
            $this->qty = 1;
            $this->open = $this->product !== null;
        }
    }

    public function close(): void
    {
        $this->open = false;
    }

    public function addToCart(): void
    {
        if (!$this->product) return;
        $qty = max(1, min(999, (int) $this->qty));

        $cart = session('cart', ['items' => [], 'count' => 0, 'subtotal' => 0.0]);
        $items = $cart['items'];
        $existing = $items[$this->product->id]['qty'] ?? 0;
        $newQty = $existing + $qty;
        if (!is_null($this->product->stock) && $newQty > (int)$this->product->stock) {
            $newQty = (int)$this->product->stock;
        }
        $items[$this->product->id] = [
            'id' => $this->product->id,
            'name' => $this->product->name,
            'price' => (float) $this->product->price,
            'qty' => $newQty,
            'image' => $this->product->image_path,
            'sku' => $this->product->sku,
        ];
        $cart['items'] = $items;

        $count = 0; $subtotal = 0.0;
        foreach ($cart['items'] as $item) { $count += (int)$item['qty']; $subtotal += (float)$item['price'] * (int)$item['qty']; }
        $cart['count'] = $count; $cart['subtotal'] = round($subtotal, 2);
        session(['cart' => $cart]);

        $this->dispatch('cart-updated');
        $this->dispatch('toast', ['message' => 'Added to cart.']);
        $this->close();
    }

    public function render()
    {
        return view('livewire.products.quick-view');
    }
}

