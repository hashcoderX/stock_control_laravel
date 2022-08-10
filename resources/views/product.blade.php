@extends('layout.header')

@section('content')
<div class="container">
    <div id="displaymsg"></div>
    <div class="row">
        <div class="col-md-4">
            <form id="productregisterform" method="POST" action="/saveProduct">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="exampleInputEmail1">Product Code</label>
                    <input type="text" class="form-control" id="prcode" name="prcode" placeholder="Enter Product Code">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Product Long Name</label>
                    <input type="text" class="form-control" id="prlongname" name="prlongname" placeholder="Product Long Name">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Product Short Name</label>
                    <input type="text" class="form-control" id="prshortname" name="prshortname" placeholder="Product Short Name">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Expiry Date</label>
                    <input type="date" class="form-control" id="expirydate" name="expirydate">
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">Price</label>
                    <input type="number" class="form-control" id="price" name="price">
                </div>

                <button type="submit" class="btn btn-primary" id="createbtn">Create Product</button>
            </form>
        </div>
        <div class="col-md-8">
            <table class="table table-success table-striped">
                <tr>
                    <th>Product id</th>
                    <th>Product Code</th>
                    <th>Product L Name</th>
                    <th>Product S Name</th>
                    <th>Expiry Date</th>
                    <th>Price</th>
                </tr>
                @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->product_code }}</td>
                    <td>{{ $product->product_long_name }}</td>
                    <td>{{ $product->Product_short_name }}</td>
                    <td>{{ $product->expiry_date }}</td>
                    <td>{{ $product->price }}</td>
                    <td><button class="btn btn-primary" id="{{ $product->id }}" onclick="changeEdit(this.id)" data-bs-toggle="modal" data-bs-target="#exampleModal">Edit</button></td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Product Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="producteditform">
                    <div id="displayeditmsg"></div>
                    <div class="form-group" style="display: none;">
                        <label for="exampleInputEmail1">Product ID</label>
                        <input type="text" class="form-control" id="pridedi" name="pridedi">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Product Code</label>
                        <input type="text" class="form-control" id="prcodeedi" name="prcodeedi">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Product Long Name</label>
                        <input type="text" class="form-control" id="prlongnameedi" name="prlongnameedi">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Product Short Name</label>
                        <input type="text" class="form-control" id="prshortnameedi" name="prshortnameedi">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Expiry Date</label>
                        <input type="date" class="form-control" id="expirydateedi" name="expirydateedi">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Price</label>
                        <input type="number" class="form-control" id="priceedi" name="priceedi">
                    </div>

                    <div class="modal-footer">
                        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                        <button type="button" onclick="saveChanges()" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

<script>
    function changeEdit(id) {
        $.ajax({
            url: "/getProductData/" + id,
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
                    $('#pridedi').val(data.product.id);
                    $('#prcodeedi').val(data.product.product_code);
                    $('#prlongnameedi').val(data.product.product_long_name);
                    $('#prshortnameedi').val(data.product.Product_short_name);
                    $('#expirydateedi').val(data.product.expiry_date);
                    $('#priceedi').val(data.product.price);
                }
            }
        });
    }

    function saveChanges() {
        var proid = $('#pridedi').val();
        var product_code = $('#prcodeedi').val();
        var product_long_name = $('#prlongnameedi').val();
        var Product_short_name = $('#prshortnameedi').val();
        var expiry_date = $('#expirydateedi').val();
        var price = $('#priceedi').val();

        if (proid == "" || product_code == "" || product_long_name == "" || expiry_date == "" || price == "") {
            $('#displayeditmsg').html("");
            $('#displayeditmsg').addClass("alert alert-danger");
            $('#displayeditmsg').text("Some Text field empty");
        } else {
            $.ajax({
                url: "/editProduct",
                method: "GET",
                data: {
                    id: proid,
                    product_code: product_code,
                    product_long_name: product_long_name,
                    Product_short_name: Product_short_name,
                    expiry_date: expiry_date,
                    price: price,
                },
                success: function(data) {
                    $('#displayeditmsg').html("");
                    $('#displayeditmsg').addClass("alert alert-success");
                    $('#displayeditmsg').text(data.message);
                    
                    window.location.href = "/product";
                }              
            });
        }


    }

    function closeModel() {
        location.reload();
    }
</script>