<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Place;
use App\Models\Event;

class EventController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Detail Of Event Controller
    |--------------------------------------------------------------------------
    |
    | This Controllers Contains :
    | -> For Admin 
    |  1. /event , Func Name : indexAdmin, Route Name : event
    |  2. /store-admin, Func Name : adminStore, Route Name : event.adminStore
    |
    | -> For Users
    |  3. /my-event, Func Name : index, Route Name : myevent.store
    |  4. /my-event/store, Func Name : store , Route Name : myevent.store
    |  5. /my-event/update, Func Name : update, Route Name : myevent.update
    |  6. /my-event/delete/{id} ,Func Name : delete, Route Name : myevent.delete
    |  7. /my-event/get-data/{id}, Func Name : getData, myevent.getData
    |
    */

    // (1) This detail of index event of admin
    function indexAdmin(Request $request){

        if (Auth::user()->hasRole('superadmin')) {
            $arrData = Event::with('places')->orderBy('updated_at', 'DESC')->get();
        }else{
            $arrData = [];

            $data = Event::with('places')->orderBy('updated_at', 'DESC')->get();
            foreach($data as $dt){
                if($dt->places){
                    if($dt->places->creator_id === Auth::user()->id){
                        $arrData[] = $dt;
                    }
                }
            }
        }

        if ($request->ajax()) {
            return Datatables::of($arrData)
                ->editColumn('date', function ($row) {
                    return \Carbon\Carbon::parse($row->date )->format('d-M-Y H:i:s').' Wita';
                })
              
                ->editColumn('deleted_at', function ($row) {
                    return $row->deleted_at ? 'Deleted' : 'Active'  ;
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
        }

        return view('Pages.Management.Master.event.index');
    }

    // (2) This is for admin to store the data with ajax request
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

        $Place = Place::select('id', 'creator_id')->where('place_code', $request->placeCode)->first();

        if(!$Place){
            return response()->json([
                'errors' => 'Place Code Not Found !'
            ]);
        }
      
        if(!Auth::user()->hasRole('superadmin')){
            if($Place->creator_id != Auth::user()->id){
                return response()->json([
                    'errors' => 'Unauthorized !'
                ]);
            }
        }
        
        Event::create([
            'place_id' => $Place->id,
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->datetime
        ]);

        return response()->json([
            'success' => 'Event Created Successfully !'
        ]);
    }
    // (3) For Users To See their detail event  
    function index(Request $request){
        if(Auth::user()->approved_at){
            $place = Place::where('creator_id', Auth::user()->id)->latest()->first();

            if ($request->ajax()) {
                if($place){
                    $data = Event::where('place_id', $place->id)->latest()->get();
    
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
    
            return view('Pages.Management.Master.my-event.index');

        }else{
            return back()->withErrors('You Must Approved By Admin First !');
        }
        

    }
    
    // (4) This is for user to store their data local event
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

        $Place = Place::select('id')->where('creator_id', Auth::user()->id)->first();
        if(!$Place){
            return response()->json([
                'errors' => 'You Must Upload Your Place First !'
            ]);
        }
        Event::create([
            'place_id' => $Place->id,
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->datetime
        ]);

        return response()->json([
            'success' => 'Event Created Successfully !'
        ]);
    }
    
    // (5) This function is used to update data for user approved
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

        if(!Auth::user()->hasRole('superadmin')){
            if($Event->places->creator_id != Auth::user()->id){
                return response()->json([
                    'errors' => 'Unauthorized !'
                ]);
            }
        }

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

    // (6) This function is used to delete an event by users
    function delete($id){
        $Event = Event::with('places')->find($id);
        if(!$Event){
            return response()->json([
                'errors' => 'Event Not Found !'
            ]);
        }
        if(Auth::user()->hasRole('superadmin')){
            $Event->delete();
        }else{

            if($Event->places->creator_id === Auth::user()->id){
                $Event->delete();
            }else{
                return response()->json([
                    'errors' => 'Unauthorized !'
                ]);
            }
        }

        return response()->json([
            'success' => 'Event Delete Success !'
        ]);
    }

    // (7) This is for users to getData Event
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

    
}
