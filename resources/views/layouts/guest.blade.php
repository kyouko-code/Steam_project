<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'GameStore') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-900">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="mb-6">
                <a href="{{ route('home') }}" class="text-3xl font-bold text-blue-500 tracking-tight">
                    GameStore
                </a>
            </div>

            @if(session('status'))
                <div class="w-full sm:max-w-md mb-4">
                    <div class="bg-green-800 border border-green-600 text-green-200 px-4 py-3 rounded relative">
                        {{ session('status') }}
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="w-full sm:max-w-md mb-4">
                    <div class="bg-red-800 border border-red-600 text-red-200 px-4 py-3 rounded">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="w-full sm:max-w-md mt-2 px-6 py-6 bg-gray-800 border border-gray-700 shadow-xl overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>