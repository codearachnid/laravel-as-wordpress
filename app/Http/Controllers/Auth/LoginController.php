<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::where('user_email', $credentials['email'])->first();

        if ($user) {
            if ($user->passwordNeedsRehash($credentials['password'])) {
                $user->updatePasswordToBcrypt($credentials['password']);
                Auth::login($user);
                return redirect()->intended('/dashboard');
            }

            if (Auth::attempt(['user_email' => $credentials['email'], 'password' => $credentials['password']])) {
                return redirect()->intended('/dashboard');
            }
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }
}