<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function changePass(){
        return view('admin.account.change');
    }

    public function change(Request $request){
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

    public function details(){
        return view('admin.account.details');
    }

    public function editprofile(){
        return view('admin.account.editprofile');
    }

    public function update(Request $request,$id){
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
        return redirect()->route('admin#profile')->with(['updatesucess'=>'Updated successfully']);
    }

    public function list(){
        $user=User::when(request('key'),function($query){
            $query->orWhere('name','like','%'.request('key').'%')
                  ->orWhere('email','like','%'.request('key').'%')
                  ->orWhere('gender','like','%'.request('key').'%')
                  ->orWhere('phone','like','%'.request('key').'%')
                  ->orWhere('address','like','%'.request('key').'%');
        })->where('role','admin')->paginate(3);
        $user->appends(request()->all());
        return view('admin.account.list',compact('user'));
    }

    public function delete($id){
        User::where('id',$id)->delete();
        return redirect()->route('admin#list')->with(['deletesuccess'=>'Deleted successfully']);
    }

    public function changeRole(Request $request){
        $updateData = [
            'role' =>$request->role
        ];
        User::where('id',$request->userId)->update($updateData);
   }

    public function updateRole(Request $request,$id){
        $data=$this->getRoleData($request);
        User::where('id',$id)->update($data);
        return redirect()->route('admin#list');
    }

    public function contactList(){
        $data=Contact::get();
        return view('admin.user.contactList',compact('data'));
    }

    public function deleteList($id){
        Contact::where('id',$id)->delete();
        return redirect()->route('admin#contactList');
    }

    private function getRoleData($request){
       return [
         'role'=>$request->role
       ];
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

    private function passwordValidationCheck($request){
        Validator::make($request->all(),[
            'currentPassword'=>'required|min:6|max:10',
            'newPassword'=>'required|min:6|max:10',
            'confirmPassword'=>'required|min:6|max:10|same:newPassword',
        ])->validate();
    }
}
