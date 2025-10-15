<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function login(Request $request)
{
    try {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = bin2hex(random_bytes(40));

        return response()->json([
            'token' => $token,
            'admin' => [
                'id' => $admin->id,
                'email' => $admin->email,
            ]
        ]);
    } catch (\Exception $e) {
        // Error message detail bhej do frontend ko
        return response()->json([
            'message' => 'Server Error',
            'error' => $e->getMessage(),
        ], 500);
    }
}

}
