<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait getFilterParams {

    public function getFilterParams($request, $productType, $categoryID)
    {
        $filterParams['page'] = $request->page ? (int)$request->page : 1;
        $filterParams['order'] = $request->order ? $request->order : 'price_asc';

        if($productType == 'sku')
        {
            $req = $request->filter_params;

            $filterParams['category_id'] = isset($req['category_id']) ? (int)$req['category_id'] : null;
            $filterParams['priceFrom'] = isset($req['price_from']) ? (int)$req['price_from'] : null;
            $filterParams['priceTo'] = isset($req['price_to']) ? (int)$req['price_to'] : null;
            $filterParams['types'] = isset($req['types']) ? $req['types'] : null;
            $filterParams['styles'] = isset($req['styles']) ? $req['styles'] : null;
            $filterParams['surfaces'] = isset($req['surfaces']) ? $req['surfaces'] : null;
            $filterParams['colors'] = isset($req['colors']) ? $req['colors'] : null;
            $filterParams['glasses'] = isset($req['glasses']) ? $req['glasses'] : null;
        }

        if($productType == 'product')
        {
            $filterParams['category_id'] = $categoryID;
            $filterParams['priceFrom'] = $request->price_from;
            $filterParams['priceTo'] = $request->price_to;
            $filterParams['types'] = $request->type ? explode(',', $request->type) : null;
            $filterParams['styles'] = $request->style ? explode(',', $request->style) : null;
            $filterParams['surfaces'] = $request->surface ? explode(',', $request->surface) : null;
            $filterParams['colors'] = $request->color ? explode(',', $request->color) : null;
            $filterParams['glasses'] = $request->glass ? explode(',', $request->glass) : null;
        }

        return $filterParams;
    }

}