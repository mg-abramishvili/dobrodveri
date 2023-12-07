<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FurnitureType extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function skus()
    {
        return $this->hasManyThrough(Sku::class, Product::class);
    }
}
