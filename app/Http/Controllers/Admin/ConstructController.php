<?php

namespace App\Http\Controllers\Admin;

use App\Models\Construct;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConstructController extends Controller
{
    public function index()
    {
        return Construct::all();
    }

    public function construct($id)
    {
        return Construct::find($id);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'slug' => 'required',
        ];

        $this->validate($request, $rules);

        $constructExists = Construct::where('slug', $request->slug)->first();

        if($constructExists) {
            return response('Такой симовльный код уже занят', 500);
        }

        $construct = new Construct();

        $construct->name = $request->name;
        $construct->slug = $request->slug;

        $construct->save();
    }

    public function update($id, Request $request)
    {
        $rules = [
            'name' => 'required',
            'slug' => 'required',
        ];

        $this->validate($request, $rules);

        $constructExists = Construct::where('id', '!=', $id)->where('slug', $request->slug)->first();

        if($constructExists) {
            return response('Такой симовльный код уже занят', 500);
        }

        $construct = Construct::find($id);

        $construct->name = $request->name;
        $construct->slug = $request->slug;

        $construct->save();
    }

    public function delete($id)
    {
        $construct = Construct::find($id);

        if(count($construct->products) > 0) {
            return response('Невозможно удалить конструкцию.<br>Конструкция используется в товарах.', 500);
        }

        $construct->delete();
    }
}
