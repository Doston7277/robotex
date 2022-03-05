<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subject;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::query()->with(['products'])->get();
        $cart = Cart::content();
        $cart_subtotal = Cart::subtotal();
        $products = Product::query()->get();
        return view('front.product' , compact('categories', 'cart', 'cart_subtotal', 'products'));
    }

    public function detail($product_id)
    {
        $categories = Category::query()->with(['products'])->get();
        $cart = Cart::content();
        $cart_subtotal = Cart::subtotal();
        $product = Product::query()->find($product_id);
        $products = Product::query()->where('category_id', $product->category_id)->get();

        return view('front.product-detail', compact('product', 'cart', 'cart_subtotal', 'categories', 'products'));
    }

    public function view($product_id){
        $pro = Product::query()->find($product_id);
        $pro->product_images = asset($pro->product_images);
        return $pro;
    }

    public function search(Request $request){
        $product = Product::query()->where('product_model' , 'LIKE', "%{$request->search}%")
            ->orWhere('product_name' , 'LIKE', "%{$request->search}%")
            ->orWhere('product_company' , 'LIKE', "%{$request->search}%")
            ->orWhere('product_company' , 'LIKE', "%{$request->search}%")->first();
        if ($product != null){
            $subject = Subject::query()->find($product->subject_id);
        }else{
            return back();
        }
        return redirect('/products/'.$subject->subject_route);
    }
}
