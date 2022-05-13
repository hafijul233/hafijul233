@extends('backend.layouts.master')

@push('meta')

@endpush

@push('icon')

@endpush

@push('plugin-style')
    <!-- Bootstrap Toggle -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap4-toggle/css/bootstrap4-toggle.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
@endpush

@push('theme-style')
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/css/adminlte.min.css') }}">
    <!-- Custom style -->
    <link rel="stylesheet" href="{{ asset('assets/css/utility.css') }}">
@endpush

{{--@section('body-class', 'layout-fixed layout-navbar-fixed  sidebar-collapse')--}}

@section('body')
    <body class="sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Preloader -->
    @include('backend.layouts.includes.preloader')
    <!-- Navbar -->
    @include('backend.layouts.partials.navbar')

    <!-- Main Sidebar Container -->
    @include('backend.layouts.partials.menu-sidebar')

    <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
        @include('backend.layouts.partials.content-header')
        <!-- Main content -->
            <section class="content">
                @include('backend.layouts.includes.errors')
                @yield('content')
            </section>
            <!-- /.content -->
            <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
                <i class="fas fa-chevron-up"></i>
            </a>
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
    @include('backend.layouts.partials.control-sidebar')
    <!-- Main Footer -->
        @include('backend.layouts.partials.main-footer')
    </div>
    <!-- ./wrapper -->

    @include('backend.layouts.includes.js-constants')

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Plugin JS -->
    @include('backend.layouts.includes.plugin-script')
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('assets/js/utility.min.js') }}"></script>
    <!-- inline js -->
    @include('backend.layouts.includes.page-script')
@endsection
