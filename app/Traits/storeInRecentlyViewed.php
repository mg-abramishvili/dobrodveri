<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait StoreInRecentlyViewed {

    public function StoreInRecentlyViewed($product)
    {
        // session()->forget('recentlyViewed');

        $product = collect(json_decode($product, true));
        
        if(is_array(session('recentlyViewed')))
        {
            $recentlyViewed = session('recentlyViewed');
        }

        if(!is_array(session('recentlyViewed')))
        {
            $recentlyViewed = [];
        }

        $productAlreadyExistsInRecentlyViewed = array_filter($recentlyViewed, function($p) use($product) {
            return $p['id'] == $product['id'];
        });

        if(count($productAlreadyExistsInRecentlyViewed) > 0) {
            foreach($productAlreadyExistsInRecentlyViewed as $p) {
                $index = array_search($p, $recentlyViewed);

                unset($recentlyViewed[$index]);
            }
        }
        
        if(count($recentlyViewed) >= 4) {
            array_shift($recentlyViewed);
        }

        $recentlyViewed[] = $product;

        session([ 'recentlyViewed' => $recentlyViewed ]);
    }

}