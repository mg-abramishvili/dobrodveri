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
        $products = Product::query()
                    ->where('category_id', $request->category_id)
                    ->where('is_active', 1)
                    ->whereHas('skus')
                    ->with('skus')
                    ->orderBy('price', 'asc')
                    ->paginate(30);
        
        return $products;
    }

    public function product($productSlug)
    {
        $product = Product::where('slug', $productSlug)->first();
        
        if(!$product)
        {
            return view('404');
        }

        $product->increment('view_counter');
        
        if($product->view_counter >= 50) {
            $product->hit = true;
        }
        
        $product->timestamps = false;
        $product->save();

        $productResource = new ProductResource(Product::where('slug', $productSlug)->first());

        $this->storeInRecentlyViewed(json_encode($productResource));

        return view('product', ['product' => json_encode($productResource)]);
    }
}
