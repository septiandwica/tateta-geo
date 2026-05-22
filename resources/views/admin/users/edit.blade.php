@extends('layouts.admin')

@section('title', 'Edit User')
@section('header', 'Edit User')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 rounded-xl p-6">
        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 dark:text-gray-300 mb-2">
                    Name
                </label>
                <input type="text" 
                       name="name" 
                       id="name" 
                       value="{{ old('name', $user->name) }}"
                       class="w-full px-4 py-3 bg-white dark:bg-gray-950 border border-slate-200 dark:border-gray-800 rounded-lg text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                       required>
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 dark:text-gray-300 mb-2">
                    Email
                </label>
                <input type="email" 
                       name="email" 
                       id="email" 
                       value="{{ old('email', $user->email) }}"
                       class="w-full px-4 py-3 bg-white dark:bg-gray-950 border border-slate-200 dark:border-gray-800 rounded-lg text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                       required>
            </div>

            <!-- Role -->
            <div>
                <label for="role" class="block text-sm font-semibold text-slate-700 dark:text-gray-300 mb-2">
                    Role
                </label>
                <select name="role" 
                        id="role"
                        class="w-full px-4 py-3 bg-white dark:bg-gray-950 border border-slate-200 dark:border-gray-800 rounded-lg text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                        required>
                    <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>
                        User
                    </option>
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>
                    <option value="super_admin" {{ old('role', $user->role) === 'super_admin' ? 'selected' : '' }}>
                        Super Admin
                    </option>
                </select>
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-semibold text-slate-700 dark:text-gray-300 mb-2">
                    Status
                </label>
                <select name="status" 
                        id="status"
                        class="w-full px-4 py-3 bg-white dark:bg-gray-950 border border-slate-200 dark:border-gray-800 rounded-lg text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                        required>
                    <option value="active" {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>
                        Active
                    </option>
                    <option value="inactive" {{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}>
                        Inactive
                    </option>
                    <option value="suspended" {{ old('status', $user->status) === 'suspended' ? 'selected' : '' }}>
                        Suspended
                    </option>
                </select>
            </div>

            <!-- API Quota -->
            <div>
                <label for="api_quota" class="block text-sm font-semibold text-slate-700 dark:text-gray-300 mb-2">
                    API Quota (monthly)
                </label>
                <input type="number" 
                       name="api_quota" 
                       id="api_quota" 
                       value="{{ old('api_quota', $user->api_quota) }}"
                       class="w-full px-4 py-3 bg-white dark:bg-gray-950 border border-slate-200 dark:border-gray-800 rounded-lg text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                       min="0"
                       required>
                <p class="text-xs text-slate-500 dark:text-gray-400 mt-2">
                    Current usage this month: <span class="font-semibold text-indigo-600 dark:text-indigo-400">{{ number_format($user->api_calls_this_month) }}</span> calls
                </p>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between pt-4 border-t border-slate-200 dark:border-gray-800">
                <a href="{{ route('admin.users.show', $user) }}" 
                   class="px-6 py-3 bg-slate-100 dark:bg-gray-800 text-slate-700 dark:text-gray-300 font-semibold rounded-lg hover:bg-slate-200 dark:hover:bg-gray-700 transition-all duration-200">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg transition-all duration-200">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
