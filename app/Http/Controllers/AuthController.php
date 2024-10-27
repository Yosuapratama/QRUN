<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;

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
            if(!Auth::user()->email_verified_at){
                $this->logout($request);
                return redirect()->route('login')->withErrors('Your Account Must be verified first, Check Your Email !');
            }
            Log::info([
                'status' => 'User Logged in',
                'time' => Date::now(),
                'user_id' => Auth::user()->id,
                'email' => Auth::user()->email,
                'ip_address' => request()->ip()
            ]);

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
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(40)
        ]);

        Log::info([
            'status' => 'User Register',
            'time' => Date::now(),
            'user_id' => $user->id,
            'email' => $user->email,
            'ip_address' => request()->ip()
        ]);

        $user->assignRole('localadmin');

        // Mail::to($user->email)->send(new RegisterMail($user));
        event(new Registered($user));

        return redirect()->route('login')->with('success', 'Register Success, Check Your Email for verification !');
    }
    // (5) Logout function for all users
    public function logout(Request $request)
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

    public function resendMailVerification(Request $request){
        $request->user()->sendEmailVerificationNotification();
 
        return back()->with('success', 'Verification link sent!');
    }

    public function verifyMail(EmailVerificationRequest $request){
        $request->fulfill();
        return redirect()->route('dashboard')->with('success', 'Your email has been verified');
    }
    public function forgotPassword(){
        return view('Pages.auth.ForgotPassword');
    }
    public function submitForgotPassword(Request $request){
        $request->validate([
            'email' => 'required|email'
        ]);

        $isValidUser = User::where('email', $request->email)->first();
        if(!$isValidUser){
            return back()->withErrors('Email not found !');
        }
 
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_THROTTLED) {
            return back()->withErrors([
                'throttled' => "Too many attempts. Please try again in a few minutes."
            ]);
        }

        if ($status == Password::RESET_LINK_SENT) {
            return back()->with('status', __('We have emailed your password reset link!'));
        }
     
        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    public function resetPassView(){
        if(Auth::check()){
            Auth::logout();
        }
        return view('Pages.auth.ResetPassword');
    }

    public function updatePassword(Request $request){
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ], [
            'token.required' => 'Token is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email must be valid address !',
            'password.required' => 'Password is required',
            'password.min' => 'Password minimum 8 characters',
            'password.confirmed' => 'Confirm Password is required'
        ]);
     
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));
     
                $user->save();
     
                event(new PasswordReset($user));
            }
        );

        if($status == Password::INVALID_TOKEN){
            return back()->withErrors('Token is invalid !');
        }
     
        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', 'Your password has been reset!')
                    : back()->withErrors(['email' => trans($status)]);
    }
}
