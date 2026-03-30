<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        @php
            $bgStyle = "background-image: url('" . asset('images/f.jpg') . "'); background-size: cover; background-position: center; background-attachment: fixed;"; // Default (Home)
            
            if (request()->routeIs('categories.index')) {
            $bgStyle = "background-image: url('" . asset('images/bg.png') . "'); background-size: cover; background-position: center; background-attachment: fixed;"; // Category
            } elseif (request()->is('admin*') || request()->routeIs('dashboard')) {
                $bgStyle = ""; // No background
            }
        @endphp
        
        <div class="min-h-screen bg-gray-100" style="{{ $bgStyle }}">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
