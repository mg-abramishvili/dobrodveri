<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Traits\getProducts;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use getProducts;

    public function index()
    {
        $categories = Category::all();

        return view('categories', compact('categories'));
    }

    public function category($categorySlug, Request $request)
    {
        $page = $request->page ? $request->page : 1;

        $perPage = 30;

        $category = Category::where('slug', $categorySlug)->first();

        $productsWithPagination = $this->getProducts($category->id, $page, $perPage)->getContent();

        return view('category', ['category' => $category, 'productsWithPagination' => $productsWithPagination]);
    }
}
