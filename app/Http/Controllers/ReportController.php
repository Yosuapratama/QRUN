<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Place;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getPlaces(Request $request)
    {
        // dd($request->all());
        if (isset($request->paging) && $request->paging == "false") {
            $perPage = $request->input('per_page', 1000);
        } else {
            $perPage = $request->input('per_page', 5);
        }
        $places = Place::query()
            ->when($request->date_start && $request->date_end, function ($query) use ($request) {
                return $query->whereBetween('created_at', [
                    Carbon::parse($request->date_start),
                    Carbon::parse($request->date_end)
                ]);
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('place_code', 'like', "%{$search}%")
                        ->orWhere('title', 'like', "%{$search}%");
                });
            })
            ->with([
                'province:id,name',
                'district:id,name'
            ])
            ->select(
                'id',
                'place_code',
                'title',
                'description',
                'creator_id',
                'views',
                'is_comment',
                'created_at',
                'updated_at',
                'deleted_at',
                'province_id',
                'district_id',
                'regency_id',
                'village_id'
            )
            ->paginate($perPage);

        // dd($places);
        $data = $places->map(function ($place) {
            return [
                'id' => $place->id,
                'place_code' => $place->place_code,
                'title' => $place->title,
                'description' => $place->description,
                'creator_id' => $place->creator_id,
                'views' => $place->views,
                'is_comment' => $place->is_comment,
                'created_at' => $place->created_at,
                'updated_at' => $place->updated_at,
                'deleted_at' => $place->deleted_at,
                'province_id' => $place->province_id,
                'province_name' => optional($place->province)->name,
                'district_id' => $place->district_id,
                'district_name' => optional($place->district)->name,
                'regency_id' => $place->regency_id,
                'village_id' => $place->village_id,
                'comments_count' => $place->comment_count ?? 0
            ];
        });

        // dd($data);
        return response()->json([
            'status' => 'success',
            'data' => $data,
            'meta' => [
                'current_page' => $places->currentPage(),
                'last_page' => $places->lastPage(),
                'per_page' => $places->perPage(),
                'total' => $places->total(),
                'total_views' => $places->sum('views')
            ]
        ]);
    }

    public function getUsers(Request $request)
    {
        if (isset($request->paging) && $request->paging == "false") {
            $perPage = $request->input('per_page', 1000);
        } else {
            $perPage = $request->input('per_page', 5);
        }

        $users = User::query()
            ->when($request->date_start && $request->date_end, function ($query) use ($request) {
                return $query->whereBetween('created_at', [
                    Carbon::parse($request->date_start),
                    Carbon::parse($request->date_end)
                ]);
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->select('id', 'name', 'email', 'created_at', 'updated_at', 'approved_at')
            ->paginate($perPage);



        $data = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'address' => $user->address,
                'created_at' => $user->created_at,
                'email_verified_at' => $user->email_verified_at
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $data,
            'meta' => [
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
                'per_page' => $users->perPage(),
                'total' => $users->total()
            ]
        ]);
    }

    public function getEvents(Request $request)
    {
        if (isset($request->paging) && $request->paging == "false") {
            $perPage = $request->input('per_page', 1000);
        } else {
            $perPage = $request->input('per_page', 5);
        }

        $events = Event::withTrashed()
            ->when($request->date_start && $request->date_end, function ($query) use ($request) {
                return $query->whereBetween('date', [
                    Carbon::parse($request->date_start),
                    Carbon::parse($request->date_end)
                ]);
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->select(
                'id',
                'title',
                'description',
                'date', // only 'date' column
                // 'creator_id',
                'place_id',
                'created_at',
                'updated_at'
            )
            ->paginate($perPage);

        $data = $events->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->description,
                'date' => $event->date, // only 'date' field
                // 'creator_id' => $event->creator_id,
                'place_id' => $event->place_id,
                'created_at' => $event->created_at,
                'updated_at' => $event->updated_at
            ];
        });

        return response()->json([
            'status' => 'success',
            'data' => $data,
            'meta' => [
                'current_page' => $events->currentPage(),
                'last_page' => $events->lastPage(),
                'per_page' => $events->perPage(),
                'total' => $events->total()
            ]
        ]);
    }

    public function index()
    {
        return view('Pages.Management.Master.report.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function reportPdf(Request $request)
    {
        // dd("paus");
        $places = Place::query()
            ->when($request->start_date && $request->end_date, function ($query) use ($request) {
                return $query->whereBetween('created_at', [
                    Carbon::parse($request->start_date),
                    Carbon::parse($request->end_date)
                ]);
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('place_code', 'like', "%{$search}%")
                        ->orWhere('title', 'like', "%{$search}%");
                });
            })
            ->with([
                'province:id,name',
                'district:id,name'
            ])
            ->select(
                'id',
                'place_code',
                'title',
                'description',
                'creator_id',
                'views',
                'is_comment',
                'created_at',
                'updated_at',
                'deleted_at',
                'province_id',
                'district_id',
                'regency_id',
                'village_id'
            )
            ->get();

        $dataPlaces = $places->map(function ($place) {
            return [
                'id' => $place->id,
                'place_code' => $place->place_code,
                'title' => $place->title,
                'description' => $place->description,
                'creator_id' => $place->creator_id,
                'views' => $place->views,
                'is_comment' => $place->is_comment,
                'created_at' => $place->created_at,
                'updated_at' => $place->updated_at,
                'deleted_at' => $place->deleted_at,
                'province_id' => $place->province_id,
                'province_name' => optional($place->province)->name,
                'district_id' => $place->district_id,
                'district_name' => optional($place->district)->name,
                'regency_id' => $place->regency_id,
                'village_id' => $place->village_id,
                'comments_count' => $place->comment_count ?? 0
            ];
        });

        //get user
        $users = User::query()
            ->when($request->start_date && $request->end_date, function ($query) use ($request) {
                return $query->whereBetween('created_at', [
                    Carbon::parse($request->start_date),
                    Carbon::parse($request->end_date)
                ]);
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->select('id', 'name', 'email', 'created_at', 'updated_at', 'approved_at')
            ->get();



        $dataUsers = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'address' => $user->address,
                'created_at' => $user->created_at,
                'email_verified_at' => $user->email_verified_at
                // 'deleted_at' => $user->deleted_at
            ];
        });

        //event

        $events = Event::withTrashed()
            ->when($request->start_date && $request->end_date, function ($query) use ($request) {
                return $query->whereBetween('date', [
                    Carbon::parse($request->start_date),
                    Carbon::parse($request->end_date)
                ]);
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->select(
                'id',
                'title',
                'description',
                'date', // only 'date' column
                // 'creator_id',
                'place_id',
                'created_at',
                'updated_at'
            )->get();

        $dataEvents = $events->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->description,
                'date' => $event->date, // only 'date' field
                // 'creator_id' => $event->creator_id,
                'place_id' => $event->place_id,
                'created_at' => $event->created_at,
                'updated_at' => $event->updated_at
            ];
        });


        $pdf = Pdf::loadView('Pages.Management.Master.report.pdf', [
            'places' => $dataPlaces,
            'users' => $dataUsers,
            'events' => $dataEvents,
            'total_place' => $dataPlaces->count(),
            'total_user' => $dataUsers->count(),
            'total_views' => $dataPlaces->sum('views'),
            'total_events' => $dataEvents->count(),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);

        $startDate = $request->start_date ? Carbon::parse($request->start_date)->format('Y-m-d') : '-';
        $endDate = $request->end_date ? Carbon::parse($request->end_date)->format('Y-m-d') : '-';
        $filename = "Report Analytics Qrun Website | {$startDate} - {$endDate}.pdf";
        return $pdf->download($filename);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
