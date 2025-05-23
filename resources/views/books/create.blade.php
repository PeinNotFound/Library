@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-text leading-tight">
        <a href="{{ route('books.index') }}" class="text-primary hover:text-primary-light">Livres</a> / Ajouter un livre
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-background-light overflow-hidden shadow-dark sm:rounded-2xl border border-background-dark">
                <div class="p-6 bg-background-light border-b border-background-dark">
                    <form method="POST" action="{{ route('books.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Titre -->
                            <div class="md:col-span-2">
                                <label for="title" class="block text-sm font-medium text-text-light">Titre *</label>
                                <input type="text" name="title" id="title" required
                                       class="mt-1 block w-full rounded-md border-background-dark shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 bg-background text-text"
                                       value="{{ old('title') }}">
                                @error('title')
                                    <p class="mt-1 text-sm text-accent">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Auteur -->
                            <div>
                                <label for="author" class="block text-sm font-medium text-text-light">Auteur *</label>
                                <input type="text" name="author" id="author" required
                                       class="mt-1 block w-full rounded-md border-background-dark shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 bg-background text-text"
                                       value="{{ old('author') }}">
                                @error('author')
                                    <p class="mt-1 text-sm text-accent">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Catégorie -->
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-text-light">Catégorie *</label>
                                <select name="category_id" id="category_id" required
                                        class="mt-1 block w-full rounded-md border-background-dark shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 bg-background text-text">
                                    <option value="">Sélectionnez une catégorie</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="mt-1 text-sm text-accent">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Date de publication -->
                            <div>
                                <label for="published_at" class="block text-sm font-medium text-text-light">Date de publication *</label>
                                <input type="date" name="published_at" id="published_at" required
                                       class="mt-1 block w-full rounded-md border-background-dark shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 bg-background text-text"
                                       value="{{ old('published_at') }}">
                                @error('published_at')
                                    <p class="mt-1 text-sm text-accent">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Nombre de pages -->
                            <div>
                                <label for="pages" class="block text-sm font-medium text-text-light">Nombre de pages *</label>
                                <input type="number" name="pages" id="pages" min="1" required
                                       class="mt-1 block w-full rounded-md border-background-dark shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 bg-background text-text"
                                       value="{{ old('pages') }}">
                                @error('pages')
                                    <p class="mt-1 text-sm text-accent">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Statut -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-text-light">Statut *</label>
                                <select name="status" id="status" required
                                        class="mt-1 block w-full rounded-md border-background-dark shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 bg-background text-text">
                                    <option value="available" {{ old('status', 'available') == 'available' ? 'selected' : '' }}>Disponible</option>
                                    <option value="borrowed" {{ old('status') == 'borrowed' ? 'selected' : '' }}>Emprunté</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-accent">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Image de couverture -->
                            <div class="md:col-span-2">
                                <label for="cover" class="block text-sm font-medium text-text-light">Image de couverture</label>
                                <input type="file" name="cover" id="cover" accept="image/jpeg,image/png,image/jpg"
                                       class="mt-1 block w-full rounded-md border-background-dark shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 bg-background text-text">
                                <p class="mt-1 text-sm text-text-light">Formats acceptés: JPEG, PNG, JPG (max 2MB)</p>
                                @error('cover')
                                    <p class="mt-1 text-sm text-accent">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Résumé -->
                            <div class="md:col-span-2">
                                <label for="summary" class="block text-sm font-medium text-text-light">Résumé</label>
                                <textarea name="summary" id="summary" rows="4"
                                          class="mt-1 block w-full rounded-md border-background-dark shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 bg-background text-text">{{ old('summary') }}</textarea>
                                @error('summary')
                                    <p class="mt-1 text-sm text-accent">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="flex justify-end mt-6">
                            <a href="{{ route('books.index') }}" class="bg-background-dark text-text px-4 py-2 rounded-md hover:bg-background-light mr-2">
                                Annuler
                            </a>
                            <button type="submit" class="bg-primary text-background px-4 py-2 rounded-md hover:bg-primary-light">
                                Enregistrer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection