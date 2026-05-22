@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- Total Users Card -->
    <div class="group relative overflow-hidden bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 rounded-xl hover:bg-slate-50 dark:hover:bg-gray-800/50 transition-all duration-300">
        <div class="p-6">
            <div class="flex items-center justify-between mb-3">
                <div class="text-xs font-semibold text-slate-400 dark:text-gray-500 font-mono uppercase tracking-wider">Total Users</div>
                <div class="h-10 w-10 rounded-lg bg-indigo-50 dark:bg-indigo-950/50 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-slate-900 dark:text-white font-display">{{ $stats['total_users'] }}</div>
            <div class="text-xs text-slate-500 dark:text-gray-400 mt-2">All registered users</div>
        </div>
    </div>

    <!-- Active Users Card -->
    <div class="group relative overflow-hidden bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 rounded-xl hover:bg-slate-50 dark:hover:bg-gray-800/50 transition-all duration-300">
        <div class="p-6">
            <div class="flex items-center justify-between mb-3">
                <div class="text-xs font-semibold text-slate-400 dark:text-gray-500 font-mono uppercase tracking-wider">Active Users</div>
                <div class="h-10 w-10 rounded-lg bg-emerald-50 dark:bg-emerald-950/50 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-emerald-600 dark:text-emerald-400 font-display">{{ $stats['active_users'] }}</div>
            <div class="text-xs text-slate-500 dark:text-gray-400 mt-2">Currently active accounts</div>
        </div>
    </div>

    <!-- API Calls Today Card -->
    <div class="group relative overflow-hidden bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 rounded-xl hover:bg-slate-50 dark:hover:bg-gray-800/50 transition-all duration-300">
        <div class="p-6">
            <div class="flex items-center justify-between mb-3">
                <div class="text-xs font-semibold text-slate-400 dark:text-gray-500 font-mono uppercase tracking-wider">API Calls Today</div>
                <div class="h-10 w-10 rounded-lg bg-blue-50 dark:bg-blue-950/50 flex items-center justify-center text-blue-600 dark:text-blue-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-blue-600 dark:text-blue-400 font-display">{{ number_format($stats['api_calls_today']) }}</div>
            <div class="text-xs text-slate-500 dark:text-gray-400 mt-2">Requests processed today</div>
        </div>
    </div>

    <!-- API Calls This Month Card -->
    <div class="group relative overflow-hidden bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 rounded-xl hover:bg-slate-50 dark:hover:bg-gray-800/50 transition-all duration-300">
        <div class="p-6">
            <div class="flex items-center justify-between mb-3">
                <div class="text-xs font-semibold text-slate-400 dark:text-gray-500 font-mono uppercase tracking-wider">API Calls This Month</div>
                <div class="h-10 w-10 rounded-lg bg-purple-50 dark:bg-purple-950/50 flex items-center justify-center text-purple-600 dark:text-purple-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-purple-600 dark:text-purple-400 font-display">{{ number_format($stats['api_calls_this_month']) }}</div>
            <div class="text-xs text-slate-500 dark:text-gray-400 mt-2">Monthly total requests</div>
        </div>
    </div>
</div>

<!-- Recent Activities Section -->
<div class="bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 rounded-xl">
    <div class="px-6 py-4 border-b border-slate-200 dark:border-gray-800">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white font-display">Recent Activities</h3>
                <p class="text-xs text-slate-500 dark:text-gray-400 mt-1">Latest user actions and API calls</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="size-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-xs font-mono text-emerald-600 dark:text-emerald-400 font-semibold uppercase tracking-wider">Live</span>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50 dark:bg-gray-950/50 border-b border-slate-200 dark:border-gray-800">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider">Action</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider">Endpoint</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider">Time</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-gray-800">
                @forelse($recentActivities as $activity)
                    <tr class="hover:bg-slate-50 dark:hover:bg-gray-950/50 transition-colors duration-150">
                        <td class="px-6 py-4 text-sm">
                            <a href="{{ route('admin.users.show', $activity->user) }}" class="font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors">
                                {{ $activity->user->name }}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-gray-400">{{ $activity->action }}</td>
                        <td class="px-6 py-4 text-sm font-mono text-xs text-slate-600 dark:text-gray-400">{{ $activity->endpoint }}</td>
                        <td class="px-6 py-4 text-sm">
                            @if($activity->status_code >= 200 && $activity->status_code < 300)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 dark:bg-emerald-900/30 text-emerald-800 dark:text-emerald-300 font-semibold">
                                    {{ $activity->status_code }}
                                </span>
                            @elseif($activity->status_code >= 400)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 font-semibold">
                                    {{ $activity->status_code }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300 font-semibold">
                                    {{ $activity->status_code }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500 dark:text-gray-400">
                            {{ $activity->created_at->diffForHumans() }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500 dark:text-gray-400">
                            <div class="flex justify-center text-slate-400 dark:text-gray-500 mb-2">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 13.5h3.86a2.25 2.25 0 012.008 1.24l.885 1.77a2.25 2.25 0 002.007 1.24h1.98a2.25 2.25 0 002.007-1.24l.885-1.77a2.25 2.25 0 012.007-1.24h3.86m-18 0h18a2.25 2.25 0 012.25 2.25v4.5A2.25 2.25 0 0118.75 21H5.25A2.25 2.25 0 013 18.75v-4.5A2.25 2.25 0 015.25 13.5zm3-7.5l3 3m0 0l3-3m-3 3V1.5" />
                                </svg>
                            </div>
                            <div class="text-sm">No activities yet</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Quick Actions -->
<div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
    <a href="{{ route('admin.users.index') }}" class="group relative overflow-hidden bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl p-6 transition-all duration-300">
        <div class="relative">
            <div class="mb-3 text-white">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <p class="text-lg font-bold font-display">Manage Users</p>
            <p class="text-sm text-indigo-100 mt-2 font-medium">View and manage all users</p>
        </div>
    </a>

    <a href="{{ route('admin.activities.index') }}" class="group relative overflow-hidden bg-purple-600 hover:bg-purple-700 text-white rounded-xl p-6 transition-all duration-300">
        <div class="relative">
            <div class="mb-3 text-white">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
            </div>
            <p class="text-lg font-bold font-display">View Activity Logs</p>
            <p class="text-sm text-purple-100 mt-2 font-medium">Track all user activities</p>
        </div>
    </a>
</div>
@endsection
