<?php

namespace App\Http\Controllers\Admin;

use App\Models\Style;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StyleController extends Controller
{
    public function index()
    {
        return Style::all();
    }

    public function style($id)
    {
        return Style::find($id);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'slug' => 'required',
        ];

        $this->validate($request, $rules);

        $styleExists = Style::where('slug', $request->slug)->first();

        if($styleExists) {
            return response('Такой симовльный код уже занят', 500);
        }

        $style = new Style();

        $style->name = $request->name;
        $style->slug = $request->slug;

        $style->save();
    }

    public function update($id, Request $request)
    {
        $rules = [
            'name' => 'required',
            'slug' => 'required',
        ];

        $this->validate($request, $rules);

        $styleExists = Style::where('id', '!=', $id)->where('slug', $request->slug)->first();

        if($styleExists) {
            return response('Такой симовльный код уже занят', 500);
        }

        $style = Style::find($id);

        $style->name = $request->name;
        $style->slug = $request->slug;

        $style->save();
    }

    public function delete($id)
    {
        $style = Style::find($id);

        if(count($style->products) > 0) {
            return response('Невозможно удалить стиль.<br>Стиль используется в товарах.', 500);
        }

        $style->delete();
    }
}
