<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    public function all(Request $request) {
        $products = Item::query();
        return response()->json(new ProductResource($products->paginate()));
    }

    public function one(Item $product) {
        return response()->json($product);
    }

    public function update(Item $product, Request $reqeust) {
        $product->update(
            ...$request->all()
        );

        return response()->json([
            'data' => $product,
            'message' => 'Successfully updated.'
        ]);
    }

    public function delete(Item $product) {
        $product->delete();

        return response()->json([
            'message' => 'Successfully deleted.'
        ]);
    }
}
