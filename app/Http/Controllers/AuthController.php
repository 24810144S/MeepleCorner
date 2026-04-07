<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        // If already logged in, redirect to reservation
        if (session()->has('member_id')) {
            return redirect('/reservation');
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
        session()->regenerate(); // Important: prevent session fixation
        session([
            'member_id' => $member->id,
            'member_email' => $member->email,
            'member_name' => $member->first_name . ' ' . $member->last_name,
        ]);

        // Also set a cookie for "Remember Me" if checked
        if ($request->has('remember')) {
            session()->put('remember_me', true);
        }

        // Debug: Check if session is set
        \Log::info('User logged in:', ['member_id' => $member->id, 'session_id' => session()->getId()]);

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