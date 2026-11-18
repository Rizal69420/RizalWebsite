@props(['active'])

@php
$classes = ($active ?? false)
    ? 'block w-full px-3 py-2 rounded-lg text-start text-sm font-semibold text-indigo-700 bg-indigo-50 transition duration-150 ease-in-out'
    : 'block w-full px-3 py-2 rounded-lg text-start text-sm font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-50 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
