<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sku;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SkuController extends Controller
{
    public function index($product_id)
    {
        return Sku::where('product_id', $product_id)->get();
    }

    public function sku($id)
    {
        return Sku::find($id);
    }

    public function store(Request $request)
    {
        $rules = [
            'product_id' => 'required',
            'colors' => 'required',
        ];

        $this->validate($request, $rules);

        $colors = $request->colors;
        $glasses = $request->glasses;
        $innerdecors = $request->innerdecors;

        if(empty($colors)) {
            return;
        }
        
        foreach($colors as $color) {
            if(empty($glasses) && empty($innerdecors)) {
                $sku = new Sku();
    
                $sku->color_id = $color;
                $sku->product_id = $request->product_id;
    
                $sku->save();
            }

            if(isset($glasses)) {
                foreach($glasses as $glass) {
                    $sku = new Sku();
        
                    $sku->color_id = $color;
                    $sku->glass_id = $glass;
                    $sku->product_id = $request->product_id;
        
                    $sku->save();
                }
            }
            
            if(isset($innerdecors)) {
                foreach($innerdecors as $innerdecor) {
                    $sku = new Sku();
        
                    $sku->color_id = $color;
                    $sku->inner_decor_id = $innerdecor;
                    $sku->product_id = $request->product_id;
        
                    $sku->save();
                }
            }
        }
    }

    public function update($id, Request $request)
    {
        $sku = Sku::find($id);

        $sku->price = $request->price;
        $sku->image = $request->image;

        $sku->save();
    }

    public function delete($id)
    {
        $sku = Sku::find($id);

        $sku->delete();
    }
}
