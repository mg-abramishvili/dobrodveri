<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function product($productSlug)
    {
        $product = Product::query()
            ->where('slug', $productSlug)
            ->with([
                'category',
                'skus.color',
                'skus.glass',
                'skus.innerdecor',
                'sizes',
                'factory',
                'surface',
                'construct',
                'style',
                'type',
                'purpose',
                'furnituretype',
                'reviews' => function($q) {
                    $q->where('is_active', true);
                }
            ])
            ->first();
        
        $product->view_counter = $product->view_counter + 1;
        
        if($product->view_counter >= 50) {
            $product->hit = true;
        }
        
        $product->save();
        
        return view('products.product', compact('product'));
    }
}
