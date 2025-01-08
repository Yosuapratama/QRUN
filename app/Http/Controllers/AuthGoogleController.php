<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Laravel\Socialite\Facades\Socialite;

class AuthGoogleController extends Controller
{
    function authGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    function googleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        // Find or create a user in your database
        $user = User::withTrashed()->updateOrCreate(
            ['google_id' => $googleUser->getId()], // Match by Google ID
            [
                'email' => $googleUser->getEmail(),
                'name' => $googleUser->getName(),
                'email_verified_at' => Date::now()
            ]
        );
        
        if ($user->trashed()) {
            // User is in the trash (soft-deleted), return an error response
            return redirect()->route('login')->withErrors('Your account has disabled by administrator');
        }
      
        Auth::login($user, true);

        return redirect()->route('dashboard'); // redirect after login
    }
}
