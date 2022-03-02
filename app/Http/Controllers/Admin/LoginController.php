<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login()
    {
        return view('admin.auth.login');
    }

    public function login_check(Request $request)
    {

        $user = User::query()
            ->where('user_name',$request->admin_user_name)
            ->first();
        if ($user!=null && Crypt::decrypt($user->user_password) == $request->admin_user_password)
        {
            Auth::login($user);
            $link = session('redirect_link');
            if ($link==null){
                $link = "/admin";
            }
            session(['redirect_link'=>null]);
            return redirect($link);
        }else{
            abort(404);
        }
    }
}
