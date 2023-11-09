<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Glass;
use App\Models\InnerDecor;
use App\Models\Purpose;
use App\Models\Surface;
use App\Models\Type;
use App\Models\FurnitureType;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function index($category_id)
    {
        return response()->json([
            'colors' => Color::where(function ($q) use($category_id) { $q->whereRelation('skus.product', 'category_id', $category_id); })->get(),
            'glasses' => Glass::all(),
            'types' => Type::all(),
            'innerdecors' => InnerDecor::all(),
            'purposes' => Purpose::all(),
            'surfaces' => Surface::all(),
            'furnituretypes' => FurnitureType::all(),
        ]);
    }
}
