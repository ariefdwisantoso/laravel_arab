<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Theme;
use Illuminate\Http\Request;


class FrontController extends Controller
{
    public function index()
    {
        // Menampilkan Daftar Tema
        $themes = Theme::select('id', 'name', 'description', 'status')->where('status', 1)->paginate(6);

        return view('front/welcome', compact('themes'));
    }

    public function theme()
    {
        // Menampilkan Daftar Tema
        $themes = Theme::select('id', 'name', 'description')->where('status', 1)->paginate(10); // 10 page

        return view('front/theme', compact('themes'));
    }

    public function themeDetails($id)
    {
        // Menampilkan Detail Tema
        $themes = Theme::where('status', 1)->findOrFail($id);

        return view('front/theme_detail', compact('themes'));
    }

    public function themeDetailsImage($id)
    {
        // Ambil tema berdasarkan ID
        $theme = Theme::where('status', 1)->findOrFail($id);

        // Ambil media yang terkait dengan tema, lalu gunakan pagination
        $media = Media::where('theme_id', $id)
                    ->where('status', 1)
                    ->where('type', 'image')
                    ->paginate(6);

        return view('front/theme_detail_image', compact('theme', 'media'));
    }

    public function themeDetailsSound($id)
    {
       // Ambil tema berdasarkan ID
       $theme = Theme::where('status', 1)->findOrFail($id);

       // Ambil media yang terkait dengan tema, lalu gunakan pagination
       $media = Media::where('theme_id', $id)
                   ->where('status', 1)
                   ->where('type', 'sound')
                   ->paginate(6);

       return view('front/theme_detail_sound', compact('theme', 'media'));
    }

    public function themeDetailsVideo($id)
    {
        // Ambil tema berdasarkan ID
        $theme = Theme::findOrFail($id);

        // Ambil media yang terkait dengan tema, lalu gunakan pagination
        $media = Media::where('theme_id', $id)
                    ->where('status', 1)
                    ->where('type', 'video')
                    ->paginate(6);

        return view('front/theme_detail_video', compact('theme', 'media'));
    }
}
