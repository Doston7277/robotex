@extends('admin.layout.layout')

@section('content')
    <div class="content-body">
        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('admin.product') }}">Product</a></li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Product Table</h4>
                            <div class="table-responsive">
                                <table id="dataProduct" class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Category</th>
                                        <th>Name</th>
                                        <th>Model</th>
                                        <th>Company</th>
                                        <th>Price</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>

                                    <tfoot>
                                    <tr>
                                        <th>Id</th>
                                        <th>Category</th>
                                        <th>Name</th>
                                        <th>Model</th>
                                        <th>Company</th>
                                        <th>Price</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                </table>

                                <div class="modal fade" id="update" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Product update</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="product-form">
                                                    @csrf
                                                    <div class="form-row">
                                                        <input type="hidden" name="product_id" id="product_id">
                                                        <div class="form-group col-md-6">
                                                            <label for="categories">Category <span class="text-danger">*</span></label>
                                                            <select id="categories" class="form-control" name="category_id"></select>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="product_name_uz">Product Name Uz <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="product_name_uz" name="product_name[uz]" placeholder="Enter a product Name...">
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label for="product_name_ru">Product Name Ru <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="product_name_ru" name="product_name[ru]" placeholder="Enter a product Name...">
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label for="product_name_en">Product Name En <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="product_name_en" name="product_name[en]" placeholder="Enter a product Name...">
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label for="product_model">Product Model <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="product_model" name="product_model" placeholder="Enter a product Model...">
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label for="product_company">Product Company <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="product_company" name="product_company" placeholder="Enter a product Company...">
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label for="product_price">Product Price <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="product_price" name="product_price" placeholder="Enter a product Price...">
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
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script>
        FilePond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginImageResize,
            FilePondPluginImageTransform
        );
        const inputElement = document.querySelector('input[id="product_image"]');
        const pond = FilePond.create(inputElement, {
            labelIdle: `<i class="fa fa-plus-circle"> Upload Image</i>`,
        });
        FilePond.setOptions({
            server: {
                url: '/admin/product/upload',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            }
        });
        $(document).ready(function(){
            var url = "/admin/category/select/";
            $.get( url, function( data ) {
                var options = "";
                $.each( data, function( key, category) {
                    options+="<option value="+category.category_id+" >"+category.category_name['{{ app()->getLocale() }}']+"</option>";
                });
                $('#categories').html(options);
            });
            table = $('#dataProduct').DataTable({
                // language: {
                //     url: '//cdn.datatables.net/plug-ins/1.11.2/i18n/uz.json'
                // },
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/admin/product/datatable",
                    type: "POST",
                    data: {
                        "_token": "{{csrf_token()}}"
                    }
                },
                columns: [
                    {data: 'id', name: 'product_id'},
                    {data: 'category', name: 'category.category_name'},
                    {data: 'name', name: 'product_name'},
                    {data: 'model', name: 'product_model'},
                    {data: 'company', name: 'product_company'},
                    {data: 'price', name: 'product_price'},
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $("#submit").click(function() {
                var formData = $("#product-form").serialize();
                $.ajax({
                    url: '{{ route('admin.product-update') }}',
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

        function deleted(product_id) {
            $(document).ready(function(){
                $.ajax({
                    url: '/admin/product/delete/'+product_id,
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

        function updated(product_id) {
            $.get( '/admin/product/update/'+product_id, function( data ) {
                var url = "/admin/category/select/";
                $.get( url, function( data ) {
                    var options = "";
                    $.each( data, function( key, category) {
                        options+="<option value="+category.category_id+" >"+category.category_name['{{ app()->getLocale() }}']+"</option>";
                    });
                    $('#categories').html(options);
                });
                $('#product_name_uz').val(data.product_name['uz']);
                $('#product_name_ru').val(data.product_name['ru']);
                $('#product_name_en').val(data.product_name['en']);
                $('#product_model').val(data.product_model);
                $('#product_company').val(data.product_company);
                $('#product_price').val(data.product_price);
                $('#product_quantity').val(data.product_quantity);
                $('#product_color').val(data.product_color);
                $('#product_id').val(data.product_id);
            });
        }

    </script>

@endsection
