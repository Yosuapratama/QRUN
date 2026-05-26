<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Place;
use App\Models\Event;
use App\Models\EventImage;
use App\Models\LogActivities;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

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
    function indexAdmin(Request $request)
    {

        if (Auth::user()->hasRole('superadmin')) {
            $arrData = Event::with('places')->orderBy('updated_at', 'DESC');

            if ($request->place_id) {
                $arrData->where('place_id', $request->place_id);
            }

            $arrData = $arrData->get();
        } else {
            $arrData = [];

            $query = Event::with('places')->orderBy('updated_at', 'DESC');

            if ($request->place_id) {
                $query->where('place_id', $request->place_id);
            }

            $data = $query->get();

            foreach ($data as $dt) {
                if ($dt->places) {
                    if ($dt->places->creator_id === Auth::user()->id) {
                        $arrData[] = $dt;
                    }
                }
            }
        }

        if ($request->ajax()) {
            return Datatables::of($arrData)
                ->editColumn('deleted_at', function ($row) {
                    return $row->deleted_at ? 'Deleted' : 'Active';
                })
                ->editColumn('place_code', function ($row) {
                    $place_code = $row->places->place_code ?? '-';
                    return "<a target='_blank' href='/detail-place/$place_code'>$place_code</a>";
                })
                ->editColumn('date', function ($row) {
                    $start = \Carbon\Carbon::parse($row->date)
                        ->format('d M Y H:i');

                    // jika end_date null → samakan dengan start
                    $end = \Carbon\Carbon::parse(
                        $row->end_date ?? $row->date
                    )->format('d M Y H:i');

                    return '
                        <div class="schedule-box">
                            <div>
                                <i class="fas fa-calendar text-primary mr-2"></i>
                                ' . $start . '
                            </div>

                            <div class="small text-muted mt-1">
                                Until ' . $end . '
                            </div>
                        </div>
                    ';
                })
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = "<div class='d-flex justify-content-center'>";

                    $btn = $btn . "<button id='$row->id' class='editEventBtn btn btn-warning mr-1'>Edit</button>";
                    $btn = $btn . "<button id='$row->id' class='deleteEventButtonNew btn btn-danger'>Delete</button>";

                    $btn = $btn . "</div>";
                    return $btn;
                })
                ->rawColumns(['action', 'place_code', 'date'])
                ->make(true);
        }

        return view('Pages.Management.Master.event.index');
    }

    // (2) This is for admin to store the data with ajax request
    function adminStore(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'datetime' => 'required',
            'placeCode' => 'required_without:place_id',
            'place_id' => 'required_without:placeCode',
        ]);

        if ($Validator->fails()) {
            return response()->json([
                'errors' => $Validator->errors()
            ], 422);
        }


        if ($request->place_id) {
            $Place = Place::select('id', 'creator_id')->where('id', $request->place_id)->first();
        } else {
            $Place = Place::select('id', 'creator_id')->where('place_code', $request->placeCode)->first();
        }

        if (!$Place) {
            return response()->json([
                'message' => 'Place Code Not Found !'
            ], 404);
        }

        if (!Auth::user()->hasRole('superadmin')) {
            if ($Place->creator_id != Auth::user()->id) {
                return response()->json([
                    'message' => 'Unauthorized !'
                ], 403);
            }
        }

        $event = Event::create([
            'place_id' => $Place->id,
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->datetime
        ]);


        if ($request->hasFile('images')) {

            $directory =
                public_path(
                    "storage/event-images/{$event->id}"
                );

            if (!file_exists($directory)) {

                mkdir(
                    $directory,
                    0755,
                    true
                );
            }

            foreach (
                $request->file('images')
                as $index => $image
            ) {

                $imageName =
                    Str::uuid() .
                    '.' .
                    $image->getClientOriginalExtension();

                // move file
                $image->move(
                    $directory,
                    $imageName
                );

                // relative path ke DB
                $relativePath =
                    "event-images/{$event->id}/{$imageName}";

                EventImage::create([
                    'event_id' => $event->id,
                    'image' => $relativePath,
                    'sort_order' => $index + 1
                ]);
            }
        }
        LogActivities::create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'user_id' => Auth::user()->id,
            'activities' => "User Created Event Data at " . Carbon::now()->format('Y-m-d H:i:s'),
            "type" => LogActivities::TYPE_CREATE_EVENT
        ]);


        return response()->json([
            'success' => 'Event Created Successfully !'
        ]);
    }
    // (3) For Users To See their detail event  
    function index(Request $request)
    {
        if (Auth::user()->approved_at) {
            $place = Place::where('creator_id', Auth::user()->id)->latest()->first();

            if ($request->ajax()) {
                if ($place) {
                    $data = Event::where('place_id', $place->id)->latest()->get();

                    return Datatables::of($data)
                        // ->editColumn('date', function ($row) {
                        //     return \Carbon\Carbon::parse($row->date)->format('d-M-Y H:i:s') . ' Wita';
                        // })
                        ->addIndexColumn()
                        ->addColumn('action', function ($row) {
                            $btn = "<div class='d-flex justify-content-center'>";
                            $btn = $btn . "<button id='$row->id' class='editEventBtn btn btn-warning mr-1'>Edit</button>";
                            $btn = $btn . "<button id='$row->id' class='deleteEventButtonNew btn btn-danger'>Delete</button>";
                            $btn = $btn . "</div>";
                            return $btn;
                        })
                        ->editColumn('date', function ($row) {
                            $start = \Carbon\Carbon::parse($row->date)
                                ->format('d M Y H:i');

                            // jika end_date null → samakan dengan start
                            $end = \Carbon\Carbon::parse(
                                $row->end_date ?? $row->date
                            )->format('d M Y H:i');

                            return '
                                <div class="schedule-box">
                                    <div>
                                        <i class="fas fa-calendar text-primary mr-2"></i>
                                        ' . $start . '
                                    </div>

                                    <div class="small text-muted mt-1">
                                        Until ' . $end . '
                                    </div>
                                </div>
                            ';
                        })
                        ->rawColumns(['action', 'date'])
                        ->make(true);
                } else {
                    $data = [];

                    return Datatables::of($data)
                        ->addIndexColumn()
                        ->addColumn('action', function ($row) {
                            $btn = "<div class='d-flex justify-content-center'>";

                            $btn = $btn . "</div>";
                            return $btn;
                        })
                        ->editColumn('date', function ($row) {

                            $start = \Carbon\Carbon::parse($row->date)
                                ->format('d M Y H:i');

                            // jika end_date null → samakan dengan start
                            $end = \Carbon\Carbon::parse(
                                $row->end_date ?? $row->date
                            )->format('d M Y H:i');

                            return '
                                <div class="schedule-box">
                                    <div>
                                        <i class="fas fa-calendar text-primary mr-2"></i>
                                        ' . $start . '
                                    </div>

                                    <div class="small text-muted mt-1">
                                        Until ' . $end . '
                                    </div>
                                </div>
                            ';
                        })
                        ->rawColumns(['action', 'date'])
                        ->make(true);
                }
            }

            return view('Pages.Management.Master.my-event.index');
        } else {
            return back()->withErrors('You Must Approved By Admin First !');
        }
    }

    // (4) This is for user to store their data local event
    function store(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'datetime' => 'required'
        ]);

        if ($Validator->fails()) {
            return response()->json([
                'errors' => $Validator->errors()
            ], 422);
        }

        $Place = Place::select('id')->where('creator_id', Auth::user()->id)->first();
        if (!$Place) {
            return response()->json([
                'errors' => 'You Must Upload Your Place First !'
            ], 422);
        }
        Event::create([
            'place_id' => $Place->id,
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->datetime,
            'end_date' => $request->end_date
        ]);

        LogActivities::create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'user_id' => Auth::user()->id,
            'activities' => "User Created Event Data at " . Carbon::now()->format('Y-m-d H:i:s'),
            "type" => LogActivities::TYPE_CREATE_EVENT
        ]);

        return response()->json([
            'success' => 'Event Created Successfully !'
        ]);
    }

    private function removeDeletedImages(
        $event,
        array $existingImages = []
    ): void {

        $deletedImages = $event
            ->images()
            ->whereNotIn(
                'id',
                $existingImages
            )
            ->get();

        foreach ($deletedImages as $image) {

            // full path file
            $filePath = public_path(
                'storage/' .
                    $image->image
            );

            // delete physical file
            if (file_exists($filePath)) {

                unlink($filePath);
            }

            // soft delete db
            $image->delete();
        }
    }

    // (5) This function is used to update data for user approved
    function update(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'EventId' => 'required',
            'title' => 'required',
            'description' => 'required',
            'datetime' => 'required'
        ]);

        if ($Validator->fails()) {
            return response()->json([
                'errors' => $Validator->errors()
            ], 422);
        }

        $Event = Event::find($request->EventId);

        if (!Auth::user()->hasRole('superadmin')) {
            if ($Event->places->creator_id != Auth::user()->id) {
                return response()->json([
                    'errors' => 'Unauthorized !'
                ], 403);
            }
        }

        if (!$Event) {
            return response()->json([
                'errors' => 'Event Not Found !'
            ], 404);
        }

        $Event->title = $request->title;
        $Event->description = $request->description;
        $Event->date = $request->datetime;

        if ($request->end_date) {
            $Event->end_date = $request->end_date;
        }

        $this->removeDeletedImages(
            $Event,
            $request
                ->existing_images ?? []
        );

        if ($request->hasFile('cropped_images')) {

            foreach (
                $request->file('cropped_images')
                as $imageId => $file
            ) {

                $eventImage =
                    EventImage::find($imageId);

                if (!$eventImage) {
                    continue;
                }

                $directory =
                    public_path(
                        "storage/event-images/{$Event->id}"
                    );

                if (!file_exists($directory)) {

                    mkdir(
                        $directory,
                        0755,
                        true
                    );
                }

                // delete old file
                $oldPath =
                    public_path(
                        'storage/' .
                            $eventImage->image
                    );

                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }

                // save new file
                $imageName =
                    uniqid() . '.' .
                    $file
                    ->getClientOriginalExtension();

                $file->move(
                    $directory,
                    $imageName
                );

                $eventImage->update([
                    'image' =>
                    "event-images/{$Event->id}/{$imageName}"
                ]);
            }
        }

        // =========================
        // ADD NEW IMAGES
        // =========================
        if ($request->hasFile('images')) {

            $directory = public_path(
                "storage/event-images/{$Event->id}"
            );

            if (!file_exists($directory)) {

                mkdir(
                    $directory,
                    0755,
                    true
                );
            }

            // ambil urutan terakhir
            $lastSort =
                EventImage::where(
                    'event_id',
                    $Event->id
                )
                ->max('sort_order') ?? 0;

            foreach (
                $request->file('images')
                as $index => $file
            ) {

                $imageName =
                    Str::uuid() . '.' .
                    $file->getClientOriginalExtension();

                $file->move(
                    $directory,
                    $imageName
                );

                EventImage::create([
                    'event_id' => $Event->id,

                    'image' =>
                    "event-images/{$Event->id}/{$imageName}",

                    'sort_order' =>
                    $lastSort + $index + 1
                ]);
            }
        }
        $Event->update();

        LogActivities::create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'user_id' => Auth::user()->id,
            'activities' => "User Updated Event Data with Id : " . $Event->id . " at " . Carbon::now()->format('Y-m-d H:i:s'),
            "type" => LogActivities::TYPE_UPDATE_EVENT
        ]);

        return response()->json([
            'success' => 'Edit Event Successfully !'
        ]);
    }

    // (6) This function is used to delete an event by users
    function delete($id)
    {
        $Event = Event::with('places')->find($id);
        if (!$Event) {
            return response()->json([
                'errors' => 'Event Not Found !'
            ]);
        }
        if (Auth::user()->hasRole('superadmin')) {
            $Event->delete();
        } else {

            if ($Event->places->creator_id === Auth::user()->id) {
                $Event->delete();
            } else {
                return response()->json([
                    'errors' => 'Unauthorized !'
                ]);
            }
        }

        LogActivities::create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'user_id' => Auth::user()->id,
            'activities' => "User Deleted Event Data with Id : " . $Event->id . " at " . Carbon::now()->format('Y-m-d H:i:s'),
            "type" => LogActivities::TYPE_DELETE_EVENT
        ]);

        return response()->json([
            'success' => 'Event Delete Success !'
        ]);
    }

    // (7) This is for users to getData Event
    function getData($id)
    {
        $Event = Event::with(['images'])->find($id);
        if (!$Event) {
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
