<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Place;
use App\Models\Image;
use App\Models\Event;
use App\Models\UserHasPlaceLimit;
use DOMDocument;
use Illuminate\Support\Facades\Storage;

class PlaceController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Detail Of Place Controller
    |--------------------------------------------------------------------------
    |
    | This Controllers Contains :
    | -> For Superadmin
    | 1. /place, Func Name : index, Route Name : place
    | 2. /edit/{place_code}, Func Name : editPlace, Route Name : edit.place
    | 3. /deleted-place, Func Name : indexDeletedPlace, Route Name : place.getDeleted
    | 4. /create, Func Name : indexCreatePlace, Route Name : place.create
    | 5. /{place_code}/delete, Func Name : deletePlace, Route Name : place.delete
    |   
    | -> For User Approved
    | 6. /my-place, Func Name : returnMyPlaceView, Route Name : place.myplace
    | 7. /my-place/update, Func Name : updatePlace, Route Name : place.update
    | 8. /store, Func Name : store, Route Name : place.store
    | 9. /get-detail-data/{code}, Func Name : getDetailPlaceData, Route Name : place.getDetailPlaceData
    |
    | -> For Public To See Detail OF Place
    | 10. /detail-place/{place_code}, Func Name : getDetailPlace, Route Name : place.detail
    |
    | 11. /print-barcode/{placeCode}, Func Name : print, Route Name : place.print
    */

    // Define Application URL, example : http://localhost or https://qrun.online 
    private $applicationURLLocal;

    // Set construct, save url tu private variabel in this controller
    public function __construct(Request $request)
    {
        $this->applicationURLLocal = $request->schemeAndHttpHost();
    }

    // (1) Place Index Menu, on sidenav this menu call ManagePlace
    function index(Request $request)
    {
        if (Auth::user()->hasRole('superadmin')) {
            $data = Place::select('id', 'views', 'place_code', 'title', 'description', 'creator_id', 'created_at', 'updated_at')->with('creator_id')->latest()->get();
        } else {
            $data = Place::select('id', 'views', 'place_code', 'title', 'description', 'creator_id', 'created_at', 'updated_at')->with('creator_id')->where('creator_id', Auth::user()->id)->latest()->get();
        }

        if ($request->ajax()) {
            return DataTables::of($data)
                ->editColumn('updated_at', function ($row) {
                    return \Carbon\Carbon::parse($row->updated_at)->format('d-M-Y H:i:s');
                })
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $url = $this->applicationURLLocal . '/detail-place/' . $row->place_code;
                    $editUrl = $this->applicationURLLocal . '/management/master/place/edit/' . $row->place_code;
                    $printUrl = $this->applicationURLLocal . '/management/master/print-barcode/' . $row->place_code;

                    $btn = "<div class='d-flex'>";
                    $btn = $btn . "<button id='$row->place_code' class='detailPlaceButton btn btn-primary btn-sm mr-1'>Detail</button>";
                    $btn = $btn . "<a target='_blank' href='$url' class='btn btn-warning btn-sm mr-1'>Visit</a>";
                    $btn = $btn . "<a target='_blank' href='$editUrl' class='btn btn-secondary btn-sm mr-1'>Edit</a>";
                    $btn = $btn . "<a target='_blank' href='$printUrl' class='btn btn-success btn-sm mr-1'>Print</a>";
                    $btn = $btn . "<button id='$row->place_code' class='delete btn btn-danger btn-sm mr-1'>Delete</button>";

                    $btn = $btn . "</div>";
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }


        return view('Pages.Management.Master.place.index');
    }
    // (2) This Func For Superadmin to edit users place
    function editPlace($place_code)
    {
        if(!Auth::user()->hasRole('superadmin')){
            $Place = Place::where('place_code', $place_code)->where('creator_id', Auth::user()->id)->first();
            if(!$Place){
                return abort(404);
            }
        }else{
            $Place = Place::where('place_code', $place_code)->first();
        }
        if (!$Place) {
            return back()->withErrors('Place Code Not Found !');
        }

        return view('Pages.Management.Master.place.edit', compact('Place'));
    }

    // (3) This Func for admin to get all place deleted by admin or a users has blocked by admin
    function indexDeletedPlace(Request $request)
    {
        if (Auth::user()->hasRole('superadmin')) {
            $data = Place::whereNotNull('deleted_at')->withTrashed()->select('id', 'place_code', 'title', 'description', 'creator_id', 'created_at', 'updated_at')->with('creator_id')->latest()->get();
        } else {
            $data = Place::whereNotNull('deleted_at')->withTrashed()->select('id', 'place_code', 'title', 'description', 'creator_id', 'created_at', 'updated_at')->with('creator_id')->where('creator_id', Auth::user()->id)->latest()->get();
        }

        if ($request->ajax()) {
            return DataTables::of($data)
                ->editColumn('updated_at', function ($row) {
                    return \Carbon\Carbon::parse($row->updated_at)->format('d-M-Y H:i:s') . ' Wita';
                })
                ->make(true);
        }

        return view('Pages.Management.Master.place.deleted');
    }
    // (4) To Show Pages For user to create new posts/place
    function indexCreatePlace()
    {
        if (!Auth::user()->hasRole('superadmin')) {
            if (Auth::user()->approved_at) {
                $checkTheLimitOfUserPlace = UserHasPlaceLimit::where('user_id', Auth::user()->id)->with('placeLimit')->first();
                if($checkTheLimitOfUserPlace){
                    if(Place::where('creator_id', Auth::user()->id)->count() <= $checkTheLimitOfUserPlace->placeLimit->total_limit){
                        return view('Pages.Management.Master.place.form');
                    }else{
                        return redirect()->route('dashboard')->withErrors('Your account place has entered the limit !');
                    }
                }else{
                    $Place = Place::where('creator_id', Auth::user()->id)->latest()->first();
    
                    if ($Place) {
                        $url = $this->applicationURLLocal . '/detail-place/' . $Place->place_code;
                        $printUrl = $this->applicationURLLocal . '/management/master/print-barcode/' . $Place->place_code;
        
                        return view('Pages.Management.Master.my-place.index', compact('Place', 'url', 'printUrl'));
                    } else {
                        $Place = null;
                        $url = '#';
                        $printUrl = '#';
                        return view('Pages.Management.Master.my-place.index', compact('Place', 'url', 'printUrl'));
                    }
                }
            }else {
                return back()->withErrors('Your Account Need Approval First !');
            }   

        }else{
            return view('Pages.Management.Master.place.form');
        }

        
    }
    // (5) For admin to delete place user, after do this delete, the user can create a new place, like new account approved
    function deletePlace($place_code)
    {
        $GetPlace = Place::where('place_code', $place_code)->with('creator_id')->first();

        if (!Auth::user()->hasRole('superadmin')) {
            if ($GetPlace->creator_id !== Auth::user()->id) {
                return response()->json([
                    'errors' => 'You dont have access to this !'
                ]);
            }

            $GetPlace->delete();
            
            $commentData = Comment::where('place_id', $GetPlace->id)->get();

            foreach ($commentData as $key => $comment) {
                $commentData[$key]->delete();
            }

        } else {
            $GetPlace->delete();
            $commentData = Comment::where('place_id', $GetPlace->id)->get();

            foreach ($commentData as $key => $comment) {
                $commentData[$key]->delete();
            }
        }

        return response()->json([
            'success' => 'Delete Success !'
        ]);
    }

    // (6) Return View For User Approved
    function returnMyPlaceView(Request $request)
    {
        if (Auth::user()->approved_at) {
            $Place = Place::where('creator_id', Auth::user()->id)->latest()->first();

            if ($Place) {
                $url = $this->applicationURLLocal . '/detail-place/' . $Place->place_code;
                $printUrl = $this->applicationURLLocal . '/management/master/print-barcode/' . $Place->place_code;

                return view('Pages.Management.Master.my-place.index', compact('Place', 'url', 'printUrl'));
            } else {
                $Place = null;
                $url = '#';
                $printUrl = '#';
                return view('Pages.Management.Master.my-place.index', compact('Place', 'url', 'printUrl'));
            }
        } else {
            return back()->withErrors('Your Account Need Approval First !');
        }
    }

    // (7) Update Place Data With Place Code For user approved
    function updatePlace(Request $request)
    {
        if (!Auth::user()->approved_at) {
            return back()->withErrors('Your Account Need Approval First !');
        }

        $Validate = $request->validate(
            [
                'title' => 'required',
                'description' => 'required',
                'content' => 'required'
            ],
            [
                'title.required' => 'Title Fields is required',
                'description.required' => 'Description is required',
                'content.required' => 'Content is required',
            ]
        );

        if ($request->id) {
            if(Auth::user()->hasRole('superadmin')){
                $Place = Place::where('id', $request->id)->first();
            }else{
                $Place = Place::where('id', $request->id)->where('creator_id', Auth::user()->id)->first();
                if(!$Place){
                    return abort(404);
                }
            }
        } else {
            $Place = Place::where('creator_id', Auth::user()->id)->latest()->first();
        }

        // $GetCurrentImage = Image::where('place_id', $Place->id)->get();
        // if ($GetCurrentImage) {
        //     foreach ($GetCurrentImage as $key => $img) {
        //         $image = $GetCurrentImage[$key]->src;
        //         $updatedImages = str_replace('/storage/', '', $image);

        //         if (Storage::disk('public')->exists($updatedImages)) {
        //             Storage::disk('public')->delete($updatedImages);
        //         }

        //         $GetCurrentImage[$key]->delete();
        //     }
        // }

        $dom = new DOMDocument();
        $content = $request->content;

        $dom->loadHtml($content, 9);

        $images = $dom->getElementsByTagName('img');
        $imageData = [];

        $user_id = Auth::user()->id;
        // Setup Images
        if ($images) {
            foreach ($images as $key => $img) {
                $data = $img->getAttribute('src');

                if (strpos($data, 'data') !== false) {
                    list($type, $data) = array_pad(explode(';', $data), 2, null);
                    list(, $data) = array_pad(explode(',', $data), 2, null);
                    $dataConvert = base64_decode($data);

                    $str = $img->getAttribute('src');
                    $trim = Str::after($str, 'image/');
                    $trim2 = Str::before($trim, ';');

                    // Generate a unique image name
                    $image_name = time() . '-' . $key . Str::random(10) . '.' . $trim2;


                    // Define the path for storing the image
                    $path = "public/UploadImage/PlaceImage/{$Place->id}/" . $image_name;

                    // Store the file using the Storage facade
                    Storage::put($path, $dataConvert);

                    // Generate the public URL for the image
                    $publicUrl = Storage::url($path);

                    // Remove the src attribute and set the new src
                    $img->removeAttribute('src');
                    $img->setAttribute('src', $publicUrl);

                    // Store the public URL in the array
                    $imageData[] = $publicUrl;
                }
            }
        }


        $content = $dom->saveHTML();

        $Place->title = $request->title;
        $Place->description = $request->description;
        $Place->content = $content;
        $Place->is_comment = $request->AllowComment == 'on' ? 1 : 0;
        $Place->update();


        foreach ($imageData as $img) {
            Image::create([
                'description' => '-',
                'place_id' => $Place->id,
                'src' => $img
            ]);
        }

        return back()->with('success', 'Data SuccesFully Saved !');
    }

    // (8) This function Is used to store data while user/admin create new place data
    function store(Request $request)
    {
        // Check Authentication
        if (!Auth::user()->approved_at) {
            return back()->withErrors('Your Account Need Approval First !');
        }
        if(!Auth::user()->hasRole('superadmin')){
            $checkTheLimitOfUserPlace = UserHasPlaceLimit::where('user_id', Auth::user()->id)->with('placeLimit')->first();
            if($checkTheLimitOfUserPlace){
                if(Place::where('creator_id', Auth::user()->id)->count() >= $checkTheLimitOfUserPlace->placeLimit->total_limit){
                    return back()->withErrors('Your account place has entered the limit !');
                }
            }else{
                $Place = Place::where('creator_id', Auth::user()->id)->first();
                if($Place){
                    return back()->withErrors('You have created place !');
                }
            }
        }

        $Validate = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'content' => 'required'
        ], [
            'title.required' => 'Title Fields is required',
            'description.required' => 'Description is required',
            'content.required' => 'Content is required',
        ]);



        $getPlaceData = Place::latest()->first() !== null ? Place::select('id')->latest()->first()->id + 1 : 1;
        $convertedCode = sprintf('%05d', $getPlaceData);

        // Start Setup images
        $dom = new DOMDocument();
        $content = $request->content;

        $dom->loadHtml($content, 9);

        $images = $dom->getElementsByTagName('img');
        $imageData = [];

        $user_id = Auth::user()->id;

        // Setup Images
        if ($images) {
            foreach ($images as $key => $img) {
                $data = $img->getAttribute('src');

                if (strpos($data, 'data') !== false) {
                    list($type, $data) = array_pad(explode(';', $data), 2, null);
                    list(, $data) = array_pad(explode(',', $data), 2, null);
                    $dataConvert = base64_decode($data);

                    $str = $img->getAttribute('src');
                    $trim = Str::after($str, 'image/');
                    $trim2 = Str::before($trim, ';');

                    // Generate a unique image name
                    $image_name = time() . '-' . $key . Str::random(10) . '.' . $trim2;

                    // Store the image in the storage path
                    $path = "public/UploadImage/PlaceImage/{$user_id}/" . $image_name;

                    // Store the file
                    Storage::put($path, $dataConvert);

                    // Generate the public URL for the image
                    $publicUrl = Storage::url($path);

                    // Update the image src
                    $img->removeAttribute('src');
                    $img->setAttribute('src', $publicUrl);

                    $imageData[] = $publicUrl; // Store the public URL instead of the path
                }
            }
        }


        $content = $dom->saveHTML();

        $Place = Place::create([
            'place_code' => time() . $convertedCode,
            'title' => $request->title,
            'description' => $request->description,
            'creator_id' => $user_id,
            'content' => $content,
            'views' => 0,
            'is_comment' => $request->AllowComment == 'on' ? 1 : 0
        ]);

        foreach ($imageData as $img) {
            Image::create([
                'description' => '-',
                'place_id' => $Place->id,
                'src' => $img
            ]);
        }

        return back()->with('success', 'Data SuccesFully Created !');
    }
    // (9) This function is to get JsonFileData From Place selected
    function getDetailPlaceData($place_code)
    {
        $Place = Place::with('creator_id')->where('place_code', $place_code)->first();

        if (!$Place) {
            return response()->json([
                'message' => 'Place Not Found !'
            ], 404);
        }

        $Event = Event::select('id')->where('place_id', $Place->id)->get();

        return response()->json([
            'data' => $Place,
            'total_event' => $Event->count() ? $Event->count() : 0,
            'event' => $Event ? $Event : null
        ]);
    }

    // (10) This function is used to get detail place for public user to see the detail of the place
    function getDetailPlace($place_code)
    {
        $place = Place::where('place_code', $place_code)->first();
        if (!$place) {
            return redirect()->route('dashboard');
        }

        if ($place->deleted_at) {
            return redirect()->route('dashboard')->withErrors('This Place has been deleted !');
        }

        if (!session()->has('views')) {
            session(['views' => []]);
        }

        // If the post hasn't been viewed yet, add it to the session
        if (!in_array($place_code, session('views'))) {
            session()->push('views', $place_code);
            $place->increment('views');
        }


        $ValidEvent = [];

        $event = Event::where('place_id', $place->id)->get();
        foreach ($event as $evnt) {
            $expirydate = \Carbon\Carbon::parse($evnt->date);
            $today = \Carbon\Carbon::now();
            $difference = $today->diffInDays($expirydate, false);

            if ($difference >= 0) {
                $ValidEvent[] = $evnt;
            }
        }

        if ($ValidEvent) {
            $event = $ValidEvent;
        } else {
            $event = [];
        }

        return view('Pages.detail-place.index', compact('place', 'event'));
    }


    // (11) This function is used to print qrcode by admin
    function print($placeCode)
    {
        $place = Place::where('place_code', $placeCode)->first();
        $printUrl = $this->applicationURLLocal . '/detail-place/' . $place->place_code;

        if (!$place) {
            return back()->withErrors('Place Code Not Found !');
        }
        return view('Pages.Management.Master.print-barcode.index', compact('place', 'printUrl'));
    }

    function fetchAll()
    {
        if(Auth::user()->hasRole('superadmin')){
            $placeData = Place::select('id', 'place_code', 'title')->get();
        }else{
            $placeData = Place::where('creator_id', Auth::user()->id)->select('id', 'place_code', 'title')->get();
        }

        return response()->json([
            'data' => $placeData
        ]);
    }
}
