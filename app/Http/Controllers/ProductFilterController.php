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
        $filterParams['category_id'] = $request->category_id;
        $filterParams['priceFrom'] = $request->price_from;
        $filterParams['priceTo'] = $request->price_to;
        $filterParams['types'] = $request->types;
        $filterParams['styles'] = $request->styles;
        $filterParams['surfaces'] = $request->surfaces;
        $filterParams['colors'] = $request->colors;
        $filterParams['glasses'] = $request->glasses;

        $filteredTypes = Type::withCount(['skus' => function ($query) use($filterParams) {
            $filterParams['types'] = null;

            $query->withFilters($filterParams);
        }])->orderBy('skus_count', 'desc')->get();

        $filteredStyles = Style::withCount(['skus' => function ($query) use($filterParams) {
            $filterParams['styles'] = null;
            
            $query->withFilters($filterParams);
        }])->orderBy('skus_count', 'desc')->get();

        $filteredSurfaces = Surface::withCount(['skus' => function ($query) use($filterParams) {
            $filterParams['surfaces'] = null;
            
            $query->withFilters($filterParams);
        }])->orderBy('skus_count', 'desc')->get();

        $filteredColors = Color::withCount(['skus' => function ($query) use($filterParams) {
            $filterParams['colors'] = null;
            
            $query->withFilters($filterParams);
        }])->orderBy('skus_count', 'desc')->get();

        $filteredGlasses = Glass::withCount(['skus' => function ($query) use($filterParams) {
            $filterParams['glasses'] = null;
            
            $query->withFilters($filterParams);
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
