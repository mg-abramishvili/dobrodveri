<?php

use App\Models\MainSlider;
use Illuminate\Support\Facades\Route;

// HOME PAGE
Route::get('/', function () {
    $mainSlider = MainSlider::all();

    return view('home', ['mainSlider' => $mainSlider]);
});

Route::get('p/{slug}', [App\Http\Controllers\PageController::class, 'page'])->name('page');

Route::post('lead', [App\Http\Controllers\LeadController::class, 'store'])->name('lead');
Route::post('review', [App\Http\Controllers\ReviewController::class, 'store'])->name('review');

// CATALOG
Route::get('catalog', [App\Http\Controllers\CategoryController::class, 'index'])->name('catalog');
Route::get('catalog/{categorySlug}', [App\Http\Controllers\CategoryController::class, 'category'])->name('category');

// PRODUCTS
Route::get('products', [App\Http\Controllers\ProductController::class, 'index']);
Route::get('_products', [App\Http\Controllers\ProductController::class, 'indexData']);
Route::get('_product_skus', [App\Http\Controllers\SkuController::class, 'indexData']);
Route::get('product/{productSlug}', [App\Http\Controllers\ProductController::class, 'product'])->name('product');

// FAVORITES
Route::view('favorites', 'favorites');
Route::get('_favorites', function () {
    return session('favorites');
});
Route::post('_favorites', [App\Http\Controllers\SkuController::class, 'addToFavorite']);

// ADMIN
Route::get('admin', function () {
    return view('layouts.admin');
})->middleware(['auth']);

Route::prefix("admin")->middleware(['auth'])->group(function() {
    Route::get('{any}', function () {
        return view('layouts.admin');
    })->where('any', '.*');
});

// ADMIN PRODUCTS
Route::get('_admin/products', [App\Http\Controllers\Admin\ProductController::class, 'index']);
Route::get('_admin/deactivated-products', [App\Http\Controllers\Admin\ProductController::class, 'indexDeactivated']);
Route::get('_admin/product/{id}', [App\Http\Controllers\Admin\ProductController::class, 'product']);
Route::post('_admin/products', [App\Http\Controllers\Admin\ProductController::class, 'store']);
Route::put('_admin/product/{id}/update', [App\Http\Controllers\Admin\ProductController::class, 'update']);
Route::put('_admin/product/{id}/deactivate', [App\Http\Controllers\Admin\ProductController::class, 'deactivate']);
Route::put('_admin/product/{id}/activate', [App\Http\Controllers\Admin\ProductController::class, 'activate']);
Route::delete('_admin/product/{id}/delete', [App\Http\Controllers\Admin\ProductController::class, 'delete']);

// ADMIN SKU's
Route::post('_admin/skus', [App\Http\Controllers\Admin\SkuController::class, 'store']);
Route::put('_admin/sku/{id}/update', [App\Http\Controllers\Admin\SkuController::class, 'update']);
Route::delete('_admin/sku/{id}/delete', [App\Http\Controllers\Admin\SkuController::class, 'delete']);

// ADMIN CATEGORIES
Route::get('_admin/categories', [App\Http\Controllers\Admin\CategoryController::class, 'index']);
Route::get('_admin/category/{id}', [App\Http\Controllers\Admin\CategoryController::class, 'category']);
Route::post('_admin/categories', [App\Http\Controllers\Admin\CategoryController::class, 'store']);
Route::put('_admin/category/{id}/update', [App\Http\Controllers\Admin\CategoryController::class, 'update']);
Route::delete('_admin/category/{id}/delete', [App\Http\Controllers\Admin\CategoryController::class, 'delete']);

// ADMIN COLORS
Route::get('_admin/colors', [App\Http\Controllers\Admin\ColorController::class, 'index']);
Route::get('_admin/color/{id}', [App\Http\Controllers\Admin\ColorController::class, 'color']);
Route::post('_admin/colors', [App\Http\Controllers\Admin\ColorController::class, 'store']);
Route::put('_admin/color/{id}/update', [App\Http\Controllers\Admin\ColorController::class, 'update']);
Route::delete('_admin/color/{id}/delete', [App\Http\Controllers\Admin\ColorController::class, 'delete']);

