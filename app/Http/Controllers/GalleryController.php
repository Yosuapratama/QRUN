<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\LogActivities;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Gallery::latest()->get();

            return Datatables::of($data)
                ->editColumn('updated_at', function ($row) {
                    return \Carbon\Carbon::parse($row->updated_at)->format('d-M-Y H:i:s');
                })
                ->editColumn('image_url', function ($row) {
                    return "<img loading='lazy' src='" . asset($row->image_url) . "' width='100px'>";
                })
                ->addColumn('status', function ($row) {
                    // return $row->is_active ? 'Active' : 'Inactive';
                    // update the status using button url
                    // return "<button class='btn btn-sm " . ($row->is_active ? 'btn-success' : 'btn-danger') . "' onclick='toggleStatus(" . $row->id . ")'>" . ($row->is_active ? 'Active' : 'Inactive') . "</button>"; 
                    //gunakan switch button
                    return "<label class='switch'>
                                <input type='checkbox' " . ($row->is_active ? 'checked' : '') . " onclick='toggleStatus(" . $row->id . ")'>
                                <span class='slider round'></span>
                            </label>";
                })
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $editUrl = route('gallery.edit', $row->id);

                    return "
        <div class='dropdown'>
            <button 
                class='btn btn-primary btn-sm dropdown-toggle shadow-sm'
                type='button'
                data-toggle='dropdown'
                aria-expanded='false'
            >
                <i class='fas fa-cog mr-1'></i>
                Action
            </button>

            <div class='dropdown-menu dropdown-menu-right shadow animated--fade-in'>

                <a 
                    href='{$editUrl}'
                    class='dropdown-item'
                >
                    <i class='fas fa-edit text-secondary mr-2'></i>
                    Edit
                </a>

                <div class='dropdown-divider'></div>

                <button 
                    id='{$row->id}'
                    class='delete dropdown-item text-danger'
                    type='button'
                >
                    <i class='fas fa-trash-alt mr-2'></i>
                    Delete
                </button>

            </div>
        </div>
    ";
                })
                ->rawColumns(['action', 'image_url', 'status'])
                ->make(true);
        }


        return view('Pages.Management.Master.gallery.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Pages.Management.Master.gallery.form', [
            'gallery' => null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image_url' => 'required',
        ]);

        if ($request->id) {
            $gallery = Gallery::findOrFail($request->id);  // Find the existing galleryvertise record or fail if not found
            if (!$gallery) {
                return redirect()->route('gallery.index')->withErrors('Gallery data not found !');
            }

            LogActivities::create([
                'ip_address' => request()->ip(),
                'user_agent' => request()->header('User-Agent'),
                'user_id' => Auth::user()->id,
                'activities' => "User update data with gallery id = " . $gallery->id . " at " . Carbon::now()->format('Y-m-d H:i:s'),
                "type" => LogActivities::TYPE_UPDATE_GALLERY
            ]);
        } else {
            $gallery = new Gallery;  // Create a new galleryvertise instance if no ID is provided

            LogActivities::create([
                'ip_address' => request()->ip(),
                'user_agent' => request()->header('User-Agent'),
                'user_id' => Auth::user()->id,
                'activities' => "User create data with gallery id = " . $gallery->id . " at " . Carbon::now()->format('Y-m-d H:i:s'),
                "type" => LogActivities::TYPE_CREATE_GALLERY
            ]);
        }


        $gallery->title = $request->title;
        $gallery->image_url = $request->image_url;
        $gallery->save();

        return back()->with('success', 'Gallery saved successfully !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Gallery::findOrFail($id); // Find the gallery by ID or fail if not found
        if (!$data) {
            return redirect()->route('gallery.index')->withErrors('Gallery data not found !');
        }

        return view('Pages.Management.Master.gallery.form', [
            'gallery' => $data,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Gallery::findOrFail($id); // Find the gallery by ID or fail if not found
        if (!$data) {
            return redirect()->route('gallery.index')->withErrors('Gallery data not found !');
        }

        return view('Pages.Management.Master.gallery.form', [
            'gallery' => $data,
        ]);
    }

    public function toggleStatus(Request $request, string $id)
    {
        $gallery = Gallery::findOrFail($id); // Find the gallery by ID or fail if not found
        if (!$gallery) {
            return response()->json(['error' => 'Gallery data not found !'], 404);
        }

        $gallery->is_active = !$gallery->is_active; // Toggle the status
        $gallery->save();

        return response()->json(['success' => 'Update Successfully !']);
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
        $gallery = Gallery::findOrFail($id); // Find the gallery by ID or fail if not found
        if (!$gallery) {
            return redirect()->route('gallery.index')->withErrors('Gallery data not found !');
        }

        $gallery->delete(); // Soft delete the gallery

        LogActivities::create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'user_id' => Auth::user()->id,
            'activities' => "User delete data with gallery id = " . $gallery->id . " at " . Carbon::now()->format('Y-m-d H:i:s'),
            "type" => LogActivities::TYPE_DELETE_GALLERY
        ]);

        return response()->json([
            'success' => 'Data deleted successfully !'
        ]);

        // return redirect()->route('gallery.index')->with('success', 'Gallery deleted successfully !');
    }

    public function ajaxList(Request $request)
    {
        $perPage = 8;
        $page = $request->get('page', 1);

        $query = Gallery::where('is_active', 1)->orderBy('created_at', 'desc');
        $galleries = $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'data' => $galleries->items(),
            'next_page' => $galleries->currentPage() < $galleries->lastPage() ? $galleries->currentPage() + 1 : null,
        ]);
    }
}
