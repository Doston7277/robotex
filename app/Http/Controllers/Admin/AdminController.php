<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\DataTables;
class AdminController extends Controller
{
    public function admin_create(Request $request)
    {

        if ($request->admin_name == null){
            return response()->json([
                "success" => false,
                "message" => __('Admin.validation_admin_name')
            ]);
        }
        if ($request->admin_phone == null){
            return response()->json([
                "success" => false,
                "message" => __('Admin.validation_admin_phone')
            ]);
        }
        if ($request->admin_password == null){
            return response()->json([
                "success" => false,
                "message" => __('Admin.validation_admin_password')
            ]);
        }
        if (strlen($request->admin_password) < 6){
            return response()->json([
                "success" => false,
                "message" => __('Admin.validation_admin_password_min')
            ]);
        }
        if ($request->admin_password != $request->admin_password_confirmation){
            return response()->json([
                "success" => false,
                "message" => __('Admin.validation_admin_password_confirmation')
            ]);
        }


        $data                   = new User();

        $data->user_image       = session('admin_image');

        $data->user_name        = $request->admin_name;
        $data->user_phone       = $request->admin_phone;
        $data->user_password    = Crypt::encrypt($request->admin_password);
        $data->is_admin         = true;

        if ($data->save()){
            return response()->json([
                "success" => true,
                "message" => __('Admin.saved')
            ]);
        }
    }
    public function update(Request $request)
    {
        if ($request->admin_name == null){
            return response()->json([
                "success" => false,
                "message" => __('Admin.validation_admin_name')
            ]);
        }
        if ($request->admin_phone == null){
            return response()->json([
                "success" => false,
                "message" => __('Admin.validation_admin_phone')
            ]);
        }
        if ($request->admin_password_new != null){
            if ($request->admin_password_new != $request->admin_password_confiration){
                return response()->json([
                    "success" => false,
                    "message" => __('Admin.validation_admin_password_confirmation')
                ]);
            }else{
                $user = User::find($request->user_id);
                $user->user_name = $request->admin_name;
                $user->user_phone = $request->admin_phone;
                $user->user_password = Crypt::encrypt($request->admin_password_new);
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
            $user->user_name = $request->admin_name;
            $user->user_phone = $request->admin_phone;
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
    public function datatable(Request $request)
    {
        $model = User::where('is_admin', true);
        return Datatables::eloquent($model)
            ->addIndexColumn()
            ->addColumn('image', function ($admin){
                if($admin->user_image == false) {
                    $url = asset('images/user_icon.jpg');
                    return $url;
                }else {
                    $url = asset($admin->user_image);
                    return $url;
                }
            })
            ->addColumn('id', function ($admin){
                return $admin->user_id;
            })
            ->addColumn('name', function ($admin){
                return $admin->user_name;
            })
            ->addColumn('phone', function ($admin){
                return $admin->user_phone;
            })
            ->addColumn('password', function ($admin){
                if (Auth::user()->user_name == 'admin'){
                    return Crypt::decrypt($admin->user_password);
                }
            })
            ->addColumn('action',function ($admin){
                if (Auth::user()->user_name == 'admin'){
                    return "<a onclick='updated($admin->user_id)' data-toggle=\"modal\" data-target=\"#update\"><i class=\"icon-pencil\"></i></a><a onclick=\"deleted($admin->user_id)\"><i class=\"icon-trash\"></i></a>";
                }
            })
            ->make(true);
    }

    public function admin_delete($user_id)
    {
        $user = User::find($user_id);
        unlink(public_path($user->user_image));
        User::find($user_id)->delete();

        return response()->json([
            "success" => true,
            "message" => __('Admin.deleted')
        ]);
    }
    public function upload(Request $request)
    {
        if ($request->hasFile('admin_image')){
            $filename = time() . '.' . $request->admin_image->extension();
            $request->admin_image->move(public_path('images/admin/'), $filename);
            session(['admin_image' => 'images/admin/'.$filename]);
        }
    }
    public function admin_edit($user_id)
    {
        return User::find($user_id);
    }

    public function index()
    {
        return view('admin.dashboard');
    }
    public function index_admin()
    {
        return view('admin.admin.index');
    }
    public function index_admin_create()
    {
        return view('admin.admin.create');
    }

}
