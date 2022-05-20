<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ config('app.name', 'Laravel') }} | @yield('title')</title>
    <!-- meta Tags -->
@include('backend.layouts.includes.meta')
<!-- Web Font-->
@include('backend.layouts.includes.webfont')
<!-- Icon -->
@include('backend.layouts.includes.icon')
<!-- Plugins -->
@include('backend.layouts.includes.plugin-style')
<!-- Theme style -->
@include('backend.layouts.includes.theme-style')
<!-- Page Level Style -->
    @include('backend.layouts.includes.page-style')
</head>
@yield('body')
</html>
