@push('page-style')
    <link rel="stylesheet" href="{{ asset('plugins/codemirror/codemirror.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('plugins/codemirror/theme/monokai.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}" type="text/css">
@endpush

<div class="card-body">
    <div class="row">
        <div class="col-md-12">
            {!! \Form::nText('name', __('common.Name'), old('name', $service->name ?? null), true) !!}
        </div>
        <div class="col-md-12">
            {!! \Form::nTextarea('summary', __('common.Summary'), old('summary', $service->summary ?? null), true, ['rows' => 3]) !!}
        </div>
        <div class="col-md-12">
            {!! \Form::nTextarea('description', __('common.Description'), old('description', $service->description ?? null), false, ['rows' => 10]) !!}
        </div>
        <div class="col-md-12">
            {!! \Form::nImage('image', 'Image', false,
                ['preview' => true, 'height' => '240',
                 'default' => (isset($service))
                 ? $service->getFirstMediaUrl('services')
                 : asset(\App\Supports\Constant::SERVICE_IMAGE)]) !!}
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12 justify-content-between d-flex">
            {!! \Form::nCancel(__('common.Cancel')) !!}
            {!! \Form::nSubmit('submit', __('common.Save')) !!}
        </div>
    </div>
</div>


@push('page-script')
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('plugins/codemirror/codemirror.js') }}"></script>
    <script src="{{ asset('plugins/codemirror/mode/css/css.js') }}"></script>
    <script src="{{ asset('plugins/codemirror/mode/xml/xml.js') }}"></script>
    <script src="{{ asset('plugins/codemirror/mode/htmlmixed/htmlmixed.js') }}"></script>
    <script>
        $(function () {
            htmlEditor("#summary", {height: 100});

            htmlEditor("#description", {height: 400});

            $("#service-form").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    enabled: {
                        required: true
                    },
                    remarks: {},
                }
            });
        });
    </script>
@endpush
