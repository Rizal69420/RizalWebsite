<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

// Public Welcome Route -> Immediately asks user to login (or dashboard if already authenticated)
Route::get('/', function () {
    if (auth()->check()) {
        return auth()->user()->isAdmin()
            ? redirect()->route('admin.products.index')
            : redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// User & Admin Dashboards & Shop Catalog
Route::get('/dashboard', function () {
    try {
        $stats = [
            'products_count' => \App\Models\Product::count(),
            'categories_count' => \App\Models\Category::count(),
            'brands_count' => \App\Models\Brand::count(),
            'orders_count' => \App\Models\Order::count(),
            'out_of_stock_count' => \App\Models\Product::where('stock', '<=', 0)->count(),
        ];
        $products = \App\Models\Product::with(['category', 'brand'])->latest()->get();
        $categories = \App\Models\Category::all();
        $brands = \App\Models\Brand::all();
    } catch (\Throwable) {
        $stats = [
            'products_count' => 0,
            'categories_count' => 0,
            'brands_count' => 0,
            'orders_count' => 0,
            'out_of_stock_count' => 0,
        ];
        $products = collect();
        $categories = collect();
        $brands = collect();
    }
    return view('dashboard', compact('stats', 'products', 'categories', 'brands'));
})->middleware(['auth'])->name('dashboard');

// Alias for /shop pointing to the same catalog
Route::get('/shop', function () {
    return redirect()->route('dashboard');
})->middleware(['auth'])->name('shop');

Route::get('/admin/dashboard', function () {
    return redirect()->route('admin.products.index');
})->middleware(['auth', 'admin'])->name('admin.dashboard');

// Authenticated User Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- Customer Shopping, Cart & Checkout Routes ---
Route::middleware(['auth'])->group(function () {
    // Cart Routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');

    // Order & Checkout Routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/checkout', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

// --- Admin Management Routes (Products, Categories, Brands, Orders) ---
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('brands', BrandController::class);

    // Admin Order Management
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Admin User & Manager Management
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
});

// Breeze / Laravel Authentication Routes
require __DIR__.'/auth.php';