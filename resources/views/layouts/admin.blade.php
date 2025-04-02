<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-100">
    <livewire:user-navbar />

    <!-- Page Content -->
    <main class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 pt-16">
        <!-- Page Title -->
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-900">@yield('title')</h1>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        <!-- Main Content -->
        @yield('content')
    </main>

    @livewireScripts
</body>
</html> 