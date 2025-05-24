<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RatingControlleur extends Controller
{
    public function __construct() {
        $this->middleware('is.user');
    }

    public function index(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response('Product not found', 404);
        }

        return response($product->ratings, 200);
    }

    public function store(Request $req, $id)
    {
        $data = $req->all();

        $rules = [
            'rating' => 'required|min:1|max:5',
            'review' => 'nullable|max:255',
        ];

        $data = Validator::make($data, $rules);

        if ($data->fails()) {
            return response($data->messages()->first(), 422);
        } else {
            $rating = new Rating();

            $rating->product_id = $id;
            $rating->rating = $req->rating;
            $rating->review = $req->review;

            $rating->save();

            return response('Rating created successfully', 200);
        }
    }
}
