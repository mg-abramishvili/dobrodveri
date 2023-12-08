<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductColorResource;
use App\Models\Promo;

class ProductsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $colors = $this->skus->unique('color_id')->values()->all();
        $price = $this->skus->count() && $this->skus->first()->price ? $this->skus->first()->price : $this->price;
        $oldPrice = $this->factory && $this->factory->coef ? round($price * $this->factory->coef / 10) * 10 : null;
        $percent = $oldPrice ?  round((1 - $price / $oldPrice) * 100, 0) : null;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'image' => $this->skus->count() && $this->skus->first()->image ? $this->skus->first()->image : null,
            'vkhod_image' => $this->vkhod_image,
            'price' => $price,
            'old_price' => $oldPrice,
            'percent' => $percent ? '-' . $percent . '%' : null,
            'colors' => count($colors) > 0 ? ProductColorResource::collection(array_slice($colors, 0, 6)) : null,
            'other_colors' => count($colors) > 3 ? ProductColorResource::collection(array_slice($colors, 6)) : null,
            'hit' => $this->hit,
            'special' => $this->special,
            'balance' => $this->balance,
            'first_sku_id' => $this->skus->count() && $this->skus->first() ? $this->skus->first()->id : null,
        ];
    }
}
