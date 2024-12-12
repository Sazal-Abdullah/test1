<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate login form inputs
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Check if the email exists in the database
        $user = User::where('email', $request->email)->first();

        // Validate user credentials
        if ($user && Hash::check($request->password, $user->password)) {
            if ($user->email === 'admin@gmail.com') { // Ensure it's the seeded admin account
                Auth::login($user);
                return redirect()->route('admin.dashboard'); // Redirect to admin dashboard
            }

            return back()->withErrors(['email' => 'Only admin can log in.']);
        }

        return back()->withErrors(['email' => 'Invalid email or password.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
