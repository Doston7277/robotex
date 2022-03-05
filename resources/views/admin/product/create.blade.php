@extends('admin.layout.layout')

@section('content')

    <div class="content-body">

        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Product</a></li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Create Product</h4>
                            <div class="basic-form mt-4">
                                <form action="/admin/product/create" method="post" class="form-valide" enctype='multipart/form-data'>
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="categories">Category <span class="text-danger">*</span></label>
                                            <select id="categories" class="form-control" name="category_id"></select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="product_name_uz">Product Name Uz<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="product_name_uz" name="product_name[uz]" placeholder="Enter a Product Name...">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="product_name_ru">Product Name Ru<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="product_name_ru" name="product_name[ru]" placeholder="Enter a Product Name...">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="product_name_en">Product Name En<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="product_name_en" name="product_name[en]" placeholder="Enter a Product Name...">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="product_model">Product Model <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="product_model" name="product_model" placeholder="Enter a Product Model...">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="product_company">Product Company <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="product_company" name="product_company" placeholder="Enter a Product Company...">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="product_price">Product Price <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="product_price" name="product_price" placeholder="Enter a Product Price...">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="product_image">Product Image <span class="text-danger">*</span></label>
                                            <input type="file" multiple name="product_image[]" class="form-control-file">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="product_description_uz">Product Description Uz<span class="text-danger">*</span></label>
                                            <textarea  name="product_description[uz]" id="product_description_uz" class="form-control" rows="5"></textarea>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="product_description_ru">Product Description Ru<span class="text-danger">*</span></label>
                                            <textarea  name="product_description[ru]" id="product_description_ru" class="form-control" rows="5"></textarea>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="product_description_en">Product Description En<span class="text-danger">*</span></label>
                                            <textarea  name="product_description[en]" id="product_description_en" class="form-control" rows="5"></textarea>
                                        </div>


                                        <div id="nature-area" class="col-md-12">
                                            <div class="row">
                                                <div class="form-group col-md-2">
                                                    <label for="product_nature_title_uz">Product Nature Uz<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="product_nature_title_uz" name="product_nature_title[uz][]" placeholder="Enter a Product ...">
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="product_nature_title_ru">Product Nature Ru<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="product_nature_title_ru" name="product_nature_title[ru][]" placeholder="Enter a Product ...">
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label for="product_nature_title_en">Product Nature En<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="product_nature_title_en" name="product_nature_title[en][]" placeholder="Enter a Product ...">
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="product_nature_value">Product Nature<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="product_nature_value" name="product_nature_value[]" placeholder="Enter a Product ...">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <button id="add-nature" type="button" class="btn btn-outline-success float-right">Add</button>
                                        </div>

                                    </div>
                                    <button type="submit" class="btn mb-1 btn-outline-success">Create</button>
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
{{--    <script src="{{ asset( 'admin/plugins/jquery/jquery.min.js' ) }}"></script>--}}
{{--    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>--}}
{{--    <script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.js"></script>--}}
{{--    <script src="https://unpkg.com/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.js"></script>--}}
{{--    <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js"></script>--}}
{{--    <script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.min.js"></script>--}}
{{--    <script src="https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.min.js"></script>--}}
{{--    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>--}}
    <script>
        {{--FilePond.registerPlugin(FilePondPluginImagePreview);--}}
        {{--const inputElement = document.querySelector('input[id="product_image"]');--}}
        {{--const pond = FilePond.create( inputElement );--}}

        {{--FilePond.setOptions({--}}
        {{--    server:{--}}
        {{--        url: '/admin/product',--}}
        {{--        process: '/upload',--}}
        {{--        revert: '/delete',--}}
        {{--        headers: {--}}
        {{--            'X-CSRF-TOKEN': '{{ csrf_token() }}'--}}
        {{--        }--}}
        {{--    }--}}

        {{--});--}}

        window.onload = (function() {
            $(".select2").select2({
                multiple: true,
                tags: true,
                tokenSeparators: [',']
            });

            var url = "/admin/category/select/";
            $.get( url, function( data ) {
                var options = "";
                $.each( data, function( key, category) {
                    options+="<option value="+category.category_id+" >"+category.category_name['{{ app()->getLocale() }}']+"</option>";
                });
                $('#categories').html(options);
            });

            $('#add-nature').click(function () {
                $('#nature-area').append('<div class="row">\n' +
                    '                                                <div class="form-group col-md-2">\n' +
                    '                                                    <label for="product_nature_title_uz">Product Nature Uz<span class="text-danger">*</span></label>\n' +
                    '                                                    <input type="text" class="form-control" id="product_nature_title_uz" name="product_nature_title[uz][]" placeholder="Enter a Product ...">\n' +
                    '                                                </div>\n' +
                    '                                                <div class="form-group col-md-2">\n' +
                    '                                                    <label for="product_nature_title_ru">Product Nature Ru<span class="text-danger">*</span></label>\n' +
                    '                                                    <input type="text" class="form-control" id="product_nature_title_ru" name="product_nature_title[ru][]" placeholder="Enter a Product ...">\n' +
                    '                                                </div>\n' +
                    '                                                <div class="form-group col-md-2">\n' +
                    '                                                    <label for="product_nature_title_en">Product Nature En<span class="text-danger">*</span></label>\n' +
                    '                                                    <input type="text" class="form-control" id="product_nature_title_en" name="product_nature_title[en][]" placeholder="Enter a Product ...">\n' +
                    '                                                </div>\n' +
                    '\n' +
                    '                                                <div class="form-group col-md-6">\n' +
                    '                                                    <label for="product_nature_value">Product Nature<span class="text-danger">*</span></label>\n' +
                    '                                                    <input type="text" class="form-control" id="product_nature_value[]" name="product_nature_value[]" placeholder="Enter a Product ...">\n' +
                    '                                                </div>\n' +
                    '                                            </div>')
            })
            $("#submit").click(function() {
                var formData = $("#product-data").serialize();
                console.log(formData)
                $.ajax({
                    url: '/admin/product/create',
                    type: 'POST',
                    data: formData,
                    success: function (data) {
                        if (data.success) {
                            toastr['success'](data.message);
                            $('#product_name').val('');
                            $('#product_model').val('');
                            $('#product_company').val('');
                            $('#product_price').val('');
                            $('#product_name_uz').val('');
                            $('#product_name_ru').val('');
                            $('#product_name_en').val('');
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
