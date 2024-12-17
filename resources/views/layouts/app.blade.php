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
    <body class="flex flex-col font-sans antialiased bg-background min-h-screen">
        <!-- Start Loading -->
        <livewire:sync-data lazy="on-load" />

        <!-- Alert Messages -->
        <livewire:alert-message />

        <!-- Page Header -->
        <livewire:layout.app-header />

        <!-- Page Content -->
        <main class="flex-1 px-[30px] xl:px-[70px] pb-12 pt-6">
            {{ $slot }}
        </main>

        <!-- Page Footer -->
        <footer class="w-full">
            <x-footer-info />
            <div class="flex flex-col md:flex-row justify-center items-center h-24 md:h-28 w-full bg-white font-normal text-small-subtitle sm:text-small">
                <div>Copyright ©&nbsp;<span class="font-bold">Roque Matcon Estrutural</span>&nbsp;|&nbsp;</div>
                <div>Designed by Taís Ximenes & Developed by Lucas Lemos</div>
            </div>
        </footer>
    </body>
</html>
