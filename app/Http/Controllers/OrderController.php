<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Display a list of the user's orders
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('orderItems')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    // Process checkout and convert cart into an order
    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Find the user's active cart with items and products loaded
        $cart = Cart::with('cartItems.product')->where('user_id', $user->id)->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Use a database transaction to ensure data integrity
        try {
            $order = DB::transaction(function () use ($user, $cart) {
                $totalPrice = 0;

                // 1. Calculate total and verify stock availability
                foreach ($cart->cartItems as $item) {
                    if ($item->product->stock < $item->quantity) {
                        throw new \Exception("Product '{$item->product->name}' is out of stock or exceeds available quantity.");
                    }
                    $totalPrice += $item->product->price * $item->quantity;
                }

                // 2. Create the main Order record
                $order = Order::create([
                    'user_id' => $user->id,
                    'total_price' => $totalPrice,
                    'status' => 'pending',
                ]);

                // 3. Create OrderItems and reduce product stock
                foreach ($cart->cartItems as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name,
                        'quantity' => $item->quantity,
                        'price_at_purchase' => $item->product->price,
                    ]);

                    // Deduct stock from the product table
                    $item->product->decrement('stock', $item->quantity);
                }

                // 4. Clear the user's shopping cart
                $cart->cartItems()->delete();
                $cart->delete();

                return $order;
            });

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // Display a specific order's details
    public function show(Order $order)
    {
        // Ensure the order belongs to the logged-in user (or user is admin)
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('orderItems.product');

        return view('orders.show', compact('order'));
    }
}