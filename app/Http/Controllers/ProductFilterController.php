<?php

namespace App\Http\Controllers;

use App\Models\Sku;
use App\Models\Type;
use App\Models\Style;
use App\Models\Color;
use App\Models\Glass;
use App\Models\Surface;
use App\Models\InnerDecor;
use App\Models\Purpose;
use App\Models\FurnitureType;
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
        $filterParams['innerdecors'] = $request->innerdecors;
        $filterParams['purposes'] = $request->purposes;
        $filterParams['furnituretypes'] = $request->furnituretypes;

        $filteredTypes = Type::withCount(['skus' => function ($query) use($filterParams) {
            $filterParams['types'] = null;

            $query->withFilters($filterParams);
        }])->orderBy('skus_count', 'desc')->orderBy('name')->get();

        $filteredStyles = Style::withCount(['skus' => function ($query) use($filterParams) {
            $filterParams['styles'] = null;
            
            $query->withFilters($filterParams);
        }])->orderBy('skus_count', 'desc')->orderBy('name')->get();

        $filteredSurfaces = Surface::withCount(['skus' => function ($query) use($filterParams) {
            $filterParams['surfaces'] = null;
            
            $query->withFilters($filterParams);
        }])->orderBy('skus_count', 'desc')->orderBy('name')->get();

        $filteredColors = Color::withCount(['skus' => function ($query) use($filterParams) {
            $filterParams['colors'] = null;
            
            $query->withFilters($filterParams);
        }])->orderBy('skus_count', 'desc')->orderBy('name')->get();

        $filteredGlasses = Glass::withCount(['skus' => function ($query) use($filterParams) {
            $filterParams['glasses'] = null;
            
            $query->withFilters($filterParams);
        }])->orderBy('skus_count', 'desc')->orderBy('name')->get();

        $filteredInnerDecors = InnerDecor::withCount(['skus' => function ($query) use($filterParams) {
            $filterParams['innerdecors'] = null;
            
            $query->withFilters($filterParams);
        }])->orderBy('skus_count', 'desc')->orderBy('name')->get();

        $filteredPurposes = Purpose::withCount(['skus' => function ($query) use($filterParams) {
            $filterParams['purposes'] = null;
            
            $query->withFilters($filterParams);
        }])->orderBy('skus_count', 'desc')->orderBy('name')->get();

        $filteredFurnitureTypes = FurnitureType::withCount(['skus' => function ($query) use($filterParams) {
            $filterParams['furnituretypes'] = null;
            
            $query->withFilters($filterParams);
        }])->orderBy('skus_count', 'desc')->orderBy('name')->get();
        
        return response()->json([
            'types' => $filteredTypes,
            'styles' => $filteredStyles,
            'surfaces' => $filteredSurfaces,
            'colors' => $filteredColors,
            'glasses' => $filteredGlasses,
            'innerdecors' => $filteredInnerDecors,
            'purposes' => $filteredPurposes,
            'furnituretypes' => $filteredFurnitureTypes,
        ]);
    }
}
