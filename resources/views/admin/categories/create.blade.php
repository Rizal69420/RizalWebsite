<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-xl text-slate-900 leading-tight">
                {{ __('Add New Category') }}
            </h2>
            <p class="text-xs text-slate-500 mt-1">Create a new product grouping category.</p>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-slate-600 hover:text-slate-900 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            {{ __('Back to Categories') }}
        </a>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <x-card>
            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-800 mb-1.5">
                        Category Name <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           placeholder="e.g. Graphics Cards (GPU)"
                           class="w-full rounded-xl border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition">
                    @error('name')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-semibold text-slate-800 mb-1.5">
                        Description
                    </label>
                    <textarea name="description" id="description" rows="4"
                              placeholder="Describe the types of products included in this category..."
                              class="w-full rounded-xl border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 rounded-xl text-sm font-semibold text-slate-600 hover:text-slate-800 hover:bg-slate-100 transition">
                        Cancel
                    </a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-xl text-sm font-semibold shadow-sm shadow-indigo-200 transition">
                        Save Category
                    </button>
                </div>
            </form>
        </x-card>
    </div>
</x-app-layout>
