<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sku;
use App\Models\Type;
use App\Models\Style;
use App\Models\Surface;
use App\Models\Color;
use App\Models\Glass;
use App\Http\Resources\SkuResource;
use Illuminate\Http\Request;

class SkuController extends Controller
{
    public function addToFavorite(Request $request)
    {
        // session()->forget('favorites');
        
        $favorites = session()->get('favorites', []);

        $sku = Sku::find($request->id);

        if(!isset($favorites[$sku->id])) {
            $favorites[$sku->id] = new SkuResource($sku);
        }
          
        session()->put('favorites', $favorites);
    }

    public function indexData(Request $request)
    {
        $category_id = $request->category_id;
        $page = $request->page ? $request->page : 1;
        $types = $request->types;
        $styles = $request->styles;
        $surfaces = $request->surfaces;
        $priceFrom = $request->price_from;
        $priceTo = $request->price_to;
        $colors = $request->colors;
        $glasses = $request->glasses;
        
        $filteredTypes = Type::withCount(['skus' => function ($query) use($category_id, $types, $styles, $surfaces, $colors, $glasses) {
            $query->withFilters($category_id, null, $styles, $surfaces, $colors, $glasses);
        }])->orderBy('skus_count', 'desc')->get();

        $filteredStyles = Style::withCount(['skus' => function ($query) use($category_id, $types, $styles, $surfaces, $colors, $glasses) {
            $query->withFilters($category_id, $types, null, $surfaces, $colors, $glasses);
        }])->orderBy('skus_count', 'desc')->get();

        $filteredSurfaces = Surface::withCount(['skus' => function ($query) use($category_id, $types, $styles, $surfaces, $colors, $glasses) {
            $query->withFilters($category_id, $types, $styles, null, $colors, $glasses);
        }])->orderBy('skus_count', 'desc')->get();

        $filteredColors = Color::withCount(['skus' => function ($query) use($category_id, $types, $styles, $surfaces, $colors, $glasses) {
            $query->withFilters($category_id, $types, $styles, $surfaces, null, $glasses);
        }])->orderBy('skus_count', 'desc')->get();

        $filteredGlasses = Glass::withCount(['skus' => function ($query) use($category_id, $types, $styles, $surfaces, $colors, $glasses) {
            $query->withFilters($category_id, $types, $styles, $surfaces, $colors, null);
        }])->orderBy('skus_count', 'desc')->get();

        $perPage = 1;

        $skus = Sku::select(['skus.*', 'products.price as product_price'])
                    ->join('products', 'skus.product_id', '=', 'products.id')
                    ->withFilters($category_id, $types, $styles, $surfaces, $colors, $glasses)
                    ->orderBy('products.price', 'asc');

        $pagination['total_pages'] = round($skus->count() / $perPage);
        $pagination['current_page'] = (int)$page;

        $skus = $skus->skip(($perPage * $page) - $perPage)
                    ->take($perPage)
                    ->get();

        return response()->json([
            'types' => $filteredTypes,
            'styles' => $filteredStyles,
            'surfaces' => $filteredSurfaces,
            'colors' => $filteredColors,
            'glasses' => $filteredGlasses,
            'skus' => SkuResource::collection($skus),
            'pagination' => $pagination,
        ]);
    }
}
