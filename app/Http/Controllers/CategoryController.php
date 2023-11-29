<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('categories', compact('categories'));
    }

    public function category($categorySlug)
    {
        $category = Category::where('slug', $categorySlug)->first();
                            
        return view('category', compact('category'));
    }
}
