<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderList;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function list(){
        $order=Order::select('orders.*','users.name as user_name')
            ->leftJoin('users','users.id','orders.user_id')
            ->orderBy('created_at','desc')
            ->paginate('5');
        return view('admin.order.list',compact('order'));
    }

    public function orderStatus(Request $request){
        // $request->status = $request->status == null? "" :$request->status;
        $order=Order::select('orders.*','users.name as user_name')
            ->leftJoin('users','users.id','orders.user_id')
            ->orderBy('created_at','desc');

        if($request->oStatus == null ){
            $order=$order->get();
        }else{
            $order=$order->where('orders.status',$request->oStatus)->get();
        }
            return view('admin.order.list',compact('order'));
    }

    public function code($orderCode){
        $price=Order::where('order_code',$orderCode)->first();
        $order=OrderList::select('order_lists.*','users.name as user_name','products.name as product_name','products.image')->where('order_code',$orderCode)
            ->leftJoin('users','users.id','order_lists.user_id')
            ->leftJoin('products','products.id','order_lists.product_id')
            ->get();
        return view('admin.order.productList',compact('order','price'));
    }

    public function changeStatus(Request $request){
        Order::where('id',$request->orderId)->update([
            'status' => $request->status
        ]);
    }
}
