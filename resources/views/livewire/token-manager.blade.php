<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;
use function Livewire\Volt\state;
use function Livewire\Volt\rules;

state([
    'tokenName' => '',
    'expiresAt' => '', // Expiration selection during creation
    'plainTextToken' => '',
    'tokens' => fn () => Auth::user()->tokens()->orderBy('created_at', 'desc')->get(),
    'editingTokenId' => null,
    'editingExpiresAt' => '',
]);

rules([
    'tokenName' => ['required', 'string', 'min:3', 'max:255'],
]);

$createToken = function () {
    $this->validate();

    // Create the token model instance via standard Sanctum API
    $token = Auth::user()->createToken(
        $this->tokenName,
        ['*'],
        $this->expiresAt ? Carbon::parse($this->expiresAt) : null
    );

    // Save the securely encrypted version to database for client peeking
    $token->accessToken->forceFill([
        'encrypted_token' => Crypt::encryptString($token->plainTextToken)
    ])->save();

    $this->plainTextToken = $token->plainTextToken;
    $this->tokenName = '';
    $this->expiresAt = '';

    $this->tokens = Auth::user()->tokens()->orderBy('created_at', 'desc')->get();
};

$getMaskedToken = function ($token) {
    if ($token->encrypted_token) {
        try {
            $decrypted = Crypt::decryptString($token->encrypted_token);
            $parts = explode('|', $decrypted);
            $key = isset($parts[1]) ? $parts[1] : $decrypted;
            $len = strlen($key);
            if ($len > 8) {
                return '••••••••' . substr($key, -8);
            }
            return '••••••••' . substr($key, -4);
        } catch (\Exception $e) {
            return '••••••••••••';
        }
    }
    return '••••••••••••';
};

$copyTokenDirect = function ($tokenId) {
    $token = Auth::user()->tokens()->where('id', $tokenId)->first();
    if ($token && $token->encrypted_token) {
        try {
            $decrypted = Crypt::decryptString($token->encrypted_token);
            $this->dispatch('copy-token', token: $decrypted, id: $tokenId);
        } catch (\Exception $e) {
            // Silence decryption issues
        }
    }
};

$startEditExpiration = function ($tokenId) {
    $token = Auth::user()->tokens()->where('id', $tokenId)->first();
    if ($token) {
        $this->editingTokenId = $tokenId;
        $this->editingExpiresAt = $token->expires_at ? $token->expires_at->format('Y-m-d') : '';
    }
};

$cancelEditExpiration = function () {
    $this->editingTokenId = null;
    $this->editingExpiresAt = '';
};

$saveEditExpiration = function ($tokenId) {
    Auth::user()->tokens()->where('id', $tokenId)->update([
        'expires_at' => $this->editingExpiresAt ? Carbon::parse($this->editingExpiresAt) : null
    ]);
    $this->editingTokenId = null;
    $this->editingExpiresAt = '';
    $this->tokens = Auth::user()->tokens()->orderBy('created_at', 'desc')->get();
};

$revokeToken = function ($tokenId) {
    Auth::user()->tokens()->where('id', $tokenId)->delete();

    $this->tokens = Auth::user()->tokens()->orderBy('created_at', 'desc')->get();
    
    $this->plainTextToken = '';
};

?>

