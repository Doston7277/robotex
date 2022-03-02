<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(){
        $user = User::query()->find(Auth::id());
        return view('front.order', compact('user'));
    }

    public function order(Request $request){
        $data = [];
        $datas = [];
        foreach (Cart::content() as $cart)
        {

                $data ['id'] = $cart->id;
                $data ['name'] = $cart->name;
                $data ['model'] = $cart->options->model;
                $data ['company'] = $cart->options->company;
                $data ['price'] = $cart->price;
                $datas [] = $data;

        }
        if (Cart::content() != null){

            $order = new Order();
            $order->user_id = Auth::user()->user_id;
            $order->products = $datas;
            $order->order_text = $request->text;
            $order->save();

        }else{
            return back()->with('error', 'Sizning buyurtmalar qutisida mahsulot mavjud emas');
        }

        $user = User::query()->find(Auth::user()->user_id);

        $user->user_first_name = $request->first_name;
        $user->user_last_name = $request->last_name;
        $user->user_father_name = $request->father_name;
        $user->user_address = $request->address;

        $user->save();
        return back()->with('message', 'Sizning buyurtmangiz qabul qilindi');
    }
}
