@if (session('success'))
    <div x-data="{ show: true }" x-show="show" x-transition.duration.300ms class="mb-6 flex items-start justify-between rounded-xl border border-emerald-200 bg-emerald-50/90 p-4 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="flex-shrink-0 text-emerald-600">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-sm font-medium text-emerald-900">{{ session('success') }}</p>
        </div>
        <button @click="show = false" type="button" class="text-emerald-500 hover:text-emerald-700 transition">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
@endif

@if (session('error'))
    <div x-data="{ show: true }" x-show="show" x-transition.duration.300ms class="mb-6 flex items-start justify-between rounded-xl border border-rose-200 bg-rose-50/90 p-4 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="flex-shrink-0 text-rose-600">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-sm font-medium text-rose-900">{{ session('error') }}</p>
        </div>
        <button @click="show = false" type="button" class="text-rose-500 hover:text-rose-700 transition">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
@endif

@if (session('warning'))
    <div x-data="{ show: true }" x-show="show" x-transition.duration.300ms class="mb-6 flex items-start justify-between rounded-xl border border-amber-200 bg-amber-50/90 p-4 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="flex-shrink-0 text-amber-600">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <p class="text-sm font-medium text-amber-900">{{ session('warning') }}</p>
        </div>
        <button @click="show = false" type="button" class="text-amber-500 hover:text-amber-700 transition">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
@endif

@if ($errors->any())
    <div x-data="{ show: true }" x-show="show" x-transition.duration.300ms class="mb-6 rounded-xl border border-rose-200 bg-rose-50/90 p-4 shadow-sm">
        <div class="flex items-start justify-between">
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 text-rose-600 mt-0.5">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-rose-900">Please review the following errors:</h3>
                    <ul class="mt-2 list-disc list-inside text-xs text-rose-800 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button @click="show = false" type="button" class="text-rose-500 hover:text-rose-700 transition">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
@endif
