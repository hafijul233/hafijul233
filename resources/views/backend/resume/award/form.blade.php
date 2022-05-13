@include('layouts.includes.html-editor')

<div class="card-body">
    <div class="row">
        <div class="col-md-12">
            {!! \Form::nText('title', __('resume.award.Title'), old('title', $award->title ?? null), true) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nText('associate', __('resume.award.Associate'), old('associate', $award->associate ?? null), false) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nText('issuer', __('resume.award.Issuer'), old('issuer', $award->issuer ?? null), true) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nDate('issue_date', __('resume.award.Issue Date'), old('issue_date', $award->issue_date ?? null), true) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nUrl('url', __('resume.award.URL'), old('url', $award->url ?? null), false) !!}
        </div>
        <div class="col-12">
            {!! \Form::nTextarea('description', __('common.Description'), old('description', $award->description ?? null), false) !!}
        </div>
        <div class="col-md-12">
            {!! \Form::nImage('image',__('common.Image'), false,
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
    <script>
        $(function () {
            htmlEditor("#description", {height: 200});

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
