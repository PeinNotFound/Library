<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'EspaceLecture') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Source+Sans+Pro:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        .transition-all {
            transition: all 0.3s ease-in-out;
        }
        
        .hover-scale {
            transition: transform 0.2s ease-in-out;
        }
        
        .hover-scale:hover {
            transform: scale(1.02);
        }

        /* Custom scrollbar for dark theme */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: theme('colors.background.dark');
        }

        ::-webkit-scrollbar-thumb {
            background: theme('colors.primary.dark');
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: theme('colors.primary.DEFAULT');
        }

        /* Highlight the active pagination page more visibly */
        .pagination .z-10 {
            background-color: #fbbf24 !important; /* Tailwind yellow-400 */
            color: #1a202c !important; /* Tailwind gray-900 */
            border-radius: 0.375rem !important; /* rounded-md */
            font-weight: bold !important;
            box-shadow: 0 0 0 2px #fbbf24;
        }
        .pagination .z-10:hover {
            background-color: #f59e42 !important; /* Slightly darker on hover */
            color: #fff !important;
        }
    </style>
    
    @stack('styles')
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
</head>
<body class="font-sans antialiased bg-background text-text">
    <div class="min-h-screen flex flex-col">
        @include('layouts.navigation')

        <!-- Page Heading -->
        <header class="bg-background-light shadow-dark border-b border-background-dark">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                @yield('header')
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-grow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                @yield('content')
            </div>
        </main>
        
        <!-- Footer -->
        <footer class="bg-background-light border-t border-background-dark mt-auto">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <p class="text-center text-text-light text-sm">
                    © {{ date('Y') }} EspaceLecture. All rights reserved.
                </p>
            </div>
        </footer>
    </div>
    
    @stack('scripts')
</body>
</html>