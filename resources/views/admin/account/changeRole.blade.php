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
                                     <div class="ms-5">
                                       <i class="fa-solid fa-arrow-left text-dark" onclick="history.back()"></i>
                                    </div>
                                    <div class="card-title">
                                        <h3 class="text-center title-2">Change Role</h3>
                                    </div>
                                    <hr>
                                <form action="{{route('admin#updateRole',$user->id)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                <div class="row">
                                    <div class="col-4 offset-1">
                                        @if($user->image == null)
                                             @if($user->gender=='male')
                                                    <img src="{{asset('image/default.png')}}" alt="">
                                                @else
                                                    <img src="{{asset('image/default-female.jpg')}}" alt="">
                                                @endif
                                        @else
                                            <img src="{{asset('storage/'.$user->image)}}" alt="John Doe" />
                                        @endif

                                    </div>
                                    <div class="col-6">
                                        <div class="col mb-5">
                                        <input class="textbox-11  @error('name') is-invalid @enderror" type="text" name="name" value="{{old('name',$user->name)}}" placeholder="Name" disabled>
                                        <span class="focus-border-11"></span>
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col mb-5">
                                        <input class="textbox-11  @error('email') is-invalid @enderror" type="email" name="email" value="{{old('email',$user->email)}}" placeholder="Email" disabled>
                                        <span class="focus-border-11"></span>
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col mb-5">
                                        <input class="textbox-11 @error('phone') is-invalid @enderror" type="text" name="phone" value="{{old('phone',$user->phone)}}" placeholder="Phone" disabled>
                                        <span class="focus-border-11"></span>
                                        @error('phone')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col mb-5">
                                        <select name="gender" id="" class="form-control  @error('gender') is-invalid @enderror" value="{{old('gender')}}" disabled>
                                            <option value="">Choose gender...</option>
                                            <option value="male" @if ($user->gender =='male') selected  @endif>Male</option>
                                            <option value="female"  @if ($user->gender =='female') selected  @endif>Female</option>
                                        </select>
                                        @error('gender')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col mb-5">
                                        <input class="textbox-11  @error('address') is-invalid @enderror" type="text" name="address" value="{{old('address',$user->address)}}" placeholder="Address" disabled>
                                        <span class="focus-border-11"></span>
                                        @error('address')
                                            <div class="invalid-feedback">
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col mb-5">
                                       <select name="role" class="form-control">
                                            <option value="admin" @if($user->role == 'admin') selected @endif>Admin</option>
                                            <option value="user" @if($user->role == 'user') selected @endif>User</option>
                                       </select>
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
