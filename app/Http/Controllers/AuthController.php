<?php

namespace App\Http\Controllers;

use App\Mail\NewUserRegistered;
use App\Models\Blog;
use App\Models\Ebook;
use App\Models\EbookPlace;
use App\Models\LogActivities;
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
use App\Models\Place;
use App\Support\EbookGate;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
        if (request()->has('redirect_back') && !session()->has('redirect_back')) {
            session(['redirect_back' => url()->previous()]);
        }
        return view('Pages.Login');
    }

    // (2) Store Login & Check The User login is true/false
    function store(Request $request)
    {
        $Validate = $request->validate([
            'email' => 'required',
            'password' => 'required',
            'remember' => 'nullable'
        ], [
            'email.required' => 'Email is required',
            'password.required' => 'Password is required'
        ]);

        $remember = $request->remember === 'on' ? true : false;

        if (Auth::attempt($request->only(['email', 'password']), $remember)) {
            if (!Auth::user()->email_verified_at) {
                $this->logout($request);
                return redirect()->route('login')->withErrors('Your Account Must be verified first, Check Your Email !');
            }

            LogActivities::create([
                'ip_address' => request()->ip(),
                'user_agent' => request()->header('User-Agent'),
                'user_id' => Auth::user()->id,
                'activities' => "User Login at " . Carbon::now()->format('Y-m-d H:i:s'),
                "type" => LogActivities::TYPE_LOGIN
            ]);

            if (session()->has('redirect_back')) {
                $redirectUrl = session('redirect_back');
                session()->forget('redirect_back');
                if (parse_url($redirectUrl, PHP_URL_HOST) === request()->getHost()) {
                    return redirect($redirectUrl)->with('success', 'Login Success !');
                }
            }

            return redirect()->route('dashboard')->with('success', 'Login Success !');
        }

        return back()->withErrors('Login Failed Email or Password Are Incorrect !')->withInput();;
    }

    // (3) Register View For Users
    function ViewRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard')->withErrors('You Already Logged in !');
        }
        return view('Pages.Register');
    }

    public function search(Request $request)
    {
        $query = $request->get('query');

        $blogs = Blog::select(
            'id',
            'slug',
            'title',
            'description',
            'image_url',
            'views',
            'is_published',
            'created_at'
        )
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            })
            ->where('is_published', true)
            ->orderByDesc('created_at')
            ->limit(6)
            ->get();

        return response()->json([
            'blogs' => $blogs,
            'html' => view('partials.blog-cards', compact('blogs'))->render()
        ]);
    }

    public function loadMore(Request $request)
    {
        $page = $request->get('page', 1);
        $blogs = Blog::select('id', 'slug', 'title', 'description', 'image_url', 'views', 'is_published', 'created_at')
            ->where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->skip(($page - 1) * 6)
            ->take(6)
            ->get();

        return response()->json([
            'blogs' => $blogs,
            'hasMore' => $blogs->count() == 6,
            'html' => view('partials.blog-cards', compact('blogs'))->render()
        ]);
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
            'password2.min' => 'Confirm Password length must be more than 8 characters',
            'password2.required' => 'Confirm Password Required',
            'password2.same' => 'Confirm Password is wrong !'
        ]);

        if (!$request->has('agreedTOS')) {
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

        LogActivities::create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'user_id' => $user->id,
            'activities' => "User Register at " . Carbon::now()->format('Y-m-d H:i:s'),
            "type" => LogActivities::TYPE_REGISTER
        ]);

        $user->assignRole('localadmin');

        //Mail::to(config('mail.to.address'))->send(new NewUserRegistered($user));
        // Mail::to(env('MAIL_TO_ADDRESS', 'qrunonline@gmail.com'))->send(new NewUserRegistered($user));
        event(new Registered($user));

        return redirect()->route('login')->with('success', 'Register Success, Check Your Email for verification !');
    }
    // (5) Logout function for all users
    public function logout(Request $request)
    {

        LogActivities::create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'user_id' => Auth::user()->id,
            'activities' => "User Logout at " . Carbon::now()->format('Y-m-d H:i:s'),
            "type" => LogActivities::TYPE_LOGOUT
        ]);

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/auth/login');
    }

    // (6) Redirect Login Function

    function redirectToLogin(Request $request)
    {
        $query = $request->input('search');
        if ($query) {
            $data = Place::when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder->where('title', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%");
            })->paginate(10);
        } else {
            $data = Place::orderBy('views', 'DESC')->paginate(5);
        }

        return view('Pages.Index', [
            'data' => $data,
            'blogs' => Blog::where('is_published', 1)->select('id', 'slug', 'title', 'description', 'image_url', 'views', 'is_published', 'created_at')->orderByDesc('created_at')->limit(3)->get()
        ]);
    }

    public function detailBlog($slug)
    {
        $blog = Blog::where('slug', $slug)->first();

        if (!$blog) {
            abort(404);
        }

        // Check if user has viewed this blog in the last 24 hours
        $cookieName = 'blog_view_' . $blog->id;
        if (!request()->cookie($cookieName)) {
            // Increment view count
            $blog->increment('views');

            // Set cookie that expires in 24 hours
            cookie()->queue($cookieName, true, 60 * 24); // 24 hours in minutes
        }

        return view('Pages.BlogDetail', [
            'data' => $blog,
            'blogs' => Blog::where('is_published', 1)
                ->whereNot('slug', $slug)
                ->select('id', 'slug', 'title', 'description', 'image_url', 'views', 'is_published', 'created_at')
                ->orderByDesc('created_at')
                ->limit(4)
                ->get()
        ]);
    }

    public function contactPage()
    {
        return view('Pages.Contact');
    }

    public function blogPage()
    {
        return view('Pages.Blog', [
            'popularBlogs' => Blog::where('is_published', 1)->select('id', 'slug', 'title', 'description', 'image_url', 'views', 'is_published', 'created_at')->orderByDesc('created_at')->orderByDesc('views')->limit(6)->get(),
            'blogs' => Blog::where('is_published', 1)->select('id', 'slug', 'title', 'description', 'image_url', 'views', 'is_published', 'created_at')->orderByDesc('created_at')->limit(6)->get()
        ]);
    }

    public function ebookPage()
    {
        // The global ebook catalog is not public — ebooks are accessed via a
        // location's QR scan page only. Hide this listing.
        abort(404);
    }

    public function detailEbook($slug)
    {
        $ebook = Ebook::where('slug', $slug)->where('is_published', 1)->first();

        if (!$ebook) {
            abort(404);
        }

        // Count one view per visitor per 24 hours (cookie-based), same as blog
        $cookieName = 'ebook_view_' . $ebook->id;
        if (!request()->cookie($cookieName)) {
            $ebook->increment('views');
            cookie()->queue($cookieName, true, 60 * 24);
        }

        // "Ebook lainnya" must reflect the location the visitor came from (?ref=CODE),
        // not a universal list. Without a valid ref, show nothing.
        $ref = request('ref');
        $related = collect();

        // Read-gating state. The free-read counter lives in the server session
        // (see App\Support\EbookGate), so it cannot be tampered with client-side.
        $locked = false;
        $gate = null;
        $unlockAds = collect();
        $reviewQuestions = collect();

        if ($ref) {
            $place = EbookPlace::where('code', $ref)->first();
            if ($place) {
                $related = $place->ebooks()
                    ->where('is_published', 1)
                    ->where('ebooks.slug', '!=', $slug)
                    ->orderByDesc('ebooks.created_at')
                    ->limit(6)
                    ->get(['ebooks.id', 'ebooks.slug', 'ebooks.title', 'ebooks.description', 'ebooks.author', 'ebooks.category', 'ebooks.image_url', 'ebooks.views', 'ebooks.created_at']);

                // Only gate ebooks that actually belong to this location.
                $belongs = $place->ebooks()->where('ebooks.slug', $slug)->exists();
                if ($belongs) {
                    $config = EbookGate::effectiveConfig($place, $ebook);

                    if ($config['lock_enabled'] && !EbookGate::isOpened($ref, $slug)) {
                        // Try to spend a free read; otherwise the ebook is locked.
                        if (!EbookGate::tryConsumeFreeRead($ref, $slug, $config['read_limit'])) {
                            $locked = true;
                            $gate = $config + ['code' => $ref, 'slug' => $slug];

                            $methods = $config['unlock_method'] === 'both'
                                ? ['timed', 'review']
                                : [$config['unlock_method']];

                            $unlockAds = collect();

                            // Per-ebook unlock creatives take priority when overriding.
                            if ($ebook->ad_override_enabled) {
                                if (in_array('timed', $methods, true) && $ebook->unlock_timed_image) {
                                    $unlockAds->push((object) [
                                        'type' => 'timed',
                                        'title' => null,
                                        'image_url' => $ebook->unlock_timed_image,
                                        'duration_seconds' => $ebook->unlock_duration,
                                        'target_url' => $ebook->unlock_timed_target_url,
                                    ]);
                                }
                                if (in_array('review', $methods, true) && $ebook->unlock_review_image) {
                                    $unlockAds->push((object) [
                                        'type' => 'review',
                                        'title' => null,
                                        'image_url' => $ebook->unlock_review_image,
                                    ]);
                                }
                            }

                            // Fall back to the location's ads for any method not
                            // covered by the ebook's own creatives.
                            $needed = array_values(array_diff($methods, $unlockAds->pluck('type')->all()));
                            if (!empty($needed)) {
                                $placeAds = $place->ads()
                                    ->where('is_active', 1)
                                    ->whereIn('type', $needed)
                                    ->get();
                                $unlockAds = $unlockAds->concat($placeAds);
                            }

                            if (in_array('review', $methods, true)) {
                                $reviewQuestions = ($ebook->ad_override_enabled && $ebook->reviewQuestions()->exists())
                                    ? $ebook->reviewQuestions()->get()
                                    : $place->reviewQuestions()->get();
                            }
                        }
                    }
                }
            }
        }

        return view('Pages.EbookDetail', [
            'data' => $ebook,
            'ebooks' => $related,
            'locked' => $locked,
            'gate' => $gate,
            'unlockAds' => $unlockAds,
            'reviewQuestions' => $reviewQuestions,
        ]);
    }

    public function resendMailVerification(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'Verification link sent!');
    }

    public function verifyMail(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return redirect()->route('dashboard')->with('success', 'Your email has been verified');
    }
    public function forgotPassword()
    {
        return view('Pages.auth.ForgotPassword');
    }
    public function submitForgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $isValidUser = User::where('email', $request->email)->first();
        if (!$isValidUser) {
            return back()->withErrors('Email not found !');
        }

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status == Password::RESET_THROTTLED) {
            $seconds = config('auth.passwords.users.throttle');

            return back()->withErrors([
                'email' => "Please wait {$seconds} seconds before requesting another reset link."
            ]);
        }

        if ($status == Password::RESET_LINK_SENT) {
            return back()->with('status', __('We have emailed your password reset link!'));
        }

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    private function validateResetToken(
        string $email,
        string $token
    ): bool {

        $record = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if (!$record) {
            return false;
        }

        if (!Hash::check($token, $record->token)) {
            return false;
        }

        $expires = config('auth.passwords.users.expire');

        if (
            now()->diffInMinutes($record->created_at) >
            $expires
        ) {
            return false;
        }

        return true;
    }

    public function resetPassView(Request $request, string $token)
    {
        $email = $request->email;

        if (!$this->validateResetToken($email, $token)) {
            return redirect()
                ->route('password.request')
                ->withErrors([
                    'email' => 'This reset password link is invalid or has expired.'
                ]);
        }

        return view('Pages.auth.ResetPassword', compact(
            'token',
            'email'
        ));
    }

    public function updatePassword(Request $request)
    {
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

        if ($status == Password::INVALID_TOKEN) {
            return back()->withErrors('Token is invalid !');
        }

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Your password has been reset!')
            : back()->withErrors(['email' => trans($status)]);
    }
}
