<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
    public function showRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $member = Member::where('email', $request->email)->first();

        if (!$member) {
            return back()->withErrors([
                'email' => 'This email address was not found.',
            ])->withInput();
        }

        $token = Str::random(64);

        DB::table('member_password_resets')->where('email', $request->email)->delete();

        DB::table('member_password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        $resetLink = url('/reset-password/' . $token);

        Mail::raw(
            "Hello from Meeple Corner Café!\n\nClick the link below to reset your password:\n\n{$resetLink}\n\nIf you did not request a password reset, please ignore this email.",
            function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('Reset Your Meeple Corner Password');
            }
        );

        return back()->with('success', 'A password reset link has been sent to your email.');
    }

    public function showResetForm($token)
    {
        $record = DB::table('member_password_resets')->where('token', $token)->first();

        if (!$record) {
            abort(404);
        }

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $record->email,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $record = DB::table('member_password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$record) {
            return back()->withErrors([
                'email' => 'Invalid or expired reset link.',
            ]);
        }

        $member = Member::where('email', $request->email)->first();

        if (!$member) {
            return redirect('/login');
        }

        $member->update([
            'password' => Hash::make($request->password),
        ]);

        DB::table('member_password_resets')->where('email', $request->email)->delete();

        return redirect('/login')->with('success', 'Your password has been reset successfully.');
    }
}