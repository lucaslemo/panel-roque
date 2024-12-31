<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
        <!-- Page Content -->
        <main class="flex-1 px-[30px] xl:px-[70px] pb-12 pt-6">
            <table class="table-auto border-collapse border border-gray-300 w-full text-sm text-left">
                <thead>
                  <tr class="bg-gray-100 border-b border-gray-300">
                    <th class="px-4 py-2 border-r border-gray-300 text-gray-600">CÓDIGO</th>
                    <th class="px-4 py-2 border-r border-gray-300 text-gray-600">DESCRIÇÃO DO PRODUTO</th>
                    <th class="px-4 py-2 border-r border-gray-300 text-gray-600">QUANT</th>
                    <th class="px-4 py-2 border-r border-gray-300 text-gray-600">EMBALAGEM</th>
                    <th class="px-4 py-2 border-r border-gray-300 text-gray-600">VL TAB</th>
                    <th class="px-4 py-2 border-r border-gray-300 text-gray-600">VL DESC</th>
                    <th class="px-4 py-2 border-r border-gray-300 text-gray-600">VL UNIT</th>
                    <th class="px-4 py-2 text-gray-600">VL TOTAL</th>
                  </tr>
                </thead>
                <tbody>
                  <tr class="border-b border-gray-300">
                    <td class="px-4 py-2 border-r border-gray-300">327</td>
                    <td class="px-4 py-2 border-r border-gray-300">
                      CIMENTO CP IV 32 RS - BRAVO - 50KG NCM: 25232990
                    </td>
                    <td class="px-4 py-2 border-r border-gray-300">10,0000</td>
                    <td class="px-4 py-2 border-r border-gray-300">UN</td>
                    <td class="px-4 py-2 border-r border-gray-300">41,99</td>
                    <td class="px-4 py-2 border-r border-gray-300">0,00</td>
                    <td class="px-4 py-2 border-r border-gray-300">41,99</td>
                    <td class="px-4 py-2">419,90</td>
                  </tr>
                </tbody>
            </table>
        </main>
    </body>
</html>