<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderStatusController extends Controller
{
    // order status dikhana
    public function show($orderId)
{
    $order = Order::where('order_id', $orderId)->first();

    if (!$order) {
        return response()->json([
            'success' => false,
            'message' => 'Order not found'
        ], 404);
    }

    return response()->json([
        'success' => true,
        'order' => [
            'order_id' => $order->order_id,
            'name' => $order->name,
            'phone' => $order->phone,
            'status' => $order->status,
            'items' => $order->items,  // already casted to array
            'total_price' => $order->total_price,
            'payment_method' => $order->payment_method,  // <-- yeh line add karni hai
            'created_at' => $order->created_at->toDateTimeString(),
        ]
    ]);
}

    // order cancel karna
    public function cancel(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,order_id',  // order_id ke basis par validate karo
        ]);

        $order = Order::where('order_id', $request->order_id)->first();

        if ($order->status === 'cancelled') {
            return response()->json([
                'success' => false,
                'message' => 'Order is already cancelled.'
            ]);
        }

        if ($order->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Only pending orders can be cancelled.'
            ]);
        }

        $order->status = 'cancelled';
        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'Order cancelled successfully.',
            'order_id' => $order->order_id
        ]);
    }
}
