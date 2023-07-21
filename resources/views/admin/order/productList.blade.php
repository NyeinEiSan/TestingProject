@extends('admin.layouts.master')

@section('title', 'Order List')
@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-responsive table-responsive-data2">
                        <a href="{{ route('order#list') }}" class="text-dark"><i class="fa-solid fa-arrow-left-long"></i></a>
                        <div class="card col-6 mt-4">
                            <div class="card-body">
                                <h3><i class="fa-solid fa-clipboard me-3"></i>Order Info</h3>
                                <small class="text-warning">Include delivery charges</small>

                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col"><i class="fa-solid fa-user me-2"></i> Customer Name</div>
                                    <div class="col">{{ strtoupper($order[0]->user_name) }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col"><i class="fa-solid fa-barcode me-2"></i> Order Code</div>
                                    <div class="col">{{ $order[0]->order_code }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col"><i class="fa-regular fa-clock me-2"></i> Order Date</div>
                                    <div class="col">{{ $order[0]->created_at->format('j-F-Y') }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col"><i class="fa-solid fa-money-bill-wave"></i> Total</div>
                                    <div class="col">{{ $price->totalPrice }}kyats</div>
                                </div>
                            </div>
                        </div>
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Order ID</th>
                                    <th>Prodcut Image</th>
                                    <th>Product Name</th>
                                    <th>Qty</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody id='dataList'>
                                @foreach ($order as $o)
                                    <tr class="tr-shadow">
                                        <td></td>
                                        <td>{{ $o->user_id }}</td>
                                        <td class="col-2"><img src="{{ asset('storage/' . $o->image) }}"
                                                class="img_thumbnail shadow-sm"></td>
                                        <td>{{ $o->product_name }}</td>
                                        <td>{{ $o->qty }}</td>
                                        <td>{{ $o->total }}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- END DATA TABLE -->
                        {{-- <div class="mt-3">
                                {{$order->links()}}
                            </div>  --}}
                    </div>
                </div>
            </div>
        </div>
        <!-- END MAIN CONTENT-->
    @endsection
