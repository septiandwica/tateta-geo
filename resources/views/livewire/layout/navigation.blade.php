<?php

use App\Livewire\Actions\Logout;

$logout = function (Logout $logout) {
    $logout();

    $this->redirect('/', navigate: true);
};

?>

<nav x-data="{ open: false }" class="bg-white/80 dark:bg-gray-950/80 border-b border-slate-200/80 dark:border-gray-900/60 backdrop-blur-md sticky top-0 z-50 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="/" wire:navigate class="flex items-center gap-2">
                        <img src="{{ asset('icon/logo.png') }}" alt="Logo" class="h-8 w-auto rounded-lg">
                        <div class="flex flex-col">
                            <span class="text-sm font-black font-display tracking-tight text-slate-900 dark:text-white leading-none transition-colors duration-300">TATETA</span>
                            <span class="text-[8px] font-mono text-indigo-500 dark:text-indigo-400 uppercase tracking-widest font-bold leading-none mt-0.5">GEO API</span>
                        </div>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex sm:items-center">
                    <x-nav-link :href="route('dashboard', ['service' => 'dashboard'])" :active="request()->routeIs('dashboard') && (request()->query('service', 'dashboard') === 'dashboard')" wire:navigate class="text-slate-600 dark:text-gray-300 hover:text-slate-900 dark:hover:text-white">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if(request()->routeIs('dashboard'))
                        <span class="text-slate-300 dark:text-gray-800">/</span>

                        @php
                            $currentService = request()->query('service', 'dashboard');
                            $serviceName = 'Services';
                            if ($currentService === 'geo') $serviceName = 'Indonesia Geo API';
                            if ($currentService === 'telemetry') $serviceName = 'System Health Check';
                        @endphp
                        
                        <x-dropdown align="left" width="56">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-1.5 border border-slate-200 dark:border-gray-800 text-xs font-semibold rounded-lg text-slate-700 dark:text-gray-300 bg-slate-50 dark:bg-gray-900 hover:text-slate-900 dark:hover:text-white hover:border-slate-300 dark:hover:border-indigo-500/30 focus:outline-none transition ease-in-out duration-150 shadow-sm">
                                    <span class="size-2 rounded-full {{ $currentService !== 'dashboard' ? 'bg-emerald-500 animate-pulse' : 'bg-slate-400' }} mr-2"></span>
                                    <span>{{ $serviceName }}</span>
                                    <svg class="ms-1.5 h-3 w-3 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('dashboard', ['service' => 'geo'])" wire:navigate class="flex items-center justify-between text-xs">
                                    <span>Indonesia Geo API</span>
                                    <span class="px-1.5 py-0.5 rounded bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 font-bold uppercase tracking-wider text-[9px]">Active</span>
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('dashboard', ['service' => 'telemetry'])" wire:navigate class="flex items-center justify-between text-xs">
                                    <span>System Health Check</span>
                                    <span class="px-1.5 py-0.5 rounded bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 font-bold uppercase tracking-wider text-[9px]">Active</span>
                                </x-dropdown-link>

                            </x-slot>
                        </x-dropdown>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 gap-3">
                
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

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-slate-200 dark:border-gray-800 text-sm leading-4 font-medium rounded-lg text-slate-600 dark:text-gray-300 bg-white/40 dark:bg-gray-900/40 hover:text-slate-900 dark:hover:text-white hover:border-slate-300 dark:hover:border-indigo-500/30 focus:outline-none transition ease-in-out duration-150 shadow-sm">
                            <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile')" wire:navigate>
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-gray-900 border border-slate-200 dark:border-gray-800 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white dark:bg-gray-950 border-b border-slate-200 dark:border-gray-900">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate class="text-slate-600 dark:text-gray-300">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-slate-200 dark:border-gray-800">
            <div class="px-4 flex items-center justify-between">
                <div>
                    <div class="font-medium text-base text-slate-800 dark:text-white" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                    <div class="font-medium text-sm text-slate-500 dark:text-gray-400">{{ auth()->user()->email }}</div>
                </div>
                
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
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile')" wire:navigate class="text-slate-500 dark:text-gray-400">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link class="text-slate-500 dark:text-gray-400">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>
</nav>
