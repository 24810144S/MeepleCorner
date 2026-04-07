<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Space;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function create()
    {
        // Debug
        \Log::info('Reservation create accessed', [
            'session_has_member_id' => session()->has('member_id'),
            'member_id' => session('member_id')
        ]);

        if (!session()->has('member_id')) {
            return redirect('/login');
        }
        \Log::info('=== RESERVATION CREATE PAGE ===');
        \Log::info('Current member_id: ' . session('member_id'));

        $spaces = Space::where('is_active', true)->get();
        $reservations = Reservation::where('member_id', session('member_id'))
            ->with('space')
            ->latest()
            ->get();

        \Log::info('Found ' . $reservations->count() . ' reservations for member');
        foreach($reservations as $res) {
            \Log::info('Reservation: ' . $res->id . ' - Date: ' . $res->reservation_date);
        }

        return view('reservations.create', compact('spaces', 'reservations'));
    }

    public function store(Request $request)
    {
        // Debug: Log the request
        \Log::info('Reservation form submitted', [
            'all_data' => $request->all(),
            'session_member_id' => session('member_id')
        ]);

        if (!session()->has('member_id')) {
            \Log::warning('No member_id in session, redirecting to login');
            return redirect('/login');
        }

        $validated = $request->validate([
            'reservation_date' => 'required|date|after_or_equal:today',
            'time_slot' => 'required',
            'space_id' => 'required|exists:spaces,id',
        ]);

        // Check if space is already booked
        $existing = Reservation::where('space_id', $validated['space_id'])
            ->where('reservation_date', $validated['reservation_date'])
            ->where('time_slot', $validated['time_slot'])
            ->first();

        if ($existing) {
            \Log::warning('Space already booked', $validated);
            return back()->with('error', 'This space is already booked for that time.')->withInput();
        }

        $reservation = Reservation::create([
            'member_id' => session('member_id'),
            'space_id' => $validated['space_id'],
            'reservation_date' => $validated['reservation_date'],
            'time_slot' => $validated['time_slot'],
            'status' => 'confirmed',
        ]);
        \Log::info('Reservation created successfully', ['reservation_id' => $reservation->id]);
        return redirect('/thank-you/' . $reservation->id);
    }

    public function thankYou(Reservation $reservation)
    {
        if (!session()->has('member_id')) {
            return redirect('/login');
        }

        if ($reservation->member_id != session('member_id')) {
            abort(403);
        }

        $reservation->load('space', 'member');

        return view('reservations.thankyou', compact('reservation'));
    }


    public function history()
    {
        // Check if user is logged in
        if (!session()->has('member_id')) {
            return redirect('/login');
        }

        $reservations = Reservation::where('member_id', session('member_id'))
            ->with('space')
            ->orderBy('reservation_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $today = date('Y-m-d');
        $upcomingReservations = $reservations->filter(function ($res) use ($today) {
            return $res->reservation_date >= $today;
        });

        $pastReservations = $reservations->filter(function ($res) use ($today) {
            return $res->reservation_date < $today;
        });

        return view('reservations.history', compact('upcomingReservations', 'pastReservations'));
    }

    public function cancel(Reservation $reservation)
    {
        // Check if user is logged in
        if (!session()->has('member_id')) {
            return redirect('/login');
        }

        // Ensure user owns this reservation
        if ($reservation->member_id != session('member_id')) {
            return redirect('/reservation-history')->with('error', 'You cannot cancel this reservation.');
        }

        // Only allow cancellation if date is today or future
        if ($reservation->reservation_date < date('Y-m-d')) {
            return redirect('/reservation-history')->with('error', 'Cannot cancel past reservations.');
        }

        $reservation->delete();

        return redirect('/reservation-history')->with('success', 'Reservation cancelled successfully!');
    }

    // API endpoint for checking available spaces
    public function getAvailableSpaces(Request $request)
    {
        $date = $request->input('date');
        $timeSlot = $request->input('time_slot');
        
        $bookedSpaceIds = Reservation::where('reservation_date', $date)
            ->where('time_slot', $timeSlot)
            ->pluck('space_id')
            ->toArray();
        
        $availableSpaces = Space::where('is_active', true)
            ->whereNotIn('id', $bookedSpaceIds)
            ->get();
        
        return response()->json($availableSpaces);
    }
}