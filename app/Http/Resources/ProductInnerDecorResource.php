<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductInnerDecorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->innerdecor->id,
            'name' => $this->innerdecor->name,
            'slug' => $this->innerdecor->slug,
        ];
    }
}