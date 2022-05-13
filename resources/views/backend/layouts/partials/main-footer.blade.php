<footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
        Version:{{ config('backend.version') }}
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; {{ date('Y') }} <a href="{{ url('/') }}">{{ config('backend.copyright') }}</a>.</strong> All rights
    reserved.
</footer>
