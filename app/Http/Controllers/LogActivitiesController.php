<?php

namespace App\Http\Controllers;

use App\Models\LogActivities;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class LogActivitiesController extends Controller
{
    function index(Request $request){

        $data = LogActivities
        ::when($request->type !== null, function($query) use($request) {
            return $query->where('type' ,$request->type);
        })
        ->when($request->startDate !== null, function($query) use($request) {
            // Ensure startDate is in the correct format (YYYY-MM-DD)
            $startDate = \Carbon\Carbon::parse($request->startDate)->startOfDay(); // Start of the day
            return $query->where('created_at', '>=', $startDate);
        })
        ->when($request->endDate !== null, function($query) use($request) {
            // Ensure endDate is in the correct format (YYYY-MM-DD)
            $endDate = \Carbon\Carbon::parse($request->endDate)->endOfDay(); // End of the day
            return $query->where('created_at', '<=', $endDate);
        })
        ->with('user')->orderByDesc('created_at')->get();

        if ($request->ajax()) {

            return DataTables::of($data)
            
            ->editColumn('email', function($row){
                return $row->user_email;
            })
            ->editColumn('type', function($row){
                if (Str::contains($row->type, 'CREATE')) {
                    return "<div class='bg bg-success text-white rounded' style='font-size:12px; display: flex; justify-content: center; align-items: center; text-align: center; height: 100%; font-weight:bold'>$row->type</div>";
                    // Highlight with a green background
                }else if (Str::contains($row->type, 'DELETE')) {
                    return "<div class='bg bg-danger text-white rounded' style='font-size:12px; display: flex; justify-content: center; align-items: center; text-align: center; height: 100%; font-weight:bold'>$row->type</div>";
                    // Highlight with a green background
                }else if (Str::contains($row->type, 'UPDATE')) {
                    return "<div class='bg bg-warning text-white rounded' style='font-size:12px; display: flex; justify-content: center; align-items: center; text-align: center; height: 100%; font-weight:bold'>$row->type</div>";
                    // Highlight with a green background
                }else{
                    return "<div class='bg bg-primary text-white rounded' style='font-size:12px; display: flex; justify-content: center; align-items: center; text-align: center; height: 100%; font-weight:bold'>$row->type</div>";
                }
                
            })
            ->rawColumns(['type'])
            ->make(true);
                // ->editColumn('date', function ($row) {
                //     return \Carbon\Carbon::parse($row->date )->format('d-M-Y H:i:s').' Wita';
                // })
              
                // ->editColumn('deleted_at', function ($row) {
                //     return $row->deleted_at ? 'Deleted' : 'Active'  ;
                // })
                // ->editColumn('place_code', function ($row) {
                //     $place_code = $row->places->place_code ?? '-';
                //     return "<a target='_blank' href='/detail-place/$place_code'>$place_code</a>";
                // })
                // ->addIndexColumn()
                // ->addColumn('action', function ($row) {
                //     $btn = "<div class='d-flex justify-content-center'>";
                   
                //     $btn = $btn."<button id='$row->id' class='editEventBtn btn btn-warning mr-1'>Edit</button>";
                //     $btn = $btn."<button id='$row->id' class='deleteEventButtonNew btn btn-danger'>Delete</button>";
                    
                //     $btn = $btn."</div>";
                //     return $btn;
                // })
                // ->rawColumns(['action', 'place_code'])
                // ->make(true);    
        }

        return view('Pages.Management.Master.settings.log-activity.index');
    }
}
