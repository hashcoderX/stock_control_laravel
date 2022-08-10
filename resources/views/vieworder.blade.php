@extends('layout.header')

@section('content')

<div class="container">
    <div class="row">
        <table class="table table-success table-striped">
            <tr>
                <th>Order Id</th>
                <th>Customer Name</th>
                <th>Address</th>
                <th>Contact No</th>
                <th>Net Amount</th>
            </tr>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->customer_name }}</td>
                <td>{{ $order->address }}</td>
                <td>{{ $order->contact_no }}</td>
                <td>{{ $order->netamount }}</td>
                <td><button id="{{ $order->id }}" onclick="viewOrder(this.id)" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">View</button></td>
            </tr>
            @endforeach
        </table>


    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="closeModel()"></button>
            </div>
            <div class="modal-body">
                <div id="producteditform">
                    <div id="displayeditmsg"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" id="ordid">
                            <div id="orderid"></div>
                            <div id="customername"></div>
                            <div id="customeraddress"></div>
                            <div id="custelephone"></div>
                        </div>
                        <div class="col-md-6">
                            <div id="netamount"></div>
                        </div>
                    </div>
                    <div class="row">
                        <table id="productview" class="table table-success table-striped">
                            <tr>
                                <th>Product Name</th>
                                <th>Qty</th>
                                <th>Free Product</th>
                                <th>Free Qty</th>
                                <th>Net Amount</th>
                            </tr>

                            @foreach($orderitems as $orderitem)
                            <tr>
                                <td>{{ $orderitem->productname }}</td>
                                <td>{{ $orderitem->qty }}</td>
                                <td>{{ $orderitem->freeproduct }}</td>
                                <td>{{ $orderitem->freeqty }}</td>
                                <td>{{ $orderitem->netamount }}</td>
                            </tr>
                            @endforeach
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection

<script>
    function viewOrder(id) {
        $.ajax({
            url: "/getOrderData/" + id,
            method: "GET",
            data: {
                id: id,
            },
            success: function(data) {
                if (data.status == 404) {
                    $('#displaymsg').html("");
                    $('#displaymsg').addClass("alert alert-danger");
                    $('#displaymsg').text(data.message);
                } else {
                    document.getElementById('orderid').innerHTML = "Order ID : " + data.order.id;
                    document.getElementById('netamount').innerHTML = "Rs. " + data.order.netamount;
                    document.getElementById('customername').innerHTML = data.customer.customer_name;
                    document.getElementById('customeraddress').innerHTML = data.customer.address;
                    document.getElementById('custelephone').innerHTML = data.customer.contact_no;
                    document.getElementById('ordid').value = data.order.id;
                    // console.log(data);

                    // var table = document.getElementById('productview');

                    // for(var i= 0; i < data.length; i++){
                    //         var row = `<tr>
                    //         <td>${data[i].}</td>
                    //         </tr>`
                    // }
                }
            }
        });
    }
</script>