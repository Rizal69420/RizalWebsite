<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'RigStore') }} - High-End PC Hardware & Custom Rigs</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-50 text-slate-800 min-h-screen flex flex-col">
        <!-- Modern Header -->
        <header class="bg-white/90 backdrop-blur sticky top-0 z-40 border-b border-slate-200/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <div class="h-9 w-9 rounded-xl bg-gradient-to-tr from-indigo-600 to-violet-500 flex items-center justify-center text-white shadow-sm shadow-indigo-200 group-hover:scale-105 transition-transform">
                        <x-application-logo class="h-5 w-5 fill-current text-white" />
                    </div>
                    <span class="font-bold text-xl tracking-tight text-slate-900">Rig<span class="text-indigo-600">Store</span></span>
                </a>

                <nav class="flex items-center gap-3">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.products.index') }}" class="text-xs font-semibold px-3.5 py-2 rounded-xl text-indigo-700 bg-indigo-50 hover:bg-indigo-100 transition">
                                Admin Portal &rarr;
                            </a>
                        @else
                            <a href="{{ route('cart.index') }}" class="text-xs font-semibold px-3 py-2 text-slate-600 hover:text-slate-900 transition flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Cart
                            </a>
                        @endif
                        <a href="{{ url('/dashboard') }}" class="text-xs font-semibold px-4 py-2 rounded-xl bg-indigo-600 text-white hover:bg-indigo-700 shadow-sm shadow-indigo-200 transition">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-xs font-semibold px-3 py-2 text-slate-600 hover:text-slate-900 transition">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-xs font-semibold px-4 py-2 rounded-xl bg-indigo-600 text-white hover:bg-indigo-700 shadow-sm shadow-indigo-200 transition">
                                Get Started
                            </a>
                        @endif
                    @endauth
                </nav>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="py-16 lg:py-24 bg-gradient-to-b from-white to-slate-50 border-b border-slate-200/70">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200/60 mb-4">
                    ⚡ Built for Gamers, Creators & Engineers
                </span>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight max-w-3xl mx-auto">
                    Power Your Setup with <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-violet-600">Premium Rig Components</span>
                </h1>
                <p class="mt-4 text-base sm:text-lg text-slate-600 max-w-2xl mx-auto">
                    Browse top-tier GPUs, CPUs, motherboards, cooling solutions, and custom workstation hardware with instant stock updates.
                </p>
                <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.products.index') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-xl text-sm shadow-sm shadow-indigo-200 transition">
                                Manage Products &rarr;
                            </a>
                        @else
                            <a href="#featured" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-xl text-sm shadow-sm shadow-indigo-200 transition">
                                Explore Hardware &darr;
                            </a>
                        @endif
                    @else
                        <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-xl text-sm shadow-sm shadow-indigo-200 transition">
                            Create Account &rarr;
                        </a>
                        <a href="{{ route('login') }}" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold px-6 py-3 rounded-xl text-sm transition">
                            Customer Login
                        </a>
                    @endauth
                </div>
            </div>
        </section>

        <!-- Featured Hardware Catalog -->
        <section id="featured" class="py-16 flex-1">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Featured Hardware Inventory</h2>
                        <p class="text-xs text-slate-500 mt-1">High-demand components in stock now.</p>
                    </div>
                </div>

                @if($products->isEmpty())
                    <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
                        <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mx-auto text-slate-400 mb-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <h3 class="font-bold text-slate-800">Catalog is being prepared</h3>
                        <p class="text-xs text-slate-500 mt-1">Check back shortly or log in as admin to add products.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($products as $product)
                            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden flex flex-col group hover:shadow-md hover:border-indigo-300 transition-all">
                                <div class="h-48 bg-slate-100 relative overflow-hidden flex items-center justify-center">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                             alt="{{ $product->name }}" 
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="text-slate-400 flex flex-col items-center justify-center">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <span class="text-[10px] mt-1 font-medium">No Image</span>
                                        </div>
                                    @endif
                                    <div class="absolute top-3 right-3">
                                        @if($product->stock > 0)
                                            <span class="bg-emerald-50 text-emerald-700 text-[10px] font-semibold px-2 py-0.5 rounded-full border border-emerald-200/80 backdrop-blur">
                                                In Stock ({{ $product->stock }})
                                            </span>
                                        @else
                                            <span class="bg-rose-50 text-rose-700 text-[10px] font-semibold px-2 py-0.5 rounded-full border border-rose-200/80 backdrop-blur">
                                                Sold Out
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="p-5 flex-1 flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center gap-2 mb-1.5 text-xs text-slate-500">
                                            <span>{{ $product->brand->name ?? 'Brand' }}</span>
                                            <span>&bull;</span>
                                            <span>{{ $product->category->name ?? 'Hardware' }}</span>
                                        </div>
                                        <h3 class="font-bold text-slate-900 text-sm group-hover:text-indigo-600 transition line-clamp-2">
                                            {{ $product->name }}
                                        </h3>
                                        @if($product->specifications)
                                            <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $product->specifications }}</p>
                                        @endif
                                    </div>

                                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between">
                                        <div>
                                            <span class="text-[10px] text-slate-400 uppercase tracking-wider block">Price</span>
                                            <span class="font-extrabold text-sm text-slate-900">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                        </div>

                                        @auth
                                            @if(!auth()->user()->isAdmin())
                                                @if($product->stock > 0)
                                                    <form action="{{ route('cart.store') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                        <input type="hidden" name="quantity" value="1">
                                                        <button type="submit" class="inline-flex items-center gap-1 bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1.5 rounded-xl text-xs font-semibold shadow-sm transition">
                                                            + Add
                                                        </button>
                                                    </form>
                                                @endif
                                            @else
                                                <a href="{{ route('admin.products.edit', $product) }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                                                    Edit &rarr;
                                                </a>
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}" class="inline-flex items-center gap-1 bg-slate-100 hover:bg-slate-200 text-slate-700 px-3 py-1.5 rounded-xl text-xs font-medium transition">
                                                Buy &rarr;
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </section>

        @include('layouts.partials.footer')
    </body>
</html>
