@extends('admin.layout.layout')

@section('content')
    <div class="content-body">
        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('admin.users') }}">Users</a></li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Users Table</h4>
                            <div class="table-responsive">
                                <table id="dataUsers" class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Password</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Image</th>
                                            <th>Id</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Password</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="modal fade" id="update" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">User update</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="user-form">
                                                    @csrf
                                                    <div class="form-row">
                                                        <input type="hidden" name="user_id" id="user_id">
                                                        <div class="form-group col-md-6">
                                                            <label for="user_name">Name <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Enter a User Name...">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="user_phone">Phone <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="user_phone" name="user_phone" placeholder="Enter a User phone...">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="user_password_new">New Password <span class="text-danger">*</span></label>
                                                            <input type="password" class="form-control" id="user_password_new" name="user_password_new" placeholder="Enter a User Password...">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="user_password_confiration">New Confirmation Password <span class="text-danger">*</span></label>
                                                            <input type="password" class="form-control" id="user_password_confiration" name="user_password_confiration" placeholder="Enter a User Password...">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="is_admin">User Type <span class="text-danger">*</span></label>
                                                            <select class="form-control" id="is_admin" name="is_admin">
                                                                <option value="true">Admin</option>
                                                                <option value="false">User</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" id="close" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                                                <button type="button" id="submit" class="btn btn-outline-success" data-dismiss="modal">Save changes</button>
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
        $(document).ready(function(){

            table = $('#dataUsers').DataTable({
                // language: {
                //     url: '//cdn.datatables.net/plug-ins/1.11.2/i18n/uz.json'
                // },
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/admin/users/datatable",
                    type: "POST",
                    data: {
                        "_token": "{{csrf_token()}}"
                    }
                },
                columns: [
                    {
                        data: "image",
                        render: function (data, type, full, meta) {
                            return "<img src=\"" + data + "\" height=\"50\"/>";
                        },
                        orderable: false,
                        searchable: false
                    },
                    {data: 'id', name: 'user_id'},
                    {data: 'name', name: 'user_name'},
                    {data: 'phone', name: 'user_phone'},
                    {data: 'password', name: 'user_password'},
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $("#submit").click(function() {
                var formData = $("#user-form").serialize();
                $.ajax({
                    url: '{{ route('admin.user-update') }}',
                    type: 'POST',
                    data: formData,
                    success: function (data) {
                        if (data.success) {
                            toastr['success'](data.message);
                            table.ajax.reload();
                        }
                        if (!data.success) {
                            toastr['error'](data.message);
                        }
                    }
                });
            });
        });

        function deleted(user_id) {
            $(document).ready(function(){
                $.ajax({
                    url: '/admin/user/delete/'+user_id,
                    type: 'GET',
                    success: function (data) {
                        if (data.success) {
                            toastr['success'](data.message);
                            table.ajax.reload();
                        }
                        if (!data.success) {
                            toastr['error'](data.message);
                        }
                    }
                });
            });
        }

        function updated(user_id) {
            $.get( '/admin/user/update/'+user_id, function( data ) {
                $('#user_id').val(data.user_id);
                $('#user_name').val(data.user_name);
                $('#user_phone').val(data.user_phone);
                if (!data.is_admin){
                    $('#is_admin').val("false");
                }
            });
        }
    </script>

@endsection
