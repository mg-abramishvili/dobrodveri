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

    public function removeFromFavorite($skuID)
    {
        $favorites = session()->get('favorites', []);
        
        unset($favorites[$skuID]);
        
        if(count($favorites) > 0) {
            session()->put('favorites', $favorites);
        } else {
            session()->forget('favorites');
        }
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

        $perPage = 30;

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
            'skus' => SkuResource::collection($skus),
            'pagination' => $pagination,
        ]);
    }
}
