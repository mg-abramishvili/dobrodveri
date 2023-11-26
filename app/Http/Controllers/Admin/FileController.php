<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;

class FileController extends Controller
{
    public function store(Request $request)
    {
        if (request()->file('color_image')) {
            $file = request()->file('color_image');
            $filename = time().'.'.$file->extension();

            if (!file_exists(public_path() . '/uploads/colors')) {
                mkdir(public_path() . '/uploads/colors', 0755, true);
            }

            $img = Image::make($file->path());
            $img->resize(100, 100, function ($const) {
                $const->aspectRatio();
            })->save(public_path() . '/uploads/colors/' . $filename);

            return \Response::make('/uploads/colors/' . $filename, 200, [
                'Content-Disposition' => 'inline',
            ]);
        }

        if (request()->file('glass_image')) {
            $file = request()->file('glass_image');
            $filename = time().'.'.$file->extension();

            if (!file_exists(public_path() . '/uploads/glasses')) {
                mkdir(public_path() . '/uploads/glasses', 0755, true);
            }

            $img = Image::make($file->path());
            $img->resize(100, 100, function ($const) {
                $const->aspectRatio();
            })->save(public_path() . '/uploads/glasses/' . $filename);

            return \Response::make('/uploads/glasses/' . $filename, 200, [
                'Content-Disposition' => 'inline',
            ]);
        }

        if (request()->file('innerdecor_image')) {
            $file = request()->file('innerdecor_image');
            $filename = time().'.'.$file->extension();

            if (!file_exists(public_path() . '/uploads/innerdecors')) {
                mkdir(public_path() . '/uploads/innerdecors', 0755, true);
            }

            $img = Image::make($file->path());
            $img->resize(100, 100, function ($const) {
                $const->aspectRatio();
            })->save(public_path() . '/uploads/innerdecors/' . $filename);

            return \Response::make('/uploads/innerdecors/' . $filename, 200, [
                'Content-Disposition' => 'inline',
            ]);
        }

        if (request()->file('mainslide_image')) {
            $file = request()->file('mainslide_image');
            $filename = time().'.'.$file->extension();

            if (!file_exists(public_path() . '/uploads/mainslider')) {
                mkdir(public_path() . '/uploads/mainslider', 0755, true);
            }

            $img = Image::make($file->path());
            $img->resize(2000, 2000, function ($const) {
                $const->aspectRatio();
            })->save(public_path() . '/uploads/mainslider/' . $filename);

            return \Response::make('/uploads/mainslider/' . $filename, 200, [
                'Content-Disposition' => 'inline',
            ]);
        }

        if (request()->file('vkhod_image')) {
            $file = request()->file('vkhod_image');
            $filename = time().'.'.$file->extension();

            if (!file_exists(public_path() . '/uploads/vkhod')) {
                mkdir(public_path() . '/uploads/vkhod', 0755, true);
            }

            $img = Image::make($file->path());
            $img->resize(600, 600, function ($const) {
                $const->aspectRatio();
            })->save(public_path() . '/uploads/vkhod/' . $filename);

            return \Response::make('/uploads/vkhod/' . $filename, 200, [
                'Content-Disposition' => 'inline',
            ]);
        }

        if (request()->file('image')) {
            $file = request()->file('image');
            $filename = time().'.'.$file->extension();

            if (!file_exists(public_path() . '/uploads/products/' . $request->product_id)) {
                mkdir(public_path() . '/uploads/products/' . $request->product_id, 0755, true);
            }

            $img = Image::make($file->path());
            $img->resize(600, 600, function ($const) {
                $const->aspectRatio();
            })->save(public_path() . '/uploads/products/' . $request->product_id . '/' . $filename);

            return \Response::make('/uploads/products/' . $request->product_id . '/' . $filename, 200, [
                'Content-Disposition' => 'inline',
            ]);
        }

        if (request()->file('page_gallery')) {
            $file1 = request()->file('page_gallery');
            for ($i = 0; $i < count($file1); $i++) {
                $file = $file1[$i];
                $filename = md5(time() . rand(1, 100000)) . '.' . $file->getClientOriginalExtension();
                // $file->move(public_path() . '/uploads', $filename);

                $img = Image::make($file->path());
                $img->resize(1100, 1100, function ($const) {
                        $const->aspectRatio();
                    })->save(public_path() . '/uploads/page-galleries/' . $filename);

                return \Response::make('/uploads/page-galleries/' . $filename, 200, [
                    'Content-Disposition' => 'inline',
                ]);
            }
        }

        if (request()->file('page_cover')) {
            $file = request()->file('page_cover');
            $filename = time().'.'.$file->extension();

            if (!file_exists(public_path() . '/uploads/page-covers')) {
                mkdir(public_path() . '/uploads/page-covers', 0755, true);
            }

            $img = Image::make($file->path());
            $img->resize(600, 600, function ($const) {
                $const->aspectRatio();
            })->save(public_path() . '/uploads/page-covers/' . $filename);

            return \Response::make('/uploads/page-covers/' . $filename, 200, [
                'Content-Disposition' => 'inline',
            ]);
        }
    }
}
