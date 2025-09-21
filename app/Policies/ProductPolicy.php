<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    public function view(?User $user, Product $product): bool
    {
        if ($product->status === 'published') {
            return true;
        }
        if ($user === null) {
            return false;
        }
        return $user->id === $product->user_id || $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isSeller() || $user->isAdmin();
    }

    public function update(User $user, Product $product): bool
    {
        return $user->id === $product->user_id || $user->isAdmin();
    }

    public function delete(User $user, Product $product): bool
    {
        return $user->id === $product->user_id || $user->isAdmin();
    }
}

