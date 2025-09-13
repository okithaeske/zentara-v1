<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class UsersTable extends Component
{
    use WithPagination;

    #[Url]
    public string $q = '';

    protected $listeners = ['refreshUsers' => '$refresh'];

    public function updatingQ(): void
    {
        $this->resetPage();
    }

    public function toggleBan(int $userId): void
    {
        $me = Auth::id();
        if ($me === $userId) {
            return; // do not ban self
        }
        $user = User::find($userId);
        if (!$user) return;
        $user->banned = (bool)!$user->banned;
        $user->save();
        $this->dispatch('refreshUsers');
        session()->flash('status', $user->banned ? 'User banned.' : 'User unbanned.');
    }

    public function delete(int $userId): void
    {
        $me = Auth::id();
        if ($me === $userId) return;
        $user = User::find($userId);
        if (!$user) return;
        $user->delete();
        $this->resetPage();
        session()->flash('status', 'User deleted.');
    }

    public function getRows()
    {
        return User::query()
            ->when($this->q !== '', function (Builder $q) {
                $term = '%'.strtolower($this->q).'%';
                $q->where(function (Builder $w) use ($term) {
                    $w->whereRaw('LOWER(name) like ?', [$term])
                      ->orWhereRaw('LOWER(email) like ?', [$term])
                      ->orWhereRaw('LOWER(role) like ?', [$term]);
                });
            })
            ->orderByDesc('id')
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.admin.users-table', [
            'users' => $this->getRows(),
        ]);
    }
}

