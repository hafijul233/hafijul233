@extends('layouts.master')

@push('meta')

@endpush

@push('icon')
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
@endpush

@push('plugin-style')
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
@endpush

@push('theme-style')
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/css/adminlte.min.css') }}">
@endpush

@section('body-class', 'layout-fixed layout-navbar-fixed  sidebar-collapse')

@section('body')
    <body class="hold-transition @yield('body-class')">
    <div class="wrapper">
        <!-- Preloader -->
    @include('layouts.includes.preloader')
    <!-- Navbar -->
    @include('layouts.partials.navbar')

    <!-- Main Sidebar Container -->
    @include('layouts.partials.menu-sidebar')

    <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
        @include('layouts.partials.content-header')
        <!-- Main content -->
            <section class="content">

                <div class="error-page">
                    <h2 class="headline text-@yield('text-color', 'danger')">@yield('code')</h2>

                    <div class="error-content pt-3">
                        <h3>
                            <i class="fas fa-exclamation-triangle text-@yield('text-color', 'danger')"></i> @yield('message')
                        </h3>

{{--                        <p>
                            We could not find the page you were looking for.
                            Meanwhile, you may <a href="../../index.html">return to dashboard</a> or try using the search
                            form.
                        </p>--}}

                        {!! \Form::open(['link' => '#', 'method' => 'get', 'class' => 'search-form']) !!}
                        <div class="input-group">
                            {!! \Form::search('search', \request()->query('search'),
                                    ['class' => 'form-control', 'id' => 'search-from',
                                    'placeholder' => 'Type you search ...']) !!}
                            <div class="input-group-append">
                                <button type="submit" name="submit" class="btn btn-warning">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.input-group -->
                        {!! \Form::close() !!}
                    </div>
                    <!-- /.error-content -->
                </div>
                <!-- /.error-page -->
                @yield('content')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
    @include('layouts.partials.control-sidebar')
    <!-- Main Footer -->
        @include('layouts.partials.main-footer')
    </div>
    <!-- ./wrapper -->

    @include('layouts.includes.js-constants')

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Plugin JS -->
    @include('layouts.includes.plugin-script')
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('assets/js/utility.min.js') }}"></script>
    <!-- inline js -->
    @include('layouts.includes.page-script')
    @endsection