//`title`, `type`, `company`, `address`, `start_date`, `end_date`, `description`, `url`, `enabled`

@include('layouts.includes.html-editor')

<div class="card-body">
    <div class="row">
        <div class="col-md-6">
            {!! \Form::nText('title', __('portfolio.certificate.Title'), old('title', $experience->title ?? null), true) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nText('organization', __('portfolio.certificate.Organization'), old('organization', $experience->organization ?? null), true) !!}
        </div>
        <div class="col-md-12">
            {!! \Form::nText('address', __('portfolio.certificate.Title'), old('address', $experience->address ?? null), true) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nDate('issue_date', __('portfolio.certificate.Issue Date'), old('issue_date', $experience->issue_date ?? null), true) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nDate('expire_date', __('portfolio.certificate.Expire Date'), old('expire_date', $experience->expire_date ?? null), false) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nText('credential', __('portfolio.certificate.Credential ID'), old('credential', $experience->credential ?? null), false) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nUrl('verify_url', __('portfolio.certificate.Verify URL'), old('verify_url', $experience->verify_url ?? null), false) !!}
        </div>
        <div class="col-12">
            {!! \Form::nTextarea('description', __('common.Description'), old('description', $experience->description ?? null), false) !!}
        </div>
        <div class="col-md-12">
            {!! \Form::nImage('image',__('common.Image'), false,
                ['preview' => true, 'height' => '240',
                 'default' => (isset($experience))
                 ? $experience->getFirstMediaUrl('services')
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
    <script>
        $(function () {
            htmlEditor("#description", {height: 200});

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
