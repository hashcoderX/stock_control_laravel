@extends('layout.header')

@section('content')
<div class="container">
    <div id="displaymsg"></div>
    <div class="row">
        <div class="col-md-4">
            <form id="customerregisterform" method="POST" action="/saveCustomer">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="exampleInputEmail1">Customer Name</label>
                    <input type="text" class="form-control" id="cusname" name="cusname" placeholder="Customer Name">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Address</label>
                    <textarea class="form-control" id="address" name="address" placeholder="Address"></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Contact No</label>
                    <input type="text" class="form-control" id="contactno" name="contactno" placeholder="Contact No">
                </div>

                <button type="submit" class="btn btn-primary" id="createbtn">Create Customer</button>
            </form>
        </div>
        <div class="col-md-8">
            <table class="table table-success table-striped">
                <tr>
                    <th>Customer Code</th>
                    <th>Customer Name</th>
                    <th>Address</th>
                    <th>Contact No</th>

                </tr>
                @foreach($customers as $customer)
                <tr>
                    <td>{{ $customer -> id }}</td>
                    <td>{{ $customer -> customer_name}}</td>
                    <td>{{ $customer -> address	}}</td>
                    <td>{{ $customer -> contact_no	}}</td>
                    <td><button class="btn btn-primary" id="{{ $customer -> id }}" onclick="changeEdit(this.id)" data-bs-toggle="modal" data-bs-target="#exampleModal">Edit</button></td>
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
                <h5 class="modal-title" id="exampleModalLabel">Edit Customer Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="producteditform">
                    <div id="displayeditmsg"></div>
                    <div class="form-group" style="display: none;">
                        <label for="exampleInputEmail1">Customer ID</label>
                        <input type="text" class="form-control" id="cusidex" name="cuside">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Customer Name</label>
                        <input type="text" class="form-control" id="cusnameeex" name="cusnameee">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Address</label>
                        <textarea class="form-control" id="addressex" name="addressex"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Telephone No</label>
                        <input type="text" class="form-control" id="contactex" name="contacte">
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
            url: "/getCustomerData/" + id,
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
                    $('#cusidex').val(data.customer.id);
                    $('#cusnameeex').val(data.customer.customer_name);
                    $('#addressex').val(data.customer.address);
                    $('#contactex').val(data.customer.contact_no);
                }
            }
        });
    }

    function saveChanges() {
        var cusid = $('#cusidex').val();
        var cusname = $('#cusnameeex').val();
        var address = $('#addressex').val();
        var contact = $('#contactex').val();

        if (cusid == "" || cusname == "" || address == "" || contact=="") {
            $('#displayeditmsg').html("");
            $('#displayeditmsg').addClass("alert alert-danger");
            $('#displayeditmsg').text("Some Text field empty");
        } else {
            $.ajax({
                url: "/editCustomer",
                method: "GET",
                data: {
                    id: cusid,
                    cusname: cusname,
                    address: address,
                    contact: contact,
                    
                },
                success: function(data) {
                    $('#displayeditmsg').html("");
                    $('#displayeditmsg').addClass("alert alert-success");
                    $('#displayeditmsg').text(data.message);
                    
                    window.location.href = "/customer";
                }
            });
        }


    }

    function reloadPage() {
        location.reload();
    }
</script>