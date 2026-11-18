<x-app-layout>
    <div class="max-w-6xl mx-auto">
        <!-- Card Container (Matching Reference Image) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Card Header: Title on Left, Action on Right -->
            <div class="px-6 py-4 border-b border-gray-200 flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <span class="text-blue-600 text-xl font-bold"></span>
                    <h2 class="text-xl font-bold text-blue-600">Daftar Produk</h2>
                </div>
                <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg text-sm shadow-sm transition">
                    <span>+</span>
                    <span>Tambah Produk</span>
                </a>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-200 font-bold text-sm text-gray-800 bg-gray-50/50">
                            <th class="py-3.5 px-4 w-20 text-center">Foto</th>
                            <th class="py-3.5 px-4">Nama Produk</th>
                            <th class="py-3.5 px-4">Kategori</th>
                            <th class="py-3.5 px-4">Brand</th>
                            <th class="py-3.5 px-4 text-right">Harga</th>
                            <th class="py-3.5 px-4 text-center">Stok</th>
                            <th class="py-3.5 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm">
                        @forelse($products as $product)
                            <tr class="hover:bg-gray-50/70 transition-colors">
                                <td class="py-3 px-4 text-center">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                             alt="{{ $product->name }}" 
                                             class="w-12 h-12 object-cover rounded-lg border border-gray-200 mx-auto">
                                    @else
                                        <div class="w-12 h-12 rounded-lg bg-gray-100 text-gray-400 text-xs flex items-center justify-center mx-auto border border-gray-200">
                                            No Foto
                                        </div>
                                    @endif
                                </td>
                                <td class="py-3 px-4 font-semibold text-gray-900">
                                    {{ $product->name }}
                                </td>
                                <td class="py-3 px-4 text-gray-600">
                                    {{ $product->category->name ?? '-' }}
                                </td>
                                <td class="py-3 px-4 text-gray-600">
                                    {{ $product->brand->name ?? '-' }}
                                </td>
                                <td class="py-3 px-4 text-right font-bold text-gray-900">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-4 text-center">
                                    @if($product->stock <= 0)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200">
                                            Stok Habis (Out of Stock)
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 border border-green-200">
                                            {{ $product->stock }} Tersedia
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-4 text-center space-x-1.5 whitespace-nowrap">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="inline-flex items-center px-2.5 py-1.5 rounded-md text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
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
                                <td colspan="7" class="py-12 text-center text-gray-500">
                                    Tidak ada data produk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($products->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
