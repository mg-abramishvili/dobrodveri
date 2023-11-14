<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductGlassResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->glass->id,
            'name' => $this->glass->name,
            'image' => $this->glass->image,
        ];
    }
}