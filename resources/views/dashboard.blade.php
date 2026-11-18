<x-app-layout>
    <div class="max-w-6xl mx-auto space-y-6">
        <!-- Dashboard Header / Welcome -->
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Dashboard {{ auth()->user()->isAdmin() ? 'Admin & Manager' : 'Pelanggan' }}
                </h1>
                <p class="text-sm text-gray-500">Selamat datang kembali, <span class="font-semibold text-gray-800">{{ auth()->user()->name }}</span> ({{ auth()->user()->email }})</p>
            </div>
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg text-sm shadow-sm transition">
                    <span>+</span>
                    <span>Tambah Produk</span>
                </a>
            @else
                <a href="{{ route('cart.index') }}" class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg text-sm shadow-sm transition">
                    <span>🛒</span>
                    <span>Lihat Keranjang</span>
                </a>
            @endif
        </div>

        @if(auth()->user()->isAdmin())
            <!-- SB Admin 2 Style KPI Cards (From References folder) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                <!-- Products Card (Primary / Blue) -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 border-l-4 border-l-blue-600 p-5 flex items-center justify-between hover:shadow-md transition">
                    <div>
                        <div class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-1">
                            Total Produk
                        </div>
                        <div class="text-2xl font-extrabold text-gray-800">
                            {{ $stats['products_count'] ?? 0 }}
                        </div>
                        <a href="{{ route('admin.products.index') }}" class="text-xs text-blue-600 hover:underline mt-2 inline-block font-medium">
                            Kelola produk &rarr;
                        </a>
                    </div>
                    <div class="text-3xl text-gray-300">
                        📦
                    </div>
                </div>

                <!-- Categories Card (Info / Cyan) -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 border-l-4 border-l-cyan-500 p-5 flex items-center justify-between hover:shadow-md transition">
                    <div>
                        <div class="text-xs font-bold text-cyan-600 uppercase tracking-wider mb-1">
                            Kategori
                        </div>
                        <div class="text-2xl font-extrabold text-gray-800">
                            {{ $stats['categories_count'] ?? 0 }}
                        </div>
                        <a href="{{ route('admin.categories.index') }}" class="text-xs text-cyan-600 hover:underline mt-2 inline-block font-medium">
                            Kelola kategori &rarr;
                        </a>
                    </div>
                    <div class="text-3xl text-gray-300">
                        🏷️
                    </div>
                </div>

                <!-- Brands Card (Warning / Yellow) -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 border-l-4 border-l-amber-500 p-5 flex items-center justify-between hover:shadow-md transition">
                    <div>
                        <div class="text-xs font-bold text-amber-600 uppercase tracking-wider mb-1">
                            Brand / Manufaktur
                        </div>
                        <div class="text-2xl font-extrabold text-gray-800">
                            {{ $stats['brands_count'] ?? 0 }}
                        </div>
                        <a href="{{ route('admin.brands.index') }}" class="text-xs text-amber-600 hover:underline mt-2 inline-block font-medium">
                            Kelola brand &rarr;
                        </a>
                    </div>
                    <div class="text-3xl text-gray-300">
                        🏢
                    </div>
                </div>

                <!-- Orders Card (Success / Green) -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 border-l-4 border-l-green-600 p-5 flex items-center justify-between hover:shadow-md transition">
                    <div>
                        <div class="text-xs font-bold text-green-600 uppercase tracking-wider mb-1">
                            Total Pesanan
                        </div>
                        <div class="text-2xl font-extrabold text-gray-800">
                            {{ $stats['orders_count'] ?? 0 }}
                        </div>
                        <a href="{{ route('admin.orders.index') }}" class="text-xs text-green-600 hover:underline mt-2 inline-block font-medium">
                            Kelola pesanan &rarr;
                        </a>
                    </div>
                    <div class="text-3xl text-gray-300">
                        📋
                    </div>
                </div>
            </div>

            <!-- Out of Stock Warning Card (Red / Danger) -->
            @if(($stats['out_of_stock_count'] ?? 0) > 0)
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl shadow-sm flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">⚠️</span>
                        <div>
                            <p class="font-bold text-sm text-red-800">Perhatian: Stok Habis (Out of Stock)</p>
                            <p class="text-xs text-red-600">Ada <span class="font-bold">{{ $stats['out_of_stock_count'] }}</span> produk dengan stok 0 yang saat ini tidak dapat dibeli oleh pelanggan.</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.products.index') }}" class="bg-red-600 hover:bg-red-700 text-white text-xs font-semibold px-3 py-1.5 rounded-lg shadow-sm transition">
                        Periksa Stok &rarr;
                    </a>
                </div>
            @endif

            <!-- Quick Access Table Cards -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center gap-2 mb-4">
                    <span class="text-blue-600 text-lg">⚡</span>
                    <h2 class="text-base font-bold text-gray-800">Akses Cepat Tabel Database</h2>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-5 gap-3 text-center">
                    <a href="{{ route('admin.products.index') }}" class="p-3 rounded-lg border border-gray-200 hover:border-blue-500 hover:bg-blue-50 transition group">
                        <span class="text-2xl block mb-1">📦</span>
                        <span class="text-xs font-bold text-gray-800 group-hover:text-blue-600">Produk</span>
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="p-3 rounded-lg border border-gray-200 hover:border-blue-500 hover:bg-blue-50 transition group">
                        <span class="text-2xl block mb-1">🏷️</span>
                        <span class="text-xs font-bold text-gray-800 group-hover:text-blue-600">Kategori</span>
                    </a>
                    <a href="{{ route('admin.brands.index') }}" class="p-3 rounded-lg border border-gray-200 hover:border-blue-500 hover:bg-blue-50 transition group">
                        <span class="text-2xl block mb-1">🏢</span>
                        <span class="text-xs font-bold text-gray-800 group-hover:text-blue-600">Brand</span>
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="p-3 rounded-lg border border-gray-200 hover:border-blue-500 hover:bg-blue-50 transition group">
                        <span class="text-2xl block mb-1">📋</span>
                        <span class="text-xs font-bold text-gray-800 group-hover:text-blue-600">Pesanan</span>
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="p-3 rounded-lg border border-gray-200 hover:border-blue-500 hover:bg-blue-50 transition group">
                        <span class="text-2xl block mb-1">👥</span>
                        <span class="text-xs font-bold text-gray-800 group-hover:text-blue-600">Manager</span>
                    </a>
                </div>
            </div>

            <!-- Customer Storefront Preview for Admin -->
            <div class="pt-4 border-t border-gray-200">
                <div class="flex flex-wrap items-center justify-between gap-4 mb-5">
                    <div>
                        <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                            <span>🛍️</span>
                            <span>Katalog Toko (Sudut Pandang Pelanggan)</span>
                        </h2>
                        <p class="text-xs text-gray-500 mt-0.5">Tampilan yang dilihat oleh pelanggan saat berbelanja. Anda dapat menguji memasukkan produk ke keranjang belanja dari sini.</p>
                    </div>
                    <span class="text-xs bg-blue-50 text-blue-700 font-semibold px-3 py-1 rounded-full border border-blue-200">
                        Admin Preview Mode
                    </span>
                </div>

                @if($products->isEmpty())
                    <div class="bg-white rounded-xl border border-gray-200 p-10 text-center text-gray-500 text-sm">
                        Belum ada produk yang tersedia. Tambahkan produk melalui tombol "Tambah Produk" di atas.
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($products as $product)
                            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden flex flex-col hover:shadow-md transition">
                                <!-- Product Image & Stock Badge -->
                                <div class="h-44 bg-slate-50 relative flex items-center justify-center border-b border-gray-100 overflow-hidden">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                             alt="{{ $product->name }}" 
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="text-gray-400 flex flex-col items-center justify-center">
                                            <span class="text-3xl">💻</span>
                                            <span class="text-[11px] mt-1 text-gray-400">Tidak ada foto</span>
                                        </div>
                                    @endif

                                    <!-- Stock Pill Badge -->
                                    <div class="absolute top-2.5 right-2.5">
                                        @if($product->stock > 0)
                                            <span class="bg-emerald-50 text-emerald-700 text-[11px] font-bold px-2 py-0.5 rounded-full border border-emerald-200 shadow-sm">
                                                ✓ {{ $product->stock }} Tersedia
                                            </span>
                                        @else
                                            <span class="bg-rose-50 text-rose-700 text-[11px] font-bold px-2 py-0.5 rounded-full border border-rose-200 shadow-sm">
                                                ✕ Stok Habis
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Product Info -->
                                <div class="p-4 flex-1 flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center gap-1.5 text-[11px] text-gray-500 mb-1">
                                            <span class="font-semibold text-blue-600">{{ $product->brand->name ?? 'RigStore' }}</span>
                                            <span>&bull;</span>
                                            <span>{{ $product->category->name ?? 'Hardware' }}</span>
                                        </div>
                                        <h3 class="font-bold text-gray-900 text-sm leading-snug line-clamp-2">
                                            {{ $product->name }}
                                        </h3>
                                        @if($product->specifications)
                                            <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $product->specifications }}</p>
                                        @endif
                                    </div>

                                    <div class="mt-4 pt-3 border-t border-gray-100">
                                        <div class="flex items-baseline justify-between mb-2">
                                            <span class="text-[10px] text-gray-400 uppercase tracking-wider">Harga</span>
                                            <span class="font-extrabold text-sm text-gray-900">
                                                Rp {{ number_format($product->price, 0, ',', '.') }}
                                            </span>
                                        </div>

                                        <!-- Add to Cart Form -->
                                        @if($product->stock > 0)
                                            <form action="{{ route('cart.store') }}" method="POST" class="flex items-center gap-2">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" 
                                                       class="w-16 rounded-lg border-gray-300 text-center text-xs py-1 px-2 focus:ring-blue-500 focus:border-blue-500">
                                                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-1.5 px-3 rounded-lg text-xs shadow-sm transition flex items-center justify-center gap-1 cursor-pointer">
                                                    <span>🛒</span>
                                                    <span>+ Keranjang</span>
                                                </button>
                                            </form>
                                        @else
                                            <button type="button" disabled class="w-full bg-gray-100 text-gray-400 font-semibold py-1.5 px-3 rounded-lg text-xs cursor-not-allowed flex items-center justify-center gap-1">
                                                <span>✕</span>
                                                <span>Stok Habis</span>
                                            </button>
                                        @endif

                                        <div class="mt-2 text-center">
                                            <a href="{{ route('admin.products.edit', $product) }}" class="text-[11px] text-blue-600 hover:underline">
                                                ✏️ Edit di Admin &rarr;
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @else
            <!-- Customer Storefront / Dashboard -->
            <div class="space-y-6">
                <!-- Customer Quick Overview Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl shadow-sm p-5 text-white flex items-center justify-between">
                        <div>
                            <h3 class="font-extrabold text-base mb-1">Keranjang Belanja Anda</h3>
                            <p class="text-xs text-blue-100">Periksa hardware yang telah Anda pilih dan selesaikan pesanan.</p>
                            <a href="{{ route('cart.index') }}" class="mt-3 inline-flex items-center gap-1.5 bg-white text-blue-600 font-bold px-3.5 py-1.5 rounded-lg text-xs shadow-sm hover:bg-blue-50 transition">
                                <span>🛒</span>
                                <span>Buka Keranjang &rarr;</span>
                            </a>
                        </div>
                        <div class="text-4xl text-white/30 pr-2">
                            🛒
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 flex items-center justify-between">
                        <div>
                            <h3 class="font-extrabold text-gray-800 text-base mb-1">Riwayat Pesanan</h3>
                            <p class="text-xs text-gray-500">Lacak pengiriman dan status transaksi pembelian Anda.</p>
                            <a href="{{ route('orders.index') }}" class="mt-3 inline-flex items-center gap-1.5 bg-gray-800 text-white font-bold px-3.5 py-1.5 rounded-lg text-xs shadow-sm hover:bg-gray-900 transition">
                                <span>📋</span>
                                <span>Lihat Semua Pesanan &rarr;</span>
                            </a>
                        </div>
                        <div class="text-4xl text-gray-200 pr-2">
                            📋
                        </div>
                    </div>
                </div>

                <!-- Product Catalog Section -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                        <div>
                            <h2 class="text-xl font-bold text-gray-900 flex items-center gap-2">
                                <span>🛍️</span>
                                <span>Katalog Hardware & Komponen PC</span>
                            </h2>
                            <p class="text-xs text-gray-500 mt-1">Pilih hardware berkualitas tinggi, tentukan jumlah, dan klik <strong>+ Keranjang</strong> untuk membeli.</p>
                        </div>
                        <div class="text-xs text-gray-500 font-medium">
                            Menampilkan <span class="font-bold text-gray-800">{{ $products->count() }}</span> produk
                        </div>
                    </div>

                    @if($products->isEmpty())
                        <div class="py-12 text-center">
                            <span class="text-4xl block mb-2">📦</span>
                            <h4 class="font-bold text-gray-700">Belum ada produk yang dijual</h4>
                            <p class="text-xs text-gray-500 mt-1">Silakan kembali lagi nanti saat produk telah ditambahkan.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            @foreach($products as $product)
                                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col hover:shadow-md transition group">
                                    <!-- Product Image & Stock Badge -->
                                    <div class="h-48 bg-slate-50 relative flex items-center justify-center border-b border-gray-100 overflow-hidden">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" 
                                                 alt="{{ $product->name }}" 
                                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        @else
                                            <div class="text-gray-400 flex flex-col items-center justify-center">
                                                <span class="text-4xl">💻</span>
                                                <span class="text-[11px] mt-1 text-gray-400">Tidak ada foto</span>
                                            </div>
                                        @endif

                                        <!-- Stock Pill Badge -->
                                        <div class="absolute top-2.5 right-2.5">
                                            @if($product->stock > 0)
                                                <span class="bg-emerald-50 text-emerald-700 text-[11px] font-bold px-2.5 py-0.5 rounded-full border border-emerald-200 shadow-sm backdrop-blur">
                                                    ✓ {{ $product->stock }} Tersedia
                                                </span>
                                            @else
                                                <span class="bg-rose-50 text-rose-700 text-[11px] font-bold px-2.5 py-0.5 rounded-full border border-rose-200 shadow-sm backdrop-blur">
                                                    ✕ Stok Habis
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Product Info -->
                                    <div class="p-4 flex-1 flex flex-col justify-between">
                                        <div>
                                            <div class="flex items-center gap-1.5 text-[11px] text-gray-500 mb-1">
                                                <span class="font-semibold text-blue-600">{{ $product->brand->name ?? 'RigStore' }}</span>
                                                <span>&bull;</span>
                                                <span>{{ $product->category->name ?? 'Hardware' }}</span>
                                            </div>
                                            <h3 class="font-bold text-gray-900 text-sm leading-snug line-clamp-2">
                                                {{ $product->name }}
                                            </h3>
                                            @if($product->specifications)
                                                <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $product->specifications }}</p>
                                            @endif
                                        </div>

                                        <div class="mt-4 pt-3 border-t border-gray-100">
                                            <div class="flex items-baseline justify-between mb-2.5">
                                                <span class="text-[10px] text-gray-400 uppercase tracking-wider">Harga</span>
                                                <span class="font-extrabold text-base text-gray-900">
                                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                                </span>
                                            </div>

                                            <!-- Add to Cart Form -->
                                            @if($product->stock > 0)
                                                <form action="{{ route('cart.store') }}" method="POST" class="flex items-center gap-2">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" 
                                                           class="w-16 rounded-lg border-gray-300 text-center text-xs py-1.5 px-2 focus:ring-blue-500 focus:border-blue-500 font-medium">
                                                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold py-1.5 px-3 rounded-lg text-xs shadow-sm transition flex items-center justify-center gap-1.5 cursor-pointer">
                                                        <span>🛒</span>
                                                        <span>+ Keranjang</span>
                                                    </button>
                                                </form>
                                            @else
                                                <button type="button" disabled class="w-full bg-gray-100 text-gray-400 font-semibold py-2 px-3 rounded-lg text-xs cursor-not-allowed flex items-center justify-center gap-1.5">
                                                    <span>✕</span>
                                                    <span>Stok Habis (Out of Stock)</span>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
