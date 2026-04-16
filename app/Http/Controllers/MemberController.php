<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function create()
    {
        return view('members.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'last_name' => 'required|max:255',
            'first_name' => 'required|max:255',
            'address' => 'required|max:255',
            'phone' => 'required|max:30',
            'email' => 'required|email|unique:members,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['subscribe_events'] = $request->has('subscribe_events');
        
        // Handle security answers
        $validated['security_q1_id'] = $request->security_q1_id;
        $validated['security_a1'] = $request->security_a1;
        $validated['security_a2'] = $request->security_a2;
        $validated['security_a3'] = $request->security_a3;

        $member = Member::create($validated);
        
        // Auto-login after registration
        session()->regenerate();
        session([
            'member_id' => $member->id,
            'member_email' => $member->email,
            'member_name' => $member->first_name . ' ' . $member->last_name,
        ]);

        // Check if there's a pending reservation from guest booking
        if (session()->has('temp_reservation_data')) {
            return redirect('/reservation/confirm')->with('success', 'Registration successful! Please confirm your booking.');
        }

        return redirect('/reservation')->with('success', 'Registration successful! Welcome to Meeple Corner Café!');
    }

    // Redirect to profile info page
    public function profile()
    {
        if (!session()->has('member_id')) {
            return redirect('/login');
        }
        return redirect('/profile/info');
    }

    // Profile Info (Read-only)
    public function profileInfo()
    {
        if (!session()->has('member_id')) {
            return redirect('/login');
        }

        $member = Member::find(session('member_id'));
        
        if (!$member) {
            session()->flush();
            return redirect('/login');
        }

        return view('members.profile-info', compact('member'));
    }

    // Profile Edit (Edit profile information)
    public function profileEdit()
    {
        if (!session()->has('member_id')) {
            return redirect('/login');
        }

        $member = Member::find(session('member_id'));
        
        if (!$member) {
            session()->flush();
            return redirect('/login');
        }

        return view('members.profile-edit', compact('member'));
    }

    // Update profile information
    public function updateProfile(Request $request)
    {
        if (!session()->has('member_id')) {
            return redirect('/login');
        }

        $member = Member::find(session('member_id'));

        $validated = $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'address' => 'required|max:255',
            'phone' => 'required|max:30',
            'email' => 'required|email|unique:members,email,' . $member->id,
        ]);

        $member->first_name = $validated['first_name'];
        $member->last_name = $validated['last_name'];
        $member->address = $validated['address'];
        $member->phone = $validated['phone'];
        $member->email = $validated['email'];
        $member->save();

        // Update session name
        session(['member_name' => $member->first_name . ' ' . $member->last_name]);

        return redirect('/profile/info')->with('success', 'Profile updated successfully!');
    }

    // Update password
    public function updatePassword(Request $request)
    {
        if (!session()->has('member_id')) {
            return redirect('/login');
        }

        $member = Member::find(session('member_id'));

        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        // Check current password
        if (!Hash::check($validated['current_password'], $member->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.'])->withInput();
        }

        $member->password = Hash::make($validated['password']);
        $member->save();

        return redirect('/profile/edit')->with('success', 'Password changed successfully!');
    }
}