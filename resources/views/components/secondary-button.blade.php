<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-5 py-2.5 bg-white hover:bg-slate-50 dark:bg-gray-900/40 dark:hover:bg-gray-900 text-slate-700 dark:text-gray-300 text-xs font-bold uppercase tracking-wider rounded-xl transition-all duration-150 gap-1.5 focus:outline-none border border-slate-200 dark:border-gray-800']) }}>
    {{ $slot }}
</button>
