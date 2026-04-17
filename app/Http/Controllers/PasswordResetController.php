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
   public function showRequestForm(Request $request)
{
    $email = $request->query('email', '');
    return view('auth.forgot-password', compact('email'));
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
    // -----------------------------------------------------------------
    // Security questions based reset (two questions)
    // -----------------------------------------------------------------

    // Step 1 – verify email exists for security questions
   public function verifyEmailForSecurity(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:members,email',
    ]);

    $member = Member::where('email', $request->email)->first();

    session([
        'reset_member_id' => $member->id,
        // 第一組問題與答案
        'reset_security_question1' => $member->security_q1_id,
        'reset_security_answer1' => $member->security_a1,
        'reset_security_question_season' => 'What is your favorite season of the year?',
        'reset_security_answer_season' => $member->security_a3,
        // 第二組問題與答案
        'reset_security_question_genre' => 'What is your favorite board game genre?',
        'reset_security_answer_genre' => $member->security_a2,
        'reset_security_question_q1_again' => $member->security_q1_id,
        'reset_security_answer_q1_again' => $member->security_a1,
        'security_attempts' => 0,
    ]);

    return redirect()->route('password.security-questions');
}

    // Step 2 – show the two security questions
    public function showSecurityQuestions()
{
    if (!session('reset_member_id')) {
        return redirect()->route('password.request')->withErrors(['email' => '請重新開始。']);
    }

    $attempts = session('security_attempts', 0);
    $exhausted = $attempts >= 2;

    if ($exhausted) {
        return view('auth.security-questions', compact('exhausted'));
    }

    // 根據嘗試次數選擇問題組
    if ($attempts == 0) {
        $question1 = session('reset_security_question1', '您設定的安全問題');
        $question2 = session('reset_security_question_season', '最喜歡的季節？');
    } else {
        $question1 = session('reset_security_question_genre', '最喜歡的遊戲類型？');
        $question2 = session('reset_security_question_q1_again', '您設定的安全問題');
    }

    // 確保變數都存在，避免視圖報錯
    return view('auth.security-questions', compact('question1', 'question2', 'attempts', 'exhausted'));
}

    // Step 3 – verify the answers (both questions)
   public function verifyAnswers(Request $request)
{
    $request->validate([
        'answer1' => 'required|string',
        'answer2' => 'required|string',
    ]);

    $attempts = session('security_attempts', 0);

    if ($attempts == 0) {
        $storedAnswer1 = session('reset_security_answer1');
        $storedAnswer2 = session('reset_security_answer_season');
    } else {
        $storedAnswer1 = session('reset_security_answer_genre');
        $storedAnswer2 = session('reset_security_answer_q1_again');
    }

    if (strtolower(trim($request->answer1)) !== strtolower(trim($storedAnswer1)) ||
        strtolower(trim($request->answer2)) !== strtolower(trim($storedAnswer2))) {
        $attempts++;
        session(['security_attempts' => $attempts]);

        if ($attempts >= 2) {
            return redirect()->route('password.security-questions')->withErrors(['security' => 'You have exceeded the number of attempts.']);
        }
        return back()->withErrors(['security' => 'The answer is incorrect. Please try again (for a different question).']);
    }

    session(['reset_allowed' => true]);
    session()->forget(['security_attempts']);
    return redirect()->route('password.security-reset');
}

    // Step 4 – show the reset password form
    public function showSecurityResetForm()
    {
        if (!session('reset_allowed') || !session('reset_member_id')) {
            return redirect()->route('password.request')->withErrors(['email' => 'Invalid request.']);
        }
        return view('auth.reset-password-security');
    }

    // Step 5 – update the password
    public function resetPasswordWithSecurity(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        if (!session('reset_allowed') || !session('reset_member_id')) {
            return redirect()->route('password.request')->withErrors(['email' => 'Invalid request.']);
        }

        $member = Member::find(session('reset_member_id'));
        $member->password = Hash::make($request->password);
        $member->save();

        // Clear session data
        session()->forget([
            'reset_member_id',
            'reset_security_question1',
            'reset_security_answer1',
            'reset_security_question3',
            'reset_security_answer3',
            'reset_allowed'
        ]);

        return redirect()->route('login')->with('success', 'Password reset successfully! Please login.');
    }
}