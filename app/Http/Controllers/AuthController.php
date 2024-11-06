<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        $page_title = 'login';
        return view('auth.login', compact('page_title'));
    }
    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required|string|exists:users,username',
            'password' => 'required|min:6'
        ]);
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            return redirect()->intended(route('l.list'));
        } else {
            return back()->with('error', 'Invalid login credentials');
        }
    }
    public function logout(Request $request)
    {
        $request->session()->flush();
        $request->session()->regenerate();
        Auth::logout();
        return redirect()->route('login');
    }
}
