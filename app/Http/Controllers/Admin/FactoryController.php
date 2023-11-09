<?php

namespace App\Http\Controllers\Admin;

use App\Models\Factory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FactoryController extends Controller
{
    public function index()
    {
        return Factory::all();
    }

    public function factory($id)
    {
        return Factory::find($id);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'slug' => 'required',
            'coef' => 'required',
        ];

        $this->validate($request, $rules);

        $factoryExists = Factory::where('slug', $request->slug)->first();

        if($factoryExists) {
            return response('Такой симовльный код уже занят', 500);
        }

        $factory = new Factory();

        $factory->name = $request->name;
        $factory->slug = $request->slug;
        $factory->coef = $request->coef;

        $factory->save();
    }

    public function update($id, Request $request)
    {
        $rules = [
            'name' => 'required',
            'slug' => 'required',
            'coef' => 'required',
        ];

        $this->validate($request, $rules);

        $factoryExists = Factory::where('id', '!=', $id)->where('slug', $request->slug)->first();

        if($factoryExists) {
            return response('Такой симовльный код уже занят', 500);
        }

        $factory = Factory::find($id);

        $factory->name = $request->name;
        $factory->slug = $request->slug;
        $factory->coef = $request->coef;

        $factory->save();
    }

    public function delete($id)
    {
        $factory = Factory::find($id);

        if(count($factory->products))
        {
            return response('Фабрику нельзя удалить - к ней привязаны товары', 500);
        }

        $factory->delete();
    }
}
