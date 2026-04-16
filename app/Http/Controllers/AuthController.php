<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin(Request $request)
    {
        // If already logged in, go to reservation
        if (session()->has('member_id')) {
            return redirect('/reservation');
        }

        // Store the intended URL from query string
        $redirect = $request->query('redirect');
        if ($redirect) {
            session(['url.intended' => $redirect]);
            \Log::info('Stored redirect from query: ' . $redirect);
        } else {
            $previous = url()->previous();
            if (!str_contains($previous, '/login') && $previous !== url('/')) {
                session(['url.intended' => $previous]);
                \Log::info('Stored redirect from previous: ' . $previous);
            }
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $member = Member::where('email', $validated['email'])->first();

        if (!$member || !Hash::check($validated['password'], $member->password)) {
            return redirect('/login-failed');
        }

        // Store session data
        session()->regenerate();
        session([
            'member_id' => $member->id,
            'member_email' => $member->email,
            'member_name' => $member->first_name . ' ' . $member->last_name,
        ]);

        if ($request->has('remember')) {
            session()->put('remember_me', true);
        }

        \Log::info('User logged in:', ['member_id' => $member->id, 'session_id' => session()->getId()]);

        // Priority 1: Check for pending reservation from guest booking
        if (session()->has('temp_reservation_data')) {
            return redirect('/reservation/confirm');
        }
        
        // Priority 2: Check for intended URL
        $intendedUrl = session('url.intended');
        if ($intendedUrl && $intendedUrl !== url('/login')) {
            session()->forget('url.intended');
            return redirect($intendedUrl);
        }
        
        // Priority 3: Default to reservation page
        return redirect('/reservation');
    }

    public function failed()
    {
        return view('auth.failed');
    }

    public function logout()
    {
        session()->flush();
        session()->regenerate();
        return redirect('/');
    }
}