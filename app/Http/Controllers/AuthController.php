<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Detail Of Auth Controller
    |--------------------------------------------------------------------------
    |
    | This Controllers Contains :
    | -> For User To Login/Register Account
    | 1. /login, Func Name : viewLogin, Route Name : login
    | 2. /login/store, Func Name : store, Route Name : login.store
    | 3. /register, Func Name : viewRegister, Route Name : register
    | 4. /register/store, Func Name : storeRegister, Route Name : register.store
    | 5. /logout, Func Name : logout, Route Name : logout
    | 6. Redirect Function , Func Name : redirectToLogin
    |
    */

    // (1) Login View For Users
    function ViewLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard')->withErrors('You Already Logged in !');
        }
        return view('Pages.Login');
    }

    // (2) Store Login & Check The User login is true/false
    function store(Request $request)
    {
        $Validate = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ], [
            'email.required' => 'Email is required',
            'password.required' => 'Password is required'
        ]);


        if (Auth::attempt($request->only(['email', 'password']))) {
            return redirect()->route('dashboard')->with('success', 'Login Success !');
        }

        return redirect()->route('login')->withErrors('Login Failed Email or Password Are Incorrect !');
    }

    // (3) Register View For Users
    function ViewRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard')->withErrors('You Already Logged in !');
        }
        return view('Pages.Register');
    }

    // (4) Store Register & Auto attempt/login to dashboard admin
    function storeRegister(Request $request)
    {
        $Validate = $request->validate([
            'name' => 'required|min:6',
            'phone' => 'required|numeric',
            'address' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'password2' => 'required|same:password|min:8'
        ], [
            'name.required' => 'Name is required',
            'name.min' => 'Name length must be more than 6 characters',
            'phone.required' => 'Phone Number is required',
            'phone.numeric' => 'Phone number must be of type number',
            'address.required' => 'Address is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email must be a valid mail !',
            'email.unique' => 'This email is already registered',
            'password.required' => 'Password is required',
            'password.min' => 'Password length must be more than 8 characters',
            'password2.required' => 'Confirm Password Required',
            'password2.same' => 'Confirm Password is wrong !'
        ]);

        if(!$request->has('agreedTOS')){
            return back()->withErrors('You Must Agreed Terms of service this application !');
        }
        $user = User::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => '+62' . $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $user->assignRole('localadmin');

        if (Auth::attempt($request->only(['email', 'password']))) {
            return redirect()->route('dashboard')->with('success', 'Register Success !');
        }
    }
    // (5) Logout function for all users
    function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/auth/login');
    }

    // (6) Redirect Login Function
    function redirectToLogin()
    {
        return redirect()->route('login');
    }
}
