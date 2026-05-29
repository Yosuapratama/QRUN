<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\LogActivities;
use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CommentController extends Controller
{
    public function datatable(Request $request)
    {
        if (!$request->ajax()) {
            return view('Pages.Management.Master.comments.index');
        }

        $isSuperAdmin = Auth::user()->hasRole('superadmin');

        $data = Comment::with('user', 'place');

        // =========================
        // NON SUPERADMIN FILTER
        // =========================
        if (!$isSuperAdmin) {

            $placeIds = Place::where('creator_id', Auth::id())
                ->pluck('id');

            $data->whereIn('place_id', $placeIds);
        }

        // =========================
        // FILTER PLACE CODE
        // =========================
        if ($request->place_code) {

            $data->whereHas('place', function ($query) use ($request) {

                $query->where(
                    'place_code',
                    'like',
                    '%' . $request->place_code . '%'
                );
            });
        }

        // =========================
        // FILTER EMAIL
        // =========================
        if ($request->email) {

            $data->whereHas('user', function ($query) use ($request) {

                $query->where(
                    'email',
                    'like',
                    '%' . $request->email . '%'
                );
            });
        }

        // =========================
        // FILTER DATE
        // =========================
        if ($request->date) {

            $data->whereDate(
                'updated_at',
                $request->date
            );
        }

        // =========================
        // FILTER RATING
        // =========================
        if (
            $request->filled('rating') &&
            $request->rating !== ''
        ) {

            $data->where(
                'rating',
                $request->rating
            );
        }

        return DataTables::of($data)

            ->editColumn('updated_at', function ($row) {

                return \Carbon\Carbon::parse(
                    $row->updated_at
                )->format('d-M-Y H:i:s');
            })

            ->editColumn('rating', function ($row) {

                return $row->rating > 0
                    ? $row->rating
                    : '-';
            })

            ->addColumn('email', function ($row) {

                return $row->user->email ?? '-';
            })

            ->addColumn('place_code', function ($row) {

                $place_code = $row->place->place_code ?? '-';

                if ($place_code === '-') {
                    return '-';
                }

                return "
                <a 
                    target='_blank' 
                    href='/detail-place/$place_code'
                    class='font-weight-bold text-primary'
                >
                    $place_code
                </a>
            ";
            })

            ->addColumn('action', function ($row) use ($isSuperAdmin) {

                // only owner can delete if not superadmin
                if (
                    !$isSuperAdmin &&
                    $row->user_id != Auth::id()
                ) {

                    return '-';
                }

                return "
                <div class='d-flex justify-content-center align-items-center'>

                    <button 
                        id='$row->id' 
                        class='delete btn btn-danger btn-sm shadow-sm rounded-pill px-3'
                    >
                        <i class='fas fa-trash-alt mr-1'></i>
                        Delete
                    </button>

                </div>
            ";
            })

            ->rawColumns([
                'action',
                'place_code'
            ])

            ->make(true);
    }
    // Get all comments (including replies)
    public function index(Request $request, $place_code)
    {
        if ($request->type == 'api') {
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
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Unauthenticated !'
            ]);
        }

        $placeId = Place::where('place_code', $place_code)->first();
        if (!$placeId->is_comment) {
            return abort(404);
        }

        $request->merge(['user_id' => Auth::user()->id]);
        $request->merge(['place_id' => $placeId->id]);

        $Validator = Validator::make($request->all(), [
            'rating' => 'required|numeric|min:0|max:5',
            'comment' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'place_id' => 'required|exists:place,id',
            'parent_id' => 'nullable|exists:comments,id', // Optional for replies
        ]);

        if ($Validator->fails()) {
            return response()->json([
                'errors' => $Validator->errors()
            ]);
        }

        LogActivities::create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'user_id' => Auth::user()->id,
            'activities' => "User Created Comments Data at " . Carbon::now()->format('Y-m-d H:i:s'),
            "type" => LogActivities::TYPE_CREATE_COMMENT
        ]);

        $comment = Comment::create([
            'user_id' => $request->user_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'place_id' => $request->place_id,
            'parent_id' => $request->parent_id ? $request->parent_id : null,
        ]);

        return response()->json($comment, 201);
    }

    public function delete($id)
    {
        $comment = Comment::find($id);
        if (!$comment) {
            return response()->json([
                'errors' => 'Data Not Found !'
            ]);
        }

        if (!Auth::user()->hasRole('superadmin')) {
            $Place = Place::select('id', 'creator_id')->where('id', $comment->place_id)->first();
            if (!$Place) {
                return response()->json([
                    'errors' => 'Unauthorized !'
                ]);
            }
        }

        LogActivities::create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'user_id' => Auth::user()->id,
            'activities' => "User Deleted Comments Data with id : " . $comment->id . " at " . Carbon::now()->format('Y-m-d H:i:s'),
            "type" => LogActivities::TYPE_DELETE_COMMENT
        ]);

        $comment->delete();

        return response()->json([
            'success' => 'Comment deleted successfully !'
        ]);
    }

    function deleteCommentsByUser($place_code, $comment_id)
    {
        $comment = Comment::find($comment_id);
        if (!$comment) {
            return response()->json([
                'errors' => 'Data Not Found !'
            ]);
        }

        $checkIsPlaceValid = Place::where('place_code', $place_code)->first();
        if (!$checkIsPlaceValid) {
            return response()->json([
                'errors' => 'Data Not Found !'
            ]);
        }

        if (!Auth::user()->hasRole('superadmin')) {
            $Place = Place::select('id', 'creator_id')->where('id', $comment->place_id)->first();
            if (!$Place) {
                return response()->json([
                    'errors' => 'Unauthorized !'
                ]);
            }
        }

        LogActivities::create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'user_id' => Auth::user()->id,
            'activities' => "User Deleted Comments Data with id : " . $comment->id . " at " . Carbon::now()->format('Y-m-d H:i:s'),
            "type" => LogActivities::TYPE_DELETE_COMMENT
        ]);


        $comment->delete();

        return response()->json([
            'success' => 'Comment deleted successfully !'
        ]);
    }

    function updateComment(Request $request, $place_code)
    {
        $Validator = Validator::make($request->all(), [
            'comment_id' => 'required',
            'comment' => 'required',
            'userId' => 'required'
        ]);
        if ($Validator->fails()) {
            return response()->json([
                'errors' => 'Invalid Fields !'
            ]);
        }

        $comment = Comment::find($request->comment_id);
        if (!$comment) {
            return response()->json([
                'errors' => 'Data Not Found !'
            ]);
        }

        $checkIsPlaceValid = Place::where('place_code', $place_code)->first();
        if (!$checkIsPlaceValid) {
            return response()->json([
                'errors' => 'Data Not Found !'
            ]);
        }

        if (!Auth::user()->hasRole('superadmin')) {
            $Place = Place::select('id', 'creator_id')->where('id', $comment->place_id)->first();
            if (!$Place) {
                return response()->json([
                    'errors' => 'Unauthorized !'
                ]);
            }
        }

        $comment->update([
            'comment' => $request->comment
        ]);

        LogActivities::create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'user_id' => Auth::user()->id,
            'activities' => "User Updated Comments Data with id : " . $comment->id . " at " . Carbon::now()->format('Y-m-d H:i:s'),
            "type" => LogActivities::TYPE_UPDATE_COMMENT
        ]);


        return response()->json([
            'message' => 'Data updated successfully !'
        ]);
    }
}
