<div class="card-body">
    <div class="row">
        <div class="col-md-12">
            {!! \Form::nText('client', __('portfolio.testimonial.Client'), old('client', $testimonial->client ?? null), true) !!}
        </div>
        <div class="col-md-12">
            {!! \Form::nTextarea('feedback', __('portfolio.testimonial.Feedback'), old('feedback', $testimonial->feedback ?? null), true) !!}
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
                    remarks: {
                    },
                }
            });
        });
    </script>
@endpush
