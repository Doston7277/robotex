<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class LoginController extends Controller
{
    public function login()
    {
        return view('front.login');
    }
    public function register()
    {
        return view('front.register');
    }
    public function login_check(Request $request)
    {
        $user = User::query()
            ->where('user_name',$request->user_name)
            ->first();
        if ($user!=null && Crypt::decrypt($user->user_password) == $request->user_password)
        {
            Auth::login($user);
            $link = session('redirect_link');
            if ($link==null){
                return redirect('/user/'.Auth::user()->user_id);
            }
            session(['redirect_link'=>null]);
            return redirect($link);
        }else{
            return back()->with('error', 'Usar name yoki parol xato');
        }
    }
}
