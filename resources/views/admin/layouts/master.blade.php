<!DOCTYPE html>
<html lang="en">
<head>
    @include('admin.layouts.head')
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
<div class="wrapper">
@include('admin.layouts.navbar')
<!-- Main Sidebar Container -->
@include('admin.layouts.sidebar')
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h3 class="m-0">@yield('page-title')</h3>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">@yield('breadcrumb')</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div><!-- /.content-header -->
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
            @yield('main')
            <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div><!-- /.content-wrapper -->
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        <div class="p-3">
            <h5>Title</h5>
            <p>Sidebar content</p>
        </div>
    </aside><!-- /.control-sidebar -->
    <!-- Main Footer -->
    @include('admin.layouts.footer')
</div><!-- ./wrapper -->
<!-- REQUIRED SCRIPTS -->
@include('admin.layouts.script')
@yield('custom-script')
</body>
</html>
