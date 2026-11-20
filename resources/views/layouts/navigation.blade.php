<nav class="bg-blue-600 text-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center justify-between min-h-[4rem] py-2 gap-4">
            <!-- Left Branding: Title changed back to RigStore with previous logo -->
            <div class="flex items-center">
                <a href="{{ auth()->check() && auth()->user()->isAdmin() ? route('admin.products.index') : route('dashboard') }}" class="flex items-center gap-2.5 text-white hover:opacity-95 transition">
                    <div class="h-8 w-8 rounded-lg bg-white/15 border border-white/30 flex items-center justify-center p-1">
                        <x-application-logo class="block h-5 w-auto fill-current text-white" />
                    </div>
                    <span class="font-bold text-xl sm:text-2xl tracking-tight text-white">
                        Rig<span class="text-blue-200">Store</span>
                    </span>
                    @if(auth()->check() && auth()->user()->isAdmin())
                        <span class="bg-white/20 text-white text-[11px] font-semibold uppercase tracking-wider px-2 py-0.5 rounded-full ml-1 border border-white/30">
                            Admin
                        </span>
                    @endif
                </a>
            </div>

            <!-- Right Navigation: Direct Links to Other Tables + Logout (ALWAYS VISIBLE) -->
            <div class="flex items-center flex-wrap gap-2 sm:gap-4">
                @if(auth()->check() && auth()->user()->isAdmin())
                    <!-- Customer Storefront View for Admin -->
                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center gap-1.5 text-sm font-semibold px-2.5 py-1.5 rounded-lg transition {{ request()->routeIs('dashboard') ? 'bg-white/25 text-white underline underline-offset-4' : 'text-white/90 hover:text-white hover:bg-white/15' }}"
                       title="Lihat Tampilan Toko dari Sudut Pandang Pelanggan">
                        <span>🏪</span>
                        <span>Shop</span>
                    </a>

                    <!-- Admin Table Links -->
                    <a href="{{ route('admin.products.index') }}" 
                       class="inline-flex items-center gap-1.5 text-sm font-semibold px-2.5 py-1.5 rounded-lg transition {{ request()->routeIs('admin.products.*') ? 'bg-white/25 text-white underline underline-offset-4' : 'text-white/90 hover:text-white hover:bg-white/15' }}">
                        <span>📦</span>
                        <span>Products</span>
                    </a>

                    <a href="{{ route('admin.categories.index') }}" 
                       class="inline-flex items-center gap-1.5 text-sm font-semibold px-2.5 py-1.5 rounded-lg transition {{ request()->routeIs('admin.categories.*') ? 'bg-white/25 text-white underline underline-offset-4' : 'text-white/90 hover:text-white hover:bg-white/15' }}">
                        <span>🏷️</span>
                        <span>Categories</span>
                    </a>

                    <a href="{{ route('admin.brands.index') }}" 
                       class="inline-flex items-center gap-1.5 text-sm font-semibold px-2.5 py-1.5 rounded-lg transition {{ request()->routeIs('admin.brands.*') ? 'bg-white/25 text-white underline underline-offset-4' : 'text-white/90 hover:text-white hover:bg-white/15' }}">
                        <span>🏢</span>
                        <span>Brands</span>
                    </a>

                    <a href="{{ route('admin.orders.index') }}" 
                       class="inline-flex items-center gap-1.5 text-sm font-semibold px-2.5 py-1.5 rounded-lg transition {{ request()->routeIs('admin.orders.*') ? 'bg-white/25 text-white underline underline-offset-4' : 'text-white/90 hover:text-white hover:bg-white/15' }}">
                        <span>📋</span>
                        <span>Orders</span>
                    </a>

                    <a href="{{ route('admin.users.index') }}" 
                       class="inline-flex items-center gap-1.5 text-sm font-semibold px-2.5 py-1.5 rounded-lg transition {{ request()->routeIs('admin.users.*') ? 'bg-white/25 text-white underline underline-offset-4' : 'text-white/90 hover:text-white hover:bg-white/15' }}">
                        <span>👥</span>
                        <span>Users</span>
                    </a>
                @else
                    <!-- Customer Links -->
                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center gap-1.5 text-sm font-semibold px-2.5 py-1.5 rounded-lg transition {{ request()->routeIs('dashboard') ? 'bg-white/25 text-white underline underline-offset-4' : 'text-white/90 hover:text-white hover:bg-white/15' }}">
                        <span>🛍️</span>
                        <span>Shop</span>
                    </a>

                    <a href="{{ route('cart.index') }}" 
                       class="inline-flex items-center gap-1.5 text-sm font-semibold px-2.5 py-1.5 rounded-lg transition {{ request()->routeIs('cart.*') ? 'bg-white/25 text-white underline underline-offset-4' : 'text-white/90 hover:text-white hover:bg-white/15' }}">
                        <span>🛒</span>
                        <span>Cart</span>
                    </a>

                    <a href="{{ route('orders.index') }}" 
                       class="inline-flex items-center gap-1.5 text-sm font-semibold px-2.5 py-1.5 rounded-lg transition {{ request()->routeIs('orders.*') ? 'bg-white/25 text-white underline underline-offset-4' : 'text-white/90 hover:text-white hover:bg-white/15' }}">
                        <span>📋</span>
                        <span>My Orders</span>
                    </a>
                @endif

                <!-- User & Direct Logout Button (Always Visible in Header) -->
                <div class="flex items-center gap-2.5 pl-2 border-l border-white/25">
                    @auth
                        <span class="text-xs text-white/80 hidden sm:inline font-medium">
                            {{ Auth::user()->name }}
                        </span>

                        <form method="POST" action="{{ route('logout') }}" onsubmit="return confirm('Apakah Anda yakin ingin keluar dari RigStore');">
                            @csrf
                            <button type="submit" class="bg-red-500 hover:bg-red-600 active:bg-red-700 text-white text-xs sm:text-sm font-semibold px-3 py-1.5 rounded-lg shadow-sm transition flex items-center gap-1 cursor-pointer">
                                <span>Log Out</span>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="bg-white text-blue-600 hover:bg-blue-50 font-semibold px-3.5 py-1.5 rounded-lg text-xs shadow-sm transition">
                            Log In
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</nav>
