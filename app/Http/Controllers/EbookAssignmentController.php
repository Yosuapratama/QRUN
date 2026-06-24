<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use App\Models\EbookPlace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EbookAssignmentController extends Controller
{
    public function __construct()
    {
        if (!Auth::check() || !Auth::user()->approved_at || !Auth::user()->hasRole('superadmin')) {
            abort(403);
        }
    }

    /**
     * Central page to assign ebooks to a location.
     */
    public function index()
    {
        return view('Pages.Management.Master.ebook-assignment.index', [
            'locations' => EbookPlace::orderBy('name')->get(['id', 'name', 'code']),
            'ebooks' => Ebook::orderBy('title')->get(['id', 'title', 'author', 'category', 'image_url', 'created_at']),
        ]);
    }

    /**
     * AJAX: assigned ebook ids for a given location.
     */
    public function show($id)
    {
        $location = EbookPlace::find($id);

        if (!$location) {
            return response()->json(['message' => 'Location not found'], 404);
        }

        return response()->json([
            'ebook_ids' => $location->ebooks()->pluck('ebooks.id'),
        ]);
    }

    /**
     * Sync the ebooks assigned to a location.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ebook_place_id' => 'required|exists:ebook_places,id',
        ]);

        $location = EbookPlace::findOrFail($request->ebook_place_id);
        $location->ebooks()->sync($request->ebooks ?? []);

        $message = 'Assignment for "' . $location->name . '" saved!';

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => $message,
                'count' => count($request->ebooks ?? []),
            ]);
        }

        return redirect()->route('ebook-assignment.index')->with('success', $message);
    }
}
