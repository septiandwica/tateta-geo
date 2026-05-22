@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold text-xs uppercase tracking-wider text-slate-500 dark:text-gray-400']) }}>
    {{ $value ?? $slot }}
</label>
