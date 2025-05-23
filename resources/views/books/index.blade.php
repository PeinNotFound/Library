@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-text leading-tight">
        {{ __('Liste des livres') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-background-light overflow-hidden shadow-dark sm:rounded-lg">
                <div class="p-6 bg-background-light border-b border-background-dark">
                    <!-- Filtres et recherche -->
                    <div class="mb-6">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-4">
                            <!-- Barre de recherche -->
                            <form method="GET" action="{{ route('books.index') }}" class="w-full md:w-auto">
                                <div class="flex">
                                    <input type="text" name="search" placeholder="Rechercher..." 
                                           class="rounded-l-md bg-background border-background-dark focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition-all text-text placeholder-text-light"
                                           value="{{ request('search') }}">
                                    <button type="submit" class="bg-primary text-background px-4 py-2 rounded-r-md hover:bg-primary-light transition-all">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>

                            <!-- Bouton d'ajout pour admin -->
                            @can('admin')
                                <a href="{{ route('books.create') }}" class="bg-green-700 text-white px-4 py-2 rounded-md hover:bg-green-800 transition-all">
                                    <i class="fas fa-plus mr-1"></i> Ajouter un livre
                                </a>
                            @endcan
                        </div>

                        <!-- Filtres avancés -->
                        <div x-data="{ open: false }" class="mb-4">
                            <button @click="open = !open" class="text-primary hover:text-primary-light text-sm font-medium transition-all">
                                <i class="fas fa-filter mr-1"></i> Filtres avancés
                            </button>
                            
                            <div x-show="open" x-transition class="bg-background p-4 mt-2 rounded-md border border-background-dark">
                                <form method="GET" action="{{ route('books.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <!-- Catégorie -->
                                    <div>
                                        <label class="block text-sm font-medium text-text">Catégorie</label>
                                        <select name="category" class="mt-1 block w-full rounded-md bg-background border-background-dark shadow-sm text-text focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition-all">
                                            <option value="">Toutes</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <!-- Statut -->
                                    <div>
                                        <label class="block text-sm font-medium text-text">Statut</label>
                                        <select name="status" class="mt-1 block w-full rounded-md bg-background border-background-dark shadow-sm text-text focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition-all">
                                            <option value="">Tous</option>
                                            <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Disponible</option>
                                            <option value="borrowed" {{ request('status') == 'borrowed' ? 'selected' : '' }}>Emprunté</option>
                                        </select>
                                    </div>
                                    
                                    <!-- Nombre de pages -->
                                    <div>
                                        <label class="block text-sm font-medium text-text">Pages (min-max)</label>
                                        <div class="flex space-x-2">
                                            <input type="number" name="min_pages" placeholder="Min" 
                                                   class="w-1/2 rounded-md bg-background border-background-dark text-text focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition-all" value="{{ request('min_pages') }}">
                                            <input type="number" name="max_pages" placeholder="Max" 
                                                   class="w-1/2 rounded-md bg-background border-background-dark text-text focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition-all" value="{{ request('max_pages') }}">
                                        </div>
                                    </div>
                                    
                                    <!-- Note -->
                                    <div>
                                        <label class="block text-sm font-medium text-text">Note min.</label>
                                        <select name="min_rating" class="mt-1 block w-full rounded-md bg-background border-background-dark shadow-sm text-text focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition-all">
                                            <option value="">Toutes</option>
                                            @for($i = 1; $i <= 5; $i++)
                                                <option value="{{ $i }}" {{ request('min_rating') == $i ? 'selected' : '' }}>
                                                    {{ $i }} étoile{{ $i > 1 ? 's' : '' }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    
                                    <div class="md:col-span-4 flex justify-end space-x-2">
                                        <button type="submit" class="bg-primary text-background px-4 py-2 rounded-md hover:bg-primary-light transition-all">
                                            Appliquer
                                        </button>
                                        <a href="{{ route('books.index') }}" class="bg-gray-700 text-white px-4 py-2 rounded-md hover:bg-gray-800 transition-all">
                                            Réinitialiser
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Options de tri -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="text-sm text-text-light">
                            {{ $books->total() }} livre(s) trouvé(s)
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-text-light">Trier par :</span>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'recent']) }}" 
                               class="px-3 py-1 rounded transition-all {{ request('sort', 'recent') == 'recent' ? 'bg-primary text-background hover:bg-primary-light' : 'bg-background border border-background-dark text-text hover:bg-background-light' }}">
                                Récent
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'popular']) }}" 
                               class="px-3 py-1 rounded transition-all {{ request('sort') == 'popular' ? 'bg-primary text-background hover:bg-primary-light' : 'bg-background border border-background-dark text-text hover:bg-background-light' }}">
                                Populaire
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'rating']) }}" 
                               class="px-3 py-1 rounded transition-all {{ request('sort') == 'rating' ? 'bg-primary text-background hover:bg-primary-light' : 'bg-background border border-background-dark text-text hover:bg-background-light' }}">
                                Mieux notés
                            </a>
                        </div>
                    </div>

                    <!-- Liste des livres -->
                    <div class="space-y-4">
                        @foreach($books as $book)
                            <div class="border border-background-dark rounded-lg p-4 bg-background hover:shadow-dark transition-shadow">
                                <div class="flex flex-col md:flex-row gap-4">
                                    <!-- Couverture -->
                                    <div class="w-full md:w-1/6">
                                        <img src="{{ $book->cover ? Storage::url($book->cover) : asset('images/default-cover.jpg') }}" 
                                             alt="{{ $book->title }}" class="w-full h-auto object-cover rounded border border-background-dark">
                                    </div>
                                    
                                    <!-- Détails -->
                                    <div class="w-full md:w-4/6">
                                        <h3 class="text-lg font-semibold">
                                            <a href="{{ route('books.show', $book) }}" class="text-primary hover:text-primary-light transition-all">{{ $book->title }}</a>
                                        </h3>
                                        <p class="text-text-light">Par {{ $book->author }}</p>
                                        <p class="text-sm text-text-light mt-1">
                                            <span class="bg-secondary text-text-light px-2 py-1 rounded-full text-xs">
                                                {{ $book->category->name }}
                                            </span>
                                            <span class="ml-2">{{ $book->pages }} pages</span>
                                            <span class="ml-2">Publié le {{ $book->published_at->format('d/m/Y') }}</span>
                                        </p>
                                        <p class="mt-2 text-text">{{ Str::limit($book->summary, 200) }}</p>
                                        
                                        <!-- Note -->
                                        <div class="flex items-center mt-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $book->average_rating ? 'text-yellow-500' : 'text-gray-700' }}"></i>
                                            @endfor
                                            <span class="text-sm text-text-light ml-1">({{ $book->reviews_count }} avis)</span>
                                            <span class="ml-2 px-2 py-1 text-xs rounded-full 
                                                  {{ $book->status == 'available' ? 'bg-green-700 text-white' : 'bg-accent text-white' }}">
                                                {{ $book->status == 'available' ? 'Disponible' : 'Emprunté' }}
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <!-- Actions -->
                                    <div class="w-full md:w-1/6 flex md:flex-col justify-end gap-2">
                                        <a href="{{ route('books.show', $book) }}" 
                                           class="bg-primary text-background px-3 py-1 rounded-md hover:bg-primary-light transition-all text-sm">
                                            <i class="fas fa-eye mr-1"></i> Voir
                                        </a>
                                        @can('admin')
                                            <a href="{{ route('books.edit', $book) }}" 
                                               class="bg-yellow-600 text-background px-3 py-1 rounded-md hover:bg-yellow-700 transition-all text-sm">
                                                <i class="fas fa-edit mr-1"></i> Modifier
                                            </a>
                                            <form action="{{ route('books.destroy', $book) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="bg-accent text-white px-3 py-1 rounded-md hover:bg-accent-dark transition-all text-sm"
                                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce livre ?')">
                                                    <i class="fas fa-trash mr-1"></i> Supprimer
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $books->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection