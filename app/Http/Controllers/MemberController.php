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
            'password' => 'required|min:6',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['subscribe_events'] = $request->has('subscribe_events');

        Member::create($validated);

        return redirect('/login')->with('success', 'Registration successful! Please log in.');
    }

    
    public function profile()
    {
        // Debug: Check if session exists
        \Log::info('Profile accessed', [
            'session_has_member_id' => session()->has('member_id'),
            'member_id' => session('member_id'),
            'all_session' => session()->all()
        ]);
        
        // Check if user is logged in
        if (!session()->has('member_id')) {
            return redirect('/login');
        }

        $member = Member::find(session('member_id'));
        
        if (!$member) {
            session()->flush();
            return redirect('/login');
        }

        return view('members.profile', compact('member'));
    }

    public function updateProfile(Request $request)
    {
        // Check if user is logged in
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

        // Only update password if provided
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:6|confirmed',
            ]);
            $validated['password'] = Hash::make($request->password);
            $member->password = $validated['password'];
        }

        $member->first_name = $validated['first_name'];
        $member->last_name = $validated['last_name'];
        $member->address = $validated['address'];
        $member->phone = $validated['phone'];
        $member->email = $validated['email'];
        $member->save();

        // Update session name
        session(['member_name' => $member->first_name . ' ' . $member->last_name]);

        return redirect('/profile')->with('success', 'Profile updated successfully!');
    }
}