@extends('theme.rasalina.master')

@push('meta')

@endpush

@push('icon')

@endpush

@push('plugin-style')
    <link rel="stylesheet" href="{{ asset('theme/rasalina/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/rasalina/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/rasalina/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('theme/rasalina/css/slick.css') }}">
@endpush

@push('theme-style')
    <link rel="stylesheet" href="{{ asset('theme/rasalina/css/style.css') }}">
@endpush

@section('body')
    <body>
    <!-- preloader-start -->
    @include('theme.rasalina.includes.preloader')
    <!-- preloader-end -->

    <!-- Scroll-top -->
    @include('theme.rasalina.includes.scroll-top')
    <!-- Scroll-top-end-->

    <!-- header-area -->
    @include('theme.rasalina.partials.header-area')
    <!-- header-area-end -->
    <main>
    @yield('content')
    <!-- contact-area -->
    @include('theme.rasalina.partials.newsletter')
    <!-- contact-area-end -->
    </main>

    @include('theme.rasalina.includes.footer')
    <!-- Plugin JS -->
    @include('theme.rasalina.includes.plugin-script')
    <!-- inline js -->
    @include('theme.rasalina.includes.page-script')
    </body>
@endsection
