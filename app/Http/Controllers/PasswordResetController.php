<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Str;

class PasswordResetController extends Controller
{
    public function showForgotForm()
    {
        return view('forgot-password');
    }

    public function generateResetLink(Request $request)
    {
        $request->validate([
            'username' => 'required'
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return back()->withErrors(['username' => 'Username non trovato']);
        }

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->username], 
            [
                'token' => $token,
                'created_at' => now()
            ]
        );

        $resetLink = url('/password/reset/' . $token);

        return view('show_link', compact('resetLink'));
    }


    public function showResetForm($token)
    {
        return view('reset-password', compact('token'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
            'token' => 'required'
        ]);

        $entry = DB::table('password_reset_tokens')->where('token', $request->token)->first();

        if (!$entry) {
            return back()->withErrors(['token' => 'Token invalido o scaduto']);
        }

        $username = $entry->email;

        User::where('username', $username)->update([
            'password' => Hash::make($request->password)
        ]);

        DB::table('password_reset_tokens')->where('email', $username)->delete();

        return redirect('/login')->with('status', 'Password aggiornata con successo');
    }

}
