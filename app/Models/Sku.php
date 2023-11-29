<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sku extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function type()
    {
        return $this->hasOneThrough(Type::class, Product::class, 'id', 'id', 'product_id', 'type_id');
    }

    public function style()
    {
        return $this->hasOneThrough(Style::class, Product::class, 'id', 'id', 'product_id', 'style_id');
    }

    public function surface()
    {
        return $this->hasOneThrough(Surface::class, Product::class, 'id', 'id', 'product_id', 'surface_id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function glass()
    {
        return $this->belongsTo(Glass::class);
    }

    public function innerdecor()
    {
        return $this->belongsTo(InnerDecor::class, 'inner_decor_id');
    }

    public function scopeWithFilters($query, $category_id, $types, $styles, $surfaces, $colors, $glasses)
    {
        return $query
            ->whereRelation('product', 'category_id', $category_id)
            ->whereRelation('product', 'is_active', true)
            ->when(isset($types), function ($query) use ($types) {
                $query->whereHas('type', function($query) use($types) {
                    $query->whereIn('types.slug', $types);
                });
            })
            ->when(isset($styles), function ($query) use ($styles) {
                $query->whereHas('style', function($query) use($styles) {
                    $query->whereIn('styles.slug', $styles);
                });
            })
            ->when(isset($surfaces), function ($query) use ($surfaces) {
                $query->whereHas('surface', function($query) use($surfaces) {
                    $query->whereIn('surfaces.slug', $surfaces);
                });
            })
            ->when(isset($colors), function ($query) use ($colors) {
                $query->whereHas('color', function($query) use($colors) {
                    $query->whereIn('colors.slug', $colors);
                });
            })
            ->when(isset($glasses), function ($query) use ($glasses) {
                $query->whereHas('glass', function($query) use($glasses) {
                    $query->whereIn('glasses.slug', $glasses);
                });
            });
    }
}
