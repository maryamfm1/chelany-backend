<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Str;

class OrderController extends Controller
{
    // Store new order
    public function store(OrderRequest $request)
{
    try {
        Log::info('🟢 Order API hit hua');
        $validated = $request->validated();

        $discountCode = $validated['discount_code'] ?? null;
        $discountPercentage = 0;

        if ($discountCode) {
            $validDiscountCodes = [
                'CHELANY20' => 20,
                'WELCOME10' => 10,
            ];

            if (array_key_exists($discountCode, $validDiscountCodes)) {
                $discountPercentage = $validDiscountCodes[$discountCode];
            } else {
                return response()->json([
                    'message' => 'Invalid discount code.'
                ], 400);
            }
        }

        $originalPrice = $validated['total_price'];
        $discountAmount = ($discountPercentage / 100) * $originalPrice;
        $finalPrice = $originalPrice - $discountAmount;

        $orderId = 'ORD' . strtoupper(Str::random(8));

        $order = Order::create([
            'order_id'            => $orderId,
            'name'                => $validated['name'],
            'email'               => $validated['email'],
            'phone'               => $validated['phone'],
            'address'             => $validated['address'],
            'items'               => json_encode($validated['items']),
            'total_price'         => $finalPrice,
            'payment_method'      => $validated['payment_method'],
            'payment_details'     => $validated['payment_details'],
            'status'              => 'pending',
            'instructions'        => $validated['instructions'] ?? null,
            'tip'                 => $validated['tip'] ?? 0,
            'discount_code'       => $discountCode,
            'discount_percentage' => $discountPercentage,
        ]);

        return response()->json([
            'message'  => 'Order placed successfully!',
            'order_id' => $order->order_id,
            'data'     => $order,
        ], 201);

    } catch (\Exception $e) {
        Log::error('Order store error: ' . $e->getMessage());
        return response()->json([
            'message' => 'Server Error',
            'error'   => $e->getMessage()
        ], 500);
    }
}

    // Get all orders
    public function index()
    {
        $orders = Order::orderBy('created_at', 'desc')->get();
        return response()->json($orders);
    }

    // Update order status (remove frontend usage as you mentioned)
    public function updateStatus(Request $request, $order_id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $order = Order::where('order_id', $order_id)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->status = $request->status;
        $order->save();

        return response()->json([
            'message' => 'Order status updated successfully!',
            'order'   => $order
        ]);
    }

    // Delete order by order_id
    public function destroy($order_id)
    {
        $order = Order::where('order_id', $order_id)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        $order->delete();

        return response()->json(['message' => 'Order deleted successfully!']);
    }
}
