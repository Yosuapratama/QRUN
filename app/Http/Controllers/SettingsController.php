<?php

namespace App\Http\Controllers;

use App\Models\CustomAdsSettings;
use App\Models\CustomRunningTextSettings;
use Illuminate\Http\Request;

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

        $customAdsData->update([
            "is_active" => $request->ads_active == "on" ? 1 : 0,
            "title" => $request->title_ads,
            'time' => $request->time_ads
        ]);

        return back()->with('success', 'Data SuccesFully Saved !');
    }
}
