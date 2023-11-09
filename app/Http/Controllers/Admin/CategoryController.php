<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::all();
    }

    public function category($id)
    {
        return Category::find($id);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'slug' => 'required',
        ];

        $this->validate($request, $rules);

        $categoryExists = Category::where('slug', $request->slug)->first();

        if($categoryExists) {
            return response('Такой симовльный код уже занят', 500);
        }

        $category = new Category();

        $category->name = $request->name;
        $category->slug = $request->slug;

        $category->save();
    }

    public function update($id, Request $request)
    {
        $rules = [
            'name' => 'required',
            'slug' => 'required',
        ];

        $this->validate($request, $rules);

        $categoryExists = Category::where('id', '!=', $id)->where('slug', $request->slug)->first();

        if($categoryExists) {
            return response('Такой симовльный код уже занят', 500);
        }

        $category = Category::find($id);

        $category->name = $request->name;
        $category->slug = $request->slug;

        $category->save();
    }

    public function delete($id)
    {
        $category = Category::find($id);

        $category->delete();
    }
}
