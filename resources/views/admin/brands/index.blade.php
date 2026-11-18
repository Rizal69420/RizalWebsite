<x-app-layout>
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Card Header -->
            <div class="px-6 py-4 border-b border-gray-200 flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <span class="text-blue-600 text-xl font-bold">📖</span>
                    <h2 class="text-xl font-bold text-blue-600">Daftar Brand</h2>
                </div>
                <a href="{{ route('admin.brands.create') }}" class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg text-sm shadow-sm transition">
                    <span>+</span>
                    <span>Tambah Brand</span>
                </a>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-200 font-bold text-sm text-gray-800 bg-gray-50/50">
                            <th class="py-3.5 px-4 w-20 text-center">Logo</th>
                            <th class="py-3.5 px-4">Nama Brand</th>
                            <th class="py-3.5 px-4">Slug</th>
                            <th class="py-3.5 px-4 text-center">Jumlah Produk</th>
                            <th class="py-3.5 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm">
                        @forelse($brands as $brand)
                            <tr class="hover:bg-gray-50/70 transition-colors">
                                <td class="py-3 px-4 text-center">
                                    @if($brand->logo)
                                        <img src="{{ asset('storage/' . $brand->logo) }}" 
                                             alt="{{ $brand->name }}" 
                                             class="w-10 h-10 object-contain rounded-lg border border-gray-200 mx-auto p-1 bg-white">
                                    @else
                                        <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 font-bold text-xs flex items-center justify-center mx-auto border border-blue-100">
                                            {{ substr($brand->name, 0, 2) }}
                                        </div>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 font-semibold text-gray-900">
                                    {{ $brand->name }}
                                </td>
                                <td class="py-3.5 px-4 text-xs font-mono text-gray-500">
                                    {{ $brand->slug ?? Str::slug($brand->name) }}
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                        {{ $brand->products_count }} Produk
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-center space-x-1.5 whitespace-nowrap">
                                    <a href="{{ route('admin.brands.edit', $brand) }}" class="inline-flex items-center px-2.5 py-1.5 rounded-md text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus brand ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-2.5 py-1.5 rounded-md text-xs font-semibold text-red-700 bg-red-50 hover:bg-red-100 transition">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-gray-500">
                                    Tidak ada data brand.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($brands->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $brands->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
