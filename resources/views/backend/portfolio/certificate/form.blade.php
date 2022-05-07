@push('page-style')
    <link rel="stylesheet" href="{{ asset('plugins/codemirror/codemirror.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('plugins/codemirror/theme/monokai.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}" type="text/css">
@endpush

<div class="card-body">
    <div class="row">
        <div class="col-md-6">
            {!! \Form::nText('name', __('common.Name'), old('name', $certificate->name ?? null), true) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nText('organization', __('common.Organization'), old('organization', $certificate->organization ?? null), true) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nDate('issue_date', __('common.Issue Date'), old('issue_date', $certificate->issue_date ?? null), true) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nDate('expire_date', __('common.Expire Date'), old('expire_date', $certificate->expire_date ?? null), false) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nText('credential', __('common.Credential ID'), old('credential', $certificate->credential ?? null), false) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nUrl('verify_url', __('common.Verify URL'), old('verify_url', $certificate->verify_url ?? null), false) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            {!! \Form::nTextarea('description', __('common.Description'), old('description', $certificate->description ?? null), false) !!}
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
            htmlEditor("#description", {
                height: 200,
                codemirror: {
                    lineNumbers: true,
                    theme: 'monokai'
                }
            });

            $("#certificate-form").validate({
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
