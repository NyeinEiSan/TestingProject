@extends('admin.layouts.master')

@section('title', 'Order List')
@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Order List</h2>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3">
                            <h4 class="text-secondary">Search Key : <span class="text-danger">{{ request('key') }}</span>
                            </h4>
                        </div>
                        <div class="col-3 offset-6">
                            <form action="{{ route('category#list') }}" method="get">
                                @csrf
                                <div class="d-flex">
                                    <input type="text" name="key" class="form-control" placeholder="Search..."
                                        value="{{ request('key') }}" />
                                    <button class="btn bg-dark text-white" type="submit">
                                        <i class="zmdi zmdi-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <form action="{{ route('order#orderStatus') }}" method="GET" class="col-5">
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <i class="fa-solid fa-database"></i> {{ count($order) }}
                                </div>
                            </div>
                        </div>
                        <select name="oStatus" class="custom-select" id="inputGroupSelect02">
                            <option value="">All</option>
                            <option value="0" @if (request('oStatus') == '0') selected @endif>Pending
                            </option>
                            <option value="1" @if (request('oStatus') == '1') selected @endif>Accept
                            </option>
                            <option value="2" @if (request('oStatus') == '2') selected @endif>Reject
                            </option>
                        </select>
                        <div class="input-group-append">
                            <button class="btn sm bg-dark text-white input-group-text">Search</button>
                        </div>
                    </form>


                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>User Name</th>
                                    <th>Order Code</th>
                                    <th>Amount</th>
                                    <th>Order Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id='dataList'>
                                @foreach ($order as $o)
                                    <tr class="tr-shadow">
                                        <input type="hidden" name="" class="orderId" value="{{ $o->id }}">
                                        <td>{{ $o->user_id }}</td>
                                        <td>{{ $o->user_name }}</td>
                                        <td>
                                            <a href="{{ route('order#code', $o->order_code) }}">
                                                {{ $o->order_code }}
                                            </a>
                                        </td>
                                        <td>{{ $o->totalPrice }}</td>
                                        <td>{{ $o->created_at->format('j-F-Y') }}</td>
                                        <td>
                                            <select name="status" class="changeStatus">
                                                <option value="">All</option>
                                                <option value="0" @if ($o->status == 0) selected @endif>
                                                    Pending</option>
                                                <option value="1" @if ($o->status == 1) selected @endif>
                                                    Accept</option>
                                                <option value="2" @if ($o->status == 2) selected @endif>
                                                    Reject</option>
                                            </select>
                                        </td>
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
    @section('scriptSection')
        <script>
            $(document).ready(function() {
                // $('#orderStatus').change(function() {
                //     $status = $('#orderStatus').val();
                //     console.log($status)

                //     $.ajax({
                //         type: 'get',
                //         url: 'http://localhost/lara_auth/public/order/orderStatus',
                //         data: {
                //             'status': $status
                //         },
                //         dataType: 'json',
                //         success: function(response) {
                //             $list = '';
                //             for ($i = 0; $i < response.length; $i++) {
                //                 $month = ['January', 'Febuary', 'March', 'April', 'May', 'June',
                //                     'July', 'August', 'September', 'October', 'Novbember',
                //                     'December'
                //                 ];
                //                 $dbDate = new Date(response[$i].created_at);
                //                 $finalDate = ($month[$dbDate.getMonth()] + "-" + $dbDate.getDate() +
                //                     "-" + $dbDate.getFullYear());
                //                 if (response[$i].status == 0) {
                //                     $statusMessage = `<select name="status" class="changeStatus">
        //                         <option value="">All</option>
        //                         <option value="0" selected>Pending</option>
        //                         <option value="1">Accept</option>
        //                         <option value="2">Reject</option>
        //                     </select>`;
                //                 }
                //                 if (response[$i].status == 1) {
                //                     $statusMessage = `<select name="status" class="changeStatus"
        //                         <option value="">All</option>
        //                         <option value="0">Pending</option>
        //                         <option value="1" selected>Accept</option>
        //                         <option value="2">Reject</option>
        //                     </select>`;
                //                 }
                //                 if (response[$i].status == 2) {
                //                     $statusMessage = `<select name="status" class="changeStatus"
        //                         <option value="">All</option>
        //                         <option value="0" selected>Pending</option>
        //                         <option value="1">Accept</option>
        //                         <option value="2" selected>Reject</option>
        //                     </select>`;
                //                 }
                //                 $list += ` <tr class="tr-shadow">
        //                     <input type="hidden" name="" class="orderId" value="${response[$i].id}">
        //                         <td>${response[$i].user_id}</td>
        //                         <td>${response[$i].user_name}</td>
        //                         <td>${response[$i].order_code}</td>
        //                         <td>${response[$i].totalPrice}</td>
        //                         <td>${$finalDate}</td>
        //                         <td>${$statusMessage}</td>
        //                     </tr>`;
                //             }
                //             // console.log($list);
                //             $('#dataList').html($list);
                //         }
                //     })
                // })

                $('.changeStatus').change(function() {
                    $currentStatus = $(this).val()
                    $parentNode = $(this).parents('tr')
                    $orderId = $parentNode.find('.orderId').val()

                    $.ajax({
                        type: 'get',
                        url: 'http://localhost/lara_auth/public/order/changeStatus',
                        data: {
                            'status': $currentStatus,
                            'orderId': $orderId
                        },
                        dataType: 'json',
                    })

                });
            });
        </script>
    @endsection
