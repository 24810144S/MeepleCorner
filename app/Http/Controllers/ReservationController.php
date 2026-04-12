<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Space;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function create(Request $request)
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

        // Get filter parameters
        $tableSizeFilter = $request->input('table_size_filter', 'all');
        $privateRoomSizeFilter = $request->input('private_room_size_filter', 'all');
        $selectedDate = $request->input('reservation_date');
        $selectedTimeSlot = $request->input('time_slot');

        // Get all active spaces
        $query = Space::where('is_active', true);

        // Apply table size filter (affects standard and premium tables only)
        $tableTypes = ['standard', 'premium'];
        
        if ($tableSizeFilter === 'none') {
            // Hide all tables - show ONLY private rooms
            $query->where('type', 'private');
        } elseif ($tableSizeFilter !== 'all') {
            // Show matching tables + all private rooms
            $query->where(function($q) use ($tableSizeFilter, $tableTypes) {
                switch ($tableSizeFilter) {
                    case 'small':
                        $q->where(function($sub) use ($tableTypes) {
                            $sub->whereIn('type', $tableTypes)->where('capacity', '<=', 3);
                        });
                        break;
                    case 'medium':
                        $q->where(function($sub) use ($tableTypes) {
                            $sub->whereIn('type', $tableTypes)->whereBetween('capacity', [4, 6]);
                        });
                        break;
                    case 'large':
                        $q->where(function($sub) use ($tableTypes) {
                            $sub->whereIn('type', $tableTypes)->where('capacity', '>=', 7);
                        });
                        break;
                }
                $q->orWhere('type', 'private');
            });
        }

        // Apply private room size filter (affects private rooms only)
        if ($privateRoomSizeFilter === 'none') {
            // Hide all private rooms - show ONLY tables
            $query->whereIn('type', $tableTypes);
        } elseif ($privateRoomSizeFilter !== 'all') {
            // Filter private rooms by size
            $query->where(function($q) use ($privateRoomSizeFilter, $tableTypes) {
                switch ($privateRoomSizeFilter) {
                    case 'small_private':
                        $q->where('type', 'private')->whereBetween('capacity', [2, 4]);
                        break;
                    case 'big_private':
                        $q->where('type', 'private')->where('capacity', '>=', 5);
                        break;
                }
                $q->orWhereIn('type', $tableTypes);
            });
        }

        $allSpaces = $query->get();

        // Get booked space IDs for selected date/time
        $bookedSpaceIds = [];
        if ($selectedDate && $selectedTimeSlot) {
            $bookedSpaceIds = Reservation::where('reservation_date', $selectedDate)
                ->where('time_slot', $selectedTimeSlot)
                ->pluck('space_id')
                ->toArray();
        }

        // Mark spaces as available or not
        $spaces = $allSpaces->map(function ($space) use ($bookedSpaceIds) {
            $space->is_available = !in_array($space->id, $bookedSpaceIds);
            return $space;
        });

        // Get user's reservations
        $reservations = Reservation::where('member_id', session('member_id'))
            ->with('space')
            ->orderBy('reservation_date', 'desc')
            ->get();

        \Log::info('Found ' . $reservations->count() . ' reservations for member');

        // Define filter options for the view
        $tableSizeOptions = [
            'all' => 'All Tables',
            'small' => 'Small Tables (1-3 players)',
            'medium' => 'Medium Tables (4-6 players)',
            'large' => 'Large Tables (7+ players)',
            'none' => 'Hide All Tables (Show only Private Rooms)'
        ];

        $privateRoomSizeOptions = [
            'all' => 'All Private Rooms',
            'small_private' => 'Small Rooms (2-4 players)',
            'big_private' => 'Big Rooms (5+ players)',
            'none' => 'Hide All Rooms (Show only Tables)'
        ];

        return view('reservations.create', compact(
            'spaces', 
            'reservations', 
            'tableSizeOptions',
            'privateRoomSizeOptions',
            'tableSizeFilter',
            'privateRoomSizeFilter',
            'selectedDate',
            'selectedTimeSlot',
            'bookedSpaceIds'
        ));
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
            'time_slot' => 'required|in:10:00-13:00,13:00-16:00,16:00-19:00,19:00-22:00',
            'space_id' => 'required|exists:spaces,id',
        ]);

        // Check if space is already booked
        $existing = Reservation::where('space_id', $validated['space_id'])
            ->where('reservation_date', $validated['reservation_date'])
            ->where('time_slot', $validated['time_slot'])
            ->first();

        if ($existing) {
            \Log::warning('Space already booked', $validated);
            return back()->withErrors(['space_id' => 'This space is already booked for the selected date and time.'])->withInput();
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

    public function cancel(Reservation $reservation)
    {
        if (!session()->has('member_id')) {
            return redirect('/login');
        }

        if ($reservation->member_id != session('member_id')) {
            return redirect('/profile/history')->with('error', 'You cannot cancel this reservation.');
        }

        if ($reservation->reservation_date < date('Y-m-d')) {
            return redirect('/profile/history')->with('error', 'Cannot cancel past reservations.');
        }

        $reservation->delete();

        return redirect('/profile/history')->with('success', 'Reservation cancelled successfully!');
    }

    public function profileHistory()
    {
        if (!session()->has('member_id')) {
            return redirect('/login');
        }

        $member = Member::find(session('member_id'));
        
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

        return view('members.profile-history', compact('upcomingReservations', 'pastReservations', 'member'));
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