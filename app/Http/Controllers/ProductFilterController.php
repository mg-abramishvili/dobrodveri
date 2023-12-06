<?php

namespace App\Http\Controllers;

use App\Models\Sku;
use App\Models\Type;
use App\Models\Style;
use App\Models\Surface;
use App\Models\Color;
use App\Models\Glass;
use Illuminate\Http\Request;

class ProductFilterController extends Controller
{
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
        
        return response()->json([
            'types' => $filteredTypes,
            'styles' => $filteredStyles,
            'surfaces' => $filteredSurfaces,
            'colors' => $filteredColors,
            'glasses' => $filteredGlasses,
        ]);
    }
}
