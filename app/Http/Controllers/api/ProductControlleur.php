<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductControlleur extends Controller
{
    public function index()
    {
        $products = Product::all();

        return response($products, 200);
    }

    public function store(Request $req)
    {
        $data = $req->all();

        $rules = [
            'category_id' => 'required|exists:categories,id',
            'label' => 'required|max:255|unique:products',
            'description' => 'required|max:255',
            'price' => 'required|numeric|gt:0',
            'quantity' => 'required|numeric|gt:0',
        ];

        $data = Validator::make($data, $rules);

        if ($data->fails()) {
            return response($data->messages()->first(), 422);
        } else {
            $product = new Product();

            $product->category_id = $req->category_id;
            $product->label = $req->label;
            $product->description = $req->description;
            $product->price = $req->price;
            $product->quantity = $req->quantity;

            $product->save();

            return response($product, 201);
        }
    }

    public function show(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response('Product not found', 404);
        }

        return response($product, 200);
    }

    public function update(Request $req, string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response('Product not found', 404);
        }

        $data = $req->all();

        $rules = [
            'category_id' => 'required|exists:categories,id',
            'label' => 'required|max:255|unique:products',
            'description' => 'required|max:255',
            'price' => 'required|numeric|gt:0',
            'quantity' => 'required|numeric|gt:0',
        ];

        $data = Validator::make($data, $rules);

        if ($data->fails()) {
            return response($data->messages()->first(), 422);
        } else {
            $product->category_id = $req->category_id ?? $product->category_id;
            $product->label = $req->label ?? $product->label;
            $product->description = $req->description ?? $product->description;
            $product->price = $req->price ?? $product->price;
            $product->quantity = $req->quantity ?? $product->quantity;

            $product->save();

            return response($product, 200);
        }
    }

    public function destroy(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response('Product not found', 404);
        }

        $product->delete();
        return response('Product deleted successfully', 200);
    }
}
