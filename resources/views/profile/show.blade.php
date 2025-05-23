@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-text leading-tight">
        {{ __('Mon profil') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-background-light overflow-hidden shadow-dark sm:rounded-2xl">
                <div class="p-8 bg-background-light border-b border-background-dark">
                    <div class="flex flex-col md:flex-row gap-10">
                        <!-- Informations utilisateur -->
                        <div class="w-full md:w-1/3">
                            <div class="bg-background p-8 rounded-2xl shadow-dark border border-background-dark flex flex-col items-center">
                                @if($user->avatar)
                                    <img src="{{ Storage::url($user->avatar) }}" 
                                         alt="{{ $user->name }}" 
                                         class="w-36 h-36 rounded-full mb-4 object-cover ring-4 ring-primary"
                                         onerror="this.onerror=null;this.src='https://via.placeholder.com/150';">
                                @else
                                    <div class="w-36 h-36 rounded-full bg-background-light flex items-center justify-center mb-4 border-4 border-background-dark">
                                        <i class="fas fa-user text-text-light text-5xl"></i>
                                    </div>
                                @endif

                                <h3 class="text-2xl font-bold text-text mb-1">{{ $user->name }}</h3>
                                <p class="text-text-light mb-2">{{ $user->email }}</p>
                                <span class="mt-2 px-4 py-1 rounded-full text-xs font-semibold tracking-wide
                                    {{ $user->role == 'admin' ? 'bg-purple-700 text-white' : 'bg-primary text-background' }}">
                                    {{ $user->role == 'admin' ? 'Administrateur' : 'Utilisateur' }}
                                </span>

                                <div class="mt-8 w-full">
                                    <h4 class="font-semibold mb-3 text-text">Statistiques</h4>
                                    <div class="grid grid-cols-1 gap-3">
                                        <div class="flex justify-between items-center bg-background-light rounded-lg px-4 py-2 border border-background-dark">
                                            <span class="text-text-light">Avis postés</span>
                                            <span class="font-bold text-text">{{ $user->reviews->count() }}</span>
                                        </div>
                                        <div class="flex justify-between items-center bg-background-light rounded-lg px-4 py-2 border border-background-dark">
                                            <span class="text-text-light">Recherches</span>
                                            <span class="font-bold text-text">{{ $user->searchHistories->count() }}</span>
                                        </div>
                                        <div class="flex justify-between items-center bg-background-light rounded-lg px-4 py-2 border border-background-dark">
                                            <span class="text-text-light">Membre depuis</span>
                                            <span class="font-bold text-text">{{ $user->created_at->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-8 w-full">
                                    <a href="{{ route('profile.edit') }}" 
                                       class="w-full bg-primary text-background px-4 py-2 rounded-md hover:bg-primary-light transition-all text-center block font-semibold shadow-dark">
                                        <i class="fas fa-edit mr-1"></i> Modifier le profil
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Historique et activités -->
                        <div class="w-full md:w-2/3">
                            <!-- Derniers avis -->
                            <div class="mb-10">
                                <h3 class="text-lg font-bold mb-4 text-text">Mes derniers avis</h3>
                                @if($reviews->isEmpty())
                                    <p class="text-text-light">Vous n'avez pas encore posté d'avis.</p>
                                @else
                                    <div class="space-y-4">
                                        @foreach($reviews as $review)
                                            <div class="border-b border-background-dark pb-4">
                                                <div class="flex justify-between">
                                                    <a href="{{ route('books.show', $review->book) }}" class="font-semibold text-primary hover:text-primary-light transition-all">
                                                        {{ $review->book->title }}
                                                    </a>
                                                    <div class="flex">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-500' : 'text-text-light' }} text-sm"></i>
                                                        @endfor
                                                    </div>
                                                </div>
                                                @if($review->comment)
                                                    <p class="mt-1 text-text">{{ Str::limit($review->comment, 100) }}</p>
                                                @endif
                                                <p class="mt-1 text-sm text-text-light">{{ $review->created_at->diffForHumans() }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="mt-4">
                                        <a href="#" class="text-primary hover:text-primary-light text-sm font-semibold transition-all">
                                            Voir tous mes avis <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Historique de recherche -->
                            <div>
                                <h3 class="text-lg font-bold mb-4 text-text">Mon historique de recherche</h3>
                                @if($searchHistory->isEmpty())
                                    <p class="text-text-light">Aucune recherche récente.</p>
                                @else
                                    <div class="space-y-2">
                                        @foreach($searchHistory as $search)
                                            <div class="flex justify-between items-center py-2 border-b border-background-dark">
                                                <a href="{{ route('books.index', ['search' => $search->query]) }}" 
                                                   class="text-primary hover:text-primary-light font-semibold transition-all">
                                                    {{ $search->query }}
                                                </a>
                                                <span class="text-sm text-text-light">{{ $search->created_at->diffForHumans() }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="mt-4">
                                        <a href="#" class="text-primary hover:text-primary-light text-sm font-semibold transition-all">
                                            Voir tout l'historique <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
