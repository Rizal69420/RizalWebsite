<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Display the user's shopping cart
    public function index()
    {
        $user = Auth::user();
        
        // Find or create an active cart for the authenticated user
        $cart = Cart::with('items.product')->firstOrCreate(['user_id' => $user->id]);

        return view('cart.index', compact('cart'));
    }

    // Add a product to the cart
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $product = Product::findOrFail($request->product_id);

        // Check if product has enough stock
        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Requested quantity exceeds available stock.');
        }

        // Get or create user's cart
        $cart = Cart::firstOrCreate(['user_id' => $user->id]);

        // Check if item already exists in the cart
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            // Update quantity if it already exists, checking total stock limit
            $newQuantity = $cartItem->quantity + $request->quantity;
            
            if ($product->stock < $newQuantity) {
                return back()->with('error', 'Cannot add more. Stock limit reached.');
            }

            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            // Create new cart item
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price, // Save snapshot of price
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart successfully.');
    }

    // Update cart item quantity
    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Ensure the cart item belongs to the authenticated user
        if ($cartItem->cart->user_id !== Auth::id()) {
            abort(403);
        }

        $product = $cartItem->product;

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Requested quantity exceeds available stock.');
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return redirect()->route('cart.index')->with('success', 'Cart updated.');
    }

    // Remove an item from the cart
    public function destroy(CartItem $cartItem)
    {
        // Ensure the cart item belongs to the authenticated user
        if ($cartItem->cart->user_id !== Auth::id()) {
            abort(403);
        }

        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }
}