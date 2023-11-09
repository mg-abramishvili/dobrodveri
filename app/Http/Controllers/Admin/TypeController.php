<?php

namespace App\Http\Controllers\Admin;

use App\Models\Type;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function index()
    {
        return Type::all();
    }

    public function type($id)
    {
        return Type::find($id);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'slug' => 'required',
        ];

        $this->validate($request, $rules);

        $typeExists = Type::where('slug', $request->slug)->first();

        if($typeExists) {
            return response('Такой симовльный код уже занят', 500);
        }

        $type = new Type();

        $type->name = $request->name;
        $type->slug = $request->slug;

        $type->save();
    }

    public function update($id, Request $request)
    {
        $rules = [
            'name' => 'required',
            'slug' => 'required',
        ];

        $this->validate($request, $rules);

        $typeExists = Type::where('id', '!=', $id)->where('slug', $request->slug)->first();

        if($typeExists) {
            return response('Такой симовльный код уже занят', 500);
        }

        $type = Type::find($id);

        $type->name = $request->name;
        $type->slug = $request->slug;

        $type->save();
    }

    public function delete($id)
    {
        $type = Type::find($id);

        $type->delete();
    }
}
