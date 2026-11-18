<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-xl text-slate-900 leading-tight">
                {{ __('Add New Brand') }}
            </h2>
            <p class="text-xs text-slate-500 mt-1">Register a hardware manufacturer or vendor.</p>
        </div>
        <a href="{{ route('admin.brands.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-slate-600 hover:text-slate-900 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            {{ __('Back to Brands') }}
        </a>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <x-card>
            <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-800 mb-1.5">
                        Brand Name <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           placeholder="e.g. ASUS ROG, MSI, Corsair"
                           class="w-full rounded-xl border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition">
                    @error('name')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Logo Upload -->
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-1.5">
                        Brand Logo
                    </label>

                    <div class="flex items-center gap-4">
                        <div id="logo-preview-container" class="hidden shrink-0">
                            <img id="logo-preview" src="#" alt="Logo Preview" class="w-16 h-16 object-contain rounded-xl border border-slate-200 p-1 bg-white shadow-sm">
                        </div>
                        <label class="flex flex-col items-center justify-center border-2 border-dashed border-slate-200 hover:border-indigo-400 rounded-xl p-4 cursor-pointer bg-slate-50/50 hover:bg-slate-50 transition w-full">
                            <div class="flex flex-col items-center justify-center text-center">
                                <svg class="w-6 h-6 text-slate-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-xs font-semibold text-indigo-600">Upload brand logo</span>
                                <span class="text-[11px] text-slate-400 mt-0.5">PNG, JPG, WEBP up to 2MB</span>
                            </div>
                            <input type="file" name="logo" id="logo" accept="image/*" onchange="previewLogo(event)" class="hidden">
                        </label>
                    </div>
                    @error('logo')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('admin.brands.index') }}" class="px-4 py-2 rounded-xl text-sm font-semibold text-slate-600 hover:text-slate-800 hover:bg-slate-100 transition">
                        Cancel
                    </a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-xl text-sm font-semibold shadow-sm shadow-indigo-200 transition">
                        Save Brand
                    </button>
                </div>
            </form>
        </x-card>
    </div>

    <script>
        function previewLogo(event) {
            const input = event.target;
            const container = document.getElementById('logo-preview-container');
            const preview = document.getElementById('logo-preview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    container.classList.remove('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>
