<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;  // validation class
use App\Models\Order;
use Illuminate\Support\Str;  // For generating unique order_id

class OrderController extends Controller
{
    public function store(OrderRequest $request)
    {
        $validated = $request->validated();

        // Unique order_id generate karo - e.g. "ORD" + random 8-char string
        $orderId = 'ORD' . strtoupper(Str::random(8));

        $order = Order::create([
            'order_id'       => $orderId,
            'name'           => $validated['name'],
            'email'          => $validated['email'],
            'phone'          => $validated['phone'],
            'address'        => $validated['address'],
            'items'          => json_encode($validated['items']),
            'total_price'    => $validated['total_price'],
            'payment_method' => $validated['payment_method'],
            'payment_details'=> $validated['payment_details'],
            'status'         => 'pending',
        ]);

        return response()->json([
            'message' => 'Order placed successfully!',
            'order_id' => $order->order_id,  // ye client ko bhejna zaroori hai
            'data'    => $order,
        ], 201);
    }
}
