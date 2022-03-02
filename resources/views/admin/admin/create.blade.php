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
                            <h4 class="card-title">Create Admin</h4>
                            <div class="basic-form mt-4">
                                <form action="/admin/admin/create" method="post" id="admin-data" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="admin_image">Admin Image <span class="text-danger">*</span></label>
                                            <input type="file" name="admin_image" id="admin_image" class="form-control-file">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="admin_name">Admin name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="admin_name" name="admin_name" placeholder="Enter a Admin Name...">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="admin_phone">Admin phone <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="admin_phone" name="admin_phone" placeholder="Enter a Admin Phone...">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="admin_password">Admin Password <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="admin_password" name="admin_password" placeholder="Enter a Admin Password...">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="admin_password_confirmation">Admin Password Confirmation <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="admin_password_confirmation" name="admin_password_confirmation" placeholder="Enter a Admin Password...">
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
        const inputElement = document.querySelector('input[id="admin_image"]');
        const pond = FilePond.create(inputElement, {
            labelIdle: `<i class="fa fa-plus-circle"> Upload Image</i>`,
        });
        FilePond.setOptions({
            server: {
                url: '/admin/admin/upload',
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
                    url: '/admin/admin/create',
                    method: 'POST',
                    data: formData,
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        if (data.success) {
                            toastr['success'](data.message);
                            $('#admin_image').val('');
                            $('#admin_name').val('');
                            $('#admin_phone').val('');
                            $('#admin_password').val('');
                            $('#admin_password_confirmation').val('');
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
