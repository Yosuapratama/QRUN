<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class IsSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }else{
            App::setLocale('en');
        }

        if(Auth::check()){
            if(Auth::user()->deleted_at){
                return redirect()->route('login')->withErrors('Your Account has disabled By Admin');
            }else{
                if(!Auth::user()->hasRole('superadmin')){
                    return redirect()->route('dashboard')->withErrors('You dont have access here');
                }else{
                    return $next($request);
                }
            }
          
        }else{
            return redirect()->route('login')->withErrors('You Must Login First');
        }
    }
}
