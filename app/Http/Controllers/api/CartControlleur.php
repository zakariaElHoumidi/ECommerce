<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartControlleur extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return response($user->carts, 200);
    }

    public function store(Request $req)
    {
        $data = $req->all();

        $rules = [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric|gt:0',
        ];

        $data = Validator::make($data, $rules);

        if ($data->fails()) {
            return response($data->messages()->first(), 422);
        } else {
            $user = auth()->user();
            $product = Product::find($req->product_id);

            $cart = new Cart();

            $cart->user_id = $user->id;
            $cart->product_id = $req->product_id;
            $cart->quantity = $req->quantity;

            $cart->save();

            return response("$product->label added to cart", 200);
        }
    }
}
