<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-xl text-slate-900 leading-tight">
                {{ __('Your Shopping Cart') }}
            </h2>
            <p class="text-xs text-slate-500 mt-1">Review the hardware items you have chosen before placing your order.</p>
        </div>
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1 text-sm font-medium text-slate-600 hover:text-slate-900 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            {{ __('Continue Shopping') }}
        </a>
    </x-slot>

    @if(!$cart || $cart->cartItems->isEmpty())
        <x-card>
            <div class="py-16 text-center">
                <div class="w-16 h-16 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800">Your cart is currently empty</h3>
                <p class="text-sm text-slate-500 mt-1 max-w-sm mx-auto">Explore our inventory of high-performance rigs, GPUs, and parts to get started.</p>
                <a href="{{ route('dashboard') }}" class="mt-6 inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold shadow-sm shadow-indigo-200 transition">
                    Browse Catalog &rarr;
                </a>
            </div>
        </x-card>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Items in Cart -->
            <div class="lg:col-span-2">
                <x-card>
                    <div class="divide-y divide-slate-100">
                        @foreach($cart->cartItems as $item)
                            <div class="py-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                                <div class="flex items-center gap-4">
                                    @if($item->product && $item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" 
                                             alt="{{ $item->product->name }}" 
                                             class="w-16 h-16 object-cover rounded-xl border border-slate-200 shrink-0">
                                    @else
                                        <div class="w-16 h-16 rounded-xl bg-slate-100 text-slate-400 flex items-center justify-center shrink-0">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <h4 class="font-bold text-slate-900 text-base">{{ $item->product->name ?? 'Unavailable Product' }}</h4>
                                        <p class="text-xs text-slate-500 mt-0.5">
                                            {{ $item->product->category->name ?? 'Category' }} &bull; {{ $item->product->brand->name ?? 'Brand' }}
                                        </p>
                                        <p class="font-bold text-indigo-600 text-sm mt-1">
                                            Rp {{ number_format($item->product->price ?? $item->price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-4 self-end sm:self-center">
                                    <!-- Update Quantity Form -->
                                    <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center gap-1.5">
                                        @csrf
                                        @method('PATCH')
                                        <label for="qty_{{ $item->id }}" class="text-xs text-slate-500">Qty:</label>
                                        <input type="number" name="quantity" id="qty_{{ $item->id }}" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock ?? 99 }}"
                                               class="w-16 rounded-lg border-slate-200 text-center text-xs py-1 px-2 focus:ring-indigo-500 focus:border-indigo-500">
                                        <button type="submit" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium px-2 py-1 rounded bg-indigo-50 hover:bg-indigo-100 transition">
                                            Update
                                        </button>
                                    </form>

                                    <!-- Delete Item Form -->
                                    <form action="{{ route('cart.destroy', $item) }}" method="POST" onsubmit="return confirm('Remove this item from your cart?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-500 hover:text-rose-700 p-1.5 rounded-lg hover:bg-rose-50 transition" title="Remove Item">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-card>
            </div>

            <!-- Order Summary & Checkout -->
            <div>
                <x-card title="Order Summary">
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between text-slate-600">
                            <span>Subtotal</span>
                            <span class="font-medium text-slate-800">Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Estimated Shipping</span>
                            <span class="text-emerald-600 font-medium">Free</span>
                        </div>
                        <div class="border-t border-slate-100 pt-3 flex justify-between font-bold text-slate-900 text-base">
                            <span>Total</span>
                            <span class="text-indigo-600">Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <form action="{{ route('orders.store') }}" method="POST" class="mt-6">
                        @csrf
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-4 rounded-xl text-sm shadow-sm shadow-indigo-200 transition text-center block">
                            Proceed to Checkout &rarr;
                        </button>
                    </form>
                </x-card>
            </div>
        </div>
    @endif
</x-app-layout>
