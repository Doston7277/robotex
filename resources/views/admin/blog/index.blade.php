@extends('admin.layout.layout')

@section('content')
    <div class="content-body">
        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('admin.subject') }}">Users</a></li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Blog Table</h4>
                            <div class="table-responsive">
                                <table id="dataBlog" class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Id</th>
                                        <th>Title</th>
                                        <th>Body</th>
                                        <th>Tags</th>
                                        <th>Author</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Image</th>
                                        <th>Id</th>
                                        <th>Title</th>
                                        <th>Body</th>
                                        <th>Tags</th>
                                        <th>Author</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                </table>

                                <div class="modal fade" id="update" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Blog update</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form id="blog-form">
                                                    @csrf
                                                    <div class="form-row">
                                                        <input type="hidden" name="blog_id" id="blog_id">
                                                        <div class="form-group col-md-6">
                                                            <label for="blog_title_uz">Blog Title Uz <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="blog_title_uz" name="blog_title[uz]" placeholder="Enter a Blog Title...">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="blog_title_ru">Blog Title Ru <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="blog_title_ru" name="blog_title[ru]" placeholder="Enter a Blog Title...">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="blog_title_en">Blog Title En <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="blog_title_en" name="blog_title[en]" placeholder="Enter a Blog Title...">
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
            $(".select2").select2({
                multiple: true,
                tags: true,
                tokenSeparators: [',']
            });

            table = $('#dataBlog').DataTable({
                // language: {
                //     url: '//cdn.datatables.net/plug-ins/1.11.2/i18n/uz.json'
                // },
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/admin/blog/datatable",
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
                    {data: 'id', name: 'blog_id'},
                    {data: 'title', name: 'blog_title'},
                    {data: 'body', name: 'blog_body'},
                    {data: 'tags', name: 'blog_tags'},
                    {data: 'author', name: 'user.user_name'},
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $("#submit").click(function() {
                var formData = $("#blog-form").serialize();
                $.ajax({
                    url: '{{ route('admin.blog-update') }}',
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

        function deleted(blog_id) {
            $(document).ready(function(){
                $.ajax({
                    url: '/admin/blog/delete/'+blog_id,
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

        function updated(blog_id) {
            $.get( '/admin/blog/update/'+blog_id, function( data ) {

                $('#blog_title_uz').val(data.blog_title['uz']);
                $('#blog_title_ru').val(data.blog_title['ru']);
                $('#blog_title_en').val(data.blog_title['en']);
                $('#blog_body_uz').val(data.blog_body['uz']);
                $('#blog_body_ru').val(data.blog_body['ru']);
                $('#blog_body_en').val(data.blog_body['en']);
                $('#blog_id').val(data.blog_id);
            });
        }

    </script>

@endsection
