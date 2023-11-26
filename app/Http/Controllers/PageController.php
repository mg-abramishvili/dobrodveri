<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function page($slug)
    {
        $page = Page::where('slug', $slug)->first();

        return view('page', compact('page'));
    }

    public function pageDizaineram()
    {
        $pagesF = Page::where('is_folder1', 1)->orderBy('created_at', 'desc')->get();
        $title = 'Дизайнерам';

        return view('page-folder', compact('pagesF', 'title'));
    }

    public function pagePolezno()
    {
        $pagesF = Page::where('is_folder2', 1)->orderBy('created_at', 'desc')->get();
        $title = 'Полезно';

        return view('page-folder', compact('pagesF', 'title'));
    }
}
