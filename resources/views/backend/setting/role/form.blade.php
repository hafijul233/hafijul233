<div class="card-body">
    <div class="row">
        <div class="col-md-4">
            {!! \Form::nText('name', __('common.Name'), old('name', $role->name ?? null), true) !!}
        </div>
        <div class="col-md-4">
            {!! \Form::nSelect('guard_name', 'Guard', config('backend.guard'), old('guard_name', $role->guard_name ?? \App\Supports\Constant::PERMISSION_GUARD)) !!}
        </div>
        <div class="col-md-4">
            {!! \Form::nSelect('enabled', __('common.Enabled'), \App\Supports\Constant::ENABLED_OPTIONS,
                old('enabled', ($role->enabled ?? \App\Supports\Constant::ENABLED_OPTION))) !!}
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            {!! \Form::nTextarea('remarks', 'Remarks', old('remarks', $role->remarks ?? null)) !!}
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
        $(document).ready(function () {
            $("#role-form").validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 3,
                        maxlength: 255
                    },
                    guard_name: {
                        required: true
                    },
                    enabled: {
                        required: true
                    },
                    remarks: {
                        minlength: 3,
                        maxlength: 255
                    },
                }
            });
        });
    </script>
@endpush
