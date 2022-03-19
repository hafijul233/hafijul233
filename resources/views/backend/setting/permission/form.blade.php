<div class="card-body">
    <div class="row">
        <div class="col-md-4">
            {!! \Form::nText('display_name', 'Display Name', old('display_name', $permission->display_name ?? null), true) !!}
        </div>
        <div class="col-md-4">
            {!! \Form::nText('name', __('common.Name'), old('name', $permission->name ?? null), true ,[
            'pattern' => \App\Supports\Constant::PERMISSION_NAME_ALLOW_CHAR,
             'onkeyup' => 'this.value = this.value.replace(/\s+/g, \'-\').toLowerCase()',
             'title' => 'Only Alphanumeric, Hyphen(-), UnderScope(_), Fullstops(.) Allowed'
             ]) !!}
        </div>
        <div class="col-md-4">
            {!! \Form::nSelect('enabled', __('common.Enabled'), \App\Supports\Constant::ENABLED_OPTIONS,
                old('enabled', ($permission->enabled ?? \App\Supports\Constant::ENABLED_OPTION)), true) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            {!! \Form::nTextarea('remarks', __('common.Remarks'), old('remarks', $permission->remarks ?? null), false) !!}
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
                        regex:'{{ \App\Supports\Constant::PERMISSION_NAME_ALLOW_CHAR }}',
                    },
                    enabled: {
                        required: true
                    },
                    remarks: {
                    },
                },
                messages : {
                    name : {
                        regex : 'Only Alphanumeric, Hyphen(-), uUnderScope(_), Fullstops(.) Allowed'
                    }
                }
            });
        });
    </script>
@endpush
