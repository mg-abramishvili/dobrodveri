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
        return $this->hasMany(Sku::class);
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class);
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
}
