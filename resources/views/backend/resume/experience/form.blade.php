@include('backend.layouts.includes.html-editor')

<div class="card-body">
    <div class="row">
        <div class="col-md-6">
            {!! \Form::nText('title', __('resume.experience.Title'), old('title', $experience->title ?? null), true) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nSelect('type', __('resume.experience.Type'), \App\Supports\Constant::EMPLOYEEMENT_TYPE, old('type', $experience->type ?? null), false) !!}
        </div>
        <div class="col-md-12">
            {!! \Form::nText('organization', __('resume.experience.Organization'), old('organization', $experience->organization ?? null), true) !!}
        </div>
        <div class="col-md-12">
            {!! \Form::nText('address', __('resume.experience.Address'), old('address', $experience->address ?? null), true) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nDate('start_date', __('resume.experience.Start Date'), old('start_date', $experience->start_date ?? null), true) !!}
        </div>
        <div class="col-md-6">
            {!! \Form::nDate('end_date', __('resume.experience.End Date'), old('end_date', $experience->end_date ?? null), false) !!}
        </div>
{{--        <div class="col-md-6">
            {!! \Form::nUrl('url', __('resume.experience.URL'), old('url', $experience->url ?? null), false) !!}
        </div>--}}
        <div class="col-12">
            {!! \Form::nTextarea('description', __('common.Description'), old('description', $experience->description ?? null), false) !!}
        </div>
        {{--<div class="col-md-12">
            {!! \Form::nImage('image',__('common.Image'), false,
                ['preview' => true, 'height' => '240',
                 'default' => (isset($experience))
                 ? $experience->getFirstMediaUrl('services')
                 : asset(\App\Supports\Constant::SERVICE_IMAGE)]) !!}
        </div>--}}
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
