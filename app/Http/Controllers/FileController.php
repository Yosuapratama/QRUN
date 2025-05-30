<?php

namespace App\Http\Controllers;

use App\Models\CustomAdsSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller
{
    public function uploadFile(Request $request)
    {

        $rules = [
            'pdf' => 'required|mimes:pdf|max:10240', // Limit to 10MB
        ];

        // Create a validator instance
        $validator = Validator::make($request->all(), $rules);

        // Check if validation fails
        if ($validator->fails()) {
            // You can handle validation failure in this block
            return response()->json([
                'error' => $validator->errors()->first() // Return the first validation error
            ], 422); // 422 Unprocessable Entity is a common HTTP status for validation errors
        }

        // Store the uploaded PDF in a public disk (storage/app/public)
        if ($request->hasFile('pdf')) {
            $pdf = $request->file('pdf');

            $user_id = Auth::user()->id;

            // Define the file path in the public directory (accessible via URL)
            $path = "pdfs/{$user_id}/" . time() . '_' . $pdf->getClientOriginalName();

            // Define the directory where you want to store the PDF (in the public folder)
            $publicPath = public_path($path);

            // Check if the directory exists, if not, create it
            if (!file_exists(dirname($publicPath))) {
                mkdir(dirname($publicPath), 0755, true);
            }

            // Store the file using move() instead of file_put_contents
            $pdf->move(dirname($publicPath), basename($publicPath));

            // The path will be relative to the public directory
            // $pdfUrl = "storage/{$path}";

            // Return the file URL
            return response()->json(['url' => url($path)]);
        }

        return response()->json(['error' => 'No file uploaded'], 200);
    }

    function uploadImageAds(Request $request)
    {

        $rules = [
            'pdf' => 'mimes:png,jpg,jpeg,gif,webp|max:10240', // Limit to 10MB
        ];

        // Create a validator instance
        $validator = Validator::make($request->all(), $rules);

        // create db entry
        $customAds = CustomAdsSettings::first();


        // get dropzone image
        if ($request->file('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();

            $path = "image_ads/" . time() . '_' . $file->getClientOriginalName();

            // Define the directory where you want to store the PDF (in the public folder)
            $publicPath = public_path($path);

            $file->move(dirname($publicPath), basename($publicPath));

            $customAds->update([
                'image_url' => $path
            ]);
        }

        // return the result
        return response()->json($customAds);
    }

    function uploadImageAdsPlace(Request $request)
    {
        $request->validate([
            'file' => 'mimes:png,jpg,jpeg,gif,webp|max:5000'
        ]);

        if ($request->file('file')) {
            $file = $request->file('file');

            $path = "image_ads_by_place/" . time() . '_' . $file->getClientOriginalName();

            // Define the directory where you want to store the PDF (in the public folder)
            $publicPath = public_path($path);

            $file->move(dirname($publicPath), basename($publicPath));
        }

        // return the result
        return response()->json(["image_url" => $path])->header('Content-Type', 'application/json');;
    }

    function uploadImageGallery(Request $request)
    {
        $request->validate([
            'file' => 'mimes:png,jpg,jpeg,gif,webp|max:5000'
        ]);

        if ($request->file('file')) {
            $file = $request->file('file');

            $path = "gallery/" . time() . '_' . $file->getClientOriginalName();

            // Define the directory where you want to store the PDF (in the public folder)
            $publicPath = public_path($path);

            $file->move(dirname($publicPath), basename($publicPath));
        }

        // return the result
        return response()->json(["image_url" => $path])->header('Content-Type', 'application/json');;
    }
}
