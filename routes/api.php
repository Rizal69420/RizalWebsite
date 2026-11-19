<?php

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/products', function (Request $request) {
    $query = Product::with(['category', 'brand']);

    if ($request->filled('category_id')) {
        $query->where('category_id', $request->category_id);
    }

    if ($request->filled('brand_id')) {
        $query->where('brand_id', $request->brand_id);
    }

    return ProductResource::collection($query->latest()->get());
});

Route::get('/products/{product}', function (Product $product) {
    $product->load(['category', 'brand']);
    return new ProductResource($product);
});