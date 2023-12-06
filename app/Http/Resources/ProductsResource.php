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

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'image' => $this->skus->count() && $this->skus->first()->image ? $this->skus->first()->image : null,
            'vkhod_image' => $this->vkhod_image,
            'price' => $this->skus->count() && $this->skus->first()->price ? $this->skus->first()->price : $this->price,
            'colors' => count($colors) > 0 ? ProductColorResource::collection(array_slice($colors, 0, 3)) : null,
            'other_colors' => count($colors) > 3 ? ProductColorResource::collection(array_slice($colors, 3)) : null,
        ];
    }
}
