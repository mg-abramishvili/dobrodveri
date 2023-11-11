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

    public function categoryApi($categoryID, Request $request)
    {
        $price_from = $request->price_from;
        $price_to = $request->price_to;
        $order = $request->order;
        $order_direction = $request->order_direction;
        $types = $request->types;
        $surfaces = $request->surfaces;

        if($types || $surfaces || $price_from || $price_to)
        {
            return Category::with([
                    'products' => function($q) use($types, $surfaces, $price_from, $price_to, $order, $order_direction) {
                        if($types) {
                            $q->whereHas('type', function($q) use($types) {
                                $q->whereIn('slug', $types);
                            });
                        }
                        if($surfaces) {
                            $q->whereHas('surface', function($q) use($surfaces) {
                                $q->whereIn('slug', $surfaces);
                            });
                        }

                        if($price_from) {
                            $q->where('price', '>=', $price_from);
                        }
                        if($price_to) {
                            $q->where('price', '<=', $price_to);
                        }

                        $q->where('is_active', 1);

                        if($order && $order_direction) {
                            $q->orderBy($order, $order_direction);
                        }
                    }
                ]
            )
            ->find($categoryID);
        }

        return Category::query()
            ->with([
                'products' => function($query) use($order, $order_direction) {
                    $query->where('is_active', 1)->with('skus');
                    
                    if($order && $order_direction) {
                        $query->orderBy($order, $order_direction);
                    }
                }])
            ->find($categoryID);
    }
}
