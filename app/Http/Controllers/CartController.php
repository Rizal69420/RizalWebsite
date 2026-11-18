<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Display the user's shopping cart.
     */
    public function index(): View
    {
        $user = Auth::user();

        // Find or create an active cart for the authenticated user
        $cart = Cart::with('cartItems.product')->firstOrCreate(['user_id' => $user->id]);

        return view('cart.index', compact('cart'));
    }

    /**
     * Add a product to the cart.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $product = Product::findOrFail($request->product_id);

        if ($product->stock <= 0) {
            return back()->with('error', 'Produk ini sedang habis (Out of stock).');
        }

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Jumlah yang diminta melebihi stok yang tersedia.');
        }

        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $request->quantity;

            if ($product->stock < $newQuantity) {
                return back()->with('error', 'Cannot add more. Stock limit reached.');
            }

            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart successfully.');
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, CartItem $cartItem): RedirectResponse
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($cartItem->cart->user_id !== Auth::id()) {
            abort(403);
        }

        $product = $cartItem->product;

        if ($product && $product->stock < $request->quantity) {
            return back()->with('error', 'Requested quantity exceeds available stock.');
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return redirect()->route('cart.index')->with('success', 'Cart updated.');
    }

    /**
     * Remove an item from the cart.
     */
    public function destroy(CartItem $cartItem): RedirectResponse
    {
        if ($cartItem->cart->user_id !== Auth::id()) {
            abort(403);
        }

        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }
}
