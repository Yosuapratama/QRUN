<?php

namespace App\Http\Middleware;

use App\Models\UserHasPlaceLimit;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class checkUserLimitPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check()){
            if(!Auth::user()->hasRole('superadmin')){
                if(!Auth::user()->approved_at) {
                    return redirect()->route('dashboard')->withErrors('Your Account Need Approval First !');
                }

                $checkTheLimitOfUserPlace = UserHasPlaceLimit::where('user_id', Auth::user()->id)->with('placeLimit')->first();
                if($checkTheLimitOfUserPlace){
                    if($checkTheLimitOfUserPlace->placeLimit->total_limit > 1){
                        return $next($request);
                    }else{
                        return abort(403);
                    }
                }else{
                    return abort(403);
                }

            }

            return $next($request);
        }else{
            return redirect()->route('login')->withErrors('You Must Login First');
        }
        

    }
}
