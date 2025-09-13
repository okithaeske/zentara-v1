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

    #[Url]
    public string $sort = 'newest'; // newest, price_asc, price_desc

    #[Url]
    public ?int $min = null;

    #[Url]
    public ?int $max = null;

    #[Url]
    public bool $inStock = false;

    public function updatingQ(): void
    {
        $this->resetPage();
    }

    public function updatingSort(): void { $this->resetPage(); }
    public function updatingMin(): void { $this->resetPage(); }
    public function updatingMax(): void { $this->resetPage(); }
    public function updatingInStock(): void { $this->resetPage(); }

    public function getRows()
    {
        $query = Product::query()
            ->where('status', 'published')
            ->when($this->q !== '', function (Builder $q) {
                $term = '%'.strtolower($this->q).'%';
                $q->where(function (Builder $w) use ($term) {
                    $w->whereRaw('LOWER(name) like ?', [$term])
                      ->orWhereRaw('LOWER(sku) like ?', [$term])
                      ->orWhereRaw('LOWER(description) like ?', [$term]);
                });
            })
            ->when($this->inStock, fn ($q) => $q->where(function ($w) { $w->whereNull('stock')->orWhere('stock', '>', 0); }))
            ->when($this->min !== null, fn ($q) => $q->where('price', '>=', $this->min))
            ->when($this->max !== null, fn ($q) => $q->where('price', '<=', $this->max));

        $query = match ($this->sort) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            default => $query->orderByDesc('id'),
        };

        return $query->paginate(12);
    }

    public function render()
    {
        return view('livewire.products.index', [
            'products' => $this->getRows(),
        ]);
    }
}
