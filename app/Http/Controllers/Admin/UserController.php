<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index');
    }

    public function index_create()
    {
        return view('admin.users.create');
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('user_image')){
            $filename = time() . '.' . $request->user_image->extension();
            $request->user_image->move(public_path('images/users/'), $filename);
            session(['user_image' => 'images/users/'.$filename]);
        }
    }

    public function edit($user_id)
    {
        return User::find($user_id);
    }

    public function update(Request $request)
    {
        if ($request->user_name == null){
            return response()->json([
                "success" => false,
                "message" => __('Admin.validation_user_name')
            ]);
        }
        if ($request->user_phone == null){
            return response()->json([
                "success" => false,
                "message" => __('Admin.validation_user_phone')
            ]);
        }
        if ($request->user_password_new != null){
            if ($request->user_password_new != $request->user_password_confiration){
                return response()->json([
                    "success" => false,
                    "message" => __('Admin.validation_user_password_confirmation')
                ]);
            }else{
                $user = User::find($request->user_id);
                $user->user_name = $request->user_name;
                $user->user_phone = $request->user_phone;
                $user->user_password = Crypt::encrypt($request->user_password_new);
                if ($request->is_admin == "true"){
                    $user->is_admin = true;
                }else{
                    $user->is_admin = false;
                }
                if ($user->save()){
                    return response()->json([
                        "success" => true,
                        "message" => __('Admin.updated')
                    ]);
                }
            }
        }else{
            $user = User::find($request->user_id);
            $user->user_name = $request->user_name;
            $user->user_phone = $request->user_phone;
            if ($request->is_admin == "true"){
                $user->is_admin = true;
            }else{
                $user->is_admin = false;
            }
            if ($user->save()){
                return response()->json([
                    "success" => true,
                    "message" => __('Admin.updated')
                ]);
            }
        }
    }


    public function create(Request $request)
    {
        if ($request->user_name == null){
            return response()->json([
                "success" => false,
                "message" => __('Admin.validation_user_name')
            ]);
        }
        if ($request->user_phone == null){
            return response()->json([
                "success" => false,
                "message" => __('Admin.validation_user_phone')
            ]);
        }
        if ($request->user_password == null){
            return response()->json([
                "success" => false,
                "message" => __('Admin.validation_user_password')
            ]);
        }
        if (strlen($request->user_password) < 6){
            return response()->json([
                "success" => false,
                "message" => __('Admin.validation_user_password_min')
            ]);
        }
        if ($request->user_password != $request->user_password_confirmation){
            return response()->json([
                "success" => false,
                "message" => __('Admin.validation_user_password_confirmation')
            ]);
        }


        $data = new User();

        $data->user_image = session('user_image');

        $data->user_name = $request->user_name;
        $data->user_phone = $request->user_phone;
        $data->user_password = Crypt::encrypt($request->user_password);
        $data->is_admin = false;

        if ($data->save()){
            return response()->json([
                "success" => true,
                "message" => __('Admin.saved')
            ]);
        }
    }
    public function delete($user_id)
    {
        $user = User::find($user_id);
        unlink(public_path($user->user_image));
        User::find($user_id)->delete();

        return response()->json([
            "success" => true,
            "message" => __('Admin.deleted')
        ]);
    }

    public function datatable(Request $request)
    {
        $model = User::where('is_admin', false);
        return Datatables::eloquent($model)
            ->addIndexColumn()
            ->addColumn('image', function ($user){
                if($user->user_image == 'false') {
                    $url = asset('images/user_icon.jpg');
                    return $url;
                }else {
                    $url = asset($user->user_image);
                    return $url;
                }
            })
            ->addColumn('id', function ($user){
                return $user->user_id;
            })
            ->addColumn('name', function ($user){
                return $user->user_name;
            })
            ->addColumn('phone', function ($user){
                return $user->user_phone;
            })
            ->addColumn('password', function ($user){
                if (Auth::user()->user_name == 'admin') {
                    return Crypt::decrypt($user->user_password);
                }
            })
            ->addColumn('action',function ($user){
                if (Auth::user()->user_name == 'admin') {
                    return "<a onclick='updated($user->user_id)' data-toggle=\"modal\" data-target=\"#update\"><i class=\"icon-pencil\"></i></a><a onclick=\"deleted($user->user_id)\"><i class=\"icon-trash\"></i></a>";
                }
            })
            ->make(true);
    }
}
