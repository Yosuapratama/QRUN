<?php
namespace App\Helpers;

use App\Models\User;
use App\Models\UserHasPlaceLimit;
use Illuminate\Support\Facades\Auth;

class SidebarHelper
{
    public static function getAmountOfLimitUser(){
        $data = UserHasPlaceLimit::where('user_id', Auth::user()->id)->with('placeLimit')->first()->placeLimit->total_limit ?? 1;

        return $data;
    }

    public static function getPendingUser(){
        return User::whereNotNull('email_verified_at')->whereNull('approved_at')->get()->count();
    }
}