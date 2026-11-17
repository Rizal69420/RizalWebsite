<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between mb-4">
                    <h3 class="text-lg font-bold">Product Inventory</h3>
                    <a href="{{ route('admin.products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add New Product</a>
                </div>

                @if(session('success'))
                    <div class="mb-4 bg-green-100 text-green-700 p-3 rounded">{{ session('success') }}</div>
                @endif

                <table class="w-full border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 p-2 text-center w-20">Image</th>
                            <th class="border border-gray-300 p-2 text-left">Name</th>
                            <th class="border border-gray-300 p-2 text-left">Category</th>
                            <th class="border border-gray-300 p-2 text-left">Brand</th>
                            <th class="border border-gray-300 p-2 text-right">Price</th>
                            <th class="border border-gray-300 p-2 text-center">Stock</th>
                            <th class="border border-gray-300 p-2 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td class="border border-gray-300 p-2 text-center">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                            alt="{{ $product->name }}" 
                                            class="w-16 h-16 object-cover rounded mx-auto border">
                                    @else
                                        <div class="w-16 h-16 bg-gray-200 text-gray-400 text-xs flex items-center justify-center rounded mx-auto">
                                            No Image
                                        </div>
                                    @endif
                                </td>
                                <td class="border border-gray-300 p-2 font-medium">{{ $product->name }}</td>
                                <td class="border border-gray-300 p-2">{{ $product->category->name ?? 'N/A' }}</td>
                                <td class="border border-gray-300 p-2">{{ $product->brand->name ?? 'N/A' }}</td>
                                <td class="border border-gray-300 p-2 text-right">RP{{ number_format($product->price, 2) }}</td>
                                <td class="border border-gray-300 p-2 text-center">{{ $product->stock }}</td>
                                <td class="border border-gray-300 p-2 text-center">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="text-indigo-600 hover:underline mr-2">Edit</a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center p-4 text-gray-500">No products found in inventory.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>