<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BlogController extends Controller
{
    public function create(Request $request)
    {

        if ($request->blog_title['uz'] == null){
            return response()->json([
                "success" => false,
                "message" => __('Admin.validation_blog_title')
            ]);
        }
        if ($request->blog_title['ru'] == null){
            return response()->json([
                "success" => false,
                "message" => __('Admin.validation_blog_title')
            ]);
        }
        if ($request->blog_title['en'] == null){
            return response()->json([
                "success" => false,
                "message" => __('Admin.validation_blog_title')
            ]);
        }
        if ($request->blog_body['uz'] == null){
            return response()->json([
                "success" => false,
                "message" => __('Admin.validation_blog_body')
            ]);
        }
        if ($request->blog_body['ru'] == null){
            return response()->json([
                "success" => false,
                "message" => __('Admin.validation_blog_body')
            ]);
        }
        if ($request->blog_body['en'] == null){
            return response()->json([
                "success" => false,
                "message" => __('Admin.validation_blog_body')
            ]);
        }

        $blog = new Blog();
        $blog->blog_title = $request->blog_title;
        $blog->blog_body = $request->blog_body;
        $blog->blog_author = Auth::user()->user_id;
        $blog->blog_tags  = isset($request->blog_tags)?implode(",", $request->blog_tags):'';
        $blog->blog_image = session('blog_image');
        if($blog->save())
        {
            return response()->json([
                "success" => true,
                "message" => __('Admin.saved')
            ]);
        }
    }
    public function update(Request $request)
    {
        if ($request->blog_title['uz'] == null){
            return response()->json([
                "success" => false,
                "message" => __('Admin.validation_blog_title')
            ]);
        }
        if ($request->blog_title['ru'] == null){
            return response()->json([
                "success" => false,
                "message" => __('Admin.validation_blog_title')
            ]);
        }
        if ($request->blog_title['en'] == null){
            return response()->json([
                "success" => false,
                "message" => __('Admin.validation_blog_title')
            ]);
        }

        if ($request->blog_body['uz'] == null){
            return response()->json([
                "success" => false,
                "message" => __('Admin.validation_blog_body')
            ]);
        }
        if ($request->blog_body['ru'] == null){
            return response()->json([
                "success" => false,
                "message" => __('Admin.validation_blog_body')
            ]);
        }
        if ($request->blog_body['en'] == null){
            return response()->json([
                "success" => false,
                "message" => __('Admin.validation_blog_body')
            ]);
        }

        $blog = Blog::find($request->blog_id);

        $blog->blog_title = $request->blog_title;
        $blog->blog_body = $request->blog_body;

        if ($blog->save())
        {
            return response()->json([
                "success" => true,
                "message" => __('Admin.updated')
            ]);
        }
    }
    public function datatable(Request $request)
    {
        $model = Blog::with(['user' => function ($query) {
            $query->where('user_name', 'like', '%%');
        }]);
        return Datatables::eloquent($model)
            ->addIndexColumn()
            ->addColumn('image', function ($blog){
                return asset($blog->blog_image);
            })
            ->addColumn('id', function ($blog){
                return $blog->blog_id;
            })
            ->addColumn('title', function ($blog){
                return $blog->blog_title[app()->getLocale()];
            })
            ->addColumn('body', function ($blog){
                return $blog->blog_body[app()->getLocale()];
            })
            ->addColumn('tags', function ($blog){
                return $blog->blog_tags;
            })
            ->addColumn('author', function ($blog){
                return $blog->user->user_name;
            })
            ->addColumn('action',function ($blog){
                if (Auth::user()->user_name == 'admin') {
                    return "<a onclick='updated($blog->blog_id)' data-toggle=\"modal\" data-target=\"#update\"><i class=\"icon-pencil\"></i></a><a onclick=\"deleted($blog->blog_id)\"><i class=\"icon-trash\"></i></a>";
                }
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function upload(Request $request)
    {
        if ($request->hasFile('blog_image')){
            $filename = time() . '.' . $request->blog_image->extension();
            $request->blog_image->move(public_path('images/blog/'), $filename);
            session(['blog_image' => 'images/blog/'.$filename]);
        }
    }
    public function delete($blog_id)
    {
        $blog = Blog::query()->find($blog_id);
        unlink(public_path($blog->blog_image));
        Blog::query()->find($blog_id)->delete();

        return response()->json([
            "success" => true,
            "message" => __('Admin.deleted')
        ]);
    }
    public function edit($blog_id)
    {
        return Blog::query()->find($blog_id);
    }
    public function index()
    {
        return view('admin.blog.index');
    }
    public function index_create()
    {
        return view('admin.blog.create');
    }
}
