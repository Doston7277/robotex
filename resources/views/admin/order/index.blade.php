@extends('admin.layout.layout')

@section('content')
    <div class="content-body">
        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('admin.orders') }}">Product</a></li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Order Table</h4>
                            <div class="table-responsive">
                                <table id="dataOrder" class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>User name</th>
                                        <th>User first name</th>
                                        <th>User last name</th>
                                        <th>User father name</th>
                                        <th>User address</th>
                                        <th>Order date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Id</th>
                                        <th>User name</th>
                                        <th>User first name</th>
                                        <th>User last name</th>
                                        <th>User father name</th>
                                        <th>User address</th>
                                        <th>Order date</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                </table>
                                <div class="modal fade" id="detail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Product update</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" id="order_id">
                                                <h6 class="d-inline">User name: </h6>
                                                <p class="d-inline" id="user_name"></p>
                                                <br>
                                                <h6 class="d-inline">User phone: </h6>
                                                <p class="d-inline" id="user_phone"></p>
                                                <br>
                                                <h6 class="d-inline">User first name: </h6>
                                                <p class="d-inline" id="user_first_name"></p>
                                                <br>
                                                <h6 class="d-inline">User last name: </h6>
                                                <p class="d-inline" id="user_last_name"></p>
                                                <br>
                                                <h6 class="d-inline">User father name: </h6>
                                                <p class="d-inline" id="user_father_name"></p>
                                                <br>
                                                <h6 class="d-inline">User address: </h6>
                                                <p class="d-inline" id="user_address"></p>

                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">id</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Model</th>
                                                        <th scope="col">Price</th>
                                                        <th scope="col">Company</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr id="products">
                                                    </tr>
                                                    </tbody>
                                                </table>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" id="close" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                                                <button type="button" onclick="order_save()" class="btn btn-outline-success" data-dismiss="modal">Qabul qilish</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset( 'admin/plugins/jquery/jquery.min.js' ) }}"></script>
    <script>

        function order(order_id){
            $.get( '/admin/order/'+ order_id, function( data ) {
                $('#order_id').val(data.order_id)
                $('#user_name').text(data.users.user_name)
                $('#user_phone').text(data.users.user_phone)
                $('#user_first_name').text(data.users.user_first_name)
                $('#user_last_name').text(data.users.user_last_name)
                $('#user_father_name').text(data.users.user_father_name)
                $('#user_address').text(data.users.user_address)

                var products = "";
                $.each( data.products, function( key, product) {
                    products+="<td>"+product.id+"</td>" +
                        "<td>"+product.name['{{ app()->getLocale() }}']+"</td>" +
                        "<td>"+product.model+"</td>" +
                        "<td>"+product.price+"</td>" +
                        "<td>"+product.company+"</td>";
                });
                $('#products').html(products);

            });
        }

        function order_save()
        {
            $.get( '/admin/order/'+ order_id, function( data ) {

            });
        }

        $(document).ready(function(){
            table = $('#dataOrder').DataTable({
                // language: {
                //     url: '//cdn.datatables.net/plug-ins/1.11.2/i18n/uz.json'
                // },
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/admin/order/datatable",
                    type: "POST",
                    data: {
                        "_token": "{{csrf_token()}}"
                    }
                },
                columns: [
                    {data: 'id', name: 'order_id'},
                    {data: 'username', name: 'users.user_name'},
                    {data: 'first_name', name: 'users.user_first_name'},
                    {data: 'last_name', name: 'users.user_last_name'},
                    {data: 'father_name', name: 'users.user_father_name'},
                    {data: 'address', name: 'users.user_address'},
                    {data: 'order_date', name: 'created_at'},
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });

    </script>

@endsection
