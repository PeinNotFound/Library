<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Models\Book;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Page d'accueil publique
Route::get('/', function () {
    $recentBooks = Book::with(['category', 'reviews'])
        ->latest()
        ->take(5)
        ->get();
    
    $popularBooks = Book::withCount('reviews')
        ->orderBy('reviews_count', 'desc')
        ->take(5)
        ->get();
    
    return view('welcome', compact('recentBooks', 'popularBooks'));
})->name('welcome');

// Authentification (Laravel Breeze)
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.update');
});


Route::middleware('auth')->group(function () {
    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])
                ->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
                
    // Profil utilisateur
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/', [ProfileController::class, 'update'])->name('profile.update');
    });
});

// Routes publiques pour les livres
Route::resource('books', BookController::class)->only(['index', 'show']);

// Routes authentifiées
Route::middleware(['auth'])->group(function () {
    // Avis sur les livres
    Route::post('books/{book}/reviews', [ReviewController::class, 'store'])
        ->name('reviews.store');
    Route::delete('reviews/{review}', [ReviewController::class, 'destroy'])
        ->name('reviews.destroy');
});


// Routes admin
Route::middleware(['auth', 'can:admin'])->group(function () {
    // Tableau de bord admin
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Gestion complète des livres (admin)
    Route::resource('admin/books', BookController::class)->except(['index', 'show']);

    // Gestion des catégories
    Route::resource('categories', CategoryController::class)->except(['show']);

    // Import/Export de livres (optionnel)
    Route::get('admin/books/import', [BookController::class, 'showImportForm'])->name('admin.books.import.show');
    Route::post('admin/books/import', [BookController::class, 'import'])->name('admin.books.import');
    Route::get('admin/books/export', [BookController::class, 'export'])->name('admin.books.export');
    // The create route is now handled by the resource route above
    // The store route is now handled by the resource route above
});