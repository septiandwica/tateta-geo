<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TatetaGeo API') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

        <script>
            function applyTheme() {
                if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            }
            window.toggleTheme = function() {
                let html = document.documentElement;
                if (html.classList.contains('dark')) {
                    html.classList.remove('dark');
                    localStorage.setItem('theme', 'light');
                    console.log('Theme changed to: light');
                } else {
                    html.classList.add('dark');
                    localStorage.setItem('theme', 'dark');
                    console.log('Theme changed to: dark');
                }
            };
            applyTheme();
            document.addEventListener('livewire:navigated', applyTheme);
        </script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-slate-800 dark:text-slate-200 antialiased bg-[#f8fafc] dark:bg-[#030712] relative min-h-screen transition-colors duration-300">
        
        <div class="absolute inset-0 overflow-hidden pointer-events-none z-0">
            <div class="absolute top-0 right-0 w-[450px] h-[450px] rounded-full bg-indigo-500/5 dark:bg-indigo-500/5 blur-[90px]"></div>
            <div class="absolute bottom-0 left-[10%] w-[550px] h-[550px] rounded-full bg-emerald-500/5 dark:bg-emerald-500/5 blur-[120px]"></div>
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#0f172a04_1px,transparent_1px),linear-gradient(to_bottom,#0f172a04_1px,transparent_1px)] dark:bg-[linear-gradient(to_right,#1f293708_1px,transparent_1px),linear-gradient(to_bottom,#1f293708_1px,transparent_1px)] bg-[size:24px_24px]"></div>
        </div>

        <div class="relative min-h-screen flex flex-col z-10">
            <livewire:layout.navigation />

            @if (isset($header))
                <header class="bg-white/80 dark:bg-gray-950/40 border-b border-slate-200/80 dark:border-gray-900/60 backdrop-blur-md transition-colors duration-300">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main class="flex-1 py-12">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
