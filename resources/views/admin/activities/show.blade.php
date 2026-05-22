@extends('layouts.admin')

@section('title', 'Activity Details')
@section('header', 'Activity Details')

@section('content')
<div class="bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 rounded-xl p-6">
    <div class="mb-6">
        <a href="{{ route('admin.activities.index') }}" class="inline-flex items-center text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Activities
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Basic Info -->
        <div class="p-6 bg-slate-50 dark:bg-gray-950/50 rounded-lg border border-slate-200 dark:border-gray-800">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white font-display mb-4">Basic Information</h3>
            
            <div class="space-y-4">
                <div>
                    <p class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider mb-1">User</p>
                    <a href="{{ route('admin.users.show', $activity->user) }}" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors">
                        {{ $activity->user->name }}
                    </a>
                </div>

                <div>
                    <p class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider mb-1">Action</p>
                    <p class="text-sm font-medium text-slate-900 dark:text-white">{{ $activity->action }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider mb-1">Endpoint</p>
                    <p class="text-sm font-mono text-slate-900 dark:text-white">{{ $activity->endpoint }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider mb-1">Method</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 dark:bg-gray-800 text-slate-800 dark:text-gray-300">
                        {{ $activity->method }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Response Info -->
        <div class="p-6 bg-slate-50 dark:bg-gray-950/50 rounded-lg border border-slate-200 dark:border-gray-800">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white font-display mb-4">Response Information</h3>
            
            <div class="space-y-4">
                <div>
                    <p class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider mb-1">Status Code</p>
                    @if($activity->status_code >= 200 && $activity->status_code < 300)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 dark:bg-emerald-900/30 text-emerald-800 dark:text-emerald-300">
                            {{ $activity->status_code }} Success
                        </span>
                    @elseif($activity->status_code >= 400)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300">
                            {{ $activity->status_code }} Error
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300">
                            {{ $activity->status_code }} Other
                        </span>
                    @endif
                </div>

                <div>
                    <p class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider mb-1">IP Address</p>
                    <p class="text-sm font-mono text-slate-900 dark:text-white">{{ $activity->ip_address }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider mb-1">Timestamp</p>
                    <p class="text-sm text-slate-900 dark:text-white">{{ $activity->created_at->format('M d, Y H:i:s') }}</p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider mb-1">User Agent</p>
                    <p class="text-xs text-slate-600 dark:text-gray-400 break-words">{{ $activity->user_agent }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Metadata -->
    @if($activity->metadata)
        <div class="border-t border-slate-200 dark:border-gray-800 pt-6">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white font-display mb-4">Metadata</h3>
            
            <div class="bg-slate-50 dark:bg-gray-950/50 rounded-lg p-4 overflow-auto border border-slate-200 dark:border-gray-800">
                <pre class="text-xs text-slate-700 dark:text-gray-300 font-mono">{{ json_encode($activity->metadata, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
            </div>
        </div>
    @endif
</div>
@endsection
