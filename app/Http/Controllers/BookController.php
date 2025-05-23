<?php

// app/Http/Controllers/BookController.php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->middleware('can:admin')->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        $query = Book::with(['category', 'reviews']);

        // Recherche par mot-clé
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhere('author', 'like', "%$search%");
            });

            // Enregistrer l'historique de recherche pour les utilisateurs connectés
            if (auth()->check()) {
                auth()->user()->searchHistories()->create([
                    'query' => $search
                ]);
            }
        }

        // Filtre par catégorie
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        // Filtre par statut
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filtre par nombre de pages
        if ($request->has('min_pages')) {
            $query->where('pages', '>=', $request->min_pages);
        }
        if ($request->has('max_pages')) {
            $query->where('pages', '<=', $request->max_pages);
        }

        // Filtre par note
        if ($request->has('min_rating')) {
            $query->whereHas('reviews', function($q) use ($request) {
                $q->selectRaw('avg(rating) as avg_rating')
                  ->havingRaw('avg(rating) >= ?', [$request->min_rating]);
            });
        }

        // Tri
        $sort = $request->get('sort', 'recent');
        switch ($sort) {
            case 'popular':
                $query->withCount('reviews')->orderBy('reviews_count', 'desc');
                break;
            case 'rating':
                $query->withAvg('reviews', 'rating')->orderBy('reviews_avg_rating', 'desc');
                break;
            case 'recent':
            default:
                $query->orderBy('published_at', 'desc');
                break;
        }

        $books = $query->paginate(10);
        $categories = Category::all();

        return view('books.index', compact('books', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'summary' => 'nullable|string|max:2000',
            'pages' => 'required|integer|min:1',
            'published_at' => 'required|date',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:available,borrowed',
        ]);

        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')->store('covers', 'public');
        }

        Book::create($validated);

        return redirect()->route('books.index')->with('success', 'Livre ajouté avec succès!');
    }

    public function show(Book $book)
    {
        $book->load(['category', 'reviews.user']);
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'summary' => 'nullable|string|max:2000',
            'pages' => 'required|integer|min:1',
            'published_at' => 'required|date',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:available,borrowed',
        ]);

        if ($request->hasFile('cover')) {
            // Supprimer l'ancienne image si elle existe
            if ($book->cover) {
                Storage::disk('public')->delete($book->cover);
            }
            $validated['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $book->update($validated);

        return redirect()->route('books.index')->with('success', 'Livre mis à jour avec succès!');
    }

    public function destroy(Book $book)
    {
        if ($book->cover) {
            Storage::disk('public')->delete($book->cover);
        }
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Livre supprimé avec succès!');
    }

    



}