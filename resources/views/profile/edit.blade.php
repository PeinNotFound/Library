@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-text leading-tight">
        {{ __('Modifier mon profil') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-3xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="bg-background-light overflow-hidden shadow-dark rounded-2xl">
                <div class="p-8 bg-background-light border-b border-background-dark">
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Avatar -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-text-light">Photo de profil</label>
                                <div class="flex items-center mt-4">
                                    @if($user->avatar)
                                        <img src="{{ Storage::url($user->avatar) }}"
                                             alt="Avatar actuel" class="w-20 h-20 rounded-full mr-4 ring-4 ring-primary object-cover">
                                    @else
                                        <div class="w-20 h-20 rounded-full bg-background-light flex items-center justify-center mr-4 border-4 border-background-dark">
                                            <i class="fas fa-user text-text-light text-3xl"></i>
                                        </div>
                                    @endif
                                    <input type="file" name="avatar" id="avatar" accept="image/jpeg,image/png,image/jpg"
                                           class="rounded-md bg-background border-background-dark text-text focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition-all">
                                </div>
                                <p class="mt-1 text-sm text-text-light">Formats acceptés: JPEG, PNG, JPG (max 2MB)</p>
                                @error('avatar')
                                    <p class="mt-1 text-sm text-accent">{{ $message }}</p>
                                @enderror
                            </div>
                            <!-- Nom -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-text-light">Nom *</label>
                                <input type="text" name="name" id="name" required
                                       class="mt-1 block w-full rounded-md bg-background border-background-dark text-text focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition-all"
                                       value="{{ old('name', $user->name) }}">
                                @error('name')
                                    <p class="mt-1 text-sm text-accent">{{ $message }}</p>
                                @enderror
                            </div>
                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-text-light">Email *</label>
                                <input type="email" name="email" id="email" required
                                       class="mt-1 block w-full rounded-md bg-background border-background-dark text-text focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition-all"
                                       value="{{ old('email', $user->email) }}">
                                @error('email')
                                    <p class="mt-1 text-sm text-accent">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="flex justify-end mt-8 gap-2">
                            <a href="{{ route('profile.show') }}" class="bg-secondary text-text-light px-4 py-2 rounded-md hover:bg-secondary-light transition-all font-semibold">
                                Annuler
                            </a>
                            <button type="submit" class="bg-primary text-background px-4 py-2 rounded-md hover:bg-primary-light transition-all font-semibold">
                                Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                    <!-- Section changement de mot de passe -->
                    <div class="mt-10 pt-8 border-t border-background-dark">
                        <h3 class="text-lg font-bold text-text mb-4">Changer le mot de passe</h3>
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-1 gap-6">
                                <!-- Mot de passe actuel -->
                                <div>
                                    <label for="current_password" class="block text-sm font-medium text-text-light">Mot de passe actuel *</label>
                                    <input type="password" name="current_password" id="current_password" required
                                           class="mt-1 block w-full rounded-md bg-background border-background-dark text-text focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition-all">
                                    @error('current_password')
                                        <p class="mt-1 text-sm text-accent">{{ $message }}</p>
                                    @enderror
                                </div>
                                <!-- Nouveau mot de passe -->
                                <div>
                                    <label for="password" class="block text-sm font-medium text-text-light">Nouveau mot de passe *</label>
                                    <input type="password" name="password" id="password" required
                                           class="mt-1 block w-full rounded-md bg-background border-background-dark text-text focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition-all">
                                    @error('password')
                                        <p class="mt-1 text-sm text-accent">{{ $message }}</p>
                                    @enderror
                                </div>
                                <!-- Confirmation mot de passe -->
                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-text-light">Confirmer le nouveau mot de passe *</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" required
                                           class="mt-1 block w-full rounded-md bg-background border-background-dark text-text focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition-all">
                                </div>
                            </div>
                            <div class="flex justify-end mt-8">
                                <button type="submit" class="bg-primary text-background px-4 py-2 rounded-md hover:bg-primary-light transition-all font-semibold">
                                    Changer le mot de passe
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection