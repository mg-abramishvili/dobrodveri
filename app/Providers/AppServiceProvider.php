<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use App\Models\Product;
use App\Http\Resources\ProductResource;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (Schema::hasTable('categories') && Schema::hasTable('products'))
        {
            $categories = Category::all();
            $popularProducts = ProductResource::collection(Product::where('view_counter', '>=', 50)->orderBy('view_counter', 'desc')->take(8)->get());

            View::share([
                'categories' => $categories,
                'popularProducts' => json_encode($popularProducts),
            ]);
        }
    }
}
