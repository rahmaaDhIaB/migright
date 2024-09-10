<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function login()
    {
        return view('authentication.admin.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]) ;
        $credentials = $request->only('email', 'password');
        $user = User::where('email',$credentials['email'])->first();

        if ($user && (Hash::check($credentials['password'], $user->password))) {
            Auth::login($user);
            return redirect()->route('home');
        }

        return redirect()->back()->withErrors(['email' => __('invalid_credentials')]);
    }

    public function logout()
    {
        auth()->guard('web')->logout();
        return redirect()->route('login');
    }

    public function register()
    {
        return view('authentication.admin.register');
    }

    public function performRegister(Request $request)
    {

    }
}
