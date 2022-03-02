<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function create(Request $request)
    {
        if ($request->category_name['uz'] == null){
            return response()->json([
                "success" => false,
                "message" => __('Admin.validation_category_name')
            ]);
        }

        if ($request->category_name['ru'] == null){
            return response()->json([
                "success" => false,
                "message" => __('Admin.validation_category_name')
            ]);
        }

        if ($request->category_name['en'] == null){
            return response()->json([
                "success" => false,
                "message" => __('Admin.validation_category_name')
            ]);
        }

        $data = new Category();
        $data->category_name = $request->category_name;
        if ($data->save()){
            return response()->json([
                "success" => true,
                "message" => __('Admin.saved')
            ]);
        }
    }
    public function update(Request $request)
    {
        $category = Category::query()->find($request->category_id);

        $category->category_name = $request->category_name;

        if ($category->save()){
            return response()->json([
                "success" => true,
                "message" => __('Admin.updated')
            ]);
        }
    }
    public function datatable(Request $request)
    {
        $model = Category::query();
        return Datatables::eloquent($model)
            ->addIndexColumn()
            ->addColumn('id', function ($category){
                return $category->category_id;
            })
            ->addColumn('name', function ($category){
                return $category->category_name[app()->getLocale()];
            })
            ->addColumn('action',function ($category){
                if (Auth::user()->user_name == 'admin') {
                    return "<a onclick='updated($category->category_id)' data-toggle=\"modal\" data-target=\"#update\"><i class=\"icon-pencil\"></i></a><a onclick=\"deleted($category->category_id)\"><i class=\"icon-trash\"></i></a>";
                }
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function delete($category_id)
    {
        Category::find($category_id)->delete();
        return response()->json([
            "success" => true,
            "message" => __('Admin.deleted')
        ]);
    }
    public function edit($category_id)
    {
        return Category::query()->find($category_id);
    }
    public function select()
    {
        return Category::all();
    }

    public function index()
    {
        return view('admin.category.index');
    }
    public function index_create()
    {
        return view('admin.category.create');
    }
}
