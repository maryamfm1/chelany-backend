<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    // Online order status set/update karne ke liye method
    public function updateOnlineOrderStatus(Request $request)
    {
        // Validation
        $request->validate([
            'value' => 'required|string|in:available,unavailable',
        ]);

        // Setting update ya create karna
        Setting::updateOrCreate(
            ['key' => 'online_order_status'],
            ['value' => $request->value]
        );

        return response()->json(['success' => true, 'status' => $request->value]);
    }

    // Agar aap chahte hain ke online order status get bhi ho to yeh method add kar sakte hain
    public function getOnlineOrderStatus()
    {
        $status = Setting::where('key', 'online_order_status')->value('value') ?? 'unavailable';

        return response()->json(['status' => $status]);
    }
}
