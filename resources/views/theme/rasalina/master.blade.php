<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- meta Tags -->
    @include('theme.rasalina.includes.meta')
    <title>@yield('title', config('app.name', 'Laravel'))</title>
    <!-- Web Font-->
    @include('theme.rasalina.includes.webfont')
    <!-- Icon -->
    @include('theme.rasalina.includes.icon')
<!-- Plugins -->
    @include('theme.rasalina.includes.plugin-style')
<!-- Theme style -->
    @include('theme.rasalina.includes.theme-style')
<!-- Page Level Style -->
    @include('theme.rasalina.includes.page-style')
</head>
@yield('body')
</html>