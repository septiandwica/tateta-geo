@extends('layouts.admin')

@section('title', 'Users')
@section('header', 'User Management')

@section('content')
<div class="bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 rounded-xl">
    <div class="px-6 py-4 border-b border-slate-200 dark:border-gray-800 flex justify-between items-center">
        <div>
            <h3 class="text-lg font-bold text-slate-900 dark:text-white font-display">All Users</h3>
            <p class="text-xs text-slate-500 dark:text-gray-400 mt-1">Manage user accounts and permissions</p>
        </div>
        <div class="text-sm font-semibold text-slate-600 dark:text-gray-400">
            Total: <span class="text-indigo-600 dark:text-indigo-400">{{ $users->total() }}</span> users
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-slate-50 dark:bg-gray-950/50 border-b border-slate-200 dark:border-gray-800">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider">API Quota</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider">Joined</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-gray-800">
                @forelse($users as $user)
                    <tr class="hover:bg-slate-50 dark:hover:bg-gray-950/50 transition-colors duration-150">
                        <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">
                            {{ $user->name }}
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-gray-400">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4 text-sm">
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
                        </td>
                        <td class="px-6 py-4 text-sm">
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
                        </td>
                        <td class="px-6 py-4 text-sm font-mono text-slate-600 dark:text-gray-400">
                            {{ number_format($user->api_quota) }}
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600 dark:text-gray-400">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.users.show', $user) }}" 
                                   class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 font-semibold transition-colors">
                                    View
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" 
                                   class="text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 font-semibold transition-colors">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" 
                                      onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 font-semibold transition-colors">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-slate-500 dark:text-gray-400">
                            <div class="flex justify-center text-slate-400 dark:text-gray-500 mb-2">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A3.318 3.318 0 0114.17 21m-.182-1.972a9.99 9.99 0 00-4.594 0M14 10a3 3 0 11-6 0 3 3 0 016 0zm6 2.5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="text-sm">No users found</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-slate-200 dark:border-gray-800">
        {{ $users->links() }}
    </div>
</div>
@endsection
