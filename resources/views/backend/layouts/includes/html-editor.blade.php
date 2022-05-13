@push('page-style')
    <link rel="stylesheet" href="{{ asset('plugins/codemirror/codemirror.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('plugins/codemirror/theme/monokai.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}" type="text/css">
@endpush

@push('page-script')
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('plugins/codemirror/codemirror.js') }}"></script>
    <script src="{{ asset('plugins/codemirror/mode/css/css.js') }}"></script>
    <script src="{{ asset('plugins/codemirror/mode/xml/xml.js') }}"></script>
    <script src="{{ asset('plugins/codemirror/mode/htmlmixed/htmlmixed.js') }}"></script>
@endpush