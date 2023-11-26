<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use App\Models\Product;
use App\Models\Page;
use App\Http\Resources\ProductResource;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $shareData = [];

        if (Schema::hasTable('categories'))
        {
            $categories = Category::all();
            
            $shareData['categories'] = $categories;
        }

        if (Schema::hasTable('products'))
        {
            $popularProducts = ProductResource::collection(Product::where('is_active', 1)->where('view_counter', '>=', 50)->orderBy('view_counter', 'desc')->take(8)->get());

            $shareData['popularProducts'] = json_encode($popularProducts);
        }

        if (Schema::hasTable('pages'))
        {
            $pages = Page::get();
            
            $shareData['pages'] = $pages;
        }
        
        View::share($shareData);
    }
}
