<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed
            return redirect()->intended('/dashboard');
        } else {
            // Authentication failed
            return redirect()->route('login')->with('error', 'Invalid credentials');
        }
    }

    public function showRegister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        // Validate the input
        // $request->validate([
        //     "username" => "required|unique:users",
        //     "password" => "required|min:5|max:255",
        // ]);

        // dd($request);

        // Create a new user
        User::create([
            'username' => $request->input('username'),
            'role'=> $request->input('role'),
            'password' => bcrypt($request->input('password')),
            'remember_token' => Str::random(10),
        ]);

        // Redirect to the login page with a success message
        return redirect('/login')->with('success', 'Register Berhasil');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('logoutSuccess', 'Berhasil log out!');
    }
}
