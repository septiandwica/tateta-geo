<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - TatetaGeo</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
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
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        };
        applyTheme();
    </script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-[#f8fafc] dark:bg-[#030712] text-slate-800 dark:text-gray-100 font-sans transition-colors duration-300">
    
    <!-- Background Effects -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none z-0">
        <div class="absolute -top-[40%] left-[10%] w-[600px] h-[600px] rounded-full bg-indigo-500/5 dark:bg-indigo-500/10 blur-[120px]"></div>
        <div class="absolute top-[20%] -right-[10%] w-[500px] h-[500px] rounded-full bg-purple-500/5 blur-[100px]"></div>
        <div class="absolute -bottom-[20%] left-[20%] w-[700px] h-[700px] rounded-full bg-emerald-500/5 blur-[150px]"></div>
    </div>

    <div class="relative flex h-screen z-10">
        <!-- Sidebar -->
        <div class="w-64 bg-white/30 dark:bg-gray-950/30 backdrop-blur-md border-r border-slate-200/80 dark:border-gray-800/60 flex flex-col">
            <div class="p-6 border-b border-slate-200/80 dark:border-gray-800/60">
                <div class="flex items-center gap-3">
                    <div class="h-10 w-10 rounded-xl bg-indigo-600 flex items-center justify-center">
                        <span class="text-white font-bold text-lg">T</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-lg font-bold font-display tracking-tight text-slate-900 dark:text-white leading-none">TATETA</span>
                        <span class="text-[10px] font-mono text-indigo-500 dark:text-indigo-400 uppercase tracking-widest font-semibold mt-0.5">ADMIN</span>
                    </div>
                </div>
            </div>

            <nav class="flex-1 p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white font-semibold' : 'text-slate-600 dark:text-gray-400 hover:bg-slate-100 dark:hover:bg-gray-900/60' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.users.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-indigo-600 text-white font-semibold' : 'text-slate-600 dark:text-gray-400 hover:bg-slate-100 dark:hover:bg-gray-900/60' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>Users</span>
                </a>
                <a href="{{ route('admin.activities.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.activities.*') ? 'bg-indigo-600 text-white font-semibold' : 'text-slate-600 dark:text-gray-400 hover:bg-slate-100 dark:hover:bg-gray-900/60' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                    <span>Activity Logs</span>
                </a>
                
                <div class="border-t border-slate-200/80 dark:border-gray-800/60 my-4"></div>
                
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium text-slate-500 dark:text-gray-500 hover:bg-slate-100 dark:hover:bg-gray-900/60 transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>User Dashboard</span>
                </a>
            </nav>

            <div class="p-4 border-t border-slate-200/80 dark:border-gray-800/60">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-slate-900 dark:text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-500 dark:text-gray-400 capitalize">{{ auth()->user()->role }}</p>
                    </div>
                    <button onclick="window.toggleTheme()" 
                            class="p-2 rounded-lg text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-gray-900/60 transition-all duration-200">
                        <svg class="w-5 h-5 hidden dark:block text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                        </svg>
                        <svg class="w-5 h-5 block dark:hidden text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                        </svg>
                    </button>
                </div>
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 bg-slate-100 dark:bg-gray-900/60 hover:bg-slate-200 dark:hover:bg-gray-800 text-slate-700 dark:text-gray-300 text-sm font-medium rounded-lg transition-all duration-200">
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <div class="bg-white/30 dark:bg-gray-950/30 backdrop-blur-md border-b border-slate-200/80 dark:border-gray-800/60 px-8 py-6">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white font-display">@yield('header', 'Dashboard')</h2>
            </div>

            <!-- Content Area -->
            <div class="flex-1 overflow-auto">
                <div class="p-8">
                    <!-- Flash Messages -->
                    @if ($message = Session::get('success'))
                        <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 rounded-xl">
                            {{ $message }}
                        </div>
                    @endif

                    @if ($message = Session::get('error'))
                        <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 rounded-xl">
                            {{ $message }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 rounded-xl">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Page Content -->
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</body>
</html>
