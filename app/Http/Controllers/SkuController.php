<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sku;
use App\Models\Type;
use App\Models\Style;
use App\Models\Surface;
use App\Models\Color;
use App\Http\Resources\SkuResource;
use Illuminate\Http\Request;

class SkuController extends Controller
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
        
        $filteredTypes = Type::withCount(['skus' => function ($query) use($types, $styles, $surfaces, $colors) {
            $query->withFilters($types, $styles, $surfaces, $colors);
        }])->get();

        $filteredStyles = Style::withCount(['skus' => function ($query) use($types, $styles, $surfaces, $colors) {
            $query->withFilters($types, $styles, $surfaces, $colors);
        }])->get();

        $filteredSurfaces = Surface::withCount(['skus' => function ($query) use($types, $styles, $surfaces, $colors) {
            $query->withFilters($types, $styles, $surfaces, $colors);
        }])->get();

        $filteredColors = Color::withCount(['skus' => function ($query) use($types, $styles, $surfaces, $colors) {
            $query->withFilters($types, $styles, $surfaces, $colors);
        }])->get();

        $perPage = 2;

        $skus = Sku::withFilters($types, $styles, $surfaces, $colors);

        $pagination['total_pages'] = $skus->count() / $perPage;
        $pagination['current_page'] = (int)$page;

        $skus = SkuResource::collection($skus->skip(($perPage * $page) - $perPage)->take($perPage)->get());

        return response()->json([
            'types' => $filteredTypes,
            'styles' => $filteredStyles,
            'surfaces' => $filteredSurfaces,
            'colors' => $filteredColors,
            'skus' => $skus,
            'pagination' => $pagination,
        ]);
    }
}
