<?php

// app/Http/Controllers/AdminController.php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Category;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:admin');
    }

    public function dashboard()
    {
        $stats = [
            'total_books' => Book::count(),
            'total_users' => User::count(),
            'total_categories' => Category::count(),
            'total_reviews' => Review::count(),
        ];

        $recentBooks = Book::with('category')->latest()->take(5)->get();
        $topRatedBooks = Book::withAvg('reviews', 'rating')
            ->orderBy('reviews_avg_rating', 'desc')
            ->take(5)
            ->get();

        $recentUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentBooks', 'topRatedBooks', 'recentUsers'));
    }
}