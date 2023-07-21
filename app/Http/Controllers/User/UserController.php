<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
   public function home(){
    $pizza=Product::orderBy('created_at','desc')->get();
    $category=Category::get();
    $cart=Cart::where('user_id',Auth::user()->id)->get();
    $history=Order::where('user_id',Auth::user()->id)->get();
     return view('user.main.home',compact('pizza','category','cart','history'));
   }

    public function changePass(){
     return view('user.account.changePass');
   }

    public function updatePass(Request $request){
         $this->passwordValidationCheck($request);
         $user=User::select('password')->where('id',Auth::user()->id)->first();
        $dbHashValue=$user->password;
        if(Hash::check($request->currentPassword, $dbHashValue)){
            $data=[
            'password'=>Hash::make($request->newPassword)];
            User::where('id',Auth::user()->id)->update($data);
            return back()->with(['success'=>'Password changed']);
        }
        return back()->with(['notMatch'=>'The Current Password is not match. Try Again!']);
   }

   public function editAcc(){
        return view('user.account.profile');
   }

   public function updateAcc(Request $request,$id){
         $this->accountValidationCheck($request);
        $data=$this->getUserData($request);
       if($request->hasFile('image')){
         $dbImage=User::where('id',$id)->first();
        $dbImage=$dbImage->image;
        if($dbImage != null){
            Storage::delete('public/'.$dbImage);
        }
        $fileName=uniqid().$request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('public',$fileName);
        $data['image']=$fileName;
       }
        User::where('id',$id)->update($data);
        return back()->with(['updatesucess'=>'Updated successfully']);
   }

   public function filter($categoryId){
        $pizza=Product::where('category_id',$categoryId)->orderBy('created_at','desc')->get();
        $category=Category::get();
        $cart=Cart::where('user_id',Auth::user()->id)->get();
        return view('user.main.home',compact('pizza','category','cart'));
   }

   public function detail($pizzaId){
        $pizza=Product::where('id',$pizzaId)->first();
        $pizzaList=Product::get();
        return view('user.main.detail',compact('pizza','pizzaList'));
   }

   public function cartList(){
        $cart=Cart::select('carts.*','products.name as pizza_name','products.price','products.image as product_image')
        ->leftJoin('products','products.id','carts.product_id')
        ->where('carts.user_id',Auth::user()->id)->get();
        $totalPrice=0;
        foreach($cart as $c){
            $totalPrice += $c->price * $c->qty;
        }
        return view('user.main.cart',compact('cart','totalPrice'));
   }
   public function history(){
        $order=Order::where('user_id',Auth::user()->id)->orderBy('created_at','desc')->paginate('5');
        return view('user.main.history',compact('order'));
   }

   public function userList(){
        $user=User::where('role','user')->paginate('3');
        return view('admin.user.list',compact('user'));
   }

   public function changeRole(Request $request){
        $updateData = [
            'role' =>$request->role
        ];
        User::where('id',$request->userId)->update($updateData);
   }

   public function deleteUser($id){
        User::where('id',$id)->delete();
        return redirect()->route('user#userList');
   }


    private function passwordValidationCheck($request){
        Validator::make($request->all(),[
            'currentPassword'=>'required|min:6|max:10',
            'newPassword'=>'required|min:6|max:10',
            'confirmPassword'=>'required|min:6|max:10|same:newPassword',
        ])->validate();
    }

     private function accountValidationCheck($request){
        Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'image' =>'mimes:png,jpg,jpeg,webp|file',

        ])->validate();
    }

     private function getUserData($request){
        return[
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'gender'=>$request->gender,
            'address'=>$request->address
        ];
    }


}
