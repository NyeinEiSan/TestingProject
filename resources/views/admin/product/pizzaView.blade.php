@extends('admin.layouts.master')
@section('title','Create Page')
@section('content')
            <!-- MAIN CONTENT-->
            <div class="main-content">
                <div class="row">
                    <div class="col-4 offset-4">
                        @if(session('updatesucess'))
                             <div class="">
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fa-regular fa-check"></i> {{session('updatesucess')}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                            @endif
                    </div>
                </div>
                <div class="section__content section__content--p30">
                    <div class="container-fluid">

                        <div class="col-lg-10 offset-1">
                            <div class="card">
                                <div class="card-body">
                                    <div class="ms-5">
                                       <i class="fa-solid fa-arrow-left text-dark" onclick="history.back()"></i>
                                    </div>
                                    {{-- <div class="card-title">
                                        <h3 class="text-center title-2">Pizza Detalis</h3>
                                    </div> --}}
                                    <hr>
                                    <div class="row">
                                        <div class="col-3 offset-2">
                                           <img src="{{asset('storage/'.$pizza->image)}}" class="img-thumbnail shadow-sm">
                                        </div>
                                        <div class="col-7">
                                            <div class="btn bg-danger w-50 d-block my-2 fs-5 text-white">{{$pizza->name }}</div>

                                            <span class="btn bg-dark text-white my-2"> <i class="fa-solid fa-money-bill-1-wave me-2 "></i>{{ $pizza->price}} kyats</span>
                                            <span class="btn bg-dark text-white my-2"> <i class="fa-solid fa-clock me-2 "></i>{{ $pizza->waiting_time }} mins</span>
                                            <span class="btn bg-dark text-white my-2"> <i class="fa-solid fa-eye me-2 "></i>{{$pizza->view_count }}</span>
                                            <span class="btn bg-dark text-white my-2"> <i class="fa-solid fa-coins me-2 "></i>{{$pizza->category_name }}</span>
                                            <span class="btn bg-dark text-white my-2"> <i class="fa-solid fa-user-clock me-2 "></i>{{ $pizza->created_at->format('j-F-Y') }}</span>
                                            <div class="my-2"><i class="fa-solid fa-file-lines me-2 "></i>{{ $pizza->description }}</div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END MAIN CONTENT-->



@endsection
