<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductColorResource;

class SkuResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->product->name,
            'slug' => $this->product->slug,
            'style' => $this->product->style,
            'type' => $this->product->type,
            'surface' => $this->product->surface,
            'color' => $this->color,
            'glass' => $this->glass,
            'image' => $this->image,
            'price' => $this->price ? $this->price : $this->product->price,
            'all_colors' => ProductColorResource::collection($this->product->skus->unique('color_id')->values()->all()),
        ];
    }
}
