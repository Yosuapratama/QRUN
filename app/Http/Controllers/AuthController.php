<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    function ViewLogin(){
        if(Auth::check()){
            return redirect()->route('dashboard')->withErrors('You Already Logged in !');
        }
        return view('Login');
    }
    function ViewRegister(){
        if(Auth::check()){
            return redirect()->route('dashboard')->withErrors('You Already Logged in !');
        }
        return view('Register');
    }
    function redirectToLogin(){
        return redirect()->route('login');
    }
    function store(Request $request){
        $Validate = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt($request->only(['email', 'password']))){
            return redirect()->route('dashboard')->with('success', 'Login Success !');
        }

        return redirect()->route('login')->withErrors('Login Failed Email or Password Are Incorrect !');
        
    }
    function storeRegister(Request $request){
        $Validate = $request->validate([
            'name' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'password2' => 'required|same:password|min:8'
        ], [
            'password2.required' => 'Confirm Password Required'
        ]);


        $user = User::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_approved' => 0,
            'is_deleted' => 0
        ]);

        $user->assignRole('localadmin');

        if(Auth::attempt($request->only(['email', 'password']))){
            return redirect()->route('dashboard')->with('success', 'Register Success !');
        }
    }
    function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
 
        $request->session()->regenerateToken();
     
        return redirect('/auth/login');
    }

   
}
