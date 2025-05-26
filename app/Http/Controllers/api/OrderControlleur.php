<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderControlleur extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $carts = $user->carts()->with('product')->get();

        if ($carts->isEmpty()) {
            return response("Cart is empty", 400);
        }

        DB::beginTransaction();

        try {
            $total = $carts->sum(fn($cart) => $cart->product->price * $cart->quantity);

            $order = new Order();

            $order->user_id = $user->id;
            $order->total_price = $total;

            foreach ($carts as $cart) {
                $orderItem = new OrderItem();

                $orderItem->order_id = $order->id;
                $orderItem->product_id = $cart->product_id;
                $orderItem->quantity = $cart->quantity;
                $orderItem->price = $cart->product->price;
            }

            $user->carts()->delete();

            DB::commit();

            return response("Order created successfully", 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response($e->getMessage(), 500);
        }


        return response($order);
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
