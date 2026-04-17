<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Space;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function create(Request $request)
    {
        // Check if user is logged in
        $isLoggedIn = session()->has('member_id');
        
        // Get filter parameters
        $tableSizeFilter = $request->input('table_size_filter', 'all');
        $isPrivateBooking = $request->input('is_private_booking', false);
        $selectedDate = $request->input('reservation_date');
        $startTime = $request->input('start_time');
        $endTime = $request->input('end_time');

        // Force private room OFF when Small filter is selected
        if ($tableSizeFilter === 'small') {
            $isPrivateBooking = false;
        }

        // Build query for spaces - show public tables only (standard and premium)
        $query = Space::whereIn('type', ['standard', 'premium'])->where('is_active', true);

        // Apply size filter
        if ($tableSizeFilter !== 'all') {
            switch ($tableSizeFilter) {
                case 'small':
                    $query->where('capacity', '<=', 3);
                    break;
                case 'medium':
                    $query->whereBetween('capacity', [4, 6]);
                    break;
                case 'large':
                    $query->where('capacity', '>=', 7);
                    break;
            }
        }

        // Get all spaces (18 per page)
        $allSpaces = $query->paginate(18);

        // Get booked space IDs for selected date/time
        $bookedSpaceIds = [];
        if ($selectedDate && $startTime && $endTime) {
            $bookedSpaceIds = Reservation::where('reservation_date', $selectedDate)
                ->where(function($q) use ($startTime, $endTime) {
                    $q->where('start_time', '<', $endTime)
                      ->where('end_time', '>', $startTime);
                })
                ->pluck('space_id')
                ->toArray();
        }

        // Mark spaces as available or not
        $allSpaces->getCollection()->transform(function ($space) use ($bookedSpaceIds, $isPrivateBooking, $selectedDate, $startTime, $endTime) {
            // Check if space is actually booked (from database)
            $isBooked = in_array($space->id, $bookedSpaceIds);
            
            // Default values
            $space->is_available = false;
            $space->disabled_reason = null;
            $space->disabled_type = null;
            $space->show_private_badge = false;
            
            // Only if date and time are selected, we evaluate availability
            if ($selectedDate && $startTime && $endTime) {
                // PRIORITY 1: Private room restriction for small tables (capacity <= 3)
                if ($isPrivateBooking && $space->capacity <= 3) {
                    $space->is_available = false;
                    $space->disabled_reason = 'Not available for private room';
                    $space->disabled_type = 'private_only';  // This should be 'private_only'
                } 
                // PRIORITY 2: Check if table is actually booked
                elseif ($isBooked) {
                    $space->is_available = false;
                    $space->disabled_reason = 'Booked';
                    $space->disabled_type = 'booked';
                } 
                // PRIORITY 3: Available table
                else {
                    $space->is_available = true;
                    $space->show_private_badge = $isPrivateBooking && $space->capacity >= 4;
                }
            } else {
                // No date/time selected - all tables grayed out
                $space->disabled_reason = 'Select date & time first';
                $space->disabled_type = 'gray';
            }
            
            return $space;
        });

        $spaces = $allSpaces;

        // Get user's reservations (only if logged in)
        $reservations = [];
        if ($isLoggedIn) {
            $reservations = Reservation::where('member_id', session('member_id'))
                ->with('space')
                ->orderBy('reservation_date', 'desc')
                ->orderBy('start_time', 'desc')
                ->get();
        }

        // Filter options
        $tableSizeOptions = [
            'all' => 'All Sizes',
            'small' => 'Small (2-3 players)',
            'medium' => 'Medium (4-6 players)',
            'large' => 'Large (7-8 players)',
        ];

        // Time options (08:00 to 22:00, with 00 and 30 minutes)
        $timeOptions = [];
        for ($hour = 8; $hour <= 22; $hour++) {
            foreach ([0, 30] as $minute) {
                if ($hour == 22 && $minute > 0) continue;
                $time = sprintf('%02d:%02d', $hour, $minute);
                $timeOptions[$time] = $time;
            }
        }

        return view('reservations.create', compact(
            'spaces',
            'reservations',
            'tableSizeOptions',
            'tableSizeFilter',
            'isPrivateBooking',
            'selectedDate',
            'startTime',
            'endTime',
            'timeOptions',
            'bookedSpaceIds',
            'isLoggedIn'
        ));
    }

    // Store temporary reservation data and redirect to login (for guests)
    public function storeTemp(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'reservation_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'space_id' => 'required|exists:spaces,id',
        ]);

        // Get the space to check capacity
        $space = Space::find($validated['space_id']);
        $isPrivateBooking = $request->has('is_private_booking') && $request->input('is_private_booking') == 1;

        // If trying to book as private room but table is small (capacity <= 3)
        if ($isPrivateBooking && $space->capacity <= 3) {
            return back()->withErrors(['is_private_booking' => 'Small tables cannot be booked as private rooms. Please select a medium or large table.'])->withInput();
        }

        // Parse times
        $startTime = Carbon::parse($validated['start_time']);
        $endTime = Carbon::parse($validated['end_time']);
        $selectedDate = Carbon::parse($validated['reservation_date']);
        $now = Carbon::now();
        
        // Check if booking is less than 2 hours from now (ONLY for today's bookings)
        $today = Carbon::now()->format('Y-m-d');
        if ($validated['reservation_date'] == $today) {
            $bookingDateTime = Carbon::parse($selectedDate->format('Y-m-d') . ' ' . $startTime->format('H:i:s'));
            $hoursFromNow = $now->diffInHours($bookingDateTime, false);
            
            if ($bookingDateTime->isPast()) {
                return back()->withErrors(['start_time' => 'Cannot book a time slot that has already passed.'])->withInput();
            }
            
            if ($hoursFromNow < 2) {
                return back()->withErrors(['start_time' => 'Bookings must be made at least 2 hours in advance. Please select a later time.'])->withInput();
            }
        }
        
        // Calculate duration in minutes
        $durationMinutes = $startTime->diffInMinutes($endTime);
        
        // Rule A: Minimum 2 hours
        if ($durationMinutes < 120) {
            return back()->withErrors(['end_time' => 'Booking must be at least 2 hours.'])->withInput();
        }
        
        // Rule C: Maximum 9 hours
        if ($durationMinutes > 540) {
            return back()->withErrors(['end_time' => 'Booking cannot exceed 9 hours.'])->withInput();
        }
        
        // Rule B: Minutes must be 00 or 30
        $startMinutes = (int)$startTime->format('i');
        $endMinutes = (int)$endTime->format('i');
        
        if (!in_array($startMinutes, [0, 30])) {
            return back()->withErrors(['start_time' => 'Start time minutes must be 00 or 30.'])->withInput();
        }
        
        if (!in_array($endMinutes, [0, 30])) {
            return back()->withErrors(['end_time' => 'End time minutes must be 00 or 30.'])->withInput();
        }
        
        // Hours must be between 08:00 and 22:00
        $startHour = (int)$startTime->format('H');
        
        if ($startHour < 8 || $startHour > 22) {
            return back()->withErrors(['start_time' => 'Start time must be between 08:00 and 22:00.'])->withInput();
        }

        // Check for time conflict
        $hasConflict = Reservation::where('space_id', $validated['space_id'])
            ->where('reservation_date', $validated['reservation_date'])
            ->where(function($q) use ($startTime, $endTime) {
                $q->where('start_time', '<', $endTime->format('H:i:s'))
                  ->where('end_time', '>', $startTime->format('H:i:s'));
            })
            ->exists();

        if ($hasConflict) {
            return back()->withErrors(['time_slot' => 'This time slot conflicts with an existing booking.'])->withInput();
        }

        // Store data in session and redirect to login
        session(['temp_reservation_data' => [
            'space_id' => $validated['space_id'],
            'reservation_date' => $validated['reservation_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'is_private_booking' => $isPrivateBooking ? 1 : 0,
        ]]);

        session(['url.intended' => '/reservation/confirm']);

        return redirect('/login');
    }

    // Original store method for logged-in users (redirects to confirm)
    public function store(Request $request)
    {
        if (!session()->has('member_id')) {
            return redirect('/login');
        }

        // Validate request
        $validated = $request->validate([
            'reservation_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'space_id' => 'required|exists:spaces,id',
        ]);

        // Get the space to check capacity
        $space = Space::find($validated['space_id']);
        $isPrivateBooking = $request->has('is_private_booking') && $request->input('is_private_booking') == 1;

        // If trying to book as private room but table is small (capacity <= 3)
        if ($isPrivateBooking && $space->capacity <= 3) {
            return back()->withErrors(['is_private_booking' => 'Small tables cannot be booked as private rooms. Please select a medium or large table.'])->withInput();
        }

        // Parse times
        $startTime = Carbon::parse($validated['start_time']);
        $endTime = Carbon::parse($validated['end_time']);
        $selectedDate = Carbon::parse($validated['reservation_date']);
        $now = Carbon::now();
        
        // Check if booking is less than 2 hours from now (ONLY for today's bookings)
        $today = Carbon::now()->format('Y-m-d');
        if ($validated['reservation_date'] == $today) {
            $bookingDateTime = Carbon::parse($selectedDate->format('Y-m-d') . ' ' . $startTime->format('H:i:s'));
            $hoursFromNow = $now->diffInHours($bookingDateTime, false);
            
            if ($bookingDateTime->isPast()) {
                return back()->withErrors(['start_time' => 'Cannot book a time slot that has already passed.'])->withInput();
            }
            
            if ($hoursFromNow < 2) {
                return back()->withErrors(['start_time' => 'Bookings must be made at least 2 hours in advance. Please select a later time.'])->withInput();
            }
        }
        
        // Calculate duration in minutes
        $durationMinutes = $startTime->diffInMinutes($endTime);
        
        // Rule A: Minimum 2 hours
        if ($durationMinutes < 120) {
            return back()->withErrors(['end_time' => 'Booking must be at least 2 hours.'])->withInput();
        }
        
        // Rule C: Maximum 9 hours
        if ($durationMinutes > 540) {
            return back()->withErrors(['end_time' => 'Booking cannot exceed 9 hours.'])->withInput();
        }
        
        // Rule B: Minutes must be 00 or 30
        $startMinutes = (int)$startTime->format('i');
        $endMinutes = (int)$endTime->format('i');
        
        if (!in_array($startMinutes, [0, 30])) {
            return back()->withErrors(['start_time' => 'Start time minutes must be 00 or 30.'])->withInput();
        }
        
        if (!in_array($endMinutes, [0, 30])) {
            return back()->withErrors(['end_time' => 'End time minutes must be 00 or 30.'])->withInput();
        }
        
        // Hours must be between 08:00 and 22:00
        $startHour = (int)$startTime->format('H');
        
        if ($startHour < 8 || $startHour > 22) {
            return back()->withErrors(['start_time' => 'Start time must be between 08:00 and 22:00.'])->withInput();
        }

        // Check for time conflict
        $hasConflict = Reservation::where('space_id', $validated['space_id'])
            ->where('reservation_date', $validated['reservation_date'])
            ->where(function($q) use ($startTime, $endTime) {
                $q->where('start_time', '<', $endTime->format('H:i:s'))
                  ->where('end_time', '>', $startTime->format('H:i:s'));
            })
            ->exists();

        if ($hasConflict) {
            return back()->withErrors(['time_slot' => 'This time slot conflicts with an existing booking.'])->withInput();
        }

        // Store data in session and redirect to confirmation page
        session(['reservation_data' => [
            'space_id' => $validated['space_id'],
            'reservation_date' => $validated['reservation_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'is_private_booking' => $isPrivateBooking ? 1 : 0,
        ]]);

        return redirect()->route('reservation.confirm');
    }

    // Show confirmation page before final submission
    public function showConfirm()
    {
        if (!session()->has('member_id')) {
            return redirect('/login');
        }

        // Check for temporary reservation data (guest booking)
        $reservationData = session('temp_reservation_data');
        
        // If no temp data, check for regular session data
        if (!$reservationData) {
            $reservationData = session('reservation_data');
        }
        
        if (!$reservationData) {
            return redirect('/reservation')->with('error', 'Please select your booking details first.');
        }

        $space = Space::find($reservationData['space_id']);
        $member = Member::find(session('member_id'));

        return view('reservations.confirm', compact('reservationData', 'space', 'member'));
    }

    // Process final confirmation and redirect to history
    public function processConfirm()
    {
        if (!session()->has('member_id')) {
            return redirect('/login');
        }

        // Check for temporary reservation data first (guest booking)
        $reservationData = session('temp_reservation_data');
        
        // If no temp data, check for regular session data
        if (!$reservationData) {
            $reservationData = session('reservation_data');
        }
        
        if (!$reservationData) {
            return redirect('/reservation')->with('error', 'Session expired. Please try again.');
        }

        // Check for time conflict again
        $hasConflict = Reservation::where('space_id', $reservationData['space_id'])
            ->where('reservation_date', $reservationData['reservation_date'])
            ->where(function($q) use ($reservationData) {
                $q->where('start_time', '<', $reservationData['end_time'])
                  ->where('end_time', '>', $reservationData['start_time']);
            })
            ->exists();

        if ($hasConflict) {
            session()->forget(['temp_reservation_data', 'reservation_data']);
            return redirect('/reservation')->withErrors(['time_slot' => 'This time slot is no longer available. Please select another.']);
        }

        // Create reservation
        $reservation = Reservation::create([
            'member_id' => session('member_id'),
            'space_id' => $reservationData['space_id'],
            'reservation_date' => $reservationData['reservation_date'],
            'start_time' => $reservationData['start_time'],
            'end_time' => $reservationData['end_time'],
            'status' => 'confirmed',
            'is_private_booking' => $reservationData['is_private_booking'] ?? 0,
        ]);

        // Clear session data
        session()->forget(['temp_reservation_data', 'reservation_data', 'url.intended']);
        
        // Store the new reservation ID in session for highlighting
        session()->flash('new_reservation_id', $reservation->id);
        session()->flash('booking_success', '🎉 Your booking has been confirmed successfully!');

        return redirect('/profile/history');
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
            ->orderBy('start_time', 'desc')
            ->get();

        $today = date('Y-m-d');
        $now = date('H:i:s');
        
        $upcomingReservations = $reservations->filter(function ($res) use ($today, $now) {
            return $res->reservation_date > $today || 
                   ($res->reservation_date == $today && $res->end_time > $now);
        });

        $pastReservations = $reservations->filter(function ($res) use ($today, $now) {
            return $res->reservation_date < $today || 
                   ($res->reservation_date == $today && $res->end_time <= $now);
        });

        return view('members.profile-history', compact('upcomingReservations', 'pastReservations', 'member'));
    }

    public function getAvailableSpaces(Request $request)
    {
        $date = $request->input('date');
        $startTime = $request->input('start_time');
        $endTime = $request->input('end_time');
        
        $bookedSpaceIds = [];
        if ($date && $startTime && $endTime) {
            $bookedSpaceIds = Reservation::where('reservation_date', $date)
                ->where(function($q) use ($startTime, $endTime) {
                    $q->where('start_time', '<', $endTime)
                      ->where('end_time', '>', $startTime);
                })
                ->pluck('space_id')
                ->toArray();
        }
        
        $availableSpaces = Space::where('is_active', true)
            ->whereNotIn('id', $bookedSpaceIds)
            ->get();
        
        return response()->json($availableSpaces);
    }
}