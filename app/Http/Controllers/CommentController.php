<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CommentController extends Controller
{
    public function datatable(Request $request){
        if(Auth::user()->hasRole('superadmin')){
            if ($request->ajax()) {
                $data = Comment::with('user', 'place')->get();
                
                return DataTables::of($data)
                    ->editColumn('updated_at', function ($row) {
                        return \Carbon\Carbon::parse($row->updated_at)->format('d-M-Y H:i:s');
                    })
                    ->editColumn('rating', function ($row) {
                        return $row->rating > 0 ? $row->rating : '-'; 
                    })
                    ->addIndexColumn()
                    ->addColumn('email', function ($row) {
                        return $row->user->email;
                    })
                    ->addIndexColumn()
                    ->addColumn('place_code', function ($row) {
                        $place_code = $row->place->place_code ?? '-';
                        return "<a target='_blank' href='/detail-place/$place_code'>$place_code</a>";
                    })
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = "<div class='d-flex justify-content-center align-items-center'>";
                        $btn = $btn . "<button id='$row->id' class='delete btn btn-danger btn-sm mr-1'>Delete</button>";
                        $btn = $btn . "</div>";
                        return $btn;
                    })
                    ->rawColumns(['action', 'place_code'])
                    ->make(true);
            }
    

            
        }else {
            if ($request->ajax()) {
                $place = Place::select('id')->where('creator_id', Auth::user()->id)->get();

                $data = Comment::whereIn('place_id', $place)->with('user', 'place')->get();
                
                return DataTables::of($data)
                    ->editColumn('updated_at', function ($row) {
                        return \Carbon\Carbon::parse($row->updated_at)->format('d-M-Y H:i:s');
                    })
                    ->editColumn('rating', function ($row) {
                        return $row->rating > 0 ? $row->rating : '-'; 
                    })
                    ->addIndexColumn()
                    ->addColumn('email', function ($row) {
                        return $row->user->email;
                    })
                    ->addIndexColumn()
                    ->addColumn('place_code', function ($row) {
                        $place_code = $row->place->place_code ?? '-';
                        return "<a target='_blank' href='/detail-place/$place_code'>$place_code</a>";
                    })
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $btn = "<div class='d-flex justify-content-center align-items-center'>";
                        $btn = $btn . "<button id='$row->id' class='delete btn btn-danger btn-sm mr-1'>Delete</button>";
                        $btn = $btn . "</div>";
                        return $btn;
                    })
                    ->rawColumns(['action', 'place_code'])
                    ->make(true);
            }
        }

        // return abort(403);
        return view('Pages.Management.Master.comments.index');
    }
    // Get all comments (including replies)
    public function index(Request $request, $place_code)
    {
        if($request->type == 'api'){
            return response()->json([
                'data' => Comment::with(['user', 'replies.user'])
                ->where('place_id', Place::where('place_code', $place_code)->first()->id)
                ->whereNull('parent_id')
                ->latest()
                ->paginate(5),
                'uid' => Auth::check() ? Auth::user()->id : null
            ]);

        }
    }

    // Store a new comment or a reply
    public function store(Request $request, $place_code)
    {
        if(!Auth::check()){
            return response()->json([
                'message' => 'Unauthenticated !'
            ]);
        }

        $placeId = Place::where('place_code', $place_code)->first();
        if(!$placeId->is_comment){
            return abort(404);
        }
        
        $request->merge(['user_id' => Auth::user()->id]); 
        $request->merge(['place_id' => $placeId->id]); 

        $Validator = Validator::make($request->all(),[
            'rating'=> 'required|numeric|min:0|max:5',
            'comment' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'place_id' => 'required|exists:place,id',
            'parent_id' => 'nullable|exists:comments,id', // Optional for replies
        ]);

        if($Validator->fails()){
            return response()->json([
                'errors' => $Validator->errors()
            ]);
        }
      
        $comment = Comment::create([
            'user_id' => $request->user_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'place_id' => $request->place_id,
            'parent_id' => $request->parent_id ? $request->parent_id : null, 
        ]);

        return response()->json($comment, 201);
    }

    public function delete($id){
        $comment = Comment::find($id);
        if(!$comment){
            return response()->json([
                'errors' => 'Data Not Found !'
            ]);
        }

        if(!Auth::user()->hasRole('superadmin')){
            $Place = Place::select('id', 'creator_id')->where('id', $comment->place_id)->first();
            if(!$Place){
                return response()->json([
                    'errors' => 'Unauthorized !'
                ]);
            }
        }

        $comment->delete();

        return response()->json([
            'success' => 'Comment deleted successfully !'
        ]);

    }

    function deleteCommentsByUser($place_code, $comment_id){
        $comment = Comment::find($comment_id);
        if(!$comment){
            return response()->json([
                'errors' => 'Data Not Found !'
            ]);
        }

        $checkIsPlaceValid = Place::where('place_code', $place_code)->first();
        if(!$checkIsPlaceValid){
            return response()->json([
                'errors' => 'Data Not Found !'
            ]);
        }

        if(!Auth::user()->hasRole('superadmin')){
            $Place = Place::select('id', 'creator_id')->where('id', $comment->place_id)->first();
            if(!$Place){
                return response()->json([
                    'errors' => 'Unauthorized !'
                ]);
            }
        }

        $comment->delete();

        return response()->json([
            'success' => 'Comment deleted successfully !'
        ]);

    }

    function updateComment(Request $request, $place_code){
        $Validator = Validator::make($request->all(), [
            'comment_id' => 'required',
            'comment' => 'required',
            'userId' => 'required'
        ]);
        if($Validator->fails()){
            return response()->json([
                'errors' => 'Invalid Fields !'
            ]);
        }

        $comment = Comment::find($request->comment_id);
        if(!$comment){
            return response()->json([
                'errors' => 'Data Not Found !'
            ]);
        }

        $checkIsPlaceValid = Place::where('place_code', $place_code)->first();
        if(!$checkIsPlaceValid){
            return response()->json([
                'errors' => 'Data Not Found !'
            ]);
        }

        if(!Auth::user()->hasRole('superadmin')){
            $Place = Place::select('id', 'creator_id')->where('id', $comment->place_id)->first();
            if(!$Place){
                return response()->json([
                    'errors' => 'Unauthorized !'
                ]);
            }
        }

        $comment->update([
            'comment' => $request->comment
        ]);

        return response()->json([
            'message' => 'Data updated successfully !'
        ]);


    }
}
