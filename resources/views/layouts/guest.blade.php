<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('build/assets/favicon/apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('build/assets/favicon/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('build/assets/favicon/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('build/assets/favicon/site.webmanifest') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex bg-background">
            <!-- Mascote -->
            <div class="flex items-start w-1/2 bg-white py-36 px-20">

                <div class="flex items-center">
                    <div class="bg-primary rounded-md me-8 w-3.5 h-36"></div>
                    <h1 class="font-bold text-5xl text-primary w-56">Portal do Cliente</h1>
                </div>
                <div class="mt-10 w-64 h-64">
                    <img src="{{ Vite::asset('resources/assets/imgs/mascote_teste.png') }}" class="max-w-full h-auto" alt="Mascote da Roque">
                </div>
            </div>

            <!-- Conteúdo -->
            <div class="w-1/2 py-36 px-20">
                <div class="w-full max-w-md px-8 py-10 bg-white shadow-md rounded-lg">
                    <img src="{{ Vite::asset('resources/assets/imgs/logo_principal.png') }}" class="w-7/12 h-auto mx-auto mb-10" alt="Logo da Roque">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
