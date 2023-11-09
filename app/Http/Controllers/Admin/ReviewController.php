<?php

namespace App\Http\Controllers\Admin;

use App\Models\Review;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        return Review::orderBy('created_at', 'desc')->with('product')->get();
    }

    public function update($id)
    {
        $review = Review::find($id);

        $review->is_active = true;

        $review->save();
    }

    public function delete($id)
    {
        $review = Review::find($id);

        $review->delete();
    }
}
