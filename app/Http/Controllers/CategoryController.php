<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Traits\getProducts;
use App\Traits\getSkus;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use getProducts, getSkus;

    public function index()
    {
        $categories = Category::all();

        return view('categories', compact('categories'));
    }

    public function category($categorySlug, Request $request)
    {
        $category = Category::where('slug', $categorySlug)->first();

        $filterParams['category_id'] = $category->id;
        $filterParams['priceFrom'] = $request->price_from;
        $filterParams['priceTo'] = $request->price_to;
        $filterParams['types'] = $request->types;
        $filterParams['styles'] = $request->styles;
        $filterParams['surfaces'] = $request->surfaces;
        $filterParams['colors'] = $request->color ? explode(',', $request->color) : null;
        $filterParams['glasses'] = $request->glasses;
        $filterParams['page'] = $request->page ? $request->page : 1;
        $filterParams['order'] = $request->order ? $request->order : 'price_asc';

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
