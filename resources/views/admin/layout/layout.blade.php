<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Robo</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset( 'admin/images/favicon.png' ) }}">
    <!-- Custom Stylesheet -->
    <link href="{{ asset( 'admin/css/style.css' ) }}" rel="stylesheet">
    <link href="{{ asset( 'admin/plugins/tables/css/datatable/dataTables.bootstrap4.min.css' ) }}" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
    @yield('css')
</head>

<body>
<div id="preloader">
    <div class="loader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
        </svg>
    </div>
</div>
<div id="main-wrapper">

    <div class="nav-header">
        <div class="brand-logo">
            <a href="{{ route('home') }}">
                <b class="logo-abbr"><img src="{{ asset( 'admin/images/logo.png' ) }}" alt=""> </b>
                <span class="logo-compact"><img src="{{ asset( 'admin/images/logo-compact.png' ) }}" alt=""></span>
                <span class="brand-title">
                    <img src="{{ asset( 'admin/images/logo-text.png' ) }}" width="160" alt="">
                </span>
            </a>
        </div>
    </div>
    <div class="header">
        <div class="header-content clearfix">

            <div class="nav-control">
                <div class="hamburger">
                    <span class="toggle-icon"><i class="icon-menu"></i></span>
                </div>
            </div>
        </div>
    </div>
    <div class="nk-sidebar">
        <div class="nk-nav-scroll">
            <ul class="metismenu" id="menu">
                <li class="nav-label">Dashboard</li>
                <li>
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.orders') }}" aria-expanded="false">
                        <i class="fa fa-first-order menu-icon"></i> <span class="nav-text">Order</span>
                    </a>
                </li>
                <li>
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <i class="fa fa-user-o menu-icon"></i> <span class="nav-text">Users </span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('admin.users') }}">Users</a></li>
                        <li><a href="{{ route('admin.user-create') }}">Create</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <i class="icon-user menu-icon"></i> <span class="nav-text">Admin</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('admin.admin') }}">Admin</a></li>
                        <li><a href="{{ route('admin.admin-create') }}">Create</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <i class="icon-grid menu-icon"></i> <span class="nav-text">Category</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('admin.category') }}">Category</a></li>
                        <li><a href="{{ route('admin.category-create') }}">Create</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <i class="icon-screen-tablet menu-icon"></i> <span class="nav-text">Product</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('admin.product') }}">Product</a></li>
                        <li><a href="{{ route('admin.product-create') }}">Create</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                        <i class="icon-book-open menu-icon"></i> <span class="nav-text">Blog</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('admin.blog') }}">Blog</a></li>
                        <li><a href="{{ route('admin.blog-create') }}">Create</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('logout') }}" aria-expanded="false">
                        <i class="icon-logout menu-icon"></i> <span class="nav-text">Blog</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    @yield('content')
    <div class="footer">
        <div class="copyright">
            <p>Copyright &copy; Designed & Developed by Dostonbek</a> 2022</p>
        </div>
    </div>
</div>

@yield('js')

<script src="{{ asset( 'admin/plugins/common/common.min.js' ) }}"></script>
<script src="{{ asset( 'admin/js/custom.min.js' ) }}"></script>
<script src="{{ asset( 'admin/js/settings.js' ) }}"></script>
<script src="{{ asset( 'admin/js/gleek.js' ) }}"></script>
<script src="{{ asset( 'admin/js/styleSwitcher.js' ) }}"></script>
<script src="{{ asset( 'admin/plugins/jquery/jquery.min.js' ) }}"></script>
<script src="{{ asset( 'admin/plugins/bootstrap/js/bootstrap.bundle.min.js' ) }}"></script>
<!-- Datatable -->
<script src="{{ asset( 'admin/plugins/tables/js/jquery.dataTables.min.js' ) }}"></script>
<script src="{{ asset( 'admin/plugins/tables/js/datatable/dataTables.bootstrap4.min.js' ) }}"></script>
<script src="{{ asset( 'admin/plugins/tables/js/datatable-init/datatable-basic.min.js' ) }}"></script>
<!-- Toastr -->
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>

    (function() {
        "use strict"
        new quixSettings({
            sidebarPosition: "fixed",
            headerPosition: "fixed"
        });
    })(jQuery);

    @if(Session::has('message'))
    toastr.success("{{ session('message') }}");
    @endif

    @if(Session::has('error'))
    toastr.error("{{ session('error') }}");
    @endif

</script>

</body>
</html>
