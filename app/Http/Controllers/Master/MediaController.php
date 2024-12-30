<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;


class MediaController extends Controller
{
    public function index()
    {
        $themes = Theme::select('id', 'name')->where('status',1)->get();

        if (request()->ajax()) {
            // Fetch data from Media model with related Theme
            $media = Media::with('theme') // Load the related Theme model
                ->select('id', 'theme_id', 'type', 'file_path', 'name', 'description', 'status');

            // Return DataTables response
            return DataTables::of($media)
                ->addColumn('action', function ($row) {
                    // Edit Button with Tailwind CSS styling
                    $editButton = '<button type="button" class="px-4 py-2 bg-blue-500 text-white rounded-md text-sm hover:bg-blue-600 edit-media" data-id="' . $row->id . '" data-name="' . $row->name . '">Edit</button>';

                    // Delete Button with Tailwind CSS styling
                    $deleteButton = '<button type="button" class="px-4 py-2 bg-red-500 text-white rounded-md text-sm hover:bg-red-600 delete-media" data-id="' . $row->id . '" data-name="' . $row->name . '">Delete</button>';

                    return $editButton . ' ' . $deleteButton;
                })
                ->addColumn('status', function ($row) {
                    // Display status with Tailwind CSS styled badges
                    return $row->status == 1
                        ? '<span class="inline-block px-3 py-1 text-sm font-medium text-white bg-green-500 rounded-full">Enabled</span>'
                        : '<span class="inline-block px-3 py-1 text-sm font-medium text-white bg-red-500 rounded-full">Disabled</span>';
                })
                ->addColumn('file', function ($row) {
                    $fileUrl = asset('storage/media_files/' . $row->file_path); // Buat URL file
                    if ($row->type === 'image') {
                        // Render HTML untuk menampilkan gambar
                        return '<img src="' . $fileUrl . '" alt="' . $row->name . '" class="w-16 h-16 rounded">';
                    } else {
                        return '<a href="' . $fileUrl . '" target="_blank" class="text-blue-500 underline">View File</a>';
                    }
                })                            
                ->addColumn('theme', function ($row) {
                    // Display related theme name if available
                    return $row->theme ? $row->theme->name : '<span class="text-gray-500">No theme assigned</span>';
                })
                ->rawColumns(['action', 'status', 'file', 'theme']) // Allow HTML rendering in these columns
                ->make(true);
        }

        return view('master.media.index', compact('themes')); // Return view for the index page
    }

    
    public function store(Request $request)
    {
        // Validasi data input
        $validatedData = $request->validate([
            'mediaName' => 'required|string|max:255',
            'mediaDescription' => 'required|string|max:500',
            'mediaType' => 'required|string|in:image,sound,video',
            'mediaFile' => [
                'required',
                'file',
                'max:20240', // Maksimum 10 MB
                function ($attribute, $value, $fail) use ($request) {
                    $allowedMimeTypes = [
                        'image' => ['jpeg', 'png', 'jpg', 'gif', 'webp'],
                        'sound' => ['mp3', 'wav', 'ogg'],
                        'video' => ['mp4', 'mov', 'avi', 'mkv'],
                    ];

                    $mediaType = $request->mediaType;

                    if (isset($allowedMimeTypes[$mediaType])) {
                        $validator = \Validator::make(
                            [$attribute => $value],
                            [$attribute => 'mimes:' . implode(',', $allowedMimeTypes[$mediaType])]
                        );

                        if ($validator->fails()) {
                            $fail("The $attribute must be a valid $mediaType file.");
                        }
                    } else {
                        $fail("Invalid media type selected.");
                    }
                },
            ],
            'mediaTheme' => 'nullable|exists:theme,id',
        ]);

        // Save file to storage
        $filePath = $request->file('mediaFile')->store('media_files', 'public');
        $fileName = basename($filePath);
        // Save data to database
        $media = new Media();
        $media->name = $validatedData['mediaName'];
        $media->description = $validatedData['mediaDescription'];
        $media->type = $validatedData['mediaType'];
        $media->file_path = $fileName; 
        $media->theme_id = $validatedData['mediaTheme'] ?? null; // Opsional
        $media->status = true;
        $media->save();

        return response()->json(['message' => 'Media created successfully!']);
    }

    public function edit($id)
    {
        $media = Media::findOrFail($id); // Cari media berdasarkan ID
        return response()->json($media); // Kembalikan data dalam bentuk JSON
    }

    public function update(Request $request, $id)
    {
        // Validasi data
        $validatedData = $request->validate([
            'mediaNameEdit' => 'required|string|max:255',
            'mediaDescriptionEdit' => 'required|string|max:500',
            'mediaTypeEdit' => 'required|string|in:image,sound,video',
            'mediaFileEdit' => 'nullable|file|max:10240', // File tidak wajib
            'mediaThemeEdit' => 'nullable|exists:theme,id',
            'mediaStatusEdit' => 'required|boolean',
        ]);

        // Temukan media yang akan diupdate
        $media = Media::findOrFail($id);

        // Perbarui field
        $media->name = $validatedData['mediaNameEdit'];
        $media->description = $validatedData['mediaDescriptionEdit'];
        $media->type = $validatedData['mediaTypeEdit'];
        $media->theme_id = $validatedData['mediaThemeEdit'] ?? null;
        $media->status = $validatedData['mediaStatusEdit'];

        // Periksa jika ada file baru diunggah
        if ($request->hasFile('mediaFileEdit')) {
            // Hapus file lama jika ada
            $filePath = public_path('storage/media_files/' . $media->file_path);

            // Periksa apakah file terkait ada dan hapus file menggunakan unlink
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Simpan file baru
            $filePath = $request->file('mediaFileEdit')->store('media_files', 'public');
            $fileName = basename($filePath);
            $media->file_path = basename($fileName);
        }

        // Simpan perubahan
        $media->save();

        return response()->json(['message' => 'Media updated successfully!']);
    }

    public function destroy($id)
    {
        // Temukan media berdasarkan ID
        $media = Media::findOrFail($id);

        // Tentukan path lengkap ke file, dengan menambahkan folder 'media_files/'
        $filePath = public_path('storage/media_files/' . $media->file_path);

        // Periksa apakah file terkait ada dan hapus file menggunakan unlink
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Hapus entri media dari database
        $media->delete();

        // Kembalikan respons JSON
        return response()->json(['message' => 'The media has been deleted successfully.']);
    }



}
