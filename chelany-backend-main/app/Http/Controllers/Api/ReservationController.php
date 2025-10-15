<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class ReservationController extends Controller
{
    // ✅ GET: /api/reservations — List all reservations (latest first)
    public function index()
    {
        $reservations = Reservation::orderBy('created_at', 'desc')->get();
        return response()->json($reservations);
    }

    // ✅ POST: /api/reservations — Create new reservation
    public function store(Request $request)
    {
        // ✅ Step 1: Validate input
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'phone'   => 'required|string',
            'date'    => 'required|date',
            'time'    => 'required',
            'guests'  => 'required|integer|min:1',
            'message' => 'nullable|string',
        ]);

        // ✅ Step 2: Format date/time to Europe/Berlin
        $validated['date'] = Carbon::parse($validated['date'])
            ->timezone('Europe/Berlin')
            ->format('Y-m-d');

        $validated['time'] = Carbon::parse($validated['time'])
            ->timezone('Europe/Berlin')
            ->format('H:i:s');

        // ✅ Step 3: Save to database
        $reservation = Reservation::create($validated);

        // ✅ Step 4: Email to restaurant owner
        Mail::send('emails.reservation', ['data' => $reservation->toArray(), 'type' => 'owner'], function ($message) {
            $message->to('alishafaqat140@gmail.com')
                    ->subject('New Reservation - Chelany Restaurant');
        });

        // ✅ Step 5: Email to customer
        Mail::send('emails.reservation', ['data' => $reservation->toArray(), 'type' => 'user'], function ($message) use ($validated) {
            $message->to($validated['email'])
                    ->subject('Your Reservation Confirmation - Chelany Restaurant');
        });

        // ✅ Step 6: JSON Response
        return response()->json([
            'message' => 'Reservation successful! Confirmation email sent.',
            'data' => [
                'id'         => $reservation->id,
                'name'       => $reservation->name,
                'email'      => $reservation->email,
                'phone'      => $reservation->phone,
                'date'       => $reservation->date,
                'time'       => $reservation->time,
                'guests'     => $reservation->guests,
                'message'    => $reservation->message,
                'created_at' => Carbon::parse($reservation->created_at)
                                    ->timezone('Europe/Berlin')
                                    ->format('Y-m-d H:i:s'),
            ]
        ], 201);
    }

    // ✅ DELETE: /api/reservations/{id} — Delete reservation by ID
    public function destroy($id)
    {
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return response()->json(['message' => 'Reservation not found.'], 404);
        }

        $reservation->delete();

        return response()->json(['message' => 'Reservation deleted successfully.']);
    }
}
