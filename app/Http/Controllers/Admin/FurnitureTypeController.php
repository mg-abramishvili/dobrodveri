<?php

namespace App\Http\Controllers\Admin;

use App\Models\FurnitureType;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FurnitureTypeController extends Controller
{
    public function index()
    {
        return FurnitureType::all();
    }

    public function furnituretype($id)
    {
        return FurnitureType::find($id);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'slug' => 'required',
        ];

        $this->validate($request, $rules);

        $furnituretypeExists = FurnitureType::where('slug', $request->slug)->first();

        if($furnituretypeExists) {
            return response('Такой симовльный код уже занят', 500);
        }

        $furnituretype = new FurnitureType();

        $furnituretype->name = $request->name;
        $furnituretype->slug = $request->slug;

        $furnituretype->save();
    }

    public function update($id, Request $request)
    {
        $rules = [
            'name' => 'required',
            'slug' => 'required',
        ];

        $this->validate($request, $rules);

        $furnituretypeExists = FurnitureType::where('id', '!=', $id)->where('slug', $request->slug)->first();

        if($furnituretypeExists) {
            return response('Такой симовльный код уже занят', 500);
        }

        $furnituretype = FurnitureType::find($id);

        $furnituretype->name = $request->name;
        $furnituretype->slug = $request->slug;

        $furnituretype->save();
    }

    public function delete($id)
    {
        $furnituretype = FurnitureType::find($id);

        if(count($furnituretype->products) > 0) {
            return response('Невозможно удалить тип фурнитуры.<br>Тип используется в товарах.', 500);
        }

        $furnituretype->delete();
    }
}
