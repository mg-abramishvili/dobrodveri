<?php

namespace App\Traits;

use App\Models\Sku;
use App\Http\Resources\SkuResource;
use Illuminate\Http\Request;

trait getSkus {

    public function getSkus($filterParams, $perPage)
    {
        $skus = Sku::withFilters($filterParams)->get();
        
        if($filterParams['priceFrom']) {
            $skus = $skus->where('price_sort', '>=', $filterParams['priceFrom']);
        }
        if($filterParams['priceTo']) {
            $skus = $skus->where('price_sort', '<=', $filterParams['priceTo']);
        }
        
        $pagination['total_pages'] = round($skus->count() / $perPage);
        $pagination['current_page'] = (int)$filterParams['page'];

        if($filterParams['order'] == 'price_asc') {
            $skus = $skus->sortBy('price_sort');
        }
        if($filterParams['order'] == 'price_desc') {
            $skus = $skus->sortByDesc('price_sort');
        }
        if($filterParams['order'] == 'popular') {
            $skus = $skus->sortByDesc('popular_sort');
        }

        $skus = $skus->skip(($perPage * $filterParams['page']) - $perPage)->take($perPage);

        return response()->json([
            'skus' => SkuResource::collection($skus),
            'pagination' => $pagination,
        ]);
    }

}