// ADMIN STYLES
Route::get('_admin/styles', [App\Http\Controllers\Admin\StyleController::class, 'index']);
Route::get('_admin/style/{id}', [App\Http\Controllers\Admin\StyleController::class, 'style']);
Route::post('_admin/styles', [App\Http\Controllers\Admin\StyleController::class, 'store']);
Route::put('_admin/style/{id}/update', [App\Http\Controllers\Admin\StyleController::class, 'update']);
Route::delete('_admin/style/{id}/delete', [App\Http\Controllers\Admin\StyleController::class, 'delete']);

// ADMIN FACTORIES
Route::get('_admin/factories', [App\Http\Controllers\Admin\FactoryController::class, 'index']);
Route::get('_admin/factory/{id}', [App\Http\Controllers\Admin\FactoryController::class, 'factory']);
Route::post('_admin/factories', [App\Http\Controllers\Admin\FactoryController::class, 'store']);
Route::put('_admin/factory/{id}/update', [App\Http\Controllers\Admin\FactoryController::class, 'update']);
Route::delete('_admin/factory/{id}/delete', [App\Http\Controllers\Admin\FactoryController::class, 'delete']);

// ADMIN SURFACES
Route::get('_admin/surfaces', [App\Http\Controllers\Admin\SurfaceController::class, 'index']);
Route::get('_admin/surface/{id}', [App\Http\Controllers\Admin\SurfaceController::class, 'surface']);
Route::post('_admin/surfaces', [App\Http\Controllers\Admin\SurfaceController::class, 'store']);
Route::put('_admin/surface/{id}/update', [App\Http\Controllers\Admin\SurfaceController::class, 'update']);
Route::delete('_admin/surface/{id}/delete', [App\Http\Controllers\Admin\SurfaceController::class, 'delete']);

// ADMIN CONSTRUCTS
Route::get('_admin/constructs', [App\Http\Controllers\Admin\ConstructController::class, 'index']);
Route::get('_admin/construct/{id}', [App\Http\Controllers\Admin\ConstructController::class, 'construct']);
Route::post('_admin/constructs', [App\Http\Controllers\Admin\ConstructController::class, 'store']);
Route::put('_admin/construct/{id}/update', [App\Http\Controllers\Admin\ConstructController::class, 'update']);
Route::delete('_admin/construct/{id}/delete', [App\Http\Controllers\Admin\ConstructController::class, 'delete']);

// ADMIN TYPES
Route::get('_admin/types', [App\Http\Controllers\Admin\TypeController::class, 'index']);
Route::get('_admin/type/{id}', [App\Http\Controllers\Admin\TypeController::class, 'type']);
Route::post('_admin/types', [App\Http\Controllers\Admin\TypeController::class, 'store']);
Route::put('_admin/type/{id}/update', [App\Http\Controllers\Admin\TypeController::class, 'update']);
Route::delete('_admin/type/{id}/delete', [App\Http\Controllers\Admin\TypeController::class, 'delete']);

// ADMIN PURPOSES
Route::get('_admin/purposes', [App\Http\Controllers\Admin\PurposeController::class, 'index']);
Route::get('_admin/purpose/{id}', [App\Http\Controllers\Admin\PurposeController::class, 'purpose']);
Route::post('_admin/purposes', [App\Http\Controllers\Admin\PurposeController::class, 'store']);
Route::put('_admin/purpose/{id}/update', [App\Http\Controllers\Admin\PurposeController::class, 'update']);
Route::delete('_admin/purpose/{id}/delete', [App\Http\Controllers\Admin\PurposeController::class, 'delete']);

// ADMIN INNER DECORS
Route::get('_admin/innerdecors', [App\Http\Controllers\Admin\InnerDecorController::class, 'index']);
Route::get('_admin/innerdecor/{id}', [App\Http\Controllers\Admin\InnerDecorController::class, 'innerdecor']);
Route::post('_admin/innerdecors', [App\Http\Controllers\Admin\InnerDecorController::class, 'store']);
Route::put('_admin/innerdecor/{id}/update', [App\Http\Controllers\Admin\InnerDecorController::class, 'update']);
Route::delete('_admin/innerdecor/{id}/delete', [App\Http\Controllers\Admin\InnerDecorController::class, 'delete']);

