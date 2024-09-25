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
    <body class="font-sans antialiased bg-background">
        <!-- Alert Messages -->
        <livewire:alert-message />

        <!-- Page Header -->
        <livewire:layout.header />

        <!-- Page Body -->
        <div class="min-h-screen px-[30px] xl:px-[70px]">

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <!-- Page Footer -->
        <footer class="flex justify-center items-center h-28 w-full bg-white font-normal text-small">
            Copyright ©&nbsp;<span class="font-bold">Roque Matcon Estrutural</span>&nbsp;| Designed by Taís Ximenes & Developed by Lucas Lemos
        </footer>
    </body>
</html>
