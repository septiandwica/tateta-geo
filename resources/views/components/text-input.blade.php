@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-slate-200 dark:border-gray-800 bg-white/60 dark:bg-gray-950/40 text-slate-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500/20 rounded-xl py-2.5 px-3.5 shadow-sm text-sm transition-all duration-200']) }}>
