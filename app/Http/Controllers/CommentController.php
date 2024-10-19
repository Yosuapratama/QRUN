<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    // Get all comments (including replies)
    public function index(Request $request, $place_code)
    {
        if($request->type == 'api'){
            return response()->json([
                'data' => Comment::where('place_id', Place::where('place_code', $place_code)->first()->id)->with('user', 'replies.user')->whereNull('parent_id')->latest()->paginate(5),
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
            'parent_id' => $request->parent_id ? $request->parent_id : null, // Link to the parent comment
        ]);

        return response()->json($comment, 201);
    }
}
