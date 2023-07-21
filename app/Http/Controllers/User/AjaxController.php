<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    public function pizzalist(Request $request){
        // logger($request->status);
       if($request->status == 'desc'){
             $pizza=Product::orderBy('created_at','desc')->get();
       }else if($request->status == 'asc'){
             $pizza=Product::orderBy('created_at','asc')->get();
       }
        return $pizza;
    }

    public function addToCart(Request $request){
        $data=$this->getDataOrder($request);
        Cart::create($data);
        $response =[
            'message'=>'complete',
            'status'=>'success'
        ];
        return response()->json($response,200);
    }
    public function order(Request $request){
        $total=0;
        $snap=$request->all();
        foreach($snap as $item){
            $data=OrderList::create([
                'user_id' => $item['user_id'],
                'product_id' => $item['product_id'],
                'qty' => $item['qty'],
                'total' => $item['total'],
                'order_code' => $item['order_code'],
            ]);
            $total+=$data->total;
        }
        Cart::where('user_id',Auth::user()->id)->delete();
        Order::create([
            'user_id' =>Auth::user()->id,
            'order_code'=>$data->order_code,
            'totalPrice'=>$total+3000

        ]);
        return response()->json([
            'status'=>'true'
        ],200);
    }

    public function clearCart(){
         Cart::where('user_id',Auth::user()->id)->delete();
    }

    public function current(Request $request){
        Cart::where('user_id',Auth::user()->id)
            ->where('product_id',$request->productId)
            ->where('id',$request->orderId)->delete();
    }

    public function increaseView(Request $request){
       $pizza=Product::where('id',$request->productId)->first();
       $viewCount=[
        'view_count'=>$pizza->view_count+1
       ];
       Product::where('id',$request->productId)->update( $viewCount);
    }

    private function getDataOrder($request){
        return [
            'user_id'=>$request->userId,
            'product_id'=>$request->pizzaId,
             'qty'=>$request->count
             ];
    }
}
