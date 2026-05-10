<?php

namespace App\Http\Controllers;

use App\Mail\NewUserRegistered;
use App\Models\LogActivities;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use Symfony\Component\HttpClient\Exception\ClientException;

class AuthGoogleController extends Controller
{
    function authGoogle()
    {
        // return Socialite::driver('google')->redirect();
        return Socialite::driver('google')
            ->stateless()
            ->redirect();

    }

    function googleCallback()
    {
        try {

            $googleUser = Socialite::driver('google')->stateless()->user();
    
            // Find or create a user in your database
            // $user = User::withTrashed()->updateOrCreate(
            //     ['google_id' => $googleUser->getId()], // Match by Google ID
            //     [
            //         'email' => $googleUser->getEmail(),
            //         'name' => $googleUser->getName(),
            //         'email_verified_at' => Date::now()
            //     ]
            // );
    
            [$user, $created] = User::withTrashed()->firstOrNew([
                'google_id' => $googleUser->getId(),
            ])->fill([
                'email' => $googleUser->getEmail(),
                'name' => $googleUser->getName(),
                'email_verified_at' => now(),
            ])->saveWithCheck();
    
    
            if ($user->trashed()) {
                // User is in the trash (soft-deleted), return an error response
                return redirect()->route('login')->withErrors('Your account has disabled by administrator');
            }
    
            // Kirim email hanya jika user baru
            if ($created) {
                //Mail::to(config('mail.to.address'))->send(new NewUserRegistered($user));
                Mail::to(env('MAIL_TO_ADDRESS', 'qrunonline@gmail.com'))->send(new NewUserRegistered($user));
            }
    
    
            Auth::login($user, true);

            LogActivities::create([
                'ip_address' => request()->ip(),
                'user_agent' => request()->header('User-Agent'),
                'user_id' => Auth::user()->id,
                'activities' => "User Login By Google at " . Carbon::now()->format('Y-m-d H:i:s'),
                "type" => LogActivities::TYPE_LOGIN_GOOGLE
            ]);

            if (session()->has('redirect_back')) {
                $redirectUrl = session('redirect_back');
                session()->forget('redirect_back');
                if (parse_url($redirectUrl, PHP_URL_HOST) === request()->getHost()) {
                    return redirect($redirectUrl);
                }
            }

            return redirect()->route('dashboard'); // redirect after login
        }catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'google' => 'Login Google gagal. Coba lagi.'
            ]);
        }
    }
}
