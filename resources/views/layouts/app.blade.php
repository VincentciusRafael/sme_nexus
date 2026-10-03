<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; }
            [x-cloak] { display: none !important; }
            ::selection { background: rgba(20, 184, 166, .25); }
        </style>
    </head>
    <body class="antialiased text-gray-900 dark:text-gray-100">
        <div class="relative min-h-screen bg-slate-50 dark:bg-gray-900">

            <!-- Garis aksen di paling atas -->
            <div class="fixed inset-x-0 top-0 z-50 h-1 bg-gradient-to-r from-teal-500 via-emerald-500 to-cyan-500" aria-hidden="true"></div>

            <!-- Latar dekoratif lembut -->
            <div class="pointer-events-none fixed inset-0 overflow-hidden" aria-hidden="true">
                <div class="absolute -left-32 -top-40 h-96 w-96 rounded-full bg-teal-400/20 blur-3xl dark:bg-teal-500/10"></div>
                <div class="absolute -right-32 top-48 h-96 w-96 rounded-full bg-amber-300/20 blur-3xl dark:bg-amber-500/10"></div>
                <div class="absolute -bottom-40 left-1/3 h-80 w-80 rounded-full bg-sky-300/20 blur-3xl dark:bg-sky-500/10"></div>
            </div>

            <div class="relative z-10 flex min-h-screen flex-col">
                <div class="sticky top-0 z-40">
                    @include('layouts.navigation')
                </div>

                <!-- Page Heading -->
                @isset($header)
                    <header class="border-b border-gray-200/70 bg-white/70 backdrop-blur-md dark:border-white/10 dark:bg-gray-900/60">
                        <div class="mx-auto max-w-7xl px-4 py-5 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="flex-1">
                    {{ $slot }}
                </main>

                <footer class="mx-auto w-full max-w-7xl px-4 py-8 text-center text-xs text-gray-400 dark:text-gray-500 sm:px-6 lg:px-8">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. Semua hak dilindungi.
                </footer>
            </div>
        </div>
    </body>
</html>