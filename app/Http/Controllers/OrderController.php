<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display a list of the user's orders.
     */
    public function index(): View
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('orderItems')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Process checkout and convert cart into an order.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();

        // Find the user's active cart with items and products loaded
        $cart = Cart::with('cartItems.product')->where('user_id', $user->id)->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        try {
            $order = DB::transaction(function () use ($user, $cart) {
                $totalPrice = 0;
                $lockedProducts = [];

                // 1. Lock each product row with pessimistic locking and verify stock
                foreach ($cart->cartItems as $item) {
                    $product = Product::where('id', $item->product_id)->lockForUpdate()->first();

                    if (!$product || $product->stock <= 0) {
                        throw new Exception("Produk '" . ($product ? $product->name : 'Item') . "' sedang habis (Out of stock).");
                    }

                    if ($product->stock < $item->quantity) {
                        throw new Exception("Stok produk '{$product->name}' tidak mencukupi (Tersedia: {$product->stock}, Diminta: {$item->quantity}).");
                    }

                    $totalPrice += $product->price * $item->quantity;
                    $lockedProducts[$item->id] = $product;
                }

                // 2. Create the main Order record
                $order = Order::create([
                    'user_id' => $user->id,
                    'total_price' => $totalPrice,
                    'status' => 'pending',
                ]);

                // 3. Create OrderItems and safely deduct stock
                foreach ($cart->cartItems as $item) {
                    $product = $lockedProducts[$item->id];

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'quantity' => $item->quantity,
                        'price_at_purchase' => $product->price,
                    ]);

                    // Safe decrement with guaranteed transaction rollback on failure
                    $product->decrement('stock', $item->quantity);
                }

                // 4. Clear the user's shopping cart
                $cart->cartItems()->delete();
                $cart->delete();

                return $order;
            });

            return redirect()->route('orders.show', $order)
                ->with('success', 'Order placed successfully!');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display a specific order's details.
     */
    public function show(Order $order): View
    {
        if ($order->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $order->load('orderItems.product');

        return view('orders.show', compact('order'));
    }
}
