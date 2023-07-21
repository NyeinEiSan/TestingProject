@extends('user.layouts.master')
@section('content')
 <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0" id="dataTable">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($cart as $c)
                            <tr>
                                <td><img src="{{asset('storage/'.$c->product_image)}}" alt="" style="width: 50px;" class="img-thumbnail"></td>
                                <td class="align-middle">{{$c->pizza_name}}
                                    <input type="hidden" class="orderId" value="{{$c->id}}">
                                    <input type="hidden" class="productId" value="{{$c->product_id}}">
                                    <input type="hidden" class="userId" value="{{$c->user_id}}">
                                </td>
                                <td class="align-middle" id="priceId">{{$c->price}} kyats</td>
                                <td class="align-middle">
                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-minus" >
                                            <i class="fa fa-minus"></i>
                                            </button>
                                        </div>

                                        <input type="text" class="form-control form-control-sm  border-0 text-center" value="{{$c->qty}}" id="qty">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-primary btn-plus">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle col-3" id="total">{{$c->price * $c->qty}} kyats</td>
                                <td class="align-middle"><button class="btn btn-sm btn-danger btnRemove"><i class="fa fa-times"></i></button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class=" pr-3">Cart Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6 id="subtotal">{{$totalPrice}} kyats</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Delivery</h6>
                            <h6 class="font-weight-medium">3000 kyats</h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5 id="final">{{$totalPrice +3000}} kyats</h5>
                        </div>
                        <button class="btn btn-block btn-primary font-weight-bold my-3 py-3" id="orderBtn">Proceed To Checkout</button>
                        <button class="btn btn-block btn-danger font-weight-bold my-3 py-3" id="clearBtn">Clear Cart</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection
@section('scriptSource')
<script src="{{asset('js/cart.js')}}"></script>
<script>
    $('#orderBtn').click(function(){
        // $userId =$('#userId').val(),
        // $productId =$('#productId').val(),
        // $qty =$('#qty').val(),
        // $total =$('#total').text().replace('kyats',' ')*1
        // console.log($total)
        $orderList= [];
        $random=Math.floor(Math.random()*10001);
        $('#dataTable tbody tr').each(function(index,row) {
            $orderList.push({
                'user_id'   : $(row).find('.userId').val(),
                'product_id'   : $(row).find('.productId').val(),
                'qty'   : $(row).find('#qty').val(),
                'total'   : $(row).find('#total').html().replace("kyats"," "),
                'order_code': $random
            });
        });
        $.ajax({
                type:'get',
                url:'http://localhost/lara_auth/public/user/ajax/order',
                data :Object.assign({},$orderList),
                dataType:'json',
                success:function(response){
                    if(response.status=='true'){
                        window.location.href="http://localhost/lara_auth/public/user/home";
                    }
                }
            })
        });

        $('#clearBtn').click(function(){
            $('#dataTable tbody tr').remove()

            $.ajax({
                type:'get',
                url:'http://localhost/lara_auth/public/user/ajax/clear',
                dataType:'json',
            })
        });

        $('.btnRemove').click(function () {
            $parentNode = $(this).parents("tr");
            $productId=$parentNode.find('.productId').val();
            $orderId=$parentNode.find('.orderId').val();
            $parentNode.remove();
            $totalPrice = 0;
            $('#dataTable tr').each(function (index, row) {
                $totalPrice += Number($(row).find('#total').text().replace("kyats", " "))
            });
            $('#subtotal').html(`${$totalPrice} kyats`)
            $('#final').html(`${$totalPrice + 3000} kyats`)

             $.ajax({
                type:'get',
                url:'http://localhost/lara_auth/public/user/ajax/current',
                data  : {'productId': $productId,'orderId' : $orderId},
                dataType:'json',
            })

        })
</script>
@endsection

