<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function productList(){
        $product=Product::get();
        return response()->json([$product,200]);
    }

     public function categoryList(){
        $category=Category::get();
        return response()->json([$category,200]);
    }

    public function userList(){
        $user=User::get();
        return response()->json([$user,200]);
    }

    public function cartList(){
        $cart=Cart::get();
        return response()->json([$cart,200]);
    }

    public function orderList(){
        $order=Order::get();
        return response()->json([$order,200]);
    }
    public function contactList(){
        $contact=Contact::get();
        return response()->json([$contact,200]);
    }

    public function categoryCreate(Request $request){
        $data =[
            'name'=>$request->name
        ];
        $response=Category::create($data);
        return response()->json([$response],200);
    }

    public function contactCreate(Request $request){
        $data =[
            'name'=>$request->name,
            'email'=>$request->email,
            'message'=>$request->message
        ];
        $response=Contact::create($data);
        return response()->json([$response],200);
    }

    public function deleteCategory(Request $request){
        $data=Category::where('id',$request->id)->first();
        if(isset($data)){
            Category::where('id',$request->id)->delete();
            return response()->json(['status'=>true,'message'=>'deleted sucess'],200);
        }
        return response()->json(['status'=>false,'message'=>'There is no data to delete'],200);
    }

    public function categoryDetails($id){
        $data=Category::where('id',$id)->first();
        if(isset($data)){
            return response()->json(['status'=>true,$data],200);
        }
        return response()->json(['status'=>false,'message'=>'There is no data'],200);
    }

    public function categoryUpdate(Request $request){
        $data=Category::where('id',$request->id)->first();
        if(isset($data)){
            $category = [
                'name'=>$request->name
            ];
            $response=Category::where('id',$request->id)->update($category);
            return response()->json(['status'=>true,'category'=>$response],200);
        }
        return response()->json(['status'=>false,'message'=>'There is no data to update'],200);
    }
}
