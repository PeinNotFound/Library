@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-text leading-tight">
        {{ __('Bienvenue sur EspaceLecture') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Livres récents -->
            <div class="bg-background-light overflow-hidden shadow-dark sm:rounded-lg mb-8">
                <div class="p-6 bg-background-light border-b border-background-dark">
                    <h3 class="text-lg font-semibold mb-4 text-text">Livres récemment ajoutés</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                        @foreach($recentBooks as $book)
                            <div class="border border-background-dark rounded-lg p-4 bg-background hover:shadow-dark transition-shadow">
                                <a href="{{ route('books.show', $book) }}">
                                    <img src="{{ $book->cover ? Storage::url($book->cover) : asset('images/default-cover.jpg') }}" 
                                         alt="{{ $book->title }}" class="w-full h-48 object-cover mb-2 rounded border border-background-dark">
                                    <h4 class="font-medium text-text">{{ Str::limit($book->title, 20) }}</h4>
                                    <p class="text-sm text-text-light">{{ $book->author }}</p>
                                    <div class="flex items-center mt-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $book->average_rating ? 'text-yellow-500' : 'text-text-light' }} text-sm"></i>
                                        @endfor
                                        <span class="text-xs text-text-light ml-1">({{ $book->reviews_count }})</span>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Livres populaires -->
            <div class="bg-background-light overflow-hidden shadow-dark sm:rounded-lg">
                <div class="p-6 bg-background-light border-b border-background-dark">
                    <h3 class="text-lg font-semibold mb-4 text-text">Livres les plus populaires</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                        @foreach($popularBooks as $book)
                            <div class="border border-background-dark rounded-lg p-4 bg-background hover:shadow-dark transition-shadow">
                                <a href="{{ route('books.show', $book) }}">
                                    <img src="{{ $book->cover ? Storage::url($book->cover) : asset('images/default-cover.jpg') }}" 
                                         alt="{{ $book->title }}" class="w-full h-48 object-cover mb-2 rounded border border-background-dark">
                                    <h4 class="font-medium text-text">{{ Str::limit($book->title, 20) }}</h4>
                                    <p class="text-sm text-text-light">{{ $book->author }}</p>
                                    <div class="flex items-center mt-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $book->average_rating ? 'text-yellow-500' : 'text-text-light' }} text-sm"></i>
                                        @endfor
                                        <span class="text-xs text-text-light ml-1">({{ $book->reviews_count }})</span>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection