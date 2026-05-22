<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>TatetaGeo API - Indonesia Regional Data Service</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

        <style>
            [x-cloak] { display: none !important; }
        </style>
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
    <body class="antialiased bg-[#f8fafc] text-slate-800 dark:bg-[#030712] dark:text-gray-100 font-sans selection:bg-indigo-500/30 selection:text-indigo-200 transition-colors duration-300">
        
        <div class="absolute inset-0 overflow-hidden pointer-events-none z-0">
            <div class="absolute -top-[40%] left-[10%] w-[600px] h-[600px] rounded-full bg-indigo-500/5 dark:bg-indigo-500/10 blur-[120px]"></div>
            <div class="absolute top-[20%] -right-[10%] w-[500px] h-[500px] rounded-full bg-purple-500/5 blur-[100px]"></div>
            <div class="absolute -bottom-[20%] left-[20%] w-[700px] h-[700px] rounded-full bg-emerald-500/5 blur-[150px]"></div>
            <div class="absolute inset-0 bg-[linear-gradient(to_right,#0f172a04_1px,transparent_1px),linear-gradient(to_bottom,#0f172a04_1px,transparent_1px)] dark:bg-[linear-gradient(to_right,#1f29370a_1px,transparent_1px),linear-gradient(to_bottom,#1f29370a_1px,transparent_1px)] bg-[size:24px_24px] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)]"></div>
        </div>

        <div class="relative min-h-screen flex flex-col justify-between z-10">
            
            <header class="border-b border-slate-200/80 dark:border-gray-800/60 bg-white/30 dark:bg-gray-950/30 backdrop-blur-md sticky top-0 z-50 transition-colors duration-300">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
                    
                    <a href="{{ url('/') }}" class="flex items-center gap-3">
                        <img src="{{ asset('icon/logo.png') }}" alt="Logo" class="h-10 w-auto rounded-xl">
                        <div class="flex flex-col">
                            <span class="text-lg font-bold font-display tracking-tight text-slate-900 dark:text-white leading-none">TATETA</span>
                            <span class="text-[10px] font-mono text-indigo-500 dark:text-indigo-400 uppercase tracking-widest font-semibold mt-0.5">GEO API</span>
                        </div>
                    </a>

                    <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-500 dark:text-gray-400">
                        <a href="#features" class="hover:text-slate-900 dark:hover:text-white transition-colors duration-200">{{ __('Features') }}</a>
                        <a href="#sandbox" class="hover:text-slate-900 dark:hover:text-white transition-colors duration-200">{{ __('Sandbox') }}</a>
                        <a href="{{ url('/docs') }}" class="hover:text-slate-900 dark:hover:text-white transition-colors duration-200">{{ __('Documentation') }}</a>
                    </nav>

                    <div class="flex items-center gap-4">
                        
                        <button 
                            onclick="window.toggleTheme()"
                            type="button"
                            class="text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white transition focus:outline-none"
                            title="Toggle Theme"
                        >
                            <svg class="w-5 h-5 hidden dark:block text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                            </svg>
                            <svg class="w-5 h-5 block dark:hidden text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                            </svg>
                        </button>

                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white text-xs font-semibold rounded-lg shadow-lg shadow-indigo-500/15 transition duration-150 gap-1.5">
                                {{ __('Dashboard') }}
                                <svg class="size-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-xs font-semibold text-slate-600 dark:text-gray-300 hover:text-slate-900 dark:hover:text-white px-3 py-2 transition-colors">
                                {{ __('Log in') }}
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 border border-slate-200 dark:border-gray-700 hover:border-indigo-500/50 hover:bg-slate-50 dark:hover:bg-gray-900/60 bg-white dark:bg-gray-900/60 text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 text-xs font-semibold rounded-lg transition duration-150">
                                    {{ __('Register') }}
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </header>

            <main class="flex-1">
                <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32 flex flex-col items-center text-center">
                    
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-indigo-500/30 bg-indigo-500/5 text-indigo-600 dark:text-indigo-400 text-xs font-semibold tracking-wide uppercase mb-8 shadow-inner animate-pulse">
                        <span class="size-1.5 rounded-full bg-indigo-500"></span>
                        {{ __('Indonesia Regional Data API') }}
                    </div>

                    <h1 class="text-4xl sm:text-6xl font-extrabold font-display tracking-tight text-slate-900 dark:text-white max-w-4xl leading-[1.1] mb-6 transition-colors duration-300">
                        Complete Indonesia<br class="hidden sm:inline">
                        <span class="text-indigo-600 dark:text-indigo-400">
                            Regional Data API.
                        </span>
                    </h1>

                    <p class="text-lg text-slate-600 dark:text-gray-400 max-w-2xl leading-relaxed mb-12 transition-colors duration-300">
                        {{ __('TatetaGeo provides fast, reliable access to complete Indonesian administrative regional data. Query provinces, regencies, districts, and villages with sub-5ms response times using secure API authentication.') }}
                    </p>

                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 w-full sm:w-auto">
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-4 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-semibold rounded-xl shadow-xl shadow-indigo-500/20 w-full sm:w-60 transition duration-150 text-sm gap-2">
                            {{ __('Get Free API Token') }}
                            <svg class="size-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a3 3 0 0 1-3 3m3 0a3 3 0 0 1-3-3m-12 6c0 1.657-1.343 3-3 3s-3-1.343-3-3 1.343-3 3-3 3 1.343 3 3ZM13.5 9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </a>
                        <a href="#features" class="inline-flex items-center justify-center px-8 py-4 border border-slate-200 dark:border-gray-700 hover:border-slate-300 dark:hover:border-gray-600 bg-white hover:bg-slate-50 dark:bg-gray-900/50 dark:hover:bg-gray-900/80 text-slate-700 dark:text-gray-200 font-semibold rounded-xl w-full sm:w-60 transition duration-150 text-sm gap-2 backdrop-blur-sm shadow-sm">
                            {{ __('View Features') }}
                            <svg class="size-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </a>
                    </div>
                </section>

                <section id="features" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 border-t border-slate-200 dark:border-gray-900 transition-colors duration-300">
                    <div class="text-center max-w-3xl mx-auto mb-16">
                        <h2 class="text-3xl font-bold font-display text-slate-900 dark:text-white mb-4 transition-colors duration-300">
                            {{ __('Powerful Regional Data API') }}
                        </h2>
                        <p class="text-slate-600 dark:text-gray-400 leading-relaxed transition-colors duration-300">
                            {{ __('Access complete, accurate, and up-to-date Indonesian administrative regional data through a simple, secure REST API.') }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        <div class="group p-8 rounded-2xl bg-white dark:bg-gray-900/40 border border-slate-200 dark:border-gray-800 hover:border-indigo-500/40 dark:hover:border-indigo-500/40 transition duration-300 flex flex-col justify-between shadow-sm dark:shadow-lg relative overflow-hidden backdrop-blur-sm">
                            <div class="absolute -top-12 -right-12 size-36 bg-indigo-500/5 blur-2xl rounded-full group-hover:bg-indigo-500/10 transition-all duration-300"></div>
                            <div class="space-y-6">
                                <div class="size-12 rounded-xl bg-indigo-600/10 border border-indigo-500/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 group-hover:scale-110 transition duration-300">
                                    <svg class="size-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0Z" />
                                    </svg>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex items-center gap-3">
                                        <h3 class="text-xl font-bold text-slate-900 dark:text-white transition-colors duration-300">{{ __('Indonesia Regional Geo API') }}</h3>
                                        <span class="px-2 py-0.5 rounded bg-emerald-500/10 border border-emerald-500/30 text-emerald-600 dark:text-emerald-400 text-[10px] font-semibold uppercase tracking-wider">{{ __('Active') }}</span>
                                    </div>
                                    <p class="text-sm text-slate-500 dark:text-gray-400 leading-relaxed transition-colors duration-300">
                                        {{ __('Complete administrative spatial nodes including provinces, regencies, districts, and villages in Indonesia. Meticulously parsed, sanitized, and updated directly from BPS database records.') }}
                                    </p>
                                </div>
                            </div>
                            <div class="mt-8 pt-6 border-t border-slate-100 dark:border-gray-800/80 flex items-center justify-between text-xs text-indigo-600 dark:text-indigo-400 font-semibold group-hover:text-indigo-500 transition duration-300">
                                <span>{{ __('Secure API Token Auth') }}</span>
                                <svg class="size-4 group-hover:translate-x-1 transition duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>
                            </div>
                        </div>

                        <div class="group p-8 rounded-2xl bg-white dark:bg-gray-900/40 border border-slate-200 dark:border-gray-800 hover:border-purple-500/40 dark:hover:border-purple-500/40 transition duration-300 flex flex-col justify-between shadow-sm dark:shadow-lg relative overflow-hidden backdrop-blur-sm">
                            <div class="absolute -top-12 -right-12 size-36 bg-purple-500/5 blur-2xl rounded-full group-hover:bg-purple-500/10 transition-all duration-300"></div>
                            <div class="space-y-6">
                                <div class="size-12 rounded-xl bg-purple-600/10 border border-purple-500/30 flex items-center justify-center text-purple-600 dark:text-purple-400 group-hover:scale-110 transition duration-300">
                                    <svg class="size-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex items-center gap-3">
                                        <h3 class="text-xl font-bold text-slate-900 dark:text-white transition-colors duration-300">{{ __('Health Check & Status API') }}</h3>
                                        <span class="px-2 py-0.5 rounded bg-emerald-500/10 border border-emerald-500/30 text-emerald-600 dark:text-emerald-400 text-[10px] font-semibold uppercase tracking-wider">{{ __('Active') }}</span>
                                    </div>
                                    <p class="text-sm text-slate-500 dark:text-gray-400 leading-relaxed transition-colors duration-300">
                                        {{ __('Public health check endpoint for monitoring service availability and database connectivity. Returns real-time status with sub-millisecond response times.') }}
                                    </p>
                                </div>
                            </div>
                            <div class="mt-8 pt-6 border-t border-slate-100 dark:border-gray-800/80 flex items-center justify-between text-xs text-purple-600 dark:text-purple-400 font-semibold group-hover:text-purple-500 transition duration-300">
                                <span>{{ __('Open Unauthenticated Access') }}</span>
                                <svg class="size-4 group-hover:translate-x-1 transition duration-200" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>
                            </div>
                        </div>


                    </div>
                </section>
            </main>

            <section id="sandbox" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 border-t border-slate-200 dark:border-gray-900 transition-colors duration-300">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    
                    <div class="lg:col-span-5 space-y-6">
                        <h2 class="text-3xl font-bold font-display text-slate-900 dark:text-white transition-colors duration-300">
                            {{ __('Simple Integration') }}
                        </h2>
                        <p class="text-slate-600 dark:text-gray-400 leading-relaxed transition-colors duration-300">
                            {{ __('Querying Indonesian regional data is straightforward. Copy one of our code examples and integrate it directly into your application.') }}
                        </p>
                        <ul class="space-y-3 text-sm text-slate-700 dark:text-gray-300 font-semibold">
                            <li class="flex items-center gap-2">
                                <svg class="size-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                                {{ __('Standard Secure Bearer Token Auth') }}
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="size-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                                {{ __('Query by province, regency, district, or village') }}
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="size-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                                {{ __('High-speed JSON payloads with fallback nodes') }}
                            </li>
                        </ul>
                    </div>

                    <div class="lg:col-span-7" x-data="{ activeTab: 'curl', copied: false }">
                        <div class="rounded-2xl border border-slate-200 dark:border-gray-800 bg-white dark:bg-gray-950 shadow-xl dark:shadow-2xl transition-all duration-300">
                            
                            <div class="flex items-center justify-between border-b border-slate-100 dark:border-gray-800/80 bg-slate-50 dark:bg-gray-900/50 px-4 py-3 text-xs">
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-red-500/80"></span>
                                    <span class="w-3 h-3 rounded-full bg-yellow-500/80"></span>
                                    <span class="w-3 h-3 rounded-full bg-emerald-500/80"></span>
                                    <span class="font-mono text-slate-400 dark:text-gray-500 ml-2">tateta-request-sandbox.sh</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div x-data="{ open: false }" class="relative z-100">
                                        <button 
                                            @click="open = !open"
                                            @click.away="open = false"
                                            class="w-48 px-3 py-1.5 bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-700 rounded-lg text-xs font-semibold text-slate-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition cursor-pointer hover:border-slate-300 dark:hover:border-gray-600 flex items-center justify-between"
                                        >
                                            <span x-text="activeTab === 'curl' ? 'cURL' : activeTab === 'php' ? 'PHP (Laravel HTTP)' : activeTab === 'js' ? 'JavaScript (Fetch)' : activeTab === 'python' ? 'Python (Requests)' : activeTab === 'go' ? 'Go (net/http)' : activeTab === 'ruby' ? 'Ruby (net/http)' : 'Node.js (Axios)'"></span>
                                            <svg class="w-4 h-4" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                            </svg>
                                        </button>
                                        <div 
                                            x-show="open" 
                                            x-transition
                                            class="absolute top-full left-0 mt-1 w-48 bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-700 rounded-lg shadow-lg z-50"
                                        >
                                            <button @click="activeTab = 'curl'; open = false" class="w-full text-left px-3 py-2 text-xs hover:bg-slate-100 dark:hover:bg-gray-800 text-slate-700 dark:text-gray-300 transition" :class="{ 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-semibold': activeTab === 'curl' }">cURL</button>
                                            <button @click="activeTab = 'php'; open = false" class="w-full text-left px-3 py-2 text-xs hover:bg-slate-100 dark:hover:bg-gray-800 text-slate-700 dark:text-gray-300 transition" :class="{ 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-semibold': activeTab === 'php' }">PHP (Laravel HTTP)</button>
                                            <button @click="activeTab = 'js'; open = false" class="w-full text-left px-3 py-2 text-xs hover:bg-slate-100 dark:hover:bg-gray-800 text-slate-700 dark:text-gray-300 transition" :class="{ 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-semibold': activeTab === 'js' }">JavaScript (Fetch)</button>
                                            <button @click="activeTab = 'python'; open = false" class="w-full text-left px-3 py-2 text-xs hover:bg-slate-100 dark:hover:bg-gray-800 text-slate-700 dark:text-gray-300 transition" :class="{ 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-semibold': activeTab === 'python' }">Python (Requests)</button>
                                            <button @click="activeTab = 'go'; open = false" class="w-full text-left px-3 py-2 text-xs hover:bg-slate-100 dark:hover:bg-gray-800 text-slate-700 dark:text-gray-300 transition" :class="{ 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-semibold': activeTab === 'go' }">Go (net/http)</button>
                                            <button @click="activeTab = 'ruby'; open = false" class="w-full text-left px-3 py-2 text-xs hover:bg-slate-100 dark:hover:bg-gray-800 text-slate-700 dark:text-gray-300 transition" :class="{ 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-semibold': activeTab === 'ruby' }">Ruby (net/http)</button>
                                            <button @click="activeTab = 'node'; open = false" class="w-full text-left px-3 py-2 text-xs hover:bg-slate-100 dark:hover:bg-gray-800 text-slate-700 dark:text-gray-300 transition" :class="{ 'bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-semibold': activeTab === 'node' }">Node.js (Axios)</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="p-6 font-mono text-[13px] leading-relaxed text-slate-800 dark:text-gray-300 overflow-x-auto min-h-[160px] relative group/code bg-slate-50/30 dark:bg-transparent transition-colors duration-300">
                                
                                <button x-data="{}" @click="let codeBlock = $el.nextElementSibling; while(codeBlock && codeBlock.style.display === 'none') { codeBlock = codeBlock.nextElementSibling; } if(codeBlock) { navigator.clipboard.writeText(codeBlock.innerText); copied = true; setTimeout(() => copied = false, 2000); }" class="absolute top-4 right-4 p-2 rounded-xl bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 hover:border-indigo-500/50 text-slate-400 dark:text-gray-400 hover:text-slate-900 dark:hover:text-white transition shadow opacity-0 group-hover/code:opacity-100 focus:opacity-100 duration-200">
                                    <template x-if="!copied">
                                        <svg class="size-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5A3.375 3.375 0 006.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0015 2.25h-1.5a2.251 2.251 0 00-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5" />
                                        </svg>
                                    </template>
                                    <template x-if="copied">
                                        <svg class="size-4 text-emerald-500" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </template>
                                </button>


                                <div x-show="activeTab === 'curl'" x-transition x-cloak class="space-y-1">
                                    <div><span class="text-pink-600 dark:text-pink-400 font-bold">curl</span> -X GET <span class="text-emerald-600 dark:text-emerald-400">"{{ url('/api/v1/geo/provinces') }}"</span> \</div>
                                    <div class="pl-4">-H <span class="text-emerald-600 dark:text-emerald-400">"Authorization: Bearer tateta_api_token"</span> \</div>
                                    <div class="pl-4">-H <span class="text-emerald-600 dark:text-emerald-400">"Accept: application/json"</span></div>
                                </div>

                                <div x-show="activeTab === 'php'" x-transition x-cloak class="space-y-1">
                                    <div><span class="text-indigo-600 dark:text-indigo-400 font-bold">Http</span>::<span class="text-purple-600 dark:text-purple-400">withToken</span>(<span class="text-emerald-600 dark:text-emerald-400">'tateta_api_token'</span>)</div>
                                    <div class="pl-4">-&gt;<span class="text-purple-600 dark:text-purple-400">timeout</span>(<span class="text-amber-600 dark:text-amber-400">2</span>)</div>
                                    <div class="pl-4">-&gt;<span class="text-purple-600 dark:text-purple-400">get</span>(<span class="text-emerald-600 dark:text-emerald-400">'{{ url('/api/v1/geo/provinces') }}'</span>);</div>
                                </div>

                                <div x-show="activeTab === 'js'" x-transition x-cloak class="space-y-1">
                                    <div><span class="text-purple-600 dark:text-purple-400 font-bold">fetch</span>(<span class="text-emerald-600 dark:text-emerald-400">'{{ url('/api/v1/geo/provinces') }}'</span>, {</div>
                                    <div class="pl-4">headers: {</div>
                                    <div class="pl-8"><span class="text-emerald-600 dark:text-emerald-400">'Authorization'</span>: <span class="text-emerald-600 dark:text-emerald-400">'Bearer tateta_api_token'</span>,</div>
                                    <div class="pl-8"><span class="text-emerald-600 dark:text-emerald-400">'Accept'</span>: <span class="text-emerald-600 dark:text-emerald-400">'application/json'</span></div>
                                    <div class="pl-4">}</div>
                                    <div>}).<span class="text-purple-600 dark:text-purple-400">then</span>(res =&gt; res.<span class="text-purple-600 dark:text-purple-400">json</span>()).<span class="text-purple-600 dark:text-purple-400">then</span>(<span class="text-indigo-600 dark:text-indigo-400">console</span>.<span class="text-purple-600 dark:text-purple-400">log</span>);</div>
                                </div>

                                <div x-show="activeTab === 'python'" x-transition x-cloak class="space-y-1">
                                    <div><span class="text-purple-600 dark:text-purple-400 font-bold">import</span> requests</div>
                                    <div class="mt-2">response = requests.<span class="text-purple-600 dark:text-purple-400">get</span>(</div>
                                    <div class="pl-4"><span class="text-emerald-600 dark:text-emerald-400">'{{ url('/api/v1/geo/provinces') }}'</span>,</div>
                                    <div class="pl-4">headers={<span class="text-emerald-600 dark:text-emerald-400">'Authorization'</span>: <span class="text-emerald-600 dark:text-emerald-400">'Bearer tateta_api_token'</span>}</div>
                                    <div>)</div>
                                    <div><span class="text-indigo-600 dark:text-indigo-400">print</span>(response.<span class="text-purple-600 dark:text-purple-400">json</span>())</div>
                                </div>

                                <div x-show="activeTab === 'go'" x-transition x-cloak class="space-y-1">
                                    <div>req, _ := http.<span class="text-purple-600 dark:text-purple-400">NewRequest</span>(<span class="text-emerald-600 dark:text-emerald-400">"GET"</span>, <span class="text-emerald-600 dark:text-emerald-400">"{{ url('/api/v1/geo/provinces') }}"</span>, <span class="text-indigo-600 dark:text-indigo-400">nil</span>)</div>
                                    <div>req.Header.<span class="text-purple-600 dark:text-purple-400">Set</span>(<span class="text-emerald-600 dark:text-emerald-400">"Authorization"</span>, <span class="text-emerald-600 dark:text-emerald-400">"Bearer tateta_api_token"</span>)</div>
                                    <div>resp, _ := http.DefaultClient.<span class="text-purple-600 dark:text-purple-400">Do</span>(req)</div>
                                    <div><span class="text-purple-600 dark:text-purple-400 font-bold">defer</span> resp.Body.<span class="text-purple-600 dark:text-purple-400">Close</span>()</div>
                                </div>

                                <div x-show="activeTab === 'ruby'" x-transition x-cloak class="space-y-1">
                                    <div><span class="text-purple-600 dark:text-purple-400 font-bold">require</span> <span class="text-emerald-600 dark:text-emerald-400">'net/http'</span></div>
                                    <div><span class="text-purple-600 dark:text-purple-400 font-bold">require</span> <span class="text-emerald-600 dark:text-emerald-400">'json'</span></div>
                                    <div class="mt-2">uri = <span class="text-indigo-600 dark:text-indigo-400">URI</span>(<span class="text-emerald-600 dark:text-emerald-400">'{{ url('/api/v1/geo/provinces') }}'</span>)</div>
                                    <div>req = <span class="text-indigo-600 dark:text-indigo-400">Net::HTTP::Get</span>.<span class="text-purple-600 dark:text-purple-400">new</span>(uri)</div>
                                    <div>req[<span class="text-emerald-600 dark:text-emerald-400">'Authorization'</span>] = <span class="text-emerald-600 dark:text-emerald-400">'Bearer tateta_api_token'</span></div>
                                    <div>res = <span class="text-indigo-600 dark:text-indigo-400">Net::HTTP</span>.<span class="text-purple-600 dark:text-purple-400">start</span>(uri.hostname, uri.port) { |http| http.<span class="text-purple-600 dark:text-purple-400">request</span>(req) }</div>
                                    <div><span class="text-indigo-600 dark:text-indigo-400">puts</span> <span class="text-indigo-600 dark:text-indigo-400">JSON</span>.<span class="text-purple-600 dark:text-purple-400">parse</span>(res.body)</div>
                                </div>

                                <div x-show="activeTab === 'node'" x-transition x-cloak class="space-y-1">
                                    <div><span class="text-purple-600 dark:text-purple-400 font-bold">const</span> axios = <span class="text-purple-600 dark:text-purple-400">require</span>(<span class="text-emerald-600 dark:text-emerald-400">'axios'</span>);</div>
                                    <div class="mt-2">axios.<span class="text-purple-600 dark:text-purple-400">get</span>(<span class="text-emerald-600 dark:text-emerald-400">'{{ url('/api/v1/geo/provinces') }}'</span>, {</div>
                                    <div class="pl-4">headers: { <span class="text-emerald-600 dark:text-emerald-400">'Authorization'</span>: <span class="text-emerald-600 dark:text-emerald-400">'Bearer tateta_api_token'</span> }</div>
                                    <div>}).<span class="text-purple-600 dark:text-purple-400">then</span>(res =&gt; <span class="text-indigo-600 dark:text-indigo-400">console</span>.<span class="text-purple-600 dark:text-purple-400">log</span>(res.data));</div>
                                </div>

                             </div>
                        </div>
                    </div>

                </div>
            </section>

            <footer class="border-t border-slate-200 dark:border-gray-900 bg-white dark:bg-gray-950/40 backdrop-blur-sm py-12 text-center text-xs text-slate-500 dark:text-gray-500 space-y-2 transition-colors duration-300">
                <div class="flex items-center justify-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>{{ __('All operations are healthy & operational') }}</span>
                </div>
                <div>
                    {{ __('© 2026 TatetaGeo API. Developed by Samasta Teknologi Nuswantara.') }}
                </div>
            </footer>

        </div>
    </body>
</html>
