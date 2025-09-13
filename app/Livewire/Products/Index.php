<?php

namespace App\Livewire\Products;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url]
    public string $q = '';

    public function updatingQ(): void
    {
        $this->resetPage();
    }

    public function getRows()
    {
        return Product::query()
            ->where('status', 'published')
            ->when($this->q !== '', function (Builder $q) {
                $term = '%'.strtolower($this->q).'%';
                $q->where(function (Builder $w) use ($term) {
                    $w->whereRaw('LOWER(name) like ?', [$term])
                      ->orWhereRaw('LOWER(sku) like ?', [$term])
                      ->orWhereRaw('LOWER(description) like ?', [$term]);
                });
            })
            ->orderByDesc('id')
            ->paginate(12);
    }

    public function render()
    {
        return view('livewire.products.index', [
            'products' => $this->getRows(),
        ]);
    }
}

