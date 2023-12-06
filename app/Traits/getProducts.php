<?php

namespace App\Traits;

use App\Models\Product;
use App\Http\Resources\ProductsResource;
use Illuminate\Http\Request;

trait getProducts {

    public function getProducts($category_id, $page, $perPage)
    {
        $products = Product::query()
                    ->where('category_id', $category_id)
                    ->where('is_active', 1)
                    ->whereHas('skus');
        
        $pagination['total_pages'] = round($products->count() / $perPage);
        $pagination['current_page'] = (int)$page;

        $products = $products->orderBy('price', 'asc')
                    ->skip(($perPage * $page) - $perPage)
                    ->take($perPage)
                    ->get();
        
        return response()->json([
            'products' => ProductsResource::collection($products),
            'pagination' => $pagination,
        ]);
    }

}