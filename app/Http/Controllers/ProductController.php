<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Models\Type;
use App\Models\Style;
use App\Models\Surface;
use App\Traits\storeInRecentlyViewed;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use storeInRecentlyViewed;

    public function indexData(Request $request)
    {
        $page = $request->page ? $request->page : 1;

        $perPage = 30;

        $products = Product::query()
                    ->where('category_id', $request->category_id)
                    ->where('is_active', 1)
                    ->whereHas('skus')
                    ->orderBy('price', 'asc')
                    ->skip(($perPage * $page) - $perPage)
                    ->take($perPage)
                    ->get();
        
        $pagination['total_pages'] = round($products->count() / $perPage);
        $pagination['current_page'] = (int)$page;
        
        return response()->json([
            'products' => ProductResource::collection($products),
            'pagination' => $pagination,
        ]);
    }

    public function product($productSlug)
    {
        $product = Product::where('slug', $productSlug)->first();
        
        if(!$product)
        {
            return view('404');
        }

        $product->timestamps = false;
        $product->increment('view_counter');
        
        if($product->view_counter >= 50) {
            $product->hit = true;
        }
        
        $product->save();

        $productResource = new ProductResource(Product::where('slug', $productSlug)->first());

        $this->storeInRecentlyViewed(json_encode($productResource));

        return view('product', ['product' => json_encode($productResource)]);
    }
}
