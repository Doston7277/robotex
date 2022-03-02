@extends('admin.layout.layout')

@section('content')
    <div class="content-body">
        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('admin.category') }}">Category</a></li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Category Table</h4>
                            <div class="table-responsive">
                                <table id="dataCategory" class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>

                                    <tfoot>
                                    <tr>
                                        <th>Id</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                </table>

                                <div class="modal fade" id="update" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Subject update</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="category-form">
                                                    @csrf
                                                    <div class="form-row">
                                                        <input type="hidden" name="category_id" id="category_id">
                                                        <div class="form-group col-md-6">
                                                            <label for="category_name_uz">Category Name Uz <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="category_name_uz" name="category_name[uz]" placeholder="Enter a Category Name...">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="category_name_ru">Category Name Ru <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="category_name_ru" name="category_name[ru]" placeholder="Enter a Category Name...">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="category_name_en">Category Name En <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="category_name_en" name="category_name[en]" placeholder="Enter a Category Name...">
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
            table = $('#dataCategory').DataTable({
                // language: {
                //     url: '//cdn.datatables.net/plug-ins/1.11.2/i18n/uz.json'
                // },
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/admin/category/datatable",
                    type: "POST",
                    data: {
                        "_token": "{{csrf_token()}}"
                    }
                },
                columns: [
                    {data: 'id', name: 'category_id'},
                    {data: 'name', name: 'category_name'},
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $("#submit").click(function() {
                var formData = $("#category-form").serialize();
                $.ajax({
                    url: '{{ route('admin.category-update') }}',
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

        function deleted(category_id) {
            $(document).ready(function(){
                $.ajax({
                    url: '/admin/category/delete/'+category_id,
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

        function updated(category_id) {
            $.get( '/admin/category/update/'+category_id, function( data ) {
                $('#category_name_uz').val(data.category_name['uz']);
                $('#category_name_ru').val(data.category_name['ru']);
                $('#category_name_en').val(data.category_name['en']);
                $('#category_id').val(data.category_id);
            });
        }

    </script>

@endsection
