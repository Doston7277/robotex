<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $categories = Category::query()->with(['products'])->get();
        $cart = Cart::content();
        $cart_subtotal = Cart::subtotal();
        $blogs = Blog::with(['user'])->paginate(5);
        return view('front.blog', compact('blogs', 'categories', 'cart', 'cart_subtotal'));
    }

    public function detail($blog_id)
    {
        $blog = Blog::query()->find($blog_id);
        return view('front.blog.index', compact('blog'));
    }
}
