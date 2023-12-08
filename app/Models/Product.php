<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function skus()
    {
        return $this->hasMany(Sku::class)->orderBy('order', 'asc');
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class)->orderBy('slug');
    }

    public function style()
    {
        return $this->belongsTo(Style::class);
    }

    public function construct()
    {
        return $this->belongsTo(Construct::class);
    }

    public function surface()
    {
        return $this->belongsTo(Surface::class);
    }

    public function factory()
    {
        return $this->belongsTo(Factory::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function purpose()
    {
        return $this->belongsTo(Purpose::class);
    }

    public function furnituretype()
    {
        return $this->belongsTo(FurnitureType::class, 'furniture_type_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getPriceSortAttribute()
    {
        return $this->skus->first() && $this->skus->first()->price ? $this->skus->first()->price : $this->price;
    }

    // public function scopeWithFilters($query, $category_id, $types, $styles, $surfaces, $priceFrom, $priceTo)
    // {
    //     return $query
    //         ->where('is_active', 1)
    //         ->where('category_id', $category_id)
    //         ->when(isset($types), function ($query) use ($types) {
    //             $query->whereHas('type', function($query) use($types) {
    //                 $query->whereIn('slug', $types);
    //             });
    //         })
    //         ->when(isset($styles), function ($query) use ($styles) {
    //             $query->whereHas('style', function($query) use($styles) {
    //                 $query->whereIn('slug', $styles);
    //             });
    //         })
    //         ->when(isset($surfaces), function ($query) use ($surfaces) {
    //             $query->whereHas('surface', function($query) use($surfaces) {
    //                 $query->whereIn('slug', $surfaces);
    //             });
    //         })
    //         ->when(isset($priceFrom), function ($query) use ($priceFrom) {
    //             $query->where('price', '>=', $priceFrom);
    //         })
    //         ->when(isset($priceTo), function ($query) use ($priceTo) {
    //             $query->where('price', '<=', $priceTo);
    //         });
    // }
}
