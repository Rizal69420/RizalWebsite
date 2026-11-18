@props([
    'variant' => 'neutral', // neutral, success, warning, danger, info, primary
    'size' => 'md', // sm, md
])

@php
$baseClasses = 'inline-flex items-center font-medium rounded-full';

$sizeClasses = match($size) {
    'sm' => 'px-2 py-0.5 text-xs',
    default => 'px-2.5 py-1 text-xs',
};

$variantClasses = match($variant) {
    'success' => 'bg-emerald-50 text-emerald-700 border border-emerald-200/80',
    'warning' => 'bg-amber-50 text-amber-700 border border-amber-200/80',
    'danger' => 'bg-rose-50 text-rose-700 border border-rose-200/80',
    'info' => 'bg-sky-50 text-sky-700 border border-sky-200/80',
    'primary' => 'bg-indigo-50 text-indigo-700 border border-indigo-200/80',
    default => 'bg-slate-100 text-slate-700 border border-slate-200/80',
};
@endphp

<span {{ $attributes->merge(['class' => "$baseClasses $sizeClasses $variantClasses"]) }}>
    {{ $slot }}
</span>
