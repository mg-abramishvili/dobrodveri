<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductsResource;
use App\Traits\storeInRecentlyViewed;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use storeInRecentlyViewed;

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

        $productResource = new ProductResource($product);

        $this->storeInRecentlyViewed(json_encode(new ProductsResource($product)));

        return view('product', ['product' => json_encode($productResource)]);
    }
}
