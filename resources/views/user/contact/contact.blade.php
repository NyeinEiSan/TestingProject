@extends('user.layouts.master')
@section('content')
    <!-- Shop Detail Start -->
    <div class="container-fluid pb-5">
        <div class="row">
            <div class="col-8 offset-2 bg-info">
                <form action="{{ route('user#contactUs') }}" method="POST">
                    @csrf
                    <h3 class="text-center mt-3">Contact Us</h3>
                    @if (session('sendSuccess'))
                        <div class="col-4 offset-8">
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fa-solid fa-right-left"></i> {{ session('sendSuccess') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
                    <div class="col-7 offset-3 my-5">
                        <input type="text" name="name" placeholder="Your Name"class="form-control mb-3">
                        <input type="email" name="email" placeholder="Your Email"class="form-control mb-3">
                        <input type="text" name="subject" placeholder="Subject"class="form-control mb-3">
                        <textarea name="message" id="" cols="30" rows="10" class="form-control mb-3"
                            placeholder="Your Message..."></textarea>
                        <button type="submit" class="btn btn-dark">Send Message</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection
