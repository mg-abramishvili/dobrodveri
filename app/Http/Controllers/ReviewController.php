<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'product_id' => 'required',
            'text' => 'required',
            'rating' => 'required',
        ];

        $this->validate($request, $rules);

        $review = new Review();

        $review->name = $request->name;
        $review->product_id = $request->product_id;
        $review->text = $request->text;
        $review->rating = $request->rating;

        $review->save();
    }
}
