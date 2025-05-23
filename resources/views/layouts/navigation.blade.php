<nav x-data="{ open: false }" class="bg-background-light border-b border-background-dark shadow-dark">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('welcome') }}" class="hover-scale">
                        <x-application-logo class="block h-10 w-auto fill-current text-primary" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('books.index')" :active="request()->routeIs('books.index')" class="text-text hover:text-primary transition-all">
                        {{ __('Livres') }}
                    </x-nav-link>
                    @auth
                        @can('admin')
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')" class="text-text hover:text-primary transition-all">
                                {{ __('Admin') }}
                            </x-nav-link>
                        @endcan
                    @endauth
                </div>
            </div>

            <!-- Search Bar -->
            <div class="hidden sm:flex items-center ml-6">
                <form method="GET" action="{{ route('books.index') }}" class="flex">
                    <input type="text" name="search" placeholder="Rechercher un livre..." 
                           class="rounded-l-md bg-background border-background-dark focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition-all text-text placeholder-text-light"
                           value="{{ request('search') }}">
                    <button type="submit" class="bg-primary text-background px-4 py-2 rounded-r-md hover:bg-primary-light transition-all">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-text hover:text-primary focus:outline-none transition-all">
                                <div>
                                    @if(Auth::user()->avatar)
                                        <img src="{{ Storage::url(Auth::user()->avatar) }}" class="h-8 w-8 rounded-full ring-2 ring-primary ring-opacity-20">
                                    @else
                                        <div class="h-8 w-8 rounded-full bg-primary text-background flex items-center justify-center">
                                            {{ substr(Auth::user()->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.show')" class="text-text hover:text-primary hover:bg-background transition-all">
                                <i class="fas fa-user mr-2"></i> {{ __('Mon Profil') }}
                            </x-dropdown-link>
                            <div class="border-t border-background-dark my-1"></div>
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();"
                                        class="text-text hover:text-primary hover:bg-background transition-all">
                                    <i class="fas fa-sign-out-alt mr-2"></i> {{ __('Déconnexion') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="hidden sm:flex sm:items-center sm:ml-6 space-x-4">
                        <a href="{{ route('login') }}" class="text-sm text-text hover:text-primary transition-all">Connexion</a>
                        <a href="{{ route('register') }}" class="text-sm bg-primary text-background px-4 py-2 rounded-md hover:bg-primary-light transition-all">Inscription</a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-text-light hover:text-primary hover:bg-background focus:outline-none focus:bg-background focus:text-primary transition-all">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('books.index')" :active="request()->routeIs('books.index')" class="text-text hover:text-primary hover:bg-background transition-all">
                {{ __('Livres') }}
            </x-responsive-nav-link>
            
            @auth
                <x-responsive-nav-link :href="route('profile.show')" :active="request()->routeIs('profile.*')" class="text-text hover:text-primary hover:bg-background transition-all">
                    {{ __('Mon Profil') }}
                </x-responsive-nav-link>
                
                @can('admin')
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')" class="text-text hover:text-primary hover:bg-background transition-all">
                        {{ __('Admin') }}
                    </x-responsive-nav-link>
                @endcan
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        @auth
            <div class="pt-4 pb-1 border-t border-background-dark">
                <div class="flex items-center px-4">
                    @if(Auth::user()->avatar)
                        <img src="{{ Storage::url(Auth::user()->avatar) }}" class="h-10 w-10 rounded-full ring-2 ring-primary ring-opacity-20">
                    @else
                        <div class="h-10 w-10 rounded-full bg-primary text-background flex items-center justify-center">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    @endif
                    <div class="ml-3">
                        <div class="font-medium text-base text-text">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-text-light">{{ Auth::user()->email }}</div>
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();"
                                class="text-text hover:text-primary hover:bg-background transition-all">
                            {{ __('Déconnexion') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @else
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('login')" class="text-text hover:text-primary hover:bg-background transition-all">
                    {{ __('Connexion') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')" class="text-text hover:text-primary hover:bg-background transition-all">
                    {{ __('Inscription') }}
                </x-responsive-nav-link>
            </div>
        @endauth
        
        <!-- Search Bar Mobile -->
        <div class="px-4 py-2">
            <form method="GET" action="{{ route('books.index') }}" class="flex">
                <input type="text" name="search" placeholder="Rechercher un livre..." 
                       class="w-full rounded-l-md bg-background border-background-dark focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-20 transition-all text-text placeholder-text-light"
                       value="{{ request('search') }}">
                <button type="submit" class="bg-primary text-background px-4 py-2 rounded-r-md hover:bg-primary-light transition-all">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
    </div>
</nav>