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
        <main class="flex flex-col md:flex-row min-h-screen bg-background">
            <!-- Lado Mascote -->
            <section class="flex items-center md:justify-center w-full md:w-1/2 pt-8 md:pt-0 pb-12 md:pb-0 ps-mobile-margin xl:ps-desktop-margin bg-white">
                <div class="flex items-start">
                    <span class="flex items-center">
                        <!-- Barra azul e título -->
                        <div class="bg-primary rounded-md w-4 me-4 xl:me-8 h-14 md:h-24 lg:h-28 xl:h-40"></div>
                        <h1 class="text-primary font-bold text-h4 md:text-h3 lg:text-h2 xl:text-h1 w-56 md:w-[150px] lg:w-48 xl:w-60">Portal do Cliente</h1>
                    </span>
                    <!-- Mascote -->
                    <img src="{{ asset('build/assets/imgs/mascote_teste.png') }}" class="hidden md:block h-small-mascot lg:h-medium-mascot xl:h-big-mascot w-auto mt-8 xl:mt-12" alt="Mascote da Roque">
                </div>
            </section>

            <!-- Lado Conteúdo -->
            <section class="flex md:items-center justify-center w-full md:w-1/2 pt-12 md:pt-0 pb-12 md:pb-0 pe-mobile-margin xl:pe-desktop-margin ps-mobile-margin md:ps-0">
                <!-- Card -->
                <div class="block w-full max-w-[456px] w-[428px] md:w-[428px] lg:w-[456px] pt-8 lg:pt-10 pb-12 lg:pb-12 px-4 lg:px-[30px] bg-white shadow-menu rounded-lg">
                    <!-- Logo Roque -->
                    <img src="{{ asset('build/assets/imgs/logo_principal.png') }}" class="w-auto h-12 lg:h-14 mx-auto mb-8 lg:mb-12" alt="Logo da Roque">
                    {{ $slot }}
                </div>
            </section>
        </main>
    </body>
</html>
