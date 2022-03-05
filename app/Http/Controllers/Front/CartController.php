<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function create($product_id)
    {
        $product = Product::query()->find($product_id);
        $price = str_replace(' ', '', $product->product_price);
        Cart::add(
            [
                'id' => $product->product_id,
                'name' => $product->product_name,
                'qty' => 1,
                'price' => $price,
                'weight' => 550,
                'options' => [
                    'image' => $product->product_image[0],
                    'model' => $product->product_model,
                    'company' => $product->product_company
                ]
            ]
        );
        return back();
    }

    public function delete($rowId){
        Cart::remove($rowId);
        return back();
    }
}
