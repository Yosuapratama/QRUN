<?php

namespace App\Http\Controllers;

use App\Models\Advertise;
use App\Models\LogActivities;
use App\Models\Place;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
                ->addColumn('places', function ($row) {

                    if ($row->places->isEmpty()) {

                        return "
                <span class='badge badge-light px-3 py-2'>
                    No Place
                </span>
            ";
                    }

                    $html = "<div class='d-flex flex-wrap' style='gap:6px;'>";

                    foreach ($row->places as $place) {

                        $html .= "
                <span 
                    class='badge badge-primary'
                    style='
                        font-size: 11px;
                        padding: 7px 10px;
                        border-radius: 30px;
                        font-weight: 500;
                    '
                >
                    {$place->title}
                </span>
            ";
                    }

                    $html .= "</div>";

                    return $html;
                })

                ->editColumn('image_url', function ($row) {
                    return "<img src='" . asset($row->image_url) . "' width='100px'>";
                })
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $editUrl = route('advertise.edit', $row->id);

                    return "
        <div class='dropdown'>

            <button 
                class='btn btn-primary btn-sm dropdown-toggle shadow-sm'
                type='button'
                data-toggle='dropdown'
                aria-expanded='false'
            >
                <i class='fas fa-cog mr-1'></i>
                Action
            </button>

            <div class='dropdown-menu dropdown-menu-right shadow animated--fade-in'>

                <a 
                    href='{$editUrl}'
                    class='dropdown-item'
                >
                    <i class='fas fa-edit text-secondary mr-2'></i>
                    Edit
                </a>

                <div class='dropdown-divider'></div>

                <button 
                    id='{$row->id}'
                    class='delete dropdown-item text-danger'
                    type='button'
                >
                    <i class='fas fa-trash-alt mr-2'></i>
                    Delete
                </button>

            </div>

        </div>
    ";
                })
                ->rawColumns(['action', 'image_url', 'places'])
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
            'time' => 'required|numeric',
            'places' => 'required|array',
            'images' => $request->id
                ? 'nullable|array|min:1'
                : 'required|array|min:1',
        ]);


        DB::transaction(function () use ($request) {

            $advertise = Advertise::updateOrCreate(
                [
                    'id' => $request->id
                ],
                [
                    'title' => $request->title,
                    'time' => $request->time,
                    'is_active' => $request->is_active ? 1 : 0,
                    'is_block' => $request->is_block ? 1 : 0,
                ]
            );

            $advertise->places()->sync($request->places);

            // reset images
            $advertise->images()->delete();

            if ($request->images) {

                foreach ($request->images as $key => $image) {

                    $advertise->images()->create([
                        'image_url' => $image,
                        'sort_order' => $key
                    ]);
                }
            }
        });

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
