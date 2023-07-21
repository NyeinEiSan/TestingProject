@extends('admin.layouts.master')
@section('title','Update Page')
@section('content')
            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">

                        <div class="col-lg-10 offset-1">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h3 class="text-center title-2">Pizza Update</h3>
                                    </div>
                                    <hr>
                                <form action="{{route('product#update')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                <div class="row">
                                    <div class="col-4 offset-1">
                                        <input type="hidden" name="pizzaId" value="{{$pizza->id}}">
                                       <img src="{{asset('storage/'.$pizza->image)}}" alt="John Doe" />
                                        <div class="">
                                            <input type="file" name="pizzaImage" placeholder="Image" class="form-control @error('image') is-invalid @enderror">
                                             @error('pizzaImage')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="row col-6">
                                    <div class="form-group">
                                        <label class="control-label mb-1">Name</label>
                                        <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{old('name',$pizza->name)}}" placeholder="Name">
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-1">Description</label>
                                         <textarea name="description" id="" cols="30" rows="10" class="form-control  @error('description') is-invalid @enderror">{{old('description',$pizza->description)}}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-1">Category</label>
                                        <select name="cname" id="" class="form-control  @error('cname') is-invalid @enderror" value="{{old('cname')}}">
                                            <option value="">Choose category...</option>
                                            @foreach ($category as $c)
                                                <option value="{{$c->id}}" @if($pizza->category_id == $c->id) selected @endif>{{$c->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('cname')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-1">Price</label>
                                        <input class="form-control @error('price') is-invalid @enderror" type="text" name="price" value="{{old('price',$pizza->price)}}" placeholder="price">
                                        @error('price')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-1">Waiting Time</label>
                                        <input class="form-control @error('waiting') is-invalid @enderror" type="text" name="waiting" value="{{old('waiting',$pizza->waiting_time)}}" placeholder="waiting">
                                        @error('waiting')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-1">View Count</label>
                                        <input class="form-control " type="text" name="view_count" value="{{old('view_count',$pizza->view_count)}}" disabled>
                                        <span class="focus-border-11"></span>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-1">Created_at</label>
                                        <input class="form-control " type="text" name="created_at" value="{{$pizza->created_at->format('j-F-Y')}}" disabled>
                                    </div>
                                    </div>
                                </div>

                                <div class="col-7 offset-2 mb-3">
                                    <button type="submit" class="btn btn-lg btn-info btn-block">
                                        Update<i class="fa-solid fa-circle-right"></i>
                                    </button>
                                </div>

                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->
@endsection
