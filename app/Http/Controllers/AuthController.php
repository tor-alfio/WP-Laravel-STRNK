<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/allenamenti');
        }

        return back()->withErrors([
            'username' => 'Credenziali non valide.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
        'name' => 'required|string|max:255',
        'surname' => 'required|string|max:255',
        'birthday' => 'required|date',
        'sex' => 'required|string|max:50',
        'email' => 'required|email|max:255|unique:user,email',
        'username' => 'required|string|max:255|unique:user,username',
        'password' => 'required|string|min:6',
        ]);

    \App\Models\User::create([
        'first_Name' => $request->name,
        'last_Name' => $request->surname,
        'birthday' => $request->birthday,
        'sex' => $request->sex,
        'email' => $request->email,
        'username' => $request->username,
        'password' => Hash::make($request->password),
        'pfp' => $request->profile_image,
    ]);

    return redirect('/login')->with('success', 'Registrazione completata! Ora effettua il login.');
    }

}
