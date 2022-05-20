<div class="card-body">
    <div class="row">
        <div class="col-md-6">
            {!! \Form::nText('name', __('common.Name'), old('name', $newsLetter->name ?? null), true) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nEmail('email', __('common.Email'), old('email', $newsLetter->email ?? null), true) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nTel('mobile', __('common.Mobile'), old('mobile', $newsLetter->mobile ?? null), true) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nUrl('website', __('common.Website'), old('website', $newsLetter->website ?? null), true) !!}
        </div>
        <div class="col-md-12">
            {!! \Form::nTextarea('message', __('common.Message'), old('message', $newsLetter->message ?? null), true, ['rows' => 10]) !!}
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
            $("#newsletter-form").validate({
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
