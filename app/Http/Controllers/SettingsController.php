<?php

namespace App\Http\Controllers;

use App\Models\AdsSettingImage;
use App\Models\CustomAdsSettings;
use App\Models\CustomRunningTextSettings;
use App\Models\LogActivities;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SettingsController extends Controller
{
    function generalIndex()
    {
        $runningText = CustomRunningTextSettings::first();
        $adsSettings = CustomAdsSettings::first();

        return view('Pages.Management.Master.settings.general', compact('runningText', 'adsSettings'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            if (isset($request->deleted_images)) {
                foreach ($request->deleted_images as $id) {
                    $image = AdsSettingImage::find($id);
                    if ($image) {
                        $image->delete();
                    }
                }
            }

            // =========================
            // RUNNING TEXT
            // =========================
            $customRunningTextData = CustomRunningTextSettings::first();

            $customRunningTextData->update([
                "is_active" => $request->has('is_active_running_text') ? 1 : 0,
                "title" => $request->title_running_text,
                "background_color" => $request->background_color,
                "text_color" => $request->text_color,
                "font_size" => $request->font_size,
                "disabled_after" => $request->disabled_after
            ]);

            // =========================
            // ADS SETTINGS
            // =========================
            $customAdsData = CustomAdsSettings::first();

            $customAdsData->update([
                "is_active" => $request->has('ads_active') ? 1 : 0,
                'merge_with_advertise_users' => $request->has('merge_with_advertise_users') ? 1 : 0,
                'is_blocking' => $request->has('is_blocking') ? 1 : 0,
                "title" => $request->title_ads,
                "time" => $request->time_ads
            ]);

            // =========================
            // IMAGE UPLOAD HANDLING
            // =========================
            if ($request->hasFile('images')) {

                foreach ($request->file('images') as $file) {

                    $path = $file->store('ads', 'public');

                    $customAdsData->images()->create([
                        'image_url' => $path
                    ]);
                }
            }

            // =========================
            // LOG ACTIVITY
            // =========================
            LogActivities::create([
                'ip_address' => request()->ip(),
                'user_agent' => request()->header('User-Agent'),
                'user_id' => Auth::id(),
                'activities' => "User Updated General Settings at " . Carbon::now(),
                "type" => LogActivities::TYPE_UPDATE_SETTINGS
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Data Successfully Saved!');
        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Settings Store Failed: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Failed to save settings!');
        }
    }
}
