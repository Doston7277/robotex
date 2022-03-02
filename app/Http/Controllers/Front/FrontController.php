<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subject;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $categories = Category::query()->get();
        $products = Product::query()->get();
        return view('front.index', compact('categories', 'products'));
    }
}
