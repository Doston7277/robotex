<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function create(Request $request)
    {
        $product = Product::query()->find($request->product_id);
        $price = str_replace(' ', '', $product->product_price);
        Cart::add(
            [
                'id' => $product->product_id,
                'name' => $product->product_name,
                'qty' => $request->quantity,
                'price' => $price,
                'weight' => 550,
                'options' => [
                    'image' => $product->product_images,
                    'model' => $product->product_model,
                    'company' => $product->product_company
                ]
            ]
        );
        return response()->json([
            "success" => true,
            "message" => __("Qo'shildi")
        ]);
    }

    public function delete($rowId){
        Cart::remove($rowId);
        return back();
    }
}
