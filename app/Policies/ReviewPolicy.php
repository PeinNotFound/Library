<?php

// app/Policies/ReviewPolicy.php
namespace App\Policies;

use App\Models\User;
use App\Models\Review;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReviewPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return true;
    }

    public function delete(User $user, Review $review)
    {
        return $user->id === $review->user_id || $user->isAdmin();
    }
}