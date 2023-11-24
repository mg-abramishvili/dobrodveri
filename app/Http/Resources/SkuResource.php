<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'image' => $this->image,
            'price' => $this->price ? $this->price : $this->product->price,
        ];
    }
}
