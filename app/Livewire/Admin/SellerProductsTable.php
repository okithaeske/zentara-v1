<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class SellerProductsTable extends Component
{
    use WithPagination;

    public User $seller;

    #[Url]
    public string $q = '';

    public function mount(User $seller): void
    {
        $this->seller = $seller;
    }

    public function updatingQ(): void
    {
        $this->resetPage();
    }

    public function toggleStatus(int $productId): void
    {
        $product = Product::where('user_id', $this->seller->id)->find($productId);
        if (!$product) return;
        $product->status = $product->status === 'published' ? 'draft' : 'published';
        $product->save();
        session()->flash('status', 'Status updated.');
    }

    public function delete(int $productId): void
    {
        $product = Product::where('user_id', $this->seller->id)->find($productId);
        if (!$product) return;
        $product->delete();
        $this->resetPage();
        session()->flash('status', 'Product deleted.');
    }

    public function getRows()
    {
        return Product::query()
            ->where('user_id', $this->seller->id)
            ->when($this->q !== '', function (Builder $q) {
                $term = '%'.strtolower($this->q).'%';
                $q->where(function (Builder $w) use ($term) {
                    $w->whereRaw('LOWER(name) like ?', [$term])
                      ->orWhereRaw('LOWER(sku) like ?', [$term]);
                });
            })
            ->orderByDesc('id')
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.admin.seller-products-table', [
            'products' => $this->getRows(),
        ]);
    }
}

