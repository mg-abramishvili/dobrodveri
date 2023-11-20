<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductColorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->color->id,
            'name' => $this->color->name,
            'slug' => $this->color->slug,
            'image' => $this->color->image,
        ];
    }
}