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

        $page->save();
    }
}
