<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
     public function contact(){
        return view('user.contact.contact');
   }

   public function contactUs(Request $request){
       $data=$this->contactData($request);
       Contact::create($data);
       return back()->with(['sendSuccess'=>'Message Sent.']);
   }

    private function contactData($request){
        return [
            'name'=>$request->name,
            'email'=>$request->email,
            'message'=>$request->message
        ];
    }
}
