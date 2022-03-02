<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Overtrue\LaravelShoppingCart\Facade;


class LikeListController extends Controller
{
    public function index()
    {
        $products = Facade::all();
        return view('front.wishlist' , compact('products'));
    }

    public function create($product_id)
    {
        $product = Product::query()->find($product_id);
        $price = str_replace(' ', '', $product->product_price);
        Facade::add(
            $product->product_id,
            $product->product_model,
            1,
            $price,
            ['image' => $product->product_images]
        );
        return back()->with('message', 'Add to LikeList');
    }

    public function delete($rowId)
    {
        Facade::remove($rowId);
        return back()->with('message', 'delete to LikeList');
    }
}
