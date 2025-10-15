<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Mail;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validate incoming request
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'phone'   => 'required|string',
            'date'    => 'required|date',
            'time'    => 'required',
            'guests'  => 'required|integer|min:1',
            'message' => 'nullable|string',
        ]);

        // 2. Save to database
        $reservation = Reservation::create($validated);

        // 3. Send email to staff/owner
        Mail::raw("New Reservation:\n\n" . print_r($reservation->toArray(), true), function ($message) {
            $message->to('maryamwaraich498@gmail.com') // ← Replace with your staff/owner email
                    ->subject('New Reservation Received');
        });

        // 4. Return JSON response
        return response()->json([
            'message' => 'Reservation successful!',
            'data'    => $reservation
        ], 201);
    }
}
