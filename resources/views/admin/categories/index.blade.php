<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Categories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between mb-4">
                    <h3 class="text-lg font-bold">Categories List</h3>
                    <a href="{{ route('admin.categories.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Add Category</a>
                </div>

                @if(session('success'))
                    <div class="mb-4 bg-green-100 text-green-700 p-3 rounded">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">{{ session('error') }}</div>
                @endif

                <table class="w-full border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 p-2 text-left">Name</th>
                            <th class="border border-gray-300 p-2 text-left">Description</th>
                            <th class="border border-gray-300 p-2 text-center">Products Count</th>
                            <th class="border border-gray-300 p-2 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td class="border border-gray-300 p-2">{{ $category->name }}</td>
                                <td class="border border-gray-300 p-2">{{ $category->description ?? 'N/A' }}</td>
                                <td class="border border-gray-300 p-2 text-center">{{ $category->products_count }}</td>
                                <td class="border border-gray-300 p-2 text-center">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="text-indigo-600 hover:underline mr-2">Edit</a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center p-4 text-gray-500">No categories found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>