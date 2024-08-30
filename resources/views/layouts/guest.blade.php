<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <!-- Lado Mascote -->
            <div class="flex items-start w-1/2 bg-white px-[70px] pt-48">
                <div class="flex items-center">
                    <!-- Barra azul e título -->
                    <div class="bg-primary rounded-md me-8 w-3.5 h-36"></div>
                    <h1 class="font-bold text-5xl text-primary w-56 me-1">Portal do Cliente</h1>
                </div>
                <!-- Mascote -->
                <img src="{{ asset('build/assets/imgs/mascote_teste.png') }}" class="h-[512px] w-auto mt-12" alt="Mascote da Roque">
            </div>

            <!-- Lado Conteúdo -->
            <div class="w-1/2 px-[70px] pt-48">
                <!-- Card -->
                <div class="w-full max-w-md pt-10 pb-12 px-6 bg-white shadow-md rounded-lg">
                    <!-- Logo Roque -->
                    <img src="{{ asset('build/assets/imgs/logo_principal.png') }}" class="w-auto h-14 mx-auto mb-10" alt="Logo da Roque">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
