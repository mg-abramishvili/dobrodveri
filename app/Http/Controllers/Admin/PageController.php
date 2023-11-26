<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return Page::all();
    }

    public function page($id)
    {
        return Page::find($id);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'slug' => 'required',
            'text' => 'required',
        ]);

        $page = new Page();
        
        $page->name = $request->name;
        $page->slug = $request->slug;
        $page->text = $request->text;
        $page->gallery = isset($request->gallery) ? $request->gallery : [];
        $page->is_folder1 = $request->is_folder1;
        $page->is_folder2 = $request->is_folder2;
        $page->cover = $request->cover;

        $page->save();
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'slug' => 'required',
            'text' => 'required',
        ]);

        $page = Page::find($id);
        
        $page->name = $request->name;
        $page->slug = $request->slug;
        $page->text = $request->text;
        $page->gallery = isset($request->gallery) ? $request->gallery : [];
        $page->is_folder1 = $request->is_folder1;
        $page->is_folder2 = $request->is_folder2;
        $page->cover = $request->cover;

        $page->save();
    }
}
