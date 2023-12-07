<?php

namespace App\Traits;

use App\Models\Product;
use App\Http\Resources\ProductsResource;
use Illuminate\Http\Request;

trait getProducts {

    public function getProducts($category_id, $filterParams, $perPage)
    {
        $products = Product::query()
                    ->where('category_id', $category_id)
                    ->where('is_active', 1)
                    ->whereHas('skus')
                    ->when(isset($filterParams['priceFrom']), function ($query) use ($filterParams) {
                        $query->where('price', '>=', $filterParams['priceFrom']);
                    })
                    ->when(isset($filterParams['priceTo']), function ($query) use ($filterParams) {
                        $query->where('price', '<=', $filterParams['priceTo']);
                    })
                    ->get();
        
        $pagination['total_pages'] = round($products->count() / $perPage);
        $pagination['current_page'] = (int)$filterParams['page'];

        if($filterParams['order'] == 'price_asc') {
            $products = $products->sortBy('price_sort');
        }
        if($filterParams['order'] == 'price_desc') {
            $products = $products->sortByDesc('price_sort');
        }
        if($filterParams['order'] == 'popular') {
            $products = $products->sortByDesc('view_counter');
        }

        $products = $products->skip(($perPage * $filterParams['page']) - $perPage)->take($perPage);
        
        return response()->json([
            'products' => ProductsResource::collection($products),
            'pagination' => $pagination,
        ]);
    }

}