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
        <!-- row -->

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Create Blog</h4>
                            <div class="basic-form mt-4">
                                <form id="blog-data" class="form-valide" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="blog_image">Blog Image <span class="text-danger">*</span></label>
                                            <input type="file" id="blog_image" name="blog_image">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="blog_title_uz">Blog title Uz <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="blog_title_uz" name="blog_title[uz]" placeholder="Enter a Blog Title...">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="blog_title_ru">Blog title Ru <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="blog_title_ru" name="blog_title[ru]" placeholder="Enter a Blog Title...">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="blog_title_uz">Blog title En <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="blog_title_en" name="blog_title[en]" placeholder="Enter a Blog Title...">
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Tags</label>
                                                <select name="blog_tags[]" class="form-control select2" multiple="multiple"></select>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="blog_body_uz">Blog Body Uz <span class="text-danger">*</span></label>
                                            <textarea class="form-control h-150px" rows="6" name="blog_body[uz]" id="blog_body_uz"></textarea>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="blog_body_ru">Blog Body Ru <span class="text-danger">*</span></label>
                                            <textarea class="form-control h-150px" rows="6" name="blog_body[ru]" id="blog_body_ru"></textarea>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="blog_body_en">Blog Body En <span class="text-danger">*</span></label>
                                            <textarea class="form-control h-150px" rows="6" name="blog_body[en]" id="blog_body_en"></textarea>
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
        const inputElement = document.querySelector('input[id="blog_image"]');
        const pond = FilePond.create(inputElement, {
            labelIdle: `<i class="fa fa-plus-circle"> Upload Image</i>`,
        });
        FilePond.setOptions({
            server: {
                url: '/admin/blog/upload',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            }
        });
    </script>

    <script>

        $(document).ready(function() {
            $(".select2").select2({
                multiple: true,
                tags: true,
                tokenSeparators: [',']
            });
            $("#submit").click(function() {
                var formData = $("#blog-data").serialize();
                console.log(formData)
                $.ajax({
                    url: '/admin/blog/create',
                    type: 'POST',
                    data: formData,
                    success: function (data) {
                        if (data.success) {
                            toastr['success'](data.message);
                            $('#blog_title_uz').val('');
                            $('#blog_title_ru').val('');
                            $('#blog_title_en').val('');
                            $('#blog_body_uz').val('');
                            $('#blog_body_ru').val('');
                            $('#blog_body_en').val('');
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
