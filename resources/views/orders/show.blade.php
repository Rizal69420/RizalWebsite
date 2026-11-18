<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-xl text-slate-900 leading-tight">
                {{ __('Order Receipt') }}: <span class="text-indigo-600 font-mono">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
            </h2>
            <p class="text-xs text-slate-500 mt-1">Placed on {{ $order->created_at->format('l, F j, Y \a\t H:i') }}</p>
        </div>
        <a href="{{ route('orders.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-slate-600 hover:text-slate-900 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            {{ __('Back to Orders') }}
        </a>
    </x-slot>

    <div class="max-w-3xl mx-auto space-y-6">
        <!-- Order Status Banner -->
        <x-card>
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Fulfillment Status</span>
                    <h3 class="text-lg font-bold text-slate-900 mt-0.5 capitalize">{{ $order->status }}</h3>
                </div>
                @php
                    $badgeVariant = match($order->status) {
                        'completed' => 'success',
                        'processing' => 'info',
                        'cancelled' => 'danger',
                        default => 'warning',
                    };
                @endphp
                <x-badge :variant="$badgeVariant" size="md">
                    {{ ucfirst($order->status) }}
                </x-badge>
            </div>
        </x-card>

        <!-- Order Items -->
        <x-card title="Order Summary">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-200 text-xs font-semibold uppercase tracking-wider text-slate-500 bg-slate-50/75">
                            <th class="py-3 px-4">Item</th>
                            <th class="py-3 px-4 text-center">Qty</th>
                            <th class="py-3 px-4 text-right">Unit Price</th>
                            <th class="py-3 px-4 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @foreach($order->orderItems as $item)
                            <tr>
                                <td class="py-3.5 px-4 font-semibold text-slate-900">
                                    {{ $item->product_name }}
                                </td>
                                <td class="py-3.5 px-4 text-center text-slate-600">
                                    {{ $item->quantity }}
                                </td>
                                <td class="py-3.5 px-4 text-right text-slate-600">
                                    Rp {{ number_format($item->price_at_purchase, 0, ',', '.') }}
                                </td>
                                <td class="py-3.5 px-4 text-right font-semibold text-slate-900">
                                    Rp {{ number_format($item->price_at_purchase * $item->quantity, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="border-t-2 border-slate-200 bg-slate-50/50">
                            <td colspan="3" class="py-4 px-4 text-right font-bold text-slate-700">Total Paid:</td>
                            <td class="py-4 px-4 text-right font-extrabold text-base text-indigo-600">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </x-card>
    </div>
</x-app-layout>
