<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-xl text-slate-900 leading-tight">
                {{ __('Order Details') }}: <span class="text-indigo-600 font-mono">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
            </h2>
            <p class="text-xs text-slate-500 mt-1">Placed on {{ $order->created_at->format('l, F j, Y \a\t H:i') }}</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-slate-600 hover:text-slate-900 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            {{ __('Back to Orders') }}
        </a>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main: Ordered Items -->
        <div class="lg:col-span-2 space-y-6">
            <x-card title="Purchased Items ({{ $order->orderItems->count() }})">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-200 text-xs font-semibold uppercase tracking-wider text-slate-500 bg-slate-50/75">
                                <th class="py-3 px-4">Product</th>
                                <th class="py-3 px-4 text-center">Qty</th>
                                <th class="py-3 px-4 text-right">Unit Price</th>
                                <th class="py-3 px-4 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @foreach($order->orderItems as $item)
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="py-3.5 px-4">
                                        <div class="flex items-center gap-3">
                                            @if($item->product && $item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                     alt="{{ $item->product_name }}" 
                                                     class="w-10 h-10 object-cover rounded-lg border border-slate-200 shrink-0">
                                            @else
                                                <div class="w-10 h-10 rounded-lg bg-slate-100 text-slate-400 flex items-center justify-center shrink-0">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                    </svg>
                                                </div>
                                            @endif
                                            <div>
                                                <span class="font-semibold text-slate-900 block">{{ $item->product_name }}</span>
                                                @if($item->product && $item->product->category)
                                                    <span class="text-xs text-slate-400">{{ $item->product->category->name }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4 text-center font-medium text-slate-700">
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
                                <td colspan="3" class="py-4 px-4 text-right font-bold text-slate-700">Grand Total:</td>
                                <td class="py-4 px-4 text-right font-extrabold text-base text-indigo-600">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </x-card>
        </div>

        <!-- Sidebar: Status & Customer Information -->
        <div class="space-y-6">
            <!-- Update Status Card -->
            <x-card title="Order Fulfillment Status">
                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label for="status" class="block text-xs font-semibold text-slate-600 mb-1">
                            Current Status
                        </label>
                        <select name="status" id="status" class="w-full rounded-xl border-slate-200 text-sm focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status')
                            <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-xl text-xs shadow-sm shadow-indigo-200 transition">
                        Update Order Status
                    </button>
                </form>
            </x-card>

            <!-- Customer Profile Card -->
            <x-card title="Customer Information">
                <div class="space-y-3 text-sm">
                    <div>
                        <span class="text-xs text-slate-400 block">Name</span>
                        <span class="font-semibold text-slate-800">{{ $order->user->name ?? 'Deleted User' }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block">Email Address</span>
                        <span class="text-slate-800">{{ $order->user->email ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block">Customer Account Type</span>
                        <span class="capitalize text-slate-800">{{ $order->user->role ?? 'Customer' }}</span>
                    </div>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>
