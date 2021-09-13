<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function all(Request $request) {
        $orders = Order::query();

        if ( ! empty($request->orderBy)) {
            $orders = $orders->orderBy($request->orderBy, $request->orderByType ? : 'desc');
        }

        return response()->json([
            'data' => $orders->with(['shipments', 'invoice'])->paginate($request->per_page)
        ]);
    }
    

    public function one(Order $order) {
        return response()->json([
            'data' => $order
        ]);
    }

    public function update(Request $request, Order $order) {
        $order->update(
            ...$request->all()
        );

        return response()->json([
            'data' => $order,
            'message' => 'Successfully updated.'
        ]);
    }

    public function delete(Order $order) {
        $order->delete();

        return response()->json([
            'message' => 'Successfully deleted.'
        ]);
    }
}
