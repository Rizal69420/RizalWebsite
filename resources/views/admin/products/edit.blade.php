<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Product: ') . $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('admin.products.update', $product) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Product Name -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Product Name</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Category & Brand -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Category</label>
                            <select name="category_id" class="w-full border-gray-300 rounded-md shadow-sm" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Brand</label>
                            <select name="brand_id" class="w-full border-gray-300 rounded-md shadow-sm" required>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                            @error('brand_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Price & Stock -->
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Price (RP)</label>
                            <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-2">Stock Quantity</label>
                            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            @error('stock') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Description</label>
                        <textarea name="description" rows="3" class="w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $product->description) }}</textarea>
                        @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Specifications -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-bold mb-2">Specifications</label>
                        <textarea name="specifications" rows="3" class="w-full border-gray-300 rounded-md shadow-sm">{{ old('specifications', $product->specifications) }}</textarea>
                        @error('specifications') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Current Image / New Image Preview -->
                    <div class="mb-4">
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Product Image</label>
        
                    <div class="mb-2">
                    @if($product->image)
                    <img id="image-preview" src="{{ asset('storage/' . $product->image) }}" 
                        alt="{{ $product->name }}" 
                        class="w-32 h-32 object-cover rounded border">
                    @else
                        <img id="image-preview" src="#" alt="Preview" class="hidden w-32 h-32 object-cover rounded border">
                        <p id="no-image-text" class="text-xs text-gray-400">No image uploaded yet.</p>
                    @endif
                    </div>

                    <input type="file" name="image" id="image" accept="image/*"
                        onchange="previewEditImage(event)"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <p class="text-xs text-gray-500 mt-1">Leave blank to keep the current image.</p>

                    @error('image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('admin.products.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded mr-2 hover:bg-gray-600">Cancel</a>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<script>
    function previewEditImage(event) {
        const input = event.target;
        const preview = document.getElementById('image-preview');
        const noImageText = document.getElementById('no-image-text');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                if (noImageText) noImageText.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
</x-app-layout>