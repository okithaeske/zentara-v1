<?php

namespace App\Livewire\Cart;

use App\Models\Product;
use Livewire\Attributes\Validate;
use Livewire\Component;

class AddToCart extends Component
{
    public Product $product;

    #[Validate('required|integer|min:1|max:999')]
    public int $qty = 1;

    public function mount(Product $product): void
    {
        $this->product = $product;
    }

    public function add(): void
    {
        $this->validate();
        if ($this->product->status !== 'published') {
            $this->addError('qty', 'This product is not available.');
            return;
        }

        $cart = session('cart', ['items' => [], 'count' => 0, 'subtotal' => 0.0]);
        $items = $cart['items'];
        $existing = $items[$this->product->id]['qty'] ?? 0;
        $newQty = $existing + $this->qty;
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

        // Recompute totals
        $count = 0; $subtotal = 0.0;
        foreach ($cart['items'] as $item) {
            $count += (int)$item['qty'];
            $subtotal += ((float)$item['price']) * (int)$item['qty'];
        }
        $cart['count'] = $count;
        $cart['subtotal'] = round($subtotal, 2);

        session(['cart' => $cart]);

        session()->flash('status', 'Added to cart.');
        $this->dispatch('cart-updated');
    }

    public function render()
    {
        return view('livewire.cart.add-to-cart');
    }
}

