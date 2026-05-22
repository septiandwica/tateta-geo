<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
    <body class="font-sans text-slate-800 dark:text-slate-200 antialiased bg-[#f8fafc] dark:bg-[#030712] transition-colors duration-300">
        
        <div class="fixed top-6 right-6 z-50">
            <button 
                onclick="window.toggleTheme()"
                type="button"
                class="text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white transition focus:outline-none hover:scale-110"
                title="Toggle Theme"
            >
                <svg class="w-5 h-5 hidden dark:block text-amber-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                </svg>
                <svg class="w-5 h-5 block dark:hidden text-indigo-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                </svg>
            </button>
        </div>

        <div class="absolute inset-0 overflow-hidden pointer-events-none z-0">
            <div class="absolute -top-[20%] left-[10%] w-[500px] h-[500px] rounded-full bg-indigo-500/10 dark:bg-indigo-500/10 blur-[100px]"></div>
            <div class="absolute bottom-[10%] right-[10%] w-[500px] h-[500px] rounded-full bg-emerald-500/5 dark:bg-emerald-500/5 blur-[120px]"></div>
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#0f172a04_1px,transparent_1px),linear-gradient(to_bottom,#0f172a04_1px,transparent_1px)] dark:bg-[linear-gradient(to_right,#1f29370a_1px,transparent_1px),linear-gradient(to_bottom,#1f29370a_1px,transparent_1px)] bg-[size:24px_24px]"></div>
        </div>

        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative z-10">
            
            <div class="mb-8">
                <a href="/" wire:navigate class="flex flex-col items-center gap-3">
                    <img src="{{ asset('icon/logo.png') }}" alt="Logo" class="h-14 w-auto rounded-2xl shadow-lg shadow-indigo-500/10 transform hover:scale-105 transition-transform duration-300">
                    <div class="flex flex-col items-center">
                        <span class="text-xl font-extrabold font-display tracking-tight text-slate-900 dark:text-white leading-none">TATETA</span>
                        <span class="text-[9px] font-mono text-indigo-500 dark:text-indigo-400 uppercase tracking-widest font-semibold mt-1">GEO API</span>
                    </div>
                </a>
            </div>

            <div class="w-full sm:max-w-md px-8 py-10 bg-white dark:bg-gray-900/40 border border-slate-200 dark:border-gray-800/80 shadow-xl dark:shadow-2xl backdrop-blur-xl sm:rounded-2xl overflow-hidden relative transition-all duration-300">
                
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
