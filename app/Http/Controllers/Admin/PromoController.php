<?php

namespace App\Http\Controllers\Admin;

use App\Models\Promo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function index()
    {
        return Promo::orderBy('name', 'asc')->get();
    }

    public function promo($id)
    {
        return Promo::find($id);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
        ];

        $this->validate($request, $rules);

        $promo = new Promo();

        $promo->name = $request->name;
        $promo->description = $request->description;
        $promo->image = $request->image;

        $promo->save();
    }

    public function update($id, Request $request)
    {
        $rules = [
            'name' => 'required',
        ];

        $this->validate($request, $rules);

        $promo = Promo::find($id);

        $promo->name = $request->name;
        $promo->description = $request->description;
        $promo->image = $request->image;

        $promo->save();
    }

    public function delete($id)
    {
        $promo = Promo::find($id);
        
        $promo->factories()->sync([]);

        $promo->delete();
    }
}
