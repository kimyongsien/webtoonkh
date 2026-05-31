<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Webtoon KH</title>
        <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-[#f8fafc]">
        <!-- Full Screen Background with Gradient and Blur -->
        <div class="fixed inset-0 w-full h-full -z-10 bg-white overflow-hidden" style="background: radial-gradient(circle at 20% 20%, #fdf2f8, transparent 40%), radial-gradient(circle at 80% 80%, #eff6ff, transparent 40%), radial-gradient(circle at 50% 50%, #f5f3ff, transparent 40%);">
            <div class="absolute inset-0 backdrop-blur-[60px] opacity-60"></div>
        </div>

        <div class="min-h-screen flex flex-col justify-center items-center px-4 py-8">
            <div class="relative w-full max-w-sm mx-auto">
                <!-- Card -->
                <div class="relative z-10 w-full bg-white/90 backdrop-blur-xl shadow-[0_24px_60px_-12px_rgba(0,0,0,0.12)] border border-white/60 rounded-[32px] px-8 py-10 transition-all">
                    <!-- Logo -->
                    <div class="flex justify-center mb-10">
                        <a href="/">
                            <img src="{{ asset('images/logo.png') }}" alt="Webtoon KH" class="h-16 w-16 rounded-2xl object-cover shadow-sm">
                        </a>
                    </div>

                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
