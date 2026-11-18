<x-app-layout>
    <div class="max-w-6xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Card Header -->
            <div class="px-6 py-4 border-b border-gray-200 flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-2">
                    <span class="text-blue-600 text-xl font-bold">📖</span>
                    <h2 class="text-xl font-bold text-blue-600">Daftar Pesanan</h2>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-gray-200 font-bold text-sm text-gray-800 bg-gray-50/50">
                            <th class="py-3.5 px-4">No. Pesanan</th>
                            <th class="py-3.5 px-4">Pelanggan</th>
                            <th class="py-3.5 px-4">Tanggal</th>
                            <th class="py-3.5 px-4 text-center">Item</th>
                            <th class="py-3.5 px-4 text-right">Total Harga</th>
                            <th class="py-3.5 px-4 text-center">Status</th>
                            <th class="py-3.5 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 text-sm">
                        @forelse($orders as $order)
                            <tr class="hover:bg-gray-50/70 transition-colors">
                                <td class="py-3.5 px-4 font-mono font-bold text-blue-600">
                                    #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="font-semibold text-gray-900">{{ $order->user->name ?? '-' }}</div>
                                    <div class="text-xs text-gray-500">{{ $order->user->email ?? '-' }}</div>
                                </td>
                                <td class="py-3.5 px-4 text-xs text-gray-500">
                                    {{ $order->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                        {{ $order->order_items_count }} item
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-right font-bold text-gray-900">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    @php
                                        $badgeColor = match($order->status) {
                                            'completed' => 'bg-green-100 text-green-700 border-green-200',
                                            'processing' => 'bg-blue-100 text-blue-700 border-blue-200',
                                            'cancelled' => 'bg-red-100 text-red-700 border-red-200',
                                            default => 'bg-amber-100 text-amber-700 border-amber-200',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $badgeColor }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center px-3 py-1.5 rounded-md text-xs font-semibold text-blue-700 bg-blue-50 hover:bg-blue-100 transition">
                                        Kelola &rarr;
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-gray-500">
                                    Tidak ada data pesanan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($orders->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
