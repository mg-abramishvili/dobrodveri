<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Glass extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function skus()
    {
        return $this->hasMany(Sku::class);
    }
}
