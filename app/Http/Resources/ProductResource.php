<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductColorResource;
use App\Http\Resources\ProductGlassResource;
use App\Http\Resources\ProductInnerDecorResource;
use App\Http\Resources\ProductReviewResource;
use App\Http\Resources\SkuResource;
use App\Models\Promo;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $price = $this->price;
        $oldPrice = $this->factory && $this->factory->coef ? round($this->price * $this->factory->coef / 10) * 10 : null;
        $percent = $oldPrice ?  round((1 - $price / $oldPrice) * 100, 0) : null;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'category' => $this->category,
            'description' => $this->description,
            'image' => $this->skus->count() && $this->skus->first()->image ? $this->skus->first()->image : null,
            'vkhod_image' => $this->vkhod_image,
            'style' => $this->style ? $this->style->name : null,
            'type' => $this->type ? $this->type->name : null,
            'construct' => $this->construct ? $this->construct->name : null,
            'surface' => $this->surface ? $this->surface->name : null,
            'sizes' => $this->sizes,
            'price' => $price,
            'old_price' => $oldPrice,
            'percent' => $percent ? '-' . $percent . '%' : null,
            'skus' => SkuResource::collection($this->skus),
            'colors' => ProductColorResource::collection($this->skus->unique('color_id')->values()->all()),
            'glasses' => ProductGlassResource::collection($this->skus->where('glass_id', '!=', null)->unique('glass_id')->values()->all()),
            'inner_decors' => ProductInnerDecorResource::collection($this->skus->where('inner_decor_id', '!=', null)->unique('inner_decor_id')->values()->all()),
            'reviews' => ProductReviewResource::collection($this->reviews->where('is_active', 1)),
            'rating' => $this->reviews->where('is_active', 1)->count() ? $this->reviews->where('is_active', 1)->sum('rating') / $this->reviews->where('is_active', 1)->count() : null,
            'balance' => $this->balance,
            'view_counter' => $this->view_counter,
            'promos' => Promo::whereRelation('factories', 'factories.id', $this->factory_id)->orWhereDoesntHave('factories')->orderBy('created_at', 'desc')->get(),
            'balance' => $this->balance,
            'hit' => $this->hit,
            'sale' => $this->sale,
            'discount' => $this->discount,
            'special' => $this->special,
            'purpose' => $this->purpose ? $this->purpose->name : null,
            'napolnenie' => $this->napolnenie,
            'tolschina_polotna' => $this->tolschina_polotna,
            'tolschina_metalla' => $this->tolschina_metalla,
            'vnutr_panel' => $this->vnutr_panel,
            'zamok' => $this->zamok,
            'termorazryv' => $this->termorazryv,
            'noch_zadvizh' => $this->noch_zadvizh,
            'rebra_zh' => $this->rebra_zh,
        ];
    }
}
