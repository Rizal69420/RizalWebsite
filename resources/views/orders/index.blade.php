<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-xl text-slate-900 leading-tight">
                {{ __('My Orders') }}
            </h2>
            <p class="text-xs text-slate-500 mt-1">Review your past hardware purchases and fulfillment progress.</p>
        </div>
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1 text-sm font-medium text-slate-600 hover:text-slate-900 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            {{ __('Back to Dashboard') }}
        </a>
    </x-slot>

    <x-card>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200 text-xs font-semibold uppercase tracking-wider text-slate-500 bg-slate-50/75">
                        <th class="py-3 px-4">Order #</th>
                        <th class="py-3 px-4">Date</th>
                        <th class="py-3 px-4 text-center">Items</th>
                        <th class="py-3 px-4 text-right">Total Price</th>
                        <th class="py-3 px-4 text-center">Status</th>
                        <th class="py-3 px-4 text-right">Receipt</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($orders as $order)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3.5 px-4 font-mono font-bold text-indigo-600">
                                #{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-600">
                                {{ $order->created_at->format('M d, Y') }}
                            </td>
                            <td class="py-3.5 px-4 text-center text-slate-600">
                                {{ $order->orderItems->count() }} {{ Str::plural('item', $order->orderItems->count()) }}
                            </td>
                            <td class="py-3.5 px-4 text-right font-bold text-slate-900">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                @php
                                    $badgeVariant = match($order->status) {
                                        'completed' => 'success',
                                        'processing' => 'info',
                                        'cancelled' => 'danger',
                                        default => 'warning',
                                    };
                                @endphp
                                <x-badge :variant="$badgeVariant">
                                    {{ ucfirst($order->status) }}
                                </x-badge>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <a href="{{ route('orders.show', $order) }}" class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 transition">
                                    View Receipt &rarr;
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 mb-3">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                        </svg>
                                    </div>
                                    <p class="font-medium text-slate-700">No orders placed yet</p>
                                    <p class="text-xs text-slate-500 mt-1">Once you purchase rigs or components, your receipts will be kept here.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
            <div class="mt-6 pt-4 border-t border-slate-100">
                {{ $orders->links() }}
            </div>
        @endif
    </x-card>
</x-app-layout>
