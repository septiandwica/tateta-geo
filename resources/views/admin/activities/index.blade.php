@extends('layouts.admin')

@section('title', 'Activity Logs')
@section('header', 'Activity Logs')

@section('content')
<div class="bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 rounded-xl">
    <!-- Filters -->
    <div class="px-6 py-4 border-b border-slate-200 dark:border-gray-800">
        <form method="GET" action="{{ route('admin.activities.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider mb-2">User ID</label>
                <input type="text" 
                       name="user_id" 
                       placeholder="Filter by user"
                       value="{{ request('user_id') }}"
                       class="w-full px-4 py-2 bg-white dark:bg-gray-950 border border-slate-200 dark:border-gray-800 rounded-lg text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 text-sm">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider mb-2">Action</label>
                <input type="text" 
                       name="action" 
                       placeholder="e.g., api_call"
                       value="{{ request('action') }}"
                       class="w-full px-4 py-2 bg-white dark:bg-gray-950 border border-slate-200 dark:border-gray-800 rounded-lg text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 text-sm">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider mb-2">Endpoint</label>
                <input type="text" 
                       name="endpoint" 
                       placeholder="e.g., /api/v1/geo"
                       value="{{ request('endpoint') }}"
                       class="w-full px-4 py-2 bg-white dark:bg-gray-950 border border-slate-200 dark:border-gray-800 rounded-lg text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200 text-sm">
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition-all duration-200 text-sm">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50 dark:bg-gray-950/50 border-b border-slate-200 dark:border-gray-800">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider">Action</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider">Endpoint</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider">Method</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider">IP Address</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider">Time</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-gray-800">
                @forelse($activities as $activity)
                    <tr class="hover:bg-slate-50 dark:hover:bg-gray-950/50 transition-colors duration-150">
                        <td class="px-6 py-4 text-sm">
                            <a href="{{ route('admin.users.show', $activity->user) }}" class="font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors">
                                {{ $activity->user->name }}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-gray-400">{{ $activity->action }}</td>
                        <td class="px-6 py-4 text-sm font-mono text-xs text-slate-600 dark:text-gray-400">{{ $activity->endpoint }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 dark:bg-gray-800 text-slate-800 dark:text-gray-300">
                                {{ $activity->method }}
                            </span>
                        </td>
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
                        <td class="px-6 py-4 text-sm font-mono text-xs text-slate-600 dark:text-gray-400">{{ $activity->ip_address }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-gray-400">
                            {{ $activity->created_at->diffForHumans() }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <a href="{{ route('admin.activities.show', $activity) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 font-semibold transition-colors">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-slate-500 dark:text-gray-400">
                            <div class="flex justify-center text-slate-400 dark:text-gray-500 mb-2">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 13.5h3.86a2.25 2.25 0 012.008 1.24l.885 1.77a2.25 2.25 0 002.007 1.24h1.98a2.25 2.25 0 002.007-1.24l.885-1.77a2.25 2.25 0 012.007-1.24h3.86m-18 0h18a2.25 2.25 0 012.25 2.25v4.5A2.25 2.25 0 0118.75 21H5.25A2.25 2.25 0 013 18.75v-4.5A2.25 2.25 0 015.25 13.5zm3-7.5l3 3m0 0l3-3m-3 3V1.5" />
                                </svg>
                            </div>
                            <div class="text-sm">No activities found</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-slate-200 dark:border-gray-800">
        {{ $activities->links() }}
    </div>
</div>
@endsection
