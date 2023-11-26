<?php

namespace App\Http\Controllers\Admin;

use App\Models\Size;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index()
    {
        return Size::with('categories')->orderBy('name', 'asc')->get();
    }

    public function size($id)
    {
        return Size::with('categories')->find($id);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'slug' => 'required',
            'categories' => 'required',
        ];

        $this->validate($request, $rules);

        $sizeExists = Size::where('slug', $request->slug)->first();

        if($sizeExists) {
            return response('Такой симовльный код уже занят', 500);
        }

        $size = new Size();

        $size->name = $request->name;
        $size->slug = $request->slug;

        $size->save();

        $size->categories()->sync($request->categories);
    }

    public function update($id, Request $request)
    {
        $rules = [
            'name' => 'required',
            'slug' => 'required',
            'categories' => 'required',
        ];

        $this->validate($request, $rules);

        $sizeExists = Size::where('id', '!=', $id)->where('slug', $request->slug)->first();

        if($sizeExists) {
            return response('Такой симовльный код уже занят', 500);
        }

        $size = Size::find($id);

        $size->name = $request->name;
        $size->slug = $request->slug;

        $size->categories()->sync($request->categories);

        $size->save();
    }

    public function delete($id)
    {
        $size = Size::find($id);

        if(count($size->products) > 0) {
            return response('Невозможно удалить размер.<br>Размер используется в товарах.', 500);
        }

        $size->delete();
    }
}
