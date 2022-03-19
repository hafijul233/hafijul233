@extends('layouts.master')

@push('meta')

@endpush

@push('icon')
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
@endpush

@push('plugin-style')
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endpush

@push('theme-style')
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/css/adminlte.min.css') }}">
@endpush

@section('body')
    <body class="hold-transition @yield('body-class')">

    @include('layouts.includes.preloader')

    @yield('content')

    @include('layouts.includes.footer')
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Plugin JS -->
    @include('layouts.includes.plugin-script')
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/js/adminlte.min.js') }}"></script>
    <!-- inline js -->
    @include('layouts.includes.page-script')
    </body>
@endsection
