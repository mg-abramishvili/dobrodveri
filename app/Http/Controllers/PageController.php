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
}
