<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Traits\getProducts;
use App\Traits\getSkus;
use App\Traits\getFilterParams;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use getProducts, getFilterParams, getSkus;

    public function index()
    {
        $categories = Category::all();

        return view('categories', compact('categories'));
    }

    public function category($categorySlug, Request $request)
    {
        $category = Category::where('slug', $categorySlug)->first();

        $filterParams = $this->getFilterParams($request, 'product', $category->id);

        $perPage = 30;

        $productsWithPagination = null;
        $skusWithPagination = null;

        if($filterParams['colors'])
        {
            $skusWithPagination = $this->getSkus($filterParams, $perPage)->getContent();
        }
        else
        {
            $productsWithPagination = $this->getProducts($category->id, $filterParams, $perPage)->getContent();
        }

        return view('category', [
            'category' => $category,
            'productsWithPagination' => $productsWithPagination ? $productsWithPagination : null,
            'skusWithPagination' => $skusWithPagination ? $skusWithPagination : null,
        ]);
    }
}
