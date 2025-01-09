<?php

namespace App\Http\Controllers;

use App\Models\CustomAdsSettings;
use App\Models\CustomRunningTextSettings;
use App\Models\LogActivities;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    function generalIndex(){
        $runningText = CustomRunningTextSettings::first();
        $adsSettings = CustomAdsSettings::first();

        return view('Pages.Management.Master.settings.general', compact('runningText', 'adsSettings'));
    }
    
    function store(Request $request){
        $customRunningTextData = CustomRunningTextSettings::first();
        // dd($request->is_active_running_text);
        $customRunningTextData->update([
            "is_active" => $request->is_active_running_text == "on" ? 1 : 0,
            "title" => $request->title_running_text,
            "background_color" => $request->background_color,
            "text_color" => $request->text_color,
            "font_size" => $request->font_size,
            "disabled_after" => $request->disabled_after
        ]);

        $customAdsData = CustomAdsSettings::first();

        LogActivities::create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'user_id' => Auth::user()->id,
            'activities' => "User Updated General Settings at ".Carbon::now()->format('Y-m-d H:i:s'),
            "type" => LogActivities::TYPE_UPDATE_SETTINGS
        ]);

        $customAdsData->update([
            "is_active" => $request->ads_active == "on" ? 1 : 0,
            "title" => $request->title_ads,
            'time' => $request->time_ads
        ]);

        return redirect()->back()->with('success', 'Data SuccesFully Saved !');
    }
}
