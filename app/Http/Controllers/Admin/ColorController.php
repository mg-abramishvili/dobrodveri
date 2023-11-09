<?php

namespace App\Http\Controllers\Admin;

use App\Models\Color;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        return Color::orderBy('name', 'asc')->get();
    }

    public function color($id)
    {
        return Color::find($id);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'slug' => 'required',
            'image' => 'required',
        ];

        $this->validate($request, $rules);

        $colorExists = Color::where('slug', $request->slug)->first();

        if($colorExists) {
            return response('Такой симовльный код уже занят', 500);
        }

        $color = new Color();

        $color->name = $request->name;
        $color->slug = $request->slug;
        $color->image = $request->image;

        $color->save();
    }

    public function update($id, Request $request)
    {
        $rules = [
            'name' => 'required',
            'slug' => 'required',
            'image' => 'required',
        ];

        $this->validate($request, $rules);

        $colorExists = Color::where('id', '!=', $id)->where('slug', $request->slug)->first();

        if($colorExists) {
            return response('Такой симовльный код уже занят', 500);
        }

        $color = Color::find($id);

        $color->name = $request->name;
        $color->slug = $request->slug;
        $color->image = $request->image;

        $color->save();
    }

    public function delete($id)
    {
        $color = Color::find($id);

        $color->delete();
    }
}
