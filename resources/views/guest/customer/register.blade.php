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
    <body class="flex flex-1 flex-col justify-center items-center font-sans antialiased bg-background min-h-screen h-screen">
        <!-- Alert Messages -->
        <livewire:alert-message />

        <!-- Modal para criar um usuário -->
        <livewire:create-customer-modal />

        <!-- Modal para editar um usuário -->
        <livewire:edit-customer-modal />

        <!-- Main content -->
        <main class="w-full max-w-7xl h-full px-0 laptop:px-[30px] xl:px-[70px] py-0 laptop:py-20 desktop:py-28">
            <livewire:user-registration-chat :user="$user"/>
        </main>
    </body>
</html>
