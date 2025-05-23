<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Review;
use App\Models\SearchHistory;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show()
    {
        /** @var User $user */
        $user = Auth::user();
        
        // Eager load relationships with pagination
        $reviews = $user->reviews()
            ->with(['book' => function($query) {
                $query->select('id', 'title');
            }])
            ->latest()
            ->paginate(5);
            
        $searchHistory = $user->searchHistories()
            ->latest()
            ->paginate(5);
        
        return view('profile.show', compact('user', 'reviews', 'searchHistory'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            // Delete old avatar if it exists
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($validated);

        return redirect()->route('profile.show')
            ->with('success', 'Profil mis à jour avec succès!');
    }
}