// ADMIN FURNITURE TYPES
Route::get('_admin/furnituretypes', [App\Http\Controllers\Admin\FurnitureTypeController::class, 'index']);
Route::get('_admin/furnituretype/{id}', [App\Http\Controllers\Admin\FurnitureTypeController::class, 'furnituretype']);
Route::post('_admin/furnituretypes', [App\Http\Controllers\Admin\FurnitureTypeController::class, 'store']);
Route::put('_admin/furnituretype/{id}/update', [App\Http\Controllers\Admin\FurnitureTypeController::class, 'update']);
Route::delete('_admin/furnituretype/{id}/delete', [App\Http\Controllers\Admin\FurnitureTypeController::class, 'delete']);

// ADMIN GLASSES
Route::get('_admin/glasses', [App\Http\Controllers\Admin\GlassController::class, 'index']);
Route::get('_admin/glass/{id}', [App\Http\Controllers\Admin\GlassController::class, 'glass']);
Route::post('_admin/glasses', [App\Http\Controllers\Admin\GlassController::class, 'store']);
Route::put('_admin/glass/{id}/update', [App\Http\Controllers\Admin\GlassController::class, 'update']);
Route::delete('_admin/glass/{id}/delete', [App\Http\Controllers\Admin\GlassController::class, 'delete']);

// ADMIN SIZES
Route::get('_admin/sizes', [App\Http\Controllers\Admin\SizeController::class, 'index']);
Route::get('_admin/size/{id}', [App\Http\Controllers\Admin\SizeController::class, 'size']);
Route::post('_admin/sizes', [App\Http\Controllers\Admin\SizeController::class, 'store']);
Route::put('_admin/size/{id}/update', [App\Http\Controllers\Admin\SizeController::class, 'update']);
Route::delete('_admin/size/{id}/delete', [App\Http\Controllers\Admin\SizeController::class, 'delete']);

// ADMIN MAINSLIDER
Route::get('_admin/mainslider', [App\Http\Controllers\Admin\MainSliderController::class, 'index']);
Route::post('_admin/mainslides', [App\Http\Controllers\Admin\MainSliderController::class, 'store']);
Route::get('_admin/mainslide/{id}', [App\Http\Controllers\Admin\MainSliderController::class, 'slide']);
Route::put('_admin/mainslide/{id}/update', [App\Http\Controllers\Admin\MainSliderController::class, 'update']);
Route::delete('_admin/mainslide/{id}/delete', [App\Http\Controllers\Admin\MainSliderController::class, 'delete']);

// ADMIN LEADS
Route::get('_admin/leads', [App\Http\Controllers\Admin\LeadController::class, 'index']);
Route::get('_admin/lead/{id}', [App\Http\Controllers\Admin\LeadController::class, 'lead']);

// ADMIN REVIEWS
Route::get('_admin/reviews', [App\Http\Controllers\Admin\ReviewController::class, 'index']);
Route::put('_admin/review/{id}/update', [App\Http\Controllers\Admin\ReviewController::class, 'update']);
Route::delete('_admin/review/{id}/delete', [App\Http\Controllers\Admin\ReviewController::class, 'delete']);

// ADMIN PAGES
Route::get('_admin/pages', [App\Http\Controllers\Admin\PageController::class, 'index']);
Route::post('_admin/pages', [App\Http\Controllers\Admin\PageController::class, 'store']);
Route::get('_admin/page/{id}', [App\Http\Controllers\Admin\PageController::class, 'page']);
Route::put('_admin/page/{id}/update', [App\Http\Controllers\Admin\PageController::class, 'update']);

// ADMIN FILE UPLOAD
Route::post('_admin/file/upload', [App\Http\Controllers\Admin\FileController::class, 'store']);

// AUTH
require __DIR__.'/auth.php';