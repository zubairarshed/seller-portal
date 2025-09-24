<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function create()
    {
        return view('login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials))
        {
            $user = Auth::user();

            if ($user->role !== $request->role)
            {
                Auth::logout();
                return back()->withErrors(['email' => 'You are not authorized as ' . $request->role]);
            }
            return redirect()->route($request->role.'.dashboard')->with('message', 'Welcome,' . $request->role);
        }
        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function destroy()
    {
        Auth::logout();
        return redirect('/')->with('message', 'Logged out successfully.');
    }
}
