<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!--<link href="src\seikabutu\resources\css\blade.css" ler="stylesheet"> -->

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://kit.fontawesome.com/eb2b211333.js" crossorigin="anonymous"></script>
    </head>
    <body class="font-sans antialiased bg-gray-100 text-black dark:text-white">
        <div id="app" class="min-h-screen bg-gray-100 dark:bg-gray-700">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                        
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="py-4">
                {{ $slot ?? '' }}
            </main>
        </div>
        <footer class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class=" w-full h-full flex justify-between">
                    <div class="container mx-auto px-4">
                        <div class="flex flex-wrap justify-between items-center">
                        <div class="w-full sm:w-auto mb-4 sm:mb-0">
                            <p>&copy; 2023 Your Website. All rights reserved.</p>
                        </div>
                        <div class="w-full sm:w-auto">
                            <ul class="flex space-x-4">
                            <li><a href="#">Home</a></li>
                            <li><a href="#">About</a></li>
                            <li><a href="#">Services</a></li>
                            <li><a href="#">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
