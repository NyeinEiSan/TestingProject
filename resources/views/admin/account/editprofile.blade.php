@extends('admin.layouts.master')
@section('title','Create Page')
@section('content')
            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">

                        <div class="col-lg-10 offset-1">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h3 class="text-center title-2">Account Info</h3>
                                    </div>
                                    <hr>
                                <form action="{{route('admin#update',Auth::user()->id)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                <div class="row">
                                    <div class="col-4 offset-1">
                                        @if(Auth::user()->image == null)
                                             @if(Auth::user()->gender=='male')
                                                    <img src="{{asset('image/default.png')}}" alt="">
                                                @else
                                                    <img src="{{asset('image/default-female.jpg')}}" alt="">
                                                @endif
                                        @else
                                            <img src="{{asset('storage/'.Auth::user()->image)}}" alt="John Doe" />
                                        @endif
                                        <div class="">
                                            <input type="file" name="image" placeholder="Image" class="form-control @error('image') is-invalid @enderror">
                                             @error('image')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="col mb-5">
                                        <input class="textbox-11 @error('name') is-invalid @enderror" type="text" name="name" value="{{old('name',Auth::user()->name)}}" placeholder="Name">
                                        <span class="focus-border-11"></span>
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col mb-5">
                                        <input class="textbox-11  @error('email') is-invalid @enderror" type="email" name="email" value="{{old('email',Auth::user()->email)}}" placeholder="Email">
                                        <span class="focus-border-11"></span>
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col mb-5">
                                        <input class="textbox-11 @error('phone') is-invalid @enderror" type="text" name="phone" value="{{old('phone',Auth::user()->phone)}}" placeholder="Phone">
                                        <span class="focus-border-11"></span>
                                        @error('phone')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col mb-5">
                                        <select name="gender" id="" class="form-control  @error('gender') is-invalid @enderror" value="{{old('gender')}}">
                                            <option value="">Choose gender...</option>
                                            <option value="male" @if (Auth::user()->gender =='male') selected  @endif>Male</option>
                                            <option value="female"  @if (Auth::user()->gender =='female') selected  @endif>Female</option>
                                        </select>
                                        @error('gender')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col mb-5">
                                        <input class="textbox-11 @error('address') is-invalid @enderror" type="text" name="address" value="{{old('address',Auth::user()->address)}}" placeholder="Address">
                                        <span class="focus-border-11"></span>
                                        @error('address')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col mb-5">
                                        <input class="textbox-11 " type="text" name="role" value="{{old('role',Auth::user()->role)}}" placeholder="Role" disabled>
                                        <span class="focus-border-11"></span>
                                    </div>
                                    </div>
                                </div>

                                <div class="col-7 offset-2 mb-3">
                                    <button type="submit" class="btn btn-lg btn-info btn-block">
                                        Save changes <i class="fa-solid fa-circle-right"></i>
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
