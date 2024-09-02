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
        <main class="min-h-screen flex flex-col md:flex-row bg-background">
            <!-- Lado Mascote -->
            <section class="flex items-start w-full md:w-1/2 min-h-36 md:min-h-0 bg-white px-[30px] xl:px-[70px] pt-8 lg:pt-24 xl:pt-48">
                <div class="flex items-center">
                    <!-- Barra azul e título -->
                    <div class="bg-primary rounded-md me-4 xl:me-8 w-3.5 h-14 md:h-28 xl:h-36"></div>
                    <h1 class="font-bold text-h4 md:text-h3 xl:text-h1 text-primary md:w-[148px] xl:w-60">Portal do Cliente</h1>
                </div>
                <!-- Mascote -->
                <img src="{{ asset('build/assets/imgs/mascote_teste.png') }}" class="hidden md:block h-[341px] xl:h-[512px] w-auto md:mt-10 xl:mt-12 pe-10" alt="Mascote da Roque">
            </section>

            <!-- Lado Conteúdo -->
            <section class="w-full md:w-1/2 px-[30px] xl:px-[70px] pt-12 lg:pt-24 xl:pt-48 pb-24 xl:pb-48">
                <!-- Card -->
                <div class="w-full max-w-md pt-8 pb-12 xl:pt-10 xl:pb-12 px-4 xl:px-6 bg-white shadow-menu rounded-lg">
                    <!-- Logo Roque -->
                    <img src="{{ asset('build/assets/imgs/logo_principal.png') }}" class="w-auto h-12 xl:h-14 mx-auto mb-8 xl:mb-12" alt="Logo da Roque">
                    {{ $slot }}
                </div>
            </section>
        </main>
    </body>
</html>
