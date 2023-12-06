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
use App\Traits\getSkus;
use Illuminate\Http\Request;

class SkuController extends Controller
{
    use getSkus;

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
        $filterParams['category_id'] = $request->category_id;
        $filterParams['priceFrom'] = $request->price_from;
        $filterParams['priceTo'] = $request->price_to;
        $filterParams['types'] = $request->types;
        $filterParams['styles'] = $request->styles;
        $filterParams['surfaces'] = $request->surfaces;
        $filterParams['colors'] = $request->colors;
        $filterParams['glasses'] = $request->glasses;
        $filterParams['page'] = $request->page ? $request->page : 1;
        $filterParams['order'] = $request->order ? $request->order : 'price_asc';
        
        $perPage = 30;
        
        return $this->getSkus($filterParams, $perPage);
    }
}
