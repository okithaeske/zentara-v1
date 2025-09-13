<?php

namespace App\Livewire\Seller;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ProductsTable extends Component
{
    use WithPagination;

    #[Url]
    public string $q = '';

    #[Url]
    public string $status = '';

    public function updatingQ(): void { $this->resetPage(); }
    public function updatingStatus(): void { $this->resetPage(); }

    public function delete(int $productId): void
    {
        $product = Product::where('user_id', Auth::id())->find($productId);
        if ($product) {
            $product->delete();
            $this->resetPage();
            session()->flash('status', 'Product deleted.');
        }
    }

    public function getRows()
    {
        return Product::query()
            ->where('user_id', Auth::id())
            ->when($this->q !== '', function (Builder $q) {
                $term = '%'.strtolower($this->q).'%';
                $q->where(function (Builder $w) use ($term) {
                    $w->whereRaw('LOWER(name) like ?', [$term])
                      ->orWhereRaw('LOWER(sku) like ?', [$term]);
                });
            })
            ->when($this->status !== '', fn ($q) => $q->where('status', $this->status))
            ->orderByDesc('id')
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.seller.products-table', [
            'products' => $this->getRows(),
        ]);
    }
}

