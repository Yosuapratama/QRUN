<?php

namespace App\Http\Controllers;

use App\Models\Advertise;
use App\Models\LogActivities;
use App\Models\Place;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class AdvertiseController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Advertise::latest()->get();

            return DataTables::of($data)
                ->editColumn('updated_at', function ($row) {
                    return \Carbon\Carbon::parse($row->updated_at)->format('d-M-Y H:i:s');
                })
                ->editColumn('image_url', function ($row) {
                    return "<img src='" . asset($row->image_url) . "' width='100px'>";
                })
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = route('advertise.edit', $row->id);

                    $btn = "<div class='d-flex'>";
                    $btn = $btn . "<a href='$editUrl' class='btn btn-secondary btn-sm mr-1'>Edit</a>";
                    $btn = $btn . "<button id='$row->id' class='delete btn btn-danger btn-sm mr-1'>Delete</button>";
                    $btn = $btn . "</div>";
                    return $btn;
                })
                ->rawColumns(['action', 'image_url'])
                ->make(true);
        }

        return view('Pages.Management.Master.advertise.index');
    }

    public function create()
    {
        // $placeId = Place::select('id', 'place_code', 'title', 'creator_id')->with('creator_id')->get();

        $placeId = Place::select('id', 'place_code', 'title', 'creator_id')
            ->doesntHave('advertises') // Filters places with no related 'advertises'
            ->with('creator_id') // Assuming 'creator' is a relationship on the Place model
            ->get();
        $adsSettings = null;

        return view('Pages.Management.Master.advertise.form', compact('placeId', 'adsSettings'));
    }

    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'places' => 'required',
            'time' => 'required',
            'image_url' => 'required',
        ]);

        if ($request->id) {
            $ad = Advertise::findOrFail($request->id);  // Find the existing Advertise record or fail if not found
            if (!$ad) {
                return redirect()->route('advertise.index')->withErrors('Advertise data not found !');
            }

            LogActivities::create([
                'ip_address' => request()->ip(),
                'user_agent' => request()->header('User-Agent'),
                'user_id' => Auth::user()->id,
                'activities' => "User update data with advertise id = " . $request->id . " at " . Carbon::now()->format('Y-m-d H:i:s'),
                "type" => LogActivities::TYPE_UPDATE_ADVERTISE
            ]);
        } else {
            $ad = new Advertise;  // Create a new Advertise instance if no ID is provided

            LogActivities::create([
                'ip_address' => request()->ip(),
                'user_agent' => request()->header('User-Agent'),
                'user_id' => Auth::user()->id,
                'activities' => "User create data with advertise id = " . $ad->id . " at " . Carbon::now()->format('Y-m-d H:i:s'),
                "type" => LogActivities::TYPE_CREATE_ADVERTISE
            ]);
        }

        $ad->title = $request->title;
        $ad->is_active = $request->is_active == "on" ? 1 : 0;
        $ad->time = $request->time;
        $ad->image_url = $request->image_url;
        $ad->save();

        $ad->places()->sync($request->input('places'));

        return back()->with('success', 'Advertise saved successfully !');
    }

    public function edit(string $id)
    {
        // $placeId = Place::select('id', 'place_code', 'title', 'creator_id')->with('creator_id')->get();

        $placeId = Place::select('id', 'place_code', 'title', 'creator_id')
            ->where(function ($query) use ($id) {
                $query->doesntHave('advertises') // No related 'advertises'
                    ->orWhereHas('advertises', function ($subQuery) use ($id) {
                        $subQuery->where('advertise_tables.id', $id); // Fully qualify the 'id' from 'advertise_tables'
                    });
            })
            ->with('creator_id') // Assuming 'creator' is a relationship on the Place model
            ->get();

        $adsSettings = Advertise::where('id', $id)->first();
        if (!$adsSettings) {
            return redirect()->route('advertise.index')->withErrors('Advertise data not found !');
        }

        return view('Pages.Management.Master.advertise.form', compact('placeId', 'adsSettings'));
    }

    public function destroy(string $id)
    {
        $advertise = Advertise::findOrFail($id);

        $advertise->places()->detach();

        $advertise->delete();

        LogActivities::create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'user_id' => Auth::user()->id,
            'activities' => "User delete data with advertise id = " . $advertise->id . " at " . Carbon::now()->format('Y-m-d H:i:s'),
            "type" => LogActivities::TYPE_DELETE_ADVERTISE
        ]);

        return response()->json([
            'success' => 'Data deleted successfully !'
        ]);

        // return redirect()->route('advertise.index')->with('success', 'Advertise deleted successfully!');
    }
}
