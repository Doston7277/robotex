<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with(['user'])->paginate(5);
        return view('front.blog.index', compact('blogs'));
    }

    public function detail($blog_id)
    {
        $blog = Blog::query()->find($blog_id);
        return view('front.blog.index', compact('blog'));
    }
}
