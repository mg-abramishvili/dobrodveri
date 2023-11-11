<?php

namespace App\Http\Controllers;

use App\Models\Surface;
use App\Models\Type;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function index(Request $request)
    {
        $category_id = $request->category_id;
        $types = $request->types;
        $surfaces = $request->surfaces;

        $filteredTypes = Type::withCount(['products' => function ($query) use($types, $surfaces) {
            $query->withFilters($types, $surfaces);
        }])->get();

        $filteredSurfaces = Surface::withCount(['products' => function ($query) use($types, $surfaces) {
            $query->withFilters($types, $surfaces);
        }])->get();

        return response()->json([
            'types' => $filteredTypes,
            'surfaces' => $filteredSurfaces,
        ]);
    }
}
