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

    public function getPriceSortAttribute()
    {
        return $this->price ? $this->price : $this->product->price;
    }

    public function getPopularSortAttribute()
    {
        return $this->product->view_counter;
    }

    public function scopeWithFilters($query, $filterParams)
    {
        return $query
            ->whereRelation('product', 'category_id', $filterParams['category_id'])
            ->whereRelation('product', 'is_active', true)
            ->when(isset($filterParams['types']), function ($query) use ($filterParams) {
                $query->whereHas('type', function($query) use($filterParams) {
                    $query->whereIn('types.slug', $filterParams['types']);
                });
            })
            ->when(isset($filterParams['styles']), function ($query) use ($filterParams) {
                $query->whereHas('style', function($query) use($filterParams) {
                    $query->whereIn('styles.slug', $filterParams['styles']);
                });
            })
            ->when(isset($filterParams['colors']), function ($query) use ($filterParams) {
                $query->whereHas('color', function($query) use($filterParams) {
                    $query->whereIn('colors.slug', $filterParams['colors']);
                });
            })
            ->when(isset($filterParams['glasses']), function ($query) use ($filterParams) {
                $query->whereHas('glass', function($query) use($filterParams) {
                    $query->whereIn('glasses.slug', $filterParams['glasses']);
                });
            })
            ->when(isset($filterParams['surfaces']), function ($query) use ($filterParams) {
                $query->whereHas('surface', function($query) use($filterParams) {
                    $query->whereIn('surfaces.slug', $filterParams['surfaces']);
                });
            })
            ->when(isset($filterParams['innerdecors']), function ($query) use ($filterParams) {
                $query->whereHas('innerdecors', function($query) use($filterParams) {
                    $query->whereIn('innerdecors.slug', $filterParams['innerdecors']);
                });
            })
            ->when(isset($filterParams['purposes']), function ($query) use ($filterParams) {
                $query->whereHas('purposes', function($query) use($filterParams) {
                    $query->whereIn('purposes.slug', $filterParams['purposes']);
                });
            })
            ->when(isset($filterParams['furnituretypes']), function ($query) use ($filterParams) {
                $query->whereHas('furnituretypes', function($query) use($filterParams) {
                    $query->whereIn('furnituretypes.slug', $filterParams['furnituretypes']);
                });
            });
    }
}
