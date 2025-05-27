<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Administrateur;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderControlleur extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user instanceof User) {
            $orders = $user->orders()->with('items')->get();
        } else if ($user instanceof Administrateur) {
            $orders = Order::with('items')->get();
        }

        return response($orders, 200);
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

            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $total
            ]);

            foreach ($carts as $cart) {
                $order->items()->create([
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->quantity,
                    'price' => $cart->product->price,
                ]);
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
        $user = auth()->user();


        $order = Order::with('items.product')->find($id);

        if (!$order) {
            return response('Order not found', 404);
        }

        if ($user instanceof User) {
            if ($order->user_id !== $user->id) {
                return response('Order not found', 404);
            }
        }

        return response($order, 200);
    }
}
