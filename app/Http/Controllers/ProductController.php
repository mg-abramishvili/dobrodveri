<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Models\Type;
use App\Models\Style;
use App\Models\Surface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function product($productSlug)
    {
        $product = Product::where('slug', $productSlug)->first();
        
        if(!$product)
        {
            return view('404');
        }

        $product->increment('view_counter');
        
        if($product->view_counter >= 50) {
            $product->hit = true;
        }
        
        $product->save();

        $productResource = new ProductResource(Product::where('slug', $productSlug)->first());

        return view('product', ['product' => json_encode($productResource)]);
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
