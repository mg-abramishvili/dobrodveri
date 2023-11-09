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
}
