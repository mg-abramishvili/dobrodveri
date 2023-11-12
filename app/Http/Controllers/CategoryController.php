<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::query()
        ->with([
            'products' => function($query) {
                $query->where('is_active', 1);
            }])
        ->get();

        return view('categories', compact('categories'));
    }

    public function category($categorySlug)
    {
        $category = Category::query()
            ->where('slug', $categorySlug)
            ->with([
                'products' => function($query) {
                    $query->where('is_active', 1);
                }])
            ->first();

        return view('category', compact('category'));
    }
}
