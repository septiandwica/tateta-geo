<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-5 py-2.5 bg-red-50 hover:bg-red-100 text-red-600 dark:bg-red-950/20 dark:hover:bg-red-950/40 dark:text-red-400 text-xs font-bold uppercase tracking-wider rounded-xl transition-all duration-150 gap-1.5 focus:outline-none border border-transparent']) }}>
    {{ $slot }}
</button>
