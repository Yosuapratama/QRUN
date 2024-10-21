<?php

namespace App\Http\Controllers;

use App\Models\PlaceLimit;
use App\Models\UserHasPlaceLimit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PlaceLimitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = PlaceLimit::select('id', 'name', 'total_limit')->latest()->get();

            return DataTables::of($data)
                ->editColumn('updated_at', function ($row) {
                    return \Carbon\Carbon::parse($row->updated_at)->format('d-M-Y H:i:s');
                })
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = route('place-limit.edit', $row->id);

                    $btn = "<div class='d-flex'>";
                    $btn = $btn . "<a href='$editUrl' class='btn btn-secondary btn-sm mr-1'>Edit</a>";
                    $btn = $btn . "<button id='$row->id' class='delete btn btn-danger btn-sm mr-1'>Delete</button>";
                    $btn = $btn . "</div>";
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Pages.Management.Master.place-limit.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Pages.Management.Master.place-limit.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->approved_at) {
            return back()->withErrors('Your Account Need Approval First !');
        }
        // dd($request);

        $Validate = $request->validate([
            'name' => 'required',
            'total_limit' => 'required|numeric|min:1'
        ], [
            'name.required' => 'Name Fields is required',
            'total_limit.required' => 'Total of limit is required',
            'total_limit.numeric' => 'Total of limit type must be of number',
            'total_limit.min' => 'Total of limit need minimum 1 total',
            
        ]);

        PlaceLimit::create([
            'name' => $request->name,
            'total_limit' => $request->total_limit
        ]);

        return redirect()->route('place-limit.index')->with('success','Place limit successfully created !');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = PlaceLimit::find($id);
        return view('Pages.Management.Master.place-limit.form', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $Validate = $request->validate([
            'name' => 'required',
            'total_limit' => 'required|numeric|min:1'
        ], [
            'name.required' => 'Name Fields is required',
            'total_limit.required' => 'Total of limit is required',
            'total_limit.numeric' => 'Total of limit type must be of number',
            'total_limit.min' => 'Total of limit need minimum 1 total',
            
        ]);

        $placeLimit = PlaceLimit::find($id);
        if(!$placeLimit){
            return back()->withErrors('Place Limit not found !');
        }

        $placeLimit->update([
            'name' => $request->name,
            'total_limit' => $request->total_limit,
        ]);

        return redirect()->route('place-limit.index')->with('success', 'Place Limit updated successfully !');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $placeLimit = PlaceLimit::find($id);
        if(!$placeLimit){
            return abort(404);
        }

        $placeLimit->delete();
        $userHasPlaceLimit = UserHasPlaceLimit::where('place_limit_id', $id)->get();
        foreach($userHasPlaceLimit as $key => $item){
            $userHasPlaceLimit[$key]->delete();
        }

        return response()->json([
            'success' => 'Data deleted successfully !'
        ]);
    }
}
