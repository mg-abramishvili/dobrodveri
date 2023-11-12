<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Type;
use App\Models\Style;
use App\Models\Surface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function product($productSlug)
    {
        $product = Product::query()
            ->where('slug', $productSlug)
            ->with([
                'category',
                'skus.color',
                'skus.glass',
                'skus.innerdecor',
                'sizes',
                'factory',
                'surface',
                'construct',
                'style',
                'type',
                'purpose',
                'furnituretype',
                'reviews' => function($q) {
                    $q->where('is_active', true);
                }
            ])
            ->first();
        
        $product->view_counter = $product->view_counter + 1;
        
        if($product->view_counter >= 50) {
            $product->hit = true;
        }
        
        $product->save();
        
        return view('products.product', compact('product'));
    }

    public function indexData(Request $request)
    {
        $category_id = $request->category_id;
        $types = $request->types;
        $styles = $request->styles;
        $surfaces = $request->surfaces;

        $filteredTypes = Type::withCount(['products' => function ($query) use($types, $styles, $surfaces) {
            $query->withFilters($types, $styles, $surfaces);
        }])->get();

        $filteredStyles = Style::withCount(['products' => function ($query) use($types, $styles, $surfaces) {
            $query->withFilters($types, $styles, $surfaces);
        }])->get();

        $filteredSurfaces = Surface::withCount(['products' => function ($query) use($types, $styles, $surfaces) {
            $query->withFilters($types, $styles, $surfaces);
        }])->get();

        $products = Product::withFilters($types, $styles, $surfaces)->get();

        return response()->json([
            'types' => $filteredTypes,
            'styles' => $filteredStyles,
            'surfaces' => $filteredSurfaces,
            'products' => $products,
        ]);
    }
}
