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
                            <h4 class="card-title">Create User</h4>
                            <div class="basic-form mt-4">
                                <form action="/user/create" method="post" id="admin-data" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="user_image">User Image <span class="text-danger">*</span></label>
                                            <input type="file" name="user_image" id="user_image" class="form-control-file">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="user_name">User Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Enter a User Name...">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="user_phone">User Phone <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="user_phone" name="user_phone" placeholder="Enter a User Phone...">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="user_password">User Password <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="user_password" name="user_password" placeholder="Enter a User Password...">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="user_password_confirmation">User Password Confirmation <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="user_password_confirmation" name="user_password_confirmation" placeholder="Enter a User Confirmation Password...">
                                        </div>
                                    </div>
                                    <button type="submit" id="submit" class="btn mb-1 btn-outline-success">Create</button>
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
        const inputElement = document.querySelector('input[id="user_image"]');
        const pond = FilePond.create(inputElement, {
            labelIdle: `<i class="fa fa-plus-circle"> Upload Image</i>`,
        });
        FilePond.setOptions({
            server: {
                url: '/admin/user/upload',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            }
        });
    </script>
    <script>

        $(document).ready(function() {
            $("#admin-data").on('submit', function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    url: '/admin/user/create',
                    method: 'POST',
                    data: formData,
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        if (data.success) {
                            toastr['success'](data.message);
                            $('#user_image').val('');
                            $('#user_name').val('');
                            $('#user_phone').val('');
                            $('#user_password').val('');
                            $('#user_password_confirmation').val('');
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
