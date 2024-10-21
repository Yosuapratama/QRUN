<?php

namespace App\Http\Controllers;

use App\Models\PlaceLimit;
use App\Models\User;
use App\Models\UserHasPlaceLimit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UsersHasLimitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($data[0]);
        
        if ($request->ajax()) {
            $data = UserHasPlaceLimit::with('placeLimit', 'user')->get();
            
            return DataTables::of($data)
                ->editColumn('updated_at', function ($row) {
                    return \Carbon\Carbon::parse($row->updated_at)->format('d-M-Y H:i:s');
                })
                ->addIndexColumn()
                ->addColumn('place_name', function ($row) {
                    return $row->placeLimit->name;
                })
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = route('place-limit.edit', $row->id);

                    $btn = "<div class='d-flex'>";
                    $btn = $btn . "<a href='$row->id' class='edit btn btn-secondary btn-sm mr-1'>Edit</a>";
                    $btn = $btn . "<button id='$row->id' class='delete btn btn-danger btn-sm mr-1'>Delete</button>";
                    $btn = $btn . "</div>";
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Pages.Management.Master.manageUsers.users-limit.index');
    }

    public function getUserHasLimit(Request $request){
        if(Auth::user()->hasRole('superadmin')){
            return response()->json([
                'users' => User::select('email')->get(),
                'place_limit' => PlaceLimit::select('id','name')->get()
            ]);
        }

        return abort(403);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'user' => 'required|exists:users,email',
            'place_limit' => 'required|exists:place_limit,id' // Place limit must be a number between 1 and 100
        ], [
            'user.required' => "User can't be null",
            'user.email' => "User must be a valid email address",
            'user.exists' => "User must exist in the users table",
            'place_limit.required' => "Place Limit can't be null",
            'place_limit.exists' => "Place must exist in the users table"
        ]);

        if($Validator->fails()){
            return response()->json([
                'errors' => 'Invalid fields !'
            ]);
        }

        $checkIsExists = UserHasPlaceLimit::where('user_id', User::where('email', $request->user)->first()->id)->first();
        if($checkIsExists){
            return response()->json([
                'errors' => 'Users already have a place limit !'
            ]);
        }

        UserHasPlaceLimit::create([
            'user_id' => User::where('email', $request->user)->first()->id,
            'place_limit_id' => $request->place_limit
        ]);

        return response()->json([
            'success' => 'Data successfully added !'
        ]);

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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
