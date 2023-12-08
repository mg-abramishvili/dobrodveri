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
        if($this->innerdecor) {
            $linkParams[] = '&inner_decor=' . $this->innerdecor->slug;
        }
        
        $link = count($linkParams) > 0 ? $linkInitial . '?' . implode("", $linkParams) : $linkInitial;

        $colors = $this->product->skus->unique('color_id')->values()->all();

        $price = $this->price ? $this->price : $this->product->price;
        $oldPrice = $this->product->factory && $this->product->factory->coef ? round($price * $this->product->factory->coef / 10) * 10 : null;
        $percent = $oldPrice ?  round((1 - $price / $oldPrice) * 100, 0) : null;

        return [
            'id' => $this->id,
            'name' => $this->product->name,
            'slug' => $this->product->slug,
            'style' => $this->product->style,
            'type' => $this->product->type,
            'surface' => $this->product->surface,
            'color' => $this->color,
            'color_id' => $this->color_id,
            'glass' => $this->glass ? $this->glass : null,
            'glass_id' => $this->glass_id ? $this->glass_id : null,
            'inner_decor' => $this->innerdecor ? $this->innerdecor : null,
            'inner_decor_id' => $this->inner_decor_id ? $this->inner_decor_id : null,
            'image' => $this->image,
            'price' => $price,
            'old_price' => $oldPrice,
            'percent' => $percent ? '-' . $percent . '%' : null,
            'colors' => count($colors) > 0 ? ProductColorResource::collection(array_slice($colors, 0, 6)) : null,
            'other_colors' => count($colors) > 3 ? ProductColorResource::collection(array_slice($colors, 6)) : null,
            'link' => $link,
            'balance' => $this->product->balance,
            'hit' => $this->product->hit,
            'special' => $this->product->special,
        ];
    }
}
