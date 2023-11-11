<?php

namespace App\Http\Controllers\Admin;

use App\Models\Purpose;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PurposeController extends Controller
{
    public function index()
    {
        return Purpose::all();
    }

    public function purpose($id)
    {
        return Purpose::find($id);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'slug' => 'required',
        ];

        $this->validate($request, $rules);

        $purposeExists = Purpose::where('slug', $request->slug)->first();

        if($purposeExists) {
            return response('Такой симовльный код уже занят', 500);
        }

        $purpose = new Purpose();

        $purpose->name = $request->name;
        $purpose->slug = $request->slug;

        $purpose->save();
    }

    public function update($id, Request $request)
    {
        $rules = [
            'name' => 'required',
            'slug' => 'required',
        ];

        $this->validate($request, $rules);

        $purposeExists = Purpose::where('id', '!=', $id)->where('slug', $request->slug)->first();

        if($purposeExists) {
            return response('Такой симовльный код уже занят', 500);
        }

        $purpose = Purpose::find($id);

        $purpose->name = $request->name;
        $purpose->slug = $request->slug;

        $purpose->save();
    }

    public function delete($id)
    {
        $purpose = Purpose::find($id);

        if(count($purpose->products) > 0) {
            return response('Невозможно удалить назначение.<br>Назначение используется в товарах.', 500);
        }

        $purpose->delete();
    }
}
