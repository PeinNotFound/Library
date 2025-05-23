<?php

// app/Http/Controllers/ReviewController.php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Book $book)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Vérifier si l'utilisateur a déjà commenté ce livre
        if ($book->reviews()->where('user_id', auth()->id())->exists()) {
            return back()->with('error', 'Vous avez déjà commenté ce livre.');
        }

        $book->reviews()->create([
            'user_id' => auth()->id(),
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
        ]);

        return back()->with('success', 'Votre avis a été enregistré!');
    }

    public function destroy(Review $review)
    {
        // Seul l'auteur du commentaire ou un admin peut le supprimer
        if (auth()->id() !== $review->user_id && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $review->delete();
        return back()->with('success', 'Avis supprimé avec succès!');
    }
}