<div class="card-body">
    <div class="row">
        <div class="col-md-12">
            {!! \Form::nText('name', __('common.Name'), old('name', $skill->name ?? null), true) !!}
        </div>
        <div class="col-md-12">
            {!! \Form::nRange('percentage', __('common.Percentage'), 0, true,['min'  => 0,'max' => 100,'step' => 1]) !!}
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
            $("#skill-form").validate({
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
