@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-text leading-tight">
        {{ __('Tableau de bord administrateur') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistiques -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-background-light overflow-hidden shadow-dark sm:rounded-2xl border border-background-dark">
                    <div class="p-6 bg-background-light border-b border-background-dark">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-primary bg-opacity-20 text-primary mr-4">
                                <i class="fas fa-book text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-text-light">Livres</h3>
                                <p class="text-2xl font-semibold text-text">{{ $stats['total_books'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-background-light overflow-hidden shadow-dark sm:rounded-2xl border border-background-dark">
                    <div class="p-6 bg-background-light border-b border-background-dark">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-500 bg-opacity-20 text-green-500 mr-4">
                                <i class="fas fa-users text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-text-light">Utilisateurs</h3>
                                <p class="text-2xl font-semibold text-text">{{ $stats['total_users'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-background-light overflow-hidden shadow-dark sm:rounded-2xl border border-background-dark">
                    <div class="p-6 bg-background-light border-b border-background-dark">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-500 bg-opacity-20 text-yellow-500 mr-4">
                                <i class="fas fa-tags text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-text-light">Catégories</h3>
                                <p class="text-2xl font-semibold text-text">{{ $stats['total_categories'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-background-light overflow-hidden shadow-dark sm:rounded-2xl border border-background-dark">
                    <div class="p-6 bg-background-light border-b border-background-dark">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-500 bg-opacity-20 text-purple-500 mr-4">
                                <i class="fas fa-star text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium text-text-light">Avis</h3>
                                <p class="text-2xl font-semibold text-text">{{ $stats['total_reviews'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Derniers livres ajoutés -->
            <div class="bg-background-light overflow-hidden shadow-dark sm:rounded-2xl border border-background-dark mb-8">
                <div class="p-6 bg-background-light border-b border-background-dark">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-text">Derniers livres ajoutés</h3>
                        <a href="{{ route('books.index') }}" class="text-primary hover:text-primary-light text-sm">
                            Voir tous <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                    
                    @if($recentBooks->isEmpty())
                        <p class="text-text-light">Aucun livre ajouté récemment.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-background-dark">
                                <thead class="bg-background">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-text-light uppercase tracking-wider">
                                            Titre
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-text-light uppercase tracking-wider">
                                            Auteur
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-text-light uppercase tracking-wider">
                                            Catégorie
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-text-light uppercase tracking-wider">
                                            Date
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-text-light uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-background-light divide-y divide-background-dark">
                                    @foreach($recentBooks as $book)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-text">{{ $book->title }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-text-light">{{ $book->author }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-primary bg-opacity-20 text-white">
                                                    {{ $book->category->name }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-text-light">{{ $book->created_at->diffForHumans() }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-text-light">
                                                <a href="{{ route('books.show', $book) }}" class="text-primary hover:text-primary-light mr-2">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('books.edit', $book) }}" class="text-yellow-500 hover:text-yellow-400">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Livres les mieux notés -->
            <div class="bg-background-light overflow-hidden shadow-dark sm:rounded-2xl border border-background-dark mb-8">
                <div class="p-6 bg-background-light border-b border-background-dark">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-text">Livres les mieux notés</h3>
                        <a href="{{ route('books.index', ['sort' => 'rating']) }}" class="text-primary hover:text-primary-light text-sm">
                            Voir tous <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                    
                    @if($topRatedBooks->isEmpty())
                        <p class="text-text-light">Aucun livre avec des évaluations.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                            @foreach($topRatedBooks as $book)
                                <div class="border border-background-dark rounded-lg p-4 hover:shadow-dark transition-shadow">
                                    <a href="{{ route('books.show', $book) }}">
                                        <img src="{{ $book->cover ? Storage::url($book->cover) : asset('images/default-cover.jpg') }}" 
                                             alt="{{ $book->title }}" class="w-full h-48 object-cover mb-2">
                                        <h4 class="font-medium text-text">{{ Str::limit($book->title, 20) }}</h4>
                                        <p class="text-sm text-text-light">{{ $book->author }}</p>
                                        <div class="flex items-center mt-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= round($book->reviews_avg_rating) ? 'text-yellow-400' : 'text-text-light' }} text-sm"></i>
                                            @endfor
                                            <span class="text-xs text-text-light ml-1">({{ $book->reviews_count }})</span>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Derniers utilisateurs inscrits -->
            <div class="bg-background-light overflow-hidden shadow-dark sm:rounded-2xl border border-background-dark">
                <div class="p-6 bg-background-light border-b border-background-dark">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-text">Derniers utilisateurs inscrits</h3>
                    </div>
                    
                    @if($recentUsers->isEmpty())
                        <p class="text-text-light">Aucun utilisateur récent.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-background-dark">
                                <thead class="bg-background">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-text-light uppercase tracking-wider">
                                            Nom
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-text-light uppercase tracking-wider">
                                            Email
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-text-light uppercase tracking-wider">
                                            Rôle
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-text-light uppercase tracking-wider">
                                            Inscrit le
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-background-light divide-y divide-background-dark">
                                    @foreach($recentUsers as $user)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-text">{{ $user->name }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-text-light">{{ $user->email }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-purple-500 bg-opacity-20 text-white' : 'bg-primary bg-opacity-20 text-white' }}">
                                                    {{ $user->role === 'admin' ? 'Admin' : 'Utilisateur' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-text-light">{{ $user->created_at->diffForHumans() }}</div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection