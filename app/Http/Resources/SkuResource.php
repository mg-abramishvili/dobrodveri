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
            'link' => $link,
        ];
    }
}