<div class="space-y-6" x-data="{ copiedId: null }" @copy-token.window="navigator.clipboard.writeText($event.detail.token); copiedId = $event.detail.id; setTimeout(() => { if (copiedId === $event.detail.id) copiedId = null; }, 2000)">
    
    <!-- Token Creation Panel -->
    <div class="p-6 bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 shadow-sm rounded-xl space-y-6">
        
        <div class="max-w-2xl">
            <header class="space-y-2">
                <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full border border-indigo-200 dark:border-indigo-500/30 bg-indigo-50 dark:bg-indigo-500/5 text-indigo-600 dark:text-indigo-400 text-xs font-semibold uppercase tracking-wider">
                    {{ __('Credential Node') }}
                </div>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white">
                    {{ __('API Token Manager') }}
                </h2>
                <p class="text-xs text-slate-500 dark:text-gray-400 leading-relaxed">
                    {{ __('Generate secure access tokens to connect client microservices (like Aksara) to Tateta administrative API nodes.') }}
                </p>
            </header>

            <form wire:submit="createToken" class="mt-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-2xl">
                    <div>
                        <x-input-label for="tokenName" value="{{ __('Token Name / Client App') }}" class="text-[10px] uppercase tracking-wider font-bold text-slate-500 dark:text-gray-400" />
                        <x-text-input 
                            wire:model="tokenName" 
                            id="tokenName" 
                            name="tokenName" 
                            type="text" 
                            class="block w-full mt-1.5 rounded-xl border-slate-200 dark:border-gray-800 bg-white/40 dark:bg-gray-950/40 text-slate-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500/20 text-sm py-2.5 transition shadow-sm" 
                            placeholder="{{ __('e.g., Aksara Production Gateway') }}" 
                            required 
                            autofocus
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('tokenName')" />
                    </div>

                    <div>
                        <x-input-label for="expiresAt" value="{{ __('Expiration / Revoke Date (Optional)') }}" class="text-[10px] uppercase tracking-wider font-bold text-slate-500 dark:text-gray-400" />
                        <x-text-input 
                            wire:model="expiresAt" 
                            id="expiresAt" 
                            name="expiresAt" 
                            type="date" 
                            class="block w-full mt-1.5 rounded-xl border-slate-200 dark:border-gray-800 bg-white/40 dark:bg-gray-950/40 text-slate-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500/20 text-sm py-2.5 transition shadow-sm" 
                        />
                        <x-input-error class="mt-2" :messages="$errors->get('expiresAt')" />
                    </div>
                </div>

                <div class="flex items-center">
                    <button 
                        type="submit" 
                        wire:loading.attr="disabled"
                        class="inline-flex items-center justify-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-sm transition-all duration-150 gap-2"
                    >
                        <span wire:loading.remove wire:target="createToken" class="flex items-center gap-1.5">
                            {{ __('Generate Token') }}
                            <svg class="size-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </span>
                        <span wire:loading wire:target="createToken" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            {{ __('Generating...') }}
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Live Generated Result Callout -->
    @if ($plainTextToken)
        <div 
            x-data="{ copied: false, token: '{{ $plainTextToken }}' }" 
            class="p-5 bg-emerald-500/5 border border-emerald-500/20 shadow-sm rounded-xl flex flex-col md:flex-row items-start md:items-center justify-between gap-6"
        >
            <div class="space-y-2 max-w-2xl">
                <div class="flex items-center gap-2">
                    <span class="size-2 rounded-full bg-emerald-500 animate-ping"></span>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">
                        {{ __('Token Generated Successfully!') }}
                    </h3>
                </div>
                <p class="text-xs text-slate-500 dark:text-gray-400 leading-relaxed">
                    {{ __('Please copy this token now. You can also view or edit it anytime from the listing below.') }}
                </p>
                <div class="mt-3 font-mono text-[13px] bg-white dark:bg-gray-950 border border-emerald-500/20 rounded-xl p-4 text-slate-900 dark:text-emerald-300 select-all break-all shadow-inner leading-relaxed">
                    {{ $plainTextToken }}
                </div>
            </div>
            
            <button 
                type="button" 
                x-on:click="navigator.clipboard.writeText(token); copied = true; setTimeout(() => copied = false, 2000)"
                class="inline-flex items-center justify-center px-5 py-3 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-sm transition gap-1.5 focus:outline-none w-full md:w-auto"
            >
                <span x-show="!copied" class="flex items-center gap-1.5">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                    </svg>
                    {{ __('Copy Token') }}
                </span>
                <span x-show="copied" class="flex items-center gap-1.5">
                    <svg class="h-4 w-4 text-emerald-100" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ __('Copied!') }}
                </span>
            </button>
        </div>
    @endif



    <!-- Active Tokens Table Panel -->
    <div class="p-6 bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 shadow-sm rounded-xl space-y-6">
        
        <header class="mb-2">
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">
                {{ __('Active API Access Tokens') }}
            </h2>
            <p class="text-xs text-slate-500 dark:text-gray-400 mt-1">
                {{ __('Manage active client connections allowed to query TatetaGeo API endpoints.') }}
            </p>
        </header>

        @if ($tokens->isEmpty())
            <div class="text-xs text-slate-500 dark:text-gray-400 py-8 italic border-t border-slate-100 dark:border-gray-800 flex items-center justify-center gap-2">
                <svg class="size-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                </svg>
                {{ __('No API tokens generated yet. Enter a client name above to generate your first credential key.') }}
            </div>
        @else
            <div class="overflow-hidden border border-slate-200 dark:border-gray-800 rounded-xl">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 dark:divide-gray-800">
                        <thead class="bg-slate-50/70 dark:bg-gray-950/50 font-mono text-[10px] text-slate-400 uppercase font-bold">
                            <tr>
                                <th scope="col" class="px-5 py-3 text-left">
                                    {{ __('Client / Name') }}
                                </th>
                                <th scope="col" class="px-5 py-3 text-left">
                                    {{ __('Token Key') }}
                                </th>
                                <th scope="col" class="px-5 py-3 text-left">
                                    {{ __('Last Used') }}
                                </th>
                                <th scope="col" class="px-5 py-3 text-left">
                                    {{ __('Issued At') }}
                                </th>
                                <th scope="col" class="px-5 py-3 text-left">
                                    {{ __('Expires At') }}
                                </th>
                                <th scope="col" class="px-5 py-3 text-right">
                                    {{ __('Actions') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-gray-800/60">
                            @foreach ($tokens as $token)
                                <tr class="hover:bg-slate-50/50 dark:hover:bg-gray-900/30 transition text-xs font-mono">
                                    <td class="px-5 py-3 font-semibold text-slate-800 dark:text-slate-200">
                                        {{ $token->name }}
                                    </td>
                                    <td class="px-5 py-3 text-slate-500 dark:text-slate-400 font-mono select-all">
                                        {{ $this->getMaskedToken($token) }}
                                    </td>
                                    <td class="px-5 py-3 text-slate-500 font-sans">
                                        @if($token->last_used_at)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-indigo-50 dark:bg-indigo-500/5 text-indigo-600 dark:text-indigo-400 font-semibold">
                                                {{ $token->last_used_at->diffForHumans() }}
                                            </span>
                                        @else
                                            <span class="text-slate-400 italic">{{ __('Never Used') }}</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3 text-slate-500">
                                        {{ $token->created_at->format('Y-m-d H:i:s') }}
                                    </td>
                                    <td class="px-5 py-3">
                                        @if ($editingTokenId === $token->id)
                                            <!-- Inline Expiration Edit Mode -->
                                            <div class="flex items-center gap-1.5">
                                                <input 
                                                    type="date" 
                                                    wire:model="editingExpiresAt" 
                                                    class="px-2 py-1 bg-white dark:bg-gray-950 border border-slate-200 dark:border-gray-800 rounded-lg text-xs focus:ring-1 focus:ring-indigo-500 text-slate-900 dark:text-white" 
                                                />
                                                <button 
                                                    wire:click="saveEditExpiration({{ $token->id }})" 
                                                    class="p-1 bg-emerald-500/10 hover:bg-emerald-500 text-emerald-600 hover:text-white rounded-lg transition" 
                                                    title="Save"
                                                >
                                                    <svg class="size-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                                    </svg>
                                                </button>
                                                <button 
                                                    wire:click="cancelEditExpiration" 
                                                    class="p-1 bg-red-500/10 hover:bg-red-500 text-red-600 hover:text-white rounded-lg transition" 
                                                    title="Cancel"
                                                >
                                                    <svg class="size-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        @else
                                            <!-- Expiration Read-Only Mode with Pencil Icon -->
                                            <div class="flex items-center gap-1.5 group">
                                                @if ($token->expires_at)
                                                    <span class="text-slate-700 dark:text-slate-300">{{ $token->expires_at->format('Y-m-d') }}</span>
                                                @else
                                                    <span class="text-slate-400 italic">Never Expires</span>
                                                @endif
                                                <button 
                                                    wire:click="startEditExpiration({{ $token->id }})" 
                                                    class="opacity-0 group-hover:opacity-100 p-1 hover:bg-slate-100 dark:hover:bg-gray-800 rounded text-slate-400 hover:text-indigo-600 transition" 
                                                    title="Edit Revoke Date"
                                                >
                                                    <svg class="size-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                                    </svg>
                                                </button>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3 text-right">
                                        <div class="flex items-center justify-end gap-1.5">
                                            @if ($token->encrypted_token)
                                                <!-- Direct Quick Copy Button -->
                                                <button 
                                                    wire:click="copyTokenDirect({{ $token->id }})" 
                                                    class="inline-flex items-center justify-center px-2 py-1.5 bg-slate-50 hover:bg-emerald-500 hover:text-white dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-emerald-600 rounded-lg text-[10px] font-sans font-semibold transition gap-1"
                                                    title="Copy Token"
                                                >
                                                    <svg x-show="copiedId !== {{ $token->id }}" class="size-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                    </svg>
                                                    <svg x-show="copiedId === {{ $token->id }}" class="size-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" x-cloak>
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                                    </svg>
                                                    <span x-text="copiedId === {{ $token->id }} ? 'Copied!' : 'Copy'"></span>
                                            @endif
                                            
                                            <button 
                                                wire:click="revokeToken({{ $token->id }})" 
                                                wire:confirm="{{ __('Are you sure you want to revoke this API token? Any client application using it will lose access immediately.') }}"
                                                class="inline-flex items-center justify-center px-2 py-1.5 bg-red-50 hover:bg-red-500 hover:text-white dark:bg-red-950/20 dark:hover:bg-red-500 dark:text-red-400 rounded-lg text-[10px] font-sans font-semibold transition gap-1"
                                                title="Revoke Token"
                                            >
                                                <svg class="size-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                <span>Revoke</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</div>
