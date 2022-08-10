@extends('layout.header')

@section('content')
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> -->
<div class="container">
    <div id="displaymsg"></div>
    <div class="row">
        <div class="col-md-4">
            <form id="freeissuedefine" method="POST" action="/saveFreeIssue">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="exampleInputEmail1">Free Issue Lable</label>
                    <input type="text" class="form-control" id="freeissue_lable" name="freeissue_lable" placeholder="Free Issue Lable">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Purchese Product</label>
                    <select class="form-control" id="purchese_product" name="purchese_product">
                        <option>Select</option>
                        @foreach($products as $product )
                        <option value="{{ $product->product_long_name }}">{{ $product->product_long_name }}</option>
                        @endforeach
                    </select>
                    <!-- <input type="text" class="form-control" id="purchese_product" name="purchese_product" placeholder="Purchese Product"> -->
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Free Product</label>
                    <select class="form-control" id="free_product" name="free_product">
                        <option>Select</option>
                        @foreach($products as $product )
                        <option value="{{ $product->product_long_name }}">{{ $product->product_long_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Purches QTY</label>
                    <input type="number" class="form-control" id="purches_qty" name="purches_qty">
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">Free Qty</label>
                    <input type="number" class="form-control" id="freeqty" name="freeqty">
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">Lower Limit</label>
                    <input type="number" class="form-control" id="lowerlimit" name="lowerlimit">
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">Upper Limit</label>
                    <input type="number" class="form-control" id="upperlimit" name="upperlimit">
                </div>

                <button type="submit" class="btn btn-primary" id="createbtn">Free Issue Define</button>
            </form>
        </div>
        <div class="col-md-8">
            <table class="table table-success table-striped">
                <tr>
                    <th>Fr.I Lable</th>
                    <th>Purchese Product</th>
                    <th>Free Product</th>
                    <th>Purches QTY</th>
                    <th>Free Qty</th>
                    <th>Lower Limit</th>
                    <th>Upper Limit</th>
                </tr>
                @foreach($freeissueproducts as $freeissueproduct)
                <tr>
                    <td>{{ $freeissueproduct->lable }}</td>
                    <td>{{ $freeissueproduct->purchase_product }}</td>
                    <td>{{ $freeissueproduct->freeproduct }}</td>
                    <td>{{ $freeissueproduct->purchesqty }}</td>
                    <td>{{ $freeissueproduct->freeqty }}</td>
                    <td>{{ $freeissueproduct->lowlim }}</td>
                    <td>{{ $freeissueproduct->upperlim }}</td>
                    <td><button class="btn btn-primary" id="{{ $freeissueproduct->id }}" onclick="changeEdit(this.id)" data-bs-toggle="modal" data-bs-target="#exampleModal">Edit</button></td>
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
                <h5 class="modal-title" id="exampleModalLabel">Edit Free Issue Define</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"  aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="producteditform">
                    <div id="displayeditmsg"></div>
                    <div class="form-group" style="display: none;">
                        <label for="exampleInputEmail1">Define ID</label>
                        <input type="text" class="form-control" id="defineidex" name="defineidex">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Lable</label>
                        <input type="text" class="form-control" id="lableex" name="lableex">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Purchese Product</label>
                        <select class="form-control" id="purches_producte" name="purches_producte">
                            <option>Select</option>
                            @foreach($products as $product )
                            <option value="{{ $product->product_long_name }}">{{ $product->product_long_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Free Product</label>
                        <select class="form-control" id="free_product_e" name="free_product_e">
                            <option>Select</option>
                            @foreach($products as $product )
                            <option value="{{ $product->product_long_name }}">{{ $product->product_long_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Purches QTY</label>
                        <input type="number" class="form-control" id="purches_qty_e" name="purches_qty_e">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Free Qty</label>
                        <input type="number" class="form-control" id="freeqtye" name="freeqtye">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Lower Limit</label>
                        <input type="number" class="form-control" id="lowerlimite" name="lowerlimite">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Upper Limit</label>
                        <input type="number" class="form-control" id="upperlimite" name="upperlimite">
                    </div>

                    <div class="modal-footer">
                        <!-- <button type="button" class="btn btn-secondary" onclick="closeModel()" data-bs-dismiss="modal">Close</button> -->
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
            url: "/getFreedefineData/" + id,
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
                    // console.log(data);
                    $('#defineidex').val(data.freedefine.id);  
                    $('#lableex').val(data.freedefine.lable);
                    $('#purches_producte').val(data.freedefine.purchase_product);
                    $('#free_product_e').val(data.freedefine.freeproduct);
                    $('#purches_qty_e').val(data.freedefine.purchesqty);
                    $('#freeqtye').val(data.freedefine.freeqty);
                    $('#lowerlimite').val(data.freedefine.lowlim);
                    $('#upperlimite').val(data.freedefine.upperlim);
                }
            }
        });
    }

    function saveChanges() {
       
        var defid = $('#defineidex').val();
        var label = $('#lableex').val();
        var purches_product = $('#purches_producte').val();
        var free_product = $('#free_product_e').val();
        var purchqty = $('#purches_qty_e').val();
        var freeqty = $('#freeqtye').val();
        var lowlimit = $('#lowerlimite').val();
        var upperlimit = $('#upperlimite').val();
       
        if (defid == "" || label == "" || purches_product == "" || free_product == "" || purchqty == "" || freeqty == "" || lowlimit == "" || upperlimit == "") {
            $('#displayeditmsg').html("");
            $('#displayeditmsg').addClass("alert alert-danger");
            $('#displayeditmsg').text("Some Text field empty");
        } else {
            $.ajax({
                url: "/editfreeIssue",
                method: "GET",
                data: {
                    id: defid,
                    label: label,
                    purches_product: purches_product,
                    free_product: free_product,
                    purchqty: purchqty,
                    freeqty: freeqty,
                    lowlimit: lowlimit,
                    upperlimit: upperlimit,
                },
                success: function(data) {
                    $('#displayeditmsg').html("");
                    $('#displayeditmsg').addClass("alert alert-success");
                    $('#displayeditmsg').text(data.message);
                    
                    // window.location.reload();
                    window.location.href = "/freeissuedefining";
                }
            });
        }


    }

    
</script>