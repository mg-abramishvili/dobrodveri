<?php

namespace App\Http\Controllers\Admin;

use App\Models\InnerDecor;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InnerDecorController extends Controller
{
    public function index()
    {
        return InnerDecor::all();
    }

    public function innerdecor($id)
    {
        return InnerDecor::find($id);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'slug' => 'required',
        ];

        $this->validate($request, $rules);

        $innerdecorExists = InnerDecor::where('slug', $request->slug)->first();

        if($innerdecorExists) {
            return response('Такой симовльный код уже занят', 500);
        }

        $innerdecor = new InnerDecor();

        $innerdecor->name = $request->name;
        $innerdecor->slug = $request->slug;

        $innerdecor->save();
    }

    public function update($id, Request $request)
    {
        $rules = [
            'name' => 'required',
            'slug' => 'required',
        ];

        $this->validate($request, $rules);

        $innerdecorExists = InnerDecor::where('id', '!=', $id)->where('slug', $request->slug)->first();

        if($innerdecorExists) {
            return response('Такой симовльный код уже занят', 500);
        }

        $innerdecor = InnerDecor::find($id);

        $innerdecor->name = $request->name;
        $innerdecor->slug = $request->slug;

        $innerdecor->save();
    }

    public function delete($id)
    {
        $innerdecor = InnerDecor::find($id);

        if(count($innerdecor->skus) > 0) {
            return response('Невозможно удалить отделку.<br>Отделка используется в товарах.', 500);
        }

        $innerdecor->delete();
    }
}