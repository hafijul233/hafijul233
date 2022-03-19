<div class="card-body">
    <div class="row">
        <div class="@if(isset($occupation->name)) col-md-6 @else col-md-12 @endif">
            {!! \Form::nText('name', __('common.Name'), old('name', $occupation->name ?? null), true) !!}
        </div>
        @if(isset($occupation->name))
            <div class="col-md-6">
                {!! \Form::nSelect('enabled', __('common.Enabled'), \App\Supports\Constant::ENABLED_OPTIONS,
                    old('enabled', ($occupation->enabled ?? \App\Supports\Constant::ENABLED_OPTION)), true) !!}
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-12">
            {!! \Form::nTextarea('remarks', 'Remarks', old('remarks', $occupation->remarks ?? null), false) !!}
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
    <script>
        $(function () {
            $("#permission-form").validate({
                rules: {
                    display_name: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    name: {
                        required: true,
                        minlength: 3,
                        maxlength: 255,
                        regex: '{{ \App\Supports\Constant::PERMISSION_NAME_ALLOW_CHAR }}',
                    },
                    enabled: {
                        required: true
                    },
                    remarks: {},
                },
                messages: {
                    name: {
                        regex: 'Only Alphanumeric, Hyphen(-), uUnderScope(_), Fullstops(.) Allowed'
                    }
                }
            });
        });
    </script>
@endpush
