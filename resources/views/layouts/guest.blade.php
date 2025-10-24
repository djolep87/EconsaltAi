<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen bg-gradient-to-br from-green-50 via-white to-blue-50">
            @include('layouts.shared-navigation')
            
            <div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-4">
                <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white/80 backdrop-blur-sm shadow-xl border border-gray-200/50 overflow-hidden sm:rounded-2xl">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
