<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShoppingController extends Controller
{
    public function shopping_card()
    {
        session(['redirect_link' => '/order']);
        return view('front.shopping-cart');
    }
}
