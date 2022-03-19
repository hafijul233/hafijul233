<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ config('app.name', 'Laravel') }} | @yield('title')</title>
    <!-- meta Tags -->
@include('layouts.includes.meta')
<!-- Web Font-->
@include('layouts.includes.webfont')
<!-- Icon -->
@include('layouts.includes.icon')
<!-- Plugins -->
@include('layouts.includes.plugin-style')
<!-- Theme style -->
@include('layouts.includes.theme-style')
<!-- Page Level Style -->
    @include('layouts.includes.page-style')
</head>
@yield('body')
</html>
