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

        return view('categories.index', compact('categories'));
    }

    public function category($categorySlug)
    {
        $category = Category::query()
            ->where('slug', $categorySlug)
            ->with([
                'products' => function($query) {
                    $query->where('is_active', true);
                }])
            ->get()
            ->first();

        return view('categories.category', compact('category'));
    }

    public function categoryApi($categoryID, Request $request)
    {
        $price_from = $request->price_from;
        $price_to = $request->price_to;
        $order = $request->order;
        $order_direction = $request->order_direction;
        $types = $request->types;
        $surfaces = $request->surfaces;
        $purposes = $request->purposes;
        $furnituretypes = $request->furnituretypes;
        $colors = $request->colors;
        $glasses = $request->glasses;
        $innerdecors = $request->innerdecors;

        if($types || $surfaces || $purposes || $furnituretypes || $colors || $glasses || $innerdecors || $price_from || $price_to)
        {
            return Category::with([
                    'products' => function($q) use($types, $surfaces, $colors, $glasses, $innerdecors, $price_from, $purposes, $furnituretypes, $price_to, $order, $order_direction) {
                        if($order && $order_direction) {
                            $q->where('is_active', true)->orderBy($order, $order_direction);
                        } else {
                            $q->where('is_active', true);
                        }

                        if($types) {
                            $q->whereRelation('type', 'slug');
                            foreach($types as $type) {
                                $q->orWhereRelation('type', 'slug', $type);
                            }
                        }
                        if($surfaces) {
                            $q->whereRelation('surface', 'slug');
                            foreach($surfaces as $surface) {
                                $q->orWhereRelation('surface', 'slug', $surface);
                            }
                        }
                        if($purposes) {
                            $q->whereRelation('purpose', 'slug');
                            foreach($purposes as $purpose) {
                                $q->orWhereRelation('purpose', 'slug', $purpose);
                            }
                        }
                        if($furnituretypes) {
                            $q->whereRelation('furnituretype', 'slug');
                            foreach($furnituretypes as $furnituretype) {
                                $q->orWhereRelation('furnituretype', 'slug', $furnituretype);
                            }
                        }
                        if($price_from) {
                            $q->where('price', '>=', $price_from);
                        }
                        if($price_to) {
                            $q->where('price', '<=', $price_to);
                        }

                        $q->with([
                            'skus' => function($q) use($colors, $glasses, $innerdecors) {
                                if($colors) {
                                    $q->whereHas('color', function($q) use($colors) {
                                        $q->whereIn('slug', $colors);
                                    })->with('color');
                                }

                                if($glasses) {
                                    $q->whereHas('glass', function($q) use($glasses) {
                                        $q->whereIn('slug', $glasses);
                                    })->with('glass');
                                }

                                if($innerdecors) {
                                    $q->whereHas('innerdecor', function($q) use($innerdecors) {
                                        $q->whereIn('slug', $innerdecors);
                                    })->with('innerdecor');
                                }
                            }
                        ]);
                    }
                ]
            )
            ->find($categoryID);
        }

        return Category::query()
            ->with([
                'products' => function($query) use($order, $order_direction) {
                    if($order && $order_direction) {
                        $query->where('is_active', true)->with('skus')->orderBy($order, $order_direction);
                    } else {
                        $query->where('is_active', true)->with('skus');
                    }
                }])
            ->find($categoryID);
    }
}
