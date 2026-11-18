<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-xl text-slate-900 leading-tight">
                {{ __('Add New Product') }}
            </h2>
            <p class="text-xs text-slate-500 mt-1">Create a new item in the catalog inventory.</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-slate-600 hover:text-slate-900 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            {{ __('Back to Products') }}
        </a>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <x-card>
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Product Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-800 mb-1.5">
                        Product Name <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           placeholder="e.g. NVIDIA GeForce RTX 4080 Super"
                           class="w-full rounded-xl border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition">
                    @error('name')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category & Brand -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="category_id" class="block text-sm font-semibold text-slate-800 mb-1.5">
                            Category <span class="text-rose-500">*</span>
                        </label>
                        <select name="category_id" id="category_id" required
                                class="w-full rounded-xl border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="brand_id" class="block text-sm font-semibold text-slate-800 mb-1.5">
                            Brand <span class="text-rose-500">*</span>
                        </label>
                        <select name="brand_id" id="brand_id" required
                                class="w-full rounded-xl border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition">
                            <option value="">Select Brand</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('brand_id')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Price & Stock -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="price" class="block text-sm font-semibold text-slate-800 mb-1.5">
                            Price (IDR) <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative rounded-xl shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <span class="text-slate-500 text-xs font-semibold">Rp</span>
                            </div>
                            <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}" required
                                   placeholder="0"
                                   class="w-full rounded-xl border-slate-200 pl-10 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition">
                        </div>
                        @error('price')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="stock" class="block text-sm font-semibold text-slate-800 mb-1.5">
                            Initial Stock <span class="text-rose-500">*</span>
                        </label>
                        <input type="number" name="stock" id="stock" value="{{ old('stock', 0) }}" required min="0"
                               class="w-full rounded-xl border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition">
                        @error('stock')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-slate-800 mb-1.5">
                        Description
                    </label>
                    <textarea name="description" id="description" rows="3"
                              placeholder="Write a brief overview of the product..."
                              class="w-full rounded-xl border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Specifications -->
                <div>
                    <label for="specifications" class="block text-sm font-semibold text-slate-800 mb-1.5">
                        Technical Specifications
                    </label>
                    <textarea name="specifications" id="specifications" rows="3"
                              placeholder="e.g. 16GB GDDR6X, 256-bit, PCIe 4.0, 2610 MHz Boost Clock"
                              class="w-full rounded-xl border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition">{{ old('specifications') }}</textarea>
                    @error('specifications')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Product Image Upload -->
                <div>
                    <label class="block text-sm font-semibold text-slate-800 mb-1.5">
                        Product Image
                    </label>

                    <div class="flex items-center gap-4">
                        <div id="image-preview-container" class="hidden shrink-0">
                            <img id="image-preview" src="#" alt="Preview" class="w-20 h-20 object-cover rounded-xl border border-slate-200 shadow-sm">
                        </div>
                        <label class="flex flex-col items-center justify-center border-2 border-dashed border-slate-200 hover:border-indigo-400 rounded-xl p-4 cursor-pointer bg-slate-50/50 hover:bg-slate-50 transition w-full">
                            <div class="flex flex-col items-center justify-center text-center">
                                <svg class="w-6 h-6 text-slate-400 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-xs font-semibold text-indigo-600">Click to upload photo</span>
                                <span class="text-[11px] text-slate-400 mt-0.5">PNG, JPG, WEBP up to 2MB</span>
                            </div>
                            <input type="file" name="image" id="image" accept="image/*" onchange="previewImage(event)" class="hidden">
                        </label>
                    </div>
                    @error('image')
                        <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                    <a href="{{ route('admin.products.index') }}" class="px-4 py-2 rounded-xl text-sm font-semibold text-slate-600 hover:text-slate-800 hover:bg-slate-100 transition">
                        Cancel
                    </a>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-xl text-sm font-semibold shadow-sm shadow-indigo-200 transition">
                        Save Product
                    </button>
                </div>
            </form>
        </x-card>
    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            const container = document.getElementById('image-preview-container');
            const preview = document.getElementById('image-preview');

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
