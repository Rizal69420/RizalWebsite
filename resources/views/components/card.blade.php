@props([
    'title' => null,
    'subtitle' => null,
    'action' => null,
])

<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden']) }}>
    @if ($title || $action)
        <div class="px-6 py-5 border-b border-slate-100 flex flex-wrap items-center justify-between gap-4">
            <div>
                @if ($title)
                    <h3 class="text-base font-semibold text-slate-900">{{ $title }}</h3>
                @endif
                @if ($subtitle)
                    <p class="text-xs text-slate-500 mt-0.5">{{ $subtitle }}</p>
                @endif
            </div>
            @if ($action)
                <div class="flex items-center gap-2">
                    {{ $action }}
                </div>
            @endif
        </div>
    @endif

    <div class="p-6">
        {{ $slot }}
    </div>
</div>
