<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use App\Models\Product;
use App\Models\Page;
use App\Models\Promo;
use App\Http\Resources\ProductsResource;

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
            $popularProducts = Product::where('is_active', 1)
                                        ->where('category_id', 1)
                                        ->orWhere('category_id', 2)
                                        // ->where('view_counter', '>=', 50)
                                        ->orderBy('view_counter', 'desc')
                                        ->take(12)
                                        ->get();

            $shareData['popularProducts'] = json_encode(ProductsResource::collection($popularProducts));
        }

        if (Schema::hasTable('pages'))
        {
            $pages = Page::where('is_folder1', false)
                            ->where('is_folder2', false)
                            ->where('order', '<', 1000)
                            ->orderBy('order', 'asc')
                            ->get();

            $pagesAbout = Page::where('order', '>=', 1000)->get();
            
            $shareData['pages'] = $pages;
            $shareData['pagesAbout'] = $pagesAbout;
        }

        if (Schema::hasTable('promos'))
        {
            $promoCounter = Promo::all()->count();

            $shareData['promoCounter'] = $promoCounter;
        }
        
        View::share($shareData);
    }
}
