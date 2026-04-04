<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
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

        session([
            'member_id' => $member->id,
            'member_email' => $member->email,
            'member_name' => $member->first_name . ' ' . $member->last_name,
        ]);

        return redirect('/reservation');
    }

    public function failed()
    {
        return view('auth.failed');
    }

    public function logout()
    {
        session()->flush();
        return redirect('/');
    }
}