<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductColorResource;
use App\Http\Resources\ProductGlassResource;
use App\Http\Resources\ProductReviewResource;
use App\Models\Promo;

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
            'style' => $this->style ? $this->style->name : null,
            'type' => $this->type ? $this->type->name : null,
            'construct' => $this->construct ? $this->construct->name : null,
            'surface' => $this->surface ? $this->surface->name : null,
            'factory_coef' => $this->factory ? $this->factory->coef : null,
            'sizes' => $this->sizes,
            'price' => $this->price,
            'skus' => $this->skus->load('color', 'glass', 'innerdecor'),
            'colors' => ProductColorResource::collection($this->skus->unique('color_id')->values()->all()),
            'glasses' => ProductGlassResource::collection($this->skus->where('glass_id', '!=', null)->unique('glass_id')->values()->all()),
            'reviews' => ProductReviewResource::collection($this->reviews->where('is_active', 1)),
            'rating' => $this->reviews->where('is_active', 1)->count() ? $this->reviews->where('is_active', 1)->sum('rating') / $this->reviews->where('is_active', 1)->count() : null,
            'balance' => $this->balance,
            'view_counter' => $this->view_counter,
            'promos' => Promo::whereRelation('factories', 'factories.id', $this->factory_id)->orWhereDoesntHave('factories')->orderBy('created_at', 'desc')->get(),
        ];
    }
}
