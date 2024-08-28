<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Place;
use App\Models\Event;

class EventController extends Controller
{
    function index(Request $request){
        if(Auth::user()->is_approved){
            if ($request->ajax()) {
                $place = Place::where('creator_id', Auth::user()->id)->first();
                if($place){
                    $data = Event::where('is_deleted', 0)->where('place_id', $place->id)->latest()->get();
    
                    return Datatables::of($data)
                        ->editColumn('date', function ($row) {
                            return \Carbon\Carbon::parse($row->date )->format('d-M-Y H:i:s').' Wita';
                        })
                        ->addIndexColumn()
                        ->addColumn('action', function ($row) {
                            $btn = "<div class='d-flex justify-content-center'>";
                            $btn = $btn."<button id='$row->id' class='editEventBtn btn btn-warning mr-1'>Edit</button>";
                            $btn = $btn."<button id='$row->id' class='deleteEventButtonNew btn btn-danger'>Delete</button>";
                            $btn = $btn."</div>";
                            return $btn;
                        })
                        ->rawColumns(['action'])
                        ->make(true);
                }else{
                    $data = [];

                    return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function ($row) {
                            $btn = "<div class='d-flex justify-content-center'>";
                          
                            $btn = $btn."</div>";
                            return $btn;
                        })
                        ->rawColumns(['action'])
                        ->make(true);
                }
                
            }
    
            return view('Pages.Event.ManageUserEvent');

        }else{
            return back()->withErrors('You Must Approved By Admin First !');
        }
        

    }
    
    function store(Request $request){
        $Validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'datetime' => 'required'
        ]);

        if($Validator->fails()){
            return response()->json([
                'errors' => 'Invalid Fields !'
            ]);
        }

        $Place = Place::where('creator_id', Auth::user()->id)->first();
        if(!$Place){
            return response()->json([
                'errors' => 'You Must Upload Your Place First !'
            ]);
        }
        Event::create([
            'place_id' => $Place->id,
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->datetime,
            'is_deleted' => 0
        ]);

        return response()->json([
            'success' => 'Event Created Successfully !'
        ]);
    }
    
    // Superadmin menu
    function indexAdmin(Request $request){
        if ($request->ajax()) {
        
            $data = Event::with('place_id')->latest()->get();

            return Datatables::of($data)
                ->editColumn('date', function ($row) {
                    return \Carbon\Carbon::parse($row->date )->format('d-M-Y H:i:s').' Wita';
                })
              
                ->editColumn('is_deleted', function ($row) {
                    return $row->is_deleted ? 'Deleted' : 'Active'  ;
                })
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = "<div class='d-flex justify-content-center'>";
                    if(!$row->is_deleted){
                        $btn = $btn."<button id='$row->id' class='editEventBtn btn btn-warning mr-1'>Edit</button>";
                        $btn = $btn."<button id='$row->id' class='deleteEventButtonNew btn btn-danger'>Delete</button>";
                    }
                    $btn = $btn."</div>";
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);    
        }

        return view('Pages.Event.ManageEvent');
    }

    function delete($id){
        $Event = Event::find($id);
        if(!$Event){
            return response()->json([
                'errors' => 'Event Not Found !'
            ]);
        }
        $Event->is_deleted = 1;
        $Event->save();

        return response()->json([
            'success' => 'Event Delete Success !'
        ]);
    }

    function getData($id){
        $Event = Event::find($id);
        if(!$Event){
            return response()->json([
                'errors' => 'Event Not Found !'
            ]);
        }

        return response()->json([
            'data' => $Event,
            'date' => $Event->date->toDatetimelocalString()
        ]);
    }

    function update(Request $request){
        $Validator = Validator::make($request->all(), [
            'EventId' => 'required',
            'title' => 'required',
            'description' => 'required',
            'datetime' => 'required'
        ]);

        if($Validator->fails()){
            return response()->json([
                'errors' => 'Invalid Fields !'
            ]);
        }

        $Event = Event::find($request->EventId);
        if(!$Event){
            return response()->json([
                'errors' => 'Event Not Found !'
            ]);
        }

        $Event->title = $request->title;
        $Event->description = $request->description;
        $Event->date = $request->datetime;
        $Event->update();

        return response()->json([
            'success' => 'Edit Event Successfully !'
        ]);
    }

    function adminStore(Request $request){
        $Validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'datetime' => 'required',
            'placeCode' => 'required'
        ]);

        if($Validator->fails()){
            return response()->json([
                'errors' => 'Invalid Fields !'
            ]);
        }

        $Place = Place::where('place_code', $request->placeCode)->first();
        if(!$Place){
            return response()->json([
                'errors' => 'Place Code Not Found !'
            ]);
        }

        Event::create([
            'place_id' => $Place->id,
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->datetime,
            'is_deleted' => 0
        ]);

        return response()->json([
            'success' => 'Event Created Successfully !'
        ]);
    }
}
