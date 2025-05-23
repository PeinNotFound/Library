<?php

namespace App\Providers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Review;
use App\Policies\BookPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\ReviewPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    // app/Providers/AuthServiceProvider.php
protected $policies = [
    Book::class => BookPolicy::class,
    Category::class => CategoryPolicy::class,
    Review::class => ReviewPolicy::class,
];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
{
    

    Gate::define('admin', function ($user) {
        return $user->role === 'admin';
    });
}
}
