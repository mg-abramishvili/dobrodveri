<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Models\Type;
use App\Models\Style;
use App\Models\Surface;
use App\Traits\storeInRecentlyViewed;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use storeInRecentlyViewed;

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

        $this->storeInRecentlyViewed(json_encode($productResource));

        return view('product', ['product' => json_encode($productResource)]);
    }

    // public function indexData(Request $request)
    // {
    //     $category_id = $request->category_id;
    //     $types = $request->types;
    //     $styles = $request->styles;
    //     $surfaces = $request->surfaces;
    //     $priceFrom = $request->price_from;
    //     $priceTo = $request->price_to;

    //     $filteredTypes = Type::withCount(['products' => function ($query) use($category_id, $types, $styles, $surfaces, $priceFrom, $priceTo) {
    //         $query->withFilters($category_id, $types, $styles, $surfaces, $priceFrom, $priceTo);
    //     }])->get();

    //     $filteredStyles = Style::withCount(['products' => function ($query) use($category_id, $types, $styles, $surfaces, $priceFrom, $priceTo) {
    //         $query->withFilters($category_id, $types, $styles, $surfaces, $priceFrom, $priceTo);
    //     }])->get();

    //     $filteredSurfaces = Surface::withCount(['products' => function ($query) use($category_id, $types, $styles, $surfaces, $priceFrom, $priceTo) {
    //         $query->withFilters($category_id, $types, $styles, $surfaces, $priceFrom, $priceTo);
    //     }])->get();

    //     $products = ProductResource::collection(Product::withFilters($category_id, $types, $styles, $surfaces, $priceFrom, $priceTo)->get());

    //     return response()->json([
    //         'types' => $filteredTypes,
    //         'styles' => $filteredStyles,
    //         'surfaces' => $filteredSurfaces,
    //         'products' => $products,
    //     ]);
    // }
}
