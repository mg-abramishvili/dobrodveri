<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductColorResource;
use App\Http\Resources\ProductGlassResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'skus' => $this->skus,
            'colors' => ProductColorResource::collection($this->skus->unique('color_id')->values()->all()),
            'glasses' => ProductGlassResource::collection($this->skus->where('glass_id', '!=', null)->unique('glass_id')->values()->all()),
        ];
    }
}
