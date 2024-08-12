<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel Admin') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 text-white">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-primary shadow-lg">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-accent">Back Office</h1>
            </div>
            <nav class="mt-8">
                <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-accent hover:text-primary">
                    Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-accent hover:text-primary">
                    Kullanıcılar
                </a>
                <a href="{{ route('admin.leaves') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-accent hover:text-primary">
                    Yıllık İzinler
                </a>
            </nav>
        </aside>

        <div class="flex-1 bg-primary">
            <header class="bg-primary shadow-lg">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header ?? '' }}
                </div>
            </header>

            <main class="py-10">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    @if(session('success'))
                        <div class="bg-green-500 text-white p-4 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>
