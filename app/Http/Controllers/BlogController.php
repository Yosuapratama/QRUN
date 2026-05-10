<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\CustomAdsSettings;
use App\Models\CustomRunningTextSettings;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Image;
use App\Models\Event;
use App\Models\LogActivities;
use App\Models\UserHasPlaceLimit;
use DOMDocument;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
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

        // Check Authentication
        if (!Auth::user()->approved_at) {
            return back()->withErrors('Your Account Need Approval First !');
        }
        if (!Auth::user()->hasRole('superadmin')) {
            return abort(403);
        }
    }

    // (1) Place Index Menu, on sidenav this menu call ManagePlace
    function index(Request $request)
    {
        $data = Blog::select('id', 'slug', 'title', 'description', 'creator_id')->with('creator_id')->latest()->get();

        if ($request->ajax()) {
            return DataTables::of($data)
                ->editColumn('updated_at', function ($row) {
                    return \Carbon\Carbon::parse($row->updated_at)->format('d-M-Y H:i:s');
                })
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // $url = $this->applicationURLLocal . '/detail-place/' . $row->place_code;
                    $editUrl = $this->applicationURLLocal . '/management/master/blog/' . $row->id . '/edit';
                    // $printUrl = $this->applicationURLLocal . '/management/master/print-barcode/' . $row->place_code;

                    $btn = "<div class='d-flex'>";
                    // $btn = $btn . "<button id='$row->place_code' class='detailPlaceButton btn btn-primary btn-sm mr-1'>Detail</button>";
                    // $btn = $btn . "<a target='_blank' href='$url' class='btn btn-warning btn-sm mr-1'>Visit</a>";
                    $btn = $btn . "<a target='_blank' href='$editUrl' class='btn btn-secondary btn-sm mr-1'>Edit</a>";
                    // $btn = $btn . "<a target='_blank' href='$printUrl' class='btn btn-success btn-sm mr-1'>Print</a>";
                    $btn = $btn . "<button id='$row->id' class='delete btn btn-danger btn-sm mr-1'>Delete</button>";

                    $btn = $btn . "</div>";
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }


        return view('Pages.Management.Master.blog.index');
    }
    // (2) This Func For Superadmin to edit users place
    function edit($id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return back()->withErrors('Blog Not Found !');
        }

        return view('Pages.Management.Master.blog.form', compact('blog'));
    }

    function create()
    {
        return view('Pages.Management.Master.blog.form', [
            'blog' => null,
        ]);
        // 
    }
    // (5) For admin to delete place user, after do this delete, the user can create a new place, like new account approved
    function destroy($id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return back()->withErrors('Blog Not Found !');
        }

        if (!Auth::user()->hasRole('superadmin')) {
            if ($blog->creator_id !== Auth::user()->id) {
                return response()->json([
                    'errors' => 'You dont have access to this !'
                ]);
            }
        }

        $blog->delete();

        LogActivities::create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'user_id' => Auth::user()->id,
            'activities' => "User Deleted Blog Data with id : " . $blog->id . " at " . Carbon::now()->format('Y-m-d H:i:s'),
            "type" => LogActivities::TYPE_DELETE_BLOG
        ]);

        return response()->json([
            'success' => 'Delete Success !'
        ]);
    }

    // (7) Update Place Data With Place Code For user approved
    function update(Request $request)
    {
        if (!Auth::user()->approved_at) {
            return back()->withErrors('Your Account Need Approval First !');
        }

        $Validate = $request->validate(
            [
                'title' => 'required',
                'description' => 'required',
                'content' => 'required',
                'image_url' => 'required',
                'slug' => 'required|unique:blogs,slug,' . $request->id ?? null
            ],
            [
                'title.required' => 'Title Fields is required',
                'description.required' => 'Description is required',
                'content.required' => 'Content is required',
            ]
        );

        // dd($request->id);

        if ($request->id) {
            if (Auth::user()->hasRole('superadmin')) {
                $Blog = Blog::where('id', $request->id)->first();
            } else {
                $Blog = Blog::where('id', $request->id)->where('creator_id', Auth::user()->id)->first();
                if (!$Blog) {
                    return abort(404);
                }
            }
        } else {
            $Blog = Blog::where('creator_id', Auth::user()->id)->latest()->first();
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

                    // Define the directory and path for storing the image
                    $directory = public_path() . "/UploadImage/BlogImages/{$Blog->id}/";
                    if (!file_exists($directory)) {
                        mkdir($directory, 0755, true);
                    }

                    $path = $directory . $image_name; // Full path to the file

                    // Store the file using file_put_contents
                    $menu = file_put_contents($path, $dataConvert);
                    if ($menu === false) {
                        throw new Exception('Failed to save the image.');
                    }

                    // Generate the public URL for the image
                    $publicUrl = asset("UploadImage/BlogImages/{$Blog->id}/" . $image_name);

                    // Remove the src attribute and set the new src
                    $img->removeAttribute('src');
                    $img->setAttribute('src', $publicUrl);

                    // Store the public URL in the array
                    $imageData[] = $publicUrl;
                }
            }
        }


        $content = $dom->saveHTML();

        $Blog->title = $request->title;
        $Blog->slug = Str::slug($request->slug);
        $Blog->description = $request->description;
        $Blog->content = $content;
        $Blog->is_published = $request->is_published == 'on' ? 1 : 0;
        $Blog->image_url = $request->image_url;

        $Blog->update();


        LogActivities::create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'user_id' => Auth::user()->id,
            'activities' => "User Updated Blog Data with id : " . $Blog->id . " at " . Carbon::now()->format('Y-m-d H:i:s'),
            "type" => LogActivities::TYPE_UPDATE_BLOG
        ]);
        return back()->with('success', 'Data SuccesFully Saved !');
    }

    // (8) This function Is used to store data while user/admin create new place data
    function store(Request $request)
    {

        $Validate = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'content' => 'required',
            'image_url' => 'required',
            'slug' => 'required|unique:blogs,slug,' . $request->id ?? null
        ], [
            'title.required' => 'Title Fields is required',
            'description.required' => 'Description is required',
            'content.required' => 'Content is required',
        ]);
        // dd($request->all());
        // Start Setup images
        $dom = new DOMDocument();
        $content = $request->content;

        $dom->loadHtml($content, 9);

        $images = $dom->getElementsByTagName('img');
        $imageData = [];

        $user_id = Auth::user()->id;
        $Blog_id = Blog::latest()->first()?->id == null ? 1 : Blog::latest()->first()->id + 1;

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
                    // $path = "public/UploadImage/PlaceImage/{$Place_id}/" . $image_name;

                    // Store the file
                    // Storage::put($path, $dataConvert);

                    // // Generate the public URL for the image
                    // $publicUrl = Storage::url($path);

                    $directory = public_path() . "/storage/UploadImage/BlogImages/{$Blog_id}/";
                    if (!file_exists($directory)) {
                        mkdir($directory, 0755, true);
                    }

                    $path = $directory . $image_name; // Full path to the file

                    // Store the file using file_put_contents
                    $menu = file_put_contents($path, $dataConvert);
                    if ($menu === false) {
                        throw new Exception('Failed to save the image.');
                    }

                    // Generate the public URL for the image
                    $publicUrl = asset("/storage/UploadImage/BlogImages/{$Blog_id}/" . $image_name);



                    // Update the image src
                    $img->removeAttribute('src');
                    $img->setAttribute('src', $publicUrl);

                    $imageData[] = $publicUrl; // Store the public URL instead of the path
                }
            }
        }


        $content = $dom->saveHTML();
        // dd($request->reg_province);

        $Blog = Blog::create([
            'slug' => Str::slug($request->slug),
            'title' => $request->title,
            'description' => $request->description,
            'creator_id' => $user_id,
            'content' => $content,
            'views' => 0,
            'is_published' => $request->is_published == "on" ? 1 : 0,
            'image_url' => $request->image_url
        ]);



        LogActivities::create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'user_id' => Auth::user()->id,
            'activities' => "User Created Blog Data with id : " . $Blog->id . " at " . Carbon::now()->format('Y-m-d H:i:s'),
            "type" => LogActivities::TYPE_CREATE_BLOG
        ]);


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
        $place = Place::with('province', 'regency', 'district')->where('place_code', $place_code)->first();
        if (!$place) {
            return redirect()->route('homes')->withErrors('Place Not Found !');
        }

        if ($place->deleted_at) {
            return redirect()->route('homes')->withErrors('This Place has been deleted !');
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

        $customSettingRunningText = CustomRunningTextSettings::first();
        $customSettingAds = CustomAdsSettings::first();

        $ads = $place->advertises->first();
        // dd($place);
        return view('Pages.detail-place.index', compact('place', 'event', 'customSettingRunningText', 'customSettingAds', 'ads'));
    }
}
