<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    public function account($user_id)
    {
        $user = User::query()->find($user_id);
        $order = Order::query()->where('user_id', $user_id)->get();
        return view('front.user', compact('user', 'order'));
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('user_image')){
            $filename = time() . '.' . $request->user_image->extension();
            $request->user_image->move(public_path('images/users/'), $filename);
            session(['user_image' => 'images/users/'.$filename]);
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
                "user_id" => $data->user_id,
                "success" => true,
                "message" => __('Admin.saved')
            ]);
        }
    }
}
