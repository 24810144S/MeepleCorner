<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Space;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function create()
    {
        if (!session()->has('member_id')) {
            return redirect('/login');
        }

        $spaces = Space::where('is_active', true)->get();

        return view('reservations.create', compact('spaces'));
    }

    public function store(Request $request)
    {
        if (!session()->has('member_id')) {
            return redirect('/login');
        }

        $validated = $request->validate([
            'reservation_date' => 'required|date',
            'time_slot' => 'required',
            'space_id' => 'required|exists:spaces,id',
        ]);

        $reservation = Reservation::create([
            'member_id' => session('member_id'),
            'space_id' => $validated['space_id'],
            'reservation_date' => $validated['reservation_date'],
            'time_slot' => $validated['time_slot'],
            'status' => 'confirmed',
        ]);

        return redirect('/thank-you/' . $reservation->id);
    }

    public function thankYou(Reservation $reservation)
    {
        if (!session()->has('member_id')) {
            return redirect('/login');
        }

        $reservation->load('space', 'member');

        return view('reservations.thankyou', compact('reservation'));
    }
}