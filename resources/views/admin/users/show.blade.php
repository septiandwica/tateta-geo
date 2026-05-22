@extends('layouts.admin')

@section('title', 'User Details')
@section('header', 'User Details')

@section('content')
<!-- User Info Card -->
<div class="bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 rounded-xl p-6 mb-6">
    <div class="flex justify-between items-start mb-6">
        <div>
            <h3 class="text-2xl font-bold text-slate-900 dark:text-white font-display">{{ $user->name }}</h3>
            <p class="text-slate-600 dark:text-gray-400 mt-1">{{ $user->email }}</p>
        </div>
        <a href="{{ route('admin.users.edit', $user) }}" 
           class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition-all duration-200">
            Edit User
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="p-4 bg-slate-50 dark:bg-gray-950/50 rounded-lg">
            <p class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider mb-2">Role</p>
            @if($user->role === 'super_admin')
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300 font-semibold">
                    Super Admin
                </span>
            @elseif($user->role === 'admin')
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 dark:bg-indigo-900/30 text-indigo-800 dark:text-indigo-300 font-semibold">
                    Admin
                </span>
            @else
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 dark:bg-gray-800 text-slate-800 dark:text-gray-300">
                    User
                </span>
            @endif
        </div>

        <div class="p-4 bg-slate-50 dark:bg-gray-950/50 rounded-lg">
            <p class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider mb-2">Status</p>
            @if($user->status === 'active')
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 dark:bg-emerald-900/30 text-emerald-800 dark:text-emerald-300 font-semibold">
                    Active
                </span>
            @elseif($user->status === 'inactive')
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300 font-semibold">
                    Inactive
                </span>
            @else
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 font-semibold">
                    Suspended
                </span>
            @endif
        </div>

        <div class="p-4 bg-slate-50 dark:bg-gray-950/50 rounded-lg">
            <p class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider mb-2">Joined</p>
            <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $user->created_at->format('M d, Y') }}</p>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-slate-200 dark:border-gray-800">
        <div class="p-4 bg-indigo-50/50 dark:bg-indigo-950/20 rounded-lg border border-indigo-100 dark:border-indigo-900/50">
            <p class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider mb-1">API Quota (Monthly)</p>
            <p class="text-2xl font-bold text-indigo-900 dark:text-indigo-300">{{ number_format($user->api_quota) }}</p>
        </div>

        <div class="p-4 bg-blue-50/50 dark:bg-blue-950/20 rounded-lg border border-blue-100 dark:border-blue-900/50">
            <p class="text-xs font-semibold text-blue-600 dark:text-blue-400 uppercase tracking-wider mb-1">API Calls This Month</p>
            <p class="text-2xl font-bold text-blue-900 dark:text-blue-300">{{ number_format($user->api_calls_this_month) }}</p>
        </div>
    </div>
</div>

<!-- Activity History -->
<div class="bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 rounded-xl mb-6">
    <div class="px-6 py-4 border-b border-slate-200 dark:border-gray-800">
        <h3 class="text-lg font-bold text-slate-900 dark:text-white font-display">Activity History</h3>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50 dark:bg-gray-950/50 border-b border-slate-200 dark:border-gray-800">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider">Action</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider">Endpoint</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider">Method</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider">Time</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-gray-800">
                @forelse($activities as $activity)
                    <tr class="hover:bg-slate-50 dark:hover:bg-gray-950/50 transition-colors duration-150">
                        <td class="px-6 py-4 text-sm text-slate-900 dark:text-white">{{ $activity->action }}</td>
                        <td class="px-6 py-4 text-sm font-mono text-xs text-slate-600 dark:text-gray-400">{{ $activity->endpoint }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-gray-400">{{ $activity->method }}</td>
                        <td class="px-6 py-4 text-sm">
                            @if($activity->status_code >= 200 && $activity->status_code < 300)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 dark:bg-emerald-900/30 text-emerald-800 dark:text-emerald-300">
                                    {{ $activity->status_code }}
                                </span>
                            @elseif($activity->status_code >= 400)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300">
                                    {{ $activity->status_code }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300">
                                    {{ $activity->status_code }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-gray-400">
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

    <div class="px-6 py-4 border-t border-slate-200 dark:border-gray-800">
        {{ $activities->links() }}
    </div>
</div>

<!-- API Usage Stats -->
<div class="bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 rounded-xl">
    <div class="px-6 py-4 border-b border-slate-200 dark:border-gray-800">
        <h3 class="text-lg font-bold text-slate-900 dark:text-white font-display">API Usage (Last 30 Days)</h3>
    </div>

    <div class="p-6">
        @forelse($usage as $item)
            <div class="flex justify-between items-center py-3 border-b border-slate-200 dark:border-gray-800 last:border-0">
                <div>
                    <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $item->endpoint }}</p>
                    <p class="text-xs text-slate-500 dark:text-gray-400">{{ $item->date->format('M d, Y') }}</p>
                </div>
                <p class="text-sm font-bold text-indigo-600 dark:text-indigo-400">{{ number_format($item->count) }} calls</p>
            </div>
        @empty
            <div class="text-center text-slate-500 dark:text-gray-400 py-8">
                <div class="flex justify-center text-slate-400 dark:text-gray-500 mb-2">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                    </svg>
                </div>
                <div class="text-sm">No API usage data</div>
            </div>
        @endforelse
    </div>
</div>
@endsection
