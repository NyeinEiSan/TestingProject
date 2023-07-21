<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
   public function list(){
    $pizza =Product::select('products.*','categories.name as category_name')
    ->when(request('key'),function($query){
        $query->where('products.name','like','%'.request('key').'%');
    })->leftJoin('categories','products.category_id','categories.id')
    ->orderBy('products.created_at','desc')->paginate(3);
    $pizza->appends(request()->all());
    return view('admin.product.pizzaList',compact('pizza'));
   }

   public function create(){
    $category=Category::select('id','name')->get();
    return view('admin.product.createPizza',compact('category'));
   }

   public function createPage(Request $request){
        $this->pizzaValidationCheck($request,"cc");
        $data=$this->requestPizzData($request);

        $fileName=uniqid().$request->file('pizzaImage')->getClientOriginalName();
        $request->file('pizzaImage')->storeAs('public',$fileName);
        $data['image']=$fileName;

        Product::create($data);
        return redirect()->route('product#list')->with(['createSuccess'=>'Category Success']);
   }

   public function delete($id){
        Product::where('id',$id)->delete();
        return back()->with(['deleteSuccess'=>'Product Delete Success...']);
   }

   public function view($id){
        $pizza=Product::select('products.*','categories.name as category_name')
        ->leftJoin('categories','products.category_id','categories.id')
        ->where('products.id',$id)->first();
        return view('admin.product.pizzaView',compact('pizza'));
   }

   public function edit($id){
         $pizza=Product::where('id',$id)->first();
         $category=Category::get();
        return view('admin.product.pizzaEdit',compact('pizza','category'));
   }

   public function update(Request $request){
        $this->pizzaValidationCheck($request,"uu");
        $data=$this->requestPizzData($request);
        if($request->hasFile('pizzaImage')){
            $dbImage=Product::where('id',$request->pizzaId)->first();
            $dbImage=$dbImage->image;
            if($dbImage != null){
                Storage::delete('public/'.$dbImage);
            }
            $fileName=uniqid().$request->file('pizzaImage')->getClientOriginalName();
            $request->file('pizzaImage')->storeAs('public',$fileName);
            $data['image']=$fileName;
        }
         Product::where('id',$request->pizzaId)->update($data);
        return redirect()->route('product#list')->with(['updatesucess'=>'Updated successfully']);
   }

    private function pizzaValidationCheck($request,$action){
       $validationRules=[
            'name' => 'required|unique:products,name,'.$request->pizzaId,
            'cname'=>'required',
            'description'=>'required|min:5',
            'price'=>'required',
            'waiting'=>'required'
        ];
        $validationRules['pizzaImage'] = $action == "cc" ? 'required|mimes:jpg,jpeg,png,webp|file' : 'mimes:jpg,jpeg,png,webp|file';
        Validator::make($request->all(),$validationRules)->validate();
    }

        private function requestPizzData($request){
        return[
            'category_id'=>$request->cname,
            'name'=>$request->name,
            'description'=>$request->description,
            'price'=>$request->price,
            'waiting_time'=>$request->waiting
        ];
    }
}
