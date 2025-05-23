<?php

// app/Policies/CategoryPolicy.php
namespace App\Policies;

use App\Models\User;
use App\Models\Category;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->isAdmin();
    }

    public function update(User $user, Category $category)
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Category $category)
    {
        return $user->isAdmin();
    }
}