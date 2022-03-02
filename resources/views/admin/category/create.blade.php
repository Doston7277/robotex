@extends('admin.layout.layout')

@section('content')

    <div class="content-body">

        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Create Category</h4>
                            <div class="basic-form mt-4">
                                <form id="category-data" class="form-valide">
                                    @csrf
                                    <div class="form-row">
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
                                    <button type="button" id="submit" class="btn mb-1 btn-outline-success">Create</button>
                                </form>
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

        $(document).ready(function() {
            $("#submit").click(function() {
                var formData = $("#category-data").serialize();
                $.ajax({
                    url: '/admin/category/create',
                    type: 'POST',
                    data: formData,
                    success: function (data) {
                        if (data.success) {
                            toastr['success'](data.message);
                            $('#category_name_uz').val('');
                            $('#category_name_ru').val('');
                            $('#category_name_en').val('');
                        }
                        if (!data.success) {
                            toastr['error'](data.message);
                        }
                    }
                });
            });
        });

    </script>

@endsection
