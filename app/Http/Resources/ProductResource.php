<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductColorResource;
use App\Http\Resources\ProductGlassResource;
use App\Http\Resources\ProductReviewResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'category' => $this->category,
            'description' => $this->description,
            'image' => $this->skus->count() && $this->skus->first()->image ? $this->skus->first()->image : null,
            'style' => $this->style->name,
            'type' => $this->type->name,
            'construct' => $this->construct->name,
            'surface' => $this->surface->name,
            'factory_coef' => $this->factory->coef,
            'sizes' => $this->sizes,
            'price' => $this->price,
            'skus' => $this->skus,
            'colors' => ProductColorResource::collection($this->skus->unique('color_id')->values()->all()),
            'glasses' => ProductGlassResource::collection($this->skus->where('glass_id', '!=', null)->unique('glass_id')->values()->all()),
            'reviews' => ProductReviewResource::collection($this->reviews->where('is_active', 1)),
            'rating' => $this->reviews->where('is_active', 1)->count() ? $this->reviews->where('is_active', 1)->sum('rating') / $this->reviews->where('is_active', 1)->count() : null,
            'view_counter' => $this->view_counter,
        ];
    }
}
