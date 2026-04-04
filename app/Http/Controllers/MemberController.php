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
}