<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Models\Style;
use App\Models\Surface;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function index(Request $request)
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

        return response()->json([
            'types' => $filteredTypes,
            'styles' => $filteredStyles,
            'surfaces' => $filteredSurfaces,
        ]);
    }
}
