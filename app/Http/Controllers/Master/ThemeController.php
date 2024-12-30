<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;


class ThemeController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            // Fetch data from the Theme model
            $themes = Theme::select('id', 'name', 'description', 'status');

            // Return DataTables response
            return DataTables::of($themes)
                ->addColumn('action', function($row) {
                    // Edit Button with Tailwind CSS styling
                    $editButton = '<button type="button" class="px-4 py-2 bg-blue-500 text-white rounded-md text-sm hover:bg-blue-600 edit-theme" data-id="' . $row->id . '" data-name="' . $row->name . '">Edit</button>';

                    // Delete Button with Tailwind CSS styling
                    $deleteButton = '<button type="button" class="px-4 py-2 bg-red-500 text-white rounded-md text-sm hover:bg-red-600 delete-theme" data-id="' . $row->id . '" data-name="' . $row->name . '">Delete</button>';

                    return $editButton . ' ' . $deleteButton;
                })
                ->addColumn('status', function($row) {
                    // Display status with Tailwind CSS styled badges
                    if ($row->status == 1) {
                        return '<span class="inline-block px-3 py-1 text-sm font-medium text-white bg-green-500 rounded-full">Enabled</span>';
                    } else {
                        return '<span class="inline-block px-3 py-1 text-sm font-medium text-white bg-red-500 rounded-full">Disabled</span>';
                    }
                })
                ->rawColumns(['action', 'status']) // Allow HTML rendering in the columns
                ->make(true);
        }

        return view('master.themes.index'); // Return view for the index page
    }


    public function store(Request $request)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'themeName' => 'required|string|max:255',
            'themeDescription' => 'required|string|max:500',
        ]);

        // Store the theme in the database
        $theme = new Theme();
        $theme->name = $validatedData['themeName'];
        $theme->description = $validatedData['themeDescription'];
        $theme->status = true;
        $theme->save();

        // Return a JSON response on success
        return response()->json(['message' => 'Theme created successfully!']);
    }

    public function edit($id)
    {
        $theme = Theme::findOrFail($id);
    
        // Return only necessary fields for the modal
        return response()->json($theme); // Kembalikan data dalam bentuk JSON

    }
    

    public function update(Request $request, $id)
    {
        $theme = Theme::findOrFail($id);
        
        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);
        
        // Update the theme data
        $theme->name = $request->name;
        $theme->description = $request->description;
        $theme->status = $request->status;
        $theme->save();
        
        return response()->json(['message' => 'Theme updated successfully']);
    }

    public function destroy($id)
    {
        // Temukan theme berdasarkan ID
        $theme = Theme::findOrFail($id);

        // Periksa apakah ada media terkait dengan theme tersebut dan hapus file mereka
        $theme->media()->each(function ($media) {
            // Tentukan path lengkap ke file media
            $filePath = public_path('storage/media_files/' . $media->file_path);

            // Periksa apakah file terkait ada dan hapus file menggunakan unlink
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Hapus media dari database
            $media->delete();
        });

        // Hapus theme dari database
        $theme->delete();

        // Kembalikan respons JSON
        return response()->json(['message' => 'The theme and its associated media have been deleted successfully.']);
    }


}
