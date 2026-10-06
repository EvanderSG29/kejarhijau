<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- PWA Meta Tags & Manifest -->
        <meta name="theme-color" content="#16a34a">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">
        <meta name="apple-mobile-web-app-title" content="KejarHijau">
        <link rel="manifest" href="/manifest.json">
        <link rel="apple-touch-icon" href="/icons/icon-192.png">

        <title>{{ config('app.name', 'KejarHijau') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{-- Pesan flash sukses / error --}}
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-4">
                    @if (session('success'))
                        <div class="mb-4 p-4 rounded bg-green-100 text-green-800 border border-green-200">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="mb-4 p-4 rounded bg-red-100 text-red-800 border border-red-200">{{ session('error') }}</div>
                    @endif
                    @if (session('status'))
                        <div class="mb-4 p-4 rounded bg-blue-100 text-blue-800 border border-blue-200">{{ session('status') }}</div>
                    @endif
                </div>

                {{ $slot }}
            </main>
        </div>

        <!-- PWA Service Worker Registration -->
        <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', () => {
                    navigator.serviceWorker.register('/sw.js')
                        .then((reg) => console.log('PWA ServiceWorker registered:', reg.scope))
                        .catch((err) => console.warn('PWA ServiceWorker failed:', err));
                });
            }
        </script>
    </body>
</html>
