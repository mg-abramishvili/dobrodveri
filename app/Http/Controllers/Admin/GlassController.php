<?php

namespace App\Http\Controllers\Admin;

use App\Models\Glass;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GlassController extends Controller
{
    public function index()
    {
        return Glass::orderBy('name', 'asc')->get();
    }

    public function glass($id)
    {
        return Glass::find($id);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'slug' => 'required',
            'image' => 'required',
        ];

        $this->validate($request, $rules);

        $glassExists = Glass::where('slug', $request->slug)->first();

        if($glassExists) {
            return response('Такой симовльный код уже занят', 500);
        }

        $glass = new Glass();

        $glass->name = $request->name;
        $glass->slug = $request->slug;
        $glass->image = $request->image;

        $glass->save();
    }

    public function update($id, Request $request)
    {
        $rules = [
            'name' => 'required',
            'slug' => 'required',
            'image' => 'required',
        ];

        $this->validate($request, $rules);

        $glassExists = Glass::where('id', '!=', $id)->where('slug', $request->slug)->first();

        if($glassExists) {
            return response('Такой симовльный код уже занят', 500);
        }

        $glass = Glass::find($id);

        $glass->name = $request->name;
        $glass->slug = $request->slug;
        $glass->image = $request->image;

        $glass->save();
    }

    public function delete($id)
    {
        $glass = Glass::find($id);

        if(count($glass->skus) > 0) {
            return response('Невозможно удалить остекление.<br>Остекление используется в товарах.', 500);
        }

        $glass->delete();
    }
}
