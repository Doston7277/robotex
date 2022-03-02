<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    public function orders()
    {
        return view('admin.order.index');
    }

    public function datatable(Request $request)
    {
        $model = Order::query()->with(['users']);
        return Datatables::eloquent($model)
            ->addIndexColumn()
            ->addColumn('id', function ($order){
                return $order->order_id;
            })
            ->addColumn('username', function ($order){
                return $order->users->user_name;
            })
            ->addColumn('first_name', function ($order){
                return $order->users->user_first_name;
            })
            ->addColumn('last_name', function ($order){
                return $order->users->user_last_name;
            })
            ->addColumn('father_name', function ($order){
                return $order->users->user_father_name;
            })
            ->addColumn('address', function ($order){
                return $order->users->user_address;
            })
            ->addColumn('order_date', function ($order){
                return $order->created_at;
            })
            ->addColumn('action',function ($order){
                if (Auth::user()->is_admin == true){
                    return "<a onclick='order($order->order_id)' data-toggle=\"modal\" data-target=\"#detail\"><i class=\"icon-eye\"></i></a>";
                }
            })
            ->make(true);
    }

    public function detail($oreder_id)
    {
        $order = Order::with(['users'])->find($oreder_id);
        return $order;
    }
}
