<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title', config('app.name', 'GameStore'))</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-900 text-gray-100">
        <div class="min-h-screen flex flex-col">
            @include('layouts.navigation')

            @if(session('success'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
                    <div class="bg-green-800 border border-green-600 text-green-200 px-4 py-3 rounded relative">
                        {{ session('success') }}
                        <button onclick="this.parentElement.remove()" class="absolute top-2 right-2 text-green-300 hover:text-white">&times;</button>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
                    <div class="bg-red-800 border border-red-600 text-red-200 px-4 py-3 rounded relative">
                        {{ session('error') }}
                        <button onclick="this.parentElement.remove()" class="absolute top-2 right-2 text-red-300 hover:text-white">&times;</button>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
                    <div class="bg-red-800 border border-red-600 text-red-200 px-4 py-3 rounded">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <main class="flex-grow">
                {{ $slot }}
            </main>

            <footer class="bg-gray-950 border-t border-gray-800 mt-12">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    <div class="text-center text-gray-500 text-sm">
                        &copy; {{ date('Y') }} GameStore. Built with Laravel.
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
