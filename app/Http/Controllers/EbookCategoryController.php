<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use App\Models\EbookCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EbookCategoryController extends Controller
{
    public function __construct()
    {
        if (!Auth::check() || !Auth::user()->approved_at || !Auth::user()->hasRole('superadmin')) {
            abort(403);
        }
    }

    public function index()
    {
        $categories = EbookCategory::orderBy('name')->get();

        // Count how many ebooks use each category (category stored as name string).
        $counts = Ebook::selectRaw('category, COUNT(*) as total')
            ->whereNotNull('category')
            ->groupBy('category')
            ->pluck('total', 'category');

        return view('Pages.Management.Master.ebook-category.index', compact('categories', 'counts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:ebook_categories,name',
        ]);

        EbookCategory::create(['name' => trim($request->name)]);

        return back()->with('success', 'Category Created Successfully !');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:ebook_categories,name,' . $request->id,
        ]);

        $category = EbookCategory::find($request->id);

        if (!$category) {
            return back()->withErrors('Category Not Found !');
        }

        $oldName = $category->name;
        $newName = trim($request->name);

        $category->name = $newName;
        $category->save();

        // Keep already-tagged ebooks in sync with the renamed category.
        Ebook::where('category', $oldName)->update(['category' => $newName]);

        return back()->with('success', 'Category Updated Successfully !');
    }

    public function destroy($id)
    {
        $category = EbookCategory::find($id);

        if (!$category) {
            return response()->json(['errors' => 'Category Not Found !']);
        }

        $category->delete();

        return response()->json(['success' => 'Delete Success !']);
    }
}
