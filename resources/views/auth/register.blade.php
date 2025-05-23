<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-text-light" />
            <x-text-input id="name" class="block mt-1 w-full bg-background border-background-dark text-text focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition-all" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-accent" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-text-light" />
            <x-text-input id="email" class="block mt-1 w-full bg-background border-background-dark text-text focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition-all" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-accent" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" class="text-text-light" />

            <x-text-input id="password" class="block mt-1 w-full bg-background border-background-dark text-text focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition-all"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2 text-accent" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-text-light" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full bg-background border-background-dark text-text focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition-all"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-accent" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-text-light hover:text-primary rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4 bg-primary text-background hover:bg-primary-light transition-all font-semibold">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
