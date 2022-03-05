<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $categories = Category::query()->with(['products'])->get();
        $cart = Cart::content();
        $cart_subtotal = Cart::subtotal();
        return view('front.about', compact('categories', 'cart', 'cart_subtotal'));
    }
}
