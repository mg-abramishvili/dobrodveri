<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Sku;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return Product::where('is_active', true)->get();
    }

    public function indexDeactivated()
    {
        return Product::where('is_active', false)->get();
    }

    public function product($id)
    {
        return Product::with('skus.color', 'skus.glass', 'skus.innerdecor', 'sizes', 'factory')->find($id);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'slug' => 'required',
            'price' => 'required|numeric',
            'category' => 'required',
        ];

        $this->validate($request, $rules);

        $productExists = Product::where('slug', $request->slug)->first();

        if($productExists) {
            return response('Такой симовльный код уже занят', 500);
        }

        $product = new Product();

        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->price = $request->price;
        $product->old_price = $request->old_price;
        $product->description = $request->description;
        $product->category_id = $request->category;
        $product->type_id = $request->type;
        $product->style_id = $request->style;
        $product->factory_id = $request->factory;
        $product->surface_id = $request->surface;
        $product->construct_id = $request->construct;
        $product->purpose_id = $request->purpose;
        $product->furniture_type_id = $request->furnituretype;
        $product->vkhod_image = $request->vkhod_image;
        $product->napolnenie = $request->napolnenie;
        $product->tolschina_polotna = $request->tolschina_polotna;
        $product->tolschina_metalla = $request->tolschina_metalla;
        $product->vnutr_panel = $request->vnutr_panel;
        $product->zamok = $request->zamok;
        $product->termorazryv = $request->termorazryv;
        $product->noch_zadvizh = $request->noch_zadvizh;
        $product->rebra_zh = $request->rebra_zh;

        $product->balance = $request->balance;

        $product->save();
    }

    public function update($id, Request $request)
    {
        $rules = [
            'name' => 'required',
            'slug' => 'required',
            'price' => 'required|numeric',
            'category' => 'required',
        ];

        $this->validate($request, $rules);

        $productExists = Product::where('id', '!=', $id)->where('slug', $request->slug)->first();

        if($productExists) {
            return response('Такой симовльный код уже занят', 500);
        }

        $product = Product::find($id);

        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->price = $request->price;
        $product->old_price = $request->old_price;
        $product->description = $request->description;
        $product->category_id = $request->category;
        $product->type_id = $request->type;
        $product->style_id = $request->style;
        $product->factory_id = $request->factory;
        $product->surface_id = $request->surface;
        $product->construct_id = $request->construct;
        $product->purpose_id = $request->purpose;
        $product->furniture_type_id = $request->furnituretype;
        $product->vkhod_image = $request->vkhod_image;
        $product->napolnenie = $request->napolnenie;
        $product->tolschina_polotna = $request->tolschina_polotna;
        $product->tolschina_metalla = $request->tolschina_metalla;
        $product->vnutr_panel = $request->vnutr_panel;
        $product->zamok = $request->zamok;
        $product->termorazryv = $request->termorazryv;
        $product->noch_zadvizh = $request->noch_zadvizh;
        $product->rebra_zh = $request->rebra_zh;

        $product->hit = $request->hit;
        $product->discount = $request->discount;
        $product->sale = $request->sale;
        $product->special = $request->special;

        $product->balance = $request->balance;

        $product->save();

        $product->sizes()->sync($request->sizes);

        foreach($request->sku_items as $skuItem)
        {
            $sku = Sku::find($skuItem['id']);

            $sku->price = $skuItem['price'];
            $sku->image = $skuItem['image'];

            $sku->save();
        }
    }

    public function deactivate($id)
    {
        $product = Product::find($id);

        $product->is_active = false;

        $product->save();
    }

    public function activate($id)
    {
        $product = Product::find($id);

        $product->is_active = true;

        $product->save();
    }
}
