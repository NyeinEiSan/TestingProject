<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function list(){
        $category=Category::when(request('key'),function($query){
            $query->where('name','like','%'.request('key').'%');
        })->orderBy('id','desc')->paginate(4);
        $category->appends(request()->all());
        return view('admin.category.list',compact('category'));
    }

    public function create(){
        return view('admin.category.create');
    }

    public function createPage(Request $request){
        $this->categoryValidationCheck($request);
        $data=$this->requestCategoryData($request);
        Category::create($data);
        return redirect()->route('category#list')->with(['createSuccess'=>'Category Success']);
    }

    public function delete($id){
       Category::where('id',$id)->delete();
       return back()->with(['deleteSuccess'=>'Category deleted']);
    }

    public function edit($id){
        $category=Category::where('id',$id)->first();
        return view('admin.category.edit',compact('category'));
    }

    public function update(Request $request,$id){
        $request->id=$id;
        $this->categoryValidationCheck($request);
        $data=$this->requestCategoryData($request);
        Category::where('id',$id)->update($data);
        return redirect()->route('category#list');
    }


    private function categoryValidationCheck($request){
        Validator::make($request->all(),[
            'name' => 'required|unique:categories,name,'.$request->id
        ])->validate();
    }

    private function requestCategoryData($request){
        return[
            'name'=>$request->name
        ];
    }
}
