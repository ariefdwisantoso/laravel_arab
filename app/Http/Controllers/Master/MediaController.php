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
            $media = Media::query()->with('theme');

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
                    $fileUrl = asset('storage/media_files/' . $row->image); // Buat URL file
                    $fileUrlSound = asset('storage/media_files/' . $row->file_path); 
                    if ($row->type === 'image') {
                        // Render HTML untuk menampilkan gambar
                        return '<img src="' . $fileUrl . '" alt="' . $row->name . '" class="w-16 h-16 rounded"> <br> 
                                <audio controls> 
                                    <source src="' . $fileUrlSound . '" type="audio/mpeg">
                                </audio>';
                    } elseif($row->type === 'video') {
                        $videoUrl = asset('storage/media_files/' . $row->file_path);

                        // You can then use $videoUrl in your controller like this:
                        return '<video controls width="100%">
                                    <source src="' . $videoUrl . '" type="video/mp4">
                                </video>';
                    } elseif ($row->type === 'quiz') {
                        return '<a href="' . $row->link . '" target="_blank">Quiz Link</a>';
                    }
                })
                
                ->addColumn('file_path', function ($row) {
                    $fileUrl = asset('storage/theme_files/' . $row->file_path); // Buat URL file
                    return '<audio controls> 
                                <source src="' . $fileUrl . '" type="audio/mpeg">
                            </audio>';
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
            'mediaTheme' => 'nullable|exists:theme,id',
            'mediaType' => 'required|string|in:image,quiz,video', // Validate mediaType
        ]);

        // Initialize variables for file paths
        $fileNameImage = null;
        $fileNameSound = null;
        $fileNameVideo = null;
        
        if ($request->hasFile('mediaFile')) {
            $filePathImage = $request->file('mediaFile')->store('media_files', 'public');
            $fileNameImage = basename($filePathImage);
        }
        // Save file to storage
        if ($request->hasFile('mediaSound')) {
            $filePathSound = $request->file('mediaSound')->store('media_files', 'public');
            $fileNameSound = basename($filePathSound);
        }

        if ($request->hasFile('mediaVideo')) {
            $filePathVideo = $request->file('mediaVideo')->store('media_files', 'public');
            $fileNameVideo = basename($filePathVideo);
        }


        // Save data to database
        $media = new Media();
        $media->name = $validatedData['mediaName'];
        $media->description = $validatedData['mediaDescription'];
        $media->type = $validatedData['mediaType'];
        if ($request->hasFile('mediaFile')) {
            $media->image = $fileNameImage;
        }
        if($validatedData['mediaType'] == "image"){
            $media->file_path = $fileNameSound;
        }elseif($validatedData['mediaType'] == "video"){
            $media->file_path = $fileNameVideo;
        }
        $media->theme_id = $validatedData['mediaTheme'] ?? null; // Opsional
        $media->status = true;
        $media->link = $request->input('mediaQuiz') ?? null;
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
        // Temukan media berdasarkan ID
        $media = Media::findOrFail($id);

         // Validate the input
         $request->validate([
            'mediaNameEdit' => 'required|string|max:255' . $id,
        ]);

        // Initialize variables for file paths (untuk menyimpan nama file yang baru)
        $fileNameImage = $media->image;
        $fileNameSound = $media->file_path; // Ini default file_path sebelum update
        $fileNameVideo = $media->file_path; // Ini default file_path sebelum update

        // Periksa jika ada file gambar baru
        if ($request->hasFile('mediaFileEdit')) {
            // Hapus file lama jika ada
            if ($media->image) {
                Storage::disk('public')->delete('media_files/' . $media->image);
            }

            // Simpan file baru
            $filePathImage = $request->file('mediaFileEdit')->store('media_files', 'public');
            $fileNameImage = basename($filePathImage);
        }

        // Periksa jika ada file suara baru
        if ($request->hasFile('mediaSoundEdit')) {
            // Hapus file lama jika ada
            if ($media->file_path) {
                Storage::disk('public')->delete('media_files/' . $media->file_path);
            }

            // Simpan file baru
            $filePathSound = $request->file('mediaSoundEdit')->store('media_files', 'public');
            $fileNameSound = basename($filePathSound);
        }

        // Periksa jika ada file video baru
        if ($request->hasFile('mediaVideoEdit')) {
            // Hapus file lama jika ada
            if ($media->file_path) {
                Storage::disk('public')->delete('media_files/' . $media->file_path);
            }

            // Simpan file baru
            $filePathVideo = $request->file('mediaVideoEdit')->store('media_files', 'public');
            $fileNameVideo = basename($filePathVideo);
        }

        // Ambil nama media dari inputan request
        $mediaName = $request->input('mediaNameEdit');

        // Pastikan nama media tidak kosong
        if (empty($mediaName)) {
            return response()->json(['error' => 'Media name is required.'], 400);
        }

        // Perbarui data media
        $media->name = $mediaName;
        $media->description = $request->input('mediaDescriptionEdit');
        $media->type = $request->input('mediaTypeEdit');

        // Atur file paths berdasarkan tipe media
        if ($request->input('mediaTypeEdit') == "image") {
            $media->file_path = $fileNameSound;
            $media->image = $fileNameImage; // Jika tipe adalah image, simpan file image path
        } elseif ($request->input('mediaTypeEdit') == "video") {
            $media->file_path = $fileNameVideo; // Jika tipe adalah video, simpan file video path
        }

        $media->theme_id = $request->input('mediaThemeEdit'); // Opsional
        $media->status = true;
        $media->link = $request->input('mediaQuizEdit');

        // Simpan perubahan ke database
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
        if (file_exists($filePath) && is_file($filePath)) {
            unlink($filePath); // Menghapus file
        }

        // Hapus entri media dari database
        $media->delete();

        // Kembalikan respons JSON
        return response()->json(['message' => 'The media has been deleted successfully.']);
    }



}
