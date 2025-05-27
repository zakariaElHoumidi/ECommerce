<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

            if ($product->quantity < $req->quantity) {
                return response('Product quantity is not enough', 400);
            }

            try {
                DB::beginTransaction();

                $user->carts()->create([
                    'product_id' => $req->product_id,
                    'quantity' => $req->quantity
                ]);

                $product->quantity -= $req->quantity;

                $product->save();

                DB::commit();
                
                return response("$product->label added to cart", 200);
            } catch (\Exception $e) {
                DB::rollBack();
                return response($e->getMessage(), 500);
            }
        }
    }
}
