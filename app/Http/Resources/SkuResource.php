<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductColorResource;

class SkuResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $linkInitial = "/" . "product" . "/" . $this->product->slug;
        $linkParams = [];
        
        if($this->color) {
            $linkParams[] = '&color=' . $this->color->slug;
        }
        if($this->glass) {
            $linkParams[] = '&glass=' . $this->glass->slug;
        }
        
        $link = count($linkParams) > 0 ? $linkInitial . '?' . implode("", $linkParams) : $linkInitial;


        $price = $this->price ? $this->price : $this->product->price;
        $oldPrice = $this->product->factory && $this->product->factory->coef ? round($price * $this->product->factory->coef / 10) * 10 : null;


        return [
            'id' => $this->id,
            'name' => $this->product->name,
            'slug' => $this->product->slug,
            'style' => $this->product->style,
            'type' => $this->product->type,
            'surface' => $this->product->surface,
            'color' => $this->color,
            'color_id' => $this->color_id,
            'glass' => $this->glass,
            'glass_id' => $this->glass_id,
            'image' => $this->image,
            'price' => $price,
            'old_price' => $oldPrice,
            'all_colors' => ProductColorResource::collection($this->product->skus->unique('color_id')->values()->all()),
            'link' => $link,
        ];
    }
}
