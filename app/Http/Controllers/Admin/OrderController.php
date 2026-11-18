<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display a listing of all customer orders.
     */
    public function index(): View
    {
        $orders = Order::with(['user', 'orderItems.product'])
            ->withCount('orderItems')
            ->latest()
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified order details.
     */
    public function show(Order $order): View
    {
        $order->load(['user', 'orderItems.product']);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update the status of the specified order.
     */
    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order->update([
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Order status updated successfully.');
    }
}
