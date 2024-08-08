<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return in_array($user->role->name, ['admin', 'user']);
    }

    public function view(User $user, Product $product)
    {
        return in_array($user->role->name, ['admin', 'user']);
    }

    public function create(User $user)
    {
        return $user->role->name === 'admin';
    }

    public function update(User $user, Product $product)
    {
        return $user->role->name === 'admin';
    }

    public function delete(User $user, Product $product)
    {
        return $user->role->name === 'admin';
    }
}
