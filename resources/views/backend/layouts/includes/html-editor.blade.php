@push('plugin-style')
    <link rel="stylesheet" href="{{ asset('plugins/codemirror/codemirror.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('plugins/codemirror/theme/monokai.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}" type="text/css">
@endpush

@push('page-style')
    <style>
        .note-toolbar {
            background-color: transparent !important;
            border-bottom: 0px solid !important;
        }

        .note-statusbar {
            background-color: transparent !important;
            border-top: 0px solid !important;
        }

        .note-editor {
            box-shadow: inset 0 0 0 transparent !important;
        }
    </style>
@endpush

@push('page-script')
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('plugins/codemirror/codemirror.js') }}"></script>
    <script src="{{ asset('plugins/codemirror/mode/css/css.js') }}"></script>
    <script src="{{ asset('plugins/codemirror/mode/xml/xml.js') }}"></script>
    <script src="{{ asset('plugins/codemirror/mode/htmlmixed/htmlmixed.js') }}"></script>
@endpush