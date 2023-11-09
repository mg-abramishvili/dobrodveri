<?php

namespace App\Http\Controllers\Admin;

use App\Models\MainSlider;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainSliderController extends Controller
{
    public function index()
    {
        return MainSlider::all();
    }

    public function slide($id)
    {
        return MainSlider::find($id);
    }

    public function store(Request $request)
    {
        $rules = [
            'header' => 'required',
            'image' => 'required',
        ];

        $this->validate($request, $rules);

        $slide = new MainSlider();

        $slide->header = $request->header;
        $slide->text = $request->text;
        $slide->link = $request->link;
        $slide->image = $request->image;

        $slide->save();
    }

    public function update($id, Request $request)
    {
        $rules = [
            'header' => 'required',
            'image' => 'required',
        ];

        $this->validate($request, $rules);

        $slide = MainSlider::find($id);

        $slide->header = $request->header;
        $slide->text = $request->text;
        $slide->link = $request->link;
        $slide->image = $request->image;

        $slide->save();
    }

    public function delete($id)
    {
        $slide = MainSlider::find($id);

        $slide->delete();
    }
}
