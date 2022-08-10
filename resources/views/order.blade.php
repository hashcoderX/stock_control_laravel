@extends('layout.header')

@section('content')

<div class="container">
    <form name="orderdetails" id="orderdetails">
        {{csrf_field()}}
        <div class="row">
            <div class="col-md-6">
                <div class="customerselection">
                    <div>Customer Name</div>
                    <select class="form-control" name="cusname" id="cusname">
                        @foreach($customers as $customer)
                        <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">

            </div>
        </div>
        <div class="row" style="margin-top: 50px;">
            <table class="table table-success table-striped">
                <tr>
                    <th>Product Code</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Enter QTY</th>
                    <th>Free Product</th>
                    <th>FI QTY</th>
                    <th>Net Amount</th>
                </tr>
                <tr>
                    <td>
                        <input type="text" class="form-control" name="productcode" id="productcode" onkeyup="getProductDetails(this.value)" />
                    </td>
                    <td>
                        <input type="text" class="form-control" name="productname" id="productname" />
                    </td>
                    <td>
                        <input type="text" class="form-control" name="price" id="price" />
                    </td>
                    <td>
                        <input type="text" class="form-control" name="qty" id="qty" onkeyup="calculateNetamount(this.value)" />
                    </td>
                    <td>
                        <input type="text" class="form-control" name="freeproduct" id="freeproduct" />
                    </td>
                    <td>
                        <input type="text" class="form-control" name="fiqty" id="fiqty" />
                    </td>
                    <td>
                        <input type="text" class="form-control" name="netamount" id="netamount" />
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary" onclick="addRow()">ADD LIST</button>
                    </td>
                </tr>
            </table>

            <h3>Product List</h3>
            <table class="table table-success table-striped" id="dynamic_field">
                <tr>
                    <th>Product Code</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Enter QTY</th>
                    <th>Free Product</th>
                    <th>FI QTY</th>
                    <th>Net Amount</th>
                </tr>
            </table>

            <input class="form-control" id="totalamount" name="totalamount" value="0" />

            <button type="submit" class="btn btn-success" onclick="submitOrder()">Place To Order</button>
    </form>
</div>
</div>

@endsection

<script>
    function getProductDetails(value) {
        $.ajax({
            url: "/getProductDataviaprcode/" + value,
            method: "GET",
            data: {
                value: value,
            },
            success: function(data) {
                if (data.status == 404) {
                    // $('#displaymsg').html("");
                    // $('#displaymsg').addClass("alert alert-danger");
                    // $('#displaymsg').text(data.message);
                } else {
                    // console.log(data);
                    // console.log(data.product['product_long_name']);
                    $('#productname').val(data.product['product_long_name']);
                    $('#price').val(data.product['price']);
                    $('#qty').val(0);
                    $('#freeproduct').val("No");
                    $('#fiqty').val(0);
                    $('#netamount').val(0);
                }
            }
        });
    }

    function calculateNetamount(qty) {

        if (qty == '') {
            qty = 0;
        } else {
            qty = qty;
        }

        var productname = $('#productname').val();

        $.ajax({
            url: "/getProductfreeissue/" + productname,
            method: "GET",
            data: {
                productname: productname,
            },
            success: function(data) {
                if (data.status == 404) {
                    // $('#displaymsg').html("");
                    // $('#displaymsg').addClass("alert alert-danger");
                    // $('#displaymsg').text(data.message);
                    // console.log("lancer");

                    var itemprice = $('#price').val();
                    var netAmount = itemprice * qty;
                    $('#netamount').val(netAmount.toFixed(2));

                } else {

                    var lowerlimit = data.freeissue['lowlim'];
                    var upperlimit = data.freeissue['upperlim'];
                    var minpurchqty = data.freeissue['purchesqty'];
                    var freeqty = data.freeissue['freeqty'];
                    var freeproduct = data.freeissue['freeproduct'];

                    // qty to number 
                    qtyn = parseInt(qty);
                    lowerlimitn = parseInt(lowerlimit);
                    upperlimit = parseInt(upperlimit);

                    if (qtyn < lowerlimitn) {
                        console.log("lancer");
                        $('#fiqty').val(0);
                        var itemprice = $('#price').val();
                        var netAmount = itemprice * qty;
                        $('#netamount').val(netAmount.toFixed(2));
                    }
                    if (qtyn == lowerlimitn) {
                        console.log("Honda");
                        $('#fiqty').val(1);
                        $('#freeproduct').val(freeproduct);

                        var itemprice = $('#price').val();
                        var netAmount = itemprice * qty;
                        $('#netamount').val(netAmount.toFixed(2));
                    }
                    if (qtyn > lowerlimitn && qtyn < upperlimit) {
                        console.log("Ek3");
                        var x = qtyn / lowerlimitn;
                        var strx = x.toString();

                        var plusNum = strx.split(".");
                        var freeqty = plusNum[0];

                        $('#fiqty').val(freeqty);

                        var itemprice = $('#price').val();
                        var netAmount = itemprice * qty;
                        $('#netamount').val(netAmount.toFixed(2));
                    }
                    if (qtyn > lowerlimitn && qtyn > upperlimit) {
                        console.log("Eg8");
                        freeqty = upperlimit / lowerlimitn;

                        $('#fiqty').val(freeqty);
                    }


                }
            }
        });

    }

    function addRow() {

        var i = 0;

        var productcode = $('#productcode').val();
        var productname = $('#productname').val();
        var price = $('#price').val();
        var qty = $('#qty').val();
        var freeproduct = $('#freeproduct').val();
        var freeqty = $('#fiqty').val();
        var netamount = $('#netamount').val();

        i++;

        $('#dynamic_field').append('<tr id="row' + i + '"> <td><input type="text" readonly="readonly" name="productcodet[]" value="' + productcode + '" id="productcodet" class="form-control" /></td> <td><input type="text" readonly="readonly" name="productnamet[]" value="' + productname + '" id="productnamet" class="form-control" /></td> <td><input type="text" readonly="readonly" name="pricet[]" value="' + price + '" id="pricet" class="form-control" /></td> <td><input type="text" readonly="readonly" name="qtyt[]" value="' + qty + '" id="qtyt" class="form-control" /></td> <td><input type="text" readonly="readonly" name="freeproductt[]" value="' + freeproduct + '" id="freeproductt" class="form-control" /></td> <td><input type="text" readonly="readonly" name="freeqtyt[]" value="' + freeqty + '" id="freeqtyt" class="form-control" /></td> <td><input type="text" readonly="readonly" name="netamountt[]" value="' + netamount + '" id="netamountt" class="form-control" /></td></tr>')

        var x = document.getElementById('totalamount').value;
        var total = parseFloat(x) + parseFloat(netamount);
        $('#totalamount').val(total.toFixed(2));

        clearText();

    }

    function clearText() {
        var productcode = $('#productcode').val("");
        var productname = $('#productname').val("");
        var price = $('#price').val(0);
        var qty = $('#qty').val(0);
        var freeproduct = $('#freeproduct').val("");
        var freeqty = $('#fiqty').val(0);
        var netamount = $('#netamount').val(0);

        setFocus()
    }

    function setFocus() {
        $('#productcode').focus();
    }
    // orderdetails
    function submitOrder() {

        $.ajax({
            url: "/placeOrder",
            method: "POST",
            data: $('#orderdetails').serialize(),
            _token: '{{ csrf_token() }}',
            success: function(data) {

                $('#dynamic_field').find('tr:gt(1)').remove();


                // pageReloade();
            }
        });
    }

    function pageReloade() {
        location.reload();
    }
</script>