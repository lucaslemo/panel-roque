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
    <body class="flex flex-col font-sans antialiased bg-background min-h-screen h-screen">
        <!-- Alert Messages -->
        <livewire:alert-message />

        <!-- header -->
        <header class="flex justify-end items-center h-14 desktop:h-28 w-full bg-white px-[30px] xl:px-[70px]">
            {{-- <img src="{{ asset('build/assets/imgs/logo_principal.png') }}" class="block laptop:hidden w-auto h-12" alt="Logo da Roque"> --}}
        </header>

        <!-- Main content -->
        <main class="flex flex-1 justify-center items-center h-full px-[30px] xl:px-[70px]">
            <livewire:user-registration-chat :user="$user"/>
        </main>
    </body>
</html>