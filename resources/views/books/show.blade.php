@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-text leading-tight">
        <a href="{{ route('books.index') }}" class="text-primary hover:text-primary-light">Livres</a> / {{ $book->title }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-5xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="bg-background-light shadow-dark rounded-2xl overflow-hidden flex flex-col md:flex-row gap-0 md:gap-8 relative">
                <!-- Book Cover -->
                <div class="flex-shrink-0 flex justify-center items-start md:items-center md:pl-8 pt-8 md:pt-0 bg-background-light">
                    <div class="relative -mt-16 md:mt-0 md:-ml-16 z-10">
                        <img src="{{ $book->cover ? Storage::url($book->cover) : asset('images/default-cover.jpg') }}"
                             alt="{{ $book->title }}"
                             class="w-44 h-64 object-cover rounded-xl shadow-2xl border-4 border-background-light bg-background transition-transform duration-300 hover:scale-105">
                    </div>
                </div>
                <!-- Book Info & Details -->
                <div class="flex-1 p-8 flex flex-col justify-between">
                    <div>
                        <div class="flex flex-wrap items-center gap-2 mb-2">
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-secondary text-text-light uppercase tracking-wide">
                                {{ $book->category->name }}
                            </span>
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold {{ $book->status == 'available' ? 'bg-green-700 text-white' : 'bg-accent text-white' }}">
                                {{ $book->status == 'available' ? 'Disponible' : 'Emprunté' }}
                            </span>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-extrabold text-text mb-2 leading-tight">{{ $book->title }}</h1>
                        <div class="flex items-center gap-2 mb-4">
                            <span class="text-lg font-semibold text-primary">{{ $book->author }}</span>
                            <span class="text-text-light text-sm">• {{ $book->pages }} pages</span>
                            <span class="text-text-light text-sm">• Publié le {{ $book->published_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex items-center gap-2 mb-4">
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= round($book->average_rating) ? 'text-yellow-500' : 'text-text-light' }} text-lg"></i>
                                @endfor
                            </div>
                            <span class="text-text-light text-sm">({{ $book->reviews->count() }} avis)</span>
                            <span class="ml-2 text-text-light text-sm font-semibold">{{ number_format($book->average_rating, 1) }}/5</span>
                        </div>
                        <div class="prose prose-invert max-w-none text-text mb-6">
                            {!! nl2br(e($book->summary)) !!}
                        </div>
                    </div>
                    <!-- Actions for admin -->
                    @can('admin')
                        <div class="flex gap-2 mt-4">
                            <a href="{{ route('books.edit', $book) }}"
                               class="bg-yellow-600 text-background px-4 py-2 rounded-md hover:bg-yellow-700 font-semibold transition-all flex items-center gap-1">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            <form action="{{ route('books.destroy', $book) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-accent text-white px-4 py-2 rounded-md hover:bg-accent-dark font-semibold transition-all flex items-center gap-1"
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?')">
                                    <i class="fas fa-trash"></i> Supprimer
                                </button>
                            </form>
                        </div>
                    @endcan
                </div>
            </div>
            <!-- Détails et commentaires -->
            <div class="max-w-5xl mx-auto mt-10">
                <!-- Formulaire d'avis et commentaires (leave as is, already modernized) -->
                @auth
                    @unless($book->reviews->where('user_id', auth()->id())->count())
                        <div class="bg-background p-4 rounded-lg mb-6 border border-background-dark">
                            <h4 class="font-semibold mb-3 text-text">Donnez votre avis</h4>
                            <form action="{{ route('reviews.store', $book) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-text-light mb-1">Note</label>
                                    <div x-data="{ rating: 3, hover: 0 }" class="flex space-x-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <button type="button"
                                                @click="rating = {{ $i }}"
                                                @mouseover="hover = {{ $i }}"
                                                @mouseleave="hover = 0"
                                                :class="[ (hover >= {{ $i }} || (!hover && rating >= {{ $i }})) ? 'text-yellow-500' : 'text-text-light', 'text-2xl', 'transition-colors', 'focus:outline-none' ]">
                                                <i class="fas fa-star"></i>
                                            </button>
                                        @endfor
                                        <input type="hidden" name="rating" :value="rating">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="comment" class="block text-sm font-medium text-text-light mb-1">Commentaire (optionnel)</label>
                                    <textarea name="comment" id="comment" rows="3"
                                        class="w-full rounded-md bg-background border-background-dark text-text focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition-all"></textarea>
                                </div>
                                <button type="submit" class="bg-primary text-background px-4 py-2 rounded-md hover:bg-primary-light transition-all">
                                    Envoyer l'avis
                                </button>
                            </form>
                        </div>
                    @endunless
                @endauth
                <!-- Liste des commentaires -->
                <div>
                    <h4 class="font-semibold mb-3 text-text">Avis des lecteurs ({{ $book->reviews->count() }})</h4>
                    @if($book->reviews->isEmpty())
                        <p class="text-text-light">Aucun avis pour ce livre pour le moment.</p>
                    @else
                        <div class="space-y-4">
                            @foreach($book->reviews as $review)
                                <div class="border-b border-background-dark pb-4">
                                    <div class="flex justify-between items-start">
                                        <div class="flex items-center">
                                            @if($review->user->avatar)
                                                <img src="{{ Storage::url($review->user->avatar) }}"
                                                    alt="{{ $review->user->name }}" class="w-10 h-10 rounded-full mr-2">
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-background-light flex items-center justify-center mr-2 border border-background-dark">
                                                    <i class="fas fa-user text-text-light"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="font-medium text-text">{{ $review->user->name }}</div>
                                                <div class="text-xs text-text-light">{{ $review->created_at->diffForHumans() }}</div>
                                            </div>
                                        </div>
                                        <div class="flex">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-500' : 'text-text-light' }} text-sm"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    @if($review->comment)
                                        <div class="mt-2 pl-12 text-text">
                                            {{ $review->comment }}
                                        </div>
                                    @endif
                                    <!-- Bouton de suppression -->
                                    @if(auth()->id() === $review->user_id || auth()->user()->isAdmin())
                                        <div class="mt-2 pl-12">
                                            <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="text-accent hover:text-accent-dark text-xs"
                                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet avis ?')">
                                                    <i class="fas fa-trash mr-1"></i> Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection