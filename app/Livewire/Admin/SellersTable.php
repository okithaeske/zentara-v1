<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class SellersTable extends Component
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
        return User::query()
            ->where('role', 'seller')
            ->when($this->q !== '', function (Builder $q) {
                $term = '%'.strtolower($this->q).'%';
                $q->where(function (Builder $w) use ($term) {
                    $w->whereRaw('LOWER(name) like ?', [$term])
                      ->orWhereRaw('LOWER(email) like ?', [$term]);
                });
            })
            ->orderBy('name')
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.admin.sellers-table', [
            'sellers' => $this->getRows(),
        ]);
    }
}

