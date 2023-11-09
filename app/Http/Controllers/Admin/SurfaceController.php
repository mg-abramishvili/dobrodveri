<?php

namespace App\Http\Controllers\Admin;

use App\Models\Surface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SurfaceController extends Controller
{
    public function index()
    {
        return Surface::all();
    }

    public function surface($id)
    {
        return Surface::find($id);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'slug' => 'required',
        ];

        $this->validate($request, $rules);

        $surfaceExists = Surface::where('slug', $request->slug)->first();

        if($surfaceExists) {
            return response('Такой симовльный код уже занят', 500);
        }

        $surface = new Surface();

        $surface->name = $request->name;
        $surface->slug = $request->slug;

        $surface->save();
    }

    public function update($id, Request $request)
    {
        $rules = [
            'name' => 'required',
            'slug' => 'required',
        ];

        $this->validate($request, $rules);

        $surfaceExists = Surface::where('id', '!=', $id)->where('slug', $request->slug)->first();

        if($surfaceExists) {
            return response('Такой симовльный код уже занят', 500);
        }

        $surface = Surface::find($id);

        $surface->name = $request->name;
        $surface->slug = $request->slug;

        $surface->save();
    }

    public function delete($id)
    {
        $surface = Surface::find($id);

        $surface->delete();
    }
}
